jQuery(document).ready(function(){

	/**********************************
	 * Model popup
	 **********************************/
	// Get the modal
	var modal = document.getElementById("job_detail_myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("btn_job_apply");
	var btn2 = document.getElementById("btn_job_apply2");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("job_detail_close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	}
	btn2.onclick = function() {
	  modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}

	/**********************************
	 * Job Detail page form submission
	 **********************************/
	 jQuery('#job_detail_form').on('submit', function(e){
	 	e.preventDefault();

	 	var fileInputElement = document.getElementById("job_detail_resume2");
	 	var job_detail_online_resume = jQuery('#job_detail_online_resume').val();
	 	
	 	if ( job_detail_online_resume == 'null' && fileInputElement.files.length == 0 ) {

	 		jQuery('p.upload_err').text('*Please upload your resume or select from online resume if available');
	 		return false;

	 	}else{

	 		/*jQuery.each(jQuery('#job_detail_resume2').prop("files"), function(k,v){
		        var filename = v['name'];    
		        var ext = filename.split('.').pop().toLowerCase();
		        if($.inArray(ext, ['pdf']) == -1) {
		            jQuery('p.upload_err').text('*Please upload PDF file only');
	 				return false;
		        }else{}
		    });*/
			 
	 		jQuery.ajax({
		 		url:htjl.ajaxurl,
				type:"POST",
				processData: false,
				contentType: false,
				data: new FormData(this),
				success : function( response ){
					var returnedData = JSON.parse(response);
					if(returnedData.code == 200){
						jQuery('div.job_application_form').html('<p class="success_application">Your application has been submitted successfully.</p>');
					}else{
						alert(returnedData.msg);
					}
				},
		 	});

	 	}

		 	
	});

	jQuery("#job_detail_resume2").change(function() {
    	var filename = jQuery('#job_detail_resume2').val().split('\\').pop();
    	if ( filename != '' ) {
    		jQuery('.htjl_upload_success').text(filename);
    	}else{
    		jQuery('.htjl_upload_success').text('Choose a file');
    	}
    });
});