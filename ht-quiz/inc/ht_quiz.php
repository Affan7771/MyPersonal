<?php

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
$listing_endpoint = 'quizes/public?limit=999&session_id='.get_current_user_id();
$quiz_listing = htq_quiz_api($listing_endpoint);
$single_option = get_option( 'htq_single_page_option' );
$disable = '';
if ( !is_user_logged_in() ) {
	$disable = 'disabled';
}
?>
<div class="container">
	<div class="row pt-3 mt-2">
		<div class="col-12 col-md-10 htq_listing_box">
			<div class="row mx-2 font-size-12 pb-20">
				<div class="col-md-3 d-none d-md-block p-0 htq_filter_option"> Filter Options: </div>
				<div class="col-md-3 px-0 htq-pd-10">
					<select id="htq_progress" class="form-control-sm custom-select htq_filter px-0 ng-pristine ng-valid ng-touched" <?php echo $disable; ?>>
						<option value="all" selected="selected">All Progress</option>
						<option value="completed">Completed</option>
						<option value="in-progress">In Progress</option>
						<option value="not-attempted">Not Attempted</option>
					</select>
				</div>

				<div class="col-md-3 px-0 htq-pd-10">
					<select id="htq_type" class="form-control-sm custom-select htq_filter px-0 ng-untouched ng-pristine ng-valid" <?php echo $disable; ?>>
						<option value="all" selected="selected">All Question Type</option>
						<option value="mcq">MCQ</option>
						<option value="coding">Coding Challenge</option>
					</select>
				</div>

				<div class="col-md-3 px-0 htq-pd-10">
					<select id="htq_difficulty" class="form-control-sm custom-select htq_filter px-0 ng-untouched ng-pristine ng-valid" <?php echo $disable; ?>>
						<option value="all" selected="selected">All Difficulty</option>
						<option value="easy">Easy</option>
						<option value="medium">Medium</option>
						<option value="hard">Hard</option>
					</select>
				</div>
			</div>
			<div class="row mx-2">
				<div class="htq-table-header-row flex-fill d-flex justify-content-between mb-2">
					<div class="col-3 col-md-1 p-0 font-size-20 text-left htq_head"> No. </div>
					<div class="col-6 col-md-4 font-size-20 p-0 htq_head"> Title </div>
					<div class="col-md-2 font-size-20 d-none d-md-block p-0 htq_head"> Progress </div>
					<div class="col-md-2 font-size-20 d-none d-md-block p-0 htq_head"> Question Type </div>
					<div class="col-md-2 font-size-20 d-none d-md-block p-0 htq_head"> Difficulty </div>
					<div class="col-3 col-md-1 font-weight-bold"></div>
				</div>
			</div>

			<div style="font-size: 1em !important;" class="htq_quiz_listing_container">

				<?php 
				$count = 1;
				if (!empty($quiz_listing->results) && is_user_logged_in() ) {
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
					?>
						<form method='get' action='<?php echo site_url( "/$single_option/" ); ?>'>
							<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
							<div class="border-top row mx-2">
								<div class="col-3 col-md-1 px-2 text-left"> <?php echo $count; ?> </div>
								<div class="col-6 col-md-4 p-0"> <?php echo ucwords($result->title); ?> </div>
								<div class="col-md-2 d-none d-md-block p-0">
									<span><?php echo ucwords(str_replace('-', ' ', $result->progress)); ?></span>
								</div>

								<div class="col-md-2 d-none d-md-block p-0">
									<span><?php echo strtoupper($result->question_type); ?></span>
								</div>

								<div class="col-md-2 d-none d-md-block p-0">
									<div class="difficulty-btn d-inline-flex <?php echo $difficulty_color; ?>">
										<span><?php echo ucwords($result->difficulty); ?></span>
									</div>
								</div>

								<div class="col-3 col-md-1">
									<i aria-hidden="true" class="fa fa-chevron-circle-down size-icon text-arrow"></i>
									<i aria-hidden="true" class="fa fa-chevron-circle-up size-icon text-arrow"></i>
								</div>

								<div class="col-md-11 p-0 align-items-start">
									
									<!-- Tab Open Code -->
									<div class="inner-expansion mb-4" style="display: none;">
										<div class="my-2 htq_time_question">
											<i aria-hidden="true" class="fa fa-clock-o mr-2 mt-1"></i>
											<span> <?php echo $result->time_in_minutes; ?> Minutes</span>
										</div>

										<div class="my-2 htq_time_question">
											<i aria-hidden="true" class="fa fa-list-ul mr-2 mt-1"></i>
											<span> <?php echo $result->total_question_count; ?> Questions </span>
										</div>
										<div class="htq_practice_challenge_quote"><p>This practice challenge contains questions on:</p></div>
										<!-- Tab Open Code -->

										<div class="row mx-0">
											<div class="d-flex mb-2 topic-tag">
												<span class="tags">Modern </span> 
											</div>
											<div class="d-flex mb-2 topic-tag">
												<span class="tags">Web Development</span> 
											</div>
										</div>
													
										<div class="mt-2">
											<div class="qn-prev-inner width-100p">
												<h5 class="font-weight-bold"> Preview Question </h5>
												<div class="question">
													<?php echo $result->preview_question; ?>
												</div>
											
												<div class="mt-4">
													<button type="submit" class="btn btn-primary btn-sm" tabindex="0">Solve Challenge</button>
												</div>
											</div>
										</div>
								    </div>
								</div>
							</div>
						</form>
					<?php 
						$count++;
					} // endforeach	
				}else{
					echo "<h4 style='text-align:center;'>Please login to solve quiz</h4>";
				}
				?>

			</div>
		</div> <!-- .htq_listing_box -->
		<div class="col-md-10 col-sm-12 pagination-row d-flex my-2 mr-2 bg-page">
			<div class="mr-auto"></div>
			<ngb-pagination role="navigation" aria-label="Default pagination" size="sm">
				<ul class="pagination pagination-sm">
				</ul>
		    </ngb-pagination>
		</div><!-- .pagination-row -->
	</div> <!-- .row -->
</div> <!-- .container -->