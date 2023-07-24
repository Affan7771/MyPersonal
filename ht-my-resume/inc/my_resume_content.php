<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
global $wpdb;
$user_id = get_current_user_id();
$htmr_user_resume = $wpdb->prefix . 'htmr_user_resume';
$results = $wpdb->get_results( "SELECT * FROM $htmr_user_resume WHERE user_id = $user_id " );

?>

<div id="htmr_user_resume_table" class="htmr_container" style="overflow-x:auto;"></div>