<?php
/**
 * Auto updating post
 * 
 * @package Librarian
 */
namespace Librarian\Services\AutoUpdate;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

use WP_Query;

class PostAutoUpdate{
    
    public function librarian_init(){
        add_action( 'acf/save_post', array( $this, 'librarian_custom_chapter_on_publish' ), 20);
        add_action( 'acf/save_post', array( $this, 'librarian_auto_update_book_content_parent'), 20 );
    }

    /**
     * Auto naming the chapter with prefix
     * 
     * @param int $post_parent Parent post ID
     * @param string $post_type Post type slug
     * 
     * @return string
     */
    public function librarian_auto_name_prefix_chapter( $post_type, $post_parent ){
        $args = array(
            "post_type"      => $post_type,
            "post_parent"    => $post_parent,
            "posts_per_page" => -1,
            "no_found_rows"  => true
        );

        $posts = new WP_Query( $args );



        if( $posts->have_posts(  ) ){
            $name_prefix = 'Chapter '. $posts->post_count . ' - ';
            return array(
                'prefix' => $name_prefix,
                'slug' => 'chapter-' . $posts->post_count
            );
        }

        return null;
    }

    /**
     * Auto update parent post when child post is published
     * 
     * @param int $post_id Post ID that being published
     * 
     * @return void
     */
    public function librarian_auto_update_parent_post( $parent_post_id = null ){
        if( $parent_post_id ){
            // Check if this function has already been run for the parent post
            if ( get_post_meta( $parent_post_id, '_librarian_parent_updated', true ) ) {
                return; // Prevent infinite loop
            }

            // Set the flag to indicate this function is running for the parent post
            update_post_meta( $parent_post_id, '_librarian_parent_updated', true );

            // Update the parent post's modified date
            wp_update_post( array(
                'ID' => $parent_post_id,
                'post_modified' => current_time( 'mysql' ),
                'post_modified_gmt' => current_time( 'mysql', 1 ) 
            ) );

            // Remove the flag after updating
            delete_post_meta( $parent_post_id, '_librarian_parent_updated' );
        }
    }

    /**
     * Add naming prefix and set post parent on chapter published
     * 
     * @param int $post_id Post ID
     * 
     * @return void
     */
    public function librarian_custom_chapter_on_publish( $post_id ){

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }

        if( get_post_status( $post_id ) !== 'publish' && get_post_type( $post_id ) !== 'chapter' ){
            return;
        }

        remove_action( 'acf/save_post', array( $this, 'librarian_custom_chapter_on_publish' ), 20 );
        
        $parent_post_id = get_field( 'parent_collection', $post_id );
        $subtitle = get_field( 'chapter_sub', $post_id );

        $name_prefix = $this->librarian_auto_name_prefix_chapter( 'chapter', $parent_post_id );
        $title = $name_prefix['prefix'] . $subtitle;

        wp_update_post( array(
            'ID' => $post_id,
            'post_parent' => $parent_post_id[0],
            'post_title' => esc_html( $title ),
            'post_name' => sanitize_title($name_prefix['slug'])
        ) );

        $this->librarian_auto_update_parent_post( $parent_post_id );

        add_action( 'acf/save_post', array( $this, 'librarian_custom_chapter_on_publish' ), 20 );
    }

    /**
     * Auto update both parent and grandparent post
     * 
     * @param int $post_id Post ID after post is published
     * 
     * @return void
     */
    public function librarian_auto_update_book_content_parent( $post_id ){
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }

        if( get_post_status( $post_id ) !== 'publish' && get_post_type( $post_id ) !== 'book_content' ){
            return;
        }

        remove_action( 'acf/save_post', array( $this, 'librarian_auto_update_book_content_parent' ), 20 );

        $parent_post_id = get_field( 'parent_chapter', $post_id );
        $parent_title_id = get_field( 'parent_collection', $post_id );

        wp_update_post( array(
            'ID'          => $post_id,
            'post_parent' => $parent_post_id[0],
            'post_title'  => $parent_title_id[0] . ' - ' . $parent_post_id[0] . ' - page',
            'post_name'   => $parent_title_id[0] . '-' . $parent_post_id[0] . '-page'
        ) );

        $this->librarian_auto_update_parent_post( $parent_title_id );
        $this->librarian_auto_update_parent_post( $parent_title_id );
        
        add_action( 'acf/save_post', array( $this, 'librarian_auto_update_book_content_parent' ), 20, 1 );
        
    }

    public function librarian_debug(){
        if( get_transient( 'librarian_debug' ) ){
            echo '<div class="notice notice-success is-dismissible"><p>Function executed successfully.</p></div>';
        }
        delete_transient( 'librarian_debug' );
    }
}