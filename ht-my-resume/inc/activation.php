<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
global $wpdb;

/****************************
* Creating table for user resume
*****************************/

$htmr_user_resume = $wpdb->prefix . 'htmr_user_resume';
$query = "CREATE TABLE $htmr_user_resume(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `resume_url` TEXT NOT NULL ,
  `file_name` VARCHAR(250) NOT NULL ,
  `modified` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`)
)";

require_once(ABSPATH ."wp-admin/includes/upgrade.php");
dbDelta( $query );

?>