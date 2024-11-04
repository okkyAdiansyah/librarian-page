<?php
/**
 * Librarian collection object
 * 
 * @package Librarian
 */
namespace Librarian\Services\RestApi\Response;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class Librarian_Collection{
    public $ID;
    public $title;
    public $type;
    public $modified_date;

    public function __construct( $id, $title, $type, $modified_date ){
        $this->ID = $id;
        $this->title = $title;
        $this->type = $type;
        $this->modified_date = $modified_date;
    }
}