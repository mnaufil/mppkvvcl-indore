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
	          					<h1 class="page-title">Report Name: Compliance By TKC Report</h1>
	          				</div>
	          				<!-- PAGE-HEADER END -->

	          				<!-- ROW -->
	          				<div class="row">
	          					<div class="col-lg-12">
	          						<div class="card">
	          							<div class="card-body">
	          								
	          								<!-- Report Description -->
	          								<div class="form-row mt-2 mb-2">
	          									<div class="col-xl-4">
	          										<label class="form-label">Report Description:</label>
	          										<p class="report-desc">Compliance By TKC</p>
	          									</div>
	          								</div>

	          								<!-- Form -->
	          								<form id="generateComplianceByTKCReport" name="generateComplianceByTKCReport" method="POST" action="<?php echo base_url('generate-compliance-by-tkc-report'); ?>">
	          									<!-- Row1 -->
	          									<div class="form-row">
	          										<!-- Contractor (TKC) -->
			                						<div class="col-xl-4 mb-3">
			                							<label for="contractor" class="form-label">Contractor (TKC)<!-- <span class="text-red">*</span> --></label>
				                                       	<input class="form-control" type="text" name="contractor" id="contractor" onkeyup="showtkclist(this.value)" value="<?php echo $contractor;?>">
                                                        <div class="list-group list-view-contractor" id="list-view"></div>
			                						</div>
			                						<!-- Lot No -->
			                						<div class="col-xl-2 mb-3">
			                							<label for="package_group_no" class="form-label">Lot No.<!-- <span class="text-red">*</span> --></label>
			                							<select class="filter-multi" id="package_group_no" name="package_group_no[]" multiple="multiple">
							                              	<?php foreach($package_group_nos as $package_group_no) { ?>
							                              	<?php $lot_selected = (is_array($selected_package_group_no) && in_array($package_group_no, $selected_package_group_no)) ? 'selected' : ''; ?>
							                              	<option value="<?php echo $package_group_no;?>" <?php echo $lot_selected; ?>><?php echo $package_group_no;?></option>
							                              	<?php } ?>
							                              </select>
			                						</div>
			                						<!-- Circle -->
			                						<div class="col-xl-2">
			                							<label for="circle" class="form-label">Circle<!-- <span class="text-red">*</span> --></label>
			                							<select class="form-control select2" id="circle" name="circle">
			                								<option value="" selected disabled>Select Circle</option>
			                								<?php foreach ($circles as $circle) { ?>
			                								<?php $circle_selected = ($circle['circle_id'] == $selected_circle) ? 'selected' : ''; ?>
			                								<option value="<?php echo $circle['circle_id']; ?>" <?php echo $circle_selected; ?>><?php echo $circle['circle_name']; ?></option>
			                								<?php } ?>
			                							</select>
			                						</div>
			                						<!-- Date Range -->
			                						<div class="col-xl-4 mb-3">
			                							<label class="form-label" for="complianceByTKCDate">Compliance By TKC Date<!-- <span class="text-red">*</span> --></label>
			                							<div class="input-group">
				                                      		<div class="input-group-text dates">
				                                        		<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
				                                      		</div>
				                                      		<input type="text" class="form-control" name="complianceByTKCDate" id="complianceByTKCDate" value="<?php echo $complianceByTKCDate;?>" />
				                                    	</div>
			                						</div>
	          									</div>
	          									<button class="btn btn-success mb-3 mt-3" type="submit">Generate </button>
												<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('compliance_by_tkc_report')?>">Clear</a>
               									<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports')?>">Back</a>
	          								</form>
	          								<!-- Form Ends -->
	          							</div>
	          						</div>
	          					</div>
	          				</div>
	          				<!-- ROW Ends -->

	          				<!-- Report Row -->
	          				<?php if (isset($report_data) && is_array($report_data)) { ?>
	          				<div class="row" id="report-table">
	          					<div class="col-lg-12">
	          						<div class="card">
	          							<div class="card-body">
	          								
	          								<?php if ($download_access) { ?>
	          								<div class="row">
	          									<!-- Export Button -->
	          									<div class="col-sm-12 col-md-9s mt-3 mb-3">
	          										<div class="dts-buttons btn-group flex-wrap" style="float:right;">
	          											<a target="_blank" href="<?php echo base_url('compliance-by-tkc-report-pdf');?>" class="btn btn-success" type="button"><span>View in Pdf</span></a>
	          										</div>
	          									</div>
	          								</div>
	          								<?php } ?>

	          								<div class="row mb-3">
	          									<div class="col-xl-12" style="overflow: auto;width: 500px;">
	          										<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
	          											<tbody>
	          												<?php //$i = 0; ?>
	          												<?php foreach ($report_data as $key => $value) { ?>
	          												<?php foreach ($value as $k => $v) { ?>
	          												<?php if ($k == 0) { ?>	
	          												<!-- DISCOM -->
	          												<tr>
	          													<td><b>DISCOM</b></td>
	          													<td>MPPKVVCL</td>
	          												</tr>
	          												<!-- TKC -->
	          												<tr>
	          													<td><b>TKC</b></td>
	          													<td><?php echo $v['contractor_name']; ?></td>
	          												</tr>
	          												<!-- Package No -->
	          												<tr>
	          													<td><b>Package No</b></td>
	          													<td><?php echo $v['package_no']; ?></td>
	          												</tr>
	          												<!-- Contractor Name -->
	          												<tr>
	          													<td><b>Contractor Name</b></td>
	          													<td><?php echo $v['contractor_name']; ?></td>
	          												</tr>
	          												<!-- Region Name -->
	          												<tr>
	          													<td><b>Region Name</b></td>
	          													<td><?php echo $v['region_name']; ?></td>
	          												</tr>
	          												<!-- Circle Name -->
	          												<tr>
	          													<td><b>Circle Name</b></td>
	          													<td><?php echo $v['circle_name']; ?></td>
	          												</tr>
	          												<!-- Division Name -->
	          												<tr>
	          													<td><b>Division Name</b></td>
	          													<td><?php echo $v['division_name']; ?></td>
	          												</tr>
	          												<!-- Feeder ID -->
	          												<tr>
	          													<td><b>Feeder ID</b></td>
	          													<td><?php echo $v['feeder_id']; ?></td>
	          												</tr>
	          												<!-- Feeder Name -->
	          												<tr>
	          													<td><b>Feeder Name</b></td>
	          													<td><?php echo $v['feeder_name']; ?></td>
	          												</tr>
	          												<!-- Substation -->
	          												<tr>
	          													<td><b>Substation</b></td>
	          													<td><?php echo $v['substation']; ?></td>
	          												</tr>
	          												<!-- Standards -->
	          												<tr>
	          													<td><b>Standards</b></td>
	          													<td><?php echo $v['standards']; ?></td>
	          												</tr>
	          												<!-- Line Break -->
	          												<tr style="height:40px">
							                                	<td border='0'></td>
							                                	<td></td>
							                                </tr>
	          												<?php } ?>
	          												<!-- NCR ID -->
	          												<tr>
	          													<td><b>NCR ID</b></td>
	          													<td><?php echo $v['ncr_id']; ?></td>
	          												</tr>
	          												<!-- NCR Date -->
	          												<tr>
	          													<td><b>NCR Date</b></td>
	          													<td><?php echo $v['ncr_date']; ?></td>
	          												</tr>
	          												<!-- Raised By -->
	          												<tr>
	          													<td><b>Raised By</b></td>
	          													<td><?php echo (!empty($v['raised_by'])) ? $v['raised_by'] : $v['Inspected_by']; ?></td>
	          												</tr>
	          												<!-- Designation -->
	          												<tr>
	          													<td><b>Designation</b></td>
	          													<td><?php echo $v['designation']; ?></td>
	          												</tr>
	          												<!-- Distribution Centre -->
	          												<tr>
	          													<td><b>Distribution Centre</b></td>
	          													<td><?php echo $v['distribution_centre']; ?></td>
	          												</tr>
	          												<!-- Activity -->
	          												<tr>
	          													<td><b>Activity</b></td>
	          													<td><?php echo $v['activity']; ?></td>
	          												</tr>
	          												<!-- Observation Type -->
	          												<tr>
	          													<td><b>Observation Type</b></td>
	          													<td><?php echo $v['observation_type']; ?></td>
	          												</tr>
	          												<!-- Other Observation Type -->
	          												<?php if ($v['observation_type'] == 'Others') { ?>
	          												<tr>
	          													<td><b>Other Observation Type</b></td>
	          													<td><?php echo $v['other_observation_name']; ?></td>
	          												</tr>	
	          												<?php } ?>
	          												<!-- Observation -->
	          												<tr>
	          													<td><b>Observation</b></td>
	          													<td><?php echo $v['observation_remark']; ?></td>
	          												</tr>
	          												<!-- Observation Photos -->
	          												<tr>
	          													<td><b>Observation Photos</b></td>
	          													<td>
	          														<?php $obs_photos = explode(',', $v['observation_photos']); ?>
	          														<?php foreach ($obs_photos as $obs_value) { ?>
	          														<img src="<?php echo $obs_value; ?>" width="150"/>
	          														<?php } ?>
	          													</td>
	          												</tr>
	          												<!-- Observation Photos By TKC -->
	          												<tr>
	          													<td><b>Observation Photos By TKC</b></td>
	          													<td>
	          														<?php $obs_photos_by_tkc = explode(',', $v['tkc_observation_photos']); ?>
	          														<?php foreach ($obs_photos_by_tkc as $obs_value) { ?>
	          														<img src="<?php echo $obs_value; ?>" width="150"/>
	          														<?php } ?>
	          													</td>
	          												</tr>
	          												<!-- Compliance Remark -->
	          												<tr>
	          													<td><b>Compliance Remark</b></td>
	          													<td><?php echo $v['observation']; ?></td>
	          												</tr>
	          												<!-- Compliance Photos -->
	          												<tr>
	          													<td><b>Compliance Photos</b></td>
	          													<td>
	          														<?php if (!empty($v['completion_photos'])) {
	          																$obs_completion_photo = explode(',', $v['completion_photos']);
	          																foreach ($obs_completion_photo as $obs_value) {
	          														?>
	          														<img src="<?php echo $obs_value; ?>" width="150"/>
	          														<?php 		  } 
	          															   }
	          														?>
	          													</td>
	          												</tr>
	          												<!-- Compliance Date -->
	          												<tr>
	          													<td><b>Compliance Date</b></td>
	          													<td><?php echo (!empty($v['completion_date'])) ? date('d-m-Y', strtotime($v['completion_date'])) : ''; ?></td>
	          												</tr>
	          												<tr style="height:20px">
							                                	<td border='0'></td>
							                                	<td></td>
							                              	</tr>
	          												<?php } ?>
	          												<tr style="height:80px">
							                                	<td border='0'></td>
							                                	<td></td>
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
	          				<?php } ?>

	          			</div>
	          			<!-- CONTAINER Ends -->

	          		</div>
	          	</div>
	          	<!--app-content close-->
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

	   	<!-- DATA TABLE JS-->
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js'); ?>"></script>
	 		<!-- <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.php5.min.js'); ?>"></script> -->
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

	   	<!-- SWEET-ALERT JS -->
	   	<script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
	   	<script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

	   	<!-- MULTIPLE SELECT JS -->
      	<script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
      	<script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

      	<!-- DATERANGE PICKER JS -->
      	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

      	<script type="text/javascript">
      		$('input[name="complianceByTKCDate"]').daterangepicker({
	            autoUpdateInput: false,
	            locale: {
	                format: 'DD-MM-YYYY'
	            }
	        });

	        $('input[name="complianceByTKCDate"]').on('apply.daterangepicker', function(ev, picker) {
	            $(this).val(picker.startDate.format('DD-MM-YYYY') +' - '+ picker.endDate.format('DD-MM-YYYY'));
	         });

      		//Ajax Call to get Contractor Details
	        function showtkclist(tkcValue) {
	            $.ajax({
	               	type: 'POST',
	               	url: '<?php echo base_url('search-contractor') ?>',
	               	dataType: 'json',
	               	data: {contractor: tkcValue},
	               	success: function(response){
	                  	// console.log(response); return false;

	                  	$('#list-view').show();
	                  	$('#list-view').empty();

	                  	var html = '';

	                  	let contractor_data = response.contractor_data;
	                  	if ($.isEmptyObject(contractor_data)) {
	                     	html += 'No Contractor Found';
	                  	} else {
	                     	$.each(contractor_data, function(index, value){
	                        	html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start" data-typeofwork-id="'+value.typeofwork_id+'" data-contract-id="'+value.contract_id+'" onclick=applyContractorDetails(this)>';
	                        	html += '<div class="d-flex w-100 justify-content-between">';
	                        	html += '<h4 class="mb-1 contractor-name"><strong>'+value.contractor_name+'</strong></h4>';
	                        	html += '<small class="text-muted contract-date">Contract Date : <span class="text-primary"> '+value.tender_award_date+'</span></small>';
	                        	html += '</div>';
	                        	html += '<p class="mb-1 type-of-work">Type Of Work: <span class="text-primary"> '+value.typeofwork_name+'</span></p>';
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

	        $(document).click(function() {
	            var list_view = $('#list-view');
	            if (!list_view.is(event.target) && !list_view.has(event.target).length) {
	               list_view.hide();
	            }
	        });

	        //Applying selected contractor values
	     	function applyContractorDetails(anchor) {
	            $('#list-view').hide();

	            let contractor_name = $(anchor).find('.contractor-name').text();

	            $('input[name="contractor"]').val(contractor_name);
	        }
      	</script>

	</body>
</html>