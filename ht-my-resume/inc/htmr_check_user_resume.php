<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

global $wpdb;
$user_id = get_current_user_id();
$htmr_user_resume = $wpdb->prefix . 'htmr_user_resume';
$results = $wpdb->get_results( "SELECT * FROM $htmr_user_resume WHERE user_id = $user_id " );
$pdf_icon = site_url() . '/wp-content/plugins/ht-my-resume/assets/img/pdf-icon.png';

$output = '';
if( !empty($results) ){
	
	$output .= '<table>';
	    $output .= '<tr>';
	      $output .= '<th width="50%">Name</th>';
	      $output .= '<th>Modified</th>';
	      $output .= '<th>Visibility</th>';
	      $output .= '<th></th>';
	    $output .= '</tr>';
	    foreach($results as $row){
		    $output .= '<tr>';
		      	$output .= '<td><img src="'.$pdf_icon.'" class="pdf_icon_img" />'.$row->file_name.'</td>';
			    $output .= '<td>'.$row->modified.'</td>';
			    $output .= '<td>Only Me</td>';
			    $output .= '<td><button id="htmr_side_nav" class="htmr_three_dots htmr_dropbtn">
			      	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16"><path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>
			      </button>
			      <div id="htmr_dropdown" class="htmr_dropdown_content htmr_dropdown-content">
				    <a href="#" class="htmr_resume_view">View</a>
				    <a href="#" class="htmr_resume_update">Update</a>
				    <a href="#" class="htmr_resume_delete">Delete</a>
				  </div>
		  		</td>';
		    $output .= '</tr>';
		}
	$output .= '</table>';
}else{

	$output .= '<aside class="bp-feedback info htmr-message">
		<span class="bp-icon" aria-hidden="true"></span>
		<p>No resume were found.</p>
	</aside>';
}

echo json_encode(array(
	'output' => $output,
));

wp_die();
?>