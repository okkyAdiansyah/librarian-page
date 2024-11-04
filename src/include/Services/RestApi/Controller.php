<?php
/**
 * RestAPI controller
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use WP_Query;
use WP_REST_Response;
use Librarian\Services\RestApi\Middleware;
use Librarian\Services\RestApi\Response\Librarian_Collection;
use Librarian\Services\RestApi\Response\Librarian_Collection_With_Child;
use Librarian\Services\RestApi\Response\Librarian_Batch_Archive;


class Controller{
    /**
     * Controller to retrieve last updated book collection
     * Together with last updated children
     * 
     * @param WP_REST_Request $request REST request object
     * 
     * @return WP_REST_Response
     */
    public function librarian_get_latest_updated_book( $request ){
        $page = (int) $request->get_param( 'page' ) ?: 1; // Default to page 1
        $posts_per_page = (int) $request->get_param( 'post_per_page' ) ?: 20; // Default to 20
        
        $query_args = array(
            'post_type'      => 'collection',
            'posts_per_page' => $posts_per_page,
            'paged'          => $page,
            'orderby'        => 'modified',
            'order'          => 'DESC'
        );

        // Save parent post query
        $main_query = new WP_Query($query_args);

        // Bail out if parent doesn't have posts
        if( ! $main_query->have_posts(  ) ){
            return new WP_REST_Response( array(
                'message' => 'No Post Found'
            ), 404 );
        }

        $posts_data = array(  );
        
        if( $main_query->have_posts(  ) ){
            while( $main_query->have_posts(  ) ){
                $main_query->the_post(  );

                $collection_id = get_the_ID(  );
                $collection_title = get_the_title(  );
                $collection_type = get_post_type(  );
                $collection_modified_date = get_the_modified_date( 'd-m-y H:i:s' );
    
                $child_query_args = array(
                    'post_type'     => 'chapter',
                    'post_per_page' => 3,
                    'post_parent'   => get_the_ID(  ),
                    'orderby'       => 'modified',
                    'order'         => 'DESC'
                );

                $child_posts = Middleware::librarian_get_init_child_post( $child_query_args );

                $post = new Librarian_Collection_With_Child(
                    $collection_id,
                    $collection_title,
                    $collection_type,
                    $collection_modified_date,
                    $child_posts
                );

                $posts_data[] = $post;
            }
        }

        wp_reset_postdata(  );

        return new WP_REST_Response( $posts_data, 200 );
    }

    /**
     * Controller to retrieve all post in batches
     * 
     * @param WP_REST_Request $request REST request object
     * 
     * @return WP_REST_Response
     */
    public function librarian_get_all_posts_in_batch( $request ){
        $page = (int) $request->get_param( 'batch' ) ?: 1;
        $posts_per_page = (int) $request->get_param( 'posts_per_batch' ) ?: 20;
        $post_type = $request->get_param( 'post_type' );
        $post_parent_id = (int) $request->get_param( 'post_parent' );

        $query_args = array(
            'post_type'      => $post_type,
            'post_parent'    => $post_parent_id,
            'posts_per_page' => $posts_per_page,
            'paged'          => $page,
            'orderby'        => 'modified',
            'order'          => 'DESC'
        );

        $posts_query = new WP_Query( $query_args );

        $posts_data = array();

        if( $posts_query->have_posts(  ) ){
            while( $posts_query->have_posts(  ) ){
                $posts_query->the_post(  );
                $posts_data[] = new Librarian_Collection(
                    get_the_ID(  ),
                    get_the_title(  ),
                    get_post_type(  ),
                    get_the_post_thumbnail_url( )
                );
            }
        } else {
            return new WP_REST_Response( array(
                'message' => 'No Posts Found'
            ), 404 );
        }

        wp_reset_postdata(  );

        $has_more = $posts_query->found_posts > ( $page * $posts_per_page );

        return new WP_REST_Response(
            new Librarian_Batch_Archive( $page, $has_more, $posts_data ),
            200
        );
    }
}