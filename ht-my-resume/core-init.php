<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

// Define Our Constants
define( 'HTMR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/****************************
* Plugin activation function
*****************************/
function htmr_plugin_activation(){
	include( HTMR_PLUGIN_PATH . 'inc/activation.php');
}

/*****************************
* Plugin deactivation function
*****************************/
function htmr_plugin_deactivation(){
	include( HTMR_PLUGIN_PATH . 'inc/deactivation.php');
}

/*****************************
* Enqueue styles and scripts
*****************************/
add_action('wp_enqueue_scripts', 'htmr_scripts');
function htmr_scripts(){

	// jQuery
	//wp_enqueue_script( 'htmr_jquery', 'https://code.jquery.com/jquery-3.6.0.min.js' );

	// htmr css
	wp_enqueue_style( 'htmr_css', plugins_url( 'assets/css/htmr.css', __FILE__ ) );
	wp_enqueue_style( 'htmr_boxicon', 'https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' );

	//htmr js
	wp_enqueue_script( 'htmr_js', plugins_url( 'assets/js/htmr.js', __FILE__ ) );
	wp_localize_script( 'htmr_js', 'htmr', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );


}

/*****************************
* Adding my resume tab in profile
*****************************/
// Check if buddyboss is active
if ( function_exists('bp_is_active') ) {
  
	add_action( 'bp_setup_nav', 'htmr_my_resume_nav' );
	function htmr_my_resume_nav(){
		global $bp;
		bp_core_new_nav_item( array( 
	        'name' 						=> 'My Resume', 
	        'slug' 						=> 'my-resume', 
	        'screen_function' 			=> 'nav_resume_function', 
	        'position' 					=> 70,
	        'parent_url'      			=> bp_loggedin_user_domain() . '/my-resume/',
	        'parent_slug'     			=> $bp->profile->slug,
	        'show_for_displayed_user'	=> false,
	    ) );
	}

	function nav_resume_function(){
		// Add title and content here - last is to call the members plugin.php template.
	    add_action( 'bp_template_title', 'htmr_resume_tab_title' );
	    add_action( 'bp_template_content', 'htmr_resume_tab_content' );
	    bp_core_load_template( 'buddypress/members/single/plugins' );
	}

	function htmr_resume_tab_title(){
		include( HTMR_PLUGIN_PATH . 'inc/my_resume_title.php');
	}

	function htmr_resume_tab_content(){
		include( HTMR_PLUGIN_PATH . 'inc/my_resume_content.php');
	}

}
	
/*****************************
* File upload ajax
*****************************/
add_action('wp_ajax_nopriv_upload_file', 'htmr_upload_file');
add_action( 'wp_ajax_upload_file', 'htmr_upload_file' );
function htmr_upload_file(){
	include( HTMR_PLUGIN_PATH . 'inc/upload_file.php' );
}

add_action('wp_ajax_nopriv_htmr_check_user_resume', 'htmr_check_user_resume');
add_action( 'wp_ajax_htmr_check_user_resume', 'htmr_check_user_resume' );
function htmr_check_user_resume(){
	include( HTMR_PLUGIN_PATH . 'inc/htmr_check_user_resume.php' );
}

add_action('wp_ajax_nopriv_htmr_side_nav_ajax', 'htmr_side_nav_ajax');
add_action( 'wp_ajax_htmr_side_nav_ajax', 'htmr_side_nav_ajax' );
function htmr_side_nav_ajax(){
	include( HTMR_PLUGIN_PATH . 'inc/htmr_side_nav_ajax.php' );
}

function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL; 
  return (count(scandir($dir)) == 2);
}

?>
