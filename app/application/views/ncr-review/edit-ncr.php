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
				            	<?php if ($this->session->flashdata('error') && !empty($this->session->flashdata('error'))) { ?>
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
                                            	<?php if ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby'])) { ?>
                                            	<a href="javascript:void(0)" class="btn btn-primary btn-add me-3">Deleted</a>
                                            	<?php } else { ?>
                                                <a href="javascript:void(0)" class="btn btn-primary btn-add me-3"><?php echo $ncr_data['observation_status']; ?></a>
                                            	<?php } ?>
                                            </div>
                                        </div>

                                        <!-- Loading Spinner -->
			            				<div class="row email-loader m-0 mt-2" hidden>
			            					<div class="d-flex align-items-center rounded-2 pt-1 pb-1" style="background: #efefef">
											  	<strong class="email-loader-message">Loading...</strong>
											  	<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
											</div>	
			            				</div>
			            				<!-- Loading Spinner Ends -->

				            			<div class="card-body p-2">				            				
				            				<form name="updateNCRDetails" id="updateNCRDetails" method="post" action="<?php echo base_url('update-NCR-details'); ?>" enctype="multipart/form-data">
				            					<input type="hidden" name="pp_activity_observation_id" value="<?php echo $ncr_data['physical_progress_activity_observation_id']; ?>">
				            					<input type="hidden" name="contractLocationID" value="<?php echo $ncr_data['contract_location_id']; ?>">
				            					<input type="hidden" name="feederID" value="<?php echo $ncr_data['feeder_id']; ?>">
				            					<!-- <input type="hidden" name="typeOfWorkActivityID" value="<?php echo $ncr_data['activity_id']; ?>"> -->
				            					<!-- Row1 -->
				            					<div class="row">
				            						<!-- Raised By -->
				            						<div class="col-xl-4">
				            							<label class="form-label" for="raisedBy">Raised By</label>
                    									<input type="text" class="form-control" id="raisedBy" name="raisedBy" value="<?php echo $ncr_data['raised_by']; ?>" readonly>
				            						</div>
				            						<!-- Designation -->
								              		<div class="col-xl-4">
								              			<label class="form-label" for="designation">Designation</label>
								                    <input type="text" class="form-control" id="designation" name="designation" value="<?php echo $ncr_data['designation']; ?>" readonly>
								              		</div>
								              		<!-- Distribution Centre -->
								              		<div class="col-xl-4">
								              			<label class="form-label" for="distributionCentre">Distribution Centre</label>
								                    <input type="text" class="form-control" id="distributionCentre" name="distributionCentre" value="<?php echo $ncr_data['distribution_centre']; ?>" readonly>
								              		</div>
				            					</div>
				            					<!-- Row2 -->
				            					<div class="row">
					            					<!-- Observation Type -->
					            					<div class="col-xl-4">
					            						<label class="form-label" for="observationType">Observation Type
                    										<span class="text-red">*</span>
                    									</label>
                    									<?php //$select_disabled = ($ncr_data['completion_date'] != NULL || $logged_user_role == 'TKC') ? 'disabled' : '';?>
                    									<?php $select_disabled = (($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby'])) || $ncr_data['completion_date'] != NULL || $logged_user_role == 'TKC') ? 'disabled' : '';?>
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
					            				<!-- Row3 -->
					            				<?php if ($ncr_data['observation_id'] == 0) { ?>
					            				<?php $readonly_other_observation = ($logged_user_role == 'TKC' || $ncr_data['observation_status'] == 'Closed' || ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby']))) ? 'readonly' : ''; ?>
					            				<div class="row" id="other-observation-div">
								                	<!-- Others Observation -->
								                	<div class="col-xl-12">
								                		<label class="form-label" for="other_observation">Other Observation
								                			<span class="text-red">*</span>
								                		</label>
								                    <input type="text" class="form-control" id="other_observation" name="other_observation" value="<?php echo $ncr_data['other_observation_name']; ?>" <?php echo $readonly_other_observation; ?>>
								                	</div>
								                </div>	
					            				<?php } ?>
					            				<!-- Row4 -->
					            				<div class="row">
					            					<!-- Observation -->
					            					<div class="col-xl-12">
                    									<label class="form-label" for="observation_remark">Observation</label>
                    									<?php $observation_remark_readonly = ($logged_user_role == 'TKC' || $ncr_data['observation_status'] == 'Closed' || ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby']))) ? 'readonly' : '';?>
			                    						<input type="text" class="form-control" id="observation_remark" name="observation_remark" value="<?php echo $ncr_data['observation_remark']; ?>" <?php echo $observation_remark_readonly; ?>>
                  									</div>
					            				</div>
					            				<!-- Row5 -->
					            				<div class="row">
					            					<!-- Observation Photos -->
					            					<div class="col-xl-12">
                    									<label class="form-label" for="obs_photo">Observation Photos
                    										<span class="text-red">*</span>
                    									</label>
                    									<?php if ($logged_user_role != 'TKC') { ?>
                    									<?php $obs_photos_disabled = ($ncr_data['observation_status'] == 'Closed' || ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby']))) ? 'disabled' : '';
                										?>
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
										                        	<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="" width="100" height="100">
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
					            				<!-- Row6 -->
					            				<div class="row">
					            					<!-- TKC Observation Photos -->
					            					<div class="col-xl-12">
					            						<?php if ($logged_user_role == 'TKC' || !empty($ncr_data['observation_tkc_files'])) { ?>
					            						<label class="form-label" for="obs_photo_tkc">Observation Photos By TKC</label>
					            						<?php } ?>
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
					            									<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="" width="100" height="100">
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
					            				<!-- Row7 -->
					            				<?php if ($logged_user_role != 'TKC') { ?>
					            				<div class="row">
					            					<!-- Completion Photos -->
					            					<div class="col-xl-8">
                    									<label class="form-label" for="completion_photo">Completion Photos</label>
                    									<?php $obs_completion_photos_disabled = ($ncr_data['observation_status'] == 'Closed' || ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby']))) ? 'disabled' : '';
                    									?>
                    									<input class="form-control" type="file" id="completion_photo" name="completion_photo[]" multiple="" <?php echo $obs_completion_photos_disabled; ?>>
                    									<input type="hidden" name="obs_completion_deleted_file_id" value="">
                    									<!-- Uploaded Images -->
                  										<div class="text-wrap mt-2" id="preview-img-complete">
              											<?php 	if (!empty($ncr_data['observation_completion_files'])) {
              														foreach ($ncr_data['observation_completion_files'] as $key => $value) { ?>
              												<div class="file-image-1" data-ppao-file_id="<?php echo $value['physical_progress_activity_completion_file_id']; ?>">
                  												<a href="javascript:void(0)" onclick="showImageModal(this)">
										                        	<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="" width="100" height="100">
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
                          									<?php $readonly = ($ncr_data['observation_status'] == 'Closed' || ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby']))) ? 'readonly' : '';
                          									$disabled = ($ncr_data['observation_status'] == 'Closed' || ($ncr_data['is_active'] == 0 && !empty($ncr_data['deletedby']))) ? 'disabled' : '';
                          									?>
                          									<input type="text" class="form-control" id="completionDate" name="completionDate" value="<?php echo $ncr_data['completion_date']; ?>" <?php echo $readonly; ?>>
                      									</div>
                  									</div>
					            				</div>	
					            				<?php } ?>
					            				<!-- Row8 -->
					            				<div class="row">
					            					<!-- Submit -->
					            					<div class="col-xl-6 mt-5 mb-3">
					            						<?php if ($logged_user_role == 'TKC') { ?>
					            						<button class="btn btn-success" type="submit">Submit</button>
					            						<?php } else { ?>
					            						<?php if ($ncr_data['observation_status'] == 'Pending' && ($ncr_data['is_active'] == 1 && empty($ncr_data['deletedby']))) { ?>
					            						<input type="hidden" name="changed_observation_status" value="Forwarded">
					            						<button class="btn btn-success" type="submit">Mark as Forwarded and Send Mail to TKC</button>
					            						<?php } elseif ($ncr_data['observation_status'] == 'Reviewed' && ($ncr_data['is_active'] == 1 && empty($ncr_data['deletedby']))) { ?>
					            						<input type="hidden" name="changed_observation_status" value="Closed">
					            						<button class="btn btn-success" type="submit">Mark as Closed and Send Mail to TKC</button>
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

	    	<!-- Email Recipient Modal -->
	    	<div class="modal" id="email_recipient_list_modal" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="email_recipient_list_modalLabel" tabindex="-1" style="display: none;" data-bs-focus="true">
		        <div class="modal-dialog modal-lg" role="document">
		          	<div class="modal-content">
			            <div class="modal-header">
			            	<h5 class="modal-title" id="email_recipient_list_modalLabel">Email Recipient List</h5>
			              	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
			                	<span aria-hidden="true">×</span>
			              	</button>
			            </div>
		            	<div class="modal-body">
		              		<!-- To Recipients -->
			              	<div class="row">
			              		<div class="col-xl-12" id="to_recipients">
			              			<label class="form-label" for="">To Recipients</label>
			              			<!-- <div class="form-check">
			              				<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
			              				<label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
			              			</div> -->
			              		</div>
			              	</div>
			              	<div class="row mt-2">
				              	<div class="col-xl-12">			              		
				              		<input type="text" class="form-control" id="add_to_recipient" name="add_to_recipient" placeholder="Add additional TO recipients here comma separated">
				              	</div>
			              	</div>
			              	<!-- CC Recipients -->
			              	<div class="row">
			              		<div class="col-xl-12" id="cc_recipients">
			              			<label class="form-label" for="">CC Recipients</label>
			              			<!-- <div class="form-check">
			              				<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
			              				<label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
			              			</div> -->
			              		</div>
			              	</div>
			              	<div class="row mt-2">
				              	<div class="col-xl-12">			              		
				              		<input type="text" class="form-control" id="add_cc_recipient" name="add_cc_recipient" placeholder="Add additional CC recipients here comma separated">
				              	</div>
			              	</div>
		            	</div>
		            	<div class="modal-footer">
		              		<button class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
		              		<button class="btn btn-primary" id="btn-save-list" onclick="updateAndSendEmail()">Confirm Recipients and Send Mail</button>
		            	</div>
		          	</div>
		        </div>
		    </div>
	    	<!-- Email Recipient Modal Ends -->

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
		      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="" width="100" height="100">';
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
		      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file-id');
		      			obs_deleted_file_id.push(deleted_file_id);

		      			$('input[name="obs_deleted_file_id"]').val(obs_deleted_file_id);
		      		}
		      	} else if (photo_for == 'observation_completion') {
		      		// Removing file from observation completion photo file list
      				delete obs_completion_photo_file_list[file_index];

      				if (photo_action == 'add') {
		      			$('#completion_photo')[0].files = FileListItem(obs_completion_photo_file_list);	
		      		} else if (photo_action == 'edit') {
		      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file-id');
		      			obs_completion_deleted_file_id.push(deleted_file_id);

		      			$('input[name="obs_completion_deleted_file_id"]').val(obs_completion_deleted_file_id);
		      		}
		      	} else if (photo_for == 'observation_tkc') {
		      		// Removing file from observation tkc photo file list
		      		delete obs_tkc_photo_file_list[file_index];

		      		if (photo_action == 'add') {
		      			$('#obs_photo_tkc')[0].files = FileListItem(obs_tkc_photo_file_list);
		      		} else if (photo_action == 'edit') {
		      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file-id');
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
		      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="" width="100" height="100">';
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
		      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="" width="100" height="100">';
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
		  		let logged_user_role = '<?php echo $logged_user_role ?>';
		  		console.log('logged_user_role: ' + logged_user_role);
		  		

		  		if (logged_user_role == 'TKC') {
		  			let uploaded_obs_photos_by_tkc = $('#preview-img-obs-tkc').find('.file-image-1');

		  			if ($(uploaded_obs_photos_by_tkc).length == 0) {
		  				$('.toast-body').text('Upload Observation Photos By TKC');
	     				$('.toast').toast('show');

	     				event.preventDefault();
	     				return false;
		  			}
		  		} else if (logged_user_role != 'TKC') {
		  			let completion_date = $('input[name="completionDate"]').val();

			  		let completion_files_count = $('#completion_photo')[0].files.length;

			  		let observation_status = '<?php echo $ncr_data['observation_status'] ?>';

			  		if (completion_files_count > 0 && completion_date == '') {
			  			$('.toast-body').text('Enter completion date');
	     				$('.toast').toast('show');

	     				event.preventDefault();
	     				return false;
			  		} 

			  		if (observation_status == 'Reviewed') {
			  			let previous_uploaded_photos = $('#preview-img-complete').find('.file-image-1').length;
			  			if (previous_uploaded_photos == 0 && completion_date != '') {
				  			$('.toast-body').text('Upload completion photo');
		     				$('.toast').toast('show');

		     				event.preventDefault();
		     				return false;
				  		}	
			  		} 
			  		// alert('here'); return false;
			  		event.preventDefault();

		  			let feeder_id_arr = [];
			  		let feeder_id = $('input[name="feederID"]').val();
			  		feeder_id_arr.push(feeder_id);

			  		let ncr_id_arr = [];
			  		let ncr_id = $('input[name="ncrID"]').val();
			  		ncr_id_arr.push(ncr_id);

			  		$.ajax({
	    				type: 'POST',
	    				url: '<?php echo base_url('get-email-recipients-new') ?>',
	    				dataType: 'json',
	    				data: {feeder_id : feeder_id_arr, ncr_id: ncr_id_arr},
	    				success: function(response) {
	    					console.log(response);
	    					// return false;

	    					let to_html = '<label class="form-label" for="">To Recipients</label>';
	    					let cc_html = '<label class="form-label" for="">CC Recipients</label>';

	    					if (!$.isEmptyObject(response.to)) {
	    						$.each(response.to, function(index, value) {
	    							to_html += '<div class="form-check">';
	    							to_html += '<input class="form-check-input" type="checkbox" value="'+value+'" id="to_emails_'+index+'" name="to_emails_'+index+'" checked>';
	    							to_html += '<label class="form-check-label" for="to_emails_'+index+'"> '+value+' </label>';
	    							to_html += '</div>';
	    						});

	    						$('#to_recipients').empty().append(to_html);
	    					}

	    					if (!$.isEmptyObject(response.cc)) {
	    						$.each(response.cc, function(index, value) {
	    							cc_html += '<div class="form-check">';
	    							cc_html += '<input class="form-check-input" type="checkbox" value="'+value+'" id="cc_emails_'+index+'" name="cc_emails_'+index+'" checked>';
	    							cc_html += '<label class="form-check-label" for="cc_emails_'+index+'"> '+value+' </label>';
	    							cc_html += '</div>';
	    						});

	    						$('#cc_recipients').empty().append(cc_html);
	    					}

	    					$('#email_recipient_list_modal').modal('show');
	    					return false;
	    				},
	    				error: function(xhr, status, error) {
	    					console.log(xhr.responseText);	
	    				}
	    			});
		  		}
		  	});

		  	function updateAndSendEmail() {
		  		/*let pp_activity_observation_id = $('input[name="pp_activity_observation_id"]').val();
		  		let contract_location_id = $('input[name="contractLocationID"]').val();

		  		let observation_type_id = $('select[name="observationType"]').val();
		  		let observation_name = $('input[name="observationName"]').val();

		  		let other_observation_name = '';
		  		if ($('#other-observation-div').is(':visible')) {
		  			other_observation_name = $('input[name="other_observation"]').val();
		  		}

		  		let ncr_id = $('input[name="ncrID"]').val();
		  		let ncr_date = $('input[name="ncrDate"]').val();

		  		let observation_remark = $('input[name="observation_remark"]').val();
		  		let remark = $('input[name="remark"]').val();

		  		let completion_date = $('input[name="completionDate"]').val();

		  		let changed_observation_status = $('input[name="changed_observation_status"]').val();

		  		let obs_deleted_file_id = $('input[name="obs_deleted_file_id"]').val();
		  		let obs_completion_deleted_file_id = $('input[name="obs_completion_deleted_file_id"]').val();

		  		let observation_photos = $('#obs_photo')[0].files;
		  		let observation_completion_photo = $('#completion_photo')[0].files;*/

		  		let formData = new FormData($('#updateNCRDetails')[0]);

		  		// Ajax call to send email
		  		$.ajax({
		  			type: 'POST',
    				url: '<?php echo base_url('update-NCR-details') ?>',
    				dataType: 'json',
    				processData: false,
    				contentType: false,
    				data: formData,
    				success: function(response) {
    					console.log(response);

    					$('.toast-body').text(response.message);
	        			$('.toast').toast('show');

	        			setTimeout(function() {
	        				sendEmail();
	        			}, 2000);
    				},
    				error: function(xhr, status, error) {
    					console.log(xhr); return false;
    				}
		  		});		  		
		  	}

		  	function sendEmail() {
				let ncr_id_arr = [];
    			let feeder_IDs = [];
    			let to_email_recipients = [];
    			let cc_email_recipients = [];
    			
    			ncr_id = $('input[name="ncrID"]').val();
    			ncr_id_arr.push(ncr_id);

    			feeder_id = $('input[name="feederID"]').val();
    			feeder_IDs.push(feeder_id);

    			$('#email_recipient_list_modal input[name^="to_emails_"]:checked').each(function() {
					to_email_recipients.push($(this).val());
    			});

    			$('#email_recipient_list_modal input[name^="cc_emails_"]:checked').each(function() {
    				cc_email_recipients.push($(this).val());
    			});

    			let add_to_recipient = $('#add_to_recipient').val();
    			let add_cc_recipient = $('#add_cc_recipient').val();

				let modal_inputs = $('#email_recipient_list_modal').find('input[type="text"]');

				$(modal_inputs).each(function(index, value) {
					$(value).val('');
				});

				$('#email_recipient_list_modal').modal('hide');

				$('.email-loader').removeAttr('hidden');
				$('.email-loader').find('.email-loader-message').html('Please wait while the system is generating the NCR report and sending email to the TKC.');

				// Ajax call to send email
    			$.ajax({
    				type: 'POST',
    				url: '<?php echo base_url('send-ncr-mail-new') ?>',
    				dataType: 'json',
    				data: {checked_ncr: ncr_id_arr, feeder_id: feeder_IDs, to_email_recipients: to_email_recipients, cc_email_recipients: cc_email_recipients, add_to_recipient: add_to_recipient, add_cc_recipient: add_cc_recipient},
    				success: function(response) {
    					// console.log(response);
    					$('#sendMail').attr('disabled', false);
    					$('.email-loader').attr('hidden', true);

    					$('.toast-body').text(response.message);
	        			$('.toast').toast('show');

	        			setTimeout(function() {
	        				location.reload(true)
	        			}, 5000);
    				},
    				error: function(xhr, status, error) {
    					$('#sendMail').attr('disabled', false);
    					$('.email-loader').attr('hidden', true);

    					console.log(xhr.responseText);
    					$('.toast-body').text('Failed to send email');
			        	$('.toast').toast('show');
    				}
    			});
    		}

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