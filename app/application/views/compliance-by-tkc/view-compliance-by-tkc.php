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
				            	<h1 class="page-title">View <?php echo $title; ?></h1>
				            	<!-- FLash Alert -->
				            	<?php //if ($this->session->flashdata('error') && !empty($this->session->flashdata('error'))) { ?>
				            		<!-- <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 45%;"> 
                                        <span class="alert-inner--icon">
                                            <i class="fe fe-slash"></i>
                                        </span> 
                                        <span class="alert-inner--text"><strong>Error!</strong>
                                        	<?php //echo implode(', ', $this->session->flashdata('error')); ?>
                                        </span> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> 
                                            <span aria-hidden="true">×</span> 
                                        </button> 
                                    </div> -->	
				            	<?php //} ?>
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

		        						<div class="card-body p-2">
		        							<form name="updateComplianceByTKCDetails" id="updateComplianceByTKCDetails" method="post" action="<?php echo base_url('update-compliance-by-tkc-details'); ?>" enctype="multipart/form-data">
		        								<input type="hidden" name="pp_activity_observation_id" value="<?php echo $ncr_data['physical_progress_activity_observation_id']; ?>">
		        								<input type="hidden" name="contractLocationID" value="<?php echo $ncr_data['contract_location_id']; ?>">
		        								<input type="hidden" name="feederID" value="<?php echo $ncr_data['feeder_id']; ?>">
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
                    									<select name="observationType" id="observationType" class="form-control form-select" data-bs-placeholder="Select Observation" disabled>
									                      	<option value="select" disabled>Select Observation</option>

								                      		<?php foreach ($activity_observations as $key => $value) { ?>
								                      		<?php $selected = ($ncr_data['observation_name'] == $value['name']) ? 'selected' : ''; ?>
								                      		<option value="<?php echo $value['typeofwork_activity_options_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
								                      		<?php } ?>
                    									</select>                    									
                    									<input type="hidden" name="observationType" value="">	
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
		        								<div class="row" id="other-observation-div">
								                	<!-- Others Observation -->
								                	<div class="col-xl-12">
								                		<label class="form-label" for="other_observation">Other Observation
								                			<span class="text-red">*</span>
								                		</label>
								                    	<input type="text" class="form-control" id="other_observation" name="other_observation" value="<?php echo $ncr_data['other_observation_name']; ?>" readonly>
								                	</div>
								                </div>	
		        								<?php } ?>
		        								<!-- Row4 -->
		        								<div class="row">
		        									<!-- Observation -->
		        									<div class="col-xl-12">
                    									<label class="form-label" for="observation_remark">Observation</label>
			                    						<input type="text" class="form-control" id="observation_remark" name="observation_remark" value="<?php echo $ncr_data['observation_remark']; ?>" readonly>
                  									</div>
		        								</div>
		        								<!-- Row5 -->
		        								<div class="row">
		        									<!-- Observation Photos -->
		        									<div class="col-xl-12">
                    									<label class="form-label" for="obs_photo">Observation Photos
                    										<span class="text-red">*</span>
                    									</label>
                    									<input class="form-control" type="file" id="obs_photo" name="obs_photo[]" multiple="" disabled>
              											<!-- <input type="hidden" name="obs_deleted_file_id" value=""> -->
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
										                        <?php //if ($ncr_data['completion_date'] == NULL) { ?>
										                        <!-- <ul class="icons">
										                        	<li>
										                        		<a href="javascript:void(0)" data-photo-for="observation" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="image-<?php echo $key; ?>" data-photo-action="edit"><i class="fe fe-trash"></i></a>
										                        	</li>
										                        </ul> -->	
										                        <?php //} ?>
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
					            								<?php //if ($ncr_data['completion_date'] == NULL) { ?>
					            								<!-- <ul class="icons">
					            									<li>
					            										<a href="javascript:void(0)" data-photo-for="observation_tkc" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="image-<?php //echo $key; ?>" data-photo-action="edit"><i class="fe fe-trash"></i></a>
					            									</li>
					            								</ul> -->
					            								<?php //} ?>
					            							</div>
					            						<?php 		}
					            								}
					            						?>
					            						</div>
					            					</div>
		        								</div>
		        								<!-- Row7 -->
		        								<div class="row">
					            					<!-- Completion Photos -->
					            					<div class="col-xl-8">
                    									<label class="form-label" for="completion_photo">Completion Photos</label>
                    									<input class="form-control" type="file" id="completion_photo" name="completion_photo[]" multiple="" disabled>
                    									<input type="hidden" name="obs_completion_deleted_file_id" value="">
                    									<!-- Uploaded Images -->
                  										<div class="text-wrap mt-2" id="preview-img-complete">
              											<?php 	if (!empty($ncr_data['observation_completion_files'])) {
              														foreach ($ncr_data['observation_completion_files'] as $key => $value) { ?>
              												<div class="file-image-1" data-ppao-file_id="<?php echo $value['physical_progress_activity_completion_file_id']; ?>">
                  												<a href="javascript:void(0)" onclick="showImageModal(this)">
										                        	<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="" width="100" height="100">
										                        </a>
										                        <!-- <ul class="icons">
										                        	<li>
										                        		<a href="javascript:void(0)" data-photo-for="observation_completion" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="image-<?php echo $key; ?>" data-photo-action="edit"><i class="fe fe-trash"></i></a>
										                        	</li>
										                        </ul> -->
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
                          									<input type="text" class="form-control" id="completionDate" name="completionDate" value="<?php echo $ncr_data['completion_date']; ?>" readonly>
                      									</div>
                  									</div>
					            				</div>
					            				<!-- Row8 -->
					            				<div class="row">
					            					<!-- Submit -->
					            					<div class="col-xl-6 mt-5 mb-3">
					            						<!-- <button class="btn btn-success" type="submit">Submit</button> -->
					            						<a type="button" class="btn btn-primary" href="<?php echo base_url('compliance-by-tkc'); ?>">Back</a>	
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
            			<div class="modal-body" style="height: calc(100vh - 105px);overflow: scroll;">
              				<img src="" alt="" id="obs_image" style="object-fit: fill; width: 100%;">
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

	</body>
</html>