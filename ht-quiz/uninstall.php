<?php 

// If this file is called directly, abort. //
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

/*
* Delete custom created table
*/
global $wpdb;

$htq_user_records = $wpdb->prefix . 'htq_user_records';
$sql = "DROP TABLE IF EXISTS $htq_user_records";
$wpdb->query($sql);

/*
* Delete custom created options
*/
delete_option( 'htq_listing_page_option' );
delete_option( 'htq_single_page_option' );
// delete_option( 'htq_result_page_option' );
delete_option( 'htq_invalid_quiz_message' );

?>