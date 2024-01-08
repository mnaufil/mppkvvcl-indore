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
				            	<h1 class="page-title">Physical Verification Review</h1>
				            </div>
				            <!-- Page-Header Ends -->

				            <!-- Row -->
				            <div class="row row-sm">
				            	<div class="col-lg-12">
				            		<div class="card">
				            			<div class="card-body p-2">
				            				<!-- Search Block -->
				            				<div class="accordion" id="accordionExample">
				            					<div class="accordion-item">
				            						<h2 class="accordion-header" id="headingOne">
				            							<?php 	$accordion_btn_class = (isset($filters)) ? 'filters-on' : '';
						                                  		$accordion_btn_style = (isset($filters)) ? 'style="height:57px;"' : '';
						                                  		$clear_btn_visibility = (isset($filters)) ? '' : 'hidden';
					                            		?>
					                            		<button class="accordion-button collapsed active prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>Search Physical Verification Review</button>
				            						</h2>
				            						<div class="clear-data" <?php echo $clear_btn_visibility; ?>>
				                            			<a href="#" class="text-danger clear-search-filters" id="clear-btn"> Clear</a>
				                          			</div>
				                          			<div class="lab-value">
				                          				<ul>
				                          					<?php 	if (isset($filters)) { 
						                                      			foreach ($filters as $key => $value) { 
						                                        			if (!empty($value['value'])) {
						                              		?>
						                              		<li><?php echo $value['label'].' : '.$value['value']; ?></li>
						                              		<?php     		}
						                                      			}
					                                    			}
						                              		?>
				                          				</ul>
				                          			</div>
				                          			<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
				                          				<div class="accordion-body p-1">
				                          					<form name="searchPhysicalProgressReview" id="searchPhysicalProgressReview" method="post" action="<?php echo base_url('search-physical-progress-review'); ?>">
				                          						<!-- Row1 -->
				                          						<div class="row">
				                          							<!-- Contractor (TKC) -->
				                          							<div class="col-md-4">
								                                    	<div class="form-group">
								                                      		<label class="form-label m-0" for="contractor">Contractor (TKC)</label>
								                                      		<input class="form-control" type="text" name="contractor" id="contractor" onkeyup="showtkclist(this.value)" value="<?php echo (isset($filters)) ? $filters['contractor']['value'] : ''; ?>">
							                                      			<div class="list-group list-view-contractor" id="list-view"></div>
								                                    	</div>
								                                  	</div>
								                                  	<!-- Contract No -->
								                                  	<div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label m-0" for="tenderAwardNo">Contract No.</label>
								                                      		<input class="form-control" type="text" name="tenderAwardNo" id="tenderAwardNo" value="<?php echo (isset($filters)) ? $filters['tenderAwardNo']['value'] : ''; ?>">
							                                    		</div>
								                                  	</div>
								                                  	<!-- Type Of Work -->
								                                  	<div class="col-md-2">
									                                    <div class="form-group">
									                                      	<label class="form-label m-0" for="typeOfWork">Type Of Work</label>
									                                      	<select class="form-control form-select select2 select2-hidden-accessible" name="typeOfWork" data-bs-placeholder="Select Type Of Work" tabindex="-1" aria-hidden="true" id="typeOfWork" style="width:100%">
									                                        	<option value="select" <?php echo (isset($filters) && !empty($filters['typeOfWork']['id'])) ? '' : 'selected'; ?> disabled>Select Type Of Work</option>
									                                        	<?php $selected_work = (isset($filters)) ? $filters['typeOfWork']['id'] : ''; ?>
									                                        	<?php foreach ($work_list as $value) { ?>
									                                          		<?php $selected = ($value['typeofwork_id'] == $selected_work) ? 'selected' : ''; ?>
									                                          	<option value="<?php echo $value['typeofwork_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
									                                        	<?php } ?>
									                                      	</select>
									                                    </div>
									                                </div>
									                                <!-- Site Location -->
									                                <div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label m-0" for="siteLocation">Site Location</label>
								                                      		<input class="form-control" type="text" name="siteLocation" id="siteLocation" value="<?php echo (isset($filters)) ? $filters['siteLocation']['value'] : ''; ?>">
							                                    		</div>
								                                  	</div>
								                                  	<!-- Region -->
								                                  	<div class="col-md-2">
								                                    	<div class="form-group">
									                                      	<label class="form-label m-0" for="region">Region</label>
								                                      		<select class="form-control form-select select2 select2-hidden-accessible" name="region" data-bs-placeholder="Select Region" tabindex="-1" aria-hidden="true" id="region" style="width:100%">
								                                        		<option value="select" <?php echo (isset($filters) && !empty($filters['region']['id'])) ? '' : 'selected'; ?> disabled>Select Region</option>
								                                        		<?php //$selected_region = (isset($filters)) ?  : ''; ?>
								                                        		<?php //foreach ($region_list as $value) { ?>
								                                          		<?php //$selected = ($value['region_id'] == $selected_region) ? 'selected' : ''; ?>
								                                          		<!-- <option value="<?php //echo $value['region_id']; ?>"><?php //echo $value['region_name']; ?></option> -->
								                                        		<?php //} ?>
								                                        		<?php if (isset($region_list)) {
								                                        				foreach ($region_list as $value) {
								                                        					if (isset($filters['region']['id'])) {
								                                        						$selected = ($value['region_id'] == $filters['region']['id']) ? 'selected' : '';
								                                        					}
								                                        		?>
								                                        		<option value="<?php echo $value['region_id']; ?>" <?php echo $selected; ?>><?php echo $value['region_name']; ?></option>			
								                                        		<?php	}
								                                        			   } 
								                                        		?>
								                                      		</select>
								                                    	</div>
								                                  	</div>
				                          						</div>
				                          						<!-- Row2 -->
				                          						<div class="row">
				                          							<!-- Circle -->
								                                  	<!-- <div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label" for="circle">Circle</label>
								                                      		<select class="form-control form-select select2 select2-hidden-accessible" name="circle" data-bs-placeholder="Select Circle" tabindex="-1" aria-hidden="true" id="circle" style="width:100%">
								                                        		<option value="select" <?php //echo (isset($filters) && !empty($filters['circle']['id'])) ? '' : 'selected'; ?> disabled>Select Circle</option> 
								                                        		<?php //$selected_circle = (isset($filters)) ? $filters['circle']['id'] : ''; ?>    
								                                        		<?php //foreach ($circle_list as $value) { ?>
								                                          		<?php //$selected = ($value['circle_id'] == $selected_circle) ? 'selected' : ''; ?>
								                                          		<option value="<?php //echo $value['circle_id']; ?>"><?php //echo $value['circle_name']; ?></option>
								                                        		<?php //} ?>
								                                      		</select>
								                                    	</div>
								                                  	</div> -->
								                                  	<div class="col-md-2">
									                                    <div class="form-group">
									                                      	<label class="form-label" for="circle">Circle</label>
									                                      	<select class="form-control form-select select2 select2-hidden-accessible" name="circle" data-bs-placeholder="Select Circle" tabindex="-1" aria-hidden="true" id="circle" style="width:100%">
									                                        	<option value="select" <?php echo (isset($filters) && !empty($filters['circle']['id'])) ? '' : 'selected'; ?> disabled>Select Circle</option>
									                                        	<?php if (isset($circle_list)) { 
									                                                	foreach ($circle_list as $value) {
									                                                  		if (isset($filters['circle']['id'])) {
									                                                    		$selected = ($value['circle_id'] == $filters['circle']['id']) ? 'selected' : '';
									                                                  		}
									                                        	?>
									                                        	<option value="<?php echo $value['circle_id']; ?>" <?php echo $selected; ?>><?php echo $value['circle_name']; ?></option>
									                                        	<?php   } 
									                                              	  } 
									                                        	?>
									                                      	</select>
									                                    </div>
									                                </div>
								                                  	<!-- Division -->
								                                  	<!-- <div class="col-md-2">
									                                    <div class="form-group">
									                                      	<label class="form-label" for="division">Division</label>
									                                      	<select class="form-control form-select select2 select2-hidden-accessible" name="division" data-bs-placeholder="Select Division" tabindex="-1" aria-hidden="true" id="division" style="width:100%">
									                                        	<option value="select" <?php //echo (isset($filters) && !empty($filters['division']['id'])) ? '' : 'selected'; ?> disabled>Select Division</option>
									                                        	<?php //$selected_division = (isset($filters)) ? $filters['division']['id'] : ''; ?>    
									                                        	<?php //foreach ($division_list as $value) { ?>
									                                          	<?php //$selected = ($value['division_id'] == $selected_division) ? 'selected' : ''; ?>
									                                          	<option value="<?php //echo $value['division_id']; ?>"><?php //echo $value['division_name']; ?></option>
									                                        	<?php //} ?>
									                                      	</select>
									                                    </div>
									                                </div> -->
									                                <div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label" for="division">Division</label>
								                                      		<select class="form-control form-select select2 select2-hidden-accessible" name="division" data-bs-placeholder="Select Division" tabindex="-1" aria-hidden="true" id="division" style="width:100%">
								                                        		<option value="select" <?php echo (isset($filters) && !empty($filters['division']['id'])) ? '' : 'selected'; ?> disabled>Select Division</option>
								                                        		<?php if (isset($division_list)) {
								                                                		foreach ($division_list as $value) {
								                                                  			if (isset($filters['division']['id'])) {
								                                                    			$selected = ($value['division_id'] == $filters['division']['id']) ? 'selected' : '';
								                                                  			}
								                                        		?>
								                                        		<option value="<?php echo $value['division_id']; ?>" <?php echo $selected; ?>><?php echo $value['division_name']; ?></option>
								                                        		<?php   }
								                                              		   } 
								                                        		?>
								                                      		</select>
								                                    	</div>
								                                  	</div>
									                                <!-- Reported By -->
									                                <div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label" for="reportedBy">Reported By</label>
								                                      		<input class="form-control" type="text" name="reportedBy" id="reportedBy" value="<?php echo (isset($filters)) ? $filters['reportedBy']['value'] : ''; ?>">
							                                    		</div>
								                                  	</div>
								                                  	<!-- Reported Date -->
								                                  	<div class="col-md-2">
									                                    <div class="form-group">
									                                      	<label class="form-label" for="reportedDate">Reported Date</label>
								                                      		<div class="input-group">
									                                        	<div class="input-group-text dates">
									                                          		<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
									                                        	</div>
									                                        	<input type="text" class="form-control" name="reportedDate" value="<?php echo (isset($filters)) ? $filters['reportedDate']['value'] : ''; ?>" />
									                                      	</div>
									                                    </div>
									                                </div>
									                                <!-- Feeder ID -->
									                                <div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label" for="feederID">Feeder ID</label>
								                                      		<input type="text" class="form-control" name="feederID" value="<?php echo (isset($filters)) ? $filters['feederID']['value'] : ''; ?>" />
							                                    		</div>
								                                  	</div>
								                                  	<!-- Status -->
								                                  	<div class="col-md-2">
								                                    	<div class="form-group">
								                                      		<label class="form-label" for="status">Status</label>
								                                      		<select multiple="multiple" class="filter-multi" name="status[]" id="status">
								                                        		<!-- <option value="All">All</option> -->
								                                        		<?php $selected_status = (isset($filters)) ? $filters['status']['id'] : ''; ?>    
								                                        		<?php foreach ($status_list as $value) { ?>
								                                          		<?php $selected = (is_array($selected_status) && in_array($value['status_id'], $selected_status)) ? 'selected' : ''; ?>
								                                          		<option value="<?php echo $value['status_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
								                                        		<?php } ?>
								                                      		</select>
								                                    	</div>
								                                  	</div>
				                          						</div>
				                          						<!-- Row3 -->
				                          						<div class="row">
				                          							<!-- Search Button -->
				                          							<div class="col-md-3">
									                                    <button type="submit" class="btn btn-primary mt-1 mb-1 search-physical-review-btn">Search</button>
									                                    <button type="button" class="btn default-clear clear-search-filters mt-1 mb-1">Clear</button>
									                                </div>
				                          						</div>
				                          					</form>
				                          				</div>
				                          			</div>
				            					</div>
				            				</div>
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
									                                    <th class="wd-20p border-bottom-0 sorting" tabindex="8" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Observation: activate to sort column descending" style="width: 67.7031px;">Observation</th>
									                                    <th class="wd-15p border-bottom-0 sorting" tabindex="9" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Last Reported By: activate to sort column descending" style="width: 185.141px;">Last Reported By</th>
									                                    <th class="wd-20p border-bottom-0 sorting" tabindex="10" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Last Reported Date: activate to sort column ascending" style="width: 185.141px;">Last Reported Date</th>
									                                    <th class="wd-20p border-bottom-0 sorting" tabindex="11" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 185.141px;">Status</th>
							                              			</tr>
							                              		</thead>
							                              		<tbody>
							                              			<?php foreach ($result as $key => $value) { ?>
							                              			<tr>
							                              				<?php $mode = 'edit-review'; ?>
							                              				<td name="bstable-actions">
							                              					<!-- Action Buttons -->
							                              					<div class="btn-list">
							                              						<?php if (!empty($user_access) && isset($user_access['update'])) { ?>
							                              						<a id="bView" type="button" class="btn btn-sm" href="<?php echo base_url('add-physical-progress/'.$mode.'/'.$value['physical_progress_id'].'/'.$value['contract_id'].'/'.$value['contract_location_id']); ?>">
										                                          	<span class="fe fe-edit fa-lg action-btn-table"></span>
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
							                              				<td>
							                              					<!-- Site Location -->
							                              					<?php echo $value['site_location']; ?>
							                              				</td>
							                              				<td>
							                              					<!-- Feeder ID -->
							                              					<?php echo $value['feeder_id']; ?>
							                              				</td>
							                              				<td>
							                              					<!-- Task Ratio -->
							                              					<?php echo $value['cc_task'].' / '. $value['tt_task']; ?>
							                              				</td>
							                              				<td>
							                              					<!-- Observations Ratio -->
							                              					<?php 	if ($value['cc_observation'] == 0 && $value['tt_observation'] == 0) {
										                                              $obs_ratio = '-';
										                                            } else {
										                                              $obs_ratio = $value['cc_observation'].' / '. $value['tt_observation'];
										                                            }
										                                    ?>
										                                    <?php echo $obs_ratio; ?>
							                              				</td>
							                              				<td>
							                              					<!-- Reported By -->
							                              					<?php echo $value['pp_reported_by']; ?>
							                              				</td>
							                              				<td>
							                              					<!-- Reported Date -->
							                              					<?php echo (!empty($value['reported_date'])) ? date('d-m-Y', strtotime($value['reported_date'])) : ''; ?>
							                              				</td>
							                              				<td>
							                              					<h5 class="<?php //echo $text_color; ?> text-status text-blue">
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

	    <script type="text/javascript">
	    var form_change = false;

	    $('input[name="reportedDate"]').daterangepicker({
	      	autoUpdateInput: false,
	      	singleDatePicker: true,
	      	showDropdowns: true,
	      	locale: {
	        	format: 'DD-MM-YYYY'
	      	}
	    });

	    $('input[name="reportedDate"]').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('DD-MM-YYYY'));
      		form_change = true;
    	});

    	$('.clear-search-filters').on('click', function(event) {
	      	event.preventDefault();
	      	$('.lab-value').find('ul').empty();
	      	$('#headingOne').find('button').removeClass('filters-on');
	      	$('#headingOne').find('button').removeAttr('style');
	      
	      	let search_form = $('#searchPhysicalProgressReview')[0];
	      
	      	//Clearing all input[type=text] values
	      	$(search_form).find('input.form-control:text').each(function() {
	        	$(this).val('');
	      	});

	      	//Clearing all select values
	      	$(search_form).find('.select2').each(function() {
	        	$(this).val('select');
	        	$(this).trigger('change');
	      	});

	      	//Clearing Status filter values
	      	let status_select = $(search_form).find('.filter-multi:eq(1)');
	      	$(status_select).find('li.selected').each(function() {
	        	$(this).removeClass('selected');
	        	$(this).find('input:checkbox').prop('checked', false);
	      	});
	      	$(status_select).find('.ms-choice span').text('');
	      	$('#clear-btn').hide();

	      	window.location.replace('<?php echo base_url("physical-progress-review") ?>');
	    });

	    $('#region').on('change', function(event) {
			let selected_region_id = $(this).val();

	      	let region_circle_data = <?php echo json_encode($region_circle_data) ?>;
	      	let circle_data = region_circle_data[selected_region_id];

	      	let circle_html = '';
	      	circle_html += '<option value="select" selected disabled>Select Circle</option>';

	      	$.each(circle_data, function(index, value) {
	        	circle_html += '<option value="'+ index +'">'+ value +'</option>';
	      	});

	      	$('#circle').empty();
	      	$('#circle').append(circle_html);

	      	let division_html = '';
	      	division_html += '<option value="select" selected disabled>Select Division</option>';

	      	$('#division').empty();
	      	$('#division').append(division_html);
    	});

    	$('#circle').on('change', function(event) {
      		let selected_circle_id = $(this).val();

      		let circle_division_data = <?php echo json_encode($circle_division_data) ?>;
	      	let division_data = circle_division_data[selected_circle_id];

	      	let html = '';
	      	html += '<option value="select" selected disabled>Select Division</option>';

	      	$.each(division_data, function(index, value) {
	        	html += '<option value="'+ index +'">'+ value +'</option>';
	      	});

	      	$('#division').empty();
	      	$('#division').append(html);
    	});
	    </script>
	</body>
</html>