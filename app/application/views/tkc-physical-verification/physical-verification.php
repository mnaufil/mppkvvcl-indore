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
                <h1 class="page-title">TKC Physical Verification</h1>
              </div>
              <!-- Page-Header Ends -->

              <!-- Row -->
              <div class="row row-sm">
              	<div class="col-lg-12">
              		<div class="card">
              			<div class="card-body p-2">
              				<!-- Search Block -->
              				<!-- Search Block Ends -->

              				<!-- Table -->
              				<div class="table-responsive mt-3">
              					<div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
              						<div class="row">
              							<div class="col-sm-12">
              								<!-- Export Button -->
                              <!-- Uncomment later -->
                              <!-- <div class="col-sm-12 col-md-9s">
                                <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                  <button class="btn btn-primary" type="button"><span>Export</span></button>
                                </div>  
                              </div> -->
                              <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" id="basic-datatable" role="grid" aria-describedby="basic-datatable_info">
                              	<thead>
                              		<tr role="row">
                              			<th class="wd-10p border-bottom-0" tabindex="0" aria-controls="basic-datatable" rowspan="1" colspan="1"style="width: 95.5156px;">Actions</th>
                              			<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Contract No: activate to sort column descending" style="width: 95.5156px;">Contract No</th>
                              			<th class="wd-15p border-bottom-0 sorting" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contractor: activate to sort column descending" style="width: 88.5469px;">Contractor</th>
                              			<th class="wd-25p border-bottom-0 sorting" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Type Of Work: activate to sort column ascending" style="width: 178.531px;">Type Of Work</th>
                              			<th class="wd-25p border-bottom-0 sorting" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Region/Circle/Division: activate to sort column ascending" style="width: 92.5312px;">Region/Circle/Division</th>
                              			<th class="wd-20p border-bottom-0 sorting" tabindex="5" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Site Location: activate to sort column descending" style="width: 67.7031px;">Site Location</th>
                              			<th class="wd-20p border-bottom-0 sorting" tabindex="6" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Feeder ID: activate to sort column descending" style="width: 67.7031px;">Feeder ID</th>
                              			<th class="wd-20p border-bottom-0 sorting" tabindex="7" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Task: activate to sort column descending" style="width: 67.7031px;">Task</th>
                              			<th class="wd-20p border-bottom-0 sorting" tabindex="8" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Work Completion(In %): activate to sort column descending" style="width: 67.7031px;">Work Completion(In %)</th>
                              			<th class="wd-15p border-bottom-0 sorting" tabindex="9" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Last Reported By: activate to sort column descending" style="width: 185.141px;">Last Reported By</th>
                              			<th class="wd-20p border-bottom-0 sorting" tabindex="10" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Last Reported Date: activate to sort column ascending" style="width: 185.141px;">Last Reported Date</th>
                              			<th class="wd-20p border-bottom-0 sorting" tabindex="11" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 185.141px;">Status</th>
                              		</tr>
                              	</thead>
                              	<tbody>
                              		<?php foreach ($result as $key => $value) { ?>
                              			<tr>
                              				<?php $mode = ($value['sheet_status'] == 'Completed' || $value['sheet_status'] == 'Reviewed') ? 'view' : (($value['sheet_status'] == 'In Process') ? 'edit-prev' : 'edit-new'); ?>
                              				<td name="bstable-actions">
                              					<!-- Action Buttons -->
                              					<div class="btn-list">
                              						<?php if (!empty($user_access) && (isset($user_access['view']) || isset($user_access['update']))) { ?>
                              							<a id="bView" type="button" class="btn btn-sm" href="<?php echo base_url('add-physical-progress/'.$mode.'/'.$value['tkc_physical_progress_id'].'/'.$value['contract_id'].'/'.$value['contract_location_id']); ?>">
		                                          <span class="<?php echo ($value['sheet_status'] == 'Completed') ? 'fa fa-eye' : 'fe fe-edit'; ?> fa-lg action-btn-table"></span>
		                                        </a>
		                                      <?php } ?>
                              					</div>
                              				</td>
                              				<td>
                              					<!-- Contract No -->
                                      	<?php echo $value['tender_award_no']; ?>
                              				</td>
                              				<td>
                              					<!-- Contractor(TKC) -->
                                      	<?php echo $value['contractor_name']; ?>
                              				</td>
                              				<td>
                              					<!-- Type of Work -->
                                      	<?php echo $value['typeofwork_name']; ?>
                              				</td>
                              				<td>
                              					<!-- Region/Circle/Division -->
                                      	<?php echo $value['region_name'].'/'.$value['circle_name'].'/'.$value['division_name']; ?>
                              				</td>
                              				<td style="text-align: center;">
                              					<!-- Site Location -->
                                      	<?php echo $value['site_location']; ?>
                              				</td>
                              				<td style="text-align: center;">
                              					<!-- Feeder ID -->
                              					<?php echo $value['feeder_id']; ?>
                              				</td>
                              				<td style="text-align: center;">
                              					<!-- Task Ratio -->
                              					<?php echo $value['cc_task'].' / '. $value['tt_task']; ?>
                              				</td>
                              				<td style="text-align: center;">
                              					<!-- Work Completion (In %) -->
                              					<?php $work_completion = ($value['tt_task'] != 0) ? ((int)$value['cc_task'] / (int)$value['tt_task']) * 100 : ''; ?>
                                      	<?php echo ($work_completion == 0 || $work_completion == 100 || $work_completion == '') ? $work_completion : round($work_completion); ?>
                              				</td>
                              				<td>
                              					<!-- Reported By -->
                                      	<?php echo $value['pp_reported_by']; ?>
                              				</td>
                              				<td style="text-align: center;">
                              					<!-- Reported Date -->
                                      	<?php echo (!empty($value['reported_date'])) ? date('d-m-Y', strtotime($value['reported_date'])) : ''; ?>
                              				</td>
                              				<td>
                              					<!-- Sheet Status -->
                              					<?php if ($value['sheet_status'] == 'Open') {
	                                              $text_color = 'text-gray';
	                                            } elseif ($value['sheet_status'] == 'In Process') {
	                                              $text_color = 'text-yellow';
	                                            } elseif ($value['sheet_status'] == 'Reviewed') {
	                                              $text_color = 'text-blue';
	                                            } elseif ($value['sheet_status'] == 'Completed') {
	                                              $text_color = 'text-green';
	                                            }
	                                      ?>
	                                      <h5 class="<?php echo $text_color; ?> text-status">
	                                        <?php echo $value['sheet_status']; ?>
	                                      </h5>
                              				</td>
                              			</tr>
                              		<?php } ?>
                              	</tbody>
                              </table>
              							</div>
              						</div>
              					</div>
              				</div>
              				<!-- Table Ends -->
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

    <!-- MULTI JS -->
    <script src="<?php echo base_url('assets/plugins/multi/multi.min.js'); ?>"></script>

    <!-- MULTIPLE SELECT JS -->
    <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 


	</body>
</html>