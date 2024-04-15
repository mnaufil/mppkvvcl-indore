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

	    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">

	    <!-- TABLER ICONS CSS -->
	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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

                <!-- App Content -->
                <div class="main-content app-content mt-0">
                	<div class="side-app">
                		
                		<!-- Container -->
                		<div class="main-container container-fluid">

                			<!-- Page Header -->
                			<div class="page-header">
                				<h1 class="page-title">Add Data</h1>
                			</div>
                			<!-- Page Header Ends -->

                			<!-- Row -->
                			<div class="row row-sm">
                				<div class="col-xl-12">
                					<div class="card">
                						<div class="card-body mt-3">
                							
                							<div class="row">
                								<!-- Import Type -->
                								<div class="col-xl-3">
                									<label class="form-label" for="importType">Import Type
		                                                <span class="text-red">*</span>
		                                            </label>
		                                            <select class="form-control select2" id="importType" name="importType">
		                                            	<option value="select" selected disabled>Select Import Type</option>
		                                            	<?php foreach ($import_types as $value) { ?>
		                                            	<option value="<?php echo $value['type_name']; ?>"><?php echo $value['type_name']; ?></option>	
		                                            	<?php } ?>
		                                            </select>
                								</div>
                								<!-- Import Sub-Type -->
                								<div class="col-xl-3" id="import-sub-type">
                									<label class="form-label" for="importSubType">Import Sub Type
		                                                <span class="text-red">*</span>
		                                            </label>
		                                            <select class="form-control select2" id="importSubType" name="importSubType">
		                                            	<option value="select" selected disabled>Select Import Sub Type</option>
		                                            </select>
                								</div>
                								<!-- Sample Format -->
                								<div class="col-xl-3" id="download-format-div" hidden>
                									<!-- <label class="form-label" for="">Sample Format</label> -->
                									<a type="button" href="" class="btn btn-light btn-wave waves-effect waves-light mt-5" id="download-btn"> Download Format 
                										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                											<path d="M13 12H16L12 16L8 12H11V8H13V12ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z"></path>
                										</svg>
                									</a>
                								</div>
                							</div>

                							<div class="row" id="file-upload-div" hidden>
                								<!-- File Upload -->
                								<div class="mb-3 col-xl-6" >
                									<label for="dataFileUpload" class="form-label">Upload Data File</label>
                									<input class="form-control" type="file" id="dataFileUpload">
                								</div>
                								<!-- Process -->
                								<div class="col-xl-3 mt-5">
                									<button type="button" class="btn btn-warning btn-wave waves-effect waves-light" id="btn-process-file">Process File</button>	
                								</div>
                							</div>

                							<!-- Loading Spinner -->
				            				<div class="row process-loader m-0 mt-2 mb-3" hidden>
				            					<div class="d-flex align-items-center rounded-2 pt-1 pb-1" style="background: #efefef">
												  	<strong class="process-loader-message">Loading...</strong>
												  	<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
												</div>	
				            				</div>
				            				<!-- Loading Spinner Ends -->

				            				<!-- Valid/Invalid Records -->
				            				<div class="row mt-3 mb-3" id="file-upload-process-result-div" hidden>
				            					<div class="accordion" id="accordionExample">
				            						<!-- Valid Records -->
				            						<div class="accordion-item">
				            							<h2 class="accordion-header" id="headingValid">
				            								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#validRecords" aria-expanded="false" aria-controls="validRecords"> Valid Records (2) </button>
				            							</h2>
				            							<div id="validRecords" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
				            								<div class="accordion-body">
				            									<div class="table-responsive"> 
																	<table class="table text-nowrap" id="table-valid-records"> 
																		<thead>
																			<tr>
																				<th scope="col">Product</th>
																				<th scope="col">Seller</th>
																				<th scope="col">Sale Percentage</th>
																				<th scope="col">Qunatity Sold</th>
																			</tr> 
																		</thead> 
																		<tbody class="table-group-divider">
																		</tbody>
																	</table>
																</div>
				            								</div>
				            							</div>
				            						</div>
				            						<!-- Invalid Records -->
				            						<div class="accordion-item">
				            							<h2 class="accordion-header" id="headingInvalid">
				            								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#invalidRecords" aria-expanded="false" aria-controls="invalidRecords"> Invalid Records (2) </button>
				            							</h2>
				            							<div id="invalidRecords" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
				            								<div class="accordion-body">
				            									<div class="table-responsive"> 
																	<table class="table text-nowrap" id="table-invalid-records"> 
																		<thead>
																			<tr>
																				<th scope="col">Product</th>
																				<th scope="col">Seller</th>
																				<th scope="col">Sale Percentage</th>
																				<th scope="col">Qunatity Sold</th>
																			</tr> 
																		</thead> 
																		<tbody class="table-group-divider">
																		</tbody>
																	</table>
																</div>
				            								</div>
				            							</div>
				            						</div>
				            					</div>
				            				</div>

				            				<div class="row">
				            					<div class="col-xl-12 mt-3 mb-3">
				            						<!-- Import -->
                									<button type="button" class="btn btn-success btn-wave waves-effect waves-light" id="btn-import-file" disabled hidden>Import File</button>
                									<!-- Cancel -->
                									<button type="button" class="btn btn-danger btn-wave waves-effect waves-light" id="btn-import-file-cancel" hidden>Cancel</button>
                									<!-- Back -->
                									<a type="button" class="btn btn-primary" href="<?php echo base_url('data-import') ?>">Back</a>	
                								</div>
				            				</div>

                						</div>
                					</div>
                				</div>
                			</div>
                			<!-- Row Ends -->

                		</div>
                		<!-- Container Ends -->

                	</div>
                </div>
                <!-- App Content Ends -->
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
        <script src="<?php  echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

        <!-- SELECT2 JS -->
        <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

        <!-- FORMVALIDATION JS -->
        <script src="<?php echo base_url('assets/js/form-validation.js'); ?>"></script>

        <!-- TypeHead js -->
        <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

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

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

        <script type="text/javascript">
        	let import_sub_types = <?php echo json_encode($import_sub_types) ?>;

        	$('select[name="importType"]').change(function(event) {
        		let selected_import_type = $(this).val();

        		if ($('#download-format-div').is(":visible")) {
        			$('#download-format-div').prop('hidden', true);
        		}

        		if ($('#file-upload-div').is(":visible")) {
        			$('#file-upload-div').prop('hidden', true);
        		}

        		if (selected_import_type != 'Invoice') {
        			if ($('#import-sub-type').is(':hidden')) {
        				$('#import-sub-type').prop('hidden', false);	
        			}

        			let import_sub_type = import_sub_types[selected_import_type];

	        		let sub_type_html = '<option value="select" selected disabled>Select Import Sub Type</option>';

	        		$.each(import_sub_type, function(index, value) {
	        			sub_type_html += '<option value="'+value.sub_type_name+'">'+value.sub_type_name+'</option>';
	        		});

	        		$('select[name="importSubType"]').empty().append(sub_type_html);	
        		} else if (selected_import_type == 'Invoice') {
        			selected_import_type = selected_import_type.toLowerCase();
        			let download_url = '<?php echo base_url() ?>' + "assets/data-import-samples/" + selected_import_type + "/" + selected_import_type + ".xlsx";

        			$('#import-sub-type').prop('hidden', true);

        			$('#download-btn').attr('href', download_url);
	        		$('#download-btn').attr('download', selected_import_type + '.xlsx');

	        		$('#download-format-div').prop('hidden', false);
	        		$('#file-upload-div').prop('hidden', false);
        		}
        	});

        	$('select[name="importSubType"]').change(function(event) {
        		let selected_import_sub_type = $(this).val();

        		// selected_import_sub_type.replace(/ - /g, "_");
        		selected_import_sub_type = selected_import_sub_type.replace(/ /g, "_").toLowerCase();

        		let selected_import_type = $('select[name="importType"]').val().toLowerCase();

        		let download_url = '<?php echo base_url() ?>' + "assets/data-import-samples/" + selected_import_type + "/" + selected_import_type + "_" + selected_import_sub_type + ".xlsx";

        		$('#download-btn').attr('href', download_url);
        		$('#download-btn').attr('download', selected_import_type + "_" + selected_import_sub_type + '.xlsx');

        		$('#download-format-div').prop('hidden', false);
        		$('#file-upload-div').prop('hidden', false);        		
        	});

        	$('#btn-process-file').click(function(event) {
        		let uploaded_file = $('#dataFileUpload').val();

        		let file_ext = uploaded_file.split('.').pop().toLowerCase();

        		if ($.inArray(file_ext, ['xls', 'xlsx']) == -1) {
        			$('.toast-body').text('Kindly upload file in xls/xlsx format only');
                    $('.toast').toast('show');

                    return false;
        		} else {
        			let formData = new FormData();
        			formData.append('dataFile', $('#dataFileUpload')[0].files[0]);

        			let import_type = $('select[name="importType"]').val();
        			formData.append('import_type', import_type);

        			if ($('select[name="importSubType"]').is(":visible")) {
        				let import_sub_type = $('select[name="importSubType"]').val();
        				formData.append('import_sub_type', import_sub_type);
        			}

        			if (typeof $(this).data('import-hdr-id') !== 'undefined') {
        				let import_hdr_id = $(this).data('import-hdr-id');
        				formData.append('import_hdr_id', import_hdr_id);
        			}

        			$('.process-loader').removeAttr('hidden');
    				$('.process-loader').find('.process-loader-message').html('Please wait while the system is processing the uploaded file.');

    				// $('#btn-process-file').prop('disabled', true); //Uncomment Later

    				$.ajax({
        				url: '<?php echo base_url('process-data-file') ?>',
        				type: 'POST',
        				processData: false,
        				contentType: false,
        				dataType : 'json',
        				data: formData,
        				success: function(response) {
        					console.log(response); 
        					// return false;
        					$('.process-loader').attr('hidden', true);

        					$('.toast-body').text(response.message);
                    		$('.toast').toast('show');

                    		// Displaying count of valid and invalid records
                    		$('#headingValid').find('button').html('Valid Records (' + response.valid_records.length + ')');
                    		$('#headingInvalid').find('button').html('Invalid Records (' + response.invalid_records.length + ')');

                    		// Displaying valid records
                    		let valid_thead_html = valid_tbody_html = '';

                    		$.each(response.table_headers, function(index, value) {
                    			valid_thead_html += '<th scope="col">'+ value +'</th>';
                    		});

                    		$('#table-valid-records > thead').find('tr').empty().append(valid_thead_html);

                    		$.each(response.valid_records, function(index, value) {
                    			valid_tbody_html += '<tr>';

                    			$.each(response.table_headers, function(ind,val) {
                    				if (val.includes('(DD-MM-YYYY)')) {
                    					val = val.replace('(DD-MM-YYYY)', '');
                    				}

                    				if (val.includes('%')) {
                    					val = val.replace('%', '');
                    				}

                    				if (import_type != 'Invoice') {
                    					val = val.trim().replace(/ /g,'_').toLowerCase();
                    				} else if (import_type == 'Invoice') {
                    					val = val.trim().replace(/ /g,'_').toUpperCase();
                    				}

                    				let td_val = (value[val] == null) ? '' : value[val];
                    				valid_tbody_html += '<td>'+ td_val +'</td>';
                    			});

                    			valid_tbody_html += '</tr>';
                    		});

                    		$('#table-valid-records > tbody').empty().append(valid_tbody_html);

                    		// Displaying invalid records
                    		let invalid_thead_html = invalid_tbody_html = '';

                    		invalid_thead_html += '<th scope="col">Error Message</th>';
                    		$.each(response.table_headers, function(index, value) {
                    			invalid_thead_html += '<th scope="col">'+ value +'</th>';
                    		});

                    		$('#table-invalid-records > thead').find('tr').empty().append(invalid_thead_html);

                    		$.each(response.invalid_records, function(index, value) {
                    			invalid_tbody_html += '<tr>';
                    			invalid_tbody_html += '<th scope="row" class="text-danger">'+ value.error_message +'</th>';

                    			$.each(response.table_headers, function(ind,val) {
                    				if (val.includes('(DD-MM-YYYY)')) {
                    					val = val.replace('(DD-MM-YYYY)', '');
                    				}

                    				if (val.includes('%')) {
                    					val = val.replace('%', '');
                    				}

                    				if (import_type != 'Invoice') {
                    					val = val.trim().replace(/ /g,'_').toLowerCase();
                    				} else if (import_type == 'Invoice') {
                    					val = val.trim().replace(/ /g,'_').toUpperCase();
                    				}

                    				let td_val = (value[val] == null) ? '' : value[val];
                    				invalid_tbody_html += '<td>'+ td_val +'</td>';
                    			});

                    			invalid_tbody_html += '</tr>';
                    		});

                    		$('#table-invalid-records > tbody').empty().append(invalid_tbody_html);

                    		$('#file-upload-process-result-div').prop('hidden', false);
                    		$('#btn-import-file').prop('hidden', false);
                    		$('#btn-import-file-cancel').prop('hidden', false);

                    		// Enabling Import button only if invalid records = 0
                    		if (response.invalid_records.length == 0) {
                    			$('#btn-import-file').prop('disabled', false);
                    			$('#btn-import-file').attr('data-import-hdr-id', response.import_hdr_id);
                    		}

                    		$('#btn-process-file').attr('data-import-hdr-id', response.import_hdr_id);	
                    		$('#btn-import-file-cancel').attr('data-import-hdr-id', response.import_hdr_id);	
        				},
        				error: function(xhr, status, error) {
        					console.log(xhr);
        					let error_msg = xhr.responseJSON.message;

        					$('.process-loader').attr('hidden', true);
        					$('#btn-process-file').prop('disabled', false);

	        				$('.toast-body').text(error_msg);
	                    	$('.toast').toast('show');
        				}
        			});
        		}
        	});

        	$('#btn-import-file').click(function(event) {
        		let import_hdr_id = $(this).attr('data-import-hdr-id');
        		let import_type = $('select[name="importType"]').val();

        		$('.process-loader').removeAttr('hidden');
				$('.process-loader').find('.process-loader-message').html('Please wait while the system is importing the data.');

				$('#btn-import-file').prop('disabled', true);

        		$.ajax({
        			url: '<?php echo base_url('import-data-file') ?>',
        			type: 'POST',
        			dataType: 'json',
        			data: {import_hdr_id: import_hdr_id, import_type: import_type},
        			success: function(response) {
        				console.log(response);
        				// return false;

        				$('.process-loader').attr('hidden', true);

        				$('.toast-body').text(response.message);
                    	$('.toast').toast('show');

                    	setTimeout(function() {
                            window.location.replace('<?php echo base_url('data-import') ?>');
                        }, 2000);
        			},
        			error: function(xhr, status, error) {
        				console.log(xhr);
        				$('.process-loader').attr('hidden', true);
        				$('#btn-import-file').prop('disabled', false);

        				let error_msg = xhr.responseJSON.message;

        				$('.toast-body').text(error_msg);
                    	$('.toast').toast('show');
        			}
        		});
        	});

        	$('#btn-import-file-cancel').click(function(event){
        		let import_hdr_id = $(this).attr('data-import-hdr-id');

        		$('.process-loader').removeAttr('hidden');
				$('.process-loader').find('.process-loader-message').html('Please wait while the system cancels the data import process.');

				$('#btn-import-file').prop('disabled', true);
				$('#btn-import-file-cancel').prop('disabled', true);

				$.ajax({
					url: '<?php echo base_url('cancel-data-import') ?>',
        			type: 'POST',
        			dataType: 'json',
        			data: {import_hdr_id: import_hdr_id},
        			success: function(response) {
        				// console.log(response);
        				$('.process-loader').attr('hidden', true);

        				$('.toast-body').text(response.message);
                    	$('.toast').toast('show');

                    	setTimeout(function() {
                            window.location.replace('<?php echo base_url('data-import') ?>');
                        }, 2000);
        			}, 
        			error: function(xhr, status, error) {
        				$('.process-loader').attr('hidden', true);
        				$('#btn-import-file-cancel').prop('disabled', false);

        				if (response.invalid_records.length == 0) {
                			$('#btn-import-file').prop('disabled', false);
                		}

        				let error_msg = xhr.responseJSON.message;

        				$('.toast-body').text(error_msg);
                    	$('.toast').toast('show');
        			}
				});
        	});

        	$('#dataFileUpload').change(function(event) {
        		if ($('#btn-process-file').is(':disabled')) {
        			$('#btn-process-file').prop('disabled', false);
        		}

        		if (!$('#btn-import-file').is(':disabled')) {
        			$('#btn-import-file').prop('disabled', true);
        		}
        	});
        </script>
	</body>
</html>