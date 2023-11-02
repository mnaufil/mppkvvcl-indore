<!DOCTYPE html>
<html lang="en" dir="ltr">

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
			<!-- Page Main -->
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
								<h1 class="page-title"><?php echo $title; ?></h1>
								<!-- Code needs to written -->
								<!-- <div class="row">
									<div class="col-md-12 mt-2 mb-3">
										<a href="<?php echo base_url('add-invoice'); ?>" class="btn btn-success btn-add">Add</a>
									</div>
								</div> -->
							</div>
							<!-- Page-Header Ends -->

							<!-- Row -->
							<div class="row row-sm">
								<div class="col-lg-12">
									<div class="card">

										<div class="card-body">
											<!-- SEARCH BLOCK -->
											<div class="accordion" id="accordionExample">
												<div class="accordion-item">
													<h2 class="accordion-header" id="headingOne">
														<?php   $accordion_btn_class = (isset($filter_data)) ? 'filters-on' : '';
                                                   				$accordion_btn_style = (isset($filter_data)) ? 'style="height:57px;"' : '';
                                                   				$clear_btn_visibility = (isset($filter_data)) ? '' : 'hidden';
                                          				?>
                                          				<button class="accordion-button collapsed active prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>Search Invoice Status</button>
													</h2>
													<div class="clear-data" <?php echo $clear_btn_visibility; ?>>
														<a href="#" class="text-danger clear-search-filters" id="invoice-clear-btn" style="right: 60px !important;">Clear</a>
													</div>
													<div class="lab-value">
														<ul>
			                                             	<?php 	if (isset($filter_data)) { 
			                                                      		foreach ($filter_data as $key => $value) { 
			                                                         		if (!empty($value['value'])) {
			                                             ?>
			                                             <li><?php echo $value['label'].' : '.$value['value']; ?></li>
			                                             	<?php       	}
			                                                      		}
			                                                   		}
			                                             	?>
			                                          </ul>
													</div>
													<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
														<div class="accordion-body p-1">
															<form name="search_invoice_status" id="search_invoice_status" method="post" action="<?php echo base_url('search-invoice'); ?>">
																<!-- Row1 -->
																<div class="row">
																	<!-- Contractor (TKC) -->
																	<div class="col-md-4">
																		<div class="form-group">
																			<label class="form-label m-0" for="contractor">Contractor (TKC)</label>
																			<input class="form-control invoice-input" type="text" name="contractor" id="contractor" value="" onkeyup="showtkclist(this.value)">
																			<div class="list-group list-view-contractor" id="list-view"></div>
																		</div>
																	</div>
																	<!-- Contract No. -->
																	<div class="col-md-3">
																		<label class="form-label m-0" for="tenderAwardNo">Contract No.</label>
																		<input class="form-control invoice-input" type="text" name="tenderAwardNo" id="tenderAwardNo" value="">
																	</div>
																	<!-- Invoice No. -->
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="form-label m-0" for="invoiceNo">Invoice No.</label>
																			<input class="form-control invoice-input" type="text" name="invoiceNo" id="invoiceNo" value="">
																		</div>
																	</div>
																	<!-- Status -->
																	<div class="col-md-2">
																		<div class="form-group">
																			<label class="form-label m-0" for="status">Status</label>
																			<select multiple="multiple" class="filter-multi" name="status[]" id="status">
																				<?php foreach ($invoice_status as $key => $value) { ?>
																				<option value="<?php echo $value['status_id']; ?>"><?php echo $value['name']; ?></option>
																				<?php } ?>
																			</select>
																		</div>
																	</div>
																</div>
																<!-- Row2 -->
																<div class="row">
																	<!-- Search Button -->
																	<div class="col-md-3">
				                                                      	<button type="submit" class="btn btn-primary mt-2 mb-1 search-invoice-btn">Search</button>
				                                                      	<button type="button" class="btn default-clear clear-search-filters mt-2 mb-1">Clear</button>
				                                                   	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
											<!-- SEARCH BLOCK -->

											<!-- Table -->
											<div class="table-responsive mt-3">
												<div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
													<div class="row">
														<div class="col-sm-12">
															<!-- Export Button -->
															<!-- <div class="col-sm-12 col-md-9s">
																<div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                                                    <button class="btn btn-primary" type="button"><span>Export</span></button>
                                                                </div>
															</div> -->
															<table class="table table-bordered text-nowrap border-bottom dataTable no-footer" id="basic-datatable" role="grid" aria-describedby="basic-datatable_info">
																<thead>
																	<tr role="row">
																		<th class="wd-10p border-bottom-0" tabindex="0" aria-controls="basic-datatable" rowspan="1" colspan="1"style="width: 95.5156px;">Actions</th>
																		<th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Invoice No.: activate to sort column descending" style="width: 95.5156px;">Invoice No.</th>
																		<th class="wd-15p border-bottom-0 sorting" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Invoice Date: activate to sort column descending" style="width: 88.5469px;">Invoice Date</th>
																		<th class="wd-25p border-bottom-0 sorting" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Invoice Amount: activate to sort column ascending" style="width: 178.531px;">Invoice Amount</th>
																		<th class="wd-25p border-bottom-0 sorting" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contractor (TKC): activate to sort column ascending" style="width: 92.5312px;">Contractor (TKC)</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="5" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Type Of Supply: activate to sort column descending" style="width: 67.7031px;">Type Of Invoice</th>
																		<th class="wd-15p border-bottom-0 sorting" tabindex="6" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contract No.: activate to sort column descending" style="width: 185.141px;">Contract No.</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="7" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contract Date: activate to sort column ascending" style="width: 185.141px;">Contract Date</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="8" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Type Of Work: activate to sort column ascending" style="width: 185.141px;">Type Of Work</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="9" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Period: activate to sort column ascending" style="width: 185.141px;">Period</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="10" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Balance to Claim: activate to sort column ascending" style="width: 185.141px;">Balance to Claim</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="11" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Balance to Pay: activate to sort column ascending" style="width: 185.141px;">Balance to Pay</th>
																		<th class="wd-20p border-bottom-0 sorting" tabindex="12" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 185.141px;">Status</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach ($invoices as $key => $value) { ?>
																		<tr>
																			<td>
																				<?php if (!empty($user_access) && isset($user_access['view'])) { ?>
																				<a href="<?php echo base_url('view-invoice/'.$value['invoice_id']); ?>" class="btn btn-sm">
	                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
	                                                                            </a>
	                                                                            &nbsp;&nbsp;
																				<?php } ?>
																				<?php if (!empty($user_access) && isset($user_access['update'])) { ?>
																				<a href="<?php echo base_url('edit-invoice/'.$value['invoice_id']); ?>" class="btn btn-sm">
	                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
	                                                                            </a>	
																				<?php } ?>
	                                                                            <!-- &nbsp;&nbsp;
	                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
	                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
	                                                                            </button> -->
																			</td>
																			<td style="text-align: center;"><?php echo $value['invoice_no']; ?></td>
																			<td style="text-align: center;"><?php echo $value['invoice_date'] ?></td>
																			<td style="text-align: center;"><?php echo '&#8377;'.number_format($value['invoice_amount_with_gst'], 2); ?></td>
																			<td style="text-align: left;"><?php echo $value['contractor_name']; ?></td>
																			<td style="text-align: center;"><?php echo $value['invoice_type']; ?></td>
																			<td style="text-align: center;"><?php echo $value['tender_award_no']; ?></td>
																			<td style="text-align: center;"><?php echo $value['tender_award_date']; ?></td>
																			<td style="text-align: left;"><?php echo $value['typeofwork_name']; ?></td>
																			<td style="text-align: center;"><?php echo $value['period']; ?></td>
																			<td style="text-align: center;"><?php echo '&#8377;'.number_format($value['balance_to_claim'], 2); ?></td>
																			<td style="text-align: center;"><?php echo '&#8377;'.number_format($value['balance_to_pay'], 2); ?></td>
																			<td style="text-align: center;"><?php echo $value['status'] ?></td>
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
							</div>
							<!-- Row Ends -->

						</div>

					</div>
				</div>
				<!-- App-Content Ends -->

			</div>
			<!-- Page Main Ends -->

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
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.html5.min.js'); ?>"></script>
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

        <!-- MULTI JS -->
        <script src="<?php echo base_url('assets/plugins/multi/multi.min.js'); ?>"></script>

        <!-- MULTIPLE SELECT JS -->
		<script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

        <script type="text/javascript">
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

         	$('#search_invoice_status').submit(function(event) {
         		let contractor = $('input[name="contractor"]').val();
         		let tender_award_no = $('input[name="tenderAwardNo"]').val();
         		let invoice_no = $('input[name="invoiceNo"]').val();
         		let status = $('#status').val();

         		if (contractor == '' && tender_award_no == '' && invoice_no == '' && status == '') {
         			$('.toast-body').text('Enter value for atleast one filter');
	               	$('.toast').toast('show');

	               	event.preventDefault();
         		}
         	});

         	$('.clear-search-filters').click(function(event) {
	            event.preventDefault();
	            $('.lab-value').find('ul').empty();
	            $('#headingOne').find('button').removeClass('filters-on');
	            $('#headingOne').find('button').removeAttr('style');

	            let search_form = $('#search_invoice_status')[0];

	            //Clearing all input[type=text] values
	            $(search_form).find('input.form-control:text').each(function() {
	              	$(this).val('');
	            });

	            //Clearing Status filter values
	            let status_select = $(search_form).find('.filter-multi:eq(1)');
	            $(status_select).find('li.selected').each(function() {
	              	$(this).removeClass('selected');
	              	$(this).find('input:checkbox').prop('checked', false);
	            });
	            $(status_select).find('.ms-choice span').text('');

	            $('#invoice-clear-btn').hide();

	            window.location.replace('<?php echo base_url("invoice-status") ?>');
	        });
        </script>       

	</body>
</html>