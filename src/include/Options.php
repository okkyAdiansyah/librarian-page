<?php
/**
 * Singleton for options API
 * 
 * @package Librarian
 */
namespace Librarian;

if( ! defined( 'ABSPATH' ) ){
    exit;
}

class Options{
    /**
     * @var array $options List of option added
     */
    public static $options = array();

    public static $instance = null;

    public function __construct() {

    }

    public static function librarian_get_instance(){
        if( self::$instance === null ){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function debug($option_name){
        return get_option(self::$options[$option_name]);
    }

    /**
     * Retrieve single option
     * 
     * @param string $option_name Options name
     * @param string $option_key Option key that will retrieve its value
     * 
     * @return
     */
    public function librarian_get_option( $option_name, $option_key ){
        $option = apply_filters( 
            'librarian_get_option_value', 
            self::$options[$option_name], 
            $option_name . '_' . $option_key,
            false
        );

        return $option;
    }

    /**
     * Register option
     * 
     * @param string $option_name Option name
     * @param array $args Option value in array
     * 
     * @return void
     */
    public function librarian_add_option( $option_name, $args ){
        add_option('librarian_' . $option_name, $args);
        self::$options[$option_name] = 'librarian_' . $option_name;
    }

    /**
     * Delete option
     * 
     * @return void
     */
    public function librarian_reset_option(){
        foreach( self::$options as $option ){
            delete_option( $option );
        }
    }
}