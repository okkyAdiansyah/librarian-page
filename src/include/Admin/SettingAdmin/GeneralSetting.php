<?php
/**
 * Plugin general setting page
 * 
 * @package Librarian
 */
namespace Librarian\Admin\SettingAdmin;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;
use Librarian\Admin\SettingAdmin\SettingAPI\GeneralSetting\APISetting;
use Librarian\Admin\SettingAdmin\SettingAPI\GeneralSetting\LibraryOverviewSetting;

class GeneralSetting {
    
    /**
     * @var Librarian\Admin\SettingAdmin\SettingAPI\GeneralSetting[] $setting_api Array of SettingAPI for general setting
     */
    private $setting_api;

    public function __construct() {
        $this->setting_api = array( 
            new APISetting(),
            new LibraryOverviewSetting()
        );
    }

    /**
     * Init class method
     * 
     * @return
     */
    public function librarian_init(){
        add_action('admin_menu', array( $this, 'librarian_register_setting_sub_page' ), 10);  
    }

    /**
     * Register general setting sub-page plugin admin
     * 
     * @return void
     */
    public function librarian_register_setting_sub_page(){
        add_submenu_page( 
            'librarian', 
            'General', 
            'General', 
            'manage_options', 
            'librarian_general', 
            array( $this, 'librarian_setting_admin_renderer' ) 
        );
    }

    /**
     * General setting sub-page admin renderer
     * 
     * @return void
     */
    public function librarian_setting_admin_renderer(){
        /**
         * @see Librarian\Utils\SettingUtils librarian_admin_view_template_utils()
         */
        SettingUtils::librarian_admin_view_template_utils( 'general-settings-view.php' );
    }

}