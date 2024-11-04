<?php
/**
 * Plugin main admin
 * 
 * @uses Librarian\Utils\SettingUtils Used for rendering admin part
 * 
 * @package Librarian
 */
namespace Librarian\Admin\MainAdmin;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;

class MainAdmin{
    /**
     * Init all method within
     * 
     * @return void
     */
    public function librarian_init(){
        add_action( 'admin_menu', array( $this, 'librarian_register_menu' ), 10 );
    }

    /**
     * Register main admin
     * 
     * @return void
     */
    public function librarian_register_menu(){
        add_menu_page( 
            'Librarian', 
            'Librarian', 
            'manage_options',
            'librarian', 
            array( $this, 'librarian_admin_renderer' ),
            plugin_dir_url( dirname( __DIR__, 3 ) ) . 'asset/bookshelf.png', 
            30
        );
    }

    /**
     * Main admin renderer
     * 
     * @return void
     */
    public function librarian_admin_renderer(){
        /**
         * @see Librarian\Utils\SettingUtils librarian_admin_view_template_utils()
         */
        SettingUtils::librarian_admin_view_template_utils( 'main-view.php' );
    }
}