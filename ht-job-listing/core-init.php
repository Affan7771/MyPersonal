<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

// Define Our Constants
define( 'HTJL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/****************************
* Plugin activation function
*****************************/
function htjl_plugin_activation(){
	include( HTJL_PLUGIN_PATH . 'inc/activation.php' );
}

/*****************************
* Plugin deactivation function
*****************************/
function htjl_plugin_deactivation(){

}

/*****************************
* Plugin init function
*****************************/
function htjl_init(){
	include( HTJL_PLUGIN_PATH . 'inc/api.php');
}
add_action('init','htjl_init');

/*****************************
* Enqueue styles and scripts
*****************************/
add_action('wp_enqueue_scripts', 'htjl_scripts');
function htjl_scripts(){

	// htmr css
	wp_enqueue_style( 'htjl_css', plugins_url( 'assets/css/htjl.css', __FILE__ ) );
	
	//htmr js
	wp_enqueue_script( 'htjl_js', plugins_url( 'assets/js/htjl.js', __FILE__ ) );
	wp_localize_script( 'htjl_js', 'htjl', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}

/*****************************
* Jobs listing shortcode
*****************************/
add_shortcode('company_job_listing', 'htmr_company_job_listing');
function htmr_company_job_listing(){
	ob_start();
	include( HTJL_PLUGIN_PATH . 'inc/htmr_company_job_listing.php');
	$return_string = ob_get_clean();
	return $return_string;
}

/*****************************
* Job detail shortcode
*****************************/
add_shortcode('company_job_detail', 'htmr_company_job_detail');
function htmr_company_job_detail(){
	ob_start();
	include( HTJL_PLUGIN_PATH . 'inc/htmr_company_job_detail.php');
	$return_string = ob_get_clean();
	return $return_string;
}

/*****************************
* Ajax
*****************************/
add_action('wp_ajax_nopriv_job_detail_form', 'job_detail_form_func');
add_action( 'wp_ajax_job_detail_form', 'job_detail_form_func' );
function job_detail_form_func(){
	include( HTJL_PLUGIN_PATH . 'inc/job_detail_form.php');
}

add_action('wp_ajax_nopriv_htjl_add_group_data', 'htjl_add_group_data_func');
add_action( 'wp_ajax_htjl_add_group_data', 'htjl_add_group_data_func' );
function htjl_add_group_data_func(){
	include( HTJL_PLUGIN_PATH . 'inc/add_group_data.php');
}

?>
