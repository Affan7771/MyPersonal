jQuery(document).ready(function($){

	check_button_text();

	pageSize = 15;

	var pageCount =  jQuery(".border-top.row.mx-2").length / pageSize;
    
    jQuery(".pagination.pagination-sm").append('<li class="page-item disabled"><a href="" class="page-link" aria-label="Previous" tabindex="-1" aria-disabled="true"><span aria-hidden="true">«</span></a></li>');

     for(var i = 0 ; i<pageCount; i++){
        
       jQuery(".pagination.pagination-sm").append('<li class="page-item" aria-current="page"><a class="page-link" href="#">'+(i+1)+'</a></li> ');
     }
        jQuery(".pagination.pagination-sm li").first().find("a").addClass("current");
    showPage = function(page) {
	    jQuery(".border-top.row.mx-2").hide();
	    jQuery(".border-top.row.mx-2").each(function(n) {
	        if (n >= pageSize * (page - 1) && n < pageSize * page)
	            jQuery(this).show();
	    });        
	}
    
	showPage(1);

	jQuery(".pagination.pagination-sm").append('<li class="page-item disabled"><a href="" class="page-link" aria-label="Next" tabindex="-1" aria-disabled="true"><span aria-hidden="true">»</span></a></li>');

	jQuery(".pagination.pagination-sm li a").click(function() {
	    jQuery(".pagination.pagination-sm li a").removeClass("current");
	    jQuery(this).addClass("current");
	    showPage(parseInt(jQuery(this).text())); 
	});

  /* Code for Quiz Show */

  jQuery('body').on('click', '.fa.fa-chevron-circle-down', function () {
  	jQuery(this).next('.fa.fa-chevron-circle-up').show();
	jQuery(this).hide();
    jQuery(this).closest('.border-top').find('.inner-expansion').addClass('active');
    jQuery(this).closest('.border-top').find('.inner-expansion.active').show();
  });

  jQuery('body').on('click', '.fa.fa-chevron-circle-up', function () {
  	jQuery(this).prev('.fa.fa-chevron-circle-down').show();
	jQuery(this).hide();
    jQuery(this).closest('.border-top').find('.inner-expansion').removeClass('active');
    jQuery(this).closest('.border-top').find('.inner-expansion').hide();
  });

  jQuery('div.loader').hide();

  jQuery(document).on('click','button.button-mcq', function(){
	  var answer_id = jQuery('#radio_val').val();
	  var quiz_id = jQuery('#single_quiz_id').val();

	  jQuery.ajax({
	   	type : "get",
			dataType : "json",
			url : htq.ajaxurl,
			data : {
				action: "htq_choice_answer",
				answer_id: answer_id,
				quiz_id: quiz_id,
				htq_type: 'choice_type',
			},
			beforeSend: function() {
        jQuery('div.loader').show();
        jQuery('.mcq-options').css('opacity', '0.5');
        jQuery('button.button-mcq').addClass('disable');
				jQuery('button.button-mcq').attr('disabled', 'disabled');

    	},
			success : function( response ) {
				jQuery('div.loader').hide();
				jQuery('.mcq-options').css('opacity', '1');
				// jQuery('.single-quiz-container').html(response.new_question);
				jQuery('.question-wrapper').html(response.new_question);
				check_button_text();
				check_radio();             
			}
	  });
	});

  jQuery(document).on('click','button.submit_result', function(){
		var answer_id = jQuery('#radio_val').val();
	  var quiz_id = jQuery('#single_quiz_id').val();
	  jQuery.ajax({
	   	type : "get",
			dataType : "json",
			url : htq.ajaxurl,
			data : {
				action: "htq_choice_answer",
				answer_id: answer_id,
				quiz_id: quiz_id,
				htq_type: 'choice_type_submit',
			},
			beforeSend: function() {
        jQuery('div.loader').show();
        jQuery('.mcq-options').css('opacity', '0.5');
        jQuery('button.submit_result').addClass('disable');
				jQuery('button.submit_result').attr('disabled', 'disabled');

    	},
			success : function( response ) {
				jQuery('div.loader').hide();
				jQuery('.question-wrapper').html(response.message);
				return false;
				//window.location.href = response.site +'?result='+ response.message;
			}
	  });
	});

	jQuery(document).on('click', 'button.try_again_btn', function(){
		location.reload(true);
	})

	function check_button_text(){
		var current_question = jQuery('#current_question').val();
	  var total_question = jQuery('#total_question').val();

	  if (current_question == total_question ) {
	  	jQuery('button.button-mcq').text('Submit');
	  	jQuery('button.button-mcq').addClass('submit_result');
	  	jQuery('button.button-mcq').removeClass('button-mcq');
	  	
	  }else{
	  	jQuery('button.button-mcq').text('Next');

	  }
	}

	function check_radio(){
		jQuery('.single-quiz-container input[type="radio"]').change(function(){
			//alert(jQuery(this).attr('id'));
			jQuery('#radio_val').val(jQuery(this).attr('id'));
			/*jQuery('input[type="radio"]').removeAttr('checked');
			jQuery(this).attr('checked', 'checked');*/
			jQuery('button.button-mcq').removeClass('disable');
			jQuery('button.button-mcq').removeAttr('disabled');

			jQuery('button.submit_result').removeClass('disable');
			jQuery('button.submit_result').removeAttr('disabled');
		});
	}

	jQuery(document).on('change','select#htq_progress', function(){
		jQuery('option:selected', this).attr('selected','selected').siblings().removeAttr('selected');
		var value = jQuery(this).val();
		var question_type = jQuery('#htq_type').val();
		var difficulty = jQuery('#htq_difficulty').val();
		jQuery.ajax({
			type : "get",
			dataType : "json",
			url : htq.ajaxurl,
			data : {
				action: "htq_choice_answer",
				value: value,
				question_type: question_type,
				difficulty: difficulty,
				htq_type: 'htq_filter_progress',
			},
			success : function( response ) {
				jQuery('div.htq_quiz_listing_container').html(response.output);
			}
		});
	});

	jQuery(document).on('change','select#htq_type', function(){
		jQuery('option:selected', this).attr('selected','selected').siblings().removeAttr('selected');
		var value = jQuery(this).val();
		var progress = jQuery('#htq_progress').val();
		var difficulty = jQuery('#htq_difficulty').val();
		jQuery.ajax({
			type : "get",
			dataType : "json",
			url : htq.ajaxurl,
			data : {
				action: "htq_choice_answer",
				value: value,
				progress: progress,
				difficulty: difficulty,
				htq_type: 'htq_filter_type',
			},
			success : function( response ) {
				jQuery('div.htq_quiz_listing_container').html(response.output);
			}
		});
	});

	jQuery(document).on('change','select#htq_difficulty', function(){
		jQuery('option:selected', this).attr('selected','selected').siblings().removeAttr('selected');
		var value = jQuery(this).val();
		var progress = jQuery('#htq_progress').val();
		var question_type = jQuery('#htq_type').val();
		jQuery.ajax({
			type : "get",
			dataType : "json",
			url : htq.ajaxurl,
			data : {
				action: "htq_choice_answer",
				value: value,
				progress: progress,
				question_type: question_type,
				htq_type: 'htq_filter_difficulty',
			},
			success : function( response ) {
				jQuery('div.htq_quiz_listing_container').html(response.output);
			}
		});
	});

});