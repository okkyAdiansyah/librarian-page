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

    public $options;

    public function __construct() {
        $this->options = LIBRARIAN_OPTION();
    }

    /**
     * Register API option
     * 
     * @return void
     */
    public function librarian_init(){
        $options = array(
            "api_key"             => "LIBRARIANAPICOREKEY",
            "api_route_namespace" => "librarian/v1/"
        );
        
        $this->options->librarian_add_option('api', $options);
    }
}