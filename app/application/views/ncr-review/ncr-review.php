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
				            	<h1 class="page-title">NCR Review</h1>
				            	<!-- FLash Alert -->
				            	<!-- <?php //if ($this->session->flashdata('error') && !empty($this->session->flashdata('error'))) { ?>
				            		<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 45%;"> 
                                        <span class="alert-inner--icon">
                                            <i class="fe fe-slash"></i>
                                        </span> 
                                        <span class="alert-inner--text"><strong>Error!</strong>
                                        	<?php //echo $this->session->flashdata('error'); ?>
                                        </span> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> 
                                            <span aria-hidden="true">×</span> 
                                        </button> 
                                    </div>	
				            	<?php //} ?> -->
				            	<!-- FLash Alert Ends -->
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
				            							<?php $accordion_btn_class = (isset($filter_data)) ? 'filters-on' : '';
							                                  $accordion_btn_style = (isset($filter_data)) ? 'style="height:57px;"' : '';
							                                  $clear_btn_visibility = (isset($filter_data)) ? '' : 'hidden';
							                            ?>
							                            <button class="accordion-button collapsed active prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>
							                              	Search NCR Review
							                            </button>
				            						</h2>
				            						<div class="clear-data" <?php echo $clear_btn_visibility; ?>>
						                            	<a href="#" class="text-danger clear-search-filters" id="clear-btn"> Clear</a>
						                          	</div>
						                          	<div class="lab-value">
						                          		<ul>
						                          			<?php 	if (isset($filter_data)) {
						                          						foreach ($filter_data as $key => $value) {
						                          								if (!empty($value['value'])) { ?>
						                          			<li><?php echo $value['label'].' : '.$value['value']; ?></li>
						                          			<?php 				}
						                          						}	
						                          					}
				                          					?>
						                          		</ul>
						                          	</div>
						                          	<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
						                          		<div class="accordion-body p-1">
						                          			<form name="searchNCRReview" id="searchNCRReview" method="post" action="<?php echo base_url('search-ncr-review'); ?>">
						                          				<!-- Row1 -->
						                          				<div class="row">
						                          					<!-- Contractor (TKC) -->
						                          					<div class="col-md-4">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="contractor">Contractor (TKC)</label>
						                          							<input class="form-control" type="text" name="contractor" id="contractor" onpaste="changeFormStatus()" onkeyup="showtkclist(this.value)" value="<?php echo (isset($filter_data) && !empty($filter_data['contractor']['value'])) ? $filter_data['contractor']['value'] : ''; ?>">
						                          							<div class="list-group list-view-contractor" id="list-view"></div>
						                          						</div>
						                          					</div>
						                          					<!-- Package No -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="packageNo">Lot No.</label>
						                          							<input class="form-control" type="text" name="packageNo" id="packageNo" onpaste="changeFormStatus()" oninput="changeFormStatus()" value="<?php echo (isset($filter_data) && !empty($filter_data['package_no']['value'])) ? $filter_data['package_no']['value'] : ''; ?>">
						                          						</div>
						                          					</div>
						                          					<!-- Feeder ID -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="feederID">Feeder ID</label>
						                          							<input type="text" class="form-control" name="feederID" id="feederID" onpaste="changeFormStatus()" oninput="changeFormStatus()" value="<?php echo (isset($filter_data) && !empty($filter_data['feederID']['value'])) ? $filter_data['feederID']['value'] : ''; ?>" />
						                          						</div>
						                          					</div>
						                          					<!-- NCR ID -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="ncrID">NCR ID</label>
						                          							<input type="text" class="form-control" name="ncrID" id="ncrID" onpaste="changeFormStatus()" oninput="changeFormStatus()" value="<?php echo (isset($filter_data) && !empty($filter_data['ncrID']['value'])) ? $filter_data['ncrID']['value'] : ''; ?>">
						                          						</div>
						                          					</div>
						                          					<!-- Region -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="region">Region</label>
						                          							<select class="form-control form-select select2 select2-hidden-accessible" name="region" data-bs-placeholder="Select Region" tabindex="-1" aria-hidden="true" id="region" style="width:100%">
						                          								<option value="select" <?php echo (isset($filter_data) && !empty($filter_data['region']['id'])) ? '' : 'selected'; ?> disabled>Select Region</option>
						                          								<?php $selected_region = (isset($filter_data)) ? $filter_data['region']['id'] : ''; ?>
						                          								<?php foreach ($region_list as $key => $value) { ?>
						                          								<?php $selected = ($value['region_id'] == $selected_region) ? 'selected' : ''; ?>
						                          								<option value="<?php echo $value['region_id']; ?>" <?php echo $selected; ?>><?php echo $value['region_name']; ?></option>
						                          								<?php } ?>
						                          							</select>
						                          						</div>
						                          					</div>
						                          				</div>
						                          				<!-- Row2 -->
						                          				<div class="row">
						                          					<!-- Circle -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="circle">Circle</label>
						                          							<select class="form-control form-select select2 select2-hidden-accessible" name="circle" data-bs-placeholder="Select Circle" tabindex="-1" aria-hidden="true" id="circle" style="width:100%">
										                                        <option value="select" <?php echo (isset($filter_data) && !empty($filter_data['circle']['id'])) ? '' : 'selected'; ?> disabled>Select Circle</option>
										                                        <?php $selected_circle = (isset($filter_data)) ? $filter_data['circle']['id'] : ''; ?>
										                                        <?php foreach ($circle_list as $key => $value) { ?>
										                                        <?php $selected = ($value['circle_id'] == $selected_circle) ? 'selected' : ''; ?>
										                                        <option value="<?php echo $value['circle_id']; ?>" <?php echo $selected; ?>><?php echo $value['circle_name']; ?></option>
										                                        <?php } ?>
										                                      </select>
						                          						</div>
						                          					</div>
						                          					<!-- Division -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label m-0" for="division">Division</label>
						                          							<!-- <select class="form-control form-select select2 select2-hidden-accessible" name="division" data-bs-placeholder="Select Division" tabindex="-1" aria-hidden="true" id="division" style="width:100%">
										                                        <option value="select" <?php //echo (isset($filter_data) && !empty($filter_data['division']['id'])) ? '' : 'selected'; ?> disabled>Select Division</option>
										                                        <?php //$selected_division = (isset($filter_data)) ? $filter_data['division']['id'] : ''; ?>
										                                        <?php //foreach ($division_list as $key => $value) { ?>
									                                        	<?php //$selected = ($value['division_id'] == $selected_division) ? 'selected' : ''; ?>
										                                        <option value="<?php //echo $value['division_id']; ?>" <?php //echo $selected; ?>><?php //echo $value['division_name']; ?></option>
										                                        <?php //} ?>
										                                      </select> -->
										                                      <select class="form-control form-select select2 select2-hidden-accessible" name="division" data-bs-placeholder="Select Division" tabindex="-1" aria-hidden="true" id="division" style="width:100%">
										                                      	<option value="select" selected disabled>Select Division</option>
										                                      	<?php if (isset($division_list)) {
										                                      			foreach ($division_list as $value) {
										                                      				if (isset($filter_data['division']['id'])) {
										                                      					$selected = ($value['division_id'] == $filter_data['division']['id']) ? 'selected' : '';
										                                      				}
										                                      	?>
										                                      	<option value="<?php echo $value['division_id']; ?>" <?php echo $selected; ?>><?php echo $value['division_name']; ?></option>
										                                      	<?php 	}
										                                      		  } 
										                                      	?>
										                                      </select>
						                          						</div>
						                          					</div>
						                          					<!-- Status -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label" for="status">Status</label>
						                          							<select multiple="multiple" class="filter-multi" name="status[]" id="status">
										                                        <?php $selected_status = (isset($filter_data) && !empty($filter_data['status']['id'])) ? $filter_data['status']['id'] : ''; ?>
										                                        <?php foreach ($status_list as $key => $value) { ?>
										                                        <?php $selected = (is_array($selected_status) && in_array($value['status_id'], $selected_status)) ? 'selected' : ''; ?>
										                                        <option value="<?php echo $value['status_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
										                                        <?php } ?>
										                                      </select>
						                          						</div>
						                          					</div>
						                          					<!-- Last Email Sent -->
						                          					<div class="col-md-2">
						                          						<div class="form-group">
						                          							<label class="form-label">Last Email Sent</label>
						                          							<div class="form-check mt-2">
						                          								<?php $checked_email = (isset($filter_data) && $filter_data['last_email_sent']['value'] == 'Yes') ? 'checked' : ''; ?>
						                          								<input class="form-check-input" type="checkbox" value="Yes" name="last_email_sent" id="last_email_sent" <?php echo $checked_email; ?>>
						                          								<label class="form-check-label" for="last_email_sent">Yes</label>
						                          							</div>
						                          						</div>
						                          					</div>
						                          				</div>
						                          				<!-- Row3 -->
						                          				<div class="row">
						                          					<!-- Search Button -->
						                          					<div class="col-md-3 mt-3">
						                          						<button type="submit" class="btn btn-primary mt-1 mb-1 search-ncr-btn">Search</button>
						                          						<button type="button" class="btn default-clear clear-search-filters mt-1 mb-1">Clear</button>
						                          					</div>
						                          				</div>
						                          			</form>
						                          		</div>
						                          	</div>
				            					</div>
				            				</div>
				            				<!-- Search Block Ends -->

				            				<!-- Delete Alert -->
	                                        <div class="row war-pop" id="ncr-delete-alert" hidden>
	                                            <div class="col-xl-3 col-sm-6 war-pop-1">
	                                               <div class="card border p-0 pb-3">
	                                                    <div class="card-header border-0 pt-3">
	                                                        <div class="card-options">
	                                                            <!-- <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove" onclick="closeNotificationAlert(this)">
	                                                               <i class="fe fe-x"></i>
	                                                            </a> -->
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
	                                                        <p class="card-text notification-text">Are you sure you want to delete Division?</p>
	                                                    </div>
	                                                    <div class="card-footer text-center border-0 pt-0">
	                                                        <div class="row">
	                                                            <div class="text-center">
	                                                                <a href="javascript:void(0)" class="btn btn-danger notification-delete" data-ncr-id="" onclick="deleteNCR(this)">Delete</a>
	                                                                <a href="javascript:void(0)" class="btn btn-white me-2" onclick="closeNotificationAlert(this)">Cancel</a>
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>   
	                                        </div>
	                                        <!-- Delete Alert Ends -->

				            				<!-- Loading Spinner -->
				            				<div class="row email-loader m-0 mt-2" hidden>
				            					<div class="d-flex align-items-center rounded-2 pt-1 pb-1" style="background: #efefef">
												  	<strong class="email-loader-message">Loading...</strong>
												  	<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
												</div>	
				            				</div>				            				
				            				<!-- Loading Spinner Ends -->

				            				<!-- Table -->
				            				<div class="table-responsive mt-3">
				            					<div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
				            						<div class="row">
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
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NCR ID: activate to sort column descending" style="width: 95.5156px;">NCR ID</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NCR DATE: activate to sort column descending" style="width: 95.5156px;">NCR DATE</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Contractor(TKC): activate to sort column descending" style="width: 95.5156px;">Contractor(TKC)</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Package No: activate to sort column descending" style="width: 95.5156px;">Lot No</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="5" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Feeder ID: activate to sort column descending" style="width: 95.5156px;">Feeder ID</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="6" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Region: activate to sort column descending" style="width: 95.5156px;">Region</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="7" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Circle: activate to sort column descending" style="width: 95.5156px;">Circle</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="8" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Division: activate to sort column descending" style="width: 95.5156px;">Division</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="9" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Location: activate to sort column descending" style="width: 95.5156px;">Location</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="10" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Observation Type: activate to sort column descending" style="width: 95.5156px;">Observation Type</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="11" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Completion Date: activate to sort column descending" style="width: 95.5156px;">Completion Date</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="12" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending" style="width: 95.5156px;">Status</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="13" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Last Email Details: activate to sort column descending" style="width: 95.5156px;">Last Email Details</th>
				            										<?php if (isset($filter_data) && !empty($filter_data['status']['value']) && $filter_data['status']['value'] == 'Deleted') { ?>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="14" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Deleted By: activate to sort column descending" style="width: 95.5156px;">Deleted By</th>
				            										<?php } else { ?>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="14" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Raised By: activate to sort column descending" style="width: 95.5156px;">Raised By</th>
				            										<?php } ?>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="15" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Designation: activate to sort column descending" style="width: 95.5156px;">Designation</th>
				            										<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="16" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Distribution Centre: activate to sort column descending" style="width: 95.5156px;">Distribution Centre</th>
				            									</tr>
				            								</thead>
				            								<tbody>
				            									<?php foreach ($ncr_data as $key => $value) { ?>
				            									<tr>
				            										<!-- Action Buttons -->
				            										<?php if (isset($filter_data) && !empty($filter_data['status']['value']) && $filter_data['status']['value'] == 'Deleted') { ?>
				            										<td class="d-flex">
				            											<a href="<?php echo base_url('view-ncr/'.$value['physical_progress_activity_observation_id']); ?>" class="btn btn-sm">
		                                                               		<span class="fa fa-eye fa-lg action-btn-table"></span>
	                                                            		</a>	
				            										</td>
				            										<?php } else { ?>
				            										<td class="d-flex">
				            											<?php if ($user_role != 'TKC') { ?>
				            											<!-- <input type="checkbox" class="m-2" name="ncrReview_<?php //echo $value['ncr_id']; ?>" value="<?php //echo $value['ncr_id']; ?>"> -->
				            											<input type="radio" class="m-2" name="ncrReview_radio" id="<?php echo $value['feeder_id']; ?>" value="<?php echo $value['ncr_id']; ?>"> 
				            											&nbsp;&nbsp;	
				            											<?php } ?>
				            											
				            											<?php if (!empty($user_access) && (isset($user_access['update']))) { ?>
				            											<a href="<?php echo base_url('edit-ncr/'.$value['physical_progress_activity_observation_id']); ?>" class="btn btn-sm">
		                                                               		<span class="fe fe-edit fa-lg action-btn-table"></span>
	                                                            		</a>
		                                                            	&nbsp;&nbsp;	
				            											<?php } ?>
				            											<?php if ($user_role != 'TKC') { ?>
				            											<?php if (!empty($user_access) && (isset($user_access['delete']))) { ?>
				            											<button  type="button" class="btn btn-sm deleteNCR" name="" data-ncr-id="<?php echo $value['ncr_id']; ?>">
		                                                               		<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
	                                                            		</button>	
				            											<?php } ?>	
				            											<?php } ?>						 
				            											<a href="<?php echo base_url('download-ncr/'.$value['ncr_id']); ?>" id="btn-download" class="btn btn-sm">
								                                        	<span class="fe fe-download fa-lg action-btn-table"></span>
								                                        </a>
				            										</td>
				            										<?php } ?>
				            										<!-- NCR ID -->
				            										<td><?php echo $value['ncr_id']; ?></td>
				            										<!-- NCR Date -->
				            										<td><?php echo $value['ncr_date']; ?></td>
				            										<!-- Contractor (TKC) -->
				            										<td><?php echo $value['contractor_name']; ?></td>
				            										<!-- Package No. -->
				            										<td><?php echo $value['package_no']; ?></td>
				            										<!-- Feeder ID -->
				            										<td><?php echo $value['feeder_id']; ?></td>
				            										<!-- Region -->
				            										<td><?php echo $value['region_name']; ?></td>
				            										<!-- Circle -->
				            										<td><?php echo $value['circle_name']; ?></td>
				            										<!-- Division -->
				            										<td><?php echo $value['division_name']; ?></td>
				            										<!-- Location -->
				            										<td><?php echo $value['location_name']; ?></td>
				            										<!-- Observation Type -->
				            										<td><?php echo $value['observation_name']; ?></td>
				            										<!-- Completion Date -->
				            										<td><?php echo $value['completion_date']; ?></td>
				            										<!-- Status -->
				            										<?php 	if ($value['observation_status'] == 'Pending')
				            												{
				            													$text_color_class = 'text-gray';
				            												} elseif ($value['observation_status'] == 'Reviewed') {
				            													$text_color_class = 'text-blue';
				            												} elseif ($value['observation_status'] == 'Forwarded') {
				            													$text_color_class = 'text-red';
				            												} elseif ($value['observation_status'] == 'Closed') {
				            													$text_color_class = 'text-success';
				            												} elseif ($value['observation_status'] == 'Submitted by TKC') {
				            													$text_color_class = 'text-info';
				            												}
				            										?>
				            										<td><h6 class="<?php echo $text_color_class; ?>"><?php echo $value['observation_status']; ?></h6></td>
				            										<!-- Last Email Details -->
				            										<td>
				            											<?php if (!empty($value['last_email_details'])) {
				            													echo 'Date and Time: '.$value['last_email_details'].'<br/>'.'Sent To: '.$value['contractor_email'];
				            											} ?>
				            											<?php  ?>
				            										</td>
				            										<?php if (isset($filter_data) && !empty($filter_data['status']['value']) && $filter_data['status']['value'] == 'Deleted') { ?>
				            										<td><?php echo $value['deleted_by']; ?></td>
				            										<?php } else { ?>
				            										<td><?php echo (!empty($value['raised_by'])) ? $value['raised_by'] : $value['username']; ?></td>
				            										<?php } ?>
				            										<!-- Designation -->
				            										<td><?php echo $value['designation']; ?></td>
				            										<!-- Distribution Centre -->
				            										<td><?php echo $value['distribution_centre']; ?></td>
				            									</tr>
				            									<?php } ?>
				            								</tbody>
				            							</table>
				            						</div>
				            					</div>
				            				</div>
				            				<!-- Table Ends -->
				            				<?php if ($user_role != 'TKC') { ?>
				            				<div class="row">
				            					<!-- Submit -->
				            					<div class="col-xl-6 mt-5 mb-3">
				            						<button class="btn btn-primary" name="sendMail" id="sendMail">Send Mail</button>
				            					</div>
				            				</div>	
				            				<?php } ?>
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
			              <button class="btn btn-primary" id="btn-save-list" onclick="sendEmail(this)">Confirm Recipients and Send Mail</button>
			            </div>
			          </div>
			        </div>
			      </div>
		    	<!-- Email Recipient Modal Ends -->

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
	    	let form_change = false;

	    	$(document).ready(function() {
	    		let session_msg = '<?php echo (isset($_SESSION['error'])) ? $_SESSION['error'] : '' ?>';

	    		if (session_msg != '') {
	    			$('.toast-body').text(session_msg);
		        	$('.toast').toast('show');
	    		}
	    	});

	    	//Displays contractor search list view
    		function showtkclist(tkcValue) {
		      	$.ajax({
			        type: 'POST',
			        url: '<?php echo base_url('search-contractor-pp') ?>',
			        dataType: 'json',
			        data: {contractor: tkcValue},
			        success: function(response){
			          	// console.log(response); 

			          	$('#list-view').show();
			          	$('#list-view').empty();

			          	var html = '';

			          	let contractor_data = response.contractor_data;

			          	if ($.isEmptyObject(contractor_data)) {
			            	html += 'No Contractor Found';
			          	} else {
			            	$.each(contractor_data, function(index, value) {
			              		html += '<a href="javascript:void(0)" class="p-2 list-group-item list-group-item-action flex-column align-items-start" data-typeofwork-id="'+value.typeofwork_id+'" data-contract-id="'+value.contract_id+'" onclick=applyContractorDetails(this)>';
				              	html += '<div class="d-flex w-100 justify-content-between">';
				              	html += '<h4 class="mb-1 contractor-name"><strong>'+value.contractor_name+'</strong></h4>';
				              	html += '<small class="text-muted contract-date">Contract Date : <span class="text-primary"> '+value.tender_award_date+'</span></small>';
			              		html += '</div>';
			              		html += '<p class="mb-0 type-of-work">Type Of Work: <span class="text-primary"> '+value.typeofwork_name+'</span></p>';
			              		html += '<small class="text-muted contract-no">Contract No: <span class="text-primary">'+value.tender_award_no+'</span></small>';
			              		html += '</a>';
			            	});
			          	}

			          	$('#list-view').append(html);
			        },
			        error: function(xhr, status, error){
			          	console.log(xhr.responseText);
			        }
		      	});
    		}

    		function applyContractorDetails(anchor) {
      			$('#list-view').hide();

      			let contractor_name = $(anchor).find('.contractor-name').text();
      			$('input[name="contractor"]').val(contractor_name);
			}

    		$(document).click(function() {
      			// alert('click');
      			var list_view = $('#list-view');
      			if (!list_view.is(event.target) && !list_view.has(event.target).length) {
        			list_view.hide();
      			}
    		});

    		function changeFormStatus() {
    			form_change = true;
    		}

    		$('#sendMail').click(function(event) {
    			let checked_NCRs = [];
    			let feeder_IDs = [];

				if ($('input[name^="ncrReview_"]:checked').length > 0) {
					if ($('input[name^="ncrReview_"]:checked').length == 1) {
						$(this).attr('disabled', true);

	    				$('input[name^="ncrReview_"]:checked').each(function() {
	    					feeder_IDs.push($(this).attr("id"));
		    				checked_NCRs.push($(this).val());
		    			});

	    				/*$('.email-loader').removeAttr('hidden');
	    				$('.email-loader').find('.email-loader-message').html('Please wait while the system is generating the NCR report, for the TKC.');*/
	    				
		    			// Ajax call to send email
		    			/*$.ajax({
		    				type: 'POST',
		    				url: '<?php echo base_url('send-ncr-mail') ?>',
		    				dataType: 'json',
		    				data: {checked_ncr: checked_NCRs},
		    				success: function(response) {
		    					// console.log(response); 
		    					$('#sendMail').attr('disabled', false);
		    					$('.email-loader').attr('hidden', true);

		    					$('.toast-body').text(response.message);
			        			$('.toast').toast('show');

			        			// return false;

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
					        	event.preventDefault(); 
		    				}
		    			});*/

	    				$.ajax({
		    				type: 'POST',
		    				url: '<?php echo base_url('get-email-recipients-new') ?>',
		    				dataType: 'json',
		    				data: {feeder_id : feeder_IDs, ncr_id: checked_NCRs},
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
		    							// console.log(value);
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
					} else {
						$('.toast-body').text('Select only one NCR at a time to send mail');
			        	$('.toast').toast('show');
			        	event.preventDefault(); 
					}	
    			} else {
    				$('.toast-body').text('Select an NCR to send mail');
		        	$('.toast').toast('show');
		        	event.preventDefault(); 
    			}    			
    		});

    		function sendEmail() {
				let checked_NCRs = [];
    			let feeder_IDs = [];
    			let to_email_recipients = [];
    			let cc_email_recipients = [];

    			$('input[name^="ncrReview_"]:checked').each(function() {
    				checked_NCRs.push($(this).val());
    			});

    			$('input[name^="ncrReview_"]:checked').each(function() {
    				feeder_IDs.push($(this).attr("id"));
    			});

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
				$('.email-loader').find('.email-loader-message').html('Please wait while the system is generating the NCR report, for the TKC.');

				// Ajax call to send email
    			$.ajax({
    				type: 'POST',
    				url: '<?php echo base_url('send-ncr-mail-new') ?>',
    				dataType: 'json',
    				data: {checked_ncr: checked_NCRs, feeder_id: feeder_IDs, to_email_recipients: to_email_recipients, cc_email_recipients: cc_email_recipients, add_to_recipient: add_to_recipient, add_cc_recipient: add_cc_recipient},
    				success: function(response) {
    					// console.log(response);
    					$('#sendMail').attr('disabled', false);
    					$('.email-loader').attr('hidden', true);

    					$('.toast-body').text(response.message);
	        			$('.toast').toast('show');

	        			setTimeout(function() {
	        				location.reload(true)
	        			}, 2000);
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

    		//Check if there's any change in the search form before submitting
    		$('#searchNCRReview').submit(function(event) {
    			let inputs = $(this).find('input.form-control');
    			$(inputs).each(function(index, value) {
    				if ($(value).val() != '') {
    					form_change = true;
    				}
    			});

    			let selects = $(this).find('select.form-control');
    			$(selects).each(function(index, value) {
		        	let selected_data = $(value).select2('data');
		        	if (!selected_data[0].text.includes('Select')) {
		          		form_change = true;
		        	}
		      	});

		      	let multi_select = $(this).find('#status');
			    if ($(multi_select).val().length > 0) {
			    	form_change = true;
			    }

			    let checkbox = $(this).find('#last_email_sent');
			    if ($(checkbox).prop('checked') == true) {
			    	form_change = true;
			    }

			    if (form_change === false) {
			    	$('.toast-body').text('Select atleast one filter');
		        	$('.toast').toast('show');
		        	event.preventDefault(); 
			    }
    		});

    		$('.clear-search-filters').on('click', function(event) {
    			event.preventDefault();

    			$('.lab-value').find('ul').empty();
    			$('#headingOne').find('button').removeClass('filters-on');
      			$('#headingOne').find('button').removeAttr('style');

      			let search_form = $('#searchNCRReview')[0];

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

		      	window.location.replace('<?php echo base_url("ncr-review") ?>');
    		});

    		$('#region').on('change', function(event) {
    			let selected_region_id = $(this).val();

    			let region_circle_data = <?php echo json_encode($region_circle_data) ?>;
    			let circle_data = region_circle_data[selected_region_id];

    			let html = '';
    			html += '<option value="select" selected disabled>Select Circle</option>';

    			$.each(circle_data, function(index, value) {
    				html += '<option value="'+ index +'">'+ value +'</option>';
    			});

    			$('#circle').empty();
			    $('#circle').append(html);

			    let selected_division_id = $('#division').val();

			    if (selected_division_id != null) {
			    	$('#division').empty();
			    	$('#division').append('<option value="select" selected disabled>Select Division</option>');
			    }
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

    		$('.deleteNCR').click(function(event) {
    			let ncr_id = $(this).data('ncr-id');

    			let alert_text = 'Are you sure you want to delete NCR ID:'+ncr_id+' ?';

    			$('#ncr-delete-alert').find('.notification-text').text(alert_text);
	            $('#ncr-delete-alert').find('.notification-delete').attr('data-ncr-id', ncr_id);
	            $('#ncr-delete-alert').removeAttr('hidden');
    		});

    		function deleteNCR(delete_btn) {
    			let ncr_id = $(delete_btn).data('ncr-id');

    			// Ajax call to delete the ncr
    			$.ajax({
    				type: 'POST',
    				url: '<?php echo base_url('delete-ncr') ?>',
    				dataType: 'json',
    				data: {ncr_id:ncr_id},
    				success: function(response) {
    					// console.log(response);

    					$('#ncr-delete-alert').find('.notification-text').text('');
	                    $('#ncr-delete-alert').find('.notification-delete').attr('data-ncr-id', '');

	                    $('#ncr-delete-alert').attr('hidden', true);

	                    $('.toast-body').text(response.message);
	                    $('.toast').toast('show');

	                    setTimeout(function() {
	                        location.reload(true)
	                    }, 2000);
    				},
    				error: function(xhr, status, error) {
    					$('#ncr-delete-alert').find('.notification-text').text('');
	                    $('#ncr-delete-alert').find('.notification-delete').attr('data-ncr-id', '');

	                    $('#ncr-delete-alert').attr('hidden', true);

    					$('.toast-body').text(xhr.responseJSON.message);
	                    $('.toast').toast('show');
    				}
    			});
    		}

    		function closeNotificationAlert(delete_btn) {
    			// console.log($(delete_btn));
    			$('#ncr-delete-alert').find('.notification-text').text('');
                $('#ncr-delete-alert').find('.notification-delete').attr('data-ncr-id', '');

                $('#ncr-delete-alert').attr('hidden', true);
    		}
	    </script>

	</body>
</html>