<?php
/**
 * Collection post type
 * 
 * @package Librarian
 */
namespace Librarian\CustomPostType;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\CustomPostType\AbstractPostType;

class CollectionPostType{
    
    public $labels;
    public $args;

    public function __construct(){
        $this->labels = array(
            'name'               => __( 'Collections', 'librarian' ),
            'singular_name'      => __( 'Collection', 'librarian' )  
        );

        $this->args = array(
            'labels'             => $this->labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['title', 'thumbnail', 'author', 'excerpt'],
            'menu_icon'          => 'dashicons-book',
            'show_in_rest'       => true
        );
    }
    
    /**
     * Register collection post type
     */
    public function librarian_register_post_type(){
        $cpt_args = array(
            "slug"           => 'collection',
            "post_type_args" => $this->args
        );

        $abstract_cpt = new AbstractPostType( $cpt_args );
        $abstract_cpt->librarian_register_post_type();
    }
}