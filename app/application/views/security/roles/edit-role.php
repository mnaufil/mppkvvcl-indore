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

	    <!-- FONT AWESOME CSS -->
        <!-- <link rel="stylesheet" href="assets/iconfonts/font-awesome/css/font-awesome.css"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">

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

	            <!-- App-Content -->
	            <div class="main-content app-content mt-0">
	            	<div class="side-app">
	            		
	            		<!-- Container -->
	            		<div class="main-container container-fluid">
	            			
	            			<!-- Page-Header -->
	            			<div class="page-header">
	            				<h1 class="page-title">Edit Role</h1>
	            			</div>
	            			<!-- Page-Header Ends -->

	            			<!-- Row -->
	            			<div class="row row-sm">
	            				<div class="col-lg-12">
	            					<form id="updateRole" name="updateRole" method="post" action="<?php echo base_url('update-role'); ?>">
	            						<div class="card">

	            							<div class="card-body">
	            								<div class="form-row">
	            									<!-- Role ID -->
	            									<input type="hidden" name="roleID" value="<?php echo $role_data['role_id']; ?>">
	            									<!-- Role Name -->
	            									<div class="col-xl-4 mb-3">
	            										<label class="form-label" for="roleName">Role Name
	                                    					<span class="text-red">*</span>
	                                    				</label>
	                                    				<input type="text" class="form-control" id="roleName" name="roleName" onkeyup="changeFormStatus()" onpaste="changeFormStatus()" value="<?php echo $role_data['name']; ?>">
	            									</div>
	            									<!-- Role Description -->
	            									<div class="col-xl-4 mb-3">
	                                    				<label class="form-label" for="roleDesc">Role Description
	                                    					<span class="text-red">*</span>
	                                    				</label>
	                                       				<input type="text" class="form-control" id="roleDesc" name="roleDesc" onkeyup="changeFormStatus()" onpaste="changeFormStatus()" value="<?php echo $role_data['description']; ?>">
	                                    			</div>
	                                    			<input type="hidden" name="access_revoked_modules" value="">
	                                    			<input type="hidden" name="access_revoked_reports" value="">
	            								</div>

	            								<!-- Privileges -->
	            								<div class="form-row">
	            									<div class="col-xl-12 mt-3">
	            										<label class="form-label">
	                                    					<p>Module Access:</p>
	                                    				</label>
	                                    				<div class="table-responsive">
	                                    					<table class="table text-nowrap text-md-nowrap mb-0" id="moduleAccessTable">
	                                    						<thead>
	                                    							<tr>
	                                    								<th style="text-align:left;">Module Name</th>
	                                    								<th>Full Access</th>
	                                    								<th>View</th>
	                                    								<th>Add</th>
	                                    								<th>Update</th>
	                                    								<th>Delete</th>
	                                    								<th>Download</th>
	                                    							</tr>
	                                    						</thead>
	                                    						<tbody>
	                                    							<?php $i = 0; ?>
	                                    							<?php foreach ($module_list as $key => $value) {
	                                    									if ($key == 'Logout') {
	                                    										continue;
	                                    									}

	                                    									if (!empty($value)) {
	                                    										foreach ($value as $k => $val) {
	                                    											$i++;
	                                    							?>
	                                    							<tr data-row-id="<?php echo $i; ?>">
	                                    								<!-- Module Name -->
	                                    								<td><?php echo $key.' / '.$val; ?></td>
	                                    								<!-- Full Access -->
	                                    								<td class="text-center">
	                                    									<?php if ($val == 'Physical Progress' || $val == 'Financial Progress') {
	                                    											$check_full_access = strtolower(str_replace(' Progress','', $val)).'_fullaccess';
	                                    										  } elseif (str_contains($val, 'Type of Work')) {
	                                    										  	if (preg_match('/\bType of Work - \b/', $val)) {
	                                    										  		$check_name = str_replace(' - ', '_',$val);
	                                    										  		$check_full_access = strtolower(str_replace(' ','', $check_name)).'_fullaccess';
	                                    										  	} else {
	                                    										  		$check_full_access = strtolower(str_replace(' ','', $val)).'_fullaccess';	
	                                    										  	}
	                                    										  } elseif ($val == 'Physical Verification') {
	                                    										  	$check_full_access = strtolower(str_replace('Physical ', '', $val)).'_fullaccess';
	                                    										  } else {
	                                    											$check_full_access = strtolower(str_replace(' ','_', $val)).'_fullaccess';
	                                    										  }
	                                    									?>
																		    <input type="checkbox" name="<?php echo $check_full_access; ?>" value="Yes" onchange="setFullAccess(this)" <?php //echo $checked_fullaccess; ?>>
	                                    								</td>
	                                    								<!-- View -->
	                                    								<td class="text-center">
	                                    									<?php if ($val == 'Physical Progress' || $val == 'Financial Progress') {
	                                    											$check_view = strtolower(str_replace(' Progress','', $val)).'_view';
	                                    										  } elseif (str_contains($val, 'Type of Work')) {
	                                    										  	if (preg_match('/\bType of Work - \b/', $val)) {
	                                    										  		$check_name = str_replace(' - ', '_',$val);
	                                    										  		$check_view = strtolower(str_replace(' ','', $check_name)).'_view';
	                                    										  	} else {
	                                    										  		$check_view = strtolower(str_replace(' ','', $val)).'_view';	
	                                    										  	}
	                                    										  } elseif ($val == 'Physical Verification') {
	                                    										  	$check_view = strtolower(str_replace('Physical ','', $val)).'_view';
	                                    										  } else {
	                                    										  	$check_view = strtolower(str_replace(' ','_', $val)).'_view';
	                                    										  }
	                                    									?>
	                                    									<?php $checked_view = in_array($check_view, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_view, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_view; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_view; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Add -->
	                                    								<td class="text-center">
	                                    									<?php if ($val == 'Physical Progress' || $val == 'Financial Progress') {
	                                    											$check_add = strtolower(str_replace(' Progress','', $val)).'_add';
	                                    										  } elseif (str_contains($val, 'Type of Work')) {
	                                    										  	if (preg_match('/\bType of Work - \b/', $val)) {
	                                    										  		$check_name = str_replace(' - ', '_',$val);
	                                    										  		$check_add = strtolower(str_replace(' ','', $check_name)).'_add';
	                                    										  	} else {
	                                    										  		$check_add = strtolower(str_replace(' ','', $val)).'_add';	
	                                    										  	}
	                                    										  } elseif ($val == 'Physical Verification') {
	                                    										  	$check_add = strtolower(str_replace('Physical ','', $val)).'_add';
	                                    										  } else {
	                                    											$check_add = strtolower(str_replace(' ','_', $val)).'_add';	  	
	                                    										  }
	                                    									?>
	                                    									<?php $checked_add = in_array($check_add, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_add, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_add; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_add; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Update -->
	                                    								<td class="text-center">
	                                    									<?php if ($val == 'Physical Progress' || $val == 'Financial Progress') {
	                                    											$check_update = strtolower(str_replace(' Progress','', $val)).'_update';
	                                    										  } elseif (str_contains($val, 'Type of Work')) {
	                                    										  	if (preg_match('/\bType of Work - \b/', $val)) {
	                                    										  		$check_name = str_replace(' - ', '_',$val);
	                                    										  		$check_update = strtolower(str_replace(' ','', $check_name)).'_update';
	                                    										  	} else {
	                                    										  		$check_update = strtolower(str_replace(' ','', $val)).'_update';	
	                                    										  	}
	                                    										  } elseif ($val == 'Physical Verification') {
	                                    										  	$check_update = strtolower(str_replace('Physical ','', $val)).'_update';
	                                    										  } else {
	                                    											$check_update = strtolower(str_replace(' ','_', $val)).'_update';	  	
	                                    										  }
	                                    									?>
	                                    									<?php $checked_update = in_array($check_update, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_update, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_update; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_update; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Delete -->
	                                    								<td class="text-center">
	                                    									<?php if ($val == 'Physical Progress' || $val == 'Financial Progress') {
	                                    											$check_delete = strtolower(str_replace(' Progress','', $val)).'_delete';
	                                    										  } elseif (str_contains($val, 'Type of Work')) {
	                                    										  	if (preg_match('/\bType of Work - \b/', $val)) {
	                                    										  		$check_name = str_replace(' - ', '_',$val);
	                                    										  		$check_delete = strtolower(str_replace(' ','', $check_name)).'_delete';
	                                    										  	} else {
	                                    										  		$check_delete = strtolower(str_replace(' ','', $val)).'_delete';	
	                                    										  	}
	                                    										  } elseif ($val == 'Physical Verification') {
	                                    										  	$check_delete = strtolower(str_replace('Physical ','', $val)).'_delete';
	                                    										  } else {
	                                    											$check_delete = strtolower(str_replace(' ','_', $val)).'_delete';	  	
	                                    										  }
	                                    									?>
	                                    									<?php $checked_delete = in_array($check_delete, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_delete, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_delete; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_delete; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Download -->
	                                    								<td class="text-center">
	                                    									<?php if ($val == 'Physical Progress' || $val == 'Financial Progress') {
	                                    											$check_download = strtolower(str_replace(' Progress','', $val)).'_download';
	                                    										  } elseif (str_contains($val, 'Type of Work')) {
	                                    										  	if (preg_match('/\bType of Work - \b/', $val)) {
	                                    										  		$check_name = str_replace(' - ', '_',$val);
	                                    										  		$check_download = strtolower(str_replace(' ','', $check_name)).'_download';
	                                    										  	} else {
	                                    										  		$check_download = strtolower(str_replace(' ','', $val)).'_download';	
	                                    										  	}
	                                    										  } elseif ($val == 'Physical Verification') {
	                                    										  	$check_download = strtolower(str_replace('Physical ','', $val)).'_download';
	                                    										  } else {
	                                    											$check_download = strtolower(str_replace(' ','_', $val)).'_download';
	                                    										  }
	                                    									?>
	                                    									<?php $checked_download = in_array($check_download, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_download, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_download; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_download; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    							</tr>
	                                    							<?php 	}
	                                    								 	  } else {
	                                    								 	  	$i++;
	                                    							?>
	                                    							<tr data-row-id="<?php echo $i; ?>">
	                                    								<!-- Module Name -->
	                                    								<td><?php echo $key; ?></td>
	                                    								<!-- Full Access -->
	                                    								<td class="text-center">
	                                    									<?php $check_full_access = strtolower(str_replace(' ','_', $key)).'_fullaccess'; ?>
																		    <input type="checkbox" name="<?php echo $check_full_access ?>" value="Yes" onchange="setFullAccess(this)">
	                                    								</td>
	                                    								<!-- View -->
	                                    								<td class="text-center">
	                                    									<?php $check_view = strtolower(str_replace(' ','_', $key)).'_view'; ?>
	                                    									<?php $checked_view = in_array($check_view, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_view, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_view; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_view; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Add -->
	                                    								<td class="text-center">
	                                    									<?php $check_add = strtolower(str_replace(' ','_', $key)).'_add'; ?>
	                                    									<?php $checked_add = in_array($check_add, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_add, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_add; ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_add; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Update -->
	                                    								<td class="text-center">
	                                    									<?php $check_update = strtolower(str_replace(' ','_', $key)).'_update'; ?>
	                                    									<?php $checked_update = in_array($check_update, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_update, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_update ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_update; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Delete -->
	                                    								<td class="text-center">
	                                    									<?php $check_delete = strtolower(str_replace(' ','_', $key)).'_delete'; ?>
	                                    									<?php $checked_delete = in_array($check_delete, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_delete, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_delete ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_delete; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    								<!-- Download -->
	                                    								<td class="text-center">
	                                    									<?php $check_download = strtolower(str_replace(' ','_', $key)).'_download'; ?>
	                                    									<?php $checked_download = in_array($check_download, $role_data['module_access_data']) ? 'checked' : ''; ?>
	                                    									<?php $disabled = in_array($check_download, $module_access_list) ? '' : 'disabled'; ?>
																		    <input type="checkbox" name="<?php echo $check_download ?>" value="Yes" onchange="checkFullAccess(this)" <?php echo $checked_download; ?> <?php echo $disabled; ?>>
	                                    								</td>
	                                    							</tr>
	                                    								<?php } ?>
	                                    							<?php } ?>
	                                    						</tbody>
	                                    					</table>
	                                    				</div>
	            									</div>
	            								</div>

	            								<!-- Report Privileges -->
	            								<div class="form-row">
	                                    			<div class="col-xl-12 mt-3">
	                                    				<label class="form-label">
															<p>Report Access:</p>
														</label>
														<div class="table-responsive">
															<table class="table text-nowrap text-md-nowrap mb-0" id="reportAccessTable">
																<thead>
																	<tr>
																		<th style="text-align:left;">Report Name</th>
																		<th>Full Access</th>
																		<th>View</th>
																		<th>Download</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach ($report_list as $key => $value) { ?>
																	<tr>
																		<td><?php echo $value['name']; ?></td>
																		<!-- Full Access -->
																		<td class="text-center">
																			<?php if (str_contains($value['name'], 'Report')) {
																					$report_full_access = strtolower(str_replace(' ','_', $value['name'])).'_fullaccess';
																				  } else {
																				  	$report_full_access = strtolower(str_replace(' ','_', $value['name'])).'_report_fullaccess';
																				  }
																			?>
																		    <input type="checkbox" name="<?php echo $report_full_access ?>" value="Yes" onchange="setReportFullAccess(this)">
																		</td>
																		<!-- View -->
																		<td class="text-center">
																			<?php if (str_contains($value['name'], 'Report')) {
																					$report_view = strtolower(str_replace(' ','_', $value['name'])).'_view'; 
																				  } else {
																				  	$report_view = strtolower(str_replace(' ','_', $value['name'])).'_report_view';
																				  }
																			?>
																			<?php $checked_report_view = in_array($report_view, $role_data['report_access_data']) ? 'checked' : ''; ?>
																		    <input type="checkbox"name="<?php echo $report_view; ?>" value="Yes" onchange="checkReportFullAccess(this)" <?php echo $checked_report_view; ?>>
																		</td>
																		<!-- Download -->
																		<td class="text-center">
																			<?php if (str_contains($value['name'], 'Report')) {
																					$report_download = strtolower(str_replace(' ','_', $value['name'])).'_download';
																				  } else {
																				  	$report_download = strtolower(str_replace(' ','_', $value['name'])).'_report_download';	
																				  }
																			?>
																			<?php $checked_report_download = in_array($report_download, $role_data['report_access_data']) ? 'checked' : ''; ?>
																		    <input type="checkbox" name="<?php echo $report_download; ?>" value="Yes" onchange="checkReportFullAccess(this)" <?php echo $checked_report_download; ?>>
																		</td>
																	</tr>	
																	<?php } ?>
																</tbody>
															</table>
														</div>
	                                    			</div>
	                                    		</div>

	                                    		<button class="btn btn-success mb-3 mt-3" type="submit">Update</button>
	                                    		<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('roles'); ?>">Back</a>
	            							</div>

	            						</div>
	            					</form>
	            				</div>
	            			</div>
	            			<!-- Row Ends -->

	            		</div>
	            		<!-- Container Ends -->
	            	</div>
	            </div>
	            <!-- App-Content Ends -->

	    	</div>

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

	    <!-- SWEET-ALERT JS -->
	    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

	    <script type="text/javascript">
	    	let form_change = false;
	    	let access_revoked_modules = [];
	    	let access_revoked_reports = [];

	    	function changeFormStatus() {
				form_change = true;
	    	}

	    	// Marking full access checkbox checked if all access is granted
	    	$(document).ready(function() {
	    		let module_trs = $('#moduleAccessTable tbody').find('tr');

	    		$(module_trs).each(function(index, value) {
	    			let checkbox_count = $(value).find('input[type="checkbox"]:enabled').length;

	    			let module_checkboxes = $(value).find('input[type="checkbox"]:checked');

	    			if (module_checkboxes.length == (checkbox_count - 1)) {
	    				$(value).find('input[name*="fullaccess"]').prop('checked', true);
	    			}
	    		});

	    		let report_trs = $('#reportAccessTable tbody').find('tr');

	    		$(report_trs).each(function(index, value) {
	    			let checkbox_count = $(value).find('input[type="checkbox"]').length;

	    			let report_checkboxes = $(value).find('input[type="checkbox"]:checked');

	    			if (report_checkboxes.length == (checkbox_count - 1)) {
	    				$(value).find('input[name*="report_fullaccess"]').prop('checked', true);
	    			}
	    		});
	    	});

	    	function setFullAccess(checkbox) {
	    		let tr = $(checkbox).closest('tr');

	    		if ($(checkbox).is(':checked') == true) {
	    			$(tr).find('input[type="checkbox"]:enabled').each(function(index, value) {
		    			if ($(value).prop('checked') == false) {
		    				$(value).prop('checked', true);
		    			}
		    		});
	    		} else {
	    			$(tr).find('input[type="checkbox"]:enabled').each(function(index, value) {
		    			if ($(value).prop('checked') == true) {
		    				access_revoked_modules.push($(value).attr('name'));
		    				$(value).prop('checked', false);
		    			}
		    		});

		    		if (!$.isEmptyObject(access_revoked_modules)) {
		    			$('input[name="access_revoked_modules"]').val(access_revoked_modules);
		    		}

		    		if ($(checkbox).attr('name') == 'reports_fullaccess') {
		    			let report_trs = $('#reportAccessTable tbody').find('tr');

			    		$(report_trs).each(function(index, value) {
			    			let report_checkboxes = $(value).find('input[type="checkbox"]:checked');

			    			$(report_checkboxes).each(function(i, val) {
			    				access_revoked_reports.push($(val).attr('name'));
			    				$(val).prop('checked', false);
			    			});

			    			if (!$.isEmptyObject(access_revoked_reports)) {
			    				$('input[name="access_revoked_reports"]').val(access_revoked_reports);
			    			}
			    		});	
		    		}
	    		}
	    	}

	    	function setReportFullAccess(checkbox) {
	    		let tr = $(checkbox).closest('tr');

	    		let report_module_fullaccess = $('#moduleAccessTable tbody').find('input[name="reports_fullaccess"]');

	    		if ($(checkbox).is(':checked') == true) {
	    			if ($(report_module_fullaccess).is(':checked') == true) {
		    			$(tr).find('input[type="checkbox"]').each(function(index, value) {
			    			if ($(value).prop('checked') == false) {
			    				$(value).prop('checked', true);
			    			}
			    		});	
		    		} else {
		    			$('.toast-body').text('Kindly grant full access to Reports Module first');
			      		$('.toast').toast('show');

			      		$(tr).find('input[name*="report_fullaccess"]').prop('checked', false);

			      		return false;
		    		}	
	    		} else {
	    			$(tr).find('input[type="checkbox"]:checked').each(function(index, value) {
	    				access_revoked_reports.push($(value).attr('name'));
	    				$(value).prop('checked', false);
	    			});

	    			if (!$.isEmptyObject(access_revoked_reports)) {
	    				$('input[name="access_revoked_reports"]').val(access_revoked_reports);
	    			}
	    		}
	    	}

	    	function checkFullAccess(checkbox) {
	    		let tr = $(checkbox).closest('tr');
	    		let check_count = $(tr).find('input[type="checkbox"]:enabled').length;

	    		if ($(checkbox).is(':checked') == true) {
	    			if ($(tr).find('input[type="checkbox"]:checked').length == (check_count - 1)) {
		    			$(tr).find('input[name*="fullaccess"]').prop('checked', true);
		    		}	
	    		} else {
	    			access_revoked_modules.push($(checkbox).attr('name'));

	    			$('input[name="access_revoked_modules"]').val(access_revoked_modules);

	    			let module_fullaccess_checkbox = $(tr).find('input[name*="fullaccess"]')

	    			if ($(module_fullaccess_checkbox).is(':checked')) {
	    				$(module_fullaccess_checkbox).prop('checked', false);
	    			}

	    			let checkbox_name = $(checkbox).attr('name');

	    			if (checkbox_name == 'reports_view') {
	    				let report_view_checkboxes = $('#reportAccessTable tbody').find('input[name*="report_view"]:checked');
	    				$(report_view_checkboxes).each(function(index, value) {
	    					$(value).prop('checked', false);
	    					access_revoked_reports.push($(value).attr('name'));
	    				});
	    			} else if (checkbox_name == 'reports_download') {
	    				let report_download_checkboxes = $('#reportAccessTable tbody').find('input[name*="report_download"]:checked');
	    				$(report_download_checkboxes).each(function(index, value) {
	    					$(value).prop('checked', false);
	    					access_revoked_reports.push($(value).attr('name'));
	    				});
	    			}

	    			if (checkbox_name == 'reports_view' || checkbox_name == 'reports_download') {
	    				let report_fullaccess_checkboxes = $('#reportAccessTable tbody').find('input[name*="report_fullaccess"]:checked');

	    				$(report_fullaccess_checkboxes).each(function(index, value) {
	    					$(value).prop('checked', false);
	    				});

	    				$('input[name="access_revoked_reports"]').val(access_revoked_reports);
	    			}
	    		}
	    	}

	    	function checkReportFullAccess(checkbox) {
	    		let tr = $(checkbox).closest('tr');
	    		let check_count = $(tr).find('input[type="checkbox"]').length;
	    		let access_granted = 0;

	    		if ($(checkbox).is(':checked')) {
	    			let checkbox_name = $(checkbox).attr('name');

	    			if (checkbox_name.includes('view')) {
	    				let report_module_view = $('#moduleAccessTable tbody').find('input[name="reports_view"]');

	    				if ($(report_module_view).is(':checked')) {
	    					access_granted = 1;
	    				} else {
	    					$('.toast-body').text('Kindly grant view access to Reports Module first');
				      		$('.toast').toast('show');

				      		$(tr).find('input[name*="report_view"]').prop('checked', false);

				      		return false;
	    				}
	    			} else if (checkbox_name.includes('download')) {
	    				let report_module_download = $('#moduleAccessTable tbody').find('input[name="reports_download"]');

	    				if ($(report_module_download).is(':checked')) {
	    					access_granted = 1;
	    				} else {
	    					$('.toast-body').text('Kindly grant download access to Reports Module first');
				      		$('.toast').toast('show');

				      		$(tr).find('input[name*="report_download"]').prop('checked', false);

				      		return false;
	    				}
	    			}

	    			if (access_granted) {
	    				if ($(tr).find('input[type="checkbox"]:checked').length == (check_count - 1)) {
			    			$(tr).find('input[name*="report_fullaccess"]').prop('checked', true);
			    		}	
	    			}
	    		} else {
	    			access_revoked_reports.push($(checkbox).attr('name'));

	    			$('input[name="access_revoked_reports"]').val(access_revoked_reports);


	    			console.log('access_revoked_reports:');
	    			console.log(access_revoked_reports);

	    			let report_fullaccess_checkbox = $(tr).find('input[name*="report_fullaccess"]');

	    			if ($(report_fullaccess_checkbox).is(':checked')) {
	    				$(report_fullaccess_checkbox).prop('checked', false);
	    			}
	    		}
	    	}

	    	//Check if there's any change in the form before submitting the form
	    	$('#updateRole').on('submit', function(event) {
	    		var inputs = $('#updateRole').find(':input[type="text"]');

	    		$(inputs).each(function(index, value) {
	    			$(this).change(function() {
		      			form_change = true;
		      		});
	    		});

	    		var checkboxes = $('#updateRole').find(':input[type="checkbox"]:checked');
	    		if (checkboxes.length > 0) {
	    			form_change = true;	
	    		} else {
	    			form_change = false;	
	    		}

	    		if (!$('input[name="roleName"]').val()) {
	    			$('.toast-body').text('Enter Role Name');
		      		$('.toast').toast('show');

		      		event.preventDefault();
		      		return false;
	    		}

	    		if (!$('input[name="roleDesc"]').val()) {
	    			$('.toast-body').text('Enter Role Description');
		      		$('.toast').toast('show');

		      		event.preventDefault();
		      		return false;
	    		}

	    		if (form_change === false) {
		      		$('.toast-body').text('No changes occurred. Kindly add a role and select atleast one access for the role.');
		      		$('.toast').toast('show');

		      		event.preventDefault();
		      	}
	    	});
	    </script>
	</body>
</html>