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
	   	<title>MPPKVVCL - View Summary</title>

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
			                    <h1 class="page-title">Report Name: Material Status Summary</h1>
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
                                    				<p class="report-desc">Material Status Summary</p>
			                					</div>
			                				</div>
			                				<!-- Form -->
			                				<form class="needs-validation2" novalidate method="post" action="<?php echo base_url('generate-material-status-summary'); ?>">
			                					<div class="form-row">
			                						<!-- <div class="col-xl-4 mb-3">
			                							<label for="contractor" class="form-label">Contractor (TKC)
				                                          	<span class="text-red">*</span>
				                                       	</label>
				                                       	<input class="form-control" type="text" name="contractor" id="contractor"value="<?php echo @$contractor;?>">
                                                        <div class="list-group list-view-contractor" id="list-view"></div>
			                						</div> -->
			                						<!-- <div class="col-xl-4 mb-3">
			                							<label class="form-label" for="circle">Circle
				                							<span class="text-red">*</span>
				                						</label>
				                						<select class="form-control select2" id="circle" name="circle" required>
				                                          	<option value="select" selected disabled>Select Circle</option>
				                                          	<option value="jabalpur_city">Jabalpur City</option>
				                                          	<option value="jabalpur_om">Jabalpur O&M</option>
				                                          	<option value="katni">Katni</option>
				                                          	<option value="mandla">Mandla</option>
				                                          	<option value="narsinghpur">Narsinghpur</option>
				                                          	<option value="seoni">Seoni</option>
				                                          	<option value="balaghat">Balaghat</option>
				                                          	<option value="chhindwara">Chhindwara</option>
				                                        </select>	
			                						</div> -->
			                						<div class="col-xl-4 mb-3">
			                							<label for="packageNo" class="form-label">Package No.
				                                          	<span class="text-red">*</span>
				                                       	</label>
				                                       <select class="form-control select2" id="packageNo" name="packageNo" required>
				                                          	<?php foreach($packages as $package) { ?>
				                                          	<option value="<?php echo $package->package_no;?>" <?php if($packageNo==$package->package_no) { ?> selected <?php } ?>><?php echo $package->package_no;?></option>
															<?php } ?>
				                                        </select>
			                						</div>

			                						<div class="col-xl-4 mb-3">
			                							<label class="form-label" for="date">Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                                                        <div class="input-group-text dates">
	                                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                                                        </div>
	                                                        <input type="text" class="form-control" name="date" id="date" required value="<?php echo empty($_POST['date']) ? "" : $_POST['date'] ?>"/>
	                                                    </div>
			                						</div>


			                					</div>

			                						<button class="btn btn-success mb-3 mt-3"  type="submit">Generate</button>
														<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('material-status-summary'); ?>">Clear</a>
                                    <a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports'); ?>">Back</a>
			                				</form>
			                				<!-- Form Ends -->
			                			</div>
			                		</div>
			                	</div>
			                </div>
			                <!-- Row Ends -->

			                <!-- Report Row -->
			                <div class="row" id="report-table" >
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
			                					<div class="table-responsive mb-3 mt-3">
			                						<table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
			                							<thead>
			                								<tr>
			                									<th>Sr No.</th>
			                									<th>Material</th>
			                									<th>Unit</th>
			                									<th>BOQ</th>
			                									<th>Accepted Quantity</th>
			                									<th>Balance Quantity</th>
			                									<th>Scheduled Target</th>
			                									<th>% Achieved</th>
			                								</tr>
			                							</thead>
			                							<tbody>
			                								<?php foreach($reportData as $report) { ?>
			                								<tr>
			                									<td><?php echo $report->sr_no;?></td>
			                									<td><?php echo $report->material;?></td>
			                									<td><?php echo $report->unit;?></td>
			                									<td class="table-td-center"><?php echo $report->boq;?></td>
			                									<td class="table-td-center"><?php echo $report->accepted_quantity;?></td>
			                									<td class="table-td-center"><?php echo $report->balance_quantity;?></td>
			                									<td class="table-td-center"><?php echo $report->scheduled_target;?></td>
			                									<td class="table-td-center"><?php echo $report->per_acheived;?></td>
			                								</tr>
			                								<?php } ?>	
			                							</tbody>
			                						</table>
			                					</div>
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


	   <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	   <script type="text/javascript">

	   	$('input[name="date"]').daterangepicker({
           // autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });


         <?php if(empty($_POST['date']))  {  ?>
            $('input[name="date"]').val("");
            <?php } ?>


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
	   </script>

	</body>
</html>