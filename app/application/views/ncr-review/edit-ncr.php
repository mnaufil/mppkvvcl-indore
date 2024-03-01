<!DOCTYPE html>
<html>
	<head>
		<!-- META DATA -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="description" content="CRM - Benchmark IT Solutions">
	    <meta name="author" content="Benchmark IT Solutions">
	    <meta name="keywords" content="Benchmark IT Solutions">

	    <!-- FAVICON -->
	    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/brand/favicon.ico'); ?>">

	    <!-- TITLE -->
	    <title>MPPKVVCL - <?php echo $title; ?></title>

	    <!-- BOOTSTRAP CSS -->
	    <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

	    <!-- STYLE CSS -->
	    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

	    <!-- PLUGINS CSS -->
	    <link href="<?php echo base_url('assets/css/plugins.css'); ?>" rel="stylesheet">

	    <!--- FONT-ICONS CSS -->
	    <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet">

	    <!-- INTERNAL Switcher css -->
	    <link href="<?php echo base_url('assets/switcher/css/switcher.css'); ?>" rel="stylesheet">
	    <link href="<?php echo base_url('assets/switcher/demo.css'); ?>" rel="stylesheet">
	        
	    <!-- DATERANGEPICKER CSS -->
	    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">
	</head>

	<body class="app sidebar-mini ltr light-mode">
		<!-- GLOBAL-LOADER -->
	    <div id="global-loader">
	    	<img src="<?php echo base_url('assets/images/loader.svg'); ?>" class="loader-img" alt="Loader">
	    </div>
	    <!-- /GLOBAL-LOADER -->

	    <!-- PAGE -->
	    <div class="page">
	    	<!-- Page Main -->
	    	<div class="page-main">
	    		
	    		<!-- App-Header -->
		        <?php $this->load->view('include/header');?>
		        <!-- App-Header Ends -->

		        <!-- App-Sidebar Ends -->
		        <?php $this->load->view('include/side-bar');?>
		        <!-- App-Sidebar Ends -->

		        <!-- App-Content -->
		        <div class="main-content app-content mt-0">
		        	<div class="side-app">
		        		
		        		<!-- Container -->
		        		<div class="main-container container-fluid">
		        			
		        			<!-- Page-Header -->
				            <div class="page-header">
				            	<h1 class="page-title">Edit NCR Details</h1>
				            	<!-- FLash Alert -->
				            	<?php if ($this->session->flashdata('error')) { ?>
				            		<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 45%;"> 
                                        <span class="alert-inner--icon">
                                            <i class="fe fe-slash"></i>
                                        </span> 
                                        <span class="alert-inner--text"><strong>Error!</strong>
                                        	<?php echo implode(', ', $this->session->flashdata('error')); ?>
                                        </span> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> 
                                            <span aria-hidden="true">×</span> 
                                        </button> 
                                    </div>	
				            	<?php } ?>
				            	<!-- FLash Alert Ends -->
				            </div>
				            <!-- Page-Header Ends -->				            

				            <!-- Row -->
				            <div class="row row-sm">
				            	<div class="col-lg-12">
				            		<div class="card">
				            			<div class="row">
                                            <div class="col-md-12 mt-2">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-add me-3"><?php echo $ncr_data['observation_status']; ?></a>
                                            </div>
                                        </div>
				            			<div class="card-body p-2">				            				
				            				<form name="updateNCRDetails" id="updateNCRDetails" method="post" action="<?php echo base_url('update-NCR-details'); ?>" enctype="multipart/form-data">
				            					<input type="hidden" name="pp_activity_observation_id" value="<?php echo $ncr_data['physical_progress_activity_observation_id']; ?>">
				            					<input type="hidden" name="contractLocationID" value="<?php echo $ncr_data['contract_location_id']; ?>">
				            					<!-- <input type="hidden" name="typeOfWorkActivityID" value="<?php echo $ncr_data['activity_id']; ?>"> -->
				            					<!-- Row1 -->
				            					<div class="row">
					            					<!-- Observation Type -->
					            					<div class="col-xl-4">
					            						<label class="form-label" for="observationType">Observation Type
                    										<span class="text-red">*</span>
                    									</label>
                    									<?php $select_disabled = ($ncr_data['completion_date'] != NULL || $logged_user_role == 'TKC') ? 'disabled' : '';?>
                    									<select name="observationType" id="observationType" class="form-control form-select" data-bs-placeholder="Select Observation" <?php echo $select_disabled; ?>>
									                      	<option value="select" disabled>Select Observation</option>
								                      		<?php foreach ($activity_observations as $key => $value) { ?>
								                      		<?php $selected = ($ncr_data['observation_name'] == $value['name']) ? 'selected' : ''; ?>
								                      		<option value="<?php echo $value['typeofwork_activity_options_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
								                      		<?php } ?>
                    									</select>
                    									<?php if ($select_disabled == 'disabled') { ?>
                    									<input type="hidden" name="observationType" value="">		
                    									<?php } ?>
                    									<input type="hidden" name="observationName" value="<?php echo $ncr_data['observation_name']; ?>">
					            					</div>
					            					<!-- NCR ID -->
					            					<div class="col-xl-4">
					            						<label class="form-label" for="ncrID">NCR ID</label>
                    									<input type="text" class="form-control" id="ncrID" name="ncrID" value="<?php echo $ncr_data['ncr_id']; ?>" readonly>
					            					</div>
					            					<!-- NCR Date -->
					            					<div class="col-xl-4">
                    									<label class="form-label" for="ncrDate">NCR Date</label>
                    									<input type="text" class="form-control" id="ncrDate" name="ncrDate" value="<?php echo $ncr_data['ncr_date']; ?>"  readonly>
                  									</div>
					            				</div>
					            				<!-- Row2 -->
					            				<div class="row">
					            					<!-- Observation -->
					            					<div class="col-xl-12">
                    									<label class="form-label" for="remark">Observation</label>
                    									<?php $remark_readonly = ($ncr_data['completion_date'] != NULL) ? 'readonly' : '';?>
			                    						<input type="text" class="form-control" id="remark" name="remark" value="<?php echo $ncr_data['remark']; ?>" <?php echo $remark_readonly; ?>>
                  									</div>
					            				</div>
					            				<!-- Row3 -->
					            				<div class="row">
					            					<!-- Observation Photos -->
					            					<div class="col-xl-12">
                    									<label class="form-label" for="obs_photo">Observation Photos
                    										<span class="text-red">*</span>
                    									</label>
                    									<?php if ($logged_user_role != 'TKC') { ?>
                    									<?php $obs_photos_disabled = ($ncr_data['completion_date'] != NULL) ? 'disabled' : '';?>
                    									<input class="form-control" type="file" id="obs_photo" name="obs_photo[]" multiple="" <?php echo $obs_photos_disabled; ?>>
              											<input type="hidden" name="obs_deleted_file_id" value="">
                    									<?php } ?>
                  									</div>
                  									<!-- Uploaded Images -->
                  									<div class="col-xl-12">
                  										<div class="text-wrap mt-2" id="preview-img-obs">
                  										<?php 	if (!empty($ncr_data['observation_files'])) {
                  													foreach ($ncr_data['observation_files'] as $key => $value) { ?>
                  											<div class="file-image-1" data-ppao-file_id="<?php echo $value['physical_progress_activity_observation_file_id']; ?>">
                  												<a href="javascript:void(0)" onclick="showImageModal(this)">
										                        	<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="">
										                        </a>
										                        <?php if ($ncr_data['completion_date'] == NULL) { ?>
										                        <ul class="icons">
										                        	<li>
										                        		<a href="javascript:void(0)" data-photo-for="observation" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="image-<?php echo $key; ?>" data-photo-action="edit"><i class="fe fe-trash"></i></a>
										                        	</li>
										                        </ul>	
										                        <?php } ?>              
                  											</div>
                  										<?php			}
                  												} 
                  										?>
                  										</div>
                  									</div>
					            				</div>
					            				<!-- Row4 -->
					            				<?php if ($logged_user_role == 'TKC' || $logged_user_role == 'Admin') { ?>
					            				<div class="row">
					            					<!-- TKC Observation Photos -->
					            					<div class="col-xl-12">
					            						<label class="form-label" for="obs_photo_tkc">Observation Photos By TKC
                    									</label>
                    									<?php if ($logged_user_role == 'TKC') { ?>
                    									<input class="form-control" type="file" id="obs_photo_tkc" name="obs_photo_tkc[]" multiple="">	
                    									<?php } ?>
                    									<input type="hidden" name="obs_tkc_deleted_file_id" value="">
					            					</div>
					            					<!-- Uploaded Images -->
					            					<div class="col-xl-12">
					            						<div class="text-wrap mt-2" id="preview-img-obs-tkc">
					            						<?php 	if (!empty($ncr_data['observation_tkc_files'])) {
					            									foreach ($ncr_data['observation_tkc_files'] as $key => $value) { ?>
					            							<div class="file-image-1" data-ppao-file-id="<?php echo $value['physical_progress_activity_observation_tkc_file_id'];?>">
					            								<a href="javascript:void(0)" onclick="showImageModal(this)">
					            									<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="">
					            								</a>
					            								<?php if ($ncr_data['completion_date'] == NULL) { ?>
					            								<ul class="icons">
					            									<li>
					            										<a href="javascript:void(0)" data-photo-for="observation_tkc" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="image-<?php echo $key; ?>" data-photo-action="edit"><i class="fe fe-trash"></i></a>
					            									</li>
					            								</ul>
					            								<?php } ?>
					            							</div>
					            						<?php 		}
					            								}
					            						?>
					            						</div>
					            					</div>
					            				</div>	
					            				<?php } ?>
					            				<!-- Row5 -->
					            				<?php if ($logged_user_role != 'TKC') { ?>
					            				<div class="row">
					            					<!-- Completion Photos -->
					            					<div class="col-xl-8">
                    									<label class="form-label" for="completion_photo">Completion Photos</label>
                    									<?php $obs_completion_photos_disabled = ($ncr_data['observation_status'] == 'Closed') ? 'disabled' : '';?>
                    									<input class="form-control" type="file" id="completion_photo" name="completion_photo[]" multiple="" <?php echo $obs_completion_photos_disabled; ?>>
                    									<input type="hidden" name="obs_completion_deleted_file_id" value="">
                    									<!-- Uploaded Images -->
                  										<div class="text-wrap mt-2" id="preview-img-complete">
              											<?php 	if (!empty($ncr_data['observation_completion_files'])) {
              														foreach ($ncr_data['observation_completion_files'] as $key => $value) { ?>
              												<div class="file-image-1" data-ppao-file_id="<?php echo $value['physical_progress_activity_completion_file_id']; ?>">
                  												<a href="javascript:void(0)" onclick="showImageModal(this)">
										                        	<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="">
										                        </a>
										                        <ul class="icons">
										                        	<li>
										                        		<a href="javascript:void(0)" data-photo-for="observation_completion" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="image-<?php echo $key; ?>" data-photo-action="edit"><i class="fe fe-trash"></i></a>
										                        	</li>
										                        </ul>
                  											</div>
              											<?php		}
              													} 
              											?>
                  										</div>
              										</div>
              										<!-- Completion Date -->
              										<div class="col-xl-4">
                    									<label for="completionDate" class="form-label">Completion Date</label>
                      									<div class="input-group">
                          									<div class="input-group-text dates">
                              									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                          									</div>
                          									<?php $readonly = (!empty($ncr_data['completion_date'])) ? 'readonly' : ''; ?>
                          									<input type="text" class="form-control" id="completionDate" name="completionDate" value="<?php echo $ncr_data['completion_date']; ?>" <?php echo $readonly; ?>>
                      									</div>
                  									</div>
					            				</div>	
					            				<?php } ?>
					            				<!-- Row6 -->
					            				<div class="row">
					            					<!-- Submit -->
					            					<div class="col-xl-6 mt-5 mb-3">
					            						<?php if ($logged_user_role == 'TKC') { ?>
					            						<button class="btn btn-success" type="submit">Submit</button>
					            						<?php } else { ?>
					            						<?php if ($ncr_data['observation_status'] == 'Pending') { ?>
					            						<input type="hidden" name="changed_observation_status" value="Forwarded">
					            						<button class="btn btn-success" type="submit">Mark as Forwarded</button>
					            						<?php } elseif ($ncr_data['observation_status'] == 'Reviewed') { ?>
					            						<input type="hidden" name="changed_observation_status" value="Closed">
					            						<button class="btn btn-success" type="submit">Mark as Closed</button>
					            						<?php } ?>
					            						<?php } ?>
					            						
					            						<a type="button" class="btn btn-primary" href="<?php echo base_url('ncr-review'); ?>">Back</a>	
					            					</div>
					            				</div>
				            				</form>
				            			</div>
				            		</div>
				            	</div>
				            </div>
				            <!-- Row Ends -->
		        		</div>
		        		<!-- Container Ends -->
		        	</div>
		        </div>
		        <!-- App-Content Ends -->
	    	</div>
	    	<!-- Page Main Ends -->

	    	<!-- Image Modal -->
      		<div class="modal fade" id="img-modal" tabindex="-1" aria-hidden="true" style="display: none; text-align: center;">
        		<div class="modal-dialog modal-lg" role="document">
          			<div class="modal-content">
            			<div class="modal-header">
              				<button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                				<span aria-hidden="true">×</span>
              				</button>
            			</div>
            			<div class="modal-body">
              				<img src="" alt="" id="obs_image" style="object-fit: fill; width: 100%; height: 100%;">
            			</div>
          			</div>
        		</div>
      		</div>
      		<!-- Image Modal Ends -->

	    	<!-- Footer -->
	      	<?php $this->load->view('include/footer');?>
	      	<!-- Footer Ends -->
	    </div>

	    <!-- BACK-TO-TOP -->
    	<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    	<!-- JQUERY JS -->
    	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

    	<!-- BOOTSTRAP JS -->
    	<script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
    	<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

    	<!-- TypeHead js -->
	    <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

	    <!-- SELECT2 JS -->
    	<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

    	<!-- Perfect SCROLLBAR JS-->
	    <script src="<?php echo base_url('assets/plugins/p-scroll/perfect-scrollbar.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll-1.js'); ?>"></script>

	    <!-- SIDE-MENU JS -->
    	<script src="<?php echo base_url('assets/plugins/sidemenu/sidemenu.js'); ?>"></script>

    	<!-- SIDEBAR JS -->
    	<script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js'); ?>"></script>

    	<!-- Color Theme js -->
    	<script src="<?php echo base_url('assets/js/themeColors.js'); ?>"></script>

    	<!-- Sticky js -->
    	<script src="<?php echo base_url('assets/js/sticky.js'); ?>"></script>

    	<!-- CUSTOM JS -->
    	<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

    	<!-- Custom-switcher -->
    	<script src="<?php echo base_url('assets/js/custom-swicher.js'); ?>"></script>

    	<!-- Switcher js -->
    	<script src="<?php echo base_url('assets/switcher/js/switcher.js'); ?>"></script>

    	<!-- SWEET-ALERT JS -->
	    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

	    <!-- DATERANGE PICKER JS -->
	    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	    <script type="text/javascript">
	    	var obs_photo_file_list = [];
	    	var obs_completion_photo_file_list = [];
	    	var obs_tkc_photo_file_list = [];
	    	var obs_deleted_file_id = [];
	    	var obs_completion_deleted_file_id = [];
	    	var obs_tkc_deleted_file_id = [];

	    	let ncr_date = '<?php echo $ncr_data['ncr_date']; ?>';
	    	let current_date = new Date();

	    	let select_disabled = '<?php echo $select_disabled ?>';
	    	if (select_disabled == 'disabled') {
	    		let obs_selected_val = $('select[name="observationType"]').find(':selected').val();
	    		$('input[name="observationType"]').val(obs_selected_val);
	    	}

	    	//Setting Completion Date greater than NCR Date
			$('input[name="completionDate"]').daterangepicker({
		      	//autoUpdateInput: false,
		        singleDatePicker: true,
		        showDropdowns: true,
		        drops: "auto",
		        minDate: getModifiedDate(ncr_date),
				maxDate: current_date,
		       	autoUpdateInput: false,
		        parentEl: '#obs-detail-modal .modal-body',
		        locale: {
		        	format: 'DD-MM-YYYY'
		        }
	      	});

	      	$('input[name="completionDate"]').on('apply.daterangepicker', function(ev, picker) {
		      	$(this).val(picker.startDate.format('DD-MM-YYYY'));

		      	// Change submit button name and value
		      	let observation_status = '<?php echo $ncr_data['observation_status'] ?>';

		      	if (observation_status == 'Pending') {
		      		$('button[type="submit"]').html('Mark as Closed');
		      		$('input[name="changed_observation_status"]').val('Closed');
		      	}
		  	});

	      	// Setting observationName value on Observation Type dropdown change
		  	$('select[name="observationType"]').on('change', function(event) {
		  		let selected_observation = $(this).find('option:selected').text();

		  		$('input[name="observationName"]').val(selected_observation);
		  	});

		  	//Getting Uploaded File data and displaying the image
		  	$('#obs_photo').on('change', function(event) {
		  		obs_photo_file_list = [];

      			// Get the selected image files
    			let files = $(this)[0].files;

    			if (files.length > 0) {
    				if (files.length > 5) {
		      			$('.toast-body').text('Only 5 images can be uploaded.');
	     				$('.toast').toast('show');
		      			return false;
	    			}

	    			if ($('#preview-img-obs').find('.file-image-1').length > 0) {
	    				let previous_uploaded_photos = $('#preview-img-obs').find('.file-image-1').length;

	    				if (previous_uploaded_photos + files.length > 5) {
		      				$('.toast-body').text('Only 5 images can be uploaded.');
	     					$('.toast').toast('show');
		      				return false;
	    				}
	    			}

    				//Loop through all the selected images
	    			for (var i = 0; i < files.length; i++) {
	    				// Pushing each file in an array
	    				obs_photo_file_list.push(files[i]);

	    				let obs_file_id = 'image-'+i;
						let file_name = files[i].name;

						let html_img = '';
	          			html_img += '<div class="file-image-1">';
		      			html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
		      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="">';
		      			html_img += '</a>';
		      			html_img += '<ul class="icons">';
		      			html_img += '<li>';
		      			html_img += '<a href="javascript:void(0)" data-photo-for="observation" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="'+obs_file_id+'" data-photo-action="add">';
		      			html_img += '<i class="fe fe-trash"></i>';
		      			html_img += '</a>';
		      			html_img += '</li>';
		      			html_img += '</ul>';
		      			// html_img += '<span class="file-name-1">'+file.name+'</span>';
		      			html_img += '</div>';

		      			$('#preview-img-obs').append(html_img);
	    			}
    			}
		  	});

		  	function deleleObservationPhoto(anchor) {
		  		let obs_file_id = $(anchor).attr('data-obs-file-id');
		      	let file_index = obs_file_id.split('-').pop();
		      	let photo_for = $(anchor).attr('data-photo-for');
		      	let photo_action = $(anchor).attr('data-photo-action');

		      	if (photo_for == 'observation') {
		      		// Removing file from observation photo file list
		      		delete obs_photo_file_list[file_index];

		      		if (photo_action == 'add') {
		      			$('#obs_photo')[0].files = FileListItem(obs_photo_file_list)	
		      		} else if (photo_action == 'edit') {
		      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file_id');
		      			obs_deleted_file_id.push(deleted_file_id);

		      			$('input[name="obs_deleted_file_id"]').val(obs_deleted_file_id);
		      		}
		      	} else if (photo_for == 'observation_completion') {
		      		// Removing file from observation completion photo file list
      				delete obs_completion_photo_file_list[file_index];

      				if (photo_action == 'add') {
		      			$('#completion_photo')[0].files = FileListItem(obs_completion_photo_file_list);	
		      		} else if (photo_action == 'edit') {
		      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file_id');
		      			obs_completion_deleted_file_id.push(deleted_file_id);

		      			$('input[name="obs_completion_deleted_file_id"]').val(obs_completion_deleted_file_id);
		      		}
		      	} else if (photo_for == 'observation_tkc') {
		      		// Removing file from observation tkc photo file list
		      		delete obs_tkc_photo_file_list[file_index];

		      		if (photo_action == 'add') {
		      			$('#obs_photo_tkc')[0].files = FileListItem(obs_tkc_photo_file_list);
		      		} else if (photo_action == 'edit') {
		      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file_id');
		      			obs_tkc_deleted_file_id.push(deleted_file_id);

		      			$('input[name="obs_tkc_deleted_file_id"]').val(obs_tkc_deleted_file_id);
		      		}
		      	}

		      	// Deleting uploaded image from the modal
      			$(anchor).closest('.file-image-1').remove();
		  	}

		  	$('#completion_photo').on('change', function(event) {
		  		obs_completion_photo_file_list = [];

		  		// Get the selected image files
		  		let files = $(this)[0].files;

		  		if (files.length > 0) {
		  			if (files.length > 5) {
		      			$('.toast-body').text('Only 5 images can be uploaded.');
	     				$('.toast').toast('show');
		      			return false;
    				}

    				if ($('#preview-img-complete').find('.file-image-1').length > 0) {
    					let completion_file_count = 0;
	    				$('#preview-img-complete').find('.file-image-1').each(function(i, obj) {
	    					if (typeof $(obj).data('ppao-file_id') !== 'undefined') {
	    						completion_file_count++;
	    					}
	    				});

	    				if (completion_file_count == 0) {
	    					//Clearing previously uploaded images
	      					$('#preview-img-complete').empty();
	    				}
    				}

    				if ($('#preview-img-complete').find('.file-image-1').length > 0) {
	    				let previous_uploaded_photos = $('#preview-img-obs').find('.file-image-1').length;

	    				if (previous_uploaded_photos + files.length > 5) {
	    					$('.toast-body').text('Only 5 images can be uploaded.');
	     					$('.toast').toast('show');
		      				return false;
	    				}
	    			}

		  			//Loop through all the selected images
	    			for (var i = 0; i < files.length; i++) {
	    				// Pushing each file in an array
	    				obs_completion_photo_file_list.push(files[i]);

			            let obs_file_id = 'image-'+i;
			            let file_name = files[i].name;

            			let html_img = '';
			          	html_img += '<div class="file-image-1">';
		      			html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
		      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="">';
		      			html_img += '</a>';
		      			html_img += '<ul class="icons">';
		      			html_img += '<li>';
		      			html_img += '<a href="javascript:void(0)" data-photo-for="observation_completion" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="'+obs_file_id+'" data-photo-action="add">';
		      			html_img += '<i class="fe fe-trash"></i>';
		      			html_img += '</a>';
		      			html_img += '</li>';
		      			html_img += '</ul>';
		      			// html_img += '<span class="file-name-1">'+file_name+'</span>';
		      			html_img += '</div>';

		      			$('#preview-img-complete').append(html_img);
	    			}
		  		}
		  	});

		  	$('#obs_photo_tkc').on('change', function(event) {
		  		obs_tkc_photo_file_list = [];

		  		// Get the selected image files
		  		let files = $(this)[0].files;

		  		if (files.length > 0) {
		  			if (files.length > 5) {
		  				$('.toast-body').text('Only 5 images can be uploaded.');
	     				$('.toast').toast('show');
		      			return false;
		  			}

		  			if ($('#preview-img-obs-tkc').find('.file-image-1').length > 0) {
		  				let previous_uploaded_photos = $('#preview-img-obs-tkc').find('.file-image-1').length;

		  				if (previous_uploaded_photos + files.length > 5) {
		  					$('.toast-body').text('Only 5 images can be uploaded.');
	     					$('.toast').toast('show');
		      				return false;
		  				}
		  			}

		  			// Loop through all the selected images
		  			for (var i = 0; i < files.length; i++) {
		  				// Pushing each file in an array
	    				obs_tkc_photo_file_list.push(files[i]);

	    				let obs_file_id = 'image-'+i;
						let file_name = files[i].name;

						let html_img = '';
	          			html_img += '<div class="file-image-1">';
		      			html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
		      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="">';
		      			html_img += '</a>';
		      			html_img += '<ul class="icons">';
		      			html_img += '<li>';
		      			html_img += '<a href="javascript:void(0)" data-photo-for="observation_tkc" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="'+obs_file_id+'" data-photo-action="add">';
		      			html_img += '<i class="fe fe-trash"></i>';
		      			html_img += '</a>';
		      			html_img += '</li>';
		      			html_img += '</ul>';
		      			// html_img += '<span class="file-name-1">'+file.name+'</span>';
		      			html_img += '</div>';

		      			$('#preview-img-obs-tkc').append(html_img);
		  			}
		  		}
		  	});

		  	$('#updateNCRDetails').submit(function(event) {		  		

		  		let completion_date = $('input[name="completionDate"]').val();

		  		let completion_files_count = $('#completion_photo')[0].files.length;

		  		if (completion_files_count > 0 && completion_date == '') {
		  			$('.toast-body').text('Enter completion date');
     				$('.toast').toast('show');

     				event.preventDefault();
		  		}

		  		let observation_status = '<?php echo $ncr_data['observation_status'] ?>';

		  		if (observation_status == 'Reviewed') {
		  			let previous_uploaded_photos = $('#preview-img-complete').find('.file-image-1').length;
		  			if (previous_uploaded_photos == 0 && completion_date != '') {
			  			$('.toast-body').text('Upload completion photo');
	     				$('.toast').toast('show');

	     				event.preventDefault();
			  		}	
		  		}
		  	});

		  	function FileListItem(file) {
		      	// Clearing empty slots from file
		      	let file_temp = [];
		      	$.each(file, function(index, value) {
		      		if (typeof value === 'undefined') {
		    			return;
		    		}

		    		file_temp.push(value);
		      	});

		      	file = [];
		      	file = file_temp;

		      	file = [].slice.call(Array.isArray(file) ? file : arguments)
		        for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
		        if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
		        for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
		        return b.files
		    }

		  	function showImageModal(anchor) {
        		let image = $(anchor).find('img');
        		let image_src = image.attr('src');

        		let src_arr = image_src.split('/');
        		let image_name = src_arr[src_arr.length-1];

        		$('#obs_image').attr('src',image_src);
        		// $('#caption').text(image_name);

        		$('#img-modal').modal('show');
      		}

		  	function getModifiedDate(date) {
        		var parts = date.split("-")
        		return new Date(parts[2], parts[1] - 1, parts[0])
      		}
	    </script>
	</body>
</html>