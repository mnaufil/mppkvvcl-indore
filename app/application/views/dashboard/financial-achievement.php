<!DOCTYPE html>
<html lang="en" dir="ltr">
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
	            				<h1 class="page-title">Lot Wise Cash Flow- RDSS Project, MPPKVVCL Indore Status</h1>
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
	            							<div class="row">
	            								<!-- Export Button -->
	            								<div class="col-sm-12 col-md-9s mb-3">
	            									<div class="dts-buttons btn-group flex-wrap" style="float:right;">
	            										<a href="<?php echo base_url('export-financial-dashbaord/'.$date) ?>" class="btn btn-success p-2" type="button" id="export-btn">Export</a>	
	            									</div>
	            								</div>
	            							</div>
	            							<div class="table-responsive">
	            								<table class="table border text-wrap text-md-nowrap table-bordered mb-0" id="financial-table">
	            									<thead>
	            										<tr>
	            											<!-- <th></th> -->
	            											<th>Sr No.</th>
	            											<th>Lot No.</th>
	            											<th>Name of TKC</th>
	            											<th>Type of Work</th>
	            											<th>Contract Price (Rs. In cr.)</th>
	            											<th>Effective Date</th>
	            											<th colspan="3">Stage Data</th>
	            											<th colspan="12">Disbursement Amount(Rs. in Cr.) upto <?php echo $current_date; ?></th>
	            											<th>Acheivement (%)</th>
	            										</tr>
	            										<tr>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th>Stage</th>
	            											<th>Target Date</th>
	            											<th>Target (Rs. In cr.)</th>
	            											<th colspan="2">Supply during the Month <?php echo $current_month; ?></th>
	            											<th colspan="2">Supply Cumm. upto the period</th>
	            											<th colspan="2">Erection during the Month <?php echo $current_month; ?></th>
	            											<th colspan="2">Erection Cumm. upto the period</th>
	            											<th>Mobilization Advance </br>(C)</th>
	            											<th>Mobilization Advance Adjusted</th>
	            											<th>Payment of Taxes </br>(D)</th>
	            											<th>Total Disbursement Amount </br>(A + B + C + D)</th>
	            											<th></th>
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
	            											<th>Invoice Raised</th>
	            											<th>Amount Disbursed</th>
	            											<th>Invoice Raised</th>
	            											<th>Amount Disbursed (A)</th>
	            											<th>Invoice Raised</th>
	            											<th>Amount Disbursed</th>
	            											<th>Invoice Raised</th>
	            											<th>Amount Disbursed (B)</th>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            											<th></th>
	            										</tr>
	            									</thead>
	            									<tbody>
	            										<?php foreach ($contract_data as $key => $value) { ?>
	            											<tr>
	            												<!-- SR No -->
	            												<td><?php echo ++$key; ?></td>
	            												<!-- <td style="text-align: left;"><?php //echo 'Lot - '.$value['package_no']; ?></td> -->
	            												<!-- Lot No -->
	            												<td style="text-align: left;"><?php echo $value['package_no']; ?></td>
	            												<!-- Name of TKC -->
	            												<td style="text-align: left;"><?php echo $value['contractor_name']; ?></td>
	            												<!-- Type of Work -->
	            												<td style="text-align: left;"><?php echo $value['type_of_work']; ?></td>
	            												<!-- Contract Price -->
	            												<td style="text-align: center;"><?php echo '&#8377;'.$value['contract_price']; ?></td>
	            												<!-- Effective Date -->
	            												<td style="text-align: center;"><?php echo date('d-m-y', strtotime($value['effective_date'])); ?></td>
	            												<!-- Stage -->
	            												<td style="text-align: center;"><?php echo (!empty($value['stage_name'])) ? $value['stage_name'] : '-'; ?></td>
	            												<!-- Target Date -->
	            												<td style="text-align: center;"><?php echo (!empty($value['stage_date'])) ? date('d-m-Y', strtotime($value['stage_date'])) : '-'; ?></td>
	            												<!-- Target -->
	            												<td style="text-align: center;"><?php echo ($value['target'] == '-') ? $value['target'] : '&#8377;'.$value['target']; ?></td>
	            												<!-- Supply during the month (Invoice Raised) -->
	            												<td style="text-align: center;"><?php echo ($value['supply_invoice_raised'] == '-') ? $value['supply_invoice_raised'] : '&#8377;'.$value['supply_invoice_raised']; ?></td>
	            												<!-- Supply during the month (Amount Disbursed) -->
	            												<td style="text-align: center;"><?php echo ($value['supply_amount_disbursed'] == '-') ? $value['supply_amount_disbursed'] : '&#8377;'.$value['supply_amount_disbursed']; ?></td>
	            												<!-- Supply Cummulative upto the period (Invoice Raised) -->
	            												<td style="text-align: center;"><?php echo ($value['supply_cum_invoice_raised'] == '-') ? $value['supply_cum_invoice_raised'] : '&#8377;'.$value['supply_cum_invoice_raised']; ?></td>
	            												<!-- Supply Cummulative upto the period (Amount Disbursed) -->
	            												<td style="text-align: center;"><?php echo ($value['supply_cum_amount_disbursed'] == '-') ? $value['supply_cum_amount_disbursed'] : '&#8377;'.$value['supply_cum_amount_disbursed']; ?></td>
	            												<!-- Erection during the month (Invoice Raised) -->
	            												<td style="text-align: center;"><?php echo ($value['erection_invoice_raised'] == '-') ? $value['erection_invoice_raised'] : '&#8377;'.$value['erection_invoice_raised']; ?></td>
	            												<!-- Erection during the month (Amount Disbursed) -->
	            												<td style="text-align: center;"><?php echo ($value['erection_amount_disbursed'] == '-') ? $value['erection_amount_disbursed'] : '&#8377;'.$value['erection_amount_disbursed']; ?></td>
	            												<!-- Erection Cummulative upto the period (Invoice Raised) -->
	            												<td style="text-align: center;"><?php echo ($value['erection_cum_invoice_raised'] == '-') ? $value['erection_cum_invoice_raised'] : '&#8377;'.$value['erection_cum_invoice_raised']; ?></td>
	            												<!-- Erection Cummulative upto the period (Amount Disbursed) -->
	            												<td style="text-align: center;"><?php echo ($value['erection_cum_amount_disbursed'] == '-') ? $value['erection_cum_amount_disbursed'] : '&#8377;'.$value['erection_cum_amount_disbursed']; ?></td>
	            												<!-- Mobilisation Advance -->
	            												<td style="text-align: center;"><?php echo ($value['mobilisation_advance'] == '-') ? $value['mobilisation_advance'] : '&#8377;'.$value['mobilisation_advance']; ?></td>
	            												<!-- Mobilisation Advance Adjusted -->
	            												<td style="text-align: center;"><?php echo ($value['moblisation_adv_adjusted_amount'] == '-') ? $value['moblisation_adv_adjusted_amount'] : '&#8377;'.$value['moblisation_adv_adjusted_amount']; ?></td>
	            												<!-- Payment of Taxes -->
	            												<td style="text-align: center;"><?php echo ($value['payment_of_taxes'] == '-') ? $value['payment_of_taxes'] : '&#8377;'.$value['payment_of_taxes']; ?></td>
	            												<!-- Total Disbursement Amount -->
	            												<td style="text-align: center;"><?php echo ($value['total_disbursement_amount'] == '-') ? $value['total_disbursement_amount'] : '&#8377;'.$value['total_disbursement_amount']; ?></td>
	            												<!-- Achievement (%) -->
	            												<td style="text-align: center;"><?php echo $value['per_achievement']; ?></td>
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
	        	function changepp(date) {
	        		window.location.href = '<?php echo base_url(); ?>' + "financial/" + date;
	        	}
	        </script>
	</body>
</html>