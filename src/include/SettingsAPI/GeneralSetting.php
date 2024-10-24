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

    public function __construct() {

    }

    public function init(){
        $this->librarian_settings_init();
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

        $this->setting_utils->librarian_register_options_utils('librarian_user_permission_options', $options);
    }

    /**
     * Registering all setting and option for admin view
     * 
     * @return void
     */
    private function librarian_settings_init(){
        add_action( 'admin_init', array( $this, 'librarian_add_general_setting_section' ), 10 );
        register_setting( 'librarian_general', 'librarian_general_setting' );
        $this->librarian_add_api_setting_options();
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

        add_option( 'librarian_api_options', $options );
    }

    /**
     * API Settings section
     * 
     * @return void
     */
    public function librarian_add_general_setting_section(){
        /**
         * @var array $setting_fields Array of fields that want to be registered
         */
        $setting_fields = array(
            array(
                'id' => 'api_enable',
                'title' => 'Enable API',
                'callback' => array( $this, 'librarian_api_enable_field_renderer' ),
                'args' => array(
                    'label_for' => 'api_enable'
                )
            )
            // array(
            //     'id' => 'api_caching_duration',
            //     'title' => 'API Caching Duration ( in seconds ) ',
            //     'callback' => array( $this, 'librarian_api_caching_duration_field_renderer' ),
            //     'args' => array(
            //         'label_for' => 'api_caching_duration'
            //     )
            // ),
            // array(
            //     'id' => 'api_throttle_limits',
            //     'title' => 'Limit API Call',
            //     'callback' => array( $this, 'librarian_api_throttle_limits_field_renderer' ),
            //     'args' => array(
            //         'label_for' => 'api_throttle_limits'
            //     )
            // ),
            // array(
            //     'id' => 'api_enable_cors',
            //     'title' => 'Enable CORS',
            //     'callback' => array( $this, 'librarian_api_enable_cors_field_renderer' ),
            //     'args' => array(
            //         'label_for' => 'api_enable_cors'
            //     )
            // ),
            // array(
            //     'id' => 'api_key',
            //     'title' => 'API Key',
            //     'callback' => array( $this, 'librarian_api_key_field_renderer' ),
            //     'args' => array(
            //         'label_for' => 'api_key'
            //     )
            // )
        );

        /**
         * @see Librarian\Utils\SettingUtils librarian_register_setting_section_utils()
         */

        SettingUtils::librarian_register_setting_section_utils(
            'api_setting',
            'API Setting',
            array( $this, 'librarian_api_setting_section_renderer' ),
            'librarian_general',
            $setting_fields
        );
    }

    /**
     * API setting section renderer
     * 
     * @return void
     */
    public function librarian_api_setting_section_renderer(){
        ?>
        <p class='librarian-section__desc'><?php esc_html_e( 'General API setting', 'librarian' ); ?></p>
        <?php
    }

    /**
     * API Enable field renderer
     * 
     * @return void
     */
    public function librarian_api_enable_field_renderer(){
        /**
         * @see librarian_get_option_value filter
         */
        $option = apply_filters( 'librarian_get_option_value', 'librarian_api_options', 'librarian_api_enabled', false );
        
        if( $option === false ) : ?>
            <p class="librarian-option--error">
                <?php esc_html_e( 'Option not registered', 'librarian' ); ?>
            </p>
        <?php else : ?>
            <div class="librarian-input-container">
                <label for="api_enable" class="librarian-input__label"><?php esc_html_e( 'Enable API Connection', 'librarian' ); ?></label>
                <input type="checkbox" name="api_enable" id="api_enable" checked="<?php esc_attr( $option ); ?>">
            </div>
        <?php endif; ?>
        <?php
    }


}