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

class Librarian_Chapter{
    public $ID;
    public $title;
    public $modified_date;

    public function __construct( $ID, $title, $modified_date ) {
        $this->ID = $ID;
        $this->title = $title;
        $this->modified_date = $modified_date;
    }
}