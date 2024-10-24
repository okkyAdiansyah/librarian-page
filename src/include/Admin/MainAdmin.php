<?php
/**
 * Main Plugin Admin
 * 
 * @package Librarian
 */
namespace Librarian\Admin;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;
use Librarian\Admin\SettingAdmin\GeneralSetting;

class MainAdmin {
    /**
     * @var Librarian\Settings[] $settings Array of settings custom page
     */
    private $settings;

    public function __construct() {
        $this->settings = array(
            new GeneralSetting()
        );
    }

    /**
     * Init main admin view
     * 
     * @return void
     */
    public function librarian_init(){
        add_action( 'admin_menu', array( $this, 'librarian_add_plugin_main_dashboard' ), 10 );

        foreach( $this->settings as $setting ){
            $setting->librarian_init();
        }
    }

    /**
     * Main plugin dashboard
     * 
     * @return void
     */
    public function librarian_add_plugin_main_dashboard(){
        add_menu_page( 
            'Librarian', 
            'Librarian', 
            'manage_options',
            'librarian', 
            array( $this, 'librarian_main_dashboard_renderer' ),
            plugin_dir_url( dirname( __DIR__, 2 ) ) . 'asset/bookshelf.png', 
            30
        );
    }

    /**
     * Main plugin dashboard view renderer
     * 
     * @return void
     */
    public function librarian_main_dashboard_renderer(){
        /**
         * @see Librarian\Utils\SettingUtils librarian_admin_view_template_utils()
         */
        SettingUtils::librarian_admin_view_template_utils( 'main-view.php' );
    }
}