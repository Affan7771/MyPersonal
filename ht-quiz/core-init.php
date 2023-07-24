<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

// Define Our Constants
define( 'HTQ_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/****************************
* Plugin activation function
*****************************/
function htq_plugin_activation(){
	include( HTQ_PLUGIN_PATH . 'inc/activation.php');
}

/*****************************
* Plugin deactivation function
*****************************/
function htq_plugin_deactivation(){
	include( HTQ_PLUGIN_PATH . 'inc/deactivation.php');
}

/*****************************
* Plugin init
*****************************/
function htq_plugin_init(){
	include( HTQ_PLUGIN_PATH . 'inc/api.php');
}
add_action('init', 'htq_plugin_init');

/*****************************
* Enqueue styles and scripts
*****************************/
function htq_enqueue(){
	// jQuery
	wp_enqueue_script( 'htq_jquery', 'https://code.jquery.com/jquery-3.6.0.min.js' );
	wp_enqueue_script( 'htq_js', plugins_url( 'assets/js/htq.js', __FILE__ ) );
	wp_localize_script( 'htq_js', 'htq', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	// Bootstrap
	wp_enqueue_style( 'htq_bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css' );
	wp_enqueue_script( 'htq_bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js' );
	// htq css
	wp_enqueue_style( 'htq_css', plugins_url( 'assets/css/htq.css', __FILE__ ) );
	// font awesome
	wp_enqueue_style( 'htq_font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
	// Sweet alert popup
	wp_enqueue_script( 'htq_sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11' );


}
add_action('wp_enqueue_scripts', 'htq_enqueue');

/*****************************
* Admin Menu
*****************************/
function ht_quiz_options() {
  add_menu_page('HT Quiz', 'HT Quiz', 'manage_options', 'ht-quiz', 'htq_options_page', 'dashicons-clipboard');
}
add_action('admin_menu', 'ht_quiz_options');

function htq_options_page(){
	include( HTQ_PLUGIN_PATH . 'inc/ht_quiz_option.php');
}

/*****************************
* Shortcode for quiz
*****************************/
add_shortcode( 'ht_quiz', 'htq_quiz' );
function htq_quiz(){
	ob_start();
	include( HTQ_PLUGIN_PATH . 'inc/ht_quiz.php');
	$return_string = ob_get_clean();
	return $return_string;
}

/*****************************
* Shortcode for single quiz
*****************************/
add_shortcode( 'ht_single_quiz', 'htq_single_quiz' );
function htq_single_quiz(){
	ob_start();
	include( HTQ_PLUGIN_PATH . 'inc/ht_single_quiz.php');
	$return_string = ob_get_clean();  
	return $return_string;
}

/*****************************
* Ajax Call
*****************************/
add_action('wp_ajax_htq_choice_answer', 'htq_choice_answer');
add_action('wp_ajax_nopriv_htq_choice_answer', 'htq_choice_answer');
function htq_choice_answer(){
	include( HTQ_PLUGIN_PATH . 'inc/ht_quiz_ajax.php');
}

?>