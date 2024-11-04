<?php
/**
 * Librarian response batch archive post
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi\Response;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class Librarian_Batch_Archive{
    public $page;
    public $has_more;
    public $posts;

    public function __construct( $page, $has_more, $posts ) {
        $this->page = $page;
        $this->has_more = $has_more;
        $this->posts = $posts;
    }
}