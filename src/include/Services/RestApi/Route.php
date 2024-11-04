<?php
/**
 * RestAPI route
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Services\RestApi\Controller;
use Librarian\Services\RestApi\Middleware;

class Route{

    public $controller;
    public $options;
    public $middleware;

    public function __construct() {
        $this->controller = new Controller();
        $this->options = LIBRARIAN_OPTION();
        $this->middleware = new Middleware;
    }

    /**
     * API route service init
     */
    public function librarian_init(){
        add_action( 'rest_api_init', array( $this, 'librarian_init_route' ), 10 );
    }

    /**
     * Init all API route
     * 
     * @return void
     */
    public function librarian_init_route(){
        $this->librarian_route_get_latest_update_collection();
        $this->librarian_route_get_all_posts_in_batch();
    }

    /**
     * Route for retrieving latest updated collection and chapter
     * 
     * @return void
     */
    public function librarian_route_get_latest_update_collection(){
        $route_namespace = $this->options->librarian_get_option( 'api', 'route_namespace' );

        register_rest_route( 
            $route_namespace, 
            'latest_updated_collection', 
            array(
                'methods'             => 'GET',
                'callback'            => array( $this->controller, 'librarian_get_latest_updated_book' ),
                'permission_callback' => array( $this->middleware, 'librarian_validate_api_key' )
            ) 
        );
    }

    /**
     * Route for retrieving latest updated collection and chapter
     * 
     * @return void
     */
    public function librarian_route_get_all_posts_in_batch(){
        $route_namespace = $this->options->librarian_get_option( 'api', 'route_namespace' );

        register_rest_route( 
            $route_namespace, 
            'all_posts', 
            array(
                'methods'             => 'GET',
                'callback'            => array( $this->controller, 'librarian_get_all_posts_in_batch' ),
                'permission_callback' => array( $this->middleware, 'librarian_validate_api_key' )
            ) 
        );
    }
    
}