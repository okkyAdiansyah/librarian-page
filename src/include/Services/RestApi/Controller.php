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

use Librarian\Services\RestApi\Middleware;
use Librarian\Services\RestApi\Librarian_Collection;


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
            'post_type'     => 'collection',
            'posts_per_page' => $posts_per_page,
            'paged'         => $page,
            'orderby'       => 'modified',
            'order'         => 'DESC'
        );

        // Save parent post query
        $main_query = new \WP_Query($query_args);

        // Bail out if parent doesn't have posts
        if( ! $main_query->have_posts(  ) ){
            return new \WP_REST_Response( array(
                'message' => 'No Post Found'
            ), 404 );
        }

        $posts_data = array(  );
        
        if( $main_query->have_posts(  ) ){
            while( $main_query->have_posts(  ) ){
                $main_query->the_post(  );
    
                $child_query_args = array(
                    'post_type'     => 'chapter',
                    'post_per_page' => 3,
                    'post_parent'   => get_the_ID(  ),
                    'orderby'       => 'modified',
                    'order'         => 'DESC'
                );

                $child_posts = Middleware::librarian_get_init_child_post( $child_query_args );

                $post = new Librarian_Collection(
                    get_the_ID(  ),
                    get_the_title(  ),
                    get_the_modified_date( 'd-m-y H:i:s' ),
                    $child_posts
                );

                $posts_data[] = $post;
            }
        }

        wp_reset_postdata(  );

        return new \WP_REST_Response( $posts_data, 200 );
    }
}