<?php
/**
 * General settings
 * 
 * @package Librarian
 */
namespace Librarian\SettingsAPI;

if( ! defined( 'ABSPATH' )){
    exit;
}

use Librarian\Utils\SettingUtils;

class GeneralSetting {
    /**
     * @var Librarian\Utils\SettingUtils $setting_utils Setting utils instance
     */
    public $setting_utils;

    public function __construct() {
        $this->setting_utils = new SettingUtils();
    }

    /**
     * Register all options
     * 
     * @return void
     */
    public function librarian_register_options(){
        $function_called = get_transient( 'librarian_general_settings' );

        // Make sure this function run once
        if( false === $function_called ){
            return;
        }

        $this->librarian_add_api_setting_options();
        $this->librarian_add_content_default_setting_options();
        $this->librarian_add_headless_setting_options();
        $this->librarian_add_main_ui_setting_options();
        $this->librarian_add_notif_and_log_setting_options();
        $this->librarian_add_user_permission_setting_options();

        set_transient( 'librarian_general_settings', true, 60 * 60 );
    }

    /**
     * Add API setting options
     * 
     * @return void
     */
    private function librarian_add_api_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_api_enabled' => true,
            'librarian_api_cache_duration' => 3600,
            'librarian_api_throttle_limits' => 50,
            'librarian_api_enable_cors' => false,
            'librarian_api_key' => "LIBRARIANCOREAPI"
        ); 

        $this->setting_utils->librarian_register_options_utils('librarian_api_options', $options);
    }

    /**
     * Add content default setting options
     * 
     * @return void
     */
    private function librarian_add_content_default_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_content_default_status' => 'draft',
            'librarian_content_default_date_format' => 'd-m-Y',
            'librarian_content_default_timzone' => 'UTC'
        ); 

        $this->setting_utils->librarian_register_options_utils('librarian_content_default_options', $options);
    }

    /**
     * Add main admin view UI setting options
     * 
     * @return void
     */
    private function librarian_add_main_ui_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_main_ui_latest_content_enabled' => true,
            'librarian_main_ui_latest_content_show_count' => 5,
            'librarian_main_ui_trending_enabled' => true,
            'librarian_main_ui_trending_rank_count' => 10,
            'librarian_main_ui_book_on_hiatus_enabled' => true,
            'librarian_main_ui_book_on_hiatus_count' => 5
        ); 

        $this->setting_utils->librarian_register_options_utils('librarian_main_ui_options', $options);
    }

    /**
     * Add headless setting options
     * 
     * @return void
     */
    private function librarian_add_headless_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_headless_frontend_disabled' => true,
            'librarian_headless_default_rest_route' => "wp-json/librarian/v1/",
            'librarian_headless_allowed_origin' => "",
            'librarian_headless_webhook_sync_url' => ""
        ); 

        $this->setting_utils->librarian_register_options_utils('librarian_headless_options', $options);
    }

    /**
     * Add notification & logging setting options
     * 
     * @return void
     */
    private function librarian_add_notif_and_log_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_notif_update_enabled' => true,
            'librarian_notif_sent_to_mail_enabled' => true,
            'librarian_notif_email_reciever' => "",
            'librarian_log_enabled' => true,
            'librarian_log_show_count' => 5
        ); 

        $this->setting_utils->librarian_register_options_utils('librarian_notif_and_log_options', $options);
    }

    /**
     * Add user permissions setting options
     * 
     * @return void
     */
    private function librarian_add_user_permission_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_user_permission_restricted_role_enabled' => true,
            'librarian_user_permission_restricted_role' => array( 'editor', 'admin' ),
            'librarian_user_permission_content_moderation_enabled' => true,
            'librarian_user_permission_conntet_moderation' => 'admin'
        ); 

        $this->setting_utils->librarian_register_options_utils('librarian_user_permissi_options', $options);
    }
}