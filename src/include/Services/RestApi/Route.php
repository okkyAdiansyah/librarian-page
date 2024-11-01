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

class Route{

    public $controller;

    public function __construct() {
        $this->controller = new Controller();
    }

    /**
     * API Route init
     */
    public function librarian_init(){
        add_action( 'rest_api_init', array( $this, 'librarian_route_get_latest_update_collection' ), 10 );
    }

    /**
     * Route for retrieving latest updated collection and chapter
     */
    public function librarian_route_get_latest_update_collection(){
        register_rest_route( 
            'librarian/v1/', 
            'latest_updated_collection', 
            array(
                'methods' => 'GET',
                'callback' => array( $this->controller, 'librarian_get_latest_updated_book' ),
                'permission_callback' => '__return_true'
            ) 
        );
    }
}