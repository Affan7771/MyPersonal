<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
global $wpdb;

$htq_type = $_GET['htq_type'];

if ( $htq_type == 'choice_type' ) {

	$answer_id = $_GET['answer_id'];
	$quiz_id = $_GET['quiz_id'];
	$answer_id = str_replace('answer_', '', $answer_id);

	$endpoint = 'quizes/public/mcq/'. $quiz_id .'?session_id='.get_current_user_id();
	$req = htq_quiz_api($endpoint, 'POST', $answer_id);
	$new_question = htq_quiz_api($endpoint);
	$difficulty_color = '';
	if ( $new_question->difficulty == 'easy' ) {
		$difficulty_color = 'green-easy';
	}elseif ( $new_question->difficulty == 'medium' ) {
		$difficulty_color = 'amber-medium';
	}else{
		$difficulty_color = 'red-hard';
	}
	$output = '';

	$output .= '<input type="hidden" id="single_quiz_id" value="'.$quiz_id.'">';
	$output .= '<input type="hidden" id="current_question" value="'.$new_question->current_question_count.'">';	
	$output .= '<input type="hidden" id="total_question" value="'.$new_question->total_question_count.'">';	
	$output .= '<input type="hidden" id="radio_val">';		
	$output .= '<div class="mb-2 htq_remain_question"> Question '.$new_question->current_question_count.' of '.$new_question->total_question_count.'</div>';	
	$output .= '<div class="my-2 question-inner"><p>'.$new_question->question.'</p></div>';	
	$output .= '<div class="choice-wrapper">';
		$output .= '<div class="loader" style="display:none;"></div>';
		foreach ($new_question->choices as $value) {
			$output .= '<div class="mcq-options">';
				$output .= '<label for="answer_'.$value->id.'">';
					$output .= '<input type="radio" name="htq_choices" id="answer_'.$value->id.'" class="ng-valid ng-dirty ng-touched">';
					$output .= '<div class="htq-p-inline">'.$value->choice.'</div>';
				$output .= '</label">';
			$output .= '</div>';
		}
	$output .= '</div>';
	//$output .= '<div class="mt-3 htq_previous_button"><button class="btn btn-primary btn-sm button-previous"> Previous </button></div>';
	$output .= '<div class="mt-3 htq_next_button"><button class="btn btn-primary btn-sm button-mcq disable" disabled=""> Next </button></div>';	

	echo json_encode(array(
		'new_question'	=> $output,
	));
}

elseif ( $htq_type == 'htq_quiz_option' ) {
	
	$listing = $_GET['listing'];
	$single = $_GET['single'];
	//$result = $_GET['result'];
	$invalid_message = $_GET['invalid_message'];

	update_option( 'htq_listing_page_option', $listing );
	update_option( 'htq_single_page_option', $single );
	//update_option( 'htq_result_page_option', $result );
	update_option( 'htq_invalid_quiz_message', $invalid_message );
	echo json_encode( array(
		'status'	=> 'Updated',
	) );
}

elseif ( $htq_type == 'choice_type_submit' ) {
	
	$answer_id = $_GET['answer_id'];
	$quiz_id = $_GET['quiz_id'];
	$answer_id = str_replace('answer_', '', $answer_id);

	$endpoint = 'quizes/public/mcq/'. $quiz_id .'?session_id='.get_current_user_id();
	$req = htq_quiz_api($endpoint, 'POST', $answer_id);
	$result_page = get_option('htq_result_page_option');
	//$site = site_url().'/'.$result_page;
	$htq_user_records = $wpdb->prefix . 'htq_user_records';
	$user_id = get_current_user_id();
	$listing_link = get_option( 'htq_listing_page_option' );
	$checkIfExists = $wpdb->get_var("SELECT * FROM $htq_user_records WHERE user_id = '".$user_id."' AND quiz_id = '".$quiz_id."' ");
	if ($checkIfExists == NULL) {

		$wpdb->insert($htq_user_records, array(
			'user_id'	=> $user_id,
			'quiz_id' 	=> $quiz_id,
		), array(
			'%d', '%s',
		));

	}

	$output = '';
	$output .= '<div class="success_msg_head"><h3>Congratulations!</h3></div>';
	$output .= '<p class="success_msg">'.$req->message.'</p>';
	$output .= '<div class="htq_result_btn">';
		$output .= '<button class="btn btn-primary try_again_btn">Try Again</button>';
		//$output .= '<button class="btn btn-primary view_answer_btn">View Answer</button>';
	$output .= '</div>';
	$output .= '<div class="htq_all_question_link">';
		$output .= '<a href="'.site_url().'/'.$listing_link.'">Back to Challenge Listing</a>';
	$output .= '</div>';

	echo json_encode(array(
		'message'	=> $output,
		//'site'		=> $site,
	));
}

