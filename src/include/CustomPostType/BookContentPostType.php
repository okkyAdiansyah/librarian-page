<?php
/**
 * Chapter post type
 * 
 * @package Librarian
 */
namespace Librarian\CustomPostType;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\CustomPostType\AbstractPostType;

class BookContentPostType{

    public $labels;
    public $args;

    public function __construct(){
        $this->labels = array(
            'name'               => __( 'Book Contents', 'librarian' ),
            'singular_name'      => __( 'Book Content', 'librarian' )  
        );

        $this->args = array(
            'labels'             => $this->labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['thumbnail'],
            'menu_icon'          => 'dashicons-text-page',
            'show_in_rest'       => true
        );
    }
    
    /**
     * Register collection post type
     */
    public function librarian_register_post_type(){
        $cpt_args = array(
            "slug"           => 'book-content',
            "post_type_args" => $this->args
        );

        $abstract_cpt = new AbstractPostType( $cpt_args );
        $abstract_cpt->librarian_register_post_type();
    }
}