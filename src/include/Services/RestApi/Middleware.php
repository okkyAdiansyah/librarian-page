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

use WP_Query;
use WP_Error;
use Librarian\Services\RestApi\Response\Librarian_Chapter;

class Middleware{

    public $options;

    public function __construct() {
        $this->options = LIBRARIAN_OPTION();
    }
    /**
     * Get 3 child post
     * 
     * @param array $query_args Child post query args
     * 
     * @return array
     */
    public static function librarian_get_init_child_post( $query_args ){
        $child_query = new WP_Query( $query_args );

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

    /**
     * Verified api key
     * 
     * @param WP_REST_Request $request wp request object
     * 
     * @return bool
     */
    public function librarian_validate_api_key( $request ){
        $req_api_key = $request->get_header( 'x-api-key' );

        $valid_api_key = $this->options->librarian_get_option( 'api', 'key' );

        if( $req_api_key && $req_api_key === $valid_api_key ){
            return true;
        }

        // Bail out if api doesn't exist or not the same
        return new WP_Error(
            'rest_forbidden',
            __( 'Invalid API Key', 'librarian' ),
            array( 'status' => 403 )
        );
    }
}