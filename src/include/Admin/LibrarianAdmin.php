<?php
/**
 * Initiate plugin activation
 * 
 * @package Librarian
 */
namespace Librarian\Admin;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;
use Librarian\SettingsAPI\GeneralSetting;
use Librarian\SettingsAPI\BookChapterSetting;
use Librarian\SettingsAPI\BookCollectionSetting;
use Librarian\SettingsAPI\ChapterPageSetting;

class LibrarianAdmin {
    /**
     * @var Librarian\Settings\SettingsAPI[] $settings_api Array of Settings API instance
     */
    public $settings_api;
    
    /**
     * @var Librarian\Utils\SettingsUtils $settings_utils Instance for Setting Utils
     */
    public $settings_utils;

    public function __construct(){
        $this->settings_api = array(
            new GeneralSetting(),
            new BookChapterSetting(),
            new BookCollectionSetting(),
            new ChapterPageSetting()
        );
        $this->settings_utils = new SettingUtils();

        add_action( 'admin_menu', array( $this, 'librarian_add_top_level_admin_page' ), 10 );
        add_action( 'admin_menu', array( $this, 'librarian_add_general_sub_page' ), 10 );
        add_action( 'admin_menu', array( $this, 'librarian_add_cpt_manager_sub_page' ), 10 );
    }

    /**
     * Register top-menu admin page
     * 
     * @return void
     */
    public function librarian_add_top_level_admin_page(){
        add_menu_page( 
            'Librarian', 
            'Librarian', 
            'manage_options', 
            'librarian', 
            array( $this, 'librarian_main_admin_view' ),
            plugin_dir_url( dirname( __DIR__, 2 ) ) . 'asset/bookshelf.png', 
            30
        );
    }

    /**
     * Add general settings page to top-level
     * 
     * @return void
     */
    public function librarian_add_general_sub_page(){
        add_submenu_page( 
            'librarian', 
            'General', 
            'General', 
            'manage_options', 
            'librarian_general', 
            array( $this, 'librarian_general_settings_view' ) 
        );
    }

    /**
     * Add custom post type manager sub-page
     * 
     * @return void
     */
    public function librarian_add_cpt_manager_sub_page(){
        /**
         * @var array $sub_page_args Array of sub-page args
         */
        $sub_page_args = array(
            array(
                "page_title" => "Collections Manager",
                "menu_title" => "Collections Manager",
                "menu_slug" => "collection_manager",
                "callback" => array( $this, 'test' )
            ),
            array(
                "page_title" => "Chapter Manager",
                "menu_title" => "Chapter Manager",
                "menu_slug" => "chapter_manager",
                "callback" => array( $this, 'test' )
            ),
            array(
                "page_title" => "Chapter Page Manager",
                "menu_title" => "Chapter Page Manager",
                "menu_slug" => "chapter_page_manager",
                "callback" => array( $this, 'test' )
            )
        );

        foreach ($sub_page_args as $sub_page) {
            $hookname = add_submenu_page( 
                'librarian',
                $sub_page['page_title'], 
                $sub_page['menu_title'], 
                'manage_options', 
                $sub_page['menu_slug'], 
                $sub_page['callback'], 
                20 
            );

            add_action( 'load-' . $hookname, array( $this, 'test' ) );
        }
    }

    /**
     * Callback for main admin view
     * 
     * @see librarian_require_admin_view_template_utils()
     * 
     * @return void
     */
    public function librarian_main_admin_view(){
        $this->settings_utils->librarian_require_admin_view_template_utils( 'main-view.php' );
    }

    /**
     * Callback for general settings view
     * 
     * @see librarian_require_admin_view_template_utils()
     * 
     * @return void
     */
    public function librarian_general_settings_view(){
        $this->settings_utils->librarian_require_admin_view_template_utils( 'general-settings-view.php' );
    }

    public function test(){
        echo "
        <div>
            <h1>Test</h1>
        </div>
        ";
    }
}