<?php
/**
 * Main admin
 * 
 * @package Librarian
 */
namespace Librarian\View;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use WP_Query;
use Librarian\Services\RestApi\Setting\ApiSetting;

class Admin{

    public $options;
    public $settings;

    public function __construct() {
        $this->options = LIBRARIAN_OPTION();
        $this->settings = array(
            "api" => new ApiSetting()
        );

        foreach ($this->settings as $setting) {
            $setting->librarian_init();
        }
    }

    /**
     * Class init
     * 
     * @return void
     */
    public function librarian_init(){
        add_action( 'admin_menu', array( $this, 'librarian_main_admin' ), 10 );
    }
    
    /**
     * Main plugin admin
     * 
     * @return void
     */
    public function librarian_main_admin(){
        add_menu_page( 
            'Librarian', 
            'Librarian', 
            'manage_options',
            'librarian', 
            array( $this, 'librarian_main_admin_renderer' ),
            plugin_dir_url( dirname( __DIR__, 2 ) ) . 'asset/bookshelf.png', 
            30
        );
    }

    /**
     * Main admin renderer
     * 
     * @return void
     */
    public function librarian_main_admin_renderer(){
        $args = array(
            'post_type'     => 'chapter',
            'post_per_page' => 3,
            'meta_query'    => array(
                array(
                    'key'     => 'parent_collection',
                    'value'   => 45,
                    'compare' => 'LIKE'
                )
            )
        );
        
        $query = new WP_Query( $args );

        echo "<pre>";
        var_dump( $query );
        echo "</pre>";
    }
}