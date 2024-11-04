<?php
/**
 * Custom post type for book
 * 
 * @package Librarian
 */
namespace Librarian\CustomPostType;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class AbstractPostType{
    
    public $args;
    
    /**
     * @param array $args Custom post type for registering
     */
    public function __construct( $args ){
        $this->args = $args;
    }
 
    /**
     * Register custom post type
     * 
     * @return void
     */
    public function librarian_register_post_type(){
        register_post_type( $this->args['slug'], $this->args['post_type_args'] );
    }
}