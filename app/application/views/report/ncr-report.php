<!DOCTYPE html>
<html>
	<head>
		<!-- META DATA -->
	   	<meta charset="UTF-8">
	   	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	   	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	   	<meta name="description" content="CRM - Benchmark IT Solutions">
	   	<meta name="author" content="Benchmark IT Solutions">
	   	<meta name="keywords" content="Benchmark IT Solutions">

	   	<!-- FAVICON -->
	   	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/brand/favicon.ico'); ?>">

	   	<!-- TITLE -->
	   	<title>MPPKVVCL - View Report</title>

	   	<!-- BOOTSTRAP CSS -->
	   	<link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

	   	<!-- STYLE CSS -->
	   	<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

		<!-- Plugins CSS -->
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
			<div class="page-main">
				
				 <!-- App-Header -->
                <?php $this->load->view('include/header');?>
                <!-- App-Header Ends -->

                <!-- App-Sidebar -->
                <?php $this->load->view('include/side-bar');?>
                <!-- App-Sidebar Ends -->

		        <!--app-content open-->
		        <div class="main-content app-content mt-0">
		        	<div class="side-app">
		        		
		        		<!-- CONTAINER -->
		        		<div class="main-container container-fluid">
		        			
		        			<!-- PAGE-HEADER -->
			                <div class="page-header">
			                    <h1 class="page-title">Report Name: NCR Data</h1>
			                </div>
			                <!-- PAGE-HEADER END -->

			                <!-- Row -->
			                <div class="row">
			                	<div class="col-lg-12">
			                		<div class="card">
			                			<div class="card-body">
			                				<div class="form-row mt-2 mb-2">
			                					<div class="col-xl-12">
			                						<label class="form-label">Report Description:</label>
                                    				<p class="report-desc">NCR Data</p>
			                					</div>
			                				</div>
			                				<!-- Form -->
			                				<form id="generateNCRReport" name="generateNCRReport" method="post" action="<?php echo base_url('generate-ncr-report')?>">
			                					<div class="form-row">
			                						<!-- Physical Progress Date -->
			                						<div class="col-xl-4 mb-3">
			                							<label class="form-label" for="physicalProgressDate">Physical Progress Date<span class="text-red">*</span></label>
	                        							<div class="input-group">
	                                                        <div class="input-group-text dates">
	                                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                                                        </div>
	                                                        <input type="text" class="form-control" name="physicalProgressDate" id="physicalProgressDate" value="<?php echo $physicalProgressDate;?>" />
	                                                    </div>
			                						</div>
			                					</div>
			                					<div class="form-row">
			                						<!-- Employee -->
			                						<div class="col-xl-2 mb-3">
			                							<label class="form-label" for="employee">Employee</label>
				                						<div class="form-group">
				                                       		<div class="custom-controls">
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="employee" value="all" <?php if($employee=="all" || $employee=="") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">All</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="employee" value="specific" <?php if($employee=="specific") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Specific</span>
				                                       			</label>	
				                                       		</div>
				                                       	</div>
			                						</div>
													<?php //if($employee=="specific") { ?>
			                						<div class="col-xl-4 mb-3">
			                							<div class="form-group" id="employee_filter" <?php if($employee=="all" || $employee=="") { ?> hidden <?php } ?>>
			                								<label class="form-label">Select Employee</label>
			                								<select multiple="multiple" class="filter-multi" style="display: none;"  name="allemployee[]">
			                									<?php foreach($employees as $employee) { ?>
			                									<option value="<?php echo $employee->user_id;?>" <?php if(in_array($employee->user_id, $allEmployee)) { ?> selected <?php } ?>><?php echo $employee->username;?></option>
															<?php } ?>
			                								</select>
			                							</div>
			                						</div>
													<?php //} ?>
			                						<!-- Package -->
			                						<div class="col-xl-2 mb-3">
			                							<label class="form-label" for="package">Package</label>
				                						<div class="form-group">
				                                       		<div class="custom-controls">
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="package" value="all" <?php if($package=="all" || $package=="") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">All</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="package" value="specific" <?php if($package=="specific") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Specific</span>
				                                       			</label>	
				                                       		</div>
				                                       	</div>
			                						</div>
			                						<div class="col-xl-4">
			                							<div class="form-group" id="package_filter" <?php if($package=="all" || $package=="") { ?> hidden <?php } ?>>
			                								<label class="form-label">Select Package</label>
			                								<select multiple="multiple" class="filter-multi" style="display: none;" name="allpackage[]">
			                									<?php foreach($packages as $package) { ?>
			                									<option value="<?php echo $package->package_no;?>" <?php if(in_array($package->package_no, $allPackage)) { ?> selected <?php } ?>><?php echo $package->package_no;?></option>
																<?php } ?>
			                								</select>
			                							</div>
			                						</div>
			                					</div>
			                					<div class="form-row">
			                						<!-- Region -->
			                						<div class="col-xl-2 mb-3">
			                							<label class="form-label" for="region">Region</label>
				                						<div class="form-group">
				                                       		<div class="custom-controls">
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="region" value="all" <?php if($region=="all" || $region=="") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">All</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="region" value="specific"  <?php if($region=="specific") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Specific</span>
				                                       			</label>	
				                                       		</div>
				                                       	</div>
			                						</div>
			                						<div class="col-xl-4">
			                							<div class="form-group" id="region_filter"  <?php if($region=="all" || $region=="") { ?> hidden <?php } ?>>
			                								<label class="form-label">Select Region</label>
			                								<select multiple="multiple" class="filter-multi" style="display: none;" name="allregion[]">
			                									<?php foreach($regions as $region) { ?>
			                									<option value="<?php echo $region->region_id;?>" <?php if(in_array($region->region_id, $allRegion)) { ?> selected <?php } ?>><?php echo $region->region_name;?></option>
			                								<?php } ?>	
			                								</select>
			                							</div>
			                						</div>
			                						<!-- Circle -->
			                						<div class="col-xl-2 mb-3">
			                							<label class="form-label" for="circle">Circle</label>
				                						<div class="form-group">
				                                       		<div class="custom-controls">
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="circle" value="all" <?php if($circle=="all" || $circle=="") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">All</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="circle" value="specific" <?php if($circle=="specific") { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Specific</span>
				                                       			</label>	
				                                       		</div>
				                                       	</div>
			                						</div>
			                						<div class="col-xl-4">
			                							<div class="form-group" id="circle_filter" <?php if($circle=="all" || $circle=="") { ?> hidden <?php } ?>>
			                								<label class="form-label">Select Circle</label>
			                								<select multiple="multiple" class="filter-multi" style="display: none;" name="allcircle[]">
			                									<?php foreach($circles as $circle) { ?>
			                									<option value="<?php echo $circle->circle_id;?>" <?php if(in_array($circle->circle_id, $allCircle)) { ?> selected <?php } ?>><?php echo $circle->circle_name;?></option>
			                								<?php } ?>	
			                								</select>
			                							</div>
			                						</div>
			                					</div>
			                					<div class="form-row">
			                						<!-- NCR Status -->
			                						<div class="col-xl-3 mb-3">
			                							<label for="ncr-status" class="form-label">NCR Status</label>
				                                       	<select class="form-control select2" multiple id="ncr_status" name="ncr_status[]" >
				                                          	<option value="" disabled>Select NCR Status</option>
				                                          	<option value="All" <?php if(in_array("All", $ncr_status)) { ?> selected <?php } ?>>All</option>
				                                          	<option value="1" <?php if(in_array("1", $ncr_status)) { ?> selected <?php } ?>>Open</option>
				                                          	<option value="2" <?php if(in_array("2", $ncr_status)) { ?> selected <?php } ?>>Closed</option>
				                                        </select>
			                						</div>
			                					</div>
			                					<div class="form-row">
			                						<!-- Report Type -->
			                						<div class="col-xl-12 mb-3">
			                							<label class="form-label" for="reportType">Report Type<span class="text-red">*</span></label>
				                						<div class="form-group">
				                                       		<div class="custom-controls">
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="reportType" value="1" <?php if($reportType=='1') { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Package wise NCR Summary</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="reportType" value="2" <?php if($reportType=='2') { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Circle wise NCR Summary</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="reportType" value="3" <?php if($reportType=='3') { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">Feeder wise NCR Summary</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="reportType" value="4" <?php if($reportType=='4') { ?> checked <?php } ?>>
				                                       				<span class="custom-control-label">NCR Data</span>
				                                       			</label>
				                                       		</div>
				                                       	</div>
			                						</div>
			                					</div>

			                					<button class="btn btn-success mb-3 mt-3" type="submit" >Generate</button>
												<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('ncr-report')?>">Clear</a>
                                 				<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports')?>">Back</a>
			                				</form>
			                				<!-- Form Ends -->
			                			</div>
			                		</div>
			                	</div>
			                </div>
			                <!-- Row Ends -->

			                <!-- Report Row -->
			                <?php if (isset($reportData)) { ?>
				                <?php if (is_array($reportData)) { ?>
				                <div class="row" id="report-table">
				                	<div class="col-lg-12">
				                		<div class="card">
				                			<div class="card-body" <?php if(!isset($_POST['physicalProgressDate'])) { ?> style="background: #eeeef4;" <?php } ?>>
				                				<?php if(isset($_POST['physicalProgressDate'])) { ?>
				                				<?php if ($download_access) { ?>
				                				<div class="row">
				                					<!-- Export Button -->
				                					<div class="col-sm-12 col-md-9s mt-3">
					                                    <div class="dts-buttons btn-group flex-wrap" style="float:right;">
	 														<a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" type="button"><span>Export</span></a>
	 													</div>
					                                </div>	
				                				</div>
				                				<?php } ?>
				                				<?php } ?>
				                				<div class="row">
													<?php if($reportType=='1' && $reportType != "") { ?>
				                					<div class="table-responsive mb-3 mt-3" id="package-wise-table">
				                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
				                							<thead>
				                								<tr>
				                									<th>Package No.</th>
				                									<th>TKC</th>
				                									<th>#NCR Raise</th>
				                									<th>#NCR Closed</th>
				                									<th>#NCR Open</th>
				                								</tr>
				                							</thead>
				                							<tbody>
															<?php if(!empty($reportData)) { ?>
															<?php foreach($reportData as $report) { ?>
				                								<tr>
				                									<td><?php echo $report->package_no;?></td>
				                									<td><?php echo $report->contractor_name;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_raised;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_closed;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_open;?></td>
				                								</tr>
				                							<?php } ?>	
															<?php } ?>	
				                							</tbody>
				                						</table>
				                					</div>
													<?php } ?>
													<?php if($reportType=='2' && $reportType != "") { ?>
				                					<div class="table-responsive mb-3 mt-3" id="circle-wise-table">
				                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
				                							<thead>
				                								<tr>
				                									<th>Package No.</th>	
				                									<th>TKC</th>	
				                									<th>Circle</th>	
				                									<th>#NCR Raised</th>	
				                									<th>#NCR Closed</th>	
				                									<th>#NCR Open</th>	
				                								</tr>
				                							</thead>
				                							<tbody>
															<?php if(!empty($reportData)) { ?>
				                								<?php foreach($reportData as $report) { ?>
				                								<tr>
				                									<td><?php echo $report->package_no;?></td>
				                									<td><?php echo $report->contractor_name;?></td>
																	<td><?php echo $report->circle_name;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_raised;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_closed;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_open;?></td>
				                								</tr>
				                							<?php } ?>	
				                								<?php } ?>	
				                							</tbody>
				                						</table>
				                					</div>
													<?php } ?>
													<?php if($reportType=='3' && $reportType != "") { ?>
				                					<div class="table-responsive mb-3 mt-3" id="feeder-wise-table" >
				                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
				                							<thead>
				                								<tr>
				                									<th>Package No.</th>
				                									<th>TKC</th>
				                									<th>Circle</th>
				                									<th>Feeder ID</th>
				                									<th>Feeder Name</th>
				                									<th>Substation</th>
				                									<th>#NCR Raised</th>
				                									<th>#NCR Closed</th>
				                									<th>#NCR Open</th>
				                								</tr>
				                							</thead>
				                							<tbody>
															<?php if(!empty($reportData)) { ?>
															<?php foreach($reportData as $report) { ?>
				                								<tr>
				                									<td><?php echo $report->package_no;?></td>
				                									<td><?php echo $report->contractor_name;?></td>
																	<td><?php echo $report->circle_name;?></td>
				                									<td><?php echo $report->feeder_id;?></td>
				                									<td><?php echo $report->feeder_name;?></td>
				                									<td><?php echo $report->substation;?></td>
																	<td class="table-td-center"><?php echo $report->ncr_raised;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_closed;?></td>
				                									<td class="table-td-center"><?php echo $report->ncr_open;?></td>
				                								</tr>
																<?php } ?>
				                							<?php } ?>
				                							</tbody>
				                						</table>
				                					</div>
													<?php } ?>
													<?php if($reportType=='4' && $reportType != "") { ?>
				                					<div class="table-responsive mb-3 mt-3" id="ncr-data-table">
				                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
				                							<thead>
				                								<tr>
				                									<th>NCR No.</th>	
				                									<th>NCR Date</th>	
				                									<th>Package</th>	
				                									<th>TKC</th>	
				                									<th>Region</th>	
				                									<th>Circle</th>	
				                									<th>Division</th>	
				                									<th>Feeder ID</th>	
				                									<th>Feeder Name</th>	
				                									<th>Substation</th>	
				                									<th>Inspected By</th>	
				                									<th>Observation Type</th>	
				                									<th>Observation</th>	
				                									<th>Status</th>	
				                									<th>Closed Date</th>	
				                									<th>Delay Time</th>	
				                									<th>Action Taken</th>	
				                								</tr>
				                							</thead>
				                							<tbody>
															<?php if(!empty($reportData)) { ?>
															<?php foreach($reportData as $report) { ?>

				                								<tr>
				                									<td><?php echo $report->ncr_id;?></td>
				                									<td><?php echo date('d-m-Y', strtotime($report->ncr_date));?></td>
																	<td><?php echo $report->package_no;?></td>
				                									<td><?php echo $report->contractor_name;?></td>
				                									<td><?php echo $report->region_name;?></td>
				                									<td><?php echo $report->circle_name;?></td>
																	<td><?php echo $report->division_name;?></td>
																	<td><?php echo $report->feeder_id;?></td>
																	<td><?php echo $report->feeder_name;?></td>
																	<td><?php echo $report->substation;?></td>
																	<td><?php echo $report->Inspected_by;?></td>
																	<td><?php echo $report->observation_type;?></td>
																	<td><?php echo $report->observation;?></td>
																	<td><?php echo $report->status;?></td>
																	<td><?php echo $report->closed_date;?></td>
																	<td><?php echo $report->delay_time;?></td>
																	<td><?php echo $report->action_taken;?></td>
																	
				                								</tr>
																<?php } ?>
																<?php } ?>
				                								
				                							</tbody>
				                						</table>
				                					</div>
													<?php } ?>
				                				</div>
				                			</div>
				                		</div>
				                	</div>
				                </div>	
				                <?php } else { ?>
				                <div class="row">
				                  	<div class="col-lg-12">
				                    	<div class="card">
				                    		<div class="card-body">
				                      			<div class="row">
				                        			<h4 class="pt-3"><strong><?php echo $reportData; ?></strong></h4>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				               	</div>
				                <?php } ?>	
			                <?php } ?>
			                <!-- Report Row Ends -->

		        		</div>
		        		<!-- CONTAINER ENDS-->

		        	</div>
		        </div>
		        <!--app-content close-->
			</div>

			<!-- Footer -->
            <?php $this->load->view('include/footer');?>
		    <!-- Footer Ends -->

		</div>
		<!-- PAGE ENDS-->

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
	   <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.php5.min.js'); ?>"></script>
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

	   	<script type="text/javascript">
	   	$('input[name="physicalProgressDate"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('input[name="physicalProgressDate"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') +' - '+ picker.endDate.format('DD-MM-YYYY'));
            // $(this).val();
         });

        $('input[name="employee"]').on('change', function() {
        	let employee = $(this).val();
        	if (employee == 'specific') {
        		$('#employee_filter').removeAttr('hidden');
        	} else if (employee == 'all') {
        		$('#employee_filter').attr('hidden', 'hidden');
        	}
        });

        $('input[name="package').on('change', function() {
        	let package = $(this).val();
        	if (package == 'specific') {
        		$('#package_filter').removeAttr('hidden');
        	} else if (package == 'all') {
        		$('#package_filter').attr('hidden', 'hidden');
        	}
        });

        $('input[name="region"]').on('change', function() {
        	let region = $(this).val();
        	if (region == 'specific') {
        		$('#region_filter').removeAttr('hidden');
        	} else if (region == 'all') {
        		$('#region_filter').attr('hidden', 'hidden');
        	}
        });

        $('input[name="circle"]').on('change', function() {
        	let circle = $(this).val();
        	if (circle == 'specific') {
        		let region_filter = $('input[name="region"]:checked').val();

        		if (region_filter == 'specific') {
        			let selected_region = $('select[name="allregion[]"]').find(':selected');
        			let selected_region_ids = [];

        			$.each(selected_region, function(index, value) {
						selected_region_ids.push($(value).val());
	        		});

	        		if (!$.isEmptyObject(selected_region_ids)) {
	        			let circle_data = <?php echo json_encode($circle_data) ?>;
	        			let circle_html = '';
	        			$.each(selected_region_ids, function(index, value) {
	        				let circles = circle_data[value];
	        				
	        				$.each(circles, function(circle_id, circle_name) {
	        					circle_html += '<option value="'+ circle_id+'">'+circle_name+'</option>';
	        				});
	        			});
	        			
	        			$('select[name="allcircle[]"]').empty().append(circle_html);
	        			$('select[name="allcircle[]"]').multipleSelect();
	        		}
        		} else if (region_filter == 'all') {
        			let circle_data = <?php echo json_encode($circles) ?>;
        			
        			let circle_html = '';

        			$.each(circle_data, function(index, value) {
    					circle_html += '<option value="'+ value.circle_id +'">'+ value.circle_name +'</option>';
    				});
    			
    				$('select[name="allcircle[]"]').empty().append(circle_html);
    				$('select[name="allcircle[]"]').multipleSelect();
        		}

        		$('#circle_filter').removeAttr('hidden');
        	} else if (circle == 'all') {
        		$('#circle_filter').attr('hidden', 'hidden');
        	}
        });

	   	function showReport() {
	   		let option = $('input[name="reportType"]:checked').val();
	   		// console.log(option); return false;

	   		$('#report-table').removeAttr('hidden');

	   		switch(option) {
			  	case 'package_wise':
			    	$('#package-wise-table').removeAttr('hidden');

					var circle_attr = $('#circle-wise-table').attr('hidden');
					if (typeof circle_attr == 'undefined') {
		   				$('#circle-wise-table').attr('hidden', true);
		   			}

		   			var feeder_attr = $('#feeder-wise-table').attr('hidden');
					if (typeof feeder_attr == 'undefined') {
		   				$('#feeder-wise-table').attr('hidden', true);
		   			}

		   			var ncr_attr = $('#ncr-data-table').attr('hidden');
					if (typeof ncr_attr == 'undefined') {
		   				$('#ncr-data-table').attr('hidden', true);
		   			}
			    break;
			  	case 'circle_wise':
					$('#circle-wise-table').removeAttr('hidden');

					var package_attr = $('#package-wise-table').attr('hidden');
					if (typeof package_attr == 'undefined') {
		   				$('#package-wise-table').attr('hidden', true);
		   			}

		   			var feeder_attr = $('#feeder-wise-table').attr('hidden');
					if (typeof feeder_attr == 'undefined') {
		   				$('#feeder-wise-table').attr('hidden', true);
		   			}

		   			var ncr_attr = $('#ncr-data-table').attr('hidden');
					if (typeof ncr_attr == 'undefined') {
		   				$('#ncr-data-table').attr('hidden', true);
		   			}
			    break;
				case 'feeder_wise':
			    	$('#feeder-wise-table').removeAttr('hidden');

			    	var package_attr = $('#package-wise-table').attr('hidden');
					if (typeof package_attr == 'undefined') {
		   				$('#package-wise-table').attr('hidden', true);
		   			}

		   			var circle_attr = $('#circle-wise-table').attr('hidden');
					if (typeof circle_attr == 'undefined') {
		   				$('#circle-wise-table').attr('hidden', true);
		   			}

		   			var ncr_attr = $('#ncr-data-table').attr('hidden');
					if (typeof ncr_attr == 'undefined') {
		   				$('#ncr-data-table').attr('hidden', true);
		   			}
			    break;
				case 'ncr_data':
			    	$('#ncr-data-table').removeAttr('hidden');

			    	var package_attr = $('#package-wise-table').attr('hidden');
					if (typeof package_attr == 'undefined') {
		   				$('#package-wise-table').attr('hidden', true);
		   			}

		   			var circle_attr = $('#circle-wise-table').attr('hidden');
					if (typeof circle_attr == 'undefined') {
		   				$('#circle-wise-table').attr('hidden', true);
		   			}

		   			var feeder_attr = $('#feeder-wise-table').attr('hidden');
					if (typeof feeder_attr == 'undefined') {
		   				$('#feeder-wise-table').attr('hidden', true);
		   			}
			    break;
			  	default:
			    	break;
			}
	   	}

	   	$('#generateNCRReport').submit(function(event) {
	   		let pp_date = $('#physicalProgressDate').val();

	   		let checked_report_type_count = $('input[name="reportType"]:checked').length;

	   		if (pp_date == '' && checked_report_type_count == 0) {
	   			$('.toast-body').text('Select mandatory filters to generate the report');
           		$('.toast').toast('show');

           		event.preventDefault();
	   		} else if (pp_date == '') {
	   			$('.toast-body').text('Select Physical Progress Date range');
           		$('.toast').toast('show');

           		event.preventDefault();
	   		} else if (checked_report_type_count == 0) {
	   			$('.toast-body').text('Select Report Type');
           		$('.toast').toast('show');

           		event.preventDefault();
	   		}
	   	});
	   	
	   	</script>

	</body>
</html>