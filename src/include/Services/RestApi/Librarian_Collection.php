<?php
/**
 * Librarian collection object
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class Librarian_Collection{
    public $ID;
    public $title;
    public $modified_date;
    public $child_posts;

    public function __construct( $id, $title, $modified_date, $child_posts ){
        $this->id = $id;
        $this->title = $title;
        $this->modified_date = $modified_date;
        $this->child_posts = $child_posts;
    }
}