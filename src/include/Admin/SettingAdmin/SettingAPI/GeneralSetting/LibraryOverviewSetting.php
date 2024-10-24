<?php
/**
 * Plugin general Main Dashboard settingAPI for section, field, and option
 * 
 * @package Librarian
 */
namespace Librarian\Admin\SettingAdmin\SettingAPI\GeneralSetting;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;

class LibraryOverviewSetting {
    public function __construct() {
        // Register setting
        add_action( 'admin_init', array( $this, 'librarian_register_library_overview_setting_section' ), 10 );  
    }

    /**
     * Register general setting main dashboard option
     * 
     * @return void
     */
    private function librarian_register_library_overview_option(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_library_overview_latest_content_log_enabled' => true,
            'librarian_library_overview_latest_content_log_show_count' => 5,
            'librarian_library_overview_trending_content_enabled' => true,
            'librarian_library_overview_trending_content_show_count' => 10,
            'librarian_library_overview_book_on_hiatus_enabled' => true,
            'librarian_library_overview_book_on_hiatus_show_count' => 5
        );

        add_option( 'librarian_library_overview', $options );
    }

    /**
     * Register general main dashboard setting section
     * 
     * @return void
     */
    public function librarian_register_library_overview_setting_section(){
        // Register option
        $this->librarian_register_library_overview_option();

        /**
         * @var array $setting_fields Array of setting fields
         */
        $setting_fields = array(
            array(
                'id' => 'library_overview_latest_content_log',
                'title' => 'Enable Latest Uploaded Content Log',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_checkbox_field_renderer_utils' ),
                'args' => array(
                    'option' => 'library_overview',
                    'label_for' => 'library_overview_latest_content_log_enabled',
                    'describedby' => 'library_overview_latest_content_log_enabled_desc',
                    'desc' => 'Enabling latest content log to be used in main dashboard and l'
                )
            ),
            array(
                'id' => 'library_overview_latest_content_log_show_count',
                'title' => 'Latest Uploaded Content Log to Show',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_number_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'library_overview',
                    'label_for' => 'library_overview_latest_content_log_show_count',
                    'describedby' => 'library_overview_latest_content_log_show_count_desc',
                    'desc' => 'Number of latest uploaded content to show on the log'
                )
            ),
            array(
                'id' => 'library_overview_trending_content_enabled',
                'title' => 'Enable Trending Content Log',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_checkbox_field_renderer_utils' ),
                'args' => array(
                    'option' => 'library_overview',
                    'label_for' => 'library_overview_trending_content_enabled',
                    'describedby' => 'library_overview_trending_content_enabled_desc',
                    'desc' => 'Enable trending content log to plugin main dashboard'
                )
            ),
        );

        /**
         * @see Librarian\Utils\SettingUtils librarian_register_setting_section_utils()
         */
        SettingUtils::librarian_register_setting_section_utils(
            'librarian_library_overview_setting',
            'Library Overview Setting',
            array( $this, 'librarian_library_overview_setting_section_renderer' ),
            'librarian_general',
            $setting_fields
        );
    }

    /**
     * Register general main dashboard setting section
     * 
     * @return void
     */
    public function librarian_library_overview_setting_section_renderer(){
        printf(
            "<p class='%s'>%s</p>",
            esc_attr( 'librarian-section__desc' ),
            esc_html_e( 'Library overview settings for main dashboard and headless', 'librarian' )
        );
    }
}