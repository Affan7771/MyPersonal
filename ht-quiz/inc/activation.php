<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
global $wpdb;

/****************************
* Creating single quiz page
*****************************/
$page = get_page_by_title( 'Quiz Listing' );
if ( !$page ) {
  
  $my_post = array(
    'post_title'    => wp_strip_all_tags( 'Quiz Listing' ),
    'post_content'  => '[ht_quiz]',
    'post_status'   => 'publish',
    'post_author'   => get_current_user_id(),
    'post_type'     => 'page',
  );

  // Insert the post into the database
  wp_insert_post( $my_post );

}

/****************************
* Creating single quiz page
*****************************/
$page = get_page_by_title( 'Single Quiz' );
if ( !$page ) {
  
  $my_post = array(
    'post_title'    => wp_strip_all_tags( 'Single Quiz' ),
    'post_content'  => '[ht_single_quiz]',
    'post_status'   => 'publish',
    'post_author'   => get_current_user_id(),
    'post_type'     => 'page',
  );

  // Insert the post into the database
  wp_insert_post( $my_post );

}

/****************************
* Creating quiz result page
*****************************/
/*$page = get_page_by_title( 'Quiz Result' );
if ( !$page ) {
  
  $my_post = array(
    'post_title'    => wp_strip_all_tags( 'Quiz Result' ),
    'post_content'  => '[ht_quiz_result]',
    'post_status'   => 'publish',
    'post_author'   => get_current_user_id(),
    'post_type'     => 'page',
  );

  // Insert the post into the database
  wp_insert_post( $my_post );

}*/

/****************************
* Adding option
*****************************/
add_option( 'htq_listing_page_option', 'quiz-listing' );
add_option( 'htq_single_page_option', 'single-quiz' );
// add_option( 'htq_result_page_option', 'quiz-result' );
add_option( 'htq_invalid_quiz_message', 'Something went wrong!!' );

/****************************
* Creating table for user records
*****************************/

$htq_user_records = $wpdb->prefix . 'htq_user_records';
$query = "CREATE TABLE $htq_user_records(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `quiz_id` VARCHAR(250) NOT NULL ,
  PRIMARY KEY (`id`)
)";

require_once(ABSPATH ."wp-admin/includes/upgrade.php");
dbDelta( $query );

?>