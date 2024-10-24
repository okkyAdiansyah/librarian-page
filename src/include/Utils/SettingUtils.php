<?php
/**
 * Static class utils for Admin, Settings API, and Options.
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
    public static function librarian_add_custom_post_editor_utils( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback, $position = 20 ){
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
    
    /**
     * Admin template view utils
     * 
     * @param string $filename File name for template view
     * 
     * @return void
     */
    public static function librarian_admin_view_template_utils($filename){
        if( file_exists( plugin_dir_path( dirname( __DIR__, 2 )) ) . 'src/admin-template/' . $filename ){
            require plugin_dir_path( dirname( __DIR__, 2 ) ) . 'src/admin-template/' . $filename;
        } else {
            echo "<div class='wrap'>Test</div>";
        }
    }

    /**
     * Setting section and field registration utils
     * 
     * @param string $section_id Section identifier
     * @param string $section_title Section title
     * @param callback $section_callback Section view renderer
     * @param string $opt_page_id Setting page identifier
     * @param array $setting_fields Array of setting field that want to be registered
     * 
     * @return void
     */
    public static function librarian_register_setting_section_utils( $section_id, $section_title, $section_callback, $opt_page_id, $setting_fields ){
        // Register setting section
        add_settings_section( 
            $section_id,
            __( $section_title, 'librarian' ),
            $section_callback, 
            $opt_page_id
        );

        // Loop over field that want to be registered

        foreach( $setting_fields as $field ){
            add_settings_field( 
                $field['id'], 
                __( $field['title'], 'librarian' ), 
                $field['callback'], 
                $opt_page_id, 
                $section_id, 
                $field['args']
            );
        }
    }

    /**
     * Setting field checkbox renderer utils
     * 
     * @param array $args Option key, ARIA describedy
     * 
     * @return void
     */
    public static function librarian_checkbox_field_renderer_utils( $args ){
        /**
         * @see librarian_get_option_value filter
         */
        $option = apply_filters( 
            'librarian_get_option_value', 
            'librarian_' . $args['option'], 
            'librarian_' . $args['label_for'],
            false
        );

        $checked = $option ? 'checked' : '';

        printf(
            "<input id='%s' type='%s' name='%s' %s value='%s'>",
            esc_attr( $args['label_for'] ),
            esc_attr( 'checkbox' ),
            esc_attr( $args['label_for'] ),
            $checked,
            esc_attr( $option )
        );

        if( isset( $args['describedby'] ) ){
            printf(
                "<p id='%s'>%s</p>",
                esc_attr( $args['describedby'] ),
                esc_html( $args['desc'], 'librarian' )
            );
        }
    }

    /**
     * Setting number input field renderer utils
     * 
     * @param array $args Option key, ARIA describedy
     * 
     * @return void
     */
    public static function librarian_number_input_field_renderer_utils( $args ){
        /**
         * @see librarian_get_option_value filter
         */
        $option = apply_filters( 
            'librarian_get_option_value', 
            'librarian_' . $args['option'], 
            'librarian_' . $args['label_for'],
            false
        );

        printf(
            "<input id='%s' type='%s' name='%s' value='%s' class='regular-text' >",
            esc_attr( $args['label_for'] ),
            esc_attr( 'number' ),
            esc_attr( $args['label_for'] ),
            esc_attr( $option )
        );

        if( isset( $args['describedby'] ) ){
            printf(
                "<p id='%s'>%s</p>",
                esc_attr( $args['describedby'] ),
                esc_html( $args['desc'], 'librarian' )
            );
        }
    }

    /**
     * Setting text input field renderer utils
     * 
     * @param array $args Option key, ARIA describedy
     * 
     * @return void
     */
    public static function librarian_text_input_field_renderer_utils( $args ){
        /**
         * @see librarian_get_option_value filter
         */
        $option = apply_filters( 
            'librarian_get_option_value', 
            'librarian_' . $args['option'], 
            'librarian_' . $args['label_for'],
            false
        );

        printf(
            "<input id='%s' class='regular-text' type='%s' name='%s' value='%s'>",
            esc_attr( $args['label_for'] ),
            esc_attr( 'text' ),
            esc_attr( $args['label_for'] ),
            esc_attr( $option )
        );

        if( isset( $args['describedby'] ) ){
            printf(
                "<p id='%s'>%s</p>",
                esc_attr( $args['describedby'] ),
                esc_html( $args['desc'], 'librarian' )
            );
        }
    }
}