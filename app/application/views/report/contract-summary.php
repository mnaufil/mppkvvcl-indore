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
			                    <h1 class="page-title">Report Name: Contract Summary</h1>
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
                                    				<p class="report-desc">View the list of all the contracts awarded till date by RDSS, Jabalpur.</p>
			                					</div>
			                				</div>
			                				<!-- Form -->
			                				<form class="needs-validation2" novalidate method="post" action="<?php echo base_url('generate-contract-summary-report'); ?>">
			                					<div class="form-row">
			                						<div class="col-xl-4 mb-3">
			                							<label for="outputOption" class="form-label">Output Option
				                                          	<span class="text-red">*</span>
				                                       	</label>
				                                       	<div class="form-group">
				                                       		<div class="custom-controls">
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="outputOption" value="1" checked>
				                                       				<span class="custom-control-label">Package Wise</span>
				                                       			</label>
				                                       			<label class="custom-control custom-radio status-radio">
				                                       				<input type="radio" class="custom-control-input" name="outputOption" value="2">
				                                       				<span class="custom-control-label">Type of Work Wise</span>
				                                       			</label>	
				                                       		</div>
				                                       	</div>

				                                       	<button class="btn btn-success mb-3 mt-3"  type="submit">Generate</button>
														<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('contract-summary-report'); ?>">Clear</a>
                                    <a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports'); ?>">Back</a>

			                						</div>
			                					</div>
			                				</form>
			                				<!-- Form Ends -->

			                			</div>
			                		</div>
			                	</div>
			                </div>
			                <!-- Row Ends -->

			                <!-- Report Row -->
			                <div class="row" id="report-table">
			                	<div class="col-lg-12">
			                		<div class="card">
									 	<?php if(!empty($reportData)) { ?>
									 	<div class="card-body">
		                				<div class="row">
		                					<!-- Export Button -->
		                					<div class="col-sm-12 col-md-9s mt-3">
			                                    <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                      				<a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" ><span>Export</span></a>
			                                    </div>
			                                </div>	
		                				</div>
		                				<div class="row">
										
										 	<?php if($outputOption==1) { ?>
		                					<div class="table-responsive mb-3 mt-3" id="package-table">
		                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
		                							<thead>
		                								<tr>
		                									<th>Package No</th>
		                									<th>Type of Work</th>
		                									<th>TKC</th>
		                									<th>Award No</th>
		                									<th>Award Date</th>
		                									<th>Supply of Goods (Ex-W Price)</th>
		                									<th>Installation and Other Services</th>
		                									<th>Contract Value (Without GST)</th>
		                									<th>GST Value</th>
		                									<th>Contract Value (With GST)</th>
		                									<th>Total Mobilisation Advance Given</th>
		                									<th>Total Mobilisation Advance Adjusted</th>
		                									<th colspan="3">Stage 1</th>
		                									<th colspan="3">Stage 2</th>
		                									<th colspan="3">Stage 3</th>
		                									<th colspan="3">Stage 4</th>
		                								</tr>
		                								<tr>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                								</tr>
		                							</thead>
		                							<tbody>
													<?php if(!empty($reportData)) { ?>
													<?php foreach($reportData as $report) { ?>
		                								<tr>
		                									<td><?php echo $report->package_no;?></td>
		                									<td><?php echo $report->typeofwork;?></td>
		                									<td><?php echo $report->package_no;?></td>
		                									<td><?php echo $report->tkc_award_no;?></td>
		                									<td><?php echo $report->award_date;?></td>
		                									<td class="table-td-center"><?php echo number_format($report->supplyofgoods_ex_w_price);?></td>
		                									<td class="table-td-center"><?php echo number_format($report->installation_and_other_services);?></td>
		                									<td class="table-td-center"><?php echo number_format($report->contract_value_without_gst);?></td>
		                									<td class="table-td-center"><?php echo number_format($report->gst_value);?></td>
		                									<td class="table-td-center"><?php echo number_format($report->contract_value_with_gst);?></td>
		                									<td class="table-td-center"><?php echo number_format($report->total_mobilisation_advanced_given);?></td>
		                									<td><?php echo number_format($report->total_mobilisation_advanced_adjusted);?></td>
		                									<td><?php echo $report->stage1_target;?></td>
		                									<td><?php echo $report->stage1_achieve;?></td>
		                									<td><?php echo $report->stage1_shortfall;?></td>
		                									<td><?php echo $report->stage2_target;?></td>
		                									<td><?php echo $report->stage2_achieve;?></td>
		                									<td><?php echo $report->stage2_shortfall;?></td>
		                									<td><?php echo $report->stage3_target;?></td>
		                									<td><?php echo $report->stage3_achieve;?></td>
		                									<td><?php echo $report->stage3_shortfall;?></td>
		                									<td><?php echo $report->stage4_target;?></td>
		                									<td><?php echo $report->stage4_achieve;?></td>
		                									<td><?php echo $report->stage4_shortfall;?></td>
		                								</tr>
		                							<?php } ?>	
													<?php } ?>
		                							</tbody>
		                						</table>
		                					</div>
											<?php } ?>
											<?php if($outputOption==2) { ?>
		                					<div class="table-responsive mb-3 mt-3" id="work-table">
		                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
		                							<thead>
		                								<tr>
		                									<th>Type of Work</th>
		                									<th>Package No</th>
		                									<th>TKC</th>
		                									<th>Award No</th>
		                									<th>Award Date</th>
		                									<th>Supply of Goods (Ex-W Price)</th>
		                									<th>Installation and Other Services</th>
		                									<th>Contract Value (Without GST)</th>
		                									<th>GST Value</th>
		                									<th>Contract Value (With GST)</th>
		                									<th>Total Mobilisation Advance Given</th>
		                									<th>Total Mobilisation Advance Adjusted</th>
		                									<th colspan="3">Stage 1</th>
		                									<th colspan="3">Stage 2</th>
		                									<th colspan="3">Stage 3</th>
		                									<th colspan="3">Stage 4</th>
		                								</tr>
		                								<tr>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th></th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                									<th>Target</th>
		                									<th>Achieve</th>
		                									<th>Shortfall</th>
		                								</tr>
		                							</thead>
		                							<tbody>
													<?php if(!empty($reportData)) { ?>
													<?php foreach($reportData as $report) { ?>
		                								<tr>
		                									<td><?php echo $report->package_no;?></td>
		                									<td><?php echo $report->typeofwork;?></td>
		                									<td><?php echo $report->package_no;?></td>
		                									<td><?php echo $report->tkc_award_no;?></td>
		                									<td><?php echo $report->award_date;?></td>
		                									<td><?php echo $report->supplyofgoods_ex_w_price;?></td>
		                									<td><?php echo $report->installation_and_other_services;?></td>
		                									<td><?php echo $report->contract_value_without_gst;?></td>
		                									<td><?php echo $report->gst_value;?></td>
		                									<td><?php echo $report->contract_value_with_gst;?></td>
		                									<td><?php echo $report->total_mobilisation_advanced_given;?></td>
		                									<td><?php echo $report->total_mobilisation_advanced_adjusted;?></td>
		                									<td><?php echo $report->stage1_target;?></td>
		                									<td><?php echo $report->stage1_achieve;?></td>
		                									<td><?php echo $report->stage1_shortfall;?></td>
		                									<td><?php echo $report->stage2_target;?></td>
		                									<td><?php echo $report->stage2_achieve;?></td>
		                									<td><?php echo $report->stage2_shortfall;?></td>
		                									<td><?php echo $report->stage3_target;?></td>
		                									<td><?php echo $report->stage3_achieve;?></td>
		                									<td><?php echo $report->stage3_shortfall;?></td>
		                									<td><?php echo $report->stage4_target;?></td>
		                									<td><?php echo $report->stage4_achieve;?></td>
		                									<td><?php echo $report->stage4_shortfall;?></td>
		                								</tr>
		                							<?php } ?>	
													<?php } ?>
		                							</tbody>
		                						</table>
		                					</div>
											<?php } ?>
		                				</div>
		                				</div>
										<?php } ?>
			                		</div>
			                	</div>
			                </div>
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

	   <script type="text/javascript">
	   	function showReport() {
	   		let option = $('input[name="outputOption"]:checked').val();

	   		$('#report-table').removeAttr('hidden');

	   		if (option == 'package') {
	   			$('#package-table').removeAttr('hidden');
	   			var attr = $('#work-table').attr('hidden');

	   			if (typeof attr == 'undefined') {
	   				$('#work-table').attr('hidden', true);
	   			}
	   		} else if (option == 'typeofwork') {
	   			$('#work-table').removeAttr('hidden');
	   			var attr = $('#package-table').attr('hidden');

	   			if (typeof attr == 'undefined') {
	   				$('#package-table').attr('hidden', true);	
	   			}
	   		}
	   	}
	   </script>

	</body>
</html>