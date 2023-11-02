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

	                        <!-- Page-Header -->
	                        <div class="page-header">
	                            <h1 class="page-title">Edit Region</h1>
	                        </div>
	                        <!-- Page-Header Ends -->

	                        <!-- Row -->
	                        <div class="row">
	                        	<div class="col-lg-12 col-md-12">
	                        		<form id="updateRegion" name="updateRegion" method="post" action="<?php echo base_url('update-region'); ?>">
		                        		<div class="card">
		                        			<div class="card-body mt-3">
		                        				<div class="form-row">
		                        					<div class="col-xl-4 mb-3">
		                        						<label class="form-label" for="regionName">Region Name <span class="text-red">*</span></label>
		                        						<input type="hidden" name="regionID" value="<?php echo $region_data['region_id']; ?>">
		                        						<input type="text" class="form-control" id="regionName" name="regionName" onpaste="changeFormStatus()" onkeyup="changeFormStatus()" value="<?php echo $region_data['region_name']; ?>">
		                        					</div>
		                        					<div class="col-xl-3 mt-5">
                                                    	<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#circle-modal" data-bs-whatever="@mdo">Add/Edit Circle</button>
                                                	</div>
		                        				</div>

		                        				<button class="btn btn-success mb-3" type="button" id="update-region-submit">Submit</button>
	                                    		<a class="btn btn-primary mb-3" href="<?php echo base_url('region'); ?>">Back</a>
		                        			</div>
		                        		</div>
		                        			
	                        		</form>
	                        	</div>
	                        </div>
	                        <!-- Row Ends -->

	                    </div>
	                    <!-- Container Ends -->
	                </div>                
	            </div>
	            <!-- App-Content Ends -->
	    	</div>	    	

	        <!-- Add Circle Modal -->
	        <div class="modal fade" id="circle-modal" style="display: none;" aria-hidden="true">
	            <div class="modal-dialog" role="document">
	                <div class="modal-content modal-content-demo">
	                    <!-- Modal Header -->
	                    <div class="modal-header">
	                        <h6 class="modal-title">Add Circle</h6>
	                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">×</span>
	                        </button>
	                    </div>

	                    <!-- Modal Body -->
	                    <div class="modal-body">
	                        <form>
	                            <div class="mb-3">
	                                <ul class="list-group" id="circle_row">
	                                	<?php if (!empty($region_data['circle_data'])) {
	                                			foreach ($region_data['circle_data'] as $key => $value) { 
	                                	?>
	                                	<li class="column list-group-item justify-content-between" id="listitems-<?php echo $key; ?>">
	                                        <input type="text" name="circle<?php echo $key; ?>" class="form-control-diff" data-circle-id="<?php echo $key; ?>" value="<?php echo $value; ?>" onkeyup="updateCircleValue(this)">
	                                        <span class="badgetext badge bg-primary rounded-pill">
	                                            <span aria-hidden="true" id="close-"<?php echo $key; ?> onclick="closeli(<?php echo $key; ?>)">×</span>
	                                        </span>
	                                    </li>		 	
	                                	<?php 	}  
	                               			  } else {
	                               		?>
	                               		<li class="column list-group-item justify-content-between" id="listitems-0">
                                        	<input type="text" name="circle0" class="form-control-diff" value="">
                                        	<span class="badgetext badge bg-primary rounded-pill">
                                            	<span aria-hidden="true" id="close-0" onclick="closeli(0)">×</span>
                                        	</span>
                                    	</li>
	                               		<?php } 
	                               		?>
	                                </ul>
	                            </div>
	                            <div class="container">
	                                <div class="row add_circle" id="addCircle" onclick="addCircle();">
	                                    <span class="fe fe-plus-circle fa-lg"></span>
	                                </div> 
	                            </div>
	                        </form>
	                    </div>

	                    <!-- Modal Footer -->
	                    <div class="modal-footer">
	                        <button class="btn ripple btn-success" id="modal-submit" data-bs-dismiss="modal" type="button">Submit</button> 
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- Add Circle Modal Ends -->

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

	    <!-- SWEET-ALERT JS -->
	    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

	    <script type="text/javascript">
	    	let circle_arr = [];
	    	let deleted_circles_id = [];
	    	// let updated_circles = [];
	    	let form_change = false;
	    	let circle_change = false;

	    	function changeFormStatus() {
	    		form_change = true;
	    	}

	    	let circle_data = <?php echo json_encode($region_data['circle_data']) ?>;
	    	if (!$.isEmptyObject(circle_data)) {
				circle_arr = circle_data;
	    	}

	    	function addCircle() {
	            var list_items;
	            var rows = document.querySelectorAll('#circle_row .column');

	            if ($(rows).length == 0) {
	            	rows_length = 0;
	            } else {
	            	let last_row = $(rows).last();
	                let last_row_id = $(last_row).attr('id');
	                let row_no_arr = last_row_id.split('-');
	                let row_no = row_no_arr.pop();
	                rows_length = parseInt(row_no) + 1;
	            }
	            
	            var html = '';
	            html += '<li class="column list-group-item" id="listitems-'+rows_length+'">';
	            html += '<input type="text" name="circle'+ rows_length +'" class="form-control-diff" value="">';
	            html += '<span class="badgetext badge bg-primary rounded-pill">';
	            html += '<span aria-hidden="true" id="close-'+rows_length+'" onclick="closeli('+rows_length+')">×</span>';
	            html += '</span>';
	            html += '</li>';

	            $('#circle_row').append(html);
	            circle_change = true;
        	}

        	/*function updateCircleValue(input) {
        		console.log($(input));

        		let new_value = $(input).val();
        		console.log('new_value:' + new_value);

        		let circle_id = $(input).data('circle-id');
        		console.log('circle_id:' + circle_id);

        		let temp_arr = [];
        		temp_arr[circle_id] = new_value;
        		console.log(temp_arr);
        	}*/

	        function closeli(row_no) {
	        	if (!$.isEmptyObject(circle_data)) {
	        		deleted_circles_id.push(row_no);
	        	    circle_change = true;
	        	    changeFormStatus();
	        	}

	        	delete circle_arr[row_no];

	            $("#listitems-"+row_no).remove();
	        }

	        $('#modal-submit').click(function(event) {
	            let circle_inputs = $('#circle_row').find('input[name^="circle"]');

	            circle_arr = [];
	            $(circle_inputs).each(function(index, value) {

	            	if (typeof $(value).data('circle-id') == 'undefined') {
	            		let circle = $(value).val();
	            		circle_arr.push(circle);
	            		// form_change = true;
	            		changeFormStatus();
	            	}
	            });
	        });

	        $('#update-region-submit').click(function(event) {
	        	let region_name = $('#updateRegion').find('input[name="regionName"]').val();

	        	if (form_change == false) {
	        		$('.toast-body').text('No changes occurred. Kindly update region to submit the form.');
	                $('.toast').toast('show');

	                event.preventDefault();
	                return false;
	        	} else {
	        		if (region_name == '') {
		        		$('.toast-body').text('No changes occurred. Kindly add a region to submit the form.');
		                $('.toast').toast('show');

		                event.preventDefault();
		                return false;
		        	} else {
		        		let form = $('#updateRegion')[0];
	                	let formData = new FormData(form);

	                	if (circle_change == true) {
	                		if (!$.isEmptyObject(circle_arr)) {
		                		$.each(circle_arr, function(index, value) {
			                    	formData.append('circle[]', value);
			                	});
		                	}

		                	if (!$.isEmptyObject(deleted_circles_id)) {
		                		$.each(deleted_circles_id, function(index, value) {
			                    	formData.append('deleted_circle[]', value);
			                	});
		                	}	
	                	}

	                	/*console.log('formData:');
	                	console.log(formData);*/

	                	let form_url = $('#updateRegion').attr('action');

	                	$.ajax({
	                		type: 'POST',
		                    url: form_url,
		                    dataType: 'json',
		                    data: formData,
		                    processData: false,
		                    contentType: false,
		                    success: function(response) {
		                        console.log(response);

		                        window.location.replace('<?php echo base_url('region') ?>');
		                    },
		                    error: function(xhr, status, error) {
		                        console.log(xhr.responseText);
		                    }
	                	});
		        	}	
	        	}
	        });
	    </script>
	</body>
	
</html>