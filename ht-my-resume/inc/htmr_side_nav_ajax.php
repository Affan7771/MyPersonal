<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
global $wpdb;
$type = $_GET['type'];
$upload_dir = wp_upload_dir();
$user_id = get_current_user_id();
$htmr_user_resume = $wpdb->prefix . 'htmr_user_resume';
$results = $wpdb->get_results( "SELECT resume_url, file_name FROM $htmr_user_resume WHERE user_id = $user_id " );
$user_dirname = $upload_dir['basedir'].'/resume/'.get_current_user_id();
if ( $type == 'view' ) {
	echo json_encode(array(
		'url' 		=> $results[0]->resume_url,
		'file_name'	=> $results[0]->file_name
	));
}
elseif ( $type == 'delete' ){
	$files = glob($user_dirname.'/*');
	foreach($files as $file) {
	    if(is_file($file)) 
	        // Delete the given file
	        unlink($file); 
	}
	$wpdb->delete( $htmr_user_resume, array( 'user_id' => $user_id ) );
	echo json_encode(array(
		'status' => 'success'
	));
}

wp_die();
?>