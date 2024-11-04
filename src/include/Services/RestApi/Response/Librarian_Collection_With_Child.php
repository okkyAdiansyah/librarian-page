<?php
/**
 * Response object for collection with child
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi\Response;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class Librarian_Collection_With_Child{
    public $ID;
    public $title;
    public $cover;
    public $modified_date;
    public $child_posts;

    public function __construct( $ID, $title, $cover, $modified_date, $child_posts ) {
        $this->ID = $ID;
        $this->title = $title;
        $this->cover = $cover;
        $this->modified_date = $modified_date;
        $this->child_posts = $child_posts;
    }
}