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

class ChapterPostType{

    public $labels;
    public $args;

    public function __construct(){
        $this->labels = array(
            'name'               => __( 'Chapters', 'librarian' ),
            'singular_name'      => __( 'Chapter', 'librarian' )  
        );

        $this->args = array(
            'labels'             => $this->labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['thumbnail', 'title'],
            'menu_icon'          => 'dashicons-open-folder',
            'show_in_rest'       => true
        );
    }
    
    /**
     * Register collection post type
     */
    public function librarian_register_post_type(){
        $cpt_args = array(
            "slug"           => 'chapter',
            "post_type_args" => $this->args
        );

        $abstract_cpt = new AbstractPostType( $cpt_args );
        $abstract_cpt->librarian_register_post_type();
    }
}