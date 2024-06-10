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
	   	<title>MPPKVVCL - <?php echo $title; ?></title>

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

          		<!-- App-Content -->
          		<div class="main-content app-content mt-0">
          			<div class="side-app">
          			
	          			<!-- Container -->
	          			<div class="main-container container-fluid">
          				
	          				<!-- Page Header -->
	          				<div class="page-header">
	                  			<h1 class="page-title">Report Name: <?php echo $title; ?></h1>
	                		</div>
	          				<!-- Page Header Ends -->

	          				<!-- Row -->
	          				<div class="row">
          						<div class="col-lg-12">
          							<div class="card">
          								<div class="card-body">
          								
	          								<!-- Report Description -->
	          								<div class="form-row mt-2 mb-2">
	          									<div class="col-xl-4">
	          										<label class="form-label">Report Description:</label>
	          										<p class="report-desc">Material Inward Sampling Report</p>
	          									</div>
	          								</div>

	          								<!-- Form -->
	          								<form id="generateMaterialInwardSampling" name="generateMaterialInwardSampling" method="POST" action="<?php echo base_url('generate-material-inward-sampling-report'); ?>">
	          									<!-- Row1 -->
	          									<div class="form-row">
	          										<!-- Lot No -->
	          										<div class="col-xl-4 mb-3">
	          											<label for="packageNo" class="form-label">Lot No.<span class="text-red">*</span></label>
	          											<!-- <select class="form-control select2" id="packageNo" name="packageNo">
	          												<option value="select" selected disabled>Select Lot No.</option>
	          												<?php //foreach ($package_nos as $key => $value) { ?>
	          												<?php //$package_select = ($package_no == $value->package_group_no) ? 'selected' : ''; ?>
	          												<option value="<?php //echo $value->package_group_no; ?>" <?php //echo $package_select; ?>><?php //echo $value->package_group_no; ?></option>
	          												<?php //} ?>
	          											</select> -->
	          											<select class="filter-multi" id="packageNo" name="packageNo[]" multiple="multiple">
	          												<?php foreach ($package_nos as $key => $value) { ?>
	          												<?php $package_select = (in_array($value->package_group_no, $package_no)) ? 'selected' : ''; ?>	
	          												<option value="<?php echo $value->package_group_no; ?>" <?php echo $package_select; ?>><?php echo $value->package_group_no; ?></option>
	          												<?php } ?>
	          											</select>
	          										</div>
          											<!-- Circle -->
	          										<div class="col-xl-4 mb-3">
	          											<label class="form-label" for="circle">Circle<span class="text-red">*</span></label>
	          											<!-- <select class="form-control select2" id="circle" name="circle">
	          												<option value="select" selected disabled>Select Circle</option>
	          												<?php //foreach ($circles as $key => $value) { ?>
	          												<?php //$circle_select = ($circle == $value['circle_id']) ? 'selected' : ''; ?>
	          												<option value="<?php //echo $value['circle_id']; ?>" <?php //echo $circle_select; ?>><?php //echo $value['circle_name']; ?></option>	
	          												<?php //} ?>
	          											</select> -->
	          											<select class="filter-multi" id="circle" name="circle[]" multiple="multiple">
	          												<?php foreach ($circles as $key => $value) { ?>
	          												<?php $circle_select = (in_array($value['circle_id'], $circle)) ? 'selected' : ''; ?>
	          												<option value="<?php echo $value['circle_id']; ?>" <?php echo $circle_select; ?>><?php echo $value['circle_name']; ?></option>	
	          												<?php } ?>
	          											</select>
	          										</div>
          											<!-- Status -->
	          										<div class="col-xl-4 mb-3">
	          											<label class="form-label" for="status">Status<span class="text-red">*</span></label>
	          											<select class="form-control select2" id="status" name="status">
	          												<option value="" selected disabled>Select Status</option>
	          												<?php foreach ($status_list as $key => $value) { ?>
	          												<?php $status_select = ($status == $value['status_id']) ? 'selected' : ''; ?>
	          												<option value="<?php echo $value['status_id']; ?>" <?php echo $status_select; ?>><?php echo $value['name']; ?></option>	
	          												<?php } ?>
	          											</select>
	          										</div>
      											</div>
          										<!-- Row2 -->
          										<div class="form-row">
          											<!-- Material Received Daterange -->
	          										<div class="col-xl-4 mb-3">
	          											<label class="form-label" for="matrerialReceivedDate">Material Received Date<span class="text-red">*</span></label>
	          											<div class="input-group">
	          												<div class="input-group-text" id="material-received-date">
	          													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	          												</div>
	          												<?php $date_value = (isset($material_received_date)) ? $material_received_date : ''; ?>
	          												<input class="form-control" type="text" id="matrerialReceivedDate" name="matrerialReceivedDate" value="<?php echo $date_value; ?>">
	          											</div>
	          										</div>
          										</div>

	          									<!-- Buttons -->
	          									<button class="btn btn-success mb-3 mt-3" type="submit">Generate </button>
	          									<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('material-inward-sampling-report')?>">Clear</a>
	          									<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports')?>">Back</a>
          									</form>
          									<!-- Form Ends -->

          								</div>
          							</div>
          						</div>
          					</div>
          					<!-- Row Ends -->

	          				<!-- Response Row -->
	          				<?php if (isset($feeder_access) && $feeder_access) { ?>
	          					<?php if (is_array($report_data)) { ?>
	          					<div class="row" id="report-table">
	          						<div class="col-lg-12">
	          							<div class="card">
	          								<div class="card-body">
	          									
	          									<?php if ($download_access) { ?>
	          										<div class="row">
	          											<!-- Export Button -->
		          										<div class="col-sm-12 col-md-9s mt-3 mb-3">
		          											<div class="dts-buttons btn-group flex-wrap" style="float:right;">
		          												<a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" type="button"><span>Export</span></a>
										                        &nbsp;
										                        <!-- <a target="_blank" href="<?php //echo base_url('convert-pdf');?>" class="btn btn-success" type="button"><span>View in Pdf</span></a> -->
		          											</div>
		          										</div>
	          										</div>
	          									<?php } ?>

	          									<div class="row mb-3">
	          										<div class="col-xl-12" style="overflow: auto;width: 500px;">
	          											<div class="table-responsive">
	          												<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
	          													<thead>
	          														<tr>
	          															<th scope="col">Lot No</th>
	          															<th scope="col">Circle</th>
	          															<th scope="col">Material Description</th>
	          															<th scope="col">Unit</th>
	          															<th scope="col">Name of Vendor</th>
	          															<th scope="col">DI No</th>
	          															<th scope="col">DI Date</th>
	          															<th scope="col">DI Quantity</th>
	          															<th scope="col">Received Quantity</th>
	          															<th scope="col">Received Date</th>
	          															<th scope="col">Sampling Quantity</th>
	          															<th scope="col">Sampling Seal Date</th>
	          														</tr>
	          													</thead>
	          													<tbody>
	          														<?php foreach ($report_data as $key => $value) { ?>
	          														<tr>
	          															<td><?php echo $value['lot_no']; ?></td>
	          															<td><?php echo $value['circle']; ?></td>
	          															<td><?php echo $value['material_description']; ?></td>
	          															<td><?php echo $value['unit']; ?></td>
	          															<td><?php echo $value['name_of_vendor']; ?></td>
	          															<td><?php echo $value['di_no']; ?></td>
	          															<td><?php echo $value['di_date']; ?></td>
	          															<td><?php echo $value['di_quantity']; ?></td>
	          															<td><?php echo $value['received_quantity']; ?></td>
	          															<td><?php echo $value['received_date']; ?></td>
	          															<td><?php echo $value['sampling_quantity']; ?></td>
	          															<td><?php echo $value['sampling_seal_date']; ?></td>
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
	          					</div>
	          					<?php } else { ?>
	          					<div class="row">
					                  	<div class="col-lg-12">
					                    	<div class="card">
					                    		<div class="card-body">
					                      			<div class="row">
					                        			<h4 class="pt-3"><strong><?php echo $report_data; ?></strong></h4>
					                        		</div>
					                      		</div>
					                    	</div>
					                  	</div>
					               	</div>
	          					<?php } ?>
	          				<?php } elseif (isset($feeder_access) && !$feeder_access) { ?>
	          					<div class="row">
			                    	<div class="col-lg-12">
			                       		<div class="card">
			                          		<div class="card-body bg-danger text-white pt-2 rounded-2">
			                             		<div class="row">
			                                		<h3 class="pt-3"><strong>Authorization failed.</strong></h3>
			                                		<p>You don't have access to this record. Ask your administrator for help or request for access.</p>
			                             		</div>
			                          		</div>
			                       		</div>
			                    	</div>
			                 	</div>
	          				<?php } ?>
	          				<!-- Response Row Ends -->

	          			</div>
	          			<!-- Container Ends -->
          			</div>
	          	</div>
	          	<!-- App-Content Ends -->

	   		</div>

		   	<!-- App-Footer -->
	        <?php $this->load->view('include/footer');?>
	        <!-- App-Footer Ends -->

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
	   		$('input[name="matrerialReceivedDate"]').daterangepicker({
	   			autoUpdateInput: false,
	            locale: {
	                format: 'DD-MM-YYYY'
	            }
	   		});

	   		$('input[name="matrerialReceivedDate"]').on('apply.daterangepicker', function(ev, picker) {
            	$(this).val(picker.startDate.format('DD-MM-YYYY') +' - '+ picker.endDate.format('DD-MM-YYYY'));
        	});

        	$('#generateMaterialInwardSampling').submit(function(event) {
        		let package_no = $('select[name="packageNo[]"]').val();
        		// console.log(package_no); return false;

        		let circle = $('select[name="circle[]"]').val();

        		let status = $('select[name="status"]').val();

        		let material_received_date = $('input[name="matrerialReceivedDate"]').val();

        		if (package_no == null && circle == null && status == null && material_received_date == '') {
        			$('.toast-body').text('Select filters to generate the report');
		           	$('.toast').toast('show');

		           	event.preventDefault();
        		} else if (package_no == null) {
        			$('.toast-body').text('Select Lot No');
		           	$('.toast').toast('show');

		           	event.preventDefault();
        		} else if (circle == null) {
        			$('.toast-body').text('Select Circle');
		           	$('.toast').toast('show');

		           	event.preventDefault();
        		} else if (status == null) {
        			$('.toast-body').text('Select Status');
		           	$('.toast').toast('show');

		           	event.preventDefault();
        		} else if (material_received_date == '') {
        			$('.toast-body').text('Select Material Received Date Range');
		           	$('.toast').toast('show');

		           	event.preventDefault();
        		}
        	});
	   	</script>
	</body>
</html>