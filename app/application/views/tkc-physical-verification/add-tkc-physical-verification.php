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
    	<img src="<?php echo base_url('assets/images/loader.svg') ?>" class="loader-img" alt="Loader">
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
                <h1 class="page-title"><?php echo $page_title; ?></h1>
                <div class="row">
                	<div class="col-md-12">
                		<p><h5>Task: <strong><?php echo $sheet_data['task_ratio']; ?></strong></h5></p>
                	</div>
                </div>
              </div>
              <!-- Page-Header Ends -->

              <!-- Row -->
              <div class="row">
              	<div class="col-lg-12 col-md-12">
              		<div class="card">
              			
              			<form id="addTKCPhysicalVerificationSheet" method="post" enctype="multipart/form-data" action="<?php echo base_url('save-tkc-physical-verification'); ?>">

              				<!-- TKC Physical Progress ID -->
	                  	<input type="hidden" id="physical_progress_id" name="physical_progress_id" value="<?php echo $sheet_data['tkc_physical_progress_id']; ?>">

	                  	<?php if (!isset($sheet_type)) { ?>
	                  		<!-- Previous TKC Physical Progress ID -->
	                  		<input type="hidden" id="prev_tkc_physical_progress_id" name="prev_tkc_physical_progress_id" 	value="<?php echo $sheet_data['prev_tkc_physical_progress_id']; ?>">
	                  	<?php } ?>

	                  	<!-- Contract ID -->
	                  	<input type="hidden" id="contract_id" name="contract_id" value="<?php echo $sheet_data['contract_id']; ?>">

	                  	<!-- Contract Location ID -->
	                  	<input type="hidden" id="contract_location_id" name="contract_location_id" value="<?php echo $sheet_data['contract_location_id']; ?>">

	                  	<div class="card-body mt-3">
	                  		<!-- Row1 -->
	                  		<div class="form-row">
	                  			<!-- Sheet Status -->
	                  			<div class="col-xl-6 mb-3">
	                  				<div class="btn-group radiobtns btn-tit" role="group" aria-label="Basic radio toggle button group">
	                  					<button type="button" class="btn btn-primary"><?php echo strtoupper($sheet_data['sheet_status']); ?></button>
	                  				</div>
	                  				<!-- Work Completion -->
	                  				<div class="mt-3">
	                  					<h5><strong>Work Completion (In %): <span><?php echo $sheet_data['work_completion']; ?></span></strong></h5>
	                  				</div>
	                  			</div>

	                  			<!-- Dates -->
              						<div class="col-xl-6 mb-3">
              							<div class="breadcrumb-6">
                							<ol class="breadcrumb1 mb-0">
                								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
                								<li class="breadcrumb-item1 active"><u>Today</u></li>	
                								<?php } else { ?>
                									<?php foreach ($prev_sheet_dates as $key => $value) { ?>
                										<?php if (isset($sheet_type) && $sheet_type == 'old') { ?>
                											<li class="breadcrumb-item1 ">
			                									<?php if (date('Y-m-d', strtotime($sheet_date)) == $value['reported_date']) { ?>
			                										<a>
			                											<u><?php echo date('j M', strtotime($value['reported_date'])); ?></u>
			                  									</a>
			                										<?php } else { ?>
			                										<a href="<?php echo base_url('get-sheet/'.$value['reported_date'].'/'.$value['physical_progress_id'].'/'.$sheet_data['contract_id'].'/'.$sheet_data['contract_location_id']); ?>">
			                  									<?php echo date('j M', strtotime($value['reported_date'])); ?>
		                  									</a>
			                									<?php } ?>
				                  							</li>
                											<?php } else { ?>
	                											<li class="breadcrumb-item1">
				                  								<a href="<?php echo base_url('get-sheet/'.$value['reported_date'].'/'.$value['physical_progress_id'].'/'.$sheet_data['contract_id'].'/'.$sheet_data['contract_location_id']); ?>">
				                  									<?php echo date('j M', strtotime($value['reported_date'])); ?>
			                  									</a>
				                  							</li>
			                  								<?php //} ?>
                											<?php } ?>                									
                									<?php } ?>
                  								<?php if (isset($sheet_type) && $sheet_type == 'old' && $sheet_data['sheet_status'] == 'In Process') { ?>
                  									<?php if (!isset($future_sheet_status)) { ?>
                  										<?php $recent_sheet = end($prev_sheet_dates); ?>	
                  										<li class="breadcrumb-item1 active">
		                  									<a href="<?php echo base_url('add-physical-progress/edit-prev/'.$recent_sheet['physical_progress_id'].'/'.$sheet_data['contract_id'].'/'.$sheet_data['contract_location_id']); ?>">Today</a>
		                  								</li>
                  									<?php } ?>
                  								<?php } elseif ($sheet_data['sheet_status'] == 'In Process') { ?>
                  								<li class="breadcrumb-item1 active"><u>Today</u></li>
                  								<?php } ?>
                  							<?php } ?>
                  						</ol>	
                						</div>	
              						</div>
	                  		</div>
	                  		<!-- Row2 Form Inputs -->
	                  		<div class="form-row">
	                  			<!-- Contractor -->
	                  			<div class="col-xl-6 mb-3">
              							<label class="form-label" for="nameOfContractor">Name Of Contractor
              								<span class="text-red">*</span>
              							</label>
              							<input class="form-control" type="text" id="nameOfContractor" name="nameOfContractor" value="<?php echo $sheet_data['contractor_name']; ?>" readonly required>
              						</div>
              						<!-- Tender Award No -->
              						<div class="col-xl-3 mb-3">
						                <label class="form-label" for="tenderAwardNo">Contract No.
						                    <span class="text-red">*</span>
						                </label>
						                <input class="form-control" type="text" id="tenderAwardNo" required name="tenderAwardNo" value="<?php echo $sheet_data['tender_award_no']; ?>" readonly>
										      </div>
										      <!-- Tender Award Date -->
										      <div class="col-xl-3 mb-3">
						                <label class="form-label" for="tenderAwardDate">Contract Date
						                    <span class="text-red">*</span>
						                </label>
						                <input class="form-control" type="text" id="tenderAwardDate" required name="tenderAwardDate" value="<?php echo $sheet_data['tender_award_date']; ?>" readonly>
							            </div>
	                  		</div>
	                  		<!-- Row3 Form Inputs -->
	                  		<div class="form-row">
	                  			<!-- Package No -->
	                  			<div class="col-xl-3 mb-3">
						                <label class="form-label" for="packageNo">Lot No.
						                    <span class="text-red">*</span>
						                </label>
						                <input class="form-control" type="text" id="packageNo" required name="packageNo" value="<?php echo $sheet_data['package_no']; ?>" readonly>
							            </div>
							            <!-- Type Of Work -->
							            <div class="col-xl-3 mb-3">
						                <label class="form-label" for="typeOfWork">Type Of Work
						                    <span class="text-red">*</span>
						                </label>
						                <select class="form-control select2" id="typeOfWork" required disabled>
						                    <option value="<?php echo $sheet_data['typeofwork'] ;?>" selected><?php echo $sheet_data['typeofwork']; ?></option>
						                </select>
							            </div>
							            <!-- Reported By -->
							            <div class="col-xl-3 mb-3">
              							<label class="form-label" for="reportedBy">Reported By
              								<span class="text-red">*</span>
              							</label>
              							<?php $readonly = ($userdata['role'] == 'Admin') ? '' : 'readonly'; ?>
              							<!-- Check below case -->
              							<?php $reported_by = $userdata['username']; ?>
              							<input class="form-control" type="text" id="reportedBy" required name="reportedBy" value="<?php echo $reported_by; ?>" <?php echo $readonly; ?>>
              						</div>
              						<!-- Reported Date -->
              						<div class="col-xl-3 mb-3">
              							<label class="form-label" for="reportedDate">Reported Date
              								<span class="text-red">*</span>
              							</label>
              							<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
            								<div class="input-group">
                              <div class="input-group-text dates">
                                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                              </div>
                              <input type="text" class="form-control" name="reportedDate" id="reportedDate" />
                            </div>
              							<?php } elseif ($sheet_data['sheet_status'] == 'In Process') { ?>
              								<?php $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
              											if (in_array('get-sheet', $uriSegments)) { ?>
              								<div class="input-group">
                    						<div class="input-group-text dates">
                                	<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                              	</div>
                              	<input class="form-control" type="text" id="reportedDate" required name="reportedDate" value="<?php echo $sheet_data['reported_date']; ?>" readonly disabled>					
                            	</div>
        											<?php } else { ?>
        												<div class="input-group">
		                              <div class="input-group-text dates">
		                                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
		                              </div>
		                              <input type="text" class="form-control" name="reportedDate" id="reportedDate"/>
		                            </div>
        											<?php } ?>              							
              							<?php } elseif ($sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
              								<div class="input-group">
                              	<div class="input-group-text dates">
                          				<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
		                            </div>
	                            	<input type="text" class="form-control" name="reportedDate" id="reportedDate" value="<?php echo $sheet_data['reported_date'] ?>" readonly disabled/>
		                          </div>
              							<?php } ?>
              						</div>
	                  		</div>
	                  		<!-- Row4 Form Inputs -->
	                  		<div class="form-row">
	                  			<!-- Region -->
	                  			<div class="col-xl-3 mb-3">
              							<label class="form-label" for="region">Region</label>
                						<select class="form-control form-select select2 select2-hidden-accessible" name="region" data-bs-placeholder="Select Region" tabindex="-1" aria-hidden="true" id="region" disabled>
              								<option value="<?php echo $sheet_data['region_name']; ?> selected"><?php echo $sheet_data['region_name']; ?></option>
                            </select>
              						</div>
              						<!-- Circle -->
              						<div class="col-xl-3 mb-3">
              							<label class="form-label" for="circle">Circle</label>
                        		<select class="form-control form-select select2 select2-hidden-accessible" name="circle" data-bs-placeholder="Select Circle" tabindex="-1" aria-hidden="true" id="circle" disabled>
                            	<option value="<?php echo $sheet_data['circle_name']; ?>"><?php echo $sheet_data['circle_name']; ?></option>
                            </select>
              						</div>
              						<!-- Division -->
              						<div class="col-xl-3 mb-3">
              							<label class="form-label" for="division">Division</label>
                        		<select class="form-control form-select select2 select2-hidden-accessible" name="division" data-bs-placeholder="Select Division" tabindex="-1" aria-hidden="true" id="division" disabled>
                            	<option value="<?php echo $sheet_data['division_name']; ?>"><?php echo $sheet_data['division_name']; ?></option>
                            </select>
              						</div>
              						<!-- Site Location -->
              						<div class="col-xl-3 mb-3">
              							<label class="form-label" for="siteLocation">Site Location
              								<span class="text-red">*</span>
              							</label>
              							<input class="form-control" type="text" id="siteLocation" required name="siteLocation" value="<?php echo $sheet_data['location_name']; ?>" readonly>
              						</div>
	                  		</div>
	                  		<!-- Row5 Form Inputs -->
	                  		<div class="form-row">
	                  			<!-- Feeder ID -->
	                  			<div class="col-xl-3 mb-3">
                            <label class="form-label" for="feederID">Feeder ID
                              <span class="text-red">*</span>
                            </label>
                            <input class="form-control" type="text" id="feederID" required name="feederID" value="<?php echo $sheet_data['feeder_id']; ?>" readonly>
                          </div>
                          <!-- Feeder Name -->
                          <div class="col-xl-3 mb-3">
                            <label class="form-label" for="feederName">Feeder Name
                              <span class="text-red">*</span>
                            </label>
                            <input class="form-control" type="text" id="feederName" required name="feederName" value="<?php echo $sheet_data['feeder_name']; ?>" readonly>
                          </div>
                          <!-- Geo Location -->
                          <div class="col-xl-3 mb-3">
              							<label class="form-label" for="geoLocation">Geo Location</label>
              							<input class="form-control" type="text" id="geoLocation" required name="geoLocation" value="<?php echo $sheet_data['geo_code']; ?>" readonly>
              						</div>
	                  		</div>
	                  		<!-- Alert -->
	                  		<!-- Alert Ends -->
	                  		<!-- Row6 Tabs-->
	                  		<?php if (!empty($sheet_data['activities_list'])) { ?>
	                  		
	                  		<?php } ?>
	                  		<!-- Row7 Mark Complete Button -->
	                  		<?php if (!isset($sheet_type)) { ?>
	                    		<?php if ($sheet_data['sheet_status'] == 'Open' || $sheet_data['sheet_status'] == 'In Process') { ?>
	                    			<div class="form-row">
			                    		<div class="col-xl-12">
		                              <a href="javascript:void(0)" class="btn btn-success btn-add" id="markComplete">Mark as Complete</a>
		                           </div>
			                    	</div>	
	                    		<?php } ?>
	                    	<?php } ?>
	                    	<!-- Row8 Upload Completion File -->
	                    	<!-- Row9 Remark -->
	                    	<div class="form-row">
              						<div class="col-xl-12 mb-3">
              							<label for="sheetRemark" class="form-label mt-0">Remark <span class="text-red" id="remarkSpan"></span></label>
              							<?php //$readonly = ((isset($sheet_type) && $sheet_type == 'old') || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') ? 'readonly' : ''; ?>
              							<?php if ((isset($sheet_type) && $sheet_type == 'old') || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') {
              											if ($sheet_data['sheet_status'] == 'Reviewed' && ($userdata['role'] == 'Admin' || $userdata['role'] == 'Deputy Team Lead' || $userdata['role'] == 'Key Experts' || $userdata['role'] == 'Team Lead')) {
              												$readonly = '';
              											}	else {
              												$readonly = 'readonly';
              											}	
              										} else {
              											$readonly = '';
              										}
              							?>
              							<textarea rows="3" cols="50" class="form-control" name="sheetRemark" <?php echo $readonly; ?>><?php echo $sheet_data['remark']; ?></textarea>
              						</div>
              					</div>
              					<!-- Row10 Submit -->
              					<div class="form-row">
              						<div class="col-xl-6 mt-5 mb-3">
              							<?php if (!isset($sheet_type)) { 
              											if ($sheet_data['sheet_status'] != 'Completed' && !(isset($sheet_data['sheet_mode']))) { 
              												if ($sheet_data['sheet_status'] == 'Reviewed' && ($userdata['role'] == 'Admin' || $userdata['role'] == 'Deputy Team Lead' || $userdata['role'] == 'Key Experts' || $userdata['role'] == 'Team Lead')) { 
              							?>
              							<button type="button" class="btn btn-success" id="markReviewedSheetComplete">Mark as Complete</button>
              							<?php 		} else { ?>
              							<button type="submit" class="btn btn-success">Submit</button>		
              							<?php 	} 
              								 		} else if (isset($sheet_data['sheet_mode']) && ($sheet_data['sheet_mode'] == 'update' && $sheet_data['sheet_status'] != 'Completed')) { 
              												if ($sheet_data['sheet_status'] == 'Reviewed' && ($userdata['role'] == 'Admin' || $userdata['role'] == 'Deputy Team Lead' || $userdata['role'] == 'Key Experts' || $userdata['role'] == 'Team Lead')) { 
              							?>
              							<button type="button" class="btn btn-success" id="markReviewedSheetComplete">Mark as Complete</button>	
              							<?php 		} else if($sheet_data['sheet_status'] == 'In Process' && ($userdata['role'] == 'Admin' || $userdata['role'] == 'Field Engineer' || $userdata['role'] == 'Field Supervisor')) { ?>
              							<button type="submit" class="btn btn-success">Update</button>
              							<?php 			} 
              												}
              										 	} 
              							?>
              							<?php if ($sheet_data['sheet_status'] == 'Reviewed' && strpos($_SERVER['REQUEST_URI'], 'edit-review')) { 
              											$back_url = 'physical-verification-review';
              										} else {
              											$back_url = 'physical-verification';
              										}
              							?>
              							<a href="<?php echo base_url($back_url); ?>" type="button" class="btn btn-primary">Back</a>
              						</div>
              					</div>
	                  	</div>
              			</form>

              		</div>
              	</div>
              </div>
              <!-- Row Ends-->

        		</div>
        		<!-- Container Ends -->

        	</div>
        </div>
        <!-- App-Content Ends -->

    	</div>
    	<!-- Page Main Ends -->

    	<!-- Footer -->
      <?php $this->load->view('include/footer');?>
      <!-- Footer Ends -->      
    </div>
    <!-- PAGE ENDS -->

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JQUERY JS -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

    <!-- BOOTSTRAP JS -->
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- INPUT MASK JS-->
    <script src="<?php echo base_url('assets/plugins/input-mask/jquery.mask.min.js'); ?>"></script>

    <!-- TypeHead js -->
    <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

    <!-- SELECT2 JS -->
    <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

    <!-- FORMVALIDATION JS -->
    <script src="<?php echo base_url('assets/js/form-validation.js'); ?>"></script>

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

    <!-- EDIT TABLE JS -->
    <!-- <script src="<?php //echo base_url('assets/plugins/edit-table/installation.js'); ?>"></script>
    <script src="<?php //echo base_url('assets/plugins/edit-table/edit-table.js'); ?>"></script> -->
    <script src="<?php echo base_url('assets/plugins/edit-table/physical-progress/physical-progress.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/edit-table/physical-progress/physical-edit-table.js'); ?>"></script>

    <!-- DATA TABLE JS-->
    <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

    <!-- SWEET-ALERT JS -->
    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

    <!-- DATERANGE PICKER JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	</body>
</html>