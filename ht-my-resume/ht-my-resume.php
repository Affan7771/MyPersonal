<?php
/**
* Plugin Name: HT My Resume
* Plugin URI: https://google.com
* Description: Buddyboss my resume tab
* Version: 1.1
* Author: Hackertrial
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
register_activation_hook( __FILE__ , 'htmr_plugin_activation' );
register_deactivation_hook( __FILE__ , 'htmr_plugin_deactivation' );