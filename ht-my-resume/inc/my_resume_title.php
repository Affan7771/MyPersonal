<?php 

// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {die;} // end if
$loader = site_url() . '/wp-content/plugins/ht-my-resume/assets/img/loader.gif';

?>

<div class='htmr_title_container'>
	<div class='htmr_my_resume_title'>
		<h2 class='bb-title'>My Resume</h2>
		<button id="htmr_myBtn" class="htmr_upload_resume">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
			  <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
			  <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
			</svg> &nbsp; Upload New Resume</button>
	</div><!-- .htmr_my_resume_title -->
</div><!-- .htmr_title_container -->
<div id="htmr_Modal" class="htmr_modal">

  <!-- Modal content -->
  <div class="htmr-modal-content">
  	<span class="htmr-close">&times;</span>

  	<!-- <h2 class="upload_new_resume">Upload New Resume</h2> -->
		<div id="uploadArea" class="upload-area">
		  <!-- Header -->
		  <div class="upload-area__header">
		    <h1 class="upload-area__title">Upload New Resume</h1>
		    <p class="upload-area__paragraph">
		        <span class="upload-area__tooltip-data"></span>
		    </p>
		  </div>
		  <!-- End Header -->

		  <!-- Drop Zoon -->
		  <form method="post" enctype="multipart/form-data" id="htmr_formId">
			  <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
			    <span class="drop-zoon__icon">
			      <i class='bx bxs-file-image'></i>
			    </span>
			    <p class="drop-zoon__paragraph">Drop your file here to upload. Only .pdf file type is allowed.</p>
			    <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
			    <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">
			    <input type="hidden" name="htmr_pdf_url" id="htmr_pdf_url">
			    <!-- <input type="file" id="fileInput" class="drop-zoon__file-input" accept="application/pdf"> -->
			    <input type="file" name="htmr_file" class="drop-zoon__file-input" id="htmr_file" accept="application/pdf" required />
			    <!--Create Security nonce-->
					<input name="security" value="<?php echo wp_create_nonce('uploadingFile'); ?>" type="hidden">
					<!-- set action name -->
					<input name="action" value="upload_file" type="hidden"/>
			  </div>
		  	<!-- End Drop Zoon -->

		  <!-- File Details -->
		  <div id="fileDetails" class="upload-area__file-details file-details">
		    <h3 class="file-details__title">Uploaded File</h3>

		    <div id="uploadedFile" class="uploaded-file">
		      <div class="uploaded-file__icon-container">
		        <!-- <i class='bx bxs-file-blank uploaded-file__icon'></i> -->
		        <i class='bb-icon-file-pdf'></i>
		        <span class="uploaded-file__icon-text"></span> <!-- Data Will be Comes From Js -->
		      </div>

		      <div id="uploadedFileInfo" class="uploaded-file__info">
		        <span class="uploaded-file__name">Proejct 1</span>
		        <span class="uploaded-file__counter">0%</span>
		      </div>
		    </div>
		  </div><!-- #fileDetails -->
		  <div class="htmr_after_upload_area">
		  	<label>Visibility:
			  	<select id="visibility">
				  	<option value="only_me">Only me</option>
				  </select>
				</label>
			  <input type="submit" name="upload_file" id="upload_resume_btn" class="upload_resume_btn" value="Upload" disabled />
		  </div>
		</form>
			<div class="htmr-loader"><img src="<?php echo $loader; ?>"></div>
		  <p class="success_msg">Your resume has been uploaded successfully.</p>
		  <!-- End File Details -->
		</div><!-- #uploadArea -->
		<!-- End Upload Area -->
  </div><!-- .htmr-modal-content -->

</div>

