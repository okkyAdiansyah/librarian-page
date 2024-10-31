<?php
/**
 * Initiate plugin activation
 * 
 * @package Librarian
 */
namespace Librarian;
if( ! defined( 'ABSPATH' ) ){
    exit;
}

use Librarian\Admin\MainAdmin;

class Plugin {
    /**
     * @var array $services Stored array of registered service
     */
    public $services = array();

    /**
     * Run hook, filter, register service, and other function
     * 
     * @return void
     */
    public function librarian_init(){
        $this->librarian_register_plugin_service();
        add_action( 'init', array($this, 'librarian_register_template_cpt') );
    }

    /**
     * Method to run action or filter during plugin activation that will run once
     * 
     * @return void
     */
    public function librarian_plugin_activate(){
        flush_rewrite_rules(  );
    }

    /**
     * Method to clear any override during plugin deactivation
     * 
     * @return void
     */
    public function librarian_plugin_deactivate(){
        flush_rewrite_rules(  );
    }

    /**
     * Register plugin service
     * 
     * @return void
     */
    public function librarian_register_plugin_service(){
        /**
         * @var array $services_to_register Array of service that need to register
         */
        $services_to_register = array(
            MainAdmin::class
        );

        foreach( $services_to_register as $service_key => $service ){
            $this->services[] = $this->librarian_instantiated($service);
        }

        foreach( $this->services as $service ){
            $service->librarian_init();
        }
    }

    /**
     * Instantiated plugin service
     * 
     * @param Librarian\Service $service Service that will be instantiated
     * 
     * @return Class
     */
    private function librarian_instantiated($service){
        if( $service === null ){
            return;
        }

        return new $service();
    }

    /**
     * Register template custom post type
     * 
     * @return void
     */
    public function librarian_register_template_cpt(){
        $chapter_labels = array(
            'name'               => __( 'Book Chapters', 'librarian' ),
            'singular_name'      => __( 'Book Chapter', 'librarian' ),  
            'add_new'            => 'Add New Chapter',
            'add_new_item'       => 'Add New Chapter',
            'edit_item'          => 'Edit Chapter',
            'new_item'           => 'New Chapter',
            'view_item'          => 'View Chapter',
            'view_items'         => 'View Chapters',
            'search_items'       => 'Search Chapters',
            'not_found'          => 'No Chapters found',
            'not_found_in_trash' => 'No Chapters found in Trash',
            'all_items'          => 'All Chapters',
            'archives'           => 'Chapter Archives',
            'insert_into_item'   => 'Insert into Chapter',
            'uploaded_to_this_item' => 'Uploaded to this Chapter',
            'menu_name'          => 'Chapters',
            'name_admin_bar'     => 'Chapter',
        );

        $chapter_args = array(
            'labels'             => $chapter_labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['title', 'thumbnail'],
            'menu_icon'          => 'dashicons-open-folder',
            'show_in_rest'       => true
        );

        $page_labels = array(
            'name'               => __( 'Chapter Pages', 'librarian' ),
            'singular_name'      => __( 'Chapter Page', 'librarian' ),  
            'add_new'            => 'Add New Page',
            'add_new_item'       => 'Add New Page',
            'edit_item'          => 'Edit Page',
            'new_item'           => 'New Page',
            'view_item'          => 'View Page',
            'view_items'         => 'View Pages',
            'search_items'       => 'Search Pages',
            'not_found'          => 'No Pages found',
            'not_found_in_trash' => 'No Pages found in Trash',
            'all_items'          => 'All Pages',
            'archives'           => 'Page Archives',
            'insert_into_item'   => 'Insert into Page',
            'uploaded_to_this_item' => 'Uploaded to this Page',
            'menu_name'          => 'Chapter Pages',
            'name_admin_bar'     => 'Chapter Page',
        );

        $page_args = array(
            'labels'             => $page_labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['thumbnail'],
            'menu_icon'          => 'dashicons-text-page',
            'show_in_rest'       => true
        );

        $collection_labels = array(
            'name'               => __( 'Book Collections', 'librarian' ),
            'singular_name'      => __( 'Book Collection', 'librarian' ),  
            'add_new'            => 'Add New Book',
            'add_new_item'       => 'Add New Book',
            'edit_item'          => 'Edit Book',
            'new_item'           => 'New Book',
            'view_item'          => 'View Book',
            'view_items'         => 'View Books',
            'search_items'       => 'Search Books',
            'not_found'          => 'No Books found',
            'not_found_in_trash' => 'No Books found in Trash',
            'all_items'          => 'All Books',
            'archives'           => 'Book Archives',
            'insert_into_item'   => 'Insert into Book',
            'uploaded_to_this_item' => 'Uploaded to this Book',
            'menu_name'          => 'Book Collections',
            'name_admin_bar'     => 'Book Collection',
        );

        $collection_args = array(
            'labels'             => $collection_labels,
            'public'             => true,
            'hierarchical'       => true,
            'supports'           => ['title', 'thumbnail'],
            'menu_icon'          => 'dashicons-book',
            'show_in_rest'       => true
        );

        register_post_type( 'book_chapter', $chapter_args );
        register_post_type( 'chapter_page', $page_args );
        register_post_type( 'book_collection', $collection_args );
    }

}