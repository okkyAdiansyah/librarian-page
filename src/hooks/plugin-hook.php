<?php
/**
 * Plugin hook collection
 * 
 * @package Librarian
 */

/**
 * Filter hook for retrieving option value
 * 
 * @param string $option_name Option identifier
 * @param string $key Option key
 * @param boolean $default Default return value
 * 
 * @return value
 */
function librarian_get_option_value_callback($option_name, $key, $default = false){
    $option = get_option( $option_name );

    return $option[$key] ?? $default;
}

add_filter( 'librarian_get_option_value', 'librarian_get_option_value_callback', 10, 3 );