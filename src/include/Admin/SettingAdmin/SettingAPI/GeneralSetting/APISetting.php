<?php
/**
 * Plugin general API settingAPI for section, field, and option
 * 
 * @package Librarian
 */
namespace Librarian\Admin\SettingAdmin\SettingAPI\GeneralSetting;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;

class APISetting {
    public function __construct() {
        // Register setting
        add_action( 'admin_init', array( $this, 'librarian_register_api_setting_section' ), 10 );   
    }
    
    /**
     * Register general setting API option
     * 
     * @return void
     */
    private function librarian_register_api_option(){
        /**
         * @var array $options Array of option
         */
        $options = array(
            'librarian_api_enable' => true,
            'librarian_api_cache_duration' => 3600,
            'librarian_api_call_throttle_limit' => 100,
            'librarian_api_enable_cors' => false,
            'librarian_api_key' => 'LIBRARIANCOREAPIKEY',
            'librarian_api_rest_route' => 'wp-json/librarian/v1/',
            'librarian_api_allowed_origin' => '',
            'librarian_api_webhook_sync_url' => ''
        );

        add_option( 'librarian_api', $options );
    }
    
    /**
     * Register general api setting section
     * 
     * @return void
     */
    public function librarian_register_api_setting_section(){
        // Register option
        $this->librarian_register_api_option();

        /**
         * @var array $setting_fields Array of setting fields
         */
        $setting_fields = array(
            array(
                'id' => 'api_enable',
                'title' => 'Enable API Connection',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_checkbox_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_enable',
                    'describedby' => 'api_enable_desc',
                    'desc' => 'Enabling REST API connection to be used in headless application'
                )
            ),
            array(
                'id' => 'api_cache_duration',
                'title' => 'Set Cache Duration ( in seconds )',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_number_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_cache_duration',
                    'describedby' => 'api_cache_duration_desc',
                    'desc' => 'Caching store duration in second'
                )
            ),
            array(
                'id' => 'api_call_throttle_limit',
                'title' => 'Set API Call Limiter per Minute',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_number_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_call_throttle_limit',
                    'describedby' => 'api_call_throttle_limit_desc',
                    'desc' => 'Limiting API call per minute'
                )
            ),
            array(
                'id' => 'api_enable_cors',
                'title' => 'Enable CORS',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_checkbox_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_enable_cors',
                    'describedby' => 'api_enable_cors_desc',
                    'desc' => '* This could lead to XSS attack'
                )
            ),
            array(
                'id' => 'api_key',
                'title' => 'Set API Key',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_text_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_key',
                    'describedby' => 'api_key_desc',
                    'desc' => 'API Key for accessing REST API route'
                )
            ),
            array(
                'id' => 'api_rest_route',
                'title' => 'Default REST route',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_text_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_rest_route',
                    'describedby' => 'api_rest_route_desc',
                    'desc' => 'Default REST API route. Customize it based on need'
                )
            ),
            array(
                'id' => 'api_allowed_origin',
                'title' => 'Set REST Route Allowed Origin',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_text_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_allowed_origin',
                    'describedby' => 'api_allowed_origin_desc',
                    'desc' => 'Set allowed origin that can access REST API'
                )
            ),
            array(
                'id' => 'api_webhook_sync_url',
                'title' => 'Set Webhook Sync URL',
                'callback' => array( 'Librarian\Utils\SettingUtils', 'librarian_text_input_field_renderer_utils' ),
                'args' => array(
                    'option' => 'api',
                    'label_for' => 'api_webhook_sync_url',
                    'describedby' => 'api_webhook_sync_url_desc',
                    'desc' => 'Webhook URL for sending push notification'
                )
            )
        );

        /**
         * @see Librarian\Utils\SettingUtils librarian_register_setting_section_utils()
         */
        SettingUtils::librarian_register_setting_section_utils(
            'librarian_api_setting',
            'REST API Setting',
            array( $this, 'librarian_api_setting_section_renderer' ),
            'librarian_general',
            $setting_fields
        );
    }
    
    /**
     * Setting section renderer
     * 
     * @return void
     */
    public function librarian_api_setting_section_renderer(){
        printf(
            "<p class='%s'>%s</p>",
            esc_attr( 'librarian-section__desc' ),
            esc_html_e( 'General REST API setting for headless application', 'librarian' )
        );
    }
}