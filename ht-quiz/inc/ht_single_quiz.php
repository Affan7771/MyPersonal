<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if

$invalid_message = get_option('htq_invalid_quiz_message');
if ( empty($invalid_message) ) {
	$invalid_message = 'Something went wrong!!';
}

if ( is_user_logged_in() ) {
	
	if ( !empty($_REQUEST['quiz_id']) ) {

		$quiz_id = $_REQUEST['quiz_id'];
		$single_quiz_endpoint = 'quizes/public/mcq/' .$quiz_id. '?session_id=' .get_current_user_id();
		$quiz_listing = htq_quiz_api($single_quiz_endpoint);
		$listing_link = get_option( 'htq_listing_page_option' );
		if ( !empty($quiz_listing) ) {

			$difficulty_color = '';
			if ( $quiz_listing->difficulty == 'easy' ) {
				$difficulty_color = 'green-easy';
			}elseif ( $quiz_listing->difficulty == 'medium' ) {
				$difficulty_color = 'amber-medium';
			}else{
				$difficulty_color = 'red-hard';
			}

			?>
			<style type="text/css">
				.loader{
					background-image: url('<?php echo site_url().'/wp-content/plugins/ht-quiz/assets/images/loader.gif'; ?>');
				}
			</style>
			<div class="single-quiz-container">
				<div class="quiz_title">
					<span><?php echo ucwords($quiz_listing->quiz); ?></span>
					<span class="quiz_difficulty <?php echo $difficulty_color; ?>"><?php echo ucwords($quiz_listing->difficulty); ?></span>
				</div>
				<div class="my-2 htq_time_question">
					<i aria-hidden="true" class="fa fa-clock-o mr-2 mt-1"></i>
					<span class="countdown"> <?php echo $quiz_listing->time_in_minutes; ?> Minutes</span>
				</div>

				<div class="my-2 htq_time_question">
					<i aria-hidden="true" class="fa fa-list-ul mr-2 mt-1"></i>
					<span> <?php echo $quiz_listing->total_question_count; ?> Questions </span>
				</div>
				<div class="row ml-2 my-2 htq_practice_quote"> This practice challenge contains questions on: </div>
				<div class="row mx-0">
					<div class="d-flex mb-2 topic-tag">
						<span class="tags">Modern </span>  
					</div>
					<div class="d-flex mb-2 topic-tag">
						<span class="tags">Web Development</span> 
					</div>
				</div>
				<div class="py-3 htq_practice_quote"> 
					You will have to read and understand the question and select the correct answer. Once you have chosen your answer, click next to move on to the next question in the practice. 
				</div>

				<div class="ml-2 mt-1 question-wrapper htq_none">
					<input type="hidden" id="single_quiz_id" value="<?php echo $quiz_id; ?>">
					<input type="hidden" id="current_question" value="<?php echo $quiz_listing->current_question_count; ?>">
					<input type="hidden" id="total_question" value="<?php echo $quiz_listing->total_question_count; ?>">
					<input type="hidden" id="radio_val">
					<div class="mb-2 htq_remain_question"> 
						Question <?php echo $quiz_listing->current_question_count; ?> of <?php echo $quiz_listing->total_question_count; ?>
					</div>
					<div class="my-2 question-inner">
						<p><?php echo $quiz_listing->question; ?></p>
					</div><!-- .question-inner -->
					<div class="choice-wrapper">
						<div class="loader"></div>
						<?php foreach ($quiz_listing->choices as $value) { ?>
							<div class="mcq-options">
								<label for="answer_<?php echo $value->id; ?>">
									<input type="radio" name="htq_choices" id="answer_<?php echo $value->id;?>" class="ng-valid ng-dirty ng-touched">
									<div class="htq-p-inline"><?php echo $value->choice; ?></div>
								</label>
							</div>
						<?php } //endforeach ?>
					</div>
					<div class="mt-3 htq_next_button">
						<button class="btn btn-primary btn-sm button-mcq disable" disabled=""> Next </button>
					</div>
				</div><!-- .question-wrapper -->
			</div><!-- .single-quiz-container -->
		<?php 
		}else{
			echo "<center><h3>".$invalid_message."</h3>";
			echo '<a href="'.site_url().'/'.$listing_link.'" style="color: #f66700;"><u>Back to Challenge Listing</u></a></center>';
		}
	} //endif 

}else{
	echo "<center>";
	echo "<h3>You must be logged in to solve the quiz</h3>";
	echo '<a href="'.site_url().'/'.$listing_link.'" style="color: #f66700;"><u>Back to Challenge Listing</u></a>';
	echo "</center>";
}
?>
	
<script>
    jQuery(document).ready(function(){

        jQuery('.single-quiz-container input[type="radio"]').change(function(){
			jQuery('#radio_val').val(jQuery(this).attr('id'));
			jQuery('button.button-mcq').removeClass('disable');
			jQuery('button.button-mcq').removeAttr('disabled');
		});

		/*jQuery(document).on('click','button.submit_result', function(){
			clearInterval(timer2);
		    timer2 = null;
		});

		jQuery(document).on('click', '.htq_all_question_link a', function(){
			clearInterval(timer2);
		    timer2 = null;
		});

		function if_times_up(){
			var url = '<?php //echo site_url().'/'.$listing_link; ?>';
			Swal.fire({
			  icon: 'error',
			  title: "Oops... Time's up!!!",
			  text: 'Better luck next time',
			  footer: '<a href="'+url+'">Click Here </a><span style="padding-left:5px;">to go to challenge listing page</span>',
			  showConfirmButton: false
			});

			jQuery('.mt-3.htq_next_button').html('');
			jQuery('.question-wrapper.htq_none').css('display','none');
		}

		var timer2 = "10:00";
		var interval = setInterval(function() {
			if ( timer2 != null ) {
				var timer = timer2.split(':');
				//by parsing integer, I avoid all extra string processing
				var minutes = parseInt(timer[0], 10);
				var seconds = parseInt(timer[1], 10);
				--seconds;
				minutes = (seconds < 0) ? --minutes : minutes;
				seconds = (seconds < 0) ? 59 : seconds;
				seconds = (seconds < 10) ? '0' + seconds : seconds;
				//minutes = (minutes < 10) ?  minutes : minutes;
				$('.countdown').html(minutes + ':' + seconds + ' Time Remaining');
				if (minutes < 0) clearInterval(interval);
				//check if both minutes and seconds are 0
				if ((seconds <= 0) && (minutes <= 0)){
				clearInterval(
					interval,
				    //alert("times up"));
				    if_times_up()
				);
				
				}
				timer2 = minutes + ':' + seconds;
			}
			  
		}, 1000);*/
    });
</script>