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
		        <<?php $this->load->view('include/header');?>
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
			                    <h1 class="page-title">Report Name: Cash Flow</h1>
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
                                    				<p class="report-desc">View the cash flow by RDSS, Indore for the month.</p>
			                					</div>
			                				</div>
			                				<!-- Form -->
			                				<form id="generateCashFlowReport" name="generateCashFlowReport" method="post" action="<?php echo base_url('generate-cash-flow-report'); ?>">
			                					<div class="form-row">
			                						<!-- Package No -->
			                						<div class="col-xl-3 mb-3">
			                							<label for="packageNo" class="form-label">Lot No.
				                                          	<!-- <span class="text-red">*</span> -->
				                                       	</label>
				                                       	<!-- <select class="form-control select2" id="packageNo" name="packageNo">
				                                          	<option value="select" selected disabled>Select Lot No.</option>
				                                          	<?php //foreach($packages as $package) { ?>
				                                          	<option value="<?php //echo $package->package_no;?>" <?php //if($packageNo==$package->package_no) { ?> selected <?php //} ?>><?php //echo $package->package_no;?></option>
															<?php //} ?>
				                                        </select> -->
				                                        <select class="filter-multi" id="packageNo" name="packageNo[]" multiple="multiple">
				                                        	<?php foreach($packages as $package) { ?>
				                                          	<option value="<?php echo $package->package_no;?>" <?php if(in_array($package->package_no, $packageNo)) { ?> selected <?php } ?>><?php echo $package->package_no;?></option>
															<?php } ?>
				                                        </select>
			                						</div>
			                						<!-- Contractor (TKC) -->
			                						<div class="col-xl-4 mb-3">
			                							<label for="contractor" class="form-label">Contractor (TKC)<!-- <span class="text-red">*</span> --></label>
				                                       	<input class="form-control" type="text" name="contractor" id="contractor" onkeyup="showtkclist(this.value)" value="<?php echo @$contractor;?>">
                                                        <div class="list-group list-view-contractor" id="list-view"></div>
			                						</div>
			                					</div>

			                					<button class="btn btn-success mb-3 mt-3"  type="submit">Generate</button>
												<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('cash-flow-report'); ?>">Clear</a>
                                 				<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports'); ?>">Back</a>
			                				</form>
			                				<!-- Form Ends -->
			                			</div>
			                		</div>
			                	</div>
			                </div>
			                <!-- Row Ends -->

			                <!-- Report Row -->
			                <?php if (isset($feeder_access) && $feeder_access) { ?>
			                <div class="row" id="report-table">
			                	<div class="col-lg-12">
			                		<div class="card">
			                			<?php if(!empty($reportData)) { ?>
			                			<div class="card-body">
			                				<?php if (is_array($reportData)) { ?>
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
			                					<div class="table-responsive mb-3 mt-3" style="max-height: 500px;overflow: auto;">
			                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
			                							<thead>
			                								<tr>
			                									<th>Package No.</th>
			                									<th>TKC</th>
			                									<th>Contract No.</th>
			                									<th>Contract Date</th>
			                									<th>Invoice No</th>
			                									<th>Invoice Date</th>
			                									<th>Gross Amount (with GST)</th>
			                									<th colspan="3">Progressive Payment Mode (with GST)</th>
			                									<th>Total</th>
			                								</tr>
			                								<tr>
			                									<th></th>
			                									<th></th>
			                									<th></th>
			                									<th></th>
			                									<th></th>
			                									<th></th>
			                									<th></th>
			                									<th>Mobilisation</th>
			                									<th>Supply</th>
			                									<th>Erection</th>
			                									<th></th>
			                								</tr>
			                							</thead>
			                							<tbody>
			                								<?php foreach($reportData as $report) { ?>
			                								<tr>
			                									<td><?php echo $report->PACKAGE_NO;?></td>
			                									<td><?php echo $report->TKC;?></td>
			                									<td style="text-align:center;"><?php echo $report->AWARD_NO;?></td>
			                									<td style="text-align:right;"><?php echo date('d-m-Y', strtotime($report->AWARD_DATE));?></td>
			                									<td><?php echo $report->INVOICE_NO;?></td>
			                									<td style="text-align:right;"><?php echo date('d-m-Y', strtotime($report->INVOICE_DATE));?></td>
			                									<td style="text-align:right;"><?php echo '&#8377;'.number_format($report->GROSS_AMOUNT_WITH_GST, 2);?></td>
			                									<td style="text-align:right;"><?php echo '&#8377;'.number_format($report->MOBILISATION, 2);?></td>
			                									<td style="text-align:right;"><?php echo '&#8377;'.number_format($report->SUPPLY, 2);?></td>
			                									<td style="text-align:right;"><?php echo '&#8377;'.number_format($report->ERECTION, 2);?></td>
			                									<td style="text-align:right;"><?php echo '&#8377;'.number_format($report->TOTAL, 2);?></td>
			                								
			                								</tr>
			                								<?php } ?>	
			                							</tbody>
			                						</table>
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
			                			</div>
			                			<?php } ?>
			                		</div>
			                	</div>
			                </div>	
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

	   <!-- MULTIPLE SELECT JS -->
      <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

	   <script type="text/javascript">
	   	function showReport() {
	   		$('#report-table').removeAttr('hidden');
	   	}

	   	//Ajax Call to get Contractor Details
        function showtkclist(tkcValue) {
            $.ajax({
               	type: 'POST',
               	url: '<?php echo base_url('search-contractor') ?>',
               	dataType: 'json',
               	data: {contractor: tkcValue},
               	success: function(response){
                  	// console.log(response);

                  	$('#list-view').show();
                  	$('#list-view').empty();

                  	var html = '';

                  	let contractor_data = response.contractor_data;
                  	/*console.log("contractor_data: ");
                  	console.log(contractor_data);*/
                  	if ($.isEmptyObject(contractor_data)) {
                     	html += 'No Contractor Found';
                  	} else {
                     	$.each(contractor_data, function(index, value){
                        	// console.log(value);
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

        $('#generateCashFlowReport').submit(function(event) {
        	let package_no = $('#packageNo option:selected').val();
        	let contractor = $('#contractor').val();

        	if (package_no == 'select' && contractor == '') {
        		$('.toast-body').text('Select Package No or Enter Contractor (TKC)');
           		$('.toast').toast('show');

           		event.preventDefault();
        	}
        });
	   </script>

	</body>
</html>