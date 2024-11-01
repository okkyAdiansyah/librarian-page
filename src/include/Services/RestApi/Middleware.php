<?php
/**
 * REST API middleware
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Services\RestApi\Librarian_Chapter;

class Middleware{
    /**
     * Get 3 child post
     * 
     * @param array $query_args Child post query args
     * 
     * @return array
     */
    public static function librarian_get_init_child_post( $query_args ){
        $child_query = new \WP_Query( $query_args );

        // Bail out if parent doesn't have child post
        if( ! $child_query->have_posts(  ) ){
            return null;
        }

        $child_posts = array(  );

        if( $child_query->have_posts(  ) ){
            while( $child_query->have_posts(  ) ){
                $child_query->the_post(  );

                $post = new Librarian_Chapter(
                    get_the_ID(  ),
                    get_the_title(  ),
                    get_the_modified_date( 'd-m-Y H:i:s' )
                );

                $child_posts[] = $post;
            }
        }

        wp_reset_postdata(  );

        return $child_posts;
    }
}