elseif ( $htq_type == 'htq_filter_progress' ) {
	$value = $_GET['value'];
	$question_type = $_GET['question_type'];
	$difficulty = $_GET['difficulty'];
	$param = '&progress='.$value.'&question_type='.$question_type.'&difficulty='.$difficulty;
	$output = htq_filter_output($param);

	echo json_encode(array(
		'output'	=> $output,
	));
}

elseif ( $htq_type == 'htq_filter_type' ){

	$value = $_GET['value'];
	$progress = $_GET['progress'];
	$difficulty = $_GET['difficulty'];
	$param = '&question_type='.$value.'&progress='.$progress.'&difficulty='.$difficulty;
	$output = htq_filter_output($param);

	echo json_encode(array(
		'output'	=> $output,
	));

}

elseif ( $htq_type = 'htq_filter_difficulty' ) {
	
	$value = $_GET['value'];
	$progress = $_GET['progress'];
	$question_type = $_GET['question_type'];
	$param = '&difficulty='.$value.'&progress='.$progress.'&question_type='.$question_type;
	$output = htq_filter_output($param);

	echo json_encode(array(
		'output'	=> $output,
	));

}

function htq_filter_output($param){

	$user_id = get_current_user_id();
	$endpoint = 'quizes/public?limit=999&session_id='.$user_id.''.$param;
	$quiz_listing = htq_quiz_api($endpoint);
	
	$output = '';
	$single_option = get_option( 'htq_single_page_option' );
	$count = 1;
	if ( !empty($quiz_listing->results) ) {
		
		foreach ($quiz_listing->results as $result) {
			$difficulty_color = '';
			if ( $result->difficulty == 'easy' ) {
				$difficulty_color = 'green-easy';
			}elseif ( $result->difficulty == 'medium' ) {
				$difficulty_color = 'amber-medium';
			}else{
				$difficulty_color = 'red-hard';
			}
			$quiz_id = $result->id;

			$output .= '<form method="get" action="'.site_url( "/$single_option/" ).'">';
				$output .= '<input type="hidden" name="quiz_id" value="'.$quiz_id.'">';
				$output .= '<div class="border-top row mx-2">';
					$output .= '<div class="col-3 col-md-1 px-2 text-left">'.$count.'</div>';
					$output .= '<div class="col-6 col-md-4 p-0">'.ucwords($result->title).'</div>';
					$output .= '<div class="col-md-2 d-none d-md-block p-0">';
						$output .= '<span>'.ucwords(str_replace('-', ' ', $result->progress)).'</span>';
					$output .= '</div>';
					$output .= '<div class="col-md-2 d-none d-md-block p-0">';
						$output .= '<span>'.strtoupper($result->question_type).'</span>';
					$output .= '</div>';
					$output .= '<div class="col-md-2 d-none d-md-block p-0">';
						$output .= '<div class="difficulty-btn d-inline-flex font-size-12 '.$difficulty_color.'">';
							$output .= '<span>'.ucwords($result->difficulty).'</span>';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="col-3 col-md-1">';
						$output .= '<i aria-hidden="true" class="fa fa-chevron-circle-down size-icon text-arrow"></i>';
						$output .= '<i aria-hidden="true" class="fa fa-chevron-circle-up size-icon text-arrow"></i>';
					$output .= '</div>';
					$output .= '<div class="col-md-12 p-0 align-items-start">';
						$output .= '<div class="inner-expansion mb-4" style="display: none;">';
							$output .= '<div class="my-2 htq_time_question">';
								$output .= '<i aria-hidden="true" class="fa fa-clock-o mr-2 mt-1"></i>';
								$output .= '<span>'.$result->time_in_minutes.' Minutes</span>';
							$output .= '</div>';
							$output .= '<div class="my-2 htq_time_question">';
								$output .= '<i aria-hidden="true" class="fa fa-list-ul mr-2 mt-1"></i>';
								$output .= '<span>'.$result->total_question_count.' Questions</span>';
							$output .= '</div>';
							$output .= '<div class="htq_practice_challenge_quote"><p>This practice challenge contains questions on:</p></div>';
							$output .= '<div class="row mx-0">';
								$output .= '<div class="d-flex mb-2 topic-tag">';
									$output .= '<span class="tags">Modern </span>';
								$output .= '</div>';
								$output .= '<div class="d-flex mb-2 topic-tag">';
									$output .= '<span class="tags">Web Development</span>';
								$output .= '</div>';
							$output .= '</div>';
							$output .= '<div class="mt-2">';
								$output .= '<div class="qn-prev-inner width-100p">';
									$output .= '<h5 class="font-weight-bold"> Preview Question </h5>';
									$output .= '<div class="question">'.$result->preview_question.'</div>';
									$output .= '<div class="mt-4">';
										$output .= '<button type="submit" class="btn btn-primary btn-sm" tabindex="0">Solve Challenge</button>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</form>';
			$count++;
		}
	}else{
		$output .= '<h5 style="text-align:center;">No Data Found</h5>';
	}

	return $output;

}

wp_die();

?>