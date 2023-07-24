jQuery(document).ready(function(){

	/**********************************/
	/* User resume table
	***********************************/
	htmr_check_user_resume();
	function htmr_check_user_resume(){
		jQuery.ajax({
		   	url:htmr.ajaxurl,
			type:"POST",
			dataType : "json",
			data : {
				action: "htmr_check_user_resume",
			},
			success : function( response ) {
				//console.log(response);
				//htmr_user_resume_table
				jQuery('div#htmr_user_resume_table').html(response.output);             
			}
	  	});
	}

	if ( jQuery("body").hasClass("my-resume") ) {
	    jQuery('.item-body-inner').addClass('bb-media-container');
	}

	/**********************************/
	/* three dot nav
	***********************************/
	jQuery(document).on('click', '#htmr_side_nav', function(){
		document.getElementById("htmr_dropdown").classList.toggle("htmr_show");
	});
	jQuery(document).mouseup(function(e) 
	{
	    var container = jQuery('#htmr_dropdown');

	    // if the target of the click isn't the container nor a descendant of the container
	    if (!container.is(e.target) && container.has(e.target).length === 0) 
	    {
	        container.removeClass('htmr_show');
	    }
	});
	// Close the dropdown if the user clicks outside of it
	/*window.onclick = function(event) {
		if (!event.target.matches('.htmr_dropbtn')) {
		    var dropdowns = document.getElementsByClassName("htmr_dropdown_content");
		    var i;
		    for (i = 0; i < dropdowns.length; i++) {
		   		var openDropdown = dropdowns[i];
		      	if (openDropdown.classList.contains('htmr_show')) {
		        	openDropdown.classList.remove('htmr_show');
		      	}
		    }
		}
	}*/

	jQuery(document).on('click', 'a.htmr_resume_view', function(e){
		e.preventDefault();
		jQuery.ajax({
		   	url:htmr.ajaxurl,
			type:"GET",
			dataType : "json",
			data : {
				action: "htmr_side_nav_ajax",
				type : 'view'
			},
			success : function( response ) {
				//window.open(response.url, '_blank'); 
				//console.log(response);
				jQuery.ajax({
			        url: response.url,
			        method: 'GET',
			        xhrFields: {
			            responseType: 'blob'
			        },
			        success: function (data) {
			            var a = document.createElement('a');
			            var url = window.URL.createObjectURL(data);
			            a.href = url;
			            a.download = response.file_name;
			            document.body.append(a);
			            a.click();
			            a.remove();
			            window.URL.revokeObjectURL(url);
			        }
			    });      
			}
	  	});
	});

	jQuery(document).on('click', 'a.htmr_resume_update', function(e){
		e.preventDefault();
		jQuery('#htmr_myBtn').trigger('click');
	});

	jQuery(document).on('click', 'a.htmr_resume_delete', function(e){
		e.preventDefault();
		if ( confirm('Are you sure to delete resume?') ) {
			jQuery.ajax({
			   	url:htmr.ajaxurl,
				type:"GET",
				dataType : "json",
				data : {
					action: "htmr_side_nav_ajax",
					type : 'delete'
				},
				success : function( response ) {
					console.log("deleted");
					if ( response.status == 'success' ) {
						htmr_check_user_resume();
					}
				}
		  	});
		}
	});

	/**********************************/
	/* Upload file submit
	***********************************/
	jQuery('p.success_msg').hide();
	jQuery('div.htmr-loader').hide();
	jQuery(document).on('submit', '#htmr_formId', function(e){
		e.preventDefault();
		var fileInputElement = document.getElementById("htmr_file");
		var fileName = fileInputElement.files[0].name;
		if(fileName == ""){
			alert('Upload your file');
			return false;
		}else{
			jQuery.ajax({
				url:htmr.ajaxurl,
				type:"POST",
				processData: false,
				contentType: false,
				data: new FormData(this),
				beforeSend: function() {
			        jQuery('div.htmr-loader').show();
			    },
				success : function( response ){
					//console.log(response);
					jQuery('#fileDetails').removeClass('file-details--open');
					jQuery('div#uploadedFile').removeClass('uploaded-file--open');
					jQuery('div#uploadedFileInfo').removeClass('uploaded-file__info--active');
					jQuery('div.htmr-loader').hide();
					setTimeout(function(){
						var returnedData = JSON.parse(response);
						if(returnedData.code == 200){
							jQuery('p.success_msg').show();
							//alert('File uploaded!');
							jQuery('#htmr_file').val('');
							//jQuery('#fileDetails').html('');
							jQuery('#upload_resume_btn').attr('disabled', 'disabled');
							htmr_check_user_resume();
						}
					}, 1000);
				},
			});
		}
	});

	/**********************************/
	/* Model Popup
	***********************************/
	// Get the modal
	var modal = document.getElementById("htmr_Modal");

	// Get the button that opens the modal
	var btn = document.getElementById("htmr_myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("htmr-close")[0];

	var success = document.getElementsByClassName("success_msg")[0];
	var upload_resume_btn = document.getElementById("upload_resume_btn");
	//var htmr_fileDetails = document.getElementById("fileDetails");

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
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
	    success.style.display = "none";
	    upload_resume_btn.setAttribute("disabled", "disabled");
	    //htmr_fileDetails.innerHTML = "";
	  }
	}

	jQuery(document).on('click', 'span.htmr-close', function(){
		jQuery('p.success_msg').hide();
		upload_resume_btn.setAttribute("disabled", "disabled");
		//htmr_fileDetails.innerHTML = "";
	});

	/**********************************/
	/* Upload file Area
	***********************************/

	// Select Upload-Area
	const uploadArea = document.querySelector('#uploadArea')

	// Select Drop-Zoon Area
	const dropZoon = document.querySelector('#dropZoon');

	// Loading Text
	const loadingText = document.querySelector('#loadingText');

	// Slect File Input 
	const fileInput = document.querySelector('#htmr_file');

	// Upload button
	const uploadBtn = document.querySelector('#upload_resume_btn');

	// Select Preview Image
	const previewImage = document.querySelector('#previewImage');

	// File-Details Area
	const fileDetails = document.querySelector('#fileDetails');

	// Uploaded File
	const uploadedFile = document.querySelector('#uploadedFile');

	// Uploaded File Info
	const uploadedFileInfo = document.querySelector('#uploadedFileInfo');

	// Uploaded File  Name
	const uploadedFileName = document.querySelector('.uploaded-file__name');

	// Uploaded File Icon
	const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');

	// Uploaded File Counter
	const uploadedFileCounter = document.querySelector('.uploaded-file__counter');

	// ToolTip Data
	const toolTipData = document.querySelector('.upload-area__tooltip-data');

	// Images Types
	const imagesTypes = [
		"pdf",
	  	// "jpeg",
	  	// "png",
	  	// "svg",
	  	// "gif"
	];

	// Append Images Types Array Inisde Tooltip Data
	toolTipData.innerHTML = [...imagesTypes].join(', .');

	// When (drop-zoon) has (dragover) Event 
	dropZoon.addEventListener('dragover', function (event) {
	  // Prevent Default Behavior 
	  event.preventDefault();

	  // Add Class (drop-zoon--over) On (drop-zoon)
	  dropZoon.classList.add('drop-zoon--over');
	});

	// When (drop-zoon) has (dragleave) Event 
	dropZoon.addEventListener('dragleave', function (event) {
	  // Remove Class (drop-zoon--over) from (drop-zoon)
	  dropZoon.classList.remove('drop-zoon--over');
	});

	// When (drop-zoon) has (drop) Event 
	dropZoon.addEventListener('drop', function (event) {
	  // Prevent Default Behavior 
	  event.preventDefault();

	  // Remove Class (drop-zoon--over) from (drop-zoon)
	  dropZoon.classList.remove('drop-zoon--over');

	  // Select The Dropped File
	  const file = event.dataTransfer.files[0];

	  // Call Function uploadFile(), And Send To Her The Dropped File :)
	  uploadFile(file);
	});

	// When (drop-zoon) has (click) Event 
	dropZoon.addEventListener('click', function (event) {
	  // Click The (fileInput)
	  fileInput.click();
	});

	// When (fileInput) has (change) Event 
	fileInput.addEventListener('change', function (event) {
	  // Select The Chosen File
	  const file = event.target.files[0];

	  // Call Function uploadFile(), And Send To Her The Chosen File :)
	  uploadFile(file);
	});

	// Upload File Function
	function uploadFile(file) {
	  // FileReader()
	  const fileReader = new FileReader();
	  // File Type 
	  const fileType = file.type;
	  // File Size 
	  const fileSize = file.size;

	  // If File Is Passed from the (File Validation) Function
	  if (fileValidate(fileType, fileSize)) {
	    // Add Class (drop-zoon--Uploaded) on (drop-zoon)
	    //dropZoon.classList.add('drop-zoon--Uploaded');

	    // Show Loading-text
	    loadingText.style.display = "block";
	    // Hide Preview Image
	    previewImage.style.display = 'none';

	    // Remove Class (uploaded-file--open) From (uploadedFile)
	    uploadedFile.classList.remove('uploaded-file--open');
	    // Remove Class (uploaded-file__info--active) from (uploadedFileInfo)
	    uploadedFileInfo.classList.remove('uploaded-file__info--active');

	    // After File Reader Loaded 
	    fileReader.addEventListener('load', function () {
	      // After Half Second 
	      setTimeout(function () {
	        // Add Class (upload-area--open) On (uploadArea)
	        uploadArea.classList.add('upload-area--open');

	        // Hide Loading-text (please-wait) Element
	        loadingText.style.display = "none";
	        // Show Preview Image
	        //previewImage.style.display = 'block';

	        // Add Class (file-details--open) On (fileDetails)
	        fileDetails.classList.add('file-details--open');
	        // Add Class (uploaded-file--open) On (uploadedFile)
	        uploadedFile.classList.add('uploaded-file--open');
	        // Add Class (uploaded-file__info--active) On (uploadedFileInfo)
	        uploadedFileInfo.classList.add('uploaded-file__info--active');
	      }, 500); // 0.5s

	      // Add The (fileReader) Result Inside (previewImage) Source
	      // previewImage.setAttribute('src', fileReader.result);
	      //jQuery('#htmr_pdf_url').val(fileReader.result);
	      //previewImage.setAttribute('src', 'https://blog.idrsolutions.com/wp-content/uploads/2020/10/pdf-1.png');

	      // Add File Name Inside Uploaded File Name
	      uploadedFileName.innerHTML = file.name;

	      // Call Function progressMove();
	      progressMove();
	      uploadBtn.removeAttribute("disabled");
	    });

	    // Read (file) As Data Url 
	    fileReader.readAsDataURL(file);
	  } else { // Else

	    this; // (this) Represent The fileValidate(fileType, fileSize) Function

	  };
	};

	// Progress Counter Increase Function
	function progressMove() {
	  // Counter Start
	  let counter = 0;

	  // After 600ms 
	  setTimeout(() => {
	    // Every 100ms
	    let counterIncrease = setInterval(() => {
	      // If (counter) is equle 100 
	      if (counter === 100) {
	        // Stop (Counter Increase)
	        clearInterval(counterIncrease);
	      } else { // Else
	        // plus 10 on counter
	        counter = counter + 10;
	        // add (counter) vlaue inisde (uploadedFileCounter)
	        uploadedFileCounter.innerHTML = `${counter}%`
	      }
	    }, 100);
	  }, 600);
	};


	// Simple File Validate Function
	function fileValidate(fileType, fileSize) {

		// File Type Validation
		let isImage = imagesTypes.filter((type) => fileType.indexOf(`application/${type}`) !== -1);

		// If The Uploaded File Type Is 'jpeg'
		if (isImage[0] === 'jpeg') {
		  // Add Inisde (uploadedFileIconText) The (jpg) Value
		  //uploadedFileIconText.innerHTML = 'pdf';
		} else { // else
		  // Add Inisde (uploadedFileIconText) The Uploaded File Type 
		  //uploadedFileIconText.innerHTML = isImage[0];
		};

		// If The Uploaded File Is An Image
		if (isImage.length !== 0) {
			// Check, If File Size Is 2MB or Less
		  	if (fileSize <= 2000000) { // 2MB :)
		    	return true;
		  	} else { // Else File Size
		     	return alert('Please Your File Should be 2 Megabytes or Less');
		    };
		} else { // Else File Type 
		    return alert('Please make sure to upload PDF file only');
		};
	};

});