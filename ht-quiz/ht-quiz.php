<?php
/**
* Plugin Name: HT Quiz
* Plugin URI: https://google.com
* Description: Quiz Plugin
* Version: 1.0
* Author: HT Quiz
* Author URI: https://google.com
* License: GPL2
*/

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

// Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}

/*
* Plugin Activation and Deactivation hooks
*/
register_activation_hook( __FILE__ , 'htq_plugin_activation' );
register_deactivation_hook( __FILE__ , 'htq_plugin_deactivation' );