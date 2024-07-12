<!DOCTYPE html>
<html  lang="en" dir="ltr">

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

        			<!-- <div class="row">
        				<?php //if ($sheet_data['is_inrange'] == 0) { ?>
                		<p class="fs-6 mb-0">This entry is made beyond permissible limit of 5KM from the site location</p>	
                		<?php //} ?>
        			</div> -->
                			
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

              			<!-- <form class="needs-validation" novalidate> -->
	                  <form id="addPhysicalProgressSheet" method="post" enctype="multipart/form-data" action="<?php echo base_url('save-physical-progress'); ?>">
	                  	
	                  	<!-- Physical Progress ID -->
	                  	<input type="hidden" id="physical_progress_id" name="physical_progress_id" value="<?php echo $sheet_data['physical_progress_id']; ?>">

	                  	<?php if (!isset($sheet_type)) { ?>
	                  		<!-- Previous Physical Progress ID -->
	                  		<input type="hidden" id="prev_physical_progress_id" name="prev_physical_progress_id" 	value="<?php echo $sheet_data['prev_physical_progress_id']; ?>">
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
															<!-- <button  type="button" class="btn btn-primary" style="background: rgb(179 103 0) !important; border-color: rgb(179 103 0) !important;"><?php echo strtoupper($sheet_data['sheet_status']); ?></button> -->
															<button  type="button" class="btn btn-primary"><?php echo strtoupper($sheet_data['sheet_status']); ?></button>
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
	                      <div class="row war-pop" id="observation-notification-alert" hidden>
	                      	<div class="col-xl-3 col-sm-6 war-pop-1">
	                      		<div class="card border p-0 pb-3">
	                      			<div class="card-header border-0 pt-3">
	                      				<div class="card-options">
	                      					<a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove">
	                      						<i class="fe fe-x"></i>
	                      					</a>
	                      				</div>
	                      			</div>
	                      			<div class="card-body text-center">
	                      				<span class="">
	                      					<svg xmlns="http://www.w3.org/2000/svg" height="60" width="60" viewBox="0 0 24 24">
	                      						<path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"></path>
	                      						<circle cx="12" cy="17" r="1" fill="#e62a45"></circle>
	                      						<path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"></path>
	                      					</svg>
	                      				</span>
	                      				<h4 class="h4 mb-0 mt-3">Warning</h4>
	                      				<p class="card-text notification-text">Are you sure you want to delete 20 items</p>
	                      			</div>
	                      			<div class="card-footer text-center border-0 pt-0">
	                      				<div class="row">
	                      					<div class="text-center">
	                      						<a href="javascript:void(0)" class="btn btn-danger notification-delete" data-contract-location-id="" data-activity-id="" data-activity-type="" onclick="deleteAppliedObservations(this)">Delete</a>
	                      						<a href="javascript:void(0)" class="btn btn-white me-2" onclick="closeNotificationAlert(this)">Cancel</a>
	                      					</div>
	                      				</div>
	                      			</div>
	                      		</div>
	                      	</div>	
	                      </div>
              					<!-- Row6 Tabs-->
              					<?php if (!empty($sheet_data['activities_list'])) { ?>
              					<div class="form-row">
              						<div class="col-xl-12 mb-3 mt-3">
              							<div class="panel panel-primary">
              								<div class="tab-menu-heading tab-menu-heading-boxed">
              									<div class="tabs-menu-boxed">
	                      					<!-- Tabs -->
	                        				<ul class="nav panel-tabs" role="tablist">
	                        					<?php foreach ($sheet_data['activities_group_name'] as $key => $value) { ?>
	                        					<?php if (preg_match('/^\d/', $value['name'])) {
                    												$tab_name_arr = explode(' ', $value['name']);
                    												$tab_name_str = str_replace($tab_name_arr[0].' ', '', $value['name']);
                    												$tab = strtolower(str_replace(' ', '-', $tab_name_str.' '.$tab_name_arr[0]));
                    											} else {
                    												if (str_contains($value['name'], '/')) {
																							$value['name'] = str_replace('/', ' ', $value['name']);
																						}
                    												$tab = strtolower(str_replace(' ', '-', $value['name']));
                    											}
                    								?>
	                        					<?php $active = ($key == 0) ? 'active' : ''; ?>
	                        					<?php $aria = ($key == 0) ? 'aria-selected="true"': ''; ?>
	                        					<li>
				              								<a class="<?php echo $active; ?>" href="#<?php echo $tab; ?>" <?php echo $active; ?> data-bs-toggle="tab" <?php echo $aria; ?> role="tab"><?php echo $value['name']; ?></a>
			              								</li>
	                        					<?php } ?>
			                        		</ul>
	                        				<!-- Tabs End-->
                        				</div>
	                        		</div>

	                        		<!-- Tabs body -->
              								<div class="panel-body tabs-menu-body">
                        				<div class="tab-content">
                        					<?php foreach ($sheet_data['activities_list'] as $key => $value) { ?>
                        						<?php $active = ($key === 0) ? 'active' : ''; ?>
                        						<?php foreach ($value as $k1 => $v1) { ?>
                        							<?php if (preg_match('/^\d/', $k1)) {
	                        										$tab_name_arr = explode(' ', $k1);
	                        										$tab_name_str = str_replace($tab_name_arr[0].' ', '', $k1);
	                        										$tab_id = strtolower(str_replace(' ', '-', $tab_name_str.' '.$tab_name_arr[0]));
	                        									} else {
	                        										$tab_id = strtolower(str_replace(' ', '-', $k1));
	                        									}
	                        						?>                        							
	                        						<div class="tab-pane <?php echo $active; ?>" id="<?php echo $tab_id; ?>" role="tabpanel">
	                        							<div class="table-responsive">
	                        								<?php $table_id = strtolower(str_replace(' ', '-', $k1)).'-edit'; ?>
	                        								<table class="table table-bordered border mb-0" id="<?php echo $table_id; ?>" data-tablename = "<?php echo $k1; ?>" data-activity-index="<?php echo $key; ?>">
	                        									<thead>
																							<tr>
																								<?php if ($k1 == 'Civil Work') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th style="width: 150px;">
																									Status
																									<a class="me-4" href="javascript:void(0)" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-secondary only-body" data-bs-content="Yes - Completed with/without NCR(s), No - Not yet started, NA - Not applicable, WIP - Work in progress">
																										<svg xmlns="http://www.w3.org/2000/svg" class="svg-secondary" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
																											<path d="M0 0h24v24H0V0z" fill="none"/>
																											<path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
																										</svg>
																									</a>
																								</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } elseif ($k1 == 'Sub-station Items') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th style="width: 150px;">
																									Status
																									<a class="me-4" href="javascript:void(0)" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-secondary only-body" data-bs-content="Yes - Completed with/without NCR(s), No - Not yet started, NA - Not applicable, WIP - Work in progress">
																										<svg xmlns="http://www.w3.org/2000/svg" class="svg-secondary" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
																											<path d="M0 0h24v24H0V0z" fill="none"/>
																											<path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
																										</svg>
																									</a>
																								</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } elseif ($k1 == '33kv Feeder') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<!-- <th style="width: 150px;">Status</th> -->
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } elseif ($k1 == '11kv Feeder') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<!-- <th style="width: 150px;">Status</th> -->
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } elseif ($k1 == 'Electrical') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th style="width: 150px;">
																									Status
																									<a class="me-4" href="javascript:void(0)" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-secondary only-body" data-bs-content="Yes - Completed with/without NCR(s), No - Not yet started, NA - Not applicable, WIP - Work in progress">
																										<svg xmlns="http://www.w3.org/2000/svg" class="svg-secondary" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
																											<path d="M0 0h24v24H0V0z" fill="none"/>
																											<path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
																										</svg>
																									</a>
																								</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } elseif ($k1 == '11kv Feeder Separation') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<!-- <th style="width: 150px;">Status</th> -->
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } elseif ($k1 == '33kv Interconnection Line' || $k1 == '11 kv Bifurcation' || $k1 == '11 kv Interconnection' || $k1 == '33 kv Augmentation' || $k1 == '11 kv Augmentation' || $k1 == 'Additional DTR' || $k1 == 'Bare to Cable' || $k1 == 'Cable Augmentation' || $k1 == 'DL to AG/Coated conductor' || $k1 == 'Substation Rennovation' || $k1 == 'Mix DTR') { ?>
																								<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<!-- <th style="width: 150px;">Status</th> -->
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
																								<th>Observation Type</th>
																								<th>Observation</th>
																								<th>File Upload</th>
																								<?php } ?>
																							</tr>
																						</thead>
																						<tbody>
																						<?php if ($k1 == 'Civil Work') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																							<!-- tr open -->
																							<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																								<!-- Seq No -->
																								<td><?php echo $v2['seqno']; ?></td>
																								<!-- Activity Name -->
																								<td><?php echo $v2['activity']; ?></td>
																								<!-- Status -->
																								<td>
																									<div class="custom-controls">
																										<?php $radio_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<!-- Sheet Status: Open -->
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="yes">
																												<span class="custom-control-label">Yes</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="wip">
																												<span class="custom-control-label">WIP</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="no" checked>
																												<span class="custom-control-label">No</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="na">
																												<span class="custom-control-label">NA</span>
																											</label>
																										<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<!-- Sheet Status: In Process || Completed  || Reviewed -->
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="<?php echo ($v2['status_id'] == 1) ? 'yes' : (($v2['status_id'] == 2) ? 'yes-partial' : 'yes'); ?>" <?php echo ($v2['status_id'] == 1 || $v2['status_id'] == 2) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">Yes</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="wip" <?php echo ($v2['status_id'] == 4) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">WIP</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="no" <?php echo ($v2['status_id'] == 0) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">No</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="na" <?php echo ($v2['status_id'] == 3) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">NA</span>
																											</label>
																										<?php } ?>
																									</div>
																								</td>
																								<!-- Observations -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="observation"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="observation">
																										<?php if (($v2['status_id'] == 1 || $v2['status_id'] == 2) && !empty($v2['observations_list'])) {
																														$row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																														$obs_list_count = count($v2['applied_observations']);
																														$obs_complete_count = 0;
																														$ncr_submitted_by_tkc_count = 0;
																														foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																															if (!empty($aovalue['completion_photos'])) {
																																$obs_complete_count++;
																															}

																															if ($aovalue['observation_status'] == 'Submitted by TKC') {
																																$ncr_submitted_by_tkc_count++;
																															}
																														}

																														if ($obs_list_count > 0) {
																															$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																														}
																										?>
																										<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																										<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withoutBOQ" onclick="showObservationsList(this)">
																											<span class="fe fe-more-vertical"> </span>
																										</button>
																										<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																										<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																										<?php } ?>
																										<?php } ?>
																									</td>
																								<?php } ?>
																								<!-- Remark -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="remark"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="remark">
																										<?php $obs_remarks = []; ?>
																										<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (empty($aovalue['completion_photos'])) {
																															array_push($obs_remarks, $aovalue['remark']);
																														}
																													}
																										?>
																										<?php echo implode(', ', $obs_remarks); ?>
																									</td>
																								<?php } ?>
																								<!-- File Upload -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="fileupload"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="fileupload">
																										<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (empty($aovalue['completion_photos'])) {
																															foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																										?>
																										<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																											<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																										</a>
																										<?php			}
																														}
																													}
																										?>
																									</td>
																								<?php } ?>
																							</tr>
																							<!-- tr close -->
																							<?php } ?>
																						<?php } elseif ($k1 == 'Sub-station Items') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																							<!-- tr open -->
																							<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																								<!-- Seq No -->
																								<td><?php echo $v2['seqno']; ?></td>
																								<!-- Activity Name -->
																								<td><?php echo $v2['activity']; ?></td>
																								<!-- Status -->
																								<td>
																									<div class="custom-controls">
																										<?php $radio_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<!-- Sheet Status: Open -->
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="yes">
																												<span class="custom-control-label">Yes</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="wip">
																												<span class="custom-control-label">WIP</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="no" checked>
																												<span class="custom-control-label">No</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="na">
																												<span class="custom-control-label">NA</span>
																											</label>
																										<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<!-- Sheet Status: In Process || Completed || Reviewed -->
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="<?php echo ($v2['status_id'] == 1) ? 'yes' : (($v2['status_id'] == 2) ? 'yes-partial' : 'yes'); ?>" <?php echo ($v2['status_id'] == 1 || $v2['status_id'] == 2) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">Yes</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="wip" <?php echo ($v2['status_id'] == 4) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">WIP</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="no" <?php echo ($v2['status_id'] == 0) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">No</span>
																											</label>
																											<label class="custom-control custom-radio status-radio">
																												<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="na" <?php echo ($v2['status_id'] == 3) ? 'checked' : ''; ?>>
																												<span class="custom-control-label">NA</span>
																											</label>
																										<?php } ?>
																									</div>
																								</td>
																								<!-- Observations -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="observation"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="observation">
																										<?php if ($v2['status_id'] == 1 && !empty($v2['observations_list'])) {
																														$row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																														$obs_list_count = count($v2['applied_observations']);
																														$obs_complete_count = 0;
																														$ncr_submitted_by_tkc_count = 0;
																														foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																															if (!empty($aovalue['completion_photos'])) {
																																$obs_complete_count++;
																															}

																															if ($aovalue['observation_status'] == 'Submitted by TKC') {
																																$ncr_submitted_by_tkc_count++;
																															}
																														}

																														if ($obs_list_count > 0) {
																															$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																														}
																										?>
																										<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																										<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withoutBOQ" onclick="showObservationsList(this)">
																											<span class="fe fe-more-vertical"> </span>
																										</button>
																										<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																										<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																										<?php } ?>
																										<?php } ?>
																									</td>
																								<?php } ?>
																								<!-- Remark -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="remark"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process  || Completed-->
																									<td class="remark">
																										<?php $obs_remarks = []; ?>
																										<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (empty($aovalue['completion_photos'])) {
																															array_push($obs_remarks, $aovalue['remark']);
																														}
																													}
																										?>
																										<?php echo implode(', ', $obs_remarks); ?>
																									</td>
																								<?php } ?>
																								<!-- File Upload -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<td class="fileupload"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="fileupload">
																										<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (empty($aovalue['completion_photos'])) {
																															foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																										?>
																										<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																											<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																										</a>
																										<?php			}
																														}
																													}
																										?>
																									</td>
																								<?php } ?>
																							</tr>
																							<!-- tr close -->
																							<?php } ?>
																						<?php } elseif ($k1 == '33kv Feeder') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																								<!-- tr open -->
																								<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																									<!-- Calculating Observation Flag -->
																									<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_observation_'.$v2['typeofwork_activity_id']; ?>
																									<?php $observation_flag = 'no observation'; ?>
																									<?php if (isset($v2['applied_observations']) && !empty($v2['applied_observations'])) {
																													$obs_list_count = count($v2['applied_observations']);
																													$obs_complete_count = 0;
																													foreach ($v2['applied_observations'] as $aokey => $aovalue)
																													{
																														if (!empty($aovalue['completion_photos'])) {
																															$obs_complete_count++;
																														}
																													}

																													$observation_flag = ($obs_complete_count == $obs_list_count) ? 'observation complete' : 'observation pending';
																									} ?>
																									<input type="hidden" name="<?php echo $hidden_input_name ?>" value="<?php echo $observation_flag; ?>">
																									<!-- Calculating Observation Flag Ends-->
																									<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($userdata['role'] == 'Field Engineer' || $userdata['role'] == 'Admin' || $userdata['role'] == 'Field Supervisor') { ?>
																										<input class="form-control form-control-sm mb-4" type="text" name="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } else { ?>
																										<?php echo $v2['boq']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } ?>
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } else if ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php //$erected_qty = ($v2['erected_qty'] == 0) ? '': $v2['erected_qty']; 
																														$erected_qty = (isset($v2['erected_qty'])) ? (($v2['erected_qty'] == 0) ? '' : $v2['erected_qty']) : '';
																											?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>																										
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>	
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0 && $v2['boq'] != 0) {
																														$erected_qty = $v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format(($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
																									<?php } ?>
																									<!-- Observations -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="observation"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="observation">
																											<?php if (isset($v2['status_id'])) { ?>
																												<?php if (($v2['status_id'] == 1 || $v2['status_id'] == 2) && !empty($v2['observations_list'])) 
																														{
																																$row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																																$obs_list_count = count($v2['applied_observations']);
																																$obs_complete_count = 0;
																																$ncr_submitted_by_tkc_count = 0;
																																foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																	if (!empty($aovalue['completion_photos'])) {
																																		$obs_complete_count++;
																																	}

																																	if ($aovalue['observation_status'] == 'Submitted by TKC')
																																	{
																																		$ncr_submitted_by_tkc_count++;
																																	}
																																}

																																if ($obs_list_count > 0) {
																																	$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																																}

																																$observation_flag = ($obs_list_count == 0) ? 'no observation' : (($obs_complete_count == $obs_list_count) ? 'observation complete' : 'observation pending');
																												?>
																												<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																												<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withBOQ" onclick="showObservationsList(this)">
																													<span class="fe fe-more-vertical"> </span>
																												</button>
																												<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																												<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																												<?php } ?>
																												<?php } ?>
																											<?php } ?>																						
																										</td>
																									<?php } ?>
																									<!-- Remark -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="remark"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="remark">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php $obs_remarks = []; ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	array_push($obs_remarks, $aovalue['remark']);
																																}
																															}
																												?>
																												<?php echo implode(', ', $obs_remarks); ?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- File Upload -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="fileupload"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="fileupload">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																												?>						
																												<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																													<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																												</a>
																												<?php			}
																																}
																															}
																												?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																								</tr>
																								<!-- tr close -->
																							<?php } ?>
																						<?php } elseif ($k1 == '11kv Feeder') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																								<!-- tr open -->
																								<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																									<!-- Calculating Observation Flag -->
																									<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_observation_'.$v2['typeofwork_activity_id']; ?>
																									<?php $observation_flag = 'no observation'; ?>
																									<?php if (isset($v2['applied_observations']) && !empty($v2['applied_observations'])) {
																													$obs_list_count = count($v2['applied_observations']);
																													$obs_complete_count = 0;
																													foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (!empty($aovalue['completion_photos'])) {
																															$obs_complete_count++;
																														}
																													}

																													$observation_flag = ($obs_complete_count == $obs_list_count) ? 'observation complete' : 'observation pending';
																									} ?>
																									<input type="hidden" name="<?php echo $hidden_input_name ?>" value="<?php echo $observation_flag; ?>">
																									<!-- Calculating Observation Flag Ends-->
																									<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($userdata['role'] == 'Field Engineer' || $userdata['role'] == 'Admin' || $userdata['role'] == 'Field Supervisor') { ?>
																										<input class="form-control form-control-sm mb-4" type="text" name="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } else { ?>
																										<?php echo $v2['boq']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } ?>
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } else if ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php //$erected_qty = ($v2['erected_qty'] == 0) ? '': $v2['erected_qty']; 
																														$erected_qty = (isset($v2['erected_qty'])) ? (($v2['erected_qty'] == 0) ? '' : $v2['erected_qty']) : '';
																											?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>	
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0  && $v2['boq'] != 0) {
																														$erected_qty = $v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format(($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
																									<?php } ?>
																									<!-- Observations -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="observation"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="observation">
																											<?php if (isset($v2['status_id'])) { ?>
																												<?php if (($v2['status_id'] == 1 || $v2['status_id'] == 2) && !empty($v2['observations_list'])) { ?>
																													<?php $row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																																$obs_list_count = count($v2['applied_observations']);
																																$obs_complete_count = 0;
																																$ncr_submitted_by_tkc_count = 0;
																																foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																	if (!empty($aovalue['completion_photos'])) {
																																		$obs_complete_count++;
																																	}

																																	if ($aovalue['observation_status'] == 'Submitted by TKC')
																																	{
																																		$ncr_submitted_by_tkc_count++;
																																	}
																																}

																																if ($obs_list_count > 0) {
																																	$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																																}
																													?>
																													<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																													<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withBOQ" onclick="showObservationsList(this)">
																														<span class="fe fe-more-vertical"> </span>
																													</button>
																													<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																													<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																													<?php } ?>
																												<?php } ?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- Remark -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="remark"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="remark">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php $obs_remarks = []; ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	array_push($obs_remarks, $aovalue['remark']);
																																}
																															}
																												?>
																												<?php echo implode(', ', $obs_remarks); ?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- File Upload -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="fileupload"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="fileupload">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																												?>
																												<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																													<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																												</a>
																												<?php			}
																																}
																															}
																												?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																								</tr>
																								<!-- tr close -->
																							<?php } ?>
																						<?php } elseif ($k1 == 'Electrical') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																							<!-- tr open -->
																							<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																								<!-- Seq No -->
																								<td><?php echo $v2['seqno']; ?></td>
																								<!-- Activity Name -->
																								<td><?php echo $v2['activity']; ?></td>
																								<!-- Status -->
																								<td>
																									<div class="custom-controls">
																									<?php $radio_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="yes">
																											<span class="custom-control-label">Yes</span>
																										</label>
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="wip">
																											<span class="custom-control-label">WIP</span>
																										</label>
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="no" checked>
																											<span class="custom-control-label">No</span>
																										</label>
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="na">
																											<span class="custom-control-label">NA</span>
																										</label>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input two-way" name="<?php echo $radio_name; ?>" value="<?php echo ($v2['status_id'] == 1) ? 'yes' : (($v2['status_id'] == 2) ? 'yes-partial' : 'yes'); ?>" <?php echo ($v2['status_id'] == 1 || $v2['status_id'] == 2) ? 'checked' : ''; ?>>
																											<span class="custom-control-label">Yes</span>
																										</label>
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="wip" <?php echo ($v2['status_id'] == 4) ? 'checked' : ''; ?>>
																											<span class="custom-control-label">WIP</span>
																										</label>
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="no" <?php echo ($v2['status_id'] == 0) ? 'checked' : ''; ?>>
																											<span class="custom-control-label">No</span>
																										</label>
																										<label class="custom-control custom-radio status-radio">
																											<input type="radio" class="custom-control-input" name="<?php echo $radio_name; ?>" value="na" <?php echo ($v2['status_id'] == 3) ? 'checked' : ''; ?>>
																											<span class="custom-control-label">NA</span>
																										</label>
																									<?php } ?>
																									</div>
																								</td>
																								<!-- Observations -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="observation"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="observation">
																										<?php if (($v2['status_id'] == 1 || $v2['status_id'] == 2) && !empty($v2['observations_list'])) {
																														$row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																														$obs_list_count = count($v2['applied_observations']);
																														$obs_complete_count = 0;
																														$ncr_submitted_by_tkc_count = 0;
																														foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																															if (!empty($aovalue['completion_photos'])) {
																																$obs_complete_count++;
																															}

																															if ($aovalue['observation_status'] == 'Submitted by TKC')
																															{
																																$ncr_submitted_by_tkc_count++;
																															}
																														}

																														if ($obs_list_count > 0) {
																															$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																														}
																										?>
																										<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																										<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withoutBOQ" onclick="showObservationsList(this)">
																											<span class="fe fe-more-vertical"> </span>
																										</button>
																										<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																										<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																										<?php } ?>
																										<?php } ?>
																									</td>
																								<?php } ?>
																								<!-- Remark -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="remark"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="remark">
																										<?php $obs_remarks = []; ?>
																										<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (empty($aovalue['completion_photos'])) {
																															array_push($obs_remarks, $aovalue['remark']);
																														}
																													}
																										?>
																										<?php echo implode(', ', $obs_remarks); ?>
																									</td>
																								<?php } ?>
																								<!-- File Upload -->
																								<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<!-- Sheet Status: Open -->
																									<td class="fileupload"></td>
																								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																									<!-- Sheet Status: In Process || Completed || Reviewed -->
																									<td class="fileupload">
																										<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (empty($aovalue['completion_photos'])) {
																															foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																										?>
																										<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																											<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																										</a>
																										<?php			}
																														}
																													}
																										?>
																									</td>
																								<?php } ?>
																							</tr>
																							<!-- tr close -->
																							<?php } ?>
																						<?php } elseif ($k1 == '11kv Feeder Separation') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																								<!-- tr open -->
																								<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																									<!-- Calculating Observation Flag -->
																									<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_observation_'.$v2['typeofwork_activity_id']; ?>
																									<?php $observation_flag = 'no observation'; ?>
																									<?php if (isset($v2['applied_observations']) && !empty($v2['applied_observations'])) {
																													$obs_list_count = count($v2['applied_observations']);
																													$obs_complete_count = 0;
																													foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (!empty($aovalue['completion_photos'])) {
																															$obs_complete_count++;
																														}
																													}

																													$observation_flag = ($obs_complete_count == $obs_list_count) ? 'observation complete' : 'observation pending';
																									} ?>
																									<input type="hidden" name="<?php echo $hidden_input_name ?>" value="<?php echo $observation_flag; ?>">
																									<!-- Calculating Observation Flag Ends-->
																									<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($userdata['role'] == 'Field Engineer' || $userdata['role'] == 'Admin' || $userdata['role'] == 'Field Supervisor') { ?>
																										<input class="form-control form-control-sm mb-4" type="text" name="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } else { ?>
																										<?php echo $v2['boq']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } ?>
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } else if ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php //$erected_qty = (isset($v2['erected_qty']) && $v2['erected_qty'] == 0) ? '': $v2['erected_qty']; 
																														$erected_qty = (isset($v2['erected_qty'])) ? (($v2['erected_qty'] == 0) ? '' : $v2['erected_qty']) : '';
																											?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>																										
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>
																									<?php } else if ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0  && $v2['boq'] != 0) { 
																														$erected_qty = $v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format(($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
																									<?php } ?>																									
																									<!-- Observations -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="observation"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="observation">
																											<?php if (isset($v2['status_id'])) { ?>
																												<?php if (($v2['status_id'] == 1 || $v2['status_id'] == 2) && !empty($v2['observations_list'])) { ?>
																													<?php $row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																																$obs_list_count = count($v2['applied_observations']);
																																$obs_complete_count = 0;
																																$ncr_submitted_by_tkc_count = 0;
																																foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																	if (!empty($aovalue['completion_photos'])) {
																																		$obs_complete_count++;
																																	}

																																	if ($aovalue['observation_status'] == 'Submitted by TKC')
																																	{
																																		$ncr_submitted_by_tkc_count++;
																																	}
																																}

																																if ($obs_list_count > 0) {
																																	$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																																}
																													?>
																													<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																													<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withBOQ" onclick="showObservationsList(this)">
																														<span class="fe fe-more-vertical"> </span>
																													</button>
																													<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																													<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																													<?php } ?>
																												<?php } ?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- Remark -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="remark"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="remark">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php $obs_remarks = []; ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	array_push($obs_remarks, $aovalue['remark']);
																																}
																															}
																												?>
																												<?php echo implode(', ', $obs_remarks); ?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- File Upload -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="fileupload"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="fileupload">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																												?>
																												<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																													<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																												</a>
																												<?php			}
																																}
																															}
																												?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																								</tr>
																								<!-- tr close -->
																							<?php } ?>
																						<?php } elseif ($k1 == '33kv Interconnection Line' || $k1 == '11 kv Bifurcation' || $k1 == '11 kv Interconnection' || $k1 == '33 kv Augmentation' || $k1 == '11 kv Augmentation' || $k1 == 'Additional DTR' || $k1 == 'Bare to Cable' || $k1 == 'Cable Augmentation' || $k1 == 'DL to AG/Coated conductor' || $k1 == 'Substation Rennovation' || $k1 = 'Mix DTR') { ?>
																							<?php foreach ($v1 as $k2 => $v2) { ?>
																								<!-- tr open -->
																								<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
																									<!-- Calculating Observation Flag -->
																									<?php if (str_contains($k1, '/')) {
																													$k1 = str_replace('/', ' ', $k1);
																												} 
																									?>
																									<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_observation_'.$v2['typeofwork_activity_id']; ?>
																									<?php $observation_flag = 'no observation'; ?>
																									<?php if (isset($v2['applied_observations']) && !empty($v2['applied_observations'])) {
																													$obs_list_count = count($v2['applied_observations']);
																													$obs_complete_count = 0;
																													foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																														if (!empty($aovalue['completion_photos'])) {
																															$obs_complete_count++;
																														}
																													}

																													$observation_flag = ($obs_complete_count == $obs_list_count) ? 'observation complete' : 'observation pending';
																									} ?>
																									<input type="hidden" name="<?php echo $hidden_input_name ?>" value="<?php echo $observation_flag; ?>">
																									<!-- Calculating Observation Flag Ends-->
																									<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($userdata['role'] == 'Field Engineer' || $userdata['role'] == 'Admin' || $userdata['role'] == 'Field Supervisor') { ?>
																										<input class="form-control form-control-sm mb-4" type="text" name="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">	
																										<?php } else { ?>
																										<?php echo $v2['boq']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																										<?php } ?>
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } else if ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php //$erected_qty = ($v2['erected_qty'] == 0) ? '': $v2['erected_qty'];
																														$erected_qty = (isset($v2['erected_qty'])) ? (($v2['erected_qty'] == 0) ? '' : $v2['erected_qty']) : '';
																												 ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>	
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0  && $v2['boq'] != 0) {
																														$erected_qty = $v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format(($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
																									<?php } ?>																									
																									<!-- Observations -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="observation"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="observation">
																											<?php if (isset($v2['status_id'])) { ?>
																												<?php if (($v2['status_id'] == 1 || $v2['status_id'] == 2) && !empty($v2['observations_list'])) { ?>
																													<?php $row_id = $k2; $table = $k1; $activity_id = $v2['typeofwork_activity_id'];
																																$obs_list_count = count($v2['applied_observations']);
																																$obs_complete_count = 0;
																																$ncr_submitted_by_tkc_count = 0;
																																foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																	if (!empty($aovalue['completion_photos'])) {
																																		$obs_complete_count++;
																																	}

																																	if ($aovalue['observation_status'] == 'Submitted by TKC')
																																	{
																																		$ncr_submitted_by_tkc_count++;
																																	}
																																}

																																if ($obs_list_count > 0) {
																																	$obs_ratio = $obs_complete_count.' / '.$obs_list_count;
																																}
																													?>
																													<span class="obs_ratio"><?php echo ($obs_list_count > 0) ? $obs_ratio : ''; ?></span>
																													<button id="btn-obs-<?php echo $row_id; ?>" type="button" class="btn btn-sm btn-obs obs-list" style="margin-left: 10px;" data-tablename="<?php echo $table; ?>" data-table-row="<?php echo  $row_id; ?>" data-activity-id="<?php echo $activity_id; ?>" data-activity-type="withBOQ" onclick="showObservationsList(this)">
																														<span class="fe fe-more-vertical"> </span>
																													</button>
																													<?php if ($ncr_submitted_by_tkc_count > 0) { ?>
																													<span class="badge ms-2 bg-danger"><?php echo $ncr_submitted_by_tkc_count; ?></span>
																													<?php } ?>
																												<?php } ?>
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- Remark -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="remark"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="remark">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php $obs_remarks = []; ?>	
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	array_push($obs_remarks, $aovalue['remark']);
																																}
																															}
																												?>
																												<?php echo implode(', ', $obs_remarks); ?>
																											<?php } ?>
																										</td>
																									<?php } ?>
																									<!-- File Upload -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<!-- Sheet Status: Open -->
																										<td class="fileupload"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<!-- Sheet Status: In Process || Completed || Reviewed -->
																										<td class="fileupload">
																											<?php if (isset($v2['applied_observations'])) { ?>
																												<?php foreach ($v2['applied_observations'] as $aokey => $aovalue) {
																																if (empty($aovalue['completion_photos'])) {
																																	foreach ($aovalue['observation_photos'] as $obskey => $obsvalue) {
																												?>
																												<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block" onclick="showImageModal(this)">
																													<img src="<?php echo base_url($obsvalue['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
																												</a>
																												<?php			}
																																}
																															}
																												?>	
																											<?php } ?>
																										</td>
																									<?php } ?>
																								</tr>
																								<!-- tr close -->																								
																							<?php } ?>
																						<?php } ?>
																						</tbody>
	                        								</table>
	                        							</div>
	                        						</div>
                        						<?php } ?>
                        					<?php } ?>
						                    </div>
						                  </div>
						                  <!-- Tabs body ends -->
	                        	</div>
	                        </div>
	                    	</div>
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
              					<?php $hidden_upload_photo = ($sheet_data['sheet_status'] == 'Reviewed' && ($userdata['role'] == 'Admin' || $userdata['role'] == 'Deputy Team Lead' || $userdata['role'] == 'Key Experts' || $userdata['role'] == 'Team Lead')) ? '' : 'hidden'; ?>
              					<div class="form-row completionFile" <?php echo $hidden_upload_photo; ?>>
              						<div class="col-xl-12 mb-3">
              							<label for="completionFile" class="form-label mt-0">Upload Completion File
              								<span class="text-red">*</span>
              							</label>
              							<input class="form-control" type="file" id="completionFile" name="completionFile[]" multiple>
              							<div class="text-wrap mt-2" id="preview-img-ppsheet-complete"></div>
              						</div>
              					</div>
              					<?php if (($sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') && isset($sheet_data['ppsheet_completion_file'])) { ?>
              						<div class="form-row completion-photo-row">
              							<div class="col-xl-12">
              								<label for="completionFile" class="form-label mt-0">Completion File
              								<div class="text-wrap">
              									<?php foreach ($sheet_data['ppsheet_completion_file'] as $key => $value) { ?>
              										<?php $obs_file_id = 'image-'.$key; ?>
              										<div class="file-image-1" data-pp-file-id=<?php echo $value['physical_progress_file_id']; ?>>
              											<a href="javascript:void(0)" onclick="showImageModal(this)">
              												<img src="<?php echo base_url($value['file_path']); ?>" class="br-5" alt="">
              											</a>
              											<ul class="icons">
              												<li>
              													<a href="javascript:void(0)" data-photo-for="sheet_completion_photo" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="<?php echo $obs_file_id; ?>" data-photo-action="edit">
              														<i class="fe fe-trash"></i>
              													</a>
              												</li>
              											</ul>
              										</div>
              									<?php } ?>
              								</div>
              							</div>
              						</div>
              					<?php } ?>
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
              					<!-- Row10 Charging Status -->
              					<div class="form-row">
              						<div class="col-xl-3 mb-3">
              							<label for="charging_status" class="form-label mt-0">Charging Status</label>
              							<?php $charging_status_disabled = ($sheet_data['sheet_status'] == 'Completed') ? 'disabled' : (($sheet_data['sheet_status'] == 'Reviewed' && ($userdata['role'] == 'Field Engineer' || $userdata['role'] == 'Field Supervisor')) ? 'disabled' : ''); ?>
              							<div class="form-check" style="float: left;margin-right: 10px;"> 
              								<input class="form-check-input" type="radio" name="charging_status" value="yes" <?php echo $charging_status_disabled; ?> <?php echo ($sheet_data['charging_status'] == 'yes') ? 'checked' : '';?>>
              								<label class="form-check-label" for="flexRadioDefault1"> Yes </label>
              							</div>
              							<div class="form-check" style="float: left;">
              								<input class="form-check-input" type="radio" name="charging_status" value="no" <?php echo ($sheet_data['charging_status'] == 'no' || $sheet_data['charging_status'] == NULL) ? 'checked' : '';?> <?php echo $charging_status_disabled; ?>>
              								<label class="form-check-label" for="flexRadioDefault2"> No </label>
              							</div>
              						</div>
              					</div>
              					<!-- Row11 Submit -->
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
              <!-- Row Ends -->

        		</div>
        		<!-- Container Ends -->

        	</div>
        </div>
        <!-- App-Content Ends -->
      </div>
      <!-- Page Main Ends -->

      <!-- Observation List Modal -->
      <div class="modal" id="obs_list_modal" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="obs_list_modalLabel" tabindex="-1" style="display: none;" data-bs-focus="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="obs_list_modalLabel">Observation List</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Show a second modal and hide this one with the button below. -->
              <div class="table-responsive">
                <table class="table table-bordered border text-nowrap mb-0" id="new-edit-observations-details">
                  <thead>
                    <tr>
                      <th>NCR ID</th>
                      <th>NCR Date</th>
                      <th>Observation Type</th>
                      <th>Observation</th>
                      <th>Observation Photo</th>
                      <th>Completed Photo</th>
                      <th>Completion Date</th>
                      <th>Status</th>
                      <!-- <th name="bstable-actions">Actions</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <!-- <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr> -->
                  </tbody>
                </table>
              </div>
              <!-- <a id="table2-new-row-button-observations-details" class="btn btn-primary mb-2 mt-4" data-bs-dismiss="modal" onclick="showObservationsDetails(this)"> Add New Row</a> -->
              <?php if ($sheet_data['sheet_status'] != 'Completed') { ?>
              	<a id="add-new-observation" class="btn btn-primary mb-2 mt-4" data-bs-dismiss="modal" onclick="showObservationsDetails(this)" data-action="add" > Add New Row</a>	
              <?php } ?>
            </div>
            <div class="modal-footer">
              <!-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> -->
              <!-- <button class="btn btn-secondary" data-bs-dismiss="modal" onclick="findtr()">Close</button> -->
              <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <?php if ($sheet_data['sheet_status'] != 'Completed') { ?>
              	<button class="btn btn-primary disabled" id="btn-save-list" onclick="saveObservationList(this)">Save changes</button>	
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Observation List Modal Ends -->

      <!-- Observation Detail Modal -->
      <div class="modal" id="obs-detail-modal" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="obs-detail-modalLabel2" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="position: relative;">
              <h5 class="modal-title" id="obs-detail-modalLabel2" style="width: 100%;">Observation Details</h5>
              <span class="obs_status mt-1" style="float: right;">
              	<h6></h6>	
              </span>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeDetails()">
                <span aria-hidden="true">×</span>
              </button>
              <!-- Toaster Alert -->
              <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-animation="true" id="obs-alert">
                <div class="d-flex toster-out">
                	<div class="toast-body"> Hello, world! This is a toast message. </div>
                	<button aria-label="Close" class="btn-close text-white ms-auto  pe-2" data-bs-dismiss="toast" style="margin: -6px;">
                   	<span aria-hidden="true">×</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="modal-body">
              <!-- Hide this modal and show the first with the button below. -->
              <form id="observation_form">
                <div class="row">
                	<!-- Observation Type -->
                  <div class="col-xl-4">
                    <label class="form-label" for="observation">Observation Type
                    	<span class="text-red">*</span>
                    </label>
                    <select name="observation" id="observation" class="form-control form-select" data-bs-placeholder="Select Observation">
                      <!-- <option value="select" disabled>Select Observation</option>
                      <option value="observation1" selected>Observation 1</option>
                      <option value="observation2">Observation 2</option>
                      <option value="observation3">Observation 3</option>
                      <option value="observation4">Observation 4</option> -->
                    </select>
                  </div>
                  <!-- NCR ID -->
                  <div class="col-xl-4">
                    <label class="form-label" for="ncrID">NCR ID</label>
                    <input type="text" class="form-control" id="ncrID" name="ncrID" readonly>
                  </div>
                  <!-- NCR Date -->
                  <div class="col-xl-4">
                    <label class="form-label" for="ncrDate">NCR Date</label>
                    <input type="text" class="form-control" id="ncrDate" name="ncrDate" readonly>
                  </div>
                </div>
                <div class="row">
                	<!-- Observation -->
                  <div class="col-xl-12">
                    <label class="form-label" for="remark">Observation</label>
                    <input type="text" class="form-control" id="remark" name="remark">
                  </div>
                </div>
                <div class="row">
                	<!-- Observation Photos -->
                  <div class="col-xl-12">
                    <label class="form-label" for="obs_photo" id="obs_photo_label">Observation Photos
                    	<span class="text-red">*</span>
                    </label>
                    <input class="form-control" type="file" id="obs_photo" name="obs_photo[]" multiple="">
                  </div>
                  <!-- Uploaded Images -->
                  <div class="col-xl-12">
                    <div class="text-wrap mt-2" id="preview-img-obs">
                      <!-- <div class="file-image-1">
                        <a href="javascript:void(0)" onclick="showImageModal(this)">
                          <img src="assets/uploads/download (1).jpg" class="br-5" alt="">
                        </a>
                        <ul class="icons">
                          <li>
                            <a href="javascript:void(0)" class="btn bg-danger">
                              <i class="fe fe-trash"></i>
                            </a>
                          </li>
                        </ul>
                        <span class="file-name-1">Image01.jpg</span>
                      </div>                       -->
                    </div>                    
                  </div>
                </div>
                <div class="row" id="observation_photos_by_tkc" hidden>
                	<!-- Observation Photos By TKC -->
                	<div class="col-xl-12">
                		<label class="form-label" for="obs_photo_by_tkv" id="obs_photo_by_tkc_label">Observation Photos By TKC</label>
                		<div class="col-xl-12">
                			<div class="text-wrap mt-2" id="preview-img-obs-by-tkc"></div>
                		</div>
                	</div>
                </div>
                <div class="row mt-2">
                	<!-- Completion Photos -->
                  <div class="col-xl-8">
                    <label class="form-label" for="completion_photo">Completion Photos</label>
                    <input class="form-control" type="file" id="completion_photo" name="completion_photo[]" multiple="">
                  	<div class="text-wrap mt-2" id="preview-img-complete"></div>
                  </div>
                  <!-- Completion Date -->
                  <div class="col-xl-4">
                    <label for="completionDate" class="form-label">Completion Date</label>
                      <div class="input-group">
                          <div class="input-group-text dates">
                              <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                          </div>
                          <input type="text" class="form-control" id="completionDate" name="completionDate">
                      </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <!-- <button class="btn btn-success" data-bs-target="#obs_list_modal" data-bs-toggle="modal" data-bs-dismiss="modal" onclick="saveObservationDetails()">Save</button> -->
              <button class="btn btn-success" onclick="saveObservationDetails(this)" id="saveObs">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Observation Detail Modal Ends -->

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
            <!-- <div class="modal-footer">
              <div id="caption"></div>
            </div> -->
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

    <!-- TOASTER JS -->
    <!-- <script type="text/javascript" src="jquery.toaster.js"></script> -->

    <script type="text/javascript">
    	$('input[name="reportedDate"]').daterangepicker({
      	//autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
        	format: 'DD-MM-YYYY'
        }
      });

      $('input[name="ncrDate"]').daterangepicker({
      	singleDatePicker: true,
      	locale: {
        	format: 'DD-MM-YYYY'
        }
      });          

      var form_change = false;
      var sheet_completion_photo_uploaded = false;
      var observation_photo_uploaded = false;
      var observation_completion_photo_uploaded = false;
      var sheet_remark_change = false;
      var obs_photo_file_list = [];
      var obs_completion_photo_file_list = [];
      var sheet_completion_photo_file_list = [];
      var obs_deleted_file_id = [];
      var obs_completion_deleted_file_id = [];
      var sheet_completion_deleted_file_id = [];

      $(document).ready(function() {

	      // Displaying observation dropdown, remark input and file upload on status YES selection (without BOQ groups)
       	$('input[name^="civil_work_"], input[name^="electrical_"], input[name^="sub-station_items_"]').on('change', function() {
       		//Changing status of form to edited by setting below variable true
					form_change = true;
					//Applying observations, if any
       		getObservationsForWithoutBOQ($(this));
       	});

	      // Displaying progress(%),observation dropdown, remark input and file upload on entering value in erected qty field (with BOQ groups)
	      $('input[name^="33kv_feeder_"], input[name^="dl_to_ag_coated_conductor_"], input[name^="11kv_feeder_"], input[name^="11kv_feeder_separation_"], input[name^="33kv_interconnection_line_"], input[name^="additional_dtr_"], input[name^="bare_to_cable_"], input[name^="cable_augmentation_"], input[name^="11_kv_bifurcation_"], input[name^="11_kv_interconnection_"], input[name^="33_kv_augmentation_"], input[name^="11_kv_augmentation_"], input[name^="substation_rennovation_"], input[name="mix_dtr_"]').on('input', function() {
	      	//Changing status of form to edited by setting below variable true
					form_change = true;

					let input_name = $(this).attr('name');

					if (input_name.search('boq') == -1) {
						getObservationsForWithBOQ(this);	
					} else {
						let boq_qty = $(this).val();

						if (!$.isNumeric(boq_qty)) {
							$('.toast-body').text('Enter only digits');
			      	$('.toast').toast('show');

			      	// Setting input value to blank
			      	$(this).val('');
						}
					}
	      });

	      //Changing form status on filling remark
	      $('textarea[name="sheetRemark"]').on('input', function() {
	      	//Changing status of form to edited by setting below variable true
					form_change = true;
					sheet_remark_change = true;
	      });

	      $('input[name="charging_status"]').change(function() {
	      	form_change = true;
	      });

	      //Check if the sheet activities meet the conditions to change the sheet status to Complete
	      $('#markComplete').click(function() {
	      	let activities_remaining = 0;

	      	//Checking status of all radio buttons
	      	let trs = $('.tab-content tbody').find('tr');

	      	$(trs).each(function(index, value) {

		      	var radio = $(value).find('input[type="radio"]');

		      	if ($(radio).length > 0) {
	      			let radio_btn_val = $(value).find('input[type="radio"]:checked').val();
				      if (radio_btn_val == 'no') {
				      	activities_remaining++;
			      	}

				      if (radio_btn_val == 'yes') {
				      	let ratio_text = $(value).find('.obs_ratio').text();

				      	if (ratio_text !== '') {
				      		let fileuploads = $(value).find('.fileupload a');
				      		if (fileuploads.length > 0) {
				      			activities_remaining++;			
			      			}
			      		}
			      	}		
      			} else {
	      			let progress_val = $(value).find('.progress-percent').text();

	      			let boq_div = $(value).find('.boq-qty');
	      			let boq_qty = '';

	      			if ($(boq_div).find('input').length > 0) {
	      				boq_qty = $.trim($(boq_div).find('input').val());
	      			} else {
	      				boq_qty = $.trim($(boq_div).text());	
	      			}

	      			if (boq_qty != 0) {
	      				if (progress_val != 100) {
			      			activities_remaining++;
		      			} else {
		      				let ratio_text = $(value).find('.obs_ratio').text();

			      			if (ratio_text !== '') {
			      				let fileuploads = $(value).find( '.fileupload a');
				      			if (fileuploads.length > 0) {
				      				activities_remaining++;			
			      				}
		      				}
	      				}	      				
	      			}
      			}
      		});

	      	$(this).attr('data-activities-remaining', activities_remaining);

	      	if (activities_remaining > 0) {
	      		$('.toast-body').text('Incomplete activities found. Finish off the pending activities inorder to mark complete');
	      		$('.toast').toast('show');
	      	}

	      	if (activities_remaining == 0) {
	      		// Checking if Sheet Remark field has been filled
	      		let sheet_remark = $('textarea[name="sheetRemark"]').val();

	      		if (sheet_remark === '') {
							$('.toast-body').text('All activities have been completed. Upload the completion photo and enter the remark');
	      		} else {
	      			$('.toast-body').text('All activities have been completed. Upload the completion photo');
	      		}

	      		$('.toast').toast('show');      		

	      		$('.completionFile').removeAttr('hidden');
	      		$('#remarkSpan').text('*');
	      	}
	      });
      });
			
			//Check if there's any change in the form before submitting the form
      $('#addPhysicalProgressSheet').on('submit', function(event) {
      	//if (form_change === false) {
      		var inputs = $('#addPhysicalProgressSheet').find(':input');
	      	$(inputs).each(function(index, value){
	      		$(this).change(function() {
	      			form_change = true;
	      		});
	      	});

	      	let activities_remaining = $('#markComplete').attr('data-activities-remaining');

	      	if (activities_remaining == 0 && $('input[name="completionFile[]"]')[0].files.length == 0) {
	      		$('.toast-body').text('Upload Completion photo');
	      		$('.toast').toast('show');

	      		event.preventDefault();
	      		return false;
	      	}

	      	if (activities_remaining == 0 && $('input[name="completionFile[]"]')[0].files.length > 0 && $('textarea[name="sheetRemark"]').val() == '') {
	      		$('.toast-body').text('Enter Remark');
	      		$('.toast').toast('show');

	      		event.preventDefault();
	      		return false;
	      	}

	      	if (form_change === false) {
	      		$('.toast-body').text('No changes occurred. Kindly add a remark atleast to submit the form.');
	      		$('.toast').toast('show');

	      		event.preventDefault();	
	      		return false;
	      	}

	      	if (form_change == true) {
	      		$(this).find('button[type="submit"]').attr('disabled', true);
	      	}      	
      });

      // Ajax call to mark sheet as Complete by DTL
      $('#markReviewedSheetComplete').click(function(event) {
      	let pp_id = $('input[name="physical_progress_id"]').val();
      	let sheet_completion_files = [];
      	let sheet_remark;

      	let formData = new FormData();

      	formData.append('pp_id', pp_id);
      	formData.append('sheet_completion_deleted_file_id', sheet_completion_deleted_file_id);

      	/*console.log('sheet_completion_deleted_file_id:');
      	console.log(sheet_completion_deleted_file_id);*/

      	if (sheet_completion_photo_uploaded == true) {
      		let sheet_completion_files_count = $('#completionFile')[0].files.length;

      		for (var i = 0; i < sheet_completion_files_count; i++) {
      			formData.append('sheet_completion_files[]', $('#completionFile')[0].files[i]);
      		}
      	}

      	if (sheet_remark_change == true) {
      		sheet_remark = $('textarea[name="sheetRemark"]').val();

      		formData.append('sheet_remark', sheet_remark);
      	}

      	console.log('formData:');
      	console.log(formData);
      	event.preventDefault();

      	$.ajax({
      		type: 'POST',
      		url: '<?php echo base_url('mark-pp-reviewed-sheet-complete') ?>',
      		dataType: 'json',
      		data: formData,
      		processData: false,
      		contentType: false,
      		success: function(response) {
      			let url = '<?php echo base_url('physical-verification-review') ?>';
      			window.location.replace(url);
      		},
      		error: function(xhr, status, error) {
      			console.log(xhr.responseText);
      		}
      	});
      });

      //Getting Uploaded File data and displaying the image
      $('#obs_photo').on('change', function(event) {
      	obs_photo_file_list = [];
      	observation_photo_uploaded = true;

      	// Get the selected image files
    		let files = $(this)[0].files;

    		if (files.length > 0) {
    			if (files.length > 5) {
    				$('#obs-alert').find('.toast-body').text('Only 5 images can be uploaded.');
      			$('#obs-alert').toast('show');
      			return false;
    			}

    			if ($('#preview-img-obs').find('.file-image-1').length > 0) {
    				let previous_uploaded_photos = $('#preview-img-obs').find('.file-image-1').length;

    				if (previous_uploaded_photos + files.length > 5) {
    					$('#obs-alert').find('.toast-body').text('Only 5 images can be uploaded.');
	      			$('#obs-alert').toast('show');
	      			return false;
    				}
    			}

    			if ($('#saveObs').attr('data-action') == 'add') {
    				//Clearing previously uploaded images
      			$('#preview-img-obs').empty();
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
      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file_id');
      			obs_deleted_file_id.push(deleted_file_id);
      		}      		
      	} else if (photo_for == 'observation_completion') {
      		// Removing file from observation completion photo file list
      		delete obs_completion_photo_file_list[file_index];

      		if (photo_action == 'add') {
      			$('#completion_photo')[0].files = FileListItem(obs_completion_photo_file_list);	
      		} else if (photo_action == 'edit') {
      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-ppao-file_id');
      			obs_completion_deleted_file_id.push(deleted_file_id);
      		}
      	} else if (photo_for == 'sheet_completion_photo') {
      		// Removing file from observation completion photo file list
      		delete sheet_completion_photo_file_list[file_index];

      		if (photo_action == 'add') {
      			$('#completionFile')[0].files = FileListItem(sheet_completion_photo_file_list);	
      		} else if (photo_action == 'edit') {
      			let deleted_file_id = $(anchor).closest('.file-image-1').attr('data-pp-file-id');
      			sheet_completion_deleted_file_id.push(deleted_file_id);
      		}
      	}

      	// Deleting uploaded image from the modal
      	$(anchor).closest('.file-image-1').remove();
      }      

      $('#completion_photo').on('change', function(event){
      	obs_completion_photo_file_list = [];
      	observation_completion_photo_uploaded = true;

      	// Get the selected image files
    		let files = $(this)[0].files;

    		if (files.length > 0) {
    			if (files.length > 5) {
    				$('#obs-alert').find('.toast-body').text('Only 5 images can be uploaded.');
      			$('#obs-alert').toast('show');
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
    					$('#obs-alert').find('.toast-body').text('Only 5 images can be uploaded.');
	      			$('#obs-alert').toast('show');
	      			return false;
    				}
    			}

    			if ($('#saveObs').attr('data-action') == 'add') {
    				//Clearing previously uploaded images
      			$('#preview-img-complete').empty();
    			}

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

      $('#completionFile').on('change', function(event) {
      	sheet_completion_photo_file_list = [];

    		//Get the selected image files
    		let files = $(this)[0].files;

    		if (files.length > 0) {
    			if (files.length > 5) {
    				$('.toast-body').text('Only 5 images can be uploaded.');
	      		$('.toast').toast('show');

	      		return false;
    			}

    			if ($('.completion-photo-row').find('.file-image-1').length > 0) {
    				let previous_uploaded_photos = $('.completion-photo-row').find('.file-image-1').length;

    				if (previous_uploaded_photos + files.length > 5) {
							$('.toast-body').text('Only 5 images can be uploaded.');
		      		$('.toast').toast('show');
		      		return false;
						}
    			}

    			if ($('.completion-photo-row').length == 0) {
    				//Clearing previously uploaded images
  					$('#preview-img-ppsheet-complete').empty();
    			}

    			//Loop trough all the selected images
    			for (var i = 0; i < files.length; i++) {
  					// Pushing each file in an array
						sheet_completion_photo_file_list.push(files[i]);

						let obs_file_id = 'image-'+i;
						// let file_name = files[i].name;

  					let html_img = '';
  					html_img += '<div class="file-image-1">';
      			html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
      			html_img += '<img src="'+ URL.createObjectURL(event.target.files[i]) +'" class="br-5" alt="" width="100" height="100">';
      			html_img += '</a>';
      			html_img += '<ul class="icons">';
      			html_img += '<li>';
      			html_img += '<a href="javascript:void(0)" data-photo-for="sheet_completion_photo" onclick="deleleObservationPhoto(this)" data-obs-file-id="'+obs_file_id+'" class="btn bg-danger" data-photo-action="add">';
      			html_img += '<i class="fe fe-trash"></i>';
      			html_img += '</a>';
      			html_img += '</li>';
      			html_img += '</ul>';
      			html_img += '</div>';

      			if ($('.completion-photo-row').find('.file-image-1').length > 0) {
      				$('.completion-photo-row').find('.text-wrap').append(html_img);
      			} else {
      				$('#preview-img-ppsheet-complete').append(html_img);	
      			}	      			
    			}
    		}

    		form_change = true;
    		sheet_completion_photo_uploaded = true;
      });

      //Getting observations, if any on radio button selection
      function getObservationsForWithoutBOQ(radio) {
      	//Getting tab name
				let table_name = getTableName($(radio));
				// console.log('table_name:' + table_name);

				//Getting table row
				let tr = $(radio).closest('tr');
				let table_row = $(tr).attr('data-table-row');
				let activity_index = $(radio).closest('table').attr('data-activity-index');
				/*console.log(tr);
				console.log(table_row);
				console.log('activity_index: '+activity_index);*/ 

				//Getting selected radio button value
				let radio_val = $(radio).val();

				if (radio_val == 'yes') {
					//Getting selected activity details
    			let activity = getActivityDetails(table_name, table_row, activity_index);
    			// console.log(activity);

    			//Getting selected activity's id
    			let work_activity_id = activity.typeofwork_activity_id;
    			console.log('work_activity_id: '+work_activity_id);

    			//Getting selected activity's observations
    			let activity_obs = activity.observations_list;
    			console.log(activity_obs);

    			if (activity_obs.length > 0) {
		    		apply_observations(tr, table_row, table_name, work_activity_id,'withoutBOQ'); 
		    	}

				} else if (radio_val == 'no' || radio_val == 'na') {
					let activity_id = $(tr).attr('data-activity-id');
					let contract_location_id = $('input[name="contract_location_id"]').val();

					//Ajax call to check if any observation has been applied
					$.ajax({
							type: 'POST',
							url: '<?php echo base_url("check-observation-exists"); ?>',
							dataType: 'json',
							data: {activity_id: activity_id, contract_location_id: contract_location_id},
							success: function(response) {
								if (response.applied_obs_count > 0) {
									$('#observation-notification-alert').removeAttr('hidden');

									let delete_btn = $('#observation-notification-alert').find('.notification-delete');
									$(delete_btn).attr('data-contract-location-id', contract_location_id);
									$(delete_btn).attr('data-activity-id', activity_id);
									$(delete_btn).attr('data-activity-type', 'withoutBOQ');

									let alert_text = response.applied_obs_count + ' ' + (response.applied_obs_count == 1 ? 'observation has' : 'observations have') +' been found against the activity. Changing status of activity to NO will delete the observations. Do you still want to proceed and delete the observations?';
									$('.notification-text').text(alert_text);
								} else {
									//Removing data from observations, remark and file upload cells
									let obs_td = $(tr).find('td').eq(3);
									$(obs_td).empty();

									let remark_td = $(tr).find('td').eq(4);
									$(remark_td).empty();

									let file_td = $(tr).find('td').eq(5);
									$(file_td).empty();
								}
							},
							error: function(xhr, status, error) {
								console.log(xhr.responseText);
							}
					});
				}
      }

      //Getting observations, if any on input value of erected qty field
      function getObservationsForWithBOQ(input) {
      	//Getting table row
				let tr = $(input).closest('tr');
				let table_row = $(tr).attr('data-table-row');
				let activity_index = $(input).closest('table').attr('data-activity-index');

      	//Check if erected qty does not exceeds BOQ qty
				let boq_td = $(input).parent().prev('.boq-qty');
				let boq_qty = $(boq_td).find('input').val();
				
				let erected_qty = $(input).val();

				if (boq_qty == 0) {
					$('.toast-body').text('Cannot enter erected quantity against 0 BOQ quantity');
	      	$('.toast').toast('show');

	      	// Setting input value to blank
	      	$(input).val('');
	      	
	      	return false;
				} else if (isNaN(erected_qty)) {
					$('.toast-body').text('Enter only digits');
	      	$('.toast').toast('show');

	      	//Removing data from progress in % cell
					let progress_td = $(tr).find('td').eq(5);
					$(progress_td).empty();

	      	return false;
				} else if (parseInt(erected_qty) > parseInt(boq_qty)) {
					$('.toast-body').text('Erecetd quantity cannot exceed BOQ quantity');
	      	$('.toast').toast('show');
	      	return false;
				} else {
					//Getting tab name
	      	let table_name = getTableName($(input));

					if (erected_qty > 0) {
						//Calculating Progress in %
						// let boq_qty = $(tr).find('td').eq(3).text();
						// let progress = (parseFloat(erected_qty) / parseFloat(boq_qty)) * 100;
						let progress = (erected_qty / boq_qty) * 100;
						// $(tr).find('td').eq(5).text(Math.round(progress));
						$(tr).find('td').eq(5).text(parseFloat(progress).toFixed(2));

						//Getting selected activity details
						let activity = getActivityDetails(table_name, table_row, activity_index);

						//Getting selected activity's id
						let activity_id = activity.typeofwork_activity_id;

						//Getting selected activity's observations
						let activity_obs = activity.observations_list;

						if (activity_obs.length > 0) {
			    		apply_observations(tr, table_row, table_name, activity_id, 'withBOQ'); 
			    	}
					} else {
						let activity_id = $(tr).attr('data-activity-id');
						let contract_location_id = $('input[name="contract_location_id"]').val();

						//Ajax call to check if any observation has been applied
						$.ajax({
							type: 'POST',
							url: '<?php echo base_url("check-observation-exists"); ?>',
							dataType: 'json',
							data: {activity_id: activity_id, contract_location_id: contract_location_id},
							success: function(response) {
								// console.log(response);
								if (response.applied_obs_count > 0) {
									$('#observation-notification-alert').removeAttr('hidden');

									let delete_btn = $('#observation-notification-alert').find('.notification-delete');
									$(delete_btn).attr('data-contract-location-id', contract_location_id);
									$(delete_btn).attr('data-activity-id', activity_id);
									$(delete_btn).attr('data-activity-type', 'withBOQ');

									let alert_text = response.applied_obs_count + ' ' + (response.applied_obs_count == 1 ? 'observation has' : 'observations have') +' been found against the activity. Changing status of activity to NO will delete the observations. Do you still want to proceed and delete the observations?';
									$('.notification-text').text(alert_text);
								} else {
									//Removing data from progress in %, observations, remark and file upload cells
									let progress_td = $(tr).find('td').eq(5);
									$(progress_td).empty();

									let obs_td = $(tr).find('td').eq(6);
									$(obs_td).empty();

									let remark_td = $(tr).find('td').eq(7);
									$(remark_td).empty();

									let file_td = $(tr).find('td').eq(8);
									$(file_td).empty();			
								}
							},
							error: function(xhr, status, error) {
								console.log(xhr.responseText);
							}
						});						
					}	
				}
      }		

			//Displaying observation list of selected activity
      function showObservationsList(btn) {
      	form_change = true;
      	console.log('inside showObservationsList function');

      	//Getting tab name (table) and activity id
      	let table = $(btn).attr('data-tablename');
      	let table_row = $(btn).attr('data-table-row');
      	let activity_id = $(btn).attr('data-activity-id');
      	let pp_id = $('input[name="physical_progress_id"]').val();
      	let prev_pp_id = $('input[name="prev_physical_progress_id"]').val();

      	if (pp_id == '') {
      		pp_id = prev_pp_id;
      	}

      	//Getting type of activity group
      	let activity_type = $(btn).attr('data-activity-type');

      	//Getting Contract Location ID
      	let contract_location_id = '<?php echo $sheet_data['contract_location_id'] ?>';

      	//Setting data attribute to the modal
      	$('#obs_list_modal').attr({'data-tablename': table, 'data-table-row': table_row, 'data-activity-id': activity_id});

      	//Removing already attached trs of the table
				$('#new-edit-observations-details > tbody > tr').remove();

				//Disabling Save Changes button
				$('#btn-save-list').addClass('disabled');
				$('#btn-save-list').attr('data-activity-type', activity_type);

				//If sheet is old hide Add New Row and Save Changes button
				let sheet_type = '<?php echo (isset($sheet_type)) ? $sheet_type : '' ?>';

				if (sheet_type == 'old') {
					$('#add-new-observation').hide();
					$('#btn-save-list').hide();
				}

				//Getting saved observations, if any
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url("get-activity-detail"); ?>',
					dataType: 'json',
					data: {pp_id: pp_id, activity_id: activity_id, contract_location_id: contract_location_id, prev_pp_id: prev_pp_id},
					success:function(response){
						let activity_details = response.activity_details;
						
						if (!$.isEmptyObject(activity_details)) {
							//Enabling the Save Changes button
							$('#btn-save-list').removeClass('disabled');

							let html = '';

							$.each(response.activity_details, function(index, value) {
								let ncr_date_arr = value.ncr_date.split('-');
								let ncr_date = ncr_date_arr[2] + '-' + ncr_date_arr[1] + '-' + ncr_date_arr[0];

								let obs_file_count = ($.isArray(value.observation_file_details)) ? value.observation_file_details.length : 0;
								let obs_file_txt = (obs_file_count > 0) ? obs_file_count+' files uploaded' : '';

								let obs_completion_file_count = ($.isArray(value.observation_completion_file_details)) ? value.observation_completion_file_details.length : 0;
								let obs_completion_file_txt = (obs_completion_file_count > 0) ? obs_completion_file_count+' files uploaded' : '';

								let completion_date = '';
								if (value.completion_date == null) {
									completion_date = '';
								} else {
									let completion_date_arr = value.completion_date.split('-');
									completion_date = completion_date_arr[2] + '-' + completion_date_arr[1] + '-' + completion_date_arr[0];
								}

								let user = '<?php echo $userdata['role'] ?>';								
								
								html += '<tr data-row-id="'+index+'">';
								if ((obs_completion_file_count > 0 && completion_date != '') || (sheet_type == 'old')) {
									html += '<td>';
							    html += '<div class="btn-list">';
							    html += '<button id="bEdit" type="button" class="btn btn-sm" data-action="view" onclick="showObservationsDetails(this)" data-table-row="'+table_row+'" data-tablename="'+table+'" data-bs-dismiss="modal" data-activity-observation-id="'+value.physical_progress_activity_observation_id+'">';
							    html += '<span class="fa fa-eye fa-lg action-btn-table"></span>';
							    html += '</button>';
							    html += '</div>';
							    html += '</td>';
								// } else if ((obs_completion_file_count == 0 && completion_date == '') || (user == 'Admin')) {
								} else if ((obs_completion_file_count == 0 && completion_date == '')) {
									html += '<td>';
							    html += '<div class="btn-list">';
							    html += '<button id="bEdit" type="button" class="btn btn-sm" data-action="edit" onclick="showObservationsDetails(this)" data-table-row="'+table_row+'" data-tablename="'+table+'" data-bs-dismiss="modal" data-activity-observation-id="'+value.physical_progress_activity_observation_id+'">';
							    html += '<span class="fe fe-edit fa-lg action-btn-table"> </span>';
							    html += '</button>';
							    html += '<button id="bDel" type="button" class="btn  btn-sm" onclick="deleteObservation(this)" data-action="edit" data-table-row="'+table_row+'" data-tablename="'+table+'" data-activity-observation-id="'+value.physical_progress_activity_observation_id+'">';
							    html += '<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>';
							    html += '</button>';
							    html += '</div>';
							    html += '</td>';
								}
								
								html += '<td>'+value.ncr_id+'</td>';
								html += '<td>'+value.ncr_date+'</td>';
								html += '<td>'+value.observation_name+'</td>';
								html += '<td>'+value.remark+'</td>';
								html += '<td>'+obs_file_txt+'</td>';
								html += '<td>'+obs_completion_file_txt+'</td>';
								html += '<td>'+completion_date+'</td>';
								html += '<td>'+value.observation_status+'</td>';
								html += '</tr>';
							});

							let tbody = $('#new-edit-observations-details').find('tbody');
							tbody.append(html);
						}						
					},
					error:function(xhr, status, error){
						// alert(xhr.responseJSON.message); return false;
						console.log(xhr.responseText); return false;
					}
				});

      	// $('#add-new-observation').attr({'data-tablename': table, 'data-activity': activity_id});
      	$('#obs_list_modal').modal('show') /*Original*/
      }

      //Saving observations list
      function saveObservationList(btn) {
      	console.log('inside saveObservationList function');

      	// let rows = $('#new-edit-observations-details > tbody').find('tr');

      	let total_obs_count = $(btn).attr('data-total-observations');

      	let table = $('#obs_list_modal').attr('data-tablename');
      	let table_row = $('#obs_list_modal').attr('data-table-row');
      	let activity_id = $('#obs_list_modal').attr('data-activity-id');
      	let activity_type = $('#btn-save-list').attr('data-activity-type');

      	let completed_obs_count = 0;

      	let pp_id = $('input[name="physical_progress_id"]').val();
      	/*console.log(activity_id);
      	console.log(pp_id);*/

      	//Getting Contract Location ID
    		let contract_location_id = '<?php echo $sheet_data['contract_location_id'] ?>';

      	$.ajax({
      		type: 'POST',
      		url: '<?php echo base_url("get-activity-detail"); ?>',
      		dataType: 'json',
      		data: {pp_id: pp_id, activity_id: activity_id, contract_location_id: contract_location_id},
      		success: function(response){
      			console.log(response); 

      			let activity_details = response.activity_details;
      			// console.log(activity_details);

      			let row = $('table[data-tablename="'+table+'"]').find('tr[data-table-row="'+table_row+'"]');

      			if (!$.isEmptyObject(activity_details)) {
      				console.log('not empty');
      				let remarks = [];
	      			let obs_files = [];
	      			$.each(activity_details, function(index, value) {
	      				// console.log(value); return false;
	      				if (value.completion_date != null) {
	      					completed_obs_count++;
	      				}

	      				if (value.completion_date == null) {
	      					remarks.push(value.remark);	
	      					$.each(value.observation_file_details, function(fileindex, filevalue) {
	      						// console.log(filevalue);
	      						obs_files.push(filevalue.file_path);
	      					});
	      				}
	      			});	

	      			console.log($(row));
	      			// return false;

	      			// Calculating the observation ratio
	      			let new_obs_ratio = completed_obs_count + ' / ' + activity_details.length; //observations open ratio
			    		// let new_obs_ratio = (total_obs_count - completed_obs_count) + ' / ' + total_obs_count; //observations remaining ratio
	      			console.log('new_obs_ratio:'+new_obs_ratio);

	      			// let row = $('table[data-tablename="'+table+'"]').find('tr[data-table-row="'+table_row+'"]');
	      			console.log('activity_type:'+activity_type);
	      			if (activity_type == 'withBOQ') {
	      				//Outputing the observation ratio
	      				let obs_td = $(row).find('td').eq(6);
				    		obs_td.find('span[class="obs_ratio"]').text(new_obs_ratio);

				    		//Outputing the remarks
				    		let remark_td = $(row).find('td').eq(7);
				    		remark_td.text(remarks.join(', '));

				    		//Outputing the observation files
				    		let file_td = $(row).find('td').eq(8);
				    		$(file_td).empty();
				    		let html = '';
				    		$.each(obs_files, function(index, value) {
				    			var file_path = '<?php echo base_url(); ?>'+ value;
				    			// console.log(file_path);
				    			html += '<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block">';
				    			html += '<img src="'+file_path+'" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">';
				    			html += '</a>';
				    		});
				    		file_td.append(html);

				    		if ((completed_obs_count == activity_details.length) && ($.isEmptyObject(obs_files))) {
				    			$(row).find('input[type="hidden"]').eq(0).val('observation complete');
				    			console.log('observations complete');

				    		} else {
				    			$(row).find('input[type="hidden"]').eq(0).val('observation pending');
				    			console.log('observations incomplete');
				    		}



	      			} else if (activity_type == 'withoutBOQ') {
	      				//Outputing the observation ratio
				    		let obs_td = $(row).find('td').eq(3);
				    		obs_td.find('span[class="obs_ratio"]').text(new_obs_ratio);

				    		//Outputing the remarks
				    		let remark_td = $(row).find('td').eq(4);
				    		remark_td.text(remarks.join(', '));

				    		//Outputing the observation files
				    		let file_td = $(row).find('td').eq('5');
				    		$(file_td).empty();
				    		let html = '';
				    		$.each(obs_files, function(index, value) {
				    			var file_path = '<?php echo base_url(); ?>'+ value;
				    			// console.log(file_path);
				    			html += '<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block">';
				    			html += '<img src="'+file_path+'" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">';
				    			html += '</a>';
				    		});
				    		file_td.append(html);

				    		if ((completed_obs_count == activity_details.length) && ($.isEmptyObject(obs_files))) {
				    			$(row).find('.two-way').val('yes');
				    		} else {
				    			console.log('if observations are incomplete');
				    			console.log($(row).find('.two-way'));
				    			$(row).find('.two-way').val('yes-partial');
				    		}
	      			}			    		
      			} else {
      				if (activity_type == 'withBOQ') {
      					let obs_td = $(row).find('td').eq(6);
      					$(obs_td).find('.obs_ratio').remove();

      					let remark_td = $(row).find('td').eq(7);
      					$(remark_td).empty();

      					let file_td = $(row).find('td').eq(8);
      					$(file_td).empty();
      				} else if (activity_type == 'withoutBOQ') {
      					let obs_td = $(row).find('td').eq(3);
      					$(obs_td).find('.obs_ratio').remove();

								let remark_td = $(row).find('td').eq(4);
								$(remark_td).empty();

								let file_td = $(row).find('td').eq('5');
								$(file_td).empty();
      				}
      			}

      			

      			
      			
		    		

		    		//Closing modal
		    		$('#obs_list_modal').modal('hide');
      		},
      		error: function(xhr, status, error) {
				    // there was an error
				    console.log(xhr); return false;
				    // alert(xhr.responseJSON.message); return false;
				  }
      	});
      }

      //Displaying observation details of selected activity 
      function showObservationsDetails(btn) {
      	console.log('inside showObservationsDetails function');

      	let action = $(btn).attr('data-action');

      	let table = $('#obs_list_modal').attr('data-tablename');
      	let table_row = $('#obs_list_modal').attr('data-table-row');
      	let activity_id = $('#obs_list_modal').attr('data-activity-id');

      	let tab = $('.table-responsive').find(`[data-tablename='${table}']`).first();
      	let activity_index = $(tab).attr('data-activity-index');

      	//Getting selected activity details
	      let activity = getActivityDetails(table, table_row, activity_index);
	      /*console.log('activity data');
	      console.log(activity); return false;*/

      	//Getting selected activity's observations
      	let activity_obs = activity.observations_list;

      	let html = '';
      	html += '<option value="select" selected disabled>Select Observation</option>';

      	$('#obs-detail-modal').attr({'data-tablename':table, 'data-table-row': table_row, 'data-activity-id': activity_id});
      	console.log('action: '+ action);
      	if (action == 'add') {
      		$.ajax({
      			type: 'GET',
      			url: '<?php echo base_url('fetch-ncrID') ?>',
      			dataType: 'json',
      			success: function(response){
      				// console.log(response); return false;
      				let last_ncr_id = response.last_ncr_id;
      				let ncr_id = parseInt(last_ncr_id) + 1;

      				$('input[name="ncrID"]').val(ncr_id);
      			},
      			error: function(xhr, status, error){
      				console.log(xhr); return false;
      			}
      		});

      		// Removing readonly or disabled properties from following inputs
      		$('#observation').prop('disabled', false);

      		if ($('input[name="remark"]').is('[readonly]')) {
      			$('input[name="remark"]').attr('readonly', false);
      		}

      		if ($('#obs_photo').is(':disabled')) {
      			$('#obs_photo').prop('disabled', false);
      		}

      		if ($('#completion_photo').is(':disabled')) {
      			$('#completion_photo').prop('disabled', false);
      		}

      		if ($('input[name="completionDate"]').is(':disabled')) {
      			$('input[name="completionDate"]').prop('disabled', false);	
      		}

      		// Show Save button if hidden
      		if ($('#saveObs').is(':hidden')) {
      			$('#saveObs').show();	
      		}

      		// Removing observation status is displayed
      		if ($('.obs_status').find('h6').text() != '') {
      			$('.obs_status').find('h6').text('');	
      		}      		

      		$.each(activity_obs, function(index, value) {
						html += '<option value="'+ value.obs_id +'">'+ value.name +'</option>';
					});	

					//Removing already attached options of the dropdown
					$('#observation').find('option').remove().end().append(html);

					//Setting NCR date
					let reported_date = $('input[name="reportedDate"]').val();
					$('input[name="ncrDate"]').val(reported_date);

					//Setting Completion Date same as Reported Date
					$('input[name="completionDate"]').daterangepicker({
		      	//autoUpdateInput: false,
		        singleDatePicker: true,
		        showDropdowns: true,
		        drops: "auto",
		        minDate: getModifiedDate(reported_date),
						maxDate: getModifiedDate(reported_date),
		       	autoUpdateInput: false,
		        parentEl: '#obs-detail-modal .modal-body',
		        locale: {
		        	format: 'DD-MM-YYYY'
		        }
		      });

		      $('input[name="completionDate"]').on('apply.daterangepicker', function(ev, picker) {
		      	$(this).val(picker.startDate.format('DD-MM-YYYY'));
		  		});

					$('#preview-img-obs').empty();
					$('#preview-img-complete').empty();

      	} else if (action == 'edit' || action == 'view') {
      		let pp_activity_obs_id = $(btn).attr('data-activity-observation-id');
      		let tr = $(btn).closest('tr');
      		let tr_id = $(tr).attr('data-row-id');

      		let sheet_date = '';

      		if (action == 'view') {
      			$('select[name="observation"]').prop('disabled', true);
      			$('input[name="remark"]').prop('readonly', true);
      			$('#obs_photo').prop('disabled', true);
      			$('#obs_photo').prop('disabled', true);
      			$('#completion_photo').prop('disabled', true);
      			$('#completionDate').prop('disabled', true);

      			$('#saveObs').hide();

      			let url = window.location.href;
      			let segments = url.split('/');

      			if ($.inArray('get-sheet', segments)) {
      				sheet_date = segments[segments.length - 4];
      			}      			
      		}

      		//Getting data of selected observation to edit
      		$.ajax({
      			type: 'POST',
      			url: '<?php echo base_url('get-observation') ?>',
      			data: {pp_activity_obs_id: pp_activity_obs_id, sheet_date: sheet_date},
      			dataType: 'json',
      			success: function(response){
      				/*console.log('Get observation response:');
      				console.log(response);*/  
      				let obs_data = response.obs_data;

      				//Setting Observation Status
      				$('.obs_status').find('h6').text(obs_data.observation_status);

      				//Clearing previously attached photos
      				$('#preview-img-obs').empty();
      				$('#preview-img-obs-by-tkc').empty();
							$('#preview-img-complete').empty();

      				$.each(activity_obs, function(index, value) {
		      			let selected = (obs_data.observation_name == value.name) ? 'selected' : '';
								html += '<option value="'+ value.obs_id +'" '+selected+'>'+ value.name +'</option>';
							});

							$('#observation').find('option').remove().end().append(html);	
							$('#observation').prop('disabled', true);	
							$('#ncrID').val(obs_data.ncr_id);
		      		$('#ncrDate').val(obs_data.ncr_date);
		      		$('#remark').val(obs_data.remark);

		      		if (obs_data.observation_status == 'Pending' || obs_data.observation_status == 'Forwarded') {
		      			if ($('#completion_photo').is(':disabled')) {
			      			$('#completion_photo').prop('disabled', false);
			      		}

			      		if ($('input[name="completionDate"]').is(':disabled')) {
			      			$('input[name="completionDate"]').prop('disabled', false);	
			      		}

			      		if ($('#saveObs').is(':hidden')) {
			      			$('#saveObs').show();	
			      		}
		      		}

		      		if (obs_data.completion_date != '') {
		      			$('#completionDate').val(obs_data.completion_date);
		      		} else {
		      			//Getting Reported Date
		      			let reported_date = $('input[name="reportedDate"]').val();

		      			//Setting Completion Date same as Reported Date
								$('input[name="completionDate"]').daterangepicker({
					      	//autoUpdateInput: false,
					        singleDatePicker: true,
					        showDropdowns: true,
					        drops: "auto",
					        minDate: getModifiedDate(reported_date),
									maxDate: getModifiedDate(reported_date),
					       	autoUpdateInput: false,
					        parentEl: '#obs-detail-modal .modal-body',
					        locale: {
					        	format: 'DD-MM-YYYY'
					        }
					      });

					      $('input[name="completionDate"]').on('apply.daterangepicker', function(ev, picker) {
					      	$(this).val(picker.startDate.format('DD-MM-YYYY'));
					  		});
		      		}

		      		if (obs_data.observation_files.length > 0) {
		      			let html_img = '';
		      			obs_photo_file_list = [];

		      			$.each(obs_data.observation_files, function(index, value) {
		      				let file_path = '<?php echo base_url() ?>'+ value.file_path;
		      				let obs_file_id = 'image-'+index;
		      				obs_photo_file_list.push(value);

		      				html_img += '<div class="file-image-1" data-ppao-file_id="'+ value.physical_progress_activity_observation_file_id +'">';
		      				html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
		      				html_img += '<img src="'+file_path+'" class="br-5" alt="" width="100" height="100">';
		      				html_img += '</a>';
		      				html_img += '<ul class="icons">';
		      				html_img += '<li>';
		      				html_img += '<a href="javascript:void(0)" data-photo-for="observation" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="'+obs_file_id+'" data-photo-action="edit">';
		      				html_img += '<i class="fe fe-trash"></i>';
		      				html_img += '</a>';
		      				html_img += '</li>';
		      				html_img += '</ul>';
		      				// html_img += '<span class="file-name-1">Image01.jpg</span>';
		      				html_img += '</div>';
		      			});

		      			$('#preview-img-obs').append(html_img);
		      		}

		      		if (obs_data.observation_files_by_tkc.length > 0) {
		      			$('#observation_photos_by_tkc').prop('hidden', false);

		      			let html_img = '';
		      			obs_photo_by_tkc_file_list = [];

		      			$.each(obs_data.observation_files_by_tkc, function(index, value) {
		      				let file_path = '<?php echo base_url() ?>'+ value.file_path;

		      				html_img += '<div class="file-image-1" data-ppao-file_id="'+ value.physical_progress_activity_observation_file_id +'">';
		      				html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
		      				html_img += '<img src="'+file_path+'" class="br-5" alt="" width="100" height="100">';
		      				html_img += '</a>';
		      				html_img += '</div>';
		      			});

		      			$('#preview-img-obs-by-tkc').append(html_img);
		      		}

		      		if (obs_data.completion_files.length > 0) {
		      			let html_img = '';
		      			obs_completion_photo_file_list = [];

		      			$.each(obs_data.completion_files, function(index, value) {
		      				let file_path = '<?php echo base_url() ?>'+ value.file_path;
		      				let obs_file_id = 'image-'+index;
		      				obs_completion_photo_file_list.push(value);

		      				html_img += '<div class="file-image-1" data-ppao-file_id="'+ value.physical_progress_activity_completion_file_id +'">';
		      				html_img += '<a href="javascript:void(0)"  onclick="showImageModal(this)">';
		      				html_img += '<img src="'+file_path+'" class="br-5" alt="" width="100" height="100">';
		      				html_img += '</a>';
		      				html_img += '<ul class="icons">';
		      				html_img += '<li>';
		      				html_img += '<a href="javascript:void(0)" data-photo-for="observation_completion" onclick="deleleObservationPhoto(this)" class="btn bg-danger" data-obs-file-id="'+obs_file_id+'" data-photo-action="edit">';
		      				html_img += '<i class="fe fe-trash"></i>';
		      				html_img += '</a>';
		      				html_img += '</li>';
		      				html_img += '</ul>';
		      				// html_img += '<span class="file-name-1">Image01.jpg</span>';
		      				html_img += '</div>';
		      			});

		      			$('#preview-img-complete').append(html_img);
		      		}

		      		$('#saveObs').attr({'data-activity-observation-id': pp_activity_obs_id, 'data-tr-id': tr_id});
      			},
      			error: function(xhr, status, error){
      				console.log(xhr); return false;
      			}
      		});      		
      	}
					
				$('#saveObs').attr('data-action', action);				

				// $('#btn-save-list').attr({'data-total-observations':activity_obs.length, 'data-tablename':table, 'data-table-row':table_row});
				$('#btn-save-list').attr({'data-total-observations':activity_obs.length});

      	$('#obs-detail-modal').modal('show'); /*Original*/
      }

      //Saving observation details
      function saveObservationDetails() {
      	console.log('inside saveObservationDetails function');

      	let action = $('#saveObs').attr('data-action');
      	let pp_activity_obs_id = (action == 'edit') ? $('#saveObs').attr('data-activity-observation-id') : '';
      	let table_name = $('#obs_list_modal').attr('data-tablename');
      	let table_row = $('#obs_list_modal').attr('data-table-row');
      	let activity_id = $('#obs_list_modal').attr('data-activity-id');
      	let activity_type = $('#btn-save-list').attr('data-activity-type');

      	let ppao_file_id_not_deleted = [];

      	//Getting observation form modal data
      	let observation_id = $('#observation').find(":selected").val();

      	//Checking if observation is selected
      	if (observation_id == 'select') {
      		// alert('No observation selected.');
      		$('#obs-alert').find('.toast-body').text('Select an observation.');
      		$('#obs-alert').toast('show');
      		return false;
      	} 
      	
      	let observation = $('#observation').find(":selected").text();
      	let ncr_id = $('#ncrID').val();
      	let ncr_date = $('#ncrDate').val();
      	let remark = $('#remark').val();

      	//Checking if observation photo is uploaded
      	let check_obs_files = $('#preview-img-obs').find('div[class^="file-image"]');
      	let obs_files = $('#obs_photo')[0].files;

      	if (check_obs_files.length == 0) {
      		$('#obs-alert').find('.toast-body').text('Upload an observation photo.');
      		$('#obs-alert').toast('show');
      		return false;
      	}

      	let obs_file_txt = '';
      	obs_file_txt = (check_obs_files.length > 0) ? check_obs_files.length+' files uploaded' : '';

      	let completion_file_list = $('#preview-img-complete').find('div[class^="file-image"]');
      	let obs_completion_file_txt = (completion_file_list.length > 0) ? completion_file_list.length+' files uploaded' : '';

      	let completion_date = $('#completionDate').val();

      	if (completion_file_list.length > 0 && completion_date === '') {
      		$('#obs-alert').find('.toast-body').text('Select completion date.');
      		$('#obs-alert').toast('show');
      		return false;
      	} else if (completion_file_list.length === 0 && completion_date !== '') {
      		$('#obs-alert').find('.toast-body').text('Upload an completion photo.');
      		$('#obs-alert').toast('show');
      		return false;
      	} else {
      		//Get form data
      		let form = $('#observation_form')[0];
      		let formData = new FormData(form);

      		//Getting physical_progress id
      		var physical_progress_id = $('input[name="physical_progress_id"]').val();

      		//Getting prev_physical_progress_id
      		let prev_physical_progress_id = $('input[name="prev_physical_progress_id"]').val();      		      		

      		let row = $('table[data-tablename="'+table_name+'"]').find('tr[data-table-row="'+table_row+'"]');

      		//Getting seq no, typeofwork_activity_id and unit_id
      		let seq_no = $(row).attr('data-seqno');
      		let unit_id = $(row).attr('data-unit-id');     		

      		formData.append('observation_name', observation);
      		formData.append('physical_progress_id', physical_progress_id);
      		formData.append('prev_physical_progress_id', prev_physical_progress_id);
      		formData.append('seq_no', seq_no);
      		// formData.append('activity_status_id', activity_status_id);
      		formData.append('activity_id', activity_id);
      		formData.append('unit_id', unit_id);
      		formData.append('action', action);
      		formData.append('pp_activity_obs_id', pp_activity_obs_id);

      		if (!$.isEmptyObject(obs_deleted_file_id)) {
      			formData.append('obs_deleted_file_id', obs_deleted_file_id);
      		}

      		if (!$.isEmptyObject(obs_completion_deleted_file_id)) {
      			formData.append('obs_completion_deleted_file_id', obs_completion_deleted_file_id);	
      		}

      		//Getting Contract Location ID
      		let contract_location_id = '<?php echo $sheet_data['contract_location_id'] ?>';
      		formData.append('contract_location_id', contract_location_id);

      		if (activity_type == 'withBOQ') {
      			let erected_qty = $(row).find('td').eq(4).find('input').val();
      			formData.append('erected_qty', erected_qty);
      		}

      		/*console.log('formData:'); 
      		console.log(formData);*/
      		// return false;

	    		//Make an ajax call to save the observation
	    		$.ajax({
	    			type: 'POST',
	    			url: '<?php echo base_url("save-observation"); ?>',
	    			data: formData,
	    			dataType: 'json',
	    			contentType: false,
	    			processData: false,
	    			success: function(response) {
	    				console.log('Save Observation Response');
				      console.log(response); 
	    				physical_progress_id = response.physical_progress_id;
	    				observation_id = response.observation_id;
				      $('input[name="physical_progress_id"]').val(physical_progress_id);

				      // Calculating Observation Status
      				let observation_status = (completion_date === '') ? 'Pending' : 'Reviewed';

			      	let html = '';

      				if (action == 'add') {
			      		//Find tr no of the table
				      	let row = $('#new-edit-observations-details > tbody').find('tr');
	      	
				      	html += '<tr data-row-id="'+row.length+'">';
				      	html += '<td>';
				      	html += '<div class="btn-list">';
				      	html += '<button id="bEdit" type="button" class="btn btn-sm" data-action="edit" onclick="showObservationsDetails(this)" data-table-row="'+table_row+'" data-tablename="'+table_name+'" data-bs-dismiss="modal" data-activity-observation-id='+observation_id+'>';
				      	html += '<span class="fe fe-edit fa-lg action-btn-table"> </span>';
				      	html += '</button>';
				      	html += '<button id="bDel" type="button" class="btn  btn-sm" onclick="deleteObservation(this)" data-table-row="'+table_row+'" data-tablename="'+table_name+'" data-activity-observation-id='+observation_id+'>';
				      	html += '<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>';
				      	html += '</button>';
				      	html += '</div>';
				      	html += '</td>';
				      	html += '<td>'+ ncr_id +'</td>';
				      	html += '<td>'+ ncr_date +'</td>';
				      	html += '<td>'+ observation +'</td>';
				      	html += '<td>'+ remark +'</td>';
				      	html += '<td>'+ obs_file_txt +'</td>';
				      	html += '<td>'+ obs_completion_file_txt +'</td>';
				      	html += '<td>'+ completion_date +'</td>';
				      	html += '<td>'+ observation_status +'</td>';
				      	html += '</tr>';
      				} else if (action == 'edit') {
      					console.log('inside eidt');
      					let tr_id = $('#saveObs').attr('data-tr-id');

			      		//Find editing tr of the table
			      		let row = $('#new-edit-observations-details > tbody').find('tr').eq(tr_id);
			      		
			      		$(row).find('td:eq(1)').text(ncr_id);
			      		$(row).find('td:eq(2)').text(ncr_date);
			      		$(row).find('td:eq(3)').text(observation);
			      		$(row).find('td:eq(4)').text(remark);
			      		$(row).find('td:eq(5)').text(obs_file_txt);
			      		$(row).find('td:eq(6)').text(obs_completion_file_txt);
			      		$(row).find('td:eq(7)').text(completion_date);
			      		$(row).find('td:eq(8)').text(observation_status);
      				}

      				//Appending input values to list modal
		      		$('#new-edit-observations-details > tbody').append(html);

		      		//Enabling Save Changes button
		      		$('#btn-save-list').removeClass('disabled');

		      		// Setting observation and observation completion file upload flags to false
		      		observation_photo_uploaded = false;
		      		observation_completion_photo_uploaded = false;
		      		obs_deleted_file_id = [];
		      		obs_completion_deleted_file_id = [];
		      		
		      		//Closing observation detail modal
		      		$('#obs-detail-modal').modal('hide');

		      		//Clearing data of observation detail modal on close
		      		$('#obs-detail-modal').on('hidden.bs.modal', function () {
				        $(this).removeData('bs.modal');
				      });
				      $('#obs-detail-modal').find('form').trigger('reset');

				      //Opening observation list modal
		      		$('#obs_list_modal').modal('show');
				    },
				    error: function(xhr, status, error){
				    	console.log(xhr);
				    	let errorText = JSON.parse(xhr.responseText);
				    	console.log(errorText);

		      		$('#obs-alert').find('.toast-body').text(errorText.message);
      				$('#obs-alert').toast('show');
		      		return false;
				    }
	    		});
      	}
      }

      //Deleting observation
      function deleteObservation(btn) {
      	let obs_id = $(btn).attr('data-activity-observation-id');

      	//Make an ajax call to delete the observation
      	$.ajax({
    			type: 'POST',
    			url: '<?php echo base_url("delete-observation"); ?>',
    			data: {observation_id: obs_id},
    			dataType: 'json',
    			success: function(response) {
    				console.log(response);
    				$(btn).closest('tr').remove();
    			},
			    error: function(xhr, status, error){
			    	// let errorText = JSON.parse(xhr.responseText);
			      console.log(xhr.responseText); return false;
			    }
    		});
      }

      //Deleting all applied observations against an activity
      function deleteAppliedObservations(anchor) {
      	let contract_location_id = $(anchor).attr('data-contract-location-id');
      	let activity_id = $(anchor).attr('data-activity-id');
      	let activity_type = $(anchor).attr('data-activity-type');

      	//Ajax call to delete all applied observations against the activity
      	$.ajax({
      		type: 'POST',
      		url: '<?php echo base_url("delete-applied-observations") ?>',
      		dataType: 'json',
      		data: {activity_id: activity_id, contract_location_id: contract_location_id},
      		success: function(response) {
      			$('#observation-notification-alert').attr('hidden', true);

      			let tr = $('tr[data-activity-id="'+ activity_id +'"]');

      			if (activity_type == 'withoutBOQ') {
      				//Removing data from observations, remark and file upload cells
							let obs_td = $(tr).find('td').eq(3);
							$(obs_td).empty();

							let remark_td = $(tr).find('td').eq(4);
							$(remark_td).empty();

							let file_td = $(tr).find('td').eq(5);
							$(file_td).empty();
      			} else if (activity_type == 'withBOQ') {
      				//Removing data from progress in %, observations, remark and file upload cells
							let progress_td = $(tr).find('td').eq(5);
							$(progress_td).empty();

							let obs_td = $(tr).find('td').eq(6);
							$(obs_td).empty();

							let remark_td = $(tr).find('td').eq(7);
							$(remark_td).empty();

							let file_td = $(tr).find('td').eq(8);
							$(file_td).empty();			
      			}      			

      			let alert_text = response.deleted_obs_count + ' ' + (response.deleted_obs_count == 1 ? 'observation has' : 'observations have') + ' been deleted applied against ' + response.activity_name + ' activity';
      			$('.toast-body').text(alert_text);
	      		$('.toast').toast('show');
      		}, 
      		error: function(xhr, status, error) {
      			console.log(xhr.responseText);
      		}
      	});
      }

      function closeDetails() {
      	//Closing observation detail modal
    		$('#obs-detail-modal').modal('hide');

    		//Clearing data of observation detail modal on close
    		$('#obs-detail-modal').on('hidden.bs.modal', function () {
	        $(this).removeData('bs.modal');
	      });
	      $('#obs-detail-modal').find('form').trigger('reset');

	      //Opening observation list modal
    		$('#obs_list_modal').modal('show');
      }

      function closeNotificationAlert(anchor) {
      	let notification_alert = $(anchor).closest('#observation-notification-alert');
      	notification_alert.attr('hidden', true);
      }

      function getTableName(radio) {
      	let table = $(radio).closest('table');
      	let table_name = $(table).attr('data-tablename');
      	
      	return table_name;
      }

      function getActivityDetails(table, id, activity_index) {
      	
      	let activities = <?php echo json_encode($sheet_data['activities_list']); ?>;
      	let activity = activities[activity_index][table][id];

      	return activity;
      }

      function apply_observations(tr, row_id, table, activity_id, type) {
      	var obs_td;
      	if (type == 'withBOQ') {
					obs_td = $(tr).find('td').eq(6);
					obs_td.empty();
      	} else if (type == 'withoutBOQ') {
      		obs_td = $(tr).find('td').eq(3);
      	}

      	let html = '';
      	html += '<span class="obs_ratio">';
      	// html += obs_ratio;
      	html += '</span>';
      	html += '<button id="btn-obs-'+ row_id +'" type="button" class="btn btn-sm btn-obs obs-list"  style="margin-left: 10px;" data-tablename="'+table+'" data-table-row="'+row_id+'" data-activity-id="'+activity_id+'" onclick="showObservationsList(this)" data-activity-type="'+type+'">';
      	html += '<span class="fe fe-more-vertical"> </span>';
      	html += '</button>';

      	obs_td.append(html);
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
            
    </script>
	</body>
</html>