<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

$endpoint = 'companies/86c06169-6407-469d-88aa-678d992eed52';
$get_listing = htjl_job_listing($endpoint);
$count = 1;
$cover_img = bp_get_group_cover_url();
if ( empty($cover_img) ) {
	$img = 'null'; 
}else{
	$cover_img = base64_encode($cover_img);
	$img = $cover_img;
}

$group_id = bp_get_current_group_id();
$group_id = base64_encode($group_id);

?>
<div class="htjl_container">

	<!-- <div class="htjl_heading"><h2>Open Jobs</h2></div> -->
	<?php foreach($get_listing->jobs as $jobs){ ?>
		<?php if ( $count == 6 ) { return false; } ?>
		<!-- <input type="hidden" name="job_id" value="<?php //echo $jobs->id; ?>">
		<input type="hidden" name="cover" value="<?php //echo $img; ?>"> -->
		<div class="htjl_listing">
			<div class="job_name"><a href="<?php echo site_url().'/job-detail/?job_id='.$jobs->id.'&group_id='.$group_id ?>"><?php echo $jobs->title; ?></a></div>
			<div class="job_location">
				<i class="bb-icon-map-pin" aria-hidden="true"></i> <?php echo $jobs->location; ?>
			</div><!-- .job_location -->
		</div><!-- .htjl_listing -->
	<?php $count++; } ?>
	
</div><!-- .htjl_container -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		var img_url = '<?php echo $img; ?>';
		var group_id = '<?php echo $group_id; ?>';
		
		jQuery.ajax({
	 		url:htjl.ajaxurl,
			type:"POST",
			data: {
				action: 'htjl_add_group_data',
				img_url: img_url,
				group_id: group_id
			},
			success : function( response ){
				console.log(response);
			},
	 	});
	});
</script>