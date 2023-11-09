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
                  <h1 class="page-title">Report Name: Non Conformance Report</h1>
                </div>
                <!-- PAGE-HEADER END -->

		            <!-- ROW -->
		            <div class="row">
		            	<div class="col-lg-12">
		              	<div class="card">
		                	<div class="card-body">

		                		<div class="form-row mt-2 mb-2">
		                			<div class="col-xl-4">
		                				<label class="form-label">Report Description:</label>
                            <p class="report-desc">Choose the Package No.</p>
	                				</div>
	                			</div>

		                		<!-- Form -->
		                		<form id="generateNonConformanceReport" name="generateNonConformanceReport" method="post" action="<?php echo base_url('generate-non-conformance-report')?>">
		                			<!-- Row1 -->
		                			<div class="form-row">
		                				<!-- Package No -->
		                				<div class="col-xl-4 mb-3">
		                					<label for="packageNo" class="form-label">Package No.<span class="text-red">*</span></label>
                             	<select class="form-control select2" id="packageNo" name="packageNo">
			                        	<option value="" selected disabled>Select Package No.</option>
                              	<?php foreach($packages as $package) { ?>
                              	<option value="<?php echo $package->package_no;?>" <?php if($postpackage==$package->package_no) { ?> selected <?php } ?> ><?php echo $package->package_no;?></option>
                              	<?php } ?>
                              </select>
                						</div>
                						<!-- Region -->
		                				<div class="col-xl-4 mb-3">
			                				<label class="form-label" for="region">Region<span class="text-red">*</span></label>
	                						<select class="form-control select2" id="region" name="region">
			                        	<option value="" selected disabled>Select Region</option>
			                          <?php foreach($regions as $region) { ?>
                            		<option value="<?php echo $region->region_name;?>" <?php if($postregion==$region->region_name) { ?> selected <?php } ?>><?php echo $region->region_name;?></option>
                								<?php } ?>
                							</select>
		                				</div>
		                				<!-- Circle -->
			                			<div class="col-xl-4 mb-3">
	                						<label class="form-label" for="circle">Circle<span class="text-red">*</span></label>
	                						<select class="form-control select2" id="circle" name="circle">
			                        	<option value="" selected disabled>Select Circle</option>
			                          <?php //foreach($circles as $circle) { ?>
                              	<!-- <option value="<?php echo $circle->circle_name;?>" <?php if($postcircle==$circle->circle_name) { ?> selected <?php } ?>><?php echo $circle->circle_name;?></option> -->
		                						<?php //} ?>	

		                						<?php if (isset($selected_region_circle_data) && !empty($selected_region_circle_data)) {
		                										foreach ($selected_region_circle_data as $key => $value) {
		                											$selected = ($value == $postcircle) ? 'selected' : '';
		                						?>
		                						<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
		                						<?php 	}
		                									}
		                						?>
		                          </select>
	                					</div>
                					</div>
                					<!-- Row2 -->
                					<div class="form-row">
                						<!-- NCR Date -->
		                				<div class="col-xl-4 mb-3">
		                					<label class="form-label" for="ncrDate">NCR Date<span class="text-red">*</span></label>
                							<div class="input-group">
                        				<div class="input-group-text dates">
                        					<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                      					</div>
                      					<input class="form-control" type="text" id="ncrDate" name="ncrDate" value="<?php if(!empty($postncrDate))  { echo $postncrDate;}?>">	
                      				</div>
                						</div>
                						<!-- Status -->
                						<div class="col-xl-4 mb-3">
		                					<label class="form-label" for="status">Status<span class="text-red">*</span></label>
	                						<select class="form-control select2" id="status" name="status">
			                        	<option value="" selected disabled>Select Status</option>
			                          <option value="all" <?php if($poststatus=="all") { ?> selected <?php } ?>>All</option>
			                          <option value="1" <?php if($poststatus==1) { ?> selected <?php } ?>>Open</option>
			                          <option value="2" <?php if($poststatus==2) { ?> selected <?php } ?>>Closed</option>
		                          </select>
	                					</div>
                					</div>

		                			<button class="btn btn-success mb-3 mt-3" type="submit">Generate </button>
													<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('non-conformance-report')?>">Clear</a>
                   				<a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports')?>">Back</a>
                				</form>

                			</div>
                		</div>
                	</div>
                </div>
		            <!-- ROW ENDS -->

		            <?php if (isset($feeder_access) && $feeder_access) { ?>
			            <!-- Report Row -->
			            <?php if (is_array($reportData)) { ?>
			            <div class="row" id="report-table" >
			            	<div class="col-lg-12">
			              	<div class="card">
			                	<?php if(isset($_POST['packageNo'])) { ?>
			                	<div class="card-body">

			                		<?php if ($download_access) { ?>
			                		<div class="row">
			                			<!-- Export Button -->
			                			<div class="col-sm-12 col-md-9s mt-3 mb-3">
				                    	<div class="dts-buttons btn-group flex-wrap" style="float:right;">
				                      	<a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" type="button"><span>Export</span></a>
				                        &nbsp;
				                        <a target="_blank" href="<?php echo base_url('convert-pdf');?>" class="btn btn-success" type="button"><span>View in Pdf</span></a>
			                        </div>
			                      </div>
	                				</div>	
			                		<?php } ?>

	                        <div class="row mb-3">
			                    	<div class="col-xl-12" style="overflow: auto;width: 500px;">
			                        <table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
			                        	<tbody>
			                          	<?php $i=0; foreach($reportData as $report) { ?> 
			                            <?php if($i==0) { ?>
	                                <tr>
	                                	<tr>
	                                		<td><b>DISCOM</b></td>
	                                		<td>MPPKVVCL</td>
	                                	</tr>
	                                  <td><b>TKC</b></td>
	                                  <td><?php echo $report->contractor_name;?></td>
	                              	</tr>
	                              	<tr>
	                              		<td><b>Package No</b></td>
	                              		<td><?php echo $report->package_no?></td>
	                              	</tr>
	                                <tr>
	                                	<td><b>Contractor Name</b></td>
	                                	<td><?php echo $report->contractor_name?></td>
	                               	</tr>
	                                <tr>
	                                	<td><b>Region Name</b></td>
	                                	<td><?php echo $report->region_name?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Circle Name</b></td>
	                                	<td><?php echo $report->circle_name?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Division Name</b></td>
	                                	<td><?php echo $report->division_name?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Feeder ID</b></td>
	                                	<td><?php echo $report->feeder_id?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Feeder Name</b></td>
	                                	<td><?php echo $report->feeder_name?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Substation</b></td>
	                                	<td><?php echo $report->substation?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Standards</b></td>
	                                	<td><?php echo $report->standards?></td>
	                               	</tr>
	                                <tr style="height:50px">
	                                	<td border='0'></td>
	                                	<td></td>
	                                </tr>         
	                                <?php } ?>
	                                <tr>
	                                	<td><b>NCR ID</b></td>
	                                	<td><?php echo $report->ncr_id?></td>
	                               	</tr>
	                                <tr>
	                                	<td><b>NCR Date</b></td>
	                                	<td><?php echo $report->ncr_date?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Raised By</b></td>
	                                	<td><?php echo $report->Inspected_by?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Activity</b></td>
	                                	<td><?php echo $report->activity?></td>
	                               	</tr>
	                                <tr>
	                                	<td><b>Observation Type</b></td>
	                                	<td><?php echo $report->observation_type?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Observation</b></td>
	                                	<td><?php echo $report->observation?></td>
	                                </tr>
	                                <tr>
	                                	<td><b>Observation Photos</b></td>
	                                	<td>
	                                    <?php $explode = explode(",",$report->observation_photos ?? '');
	                                          $count = count($explode);
	                                          for($i=0;$i<$count;$i++) { 
	                                    ?>
	                                    <img src="<?php echo $explode[$i]?>" width="150"/>
	                                    <?php } ?>
	                                  </td>
	                                </tr>
	                                <tr>
	                                	<td><b>Completed Photos</b></td>
	                                  <td>
	                                  	<?php $explode1 = explode(",",$report->completion_photos ?? '');
	                                          $count1 = count($explode1);
	                                          for($j=0;$j<$count1;$j++) { 
	                                    ?>
	                                    <img src="<?php echo $explode1[$j]?>" width="150"/>
	                                  	<?php } ?>
	                                	</td>
	                                </tr>
	                                <tr>
	                                	<td><b>Completion Date</b></td>
	                                  <td><?php echo (!empty($report->completion_date) ? date('d-m-Y', strtotime($report->completion_date)) : ''); ?></td>
	                                </tr>      
	                                <tr style="height:40px">
	                                	<td border='0'></td>
	                                	<td></td>
	                              	</tr>
	                                <?php $i++; } ?>
	                        		  </tbody>
	                        		</table>
	                        	</div>
	                      	</div>
	                      </div>
			                	<?php } ?>
		                	</div>
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
	        		<!-- CONTAINER ENDS -->
	        	</div>
	        </div>
	        <!--app-content ends-->

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

	   	<!-- DATERANGE PICKER JS -->
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	   	<script type="text/javascript">
	   		$('input[name="ncrDate"]').daterangepicker({
          //autoUpdateInput: false,
          locale: {
          	format: 'DD-MM-YYYY'
          }
        });

	   		<?php if(empty($postncrDate))  {  ?>
        $('input[name="ncrDate"]').val("");
        <?php } ?>

	   		function showReport() {
         	$('#report-table').removeAttr('hidden');
    		}

      	let circle_data = <?php echo json_encode($circle_data) ?>;

      	$('#region').on('change', function(event) {
      		let selected_region = this.value;

      		let circles = circle_data[selected_region];

      		let html = '';     		

      		html += '<option value="" selected disabled>Select Circle</option>'; 
      		$.each(circles, function(index, value) {
      			html += '<option value="'+ value +'">'+ value + '</option>';
      		});

      		// Clearing previous appended circle list
      		$('#circle').empty();

      		// Appending new circle list
      		$('#circle').append(html);
      	});

      	$('#generateNonConformanceReport').submit(function(event) {
      		let package_no = $('#packageNo option:selected').val();

      		let region = $('#region option:selected').val();

					let circle = $('#circle option:selected').val();

					let ncrDate = $('#ncrDate').val();

					let status = $('#status option:selected').val();

					if (package_no == '' && region == '' && circle == '' && ncrDate == '' && status == '') {
						$('.toast-body').text('Select filters to generate the report');
           	$('.toast').toast('show');

           	event.preventDefault();
					} else if (package_no == '') {
						$('.toast-body').text('Select Package No');
           	$('.toast').toast('show');

           	event.preventDefault();
					} else if (region == '') {
						$('.toast-body').text('Select Region');
           	$('.toast').toast('show');

           	event.preventDefault();
					} else if (circle == '') {
						$('.toast-body').text('Select Circle');
           	$('.toast').toast('show');

           	event.preventDefault();
					} else if (ncrDate == '') {
						$('.toast-body').text('Select NCR Date');
           	$('.toast').toast('show');

           	event.preventDefault();
					} else if (status == '') {
						$('.toast-body').text('Select Status');
           	$('.toast').toast('show');

           	event.preventDefault();
					}
      	});
	   </script>
	</body>
</html>