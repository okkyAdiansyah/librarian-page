<?php
/**
 * API setting and option
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi\Setting;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class ApiSetting{
    public function __construct() {
        add_action( 'admin_init', array( $this, 'librarian_init' ), 10 );
    }

    /**
     * Register API option
     */
    public function librarian_init(){
        $options = array(
            "api_key"             => "LIBRARIANAPICOREKEY",
            "api_route_namespace" => "librarian/v1/"
        );

        add_option( 'librarian_api', $options );
    }
}