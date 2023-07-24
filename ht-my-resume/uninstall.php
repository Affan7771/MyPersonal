<?php 

// If this file is called directly, abort. //
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

/****************************
* Delete custom created table
*****************************/
global $wpdb;

$htmr_user_resume = $wpdb->prefix . 'htmr_user_resume';
$sql = "DROP TABLE IF EXISTS $htmr_user_resume";
$wpdb->query($sql);

?>