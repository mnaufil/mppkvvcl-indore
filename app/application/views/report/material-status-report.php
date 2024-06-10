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
			                    <h1 class="page-title">Report Name: Material Status Report</h1>
			                </div>
			                <!-- PAGE-HEADER END -->

			                <!-- Row -->
			                <div class="row">
			                	<div class="col-lg-12">
			                		<div class="card">
			                			<div class="card-body">
			                				<div class="row mt-2 mb-2">
			                					<div class="col-xl-12">
			                						<label class="form-label">Report Description:</label>
                                    				<p class="report-desc">Material Status Report</p>
			                					</div>
			                				</div>
			                				<!-- Form -->
			                				<form id="generateMaterialStatusReport" name="generateMaterialStatusReport" method="post" action="<?php echo base_url('generate-material-status-report'); ?>">
			                					<div class="form-row">
			                						<!-- Package No -->
			                						<div class="col-xl-4 mb-3">
			                							<label for="packageNo" class="form-label">Lot No.<span class="text-red">*</span></label>
			                							<!-- <select class="form-control select2" id="packageNo" name="packageNo">
			                								<option value="select" selected disabled>Select Lot</option>
													      	<?php foreach($packages as $package) { ?>
													        <option value="<?php echo $package->package_no;?>" <?php if($packageNo==$package->package_no) { ?> selected <?php } ?>><?php echo $package->package_no;?></option>
															<?php } ?>
													    </select> -->
													    <select class="filter-multi" id="packageNo" name="packageNo[]" multiple="multiple">
													    	<?php foreach ($packages as $package) { ?>
													    	<option value="<?php echo $package->package_group_no;?>"><?php echo $package->package_group_no;?></option>
													    	<?php } ?>
													    </select>
			                						</div>
			                						<!-- Contract No -->
			                						<!-- <div class="col-xl-4 mb-3">
			                							<label for="contractNo" class="form-label">Contract No.<span class="text-red">*</span></label>
			                							<input class="form-control" type="text" id="contractNo" name="contractor" value="<?php echo @$contractor;?>">
			                						</div> -->
			                						<!-- Circle -->
			                						<div class="col-xl-4 mb-3">
			                							<label for="circle" class="form-label">Circle<span class="text-red">*</span></label>
			                							<!-- <select class="form-control select2" id="circle" name="circle">
			                								<option value="select" selected disabled>Select Circle</option>
			                								<?php foreach ($circles as $key => $value) { ?>
			                								<?php $selected = ($value->circle_id == $circle) ? 'selected' : ''; ?>
			                								<option value="<?php echo $value->circle_id; ?>" <?php echo $selected; ?>><?php echo $value->circle_name; ?></option>
			                								<?php } ?>
			                							</select> -->
			                							<select class="filter-multi" id="circle" name="circle[]" multiple="multiple">
			                								<?php foreach ($circles as $key => $value) { ?>
													    	<option value="<?php echo $value->circle_id;?>"><?php echo $value->circle_name;?></option>
													    	<?php } ?>
			                							</select>
			                						</div>
			                					</div>

			                					<button class="btn btn-success mb-3 mt-3"  type="submit">Generate</button>
												<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('material-status-report'); ?>">Clear</a>
												<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports'); ?>">Back</a>
			                				</form>
			                				<!-- Form Ends -->
			                			</div>
			                		</div>
			                	</div>
			                </div>
			                <!-- Row Ends -->

			                <?php if (isset($feeder_access) && $feeder_access) { ?>
			                <!-- Report Row -->
			                <?php if (is_array($reportData)) { ?>
			                <div class="row" id="report-table">
			                	<div class="col-lg-12">
			                		<div class="card">
			                			<?php if(!empty($reportData)) { ?>
			                			<div class="card-body">

			                				<?php if ($download_access) { ?>
			                				<div class="row">
			                					<!-- Export Button -->
			                					<div class="col-sm-12 col-md-9s mt-3">
				                                    <div class="dts-buttons btn-group flex-wrap" style="float:right;">
				                                      <a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" ><span>Export</span></a>			
				                                    </div>
				                                </div>	
			                				</div>
			                				<?php } ?>
			                				
			                				<div class="row">
			                					<div class="table-responsive mb-3 mt-3">
			                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
			                							<thead>
			                								<tr>
			                									<th>DI No.</th>
			                									<th>DI Date</th>
			                									<th>Circle</th>
			                									<th>Material</th>
			                									<th>Unit</th>
			                									<th>Unit Price</th>
			                									<th>Offer Quantity</th>
			                									<th>Accepted Quantity</th>
			                									<th>Accepted Date</th>
			                									<th>Rejected Quantity</th>
			                								</tr>
			                							</thead>
			                							<tbody>
			                								<?php foreach($reportData as $report) { ?>
			                								<tr>
			                									
			                									<td><?php echo $report->di_no;?></td>
			                									<td><?php echo $report->di_date;?></td>
			                									<td><?php echo $report->circle;?></td>
			                									<td><?php echo $report->material;?></td>
			                									<td><?php echo $report->unit;?></td>
			                									<td><?php echo $report->unit_price; ?></td>
			                									<td><?php echo $report->received_quantity;?></td>
			                									<td><?php echo $report->accepted_quantity;?></td>
			                									<td><?php echo $report->accepted_date;?></td>
			                									<td><?php echo $report->rejected_quantity;?></td>
			                								</tr>
			                								<?php } ?>
			                							</tbody>
			                						</table>
			                					</div>
			                				</div>
			                			</div>
			                		</div>
			                		<?php } ?>
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
			                
			                <!-- Report Row Ends -->	
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

	   	<!-- MULTIPLE SELECT JS -->
      	<script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
	  	<script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

	   	<script type="text/javascript">
	   	function showReport() {
	   		$('#report-table').removeAttr('hidden');
	   	}

	   	//Displays contractor search list view
        function showtkc(tkcValue) {
            // alert(tkcValue);
            $('#list-view').show();
            if (tkcValue !== '') {
                var html = '';
                $('#list-view').empty();

                for (var i = 0; i < 3; i++) {
                    html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start ">';
                    html += '<div class="d-flex w-100 justify-content-between">';
                    html += '<h4 class="mb-1"><strong>M/s Shreem Capcitor</strong></h4>';
                    html += '<p>Package - 1 </p>';
                    html += '</div>';
                    html += '<p class="mb-1">Type Of Work: <span class="text-primary"> Capacitor Bank</span></p>';
                    html += '<small class="text-muted">Award No: <span class="text-primary">483</span></small><br>';
                    html += '<small class="text-muted">Award Date : <span class="text-primary"> 25-09-2023</span></small>';
                    html += '</a>';
                }

                $('#list-view').append(html);
            } else {
                $('#list-view').empty();
            }

            /*if(tkcValue!=='')
            {
                $("#tkclist").show();
            }
            else
            {
                $("#tkclist").hide();
            }*/
        }

        $(document).click(function() {
            // alert('click');
            var list_view = $('#list-view');
            if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                list_view.hide();
            }
        });

        $('#generateMaterialStatusReport').submit(function(event) {
        	let package_no = $('#packageNo option:selected').val();

        	// let contract_no = $('#contractNo').val();
        	let circle = $('#circle option:selected').val();

        	if (package_no == 'select' && circle == 'select') {
        		$('.toast-body').text('Select Filters to generate the report');
           		$('.toast').toast('show');

           		event.preventDefault();
        	} else if (package_no == 'select') {
        		$('.toast-body').text('Select Package No');
           		$('.toast').toast('show');

           		event.preventDefault();
        	} /*else if (contract_no == '') {
        		$('.toast-body').text('Enter Contract No');
           		$('.toast').toast('show');

           		event.preventDefault();
        	}*/ else if (circle == 'select') {
           		$('.toast-body').text('Select Circle');
           		$('.toast').toast('show');

           		event.preventDefault();
        	}
        });
	   </script>

	</body>
</html>