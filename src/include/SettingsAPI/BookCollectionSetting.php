<?php
/**
 * Book Collection Setting API
 * 
 * @package Librarian
 */
namespace Librarian\SettingsAPI;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Utils\SettingUtils;

class BookCollectionSetting {
    /**
     * @var Librarian\Utils\SettingUtils $setting_utils Setting utils instance
     */
    public $setting_utils;


    public function __construct() {
      $this->setting_utils = new SettingUtils();

      add_action( 'admin_menu', array( $this, 'librarian_custom_post_editor' ), 10 );
    }

    /**
     * Register all options
     * 
     * @return void
     */
    public function librarian_register_options(){
        $function_called = get_transient( 'librarian_book_collection_settings' );

        // Make sure this function run once
        if( false === $function_called ){
            return;
        }

        $this->librarian_add_metadata_setting_options();
        $this->librarian_add_display_setting_options();

        set_transient( 'librarian_book_collection_settings', true, 60 * 60 );
    }

    /**
     * Add custom post editor form for Book Chapter CPT
     */
    public function librarian_custom_post_editor(){
        /**
         * @see SettingUtils librarian_add_custom_post_editor_utils()
         */
        $this->setting_utils->librarian_add_custom_post_editor_utils( 'book_collection', 'Add New Collection', 'Add New Collection', 'manage_options', 'custom_add_new_collection', array( $this, 'test' ) );
    }

    /**
     * Add collection metadata setting option
     * 
     * @return void
     */
    private function librarian_add_metadata_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_metadata_enabled' => true,
            'librarian_metadata_custom_tags_enabled' => true,
            'librarian_metadata_description_enabled' => true,
            'librarian_metadata_authors_enabled' => true,
            'librarian_metadata_artists_enabled' => true,
            'librarian_metadata_status_enabled' => true,
            'librarian_metadata_rating_enabled' => true,
            'librarian_metadata_seo_keyword_enabled' => true,
            'librarian_metadata_featured_enabled' => true
        );
        
        $this->setting_utils->librarian_register_options_utils('librarian_collection_metadata', $options);
    }

    /**
     * Add collection display setting option
     * 
     * @return void
     */
    private function librarian_add_display_setting_options(){
        /**
         * @var array $options Array of options
         */
        $options = array(
            'librarian_collection_display_order' => array( 'Alphabetical', 'Latest Update', 'Trend', 'Rating' ),
            'librarian_collection_display_per_page' => 20,
            'librarian_collection_display_filter' => array( 'Genre', 'Type' )
        );
        
        $this->setting_utils->librarian_register_options_utils('librarian_collection_display_settings', $options);
    }

    public function test(){
        echo "
        <div>
            <h1>Test</h1>
        </div>
        ";
    }
}