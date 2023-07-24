<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

global $wpdb;
// check security nonce which one we created in html form and sending with data.
check_ajax_referer('uploadingFile', 'security');

$upload_dir = wp_upload_dir();
$user_id = get_current_user_id();
$htmr_user_resume = $wpdb->prefix . 'htmr_user_resume';

if ( ! empty( $upload_dir['basedir'] ) ) {
	$user_dirname = $upload_dir['basedir'].'/resume/'.get_current_user_id();
	if ( ! file_exists( $user_dirname ) ) {
        wp_mkdir_p( $user_dirname );
    }

    if (is_dir_empty($user_dirname)) {
		//Folder is empty
		$filename = wp_unique_filename( $user_dirname, $_FILES['htmr_file']['name'] );
		move_uploaded_file($_FILES['htmr_file']['tmp_name'], $user_dirname .'/'. $filename);
		// Insert into database
		$resume_url = $upload_dir['baseurl'].'/resume/'.get_current_user_id().'/'.$filename;
		$wpdb->insert($htmr_user_resume, array(
			'user_id'		=> $user_id,
			'resume_url' 	=> $resume_url,
			'file_name'		=> $_FILES['htmr_file']['name'],
			'modified'		=> date("F d, Y")
		), array(
			'%d', '%s', '%s', '%s',
		));
		echo json_encode( array(
			'code'	=> 200
		));

	}else{
		// Folder is not empty
		$files = glob($user_dirname.'/*');
		foreach($files as $file) {
		    if(is_file($file)) 
		        // Delete the given file
		        unlink($file); 
		}
		$filename = wp_unique_filename( $user_dirname, $_FILES['htmr_file']['name'] );
		move_uploaded_file($_FILES['htmr_file']['tmp_name'], $user_dirname .'/'. $filename);
		// Update into database
		$resume_url = $upload_dir['baseurl'].'/resume/'.get_current_user_id().'/'.$filename;
		$checkIfExists = $wpdb->get_var("SELECT * FROM $htmr_user_resume WHERE user_id = '$user_id'");
		if ($checkIfExists == NULL) {
			$wpdb->insert($htmr_user_resume, array(
				'user_id'		=> $user_id,
				'resume_url' 	=> $resume_url,
				'file_name'		=> $_FILES['htmr_file']['name'],
				'modified'		=> date("F d, Y")
			), array(
				'%d', '%s', '%s', '%s',
			));
		}else{
			$data_array = array(
			    'resume_url' => $resume_url,
			    'file_name' => $_FILES['htmr_file']['name'],
			    'modified' => date("F d, Y"),
		    );
		    $data_where = array('user_id' => $user_id);
			$wpdb->update($htmr_user_resume, $data_array, $data_where);
		}
			
		echo json_encode( array(
			'code'	=> 200
		));
	}

}

wp_die();
?>