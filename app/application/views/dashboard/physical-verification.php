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
	    <title>MPPKVVCL - Dashboard</title>

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
	            		
	            		<!-- CONTAINER -->
	            		<div class="main-container container-fluid">

	            			<!-- PAGE-HEADER -->
	            			<div class="page-header">
	            				<h1 class="page-title">Physical Progress (% Completion wise) in RDSS Project MPPKVVCL, Jabalpur</h1>
	            				<div class="col-md-2 milestone-border">
	            					<div class="form-group">
                                        <input class="form-control" type="date" name="monthdate" onchange="changepp(this.value);" value="<?php echo $date; ?>"/>
                                    </select>
	            					</div>
	            				</div>
	            			</div>
	            			<!-- PAGE-HEADER ENDS -->

	            			<div class="row">
	            				<div class="col-xl-12">
	            					<div class="card">
	            						<div class="card-body mt-3 mb-3">
	            							<div class="table-responsive">
	            								<table class="table border text-wrap text-md-nowrap table-bordered mb-0" id="physical-verification-table">
	            									<thead>
	            										<tr>
	            											<th>Lot No.</th>
	            											<th>Name of TKC</th>
	            											<th>Type of Work</th>
	            											<th colspan="2">Total Provision As Per LOA</th>
	            											<th colspan="6">Physical Verification (Feeders Count)</th>
	            										</tr>
	            										<tr>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th>S/S</th>
	            											<th>Feeders</th>
	            											<th>0% - 25%</th>
	            											<th>25% - 50%</th>
	            											<th>50% - 75%</th>
	            											<th>75% - 90%</th>
	            											<th>90% - 100%</th>
	            											<th>100%</th>
	            										</tr>
	            									</thead>
	            									<tbody>
	            										<?php foreach ($verification_data as $key => $value) { ?>
	            										<tr data-contract-id="<?php echo $value['contract_id']; ?>" data-package-no="<?php echo $value['package_no']; ?>">
	            											<td style="text-align: left;"><?php echo $value['package_no']; ?></td>
	            											<td style="text-align: left;"><?php echo $value['contractor_name']; ?></td>
	            											<td style="text-align: left;"><?php echo $value['typeofwork']; ?></td>
	            											<td style="text-align: center;"><?php echo $value['ss']; ?></td>
	            											<td style="text-align: center;"><?php echo $value['feeders']; ?></td>
	            											<td style="text-align: center;" data-slab="0% - 25%">
	            												<?php if ($value['0% - 25%'] != 0) {
	            														$data_0_25 = '<a href="javascript:void(0)" onclick="showFeedersModal(this)">'.$value['0% - 25%'].'</a>';
	            													  } else {
	            													  	$data_0_25 = $value['0% - 25%'];
	            													  }
	            												?>
	            												<?php echo $data_0_25; ?>
            												</td>
	            											<td style="text-align: center;" data-slab="25% - 50%">
	            												<?php if ($value['25% - 50%'] != 0) {
	            														$data_25_50 = '<a href="#" onclick="showFeedersModal(this)">'.$value['25% - 50%'].'</a>';
	            													  } else {
	            													  	$data_25_50 = $value['25% - 50%'];
	            													  }
	            												?>
	            												<?php echo $data_25_50; ?>
	            											</td>
	            											<td style="text-align: center;" data-slab="50% - 75%">
	            												<?php if ($value['50% - 75%'] != 0) {
	            														$data_50_75 = '<a href="#" onclick="showFeedersModal(this)">'.$value['50% - 75%'].'</a>';
	            													  } else {
	            													  	$data_50_75 = $value['50% - 75%'];
	            													  }
	            												?>
	            												<?php echo $data_50_75; ?>
	            											</td>
	            											<td style="text-align: center;" data-slab="75% - 90%">
	            												<?php if ($value['75% - 90%'] != 0) {
	            														$data_75_90 = '<a href="#" onclick="showFeedersModal(this)">'.$value['75% - 90%'].'</a>';
	            													  } else {
	            													  	$data_75_90 = $value['75% - 90%'];
	            													  }
	            												?>
	            												<?php echo $data_75_90; ?>
	            											</td>
	            											<td style="text-align: center;" data-slab="90% - 100%">
	            												<?php if ($value['90% - 100%'] != 0) {
	            														$data_90_100 = '<a href="#" onclick="showFeedersModal(this)">'.$value['90% - 100%'].'</a>';
	            													  } else {
	            													  	$data_90_100 = $value['90% - 100%'];
	            													  }
	            												?>
	            												<?php echo $data_90_100; ?>
            												</td>
	            											<td style="text-align: center;" data-slab="100%">
	            												<?php if ($value['100%'] != 0) {
	            														$data_100 = '<a href="#" onclick="showFeedersModal(this)">'.$value['100%'].'</a>';
	            													  } else {
	            													  	$data_100 = $value['100%'];
	            													  }
	            												?>
	            												<?php echo $data_100; ?>
            												</td>
	            										</tr>	
	            										<?php } ?>
	            									</tbody>
	            								</table>
	            							</div>
	            						</div>
	            					</div>	
	            				</div>
	            			</div>
	            			
	            		</div>
	            		<!-- CONTAINER ENDS -->

	            	</div>
	            </div>
	            <!-- App-Content Ends -->
	    	</div>

	    	<!-- Feeders List Modal -->
	    	<div class="modal fade" id="feeders-list-modal" tabindex="-1" role="dialog">
	    		<div class="modal-dialog modal-xl " role="document">
	    			<div class="modal-content">
	    				<div class="modal-header">
	    					<h5 class="modal-title" id="modal_title"></h5>
	    					<button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">×</span>
	                        </button>
	                        <!-- Toaster Alert -->
              				<div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-animation="true" id="feeder-list-alert">
                				<div class="d-flex toster-out">
                					<div class="toast-body"> Hello, world! This is a toast message. </div>
                					<button aria-label="Close" class="btn-close text-white ms-auto  pe-2" data-bs-dismiss="toast" style="margin: -6px;">
                   						<span aria-hidden="true">×</span>
                  					</button>
                				</div>
          					</div>
    					</div>

	    				<div class="modal-body physical-popup">
	    					<form class="form-horizontal">
	    						<div class="row">
	    							<!-- Region -->
	    							<div class="col-md-3">
	    								<label class="form-label" for="region">Region</label>
	    								<select class="form-control form-select" name="region" id="region">
	    									<option value="select" selected disabled>Select Region</option>
	    								</select>
	    							</div>
	    							<!-- Circle -->
	    							<div class="col-md-3">
	    								<label class="form-label" for="circle">Circle</label>
	    								<select class="form-control form-select" name="circle" id="circle">
	    									<option value="select" selected disabled>Select Circle</option>
	    								</select>
	    							</div>
	    							<!-- Division -->
	    							<div class="col-md-3">
	    								<label class="form-label" for="division">Division</label>
	    								<select class="form-control form-select" name="division" id="division">
	    									<option value="select" selected disabled>Select Division</option>
	    								</select>
	    							</div>
	    							<!-- Filter Button -->
	    							<div class="col-md-3">
	    								<button class="btn btn-primary mt-6 p-2" type="button" onclick="applyFilter()">Apply Filters</button>
	    								<button type="button" class="btn btn-danger mt-6 ml-0 p-2" onclick="clearFilter()">CLEAR</button>
	    							</div>
	    						</div>
	    					</form>

	    					<!-- Feeders List Table -->
	    					<div class="row">
	    						<div class="table-responsive">
	    							<table class="table text-nowrap text-md-nowrap mb-0 mt-3 text-center table-hover" id="feeders-list-table">
	    								<thead>
	    									<tr>
	    										<!-- <th>Contract No</th>
	    										<th>Contractor</th> -->
	    										<th>Region/Circle/Division</th>
	    										<th>Site Location</th>
	    										<th>Feeder ID</th>
	    										<th>Task</th>
	    										<th>Observation</th>
	    										<th>Last Reported By</th>
	    										<th>Last Reported Date</th>
	    										<th>Status</th>
	    										<th>Action</th>
	    									</tr>
	    								</thead>
	    								<tbody>
	    									<tr>
	    										<!-- <td></td>
	    										<td></td> -->
	    										<td></td>
	    										<td></td>
	    										<td></td>
	    										<td></td>
	    										<td></td>
	    										<td></td>
	    										<td></td>
	    										<td></td>
	    									</tr>
	    								</tbody>
	    							</table>
	    						</div>
	    					</div>
	    					<!-- Feeders List Table Ends -->
	    				</div>

	    				<div class="modal-footer">
	    					<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	    					<input type="hidden" name="slab" id="slab" value="">
	    					<input type="hidden" name="contract_id" id="contract_id" value="">
	    					<input type="hidden" name="package_no" id="package_no" value="">
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<!-- Feeders List Modal Ends -->

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

        <script type="text/javascript">
        	let regions = '';
        	let circles = '';
        	let divisions = '';

        	function showFeedersModal(anchor) {
        		let slab = $(anchor).closest('td').data('slab');
        		let contract_id = $(anchor).closest('tr').data('contract-id');
        		let package_no = $(anchor).closest('tr').data('package-no');
        		let date = $('input[name="monthdate"]').val();

        		$('#slab').val(slab);
        		$('#contract_id').val(contract_id);
        		$('#package_no').val(package_no);

        		// Ajax call to get feeders data
        		$.ajax({
        			type: 'POST',
        			url: '<?php echo base_url('get-feeders-list') ?>',
        			dataType: 'json',
        			data: {slab:slab, contract_id:contract_id, package_no:package_no, date:date},
        			success: function(response) {
        				let feeders_list = response.feeders_data;
        				regions = response.regions;
        				circles = response.circles;
        				divisions = response.divisions;

        				let region_html = '';

        				region_html += '<option value="select" selected disabled>Select Region</option>';
        				$.each(regions, function(index, value) {
        					region_html += '<option value="'+ value.region_id +'">'+ value.region_name +'</option>';
        				});

        				$('select[name="region"]').empty();
        				$('select[name="region"]').append(region_html);

        				if (!$.isEmptyObject(feeders_list)) {
        					let tbody_html = '';
        					let contractor = '';

        					$.each(feeders_list, function(index, value) {
        						let mode = "";
					            let action_btn = '';
					            let status_color = '';

					            if (value.name == 'Open') {
					            	mode = "edit-new";
					            	action_btn = 'fe fe-edit';
					            	status_color = 'text-gray';
					            } else if (value.name == 'In Process') {
					            	mode = "edit-prev";
					            	action_btn = 'fe fe-edit';
					            	status_color = 'text-yellow';
					            } else if (value.name == 'Reviewed') {
					            	mode = "view";
					            	action_btn = 'fa fa-eye';
					            	status_color = 'text-blue';
					            } else if (value.name == 'Completed') {
					            	mode = "view";
					            	action_btn = 'fa fa-eye';
					            	status_color = 'text-green';
					            }

					            let url = '<?php echo base_url("add-physical-progress") ?>' + '/' + mode + '/' + value.physical_progress_id + '/' + value.contract_id + '/' + value.contract_location_id;

        						tbody_html += '<tr>';
        						/*tbody_html += '<td>'+ value.contract_no +'</td>';
        						tbody_html += '<td>'+ value.contractor +'</td>';*/
        						tbody_html += '<td>'+ value.region_circle_division +'</td>';
        						tbody_html += '<td>'+ value.site_location +'</td>';
        						tbody_html += '<td>'+ value.feeder_id +'</td>';
        						tbody_html += '<td>'+ value.task +'</td>';
        						tbody_html += '<td>'+ value.observation +'</td>';
        						tbody_html += '<td>'+ value.username +'</td>';
        						tbody_html += '<td>'+ value.reported_date +'</td>';
        						tbody_html += '<td class="'+ status_color +'">'+ value.name +'</td>';
        						tbody_html += '<td><a target="_blank" href="'+ url +'" id="bEdit" type="button" class="btn btn-sm"><span class="'+ action_btn +' fa-lg action-btn-table"></span></td>';
        						tbody_html += '</tr>';

        						contractor = value.contractor;
        					});

        					$('#modal_title').text(contractor);

        					$('#feeders-list-table').find('tbody').empty();
        					$('#feeders-list-table').find('tbody').append(tbody_html);
        				} else {
        					let tbody_html = '';
        					tbody_html += '<tr><td style="text-align:center">No records found</td></tr>';

        					$('#feeders-list-table').find('tbody').empty();
        					$('#feeders-list-table').find('tbody').append(tbody_html);
        				}

        				$('#feeders-list-modal').modal('show');
        			},
        			error: function(xhr, status, error) {
        				console.log(xhr.responseText);
        			}
        		});
        	}

        	$('select[name="region"]').on('change', function() {
        		let selected_region = $('select[name="region"] option:selected').text();
        		let circle_data = circles[selected_region];

        		let circle_html = '';

				circle_html += '<option value="select" selected disabled>Select Circle</option>';
				$.each(circle_data, function(index, value) {
					circle_html += '<option value="'+ index +'">'+ value +'</option>';
				});

				$('select[name="circle"]').empty();
				$('select[name="circle"]').append(circle_html);
        	});

        	$('select[name="circle"]').on('change', function() {
        		let selected_circle = $('select[name="circle"] option:selected').text();
        		let division_data = divisions[selected_circle];

        		let division_html = '';

				division_html += '<option value="select" selected disabled>Select Division</option>';
				$.each(division_data, function(index, value) {
					division_html += '<option value="'+ index +'">'+ value +'</option>';
				});

				$('select[name="division"]').empty();
				$('select[name="division"]').append(division_html);
        	});

        	function applyFilter() {
        		let selected_region_id = $('select[name="region"]').val();
        		let selected_circle_id = $('select[name="circle"]').val();
        		let selected_division_id = $('select[name="division"]').val();

        		if (selected_region_id == null && selected_circle_id == null && selected_division_id == null) {
        			$('#feeder-list-alert').find('.toast-body').text('No Filter selected');
      				$('#feeder-list-alert').toast('show');
      				return false;
        		} else {
        			let slab = $('#slab').val();
        			let contract_id = $('#contract_id').val();
        			let package_no = $('#package_no').val();
        			let date = $('input[name="monthdate"]').val();

        			// Ajax call to get feeders data with filters
        			$.ajax({
        				type: 'POST',
        				url: '<?php echo base_url('get-feeders-list') ?>',
        				dataType: 'json',
        				data: {slab:slab, contract_id:contract_id, package_no:package_no,date:date, region_id:selected_region_id, circle_id:selected_circle_id, division_id:selected_division_id},
        				success: function(response) {
        					let feeders_list = response.feeders_data;
        					console.log(feeders_list);
        					if (!$.isEmptyObject(feeders_list)) {
	        					let tbody_html = '';
	        					let contractor = '';

	        					$.each(feeders_list, function(index, value) {
	        						let mode = "";
						            let action_btn = '';
						            let status_color = '';

						            if (value.name == 'Open') {
						            	mode = "edit-new";
						            	action_btn = 'fe fe-edit';
						            	status_color = 'text-gray';
						            } else if (value.name == 'In Process') {
						            	mode = "edit-prev";
						            	action_btn = 'fe fe-edit';
						            	status_color = 'text-yellow';
						            } else if (value.name == 'Reviewed') {
						            	mode = "view";
						            	action_btn = 'fa fa-eye';
						            	status_color = 'text-blue';
						            } else if (value.name == 'Completed') {
						            	mode = "view";
						            	action_btn = 'fa fa-eye';
						            	status_color = 'text-green';
						            }

						            let url = '<?php echo base_url("add-physical-progress") ?>' + '/' + mode + '/' + value.physical_progress_id + '/' + value.contract_id + '/' + value.contract_location_id;

	        						tbody_html += '<tr>';
	        						/*tbody_html += '<td>'+ value.contract_no +'</td>';
	        						tbody_html += '<td>'+ value.contractor +'</td>';*/
	        						tbody_html += '<td>'+ value.region_circle_division +'</td>';
	        						tbody_html += '<td>'+ value.site_location +'</td>';
	        						tbody_html += '<td>'+ value.feeder_id +'</td>';
	        						tbody_html += '<td>'+ value.task +'</td>';
	        						tbody_html += '<td>'+ value.observation +'</td>';
	        						tbody_html += '<td>'+ value.username +'</td>';
	        						tbody_html += '<td>'+ value.reported_date +'</td>';
	        						tbody_html += '<td class="'+ status_color +'">'+ value.name +'</td>';
	        						tbody_html += '<td><a target="_blank" href="'+ url +'" id="bEdit" type="button" class="btn btn-sm"><span class="'+ action_btn +' fa-lg action-btn-table"></span></td>';
	        						tbody_html += '</tr>';

	        						contractor = value.contractor;
	        					});

	        					$('#modal_title').text(contractor);

	        					$('#feeders-list-table').find('tbody').empty();
	        					$('#feeders-list-table').find('tbody').append(tbody_html);
	        				} else {
	        					let tbody_html = '';
	        					tbody_html += '<tr><td style="text-align:center">No records found</td></tr>';

	        					$('#feeders-list-table').find('tbody').empty();
	        					$('#feeders-list-table').find('tbody').append(tbody_html);
	        				}
        				},
        				error: function(xhr, status, error) {
        					console.log(xhr.responseText);
        				}
        			});
        		}
        	}

        	function clearFilter() {
        		$('select[name="region"]').val('select').change();
        		$('select[name="circle"]').val('select').change();
        		$('select[name="division"]').val('select').change();

        		let slab = $('#slab').val();
    			let contract_id = $('#contract_id').val();
    			let package_no = $('#package_no').val();
    			let date = $('input[name="monthdate"]').val();

    			// Ajax call to get feeders data by clearing filters
    			$.ajax({
    				type: 'POST',
    				url: '<?php echo base_url('get-feeders-list') ?>',
    				dataType: 'json',
    				data: {slab:slab, contract_id:contract_id, package_no:package_no, date:date},
    				success: function(response) {
    					let feeders_list = response.feeders_data;

    					if (!$.isEmptyObject(feeders_list)) {
        					let tbody_html = '';
        					let contractor = '';

        					$.each(feeders_list, function(index, value) {
        						let mode = "";
					            let action_btn = '';
					            let status_color = '';

					            if (value.name == 'Open') {
					            	mode = "edit-new";
					            	action_btn = 'fe fe-edit';
					            	status_color = 'text-gray';
					            } else if (value.name == 'In Process') {
					            	mode = "edit-prev";
					            	action_btn = 'fe fe-edit';
					            	status_color = 'text-yellow';
					            } else if (value.name == 'Reviewed') {
					            	mode = "view";
					            	action_btn = 'fa fa-eye';
					            	status_color = 'text-blue';
					            } else if (value.name == 'Completed') {
					            	mode = "view";
					            	action_btn = 'fa fa-eye';
					            	status_color = 'text-green';
					            }

					            let url = '<?php echo base_url("add-physical-progress") ?>' + '/' + mode + '/' + value.physical_progress_id + '/' + value.contract_id + '/' + value.contract_location_id;

        						tbody_html += '<tr>';
        						/*tbody_html += '<td>'+ value.contract_no +'</td>';
        						tbody_html += '<td>'+ value.contractor +'</td>';*/
        						tbody_html += '<td>'+ value.region_circle_division +'</td>';
        						tbody_html += '<td>'+ value.site_location +'</td>';
        						tbody_html += '<td>'+ value.feeder_id +'</td>';
        						tbody_html += '<td>'+ value.task +'</td>';
        						tbody_html += '<td>'+ value.observation +'</td>';
        						tbody_html += '<td>'+ value.username +'</td>';
        						tbody_html += '<td>'+ value.reported_date +'</td>';
        						tbody_html += '<td class="'+ status_color +'">'+ value.name +'</td>';
        						tbody_html += '<td><a target="_blank" href="'+ url +'" id="bEdit" type="button" class="btn btn-sm"><span class="'+ action_btn +' fa-lg action-btn-table"></span></td>';
        						tbody_html += '</tr>';

        						contractor = value.contractor;
        					});

        					$('#modal_title').text(contractor);

        					$('#feeders-list-table').find('tbody').empty();
        					$('#feeders-list-table').find('tbody').append(tbody_html);
        				}
    				},
    				error: function(xhr, status, error) {
    					console.log(xhr.responseText);
    				}
    			});
        	}

        	function changepp(date) {
        		window.location.href = '<?php echo base_url(); ?>' + "physical-verification/" + date;
        	}
        </script>
	</body>
</html>