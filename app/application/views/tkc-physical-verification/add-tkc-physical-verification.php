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
              			
              			<form id="addTKCPhysicalVerificationSheet" method="post" enctype="multipart/form-data" action="<?php echo base_url('save-tkc-physical-entry'); ?>">

              				<!-- TKC Physical Progress ID -->
	                  	<input type="hidden" id="tkc_physical_progress_id" name="tkc_physical_progress_id" value="<?php echo $sheet_data['tkc_physical_progress_id']; ?>">

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
                								<?php if ($sheet_data['sheet_status'] == 'Open' && $userdata['role'] == 'TKC') { ?>
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
			                										<a href="<?php echo base_url('get-tkc-sheet/'.$value['reported_date'].'/'.$value['tkc_physical_progress_id'].'/'.$sheet_data['contract_id'].'/'.$sheet_data['contract_location_id']); ?>">
			                  									<?php echo date('j M', strtotime($value['reported_date'])); ?>
		                  									</a>
			                									<?php } ?>
				                  							</li>
                											<?php } else { ?>
	                											<li class="breadcrumb-item1">
				                  								<a href="<?php echo base_url('get-tkc-sheet/'.$value['reported_date'].'/'.$value['tkc_physical_progress_id'].'/'.$sheet_data['contract_id'].'/'.$sheet_data['contract_location_id']); ?>">
				                  									<?php echo date('j M', strtotime($value['reported_date'])); ?>
			                  									</a>
				                  							</li>
			                  								<?php //} ?>
                											<?php } ?>                									
                									<?php } ?>
                  								<?php if (isset($sheet_type) && $sheet_type == 'old' && $sheet_data['sheet_status'] == 'In Process') { ?>
                  									<?php if (!isset($future_sheet_status) && $userdata['role'] == 'TKC') { ?>
                  										<?php $recent_sheet = end($prev_sheet_dates); ?>	
                  										<li class="breadcrumb-item1 active">
		                  									<a href="<?php echo base_url('add-tkc-physical-verification/edit-prev/'.$recent_sheet['tkc_physical_progress_id'].'/'.$sheet_data['contract_id'].'/'.$sheet_data['contract_location_id']); ?>">Today</a>
		                  								</li>
                  									<?php } ?>
                  								<?php } elseif ($sheet_data['sheet_status'] == 'In Process' && $userdata['role'] == 'TKC') { ?>
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
                              <?php $readonly = ($userdata['role'] != 'TKC') ? 'readonly' : ''; 
                              			$disabled = ($userdata['role'] != 'TKC') ? 'disabled' : ''; 
                              ?>
                              <input type="text" class="form-control" name="reportedDate" id="reportedDate" <?php echo $readonly; ?> <?php echo $disabled; ?>/>
                            </div>
              							<?php } elseif ($sheet_data['sheet_status'] == 'In Process') { ?>
              								<?php $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
              											if (in_array('get-sheet', $uriSegments) || $userdata['role'] != 'TKC') { ?>
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
	                  		<div class="form-row">
	                  			<div class="col-xl-12 mb-3 mt-3">
	                  				<div class="panel panel-primary">
	                  					<div class="tab-menu-heading tab-menu-heading-boxed">
	                  						<div class="tabs-menu-boxed">
	                  							<!-- Tabs -->
	                  							<ul class="nav panel-tabs" role="tablist">
	                  								<?php foreach ($sheet_data['activities_group_name'] as $key => $value) { ?>
	                  								<?php if (str_contains($value['name'], '/')) {
																						$value['name'] = str_replace('/', ' ', $value['name']);
																					}

	                  											if (preg_match('/^\d/', $value['name'])) {
	                  												$tab_name_arr = explode(' ', $value['name']);
	                  												$tab_name_str = str_replace($tab_name_arr[0].' ', '', $value['name']);
	                  												$tab = strtolower(str_replace(' ', '-', $tab_name_str.' '.$tab_name_arr[0]));
	                  											} else {
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
	                  							<!-- Tabs Ends -->
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
	                  														<?php } elseif ($k1 == '33kv Feeder') { ?>
	                  														<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
	                  														<?php } elseif ($k1 == '11kv Feeder') { ?>
	                  														<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
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
	                  														<?php } elseif ($k1 == '11kv Feeder Separation') { ?>
	                  														<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
	                  														<?php } elseif ($k1 == '33kv Interconnection Line' || $k1 == '11 kv Bifurcation' || $k1 == '11 kv Interconnection' || $k1 == '33 kv Augmentation' || $k1 == '11 kv Augmentation' || $k1 == 'Additional DTR' || $k1 == 'Bare to Cable' || $k1 == 'Cable Augmentation' || $k1 == 'DL to AG/Coated conductor' || $k1 == 'Substation Rennovation') { ?>
	                  														<th style="width: 10px;">Sr.No</th>
																								<th style="width: 200px;">Activity</th>
																								<th>Unit</th>
																								<th>BOQ Qty</th>
																								<th>Verified Qty</th>
																								<th>Progress in %</th>
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
	                  													</tr>
	                  													<!-- tr close -->
	                  													<?php } ?>
	                  												<?php } elseif ($k1 == '33kv Feeder') { ?>
	                  													<?php foreach ($v1 as $k2 => $v2) { ?>
	                  														<!-- tr open -->
	                  														<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
	                  															<!-- Seq No -->
	                  															<td><?php echo $v2['seqno']; ?></td>
	                  															<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php echo $v2['boq']; ?>
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php $erected_qty = ($v2['erected_qty'] == 0) ? '': $v2['erected_qty']; ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																									<td class="progress-percent"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0) {
																														$erected_qty = (int)$v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format((float)($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
																									<?php } ?>
	                  														</tr>
	                  														<!-- tr close -->
	                  													<?php } ?>
	                  												<?php } elseif ($k1 == '11kv Feeder') { ?>
	                  													<?php foreach ($v1 as $k2 => $v2) { ?>
	                  														<!-- tr open -->
	                  														<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
	                  															<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php echo $v2['boq']; ?>
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php $erected_qty = ($v2['erected_qty'] == 0) ? '': $v2['erected_qty']; ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0) {
																														$erected_qty = (int)$v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format((float)($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
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
	                  														</tr>
	                  														<!-- tr close -->
	                  													<?php } ?>
	                  												<?php } elseif ($k1 == '11kv Feeder Separation') { ?>
	                  													<?php foreach ($v1 as $k2 => $v2) { ?>
	                  														<!-- tr open -->
	                  														<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
	                  															<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php echo $v2['boq']; ?>
																										<?php $hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id']; ?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php $erected_qty = (isset($v2['erected_qty']) && $v2['erected_qty'] == 0) ? '': $v2['erected_qty']; ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>">	
																										<?php } ?>
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0) { 
																														$erected_qty = (int)$v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format((float)($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
																									<?php } ?>
	                  														</tr>
	                  														<!-- tr close -->
	                  													<?php } ?>
	                  												<?php } elseif ($k1 == '33kv Interconnection Line' || $k1 == '11 kv Bifurcation' || $k1 == '11 kv Interconnection' || $k1 == '33 kv Augmentation' || $k1 == '11 kv Augmentation' || $k1 == 'Additional DTR' || $k1 == 'Bare to Cable' || $k1 == 'Cable Augmentation' || $k1 == 'DL to AG/Coated conductor' || $k1 == 'Substation Rennovation') { ?>
	                  													<?php foreach ($v1 as $k2 => $v2) { ?>
	                  														<!-- tr open -->
	                  														<tr data-table-row="<?php echo $k2; ?>" data-seqno="<?php echo $v2['seqno'];?>" data-activity-id="<?php echo $v2['typeofwork_activity_id'];?>" data-unit-id="<?php echo $v2['unit_id'];?>">
	                  															<!-- Seq No -->
																									<td><?php echo $v2['seqno']; ?></td>
																									<!-- Activity Name -->
																									<td><?php echo $v2['activity']; ?></td>
																									<!-- Unit -->
																									<td><?php echo $v2['unit_name']; ?></td>
																									<!-- BOQ Qty -->
																									<td class="boq-qty">
																										<?php echo $v2['boq']; ?>
																										<?php if (str_contains($k1, '/')) {
																														$k1 = str_replace('/', ' ', $k1);
																													}

																													$hidden_input_name = strtolower(str_replace(' ', '_', $k1)).'_boq_'.$v2['typeofwork_activity_id'];
																										?>
																										<input type="hidden" name="<?php echo $hidden_input_name; ?>" id="<?php echo $hidden_input_name; ?>" value="<?php echo $v2['boq']; ?>">
																									</td>
																									<!-- Erected Qty -->
																									<td class="erected-qty">
																										<?php $input_name = strtolower(str_replace(' ', '_', $k1)).'_'.$v2['typeofwork_activity_id']; ?>
																										<?php if ($sheet_data['sheet_status'] == 'Open' && $userdata['role'] == 'TKC') { ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>">	
																										<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																											<?php $erected_qty = ($v2['erected_qty'] == 0) ? '': $v2['erected_qty']; ?>
																											<?php $readonly = ($userdata['role'] != 'TKC') ? 'readonly' : ''; ?>
																											<input class="form-control form-control-sm mb-4" type="text" id="<?php echo $input_name; ?>" name="<?php echo $input_name; ?>" value="<?php echo $erected_qty; ?>" <?php echo $readonly; ?>>	
																										<?php } ?>
																									</td>
																									<!-- Progress in % -->
																									<?php if ($sheet_data['sheet_status'] == 'Open') { ?>
																										<td class="progress-percent"></td>
																									<?php } elseif ($sheet_data['sheet_status'] == 'In Process' || $sheet_data['sheet_status'] == 'Completed' || $sheet_data['sheet_status'] == 'Reviewed') { ?>
																										<?php $progress = '';
																													if (isset($v2['erected_qty']) && $v2['erected_qty'] != 0) {
																														$erected_qty = (int)$v2['erected_qty'];
																														// $progress = round(($erected_qty / $v2['boq']) * 100);
																														$progress = number_format((float)($erected_qty / $v2['boq']) * 100, 2, '.', '');
																													}
																										?>
																										<td class="progress-percent"><?php echo $progress; ?></td>
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
	                  					<!-- Tabs body Ends -->
	                  				</div>
	                  			</div>
	                  		</div>
	                  		<?php } ?>
	                    	<!-- Row7 Remark -->
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
              											// $readonly = '';
              											$readonly = ($userdata['role'] != 'TKC') ? 'readonly' : '';
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
              							<?php 		} else if ($userdata['role'] == 'TKC') { ?>
              							<button type="submit" class="btn btn-success">Submit</button>		
              							<?php 	} 
              								 		} else if (isset($sheet_data['sheet_mode']) && ($sheet_data['sheet_mode'] == 'update' && $sheet_data['sheet_status'] != 'Completed')) { 
              												if ($sheet_data['sheet_status'] == 'Reviewed' && ($userdata['role'] == 'Admin' || $userdata['role'] == 'Deputy Team Lead' || $userdata['role'] == 'Key Experts' || $userdata['role'] == 'Team Lead')) { 
              							?>
              							<button type="button" class="btn btn-success" id="markReviewedSheetComplete">Mark as Complete</button>	
              							<?php 		} else if($sheet_data['sheet_status'] == 'In Process' && ($userdata['role'] == 'TKC')) { ?>
              							<button type="submit" class="btn btn-success">Update</button>
              							<?php 			} 
              												}
              										 	} 
              							?>
              							<?php if ($sheet_data['sheet_status'] == 'Reviewed' && strpos($_SERVER['REQUEST_URI'], 'edit-review')) { 
              											$back_url = 'physical-verification-review';
              										} else {
              											$back_url = 'tkc-physical-entry';
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

    <script type="text/javascript">
    	var form_change = false;

    	$('input[name="reportedDate"]').daterangepicker({
      	//autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
        	format: 'DD-MM-YYYY'
        }
      });

    	// Changing form status to true on radio button change event
    	$('input[type="radio"]').change(function() {
    		form_change = true;
    	});

    	// Displaying progress(%),observation dropdown, remark input and file upload on entering value in erected qty field (with BOQ groups)
      $('input[name^="33kv_feeder_"], input[name^="dl_to_ag_coated_conductor_"], input[name^="11kv_feeder_"], input[name^="11kv_feeder_separation_"], input[name^="33kv_interconnection_line_"], input[name^="additional_dtr_"], input[name^="bare_to_cable_"], input[name^="cable_augmentation_"], input[name^="11_kv_bifurcation_"], input[name^="11_kv_interconnection_"], input[name^="33_kv_augmentation_"], input[name^="11_kv_augmentation_"], input[name^="substation_rennovation_"]').on('input', function() {
      	// alert('here'); return false;
      	//Changing status of form to edited by setting below variable true
				form_change = true;

      	getObservationsForWithBOQ(this);
      });

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

	      	// Setting input value to blank
	      	$(input).val('');

	      	//Removing data from progress in % cell
					let progress_td = $(tr).find('td').eq(5);
					$(progress_td).empty();

	      	return false;
				} else {
					//Getting tab name
	      	let table_name = getTableName($(input));

					if (erected_qty > 0) {
						//Calculating Progress in %
						let boq_qty = $(tr).find('td').eq(3).text();
						let progress = (parseInt(erected_qty) / parseInt(boq_qty)) * 100;
						// $(tr).find('td').eq(5).text(Math.round(progress));
						$(tr).find('td').eq(5).text(parseFloat(progress).toFixed(2));

						/*//Getting selected activity details
						let activity = getActivityDetails(table_name, table_row, activity_index);

						//Getting selected activity's id
						let activity_id = activity.typeofwork_activity_id;

						//Getting selected activity's observations
						let activity_obs = activity.observations_list;

						if (activity_obs.length > 0) {
			    		apply_observations(tr, table_row, table_name, activity_id, 'withBOQ'); 
			    	}*/
					}/* else {
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
					}*/	
				}
      }

    	//Check if the sheet activities meet the conditions to change the sheet status to Complete
      $('#markComplete').click(function() {
      	let activities_remaining = 0;

      	//Checking status of all radio buttons
      	let trs = $('.tab-content tbody').find('tr');

      	$(trs).each(function(index, value) {

	      	var radio = $(value).find('input[type="radio"]');

	      	if ($(radio).length > 0) {
      			let radio_btn_val = $(value).find('input[type="radio"]:checked').val();
			      if (radio_btn_val == 'no' || radio_btn_val == 'wip') {
			      	activities_remaining++;
		      	}

			      /*if (radio_btn_val == 'yes') {
			      	let ratio_text = $(value).find('.obs_ratio').text();

			      	if (ratio_text !== '') {
			      		let fileuploads = $(value).find('.fileupload a');
			      		if (fileuploads.length > 0) {
			      			activities_remaining++;			
		      			}
		      		}
		      	}*/		
    			} else {
      			let progress_val = $(value).find('.progress-percent').text();
      			let boq_qty = $.trim($(value).find('.boq-qty').text());

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

      //Check if there's any change in the form before submitting the form
      $('#addTKCPhysicalVerificationSheet').on('submit', function(event) {
      	//if (form_change === false) {
      		var inputs = $('#addTKCPhysicalVerificationSheet').find(':input');
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

      function getTableName(radio) {
      	let table = $(radio).closest('table');
      	let table_name = $(table).attr('data-tablename');
      	
      	return table_name;
      }

    </script>
	</body>
</html>