<?php
/**
 * Utils for Admin, Settings API, and Options
 * 
 * @package Librarian
 */
namespace Librarian\Utils;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class SettingUtils{
    /**
     * Add sub-menu page to override default sub-menu on Custom Post Type
     * 
     * @param string $parent_slug CPT slug
     * @param string $page_title Sub-menu page title
     * @param string $menu_title Sub-menu menu title
     * @param string $capability Sub-menu capability
     * @param string $menu_slug Sub-menu slug
     * @param array/string $callback Sub-menu view page
     * @param int $position Sub-menu postition
     *            Default: 20
     */
    public function librarian_add_custom_post_editor_utils( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback, $position = 20 ){
        remove_submenu_page( 
            'edit.php?post_type=' . $parent_slug, 
            'post-new.php?post_type=' . $parent_slug
        );
        
        add_submenu_page( 
            'edit.php?post_type=' . $parent_slug, 
            $page_title, 
            $menu_title, 
            $capability, 
            $menu_slug, 
            $callback, 
            $position 
        );
    }
}