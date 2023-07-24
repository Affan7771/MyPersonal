<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

$invalid_message = get_option('htq_invalid_quiz_message');

?>
<style type="text/css">
	p.htq_status {
	    color: green;
	    font-size: 18px;
	    margin: 0;
	    font-weight: 500;
	}
</style>
<div class="wrap">
  	<h1>HT Quiz</h1>
  	<h3>Quiz Shortcodes</h3>
  	<hr>
  	<table class="form-table">
	  	<tr valign="top">
		  	<th scope="row"><label for="ht_quiz_listing">Quiz Listing</label></th>
	  		<td>
	  			<input type="text" id="ht_quiz_listing" name="ht_quiz_listing" value="[ht_quiz]" readonly />
	  		</td>
	  	</tr>
	  	<tr valign="top">
		  	<th scope="row"><label for="ht_quiz_single">Single Quiz</label></th>
	  		<td>
	  			<input type="text" id="ht_quiz_single" name="ht_quiz_single" value="[ht_single_quiz]" readonly />
	  		</td>
	  	</tr>
	  	<!-- <tr valign="top">
		  	<th scope="row"><label for="ht_quiz_single">Quiz Result</label></th>
	  		<td>
	  			<input type="text" id="ht_quiz_single" name="ht_quiz_single" value="[ht_quiz_result]" readonly />
	  		</td>
	  	</tr> -->
  	</table>
  	<hr>
  	<h3>Select Quiz Listing Page</h3>
	<select name="htq_listing_page" id="htq_listing_page">
	    <?php
	        $selected_page = get_option( 'htq_listing_page_option' );
	        $pages = get_pages(); 
	        foreach ( $pages as $page ) {
	            $option = '<option value="' . $page->post_name . '" ';
	            $option .= ( $page->post_name == $selected_page ) ? 'selected="selected"' : '';
	            $option .= '>';
	            $option .= $page->post_title;
	            $option .= '</option>';
	            echo $option;
	        }
	    ?>
	</select><br>

  	<h3>Select Single Quiz Page</h3>
	<select name="htq_all_pages" id="htq_all_pages">
	    <?php
	        $selected_page = get_option( 'htq_single_page_option' );
	        $pages = get_pages(); 
	        foreach ( $pages as $page ) {
	            $option = '<option value="' . $page->post_name . '" ';
	            $option .= ( $page->post_name == $selected_page ) ? 'selected="selected"' : '';
	            $option .= '>';
	            $option .= $page->post_title;
	            $option .= '</option>';
	            echo $option;
	        }
	    ?>
	</select><br>

	<!-- <h3>Select Quiz Result Page</h3>
	<select name="htq_result_page" id="htq_result_page">
	    <?php
	        $selected_page = get_option( 'htq_result_page_option' );
	        $pages = get_pages(); 
	        foreach ( $pages as $page ) {
	            $option = '<option value="' . $page->post_name . '" ';
	            $option .= ( $page->post_name == $selected_page ) ? 'selected="selected"' : '';
	            $option .= '>';
	            $option .= $page->post_title;
	            $option .= '</option>';
	            echo $option;
	        }
	    ?>
	</select><br> -->
	<p style="font-size:15px;"><b>Note :</b> Please Select different pages for different shortcodes.</p>
	<hr>
	<table class="form-table">
	  	<tr valign="top">
		  	<th scope="row"><label for="ht_quiz_invalid">Invalid Quiz Message</label></th>
	  		<td>
	  			<input type="text" id="ht_quiz_invalid" name="ht_quiz_invalid" value="<?php echo $invalid_message; ?>" />
	  		</td>
	  	</tr>
  	</table>
	<button id="htq_single_page_selection" class="button button-primary">Save Changes</button>
	<p class="htq_status"></p> 
</div><!-- .wrap -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		localStorage.setItem('ht_quiz_listing', 'quiz-listing');
		localStorage.setItem('ht_quiz_single', 'single-quiz');
		//localStorage.setItem('ht_quiz_result', 'quiz-result');

		jQuery('#htq_listing_page').change(function(){
			var value = jQuery(this).val();
			localStorage.setItem('ht_quiz_listing', value);
		});

		jQuery('#htq_all_pages').change(function(){
			var value = jQuery(this).val();
			localStorage.setItem('ht_quiz_single', value);
		});

		/*jQuery('#htq_result_page').change(function(){
			var value = jQuery(this).val();
			localStorage.setItem('ht_quiz_result', value);
		});*/

		jQuery('#htq_single_page_selection').click(function(){
			var listing = localStorage.getItem('ht_quiz_listing');
			var single = localStorage.getItem('ht_quiz_single');
			//var result = localStorage.getItem('ht_quiz_result');
			var invalid_message = jQuery('#ht_quiz_invalid').val();
			jQuery.ajax({
		   		type : "get",
				dataType : "json",
				url : '<?php echo admin_url('admin-ajax.php'); ?>',
				data : {
					action: "htq_choice_answer",
					listing: listing,
					single: single,
					invalid_message: invalid_message,
					// result: result,
					htq_type: 'htq_quiz_option',
				},
				success : function( response ) {
					jQuery('.htq_status').text(response.status);
					setTimeout(function(){ jQuery('.htq_status').text(''); }, 3000);
				}
		  });
		});
	})
</script>