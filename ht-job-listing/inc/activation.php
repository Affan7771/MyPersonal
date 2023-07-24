<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
global $wpdb;

/****************************
* Creating table for job id and username
*****************************/

$htjl_job_listing = $wpdb->prefix . 'htjl_job_listing';
$query = "CREATE TABLE $htjl_job_listing(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `group_id` TEXT NOT NULL ,
  `img_url` TEXT NOT NULL ,
  PRIMARY KEY (`id`)
)";

require_once(ABSPATH ."wp-admin/includes/upgrade.php");
dbDelta( $query );


/****************************
* Creating job detail page
*****************************/
$page = get_page_by_title( 'Job Detail' );
if ( !$page ) {
  
  $my_post = array(
    'post_title'    => wp_strip_all_tags( 'Job Detail' ),
    'post_content'  => '[company_job_detail]',
    'post_status'   => 'publish',
    'post_author'   => get_current_user_id(),
    'post_type'     => 'page',
  );

  // Insert the post into the database
  wp_insert_post( $my_post );

}

?>