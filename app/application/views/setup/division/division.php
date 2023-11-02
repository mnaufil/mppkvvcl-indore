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
                                <h1 class="page-title">Division</h1>
                                <div class="row">
                            		<div class="col-md-12 mt-2 mb-3">
                            			<a  href="<?php echo base_url('add-division'); ?>" class="btn btn-success btn-add">Add</a>
                            		</div>
                            	</div>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row row-sm">
                            	<div class="col-lg-12">
                            		<div class="card">

                                        <div class="card-body p-2">
                                        	<!-- Search Block -->
                                        	<div class="accordion" id="accordionExample">
                                        		<div class="accordion-item">
                                        			<h2 class="accordion-header" id="headingOne">
                                        				<?php $accordion_btn_class = (isset($filter_data)) ? 'filters-on' : '';
                                                          	  $accordion_btn_style = (isset($filter_data)) ? 'style="height:57px;"' : '';
                                                          	  $clear_btn_visibility = (isset($filter_data)) ? '' : 'hidden';
                                                    	?>
                                                    	<button class="accordion-button collapsed active prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>Search Division</button>
                                        			</h2>
                                        			<div class="clear-data" <?php echo $clear_btn_visibility; ?>>
	                                                    <a href="#" class="text-danger clear-search-filters" id="clear-btn"> Clear</a>
	                                                </div>
	                                                <div class="lab-value">
	                                                	<ul>
	                                                		<?php   if (isset($filter_data)) {
                                                                    	foreach ($filter_data as $key => $value) {
                                                                        	if (!empty($value['value'])) { ?>
	                                                        <li><?php echo $value['label'].' : '.$value['value']; ?></li>
	                                                        <?php           }
	                                                                    }   
	                                                                }
	                                                        ?>
	                                                	</ul>
	                                                </div>
	                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
	                                                	<div class="accordion-body p-1">
	                                                		<form name="searchDivision" id="searchDivision" method="post" action="<?php echo base_url('search-division'); ?>">
	                                                			<!-- Row1 -->
	                                                			<div class="row">
	                                                				<!-- Region -->
	                                                				<div class="col-md-2">
	                                                					<div class="form-group">
	                                                						<label class="form-label m-0" for="region">Region</label>
	                                                						<select class="form-control form-select select2 select2-hidden-accessible" name="region" data-bs-placeholder="Select Region" tabindex="-1" aria-hidden="true" id="region" style="width:100%">
	                                                							<option value="select" disabled <?php echo (isset($filter_data) && !empty($filter_data['region']['id'])) ? '' : 'selected'; ?>>Select Region</option>
	                                                							<?php $selected_region = (isset($filter_data)) ? $filter_data['region']['id'] : ''; ?>
	                                                							<?php foreach ($regions as $key => $value) { ?>
	                                                							<?php $selected = ($value['region_id'] == $selected_region) ? 'selected' : ''; ?>
	                                                							<option value="<?php echo $value['region_id']; ?>" <?php echo $selected; ?>><?php echo $value['region_name']; ?></option>
	                                                							<?php } ?>
	                                                						</select>
	                                                					</div>
	                                                				</div>
	                                                				<!-- Circle -->
	                                                				<div class="col-md-2">
	                                                					<div class="form-group">
	                                                						<label class="form-label m-0" for="circle">Circle</label>
	                                                						<select class="form-control form-select select2 select2-hidden-accessible" name="circle" data-bs-placeholder="Select Circle" tabindex="-1" aria-hidden="true" id="circle" style="width:100%">
	                                                							<option value="select" disabled <?php echo (isset($filter_data) && !empty($filter_data['circle']['id'])) ? '' : 'selected'; ?>>Select Circle</option>
	                                                							<?php $selected_circle = (isset($filter_data)) ? $filter_data['circle']['id'] : ''; ?>
	                                                							<?php foreach ($circles as $key => $value) { ?>
                                                								<?php $selected = ($value['circle_id'] == $selected_circle) ? 'selected' : ''; ?>
                                                								<option value="<?php echo $value['circle_id']; ?>" <?php echo $selected; ?>><?php echo $value['circle_name']; ?></option>
	                                                							<?php } ?>
	                                                						</select>
	                                                					</div>
	                                                				</div>
	                                                				<!-- Division -->
	                                                				<div class="col-md-2">
	                                                					<div class="form-group">
	                                                						<label class="form-label m-0" for="division">Division</label>
	                                                						<input type="text" class="form-control" name="division" id="division" value="<?php echo (isset($filter_data) && !empty($filter_data['division']['value'])) ? $filter_data['division']['value'] : ''; ?>">
	                                                					</div>
	                                                				</div>
	                                                			</div>
	                                                			<!-- Row2 -->
	                                                			<div class="row">
	                                                				<!-- Search Button -->
	                                                				<div class="col-md-3 mt-3">
	                                                                    <button type="submit" class="btn btn-primary mt-1 mb-1 search-division-btn">Search</button>
	                                                                    <button type="button" class="btn default-clear clear-search-filters mt-1 mb-1">Clear</button>
	                                                                </div>
	                                                			</div>
	                                                		</form>
	                                                	</div>
	                                                </div>
                                        		</div>
                                        	</div>
                                        	<!-- Search Block Ends -->

                                        	<!-- Delete Alert -->
	                                        <div class="row war-pop" id="division-delete-alert" hidden>
	                                            <div class="col-xl-3 col-sm-6 war-pop-1">
	                                               <div class="card border p-0 pb-3">
	                                                    <div class="card-header border-0 pt-3">
	                                                        <div class="card-options">
	                                                            <!-- <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove" onclick="closeNotificationAlert(this)">
	                                                               <i class="fe fe-x"></i>
	                                                            </a> -->
	                                                        </div>
	                                                    </div>
	                                                    <div class="card-body text-center">
	                                                        <span class="">
	                                                            <svg xmlns="http://www.w3.org/2000/svg" height="60" width="60" viewBox="0 0 24 24">
	                                                                <path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"></path>
	                                                                <circle cx="12" cy="17" r="1" fill="#e62a45"></circle>
	                                                                <path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"></path>
	                                                            </svg>
	                                                        </span>
	                                                        <h4 class="h4 mb-0 mt-3">Warning</h4>
	                                                        <p class="card-text notification-text">Are you sure you want to delete Division?</p>
	                                                    </div>
	                                                    <div class="card-footer text-center border-0 pt-0">
	                                                        <div class="row">
	                                                            <div class="text-center">
	                                                                <a href="javascript:void(0)" class="btn btn-danger notification-delete" data-circle-id="" onclick="deleteDivision(this)">Delete</a>
	                                                                <a href="javascript:void(0)" class="btn btn-white me-2" onclick="closeNotificationAlert(this)">Cancel</a>
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>   
	                                        </div>
	                                        <!-- Delete Alert Ends -->
                                        	
                                        	<!-- Table -->
                                        	<div class="table-responsive mt-3">
                                        		<table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                        			<thead>
		                                                <tr>
		                                                    <th class="wd-15p border-bottom-0">Actions</th>
		                                                    <th class="wd-15p border-bottom-0">Division</th>
		                                                    <th class="wd-15p border-bottom-0">Circle</th>
		                                                    <th class="wd-15p border-bottom-0">Region</th>
		                                                </tr>
		                                            </thead>
		                                            <tbody>
		                                            	<?php foreach ($divisions as $key => $value) { ?>
		                                            	<tr>
		                                            		<td>
		                                            			<a href="<?php echo base_url('edit-division/'.$value['division_id']); ?>" class="btn btn-sm">
		                                                            <span class="fe fe-edit fa-lg action-btn-table"></span>
		                                                        </a>&nbsp;&nbsp;
		                                                        <button  type="button" class="btn btn-sm deleteDivision" data-division-id="<?php echo $value['division_id']; ?>">
		                                                            <span class="fe fe-trash-2 fa-lg action-btn-table"></span>
		                                                        </button>
		                                            		</td>
		                                            		<td class="division-name"><?php echo $value['division_name']; ?></td>
		                                            		<td><?php echo $value['circle_name']; ?></td>
		                                            		<td><?php echo $value['region_name']; ?></td>
		                                            	</tr>	
		                                            	<?php } ?>
		                                            </tbody>
                                        		</table>
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
                <!-- App-Content Ends -->

        	</div>
        	<!-- Page Main Ends-->

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

        <script type="text/javascript">
        	$('.clear-search-filters').on('click', function(event) {
	            event.preventDefault();

	            $('.lab-value').find('ul').empty();
	            $('#headingOne').find('button').removeClass('filters-on');
	            $('#headingOne').find('button').removeAttr('style');

	            let search_form = $('#searchDivision')[0];

	            //Clearing all input[type=text] values
	            $(search_form).find('input.form-control:text').each(function() {
	                $(this).val('');
	            });

	            //Clearing all select values
	            $(search_form).find('.select2').each(function() {
	                $(this).val('select');
	                $(this).trigger('change');
	            });

	            $('#clear-btn').hide();

	            window.location.replace('<?php echo base_url("division") ?>');
	        });

	        $('.deleteDivision').click(function() {
	            let division_id = $(this).data('division-id');
	            let division_name = $(this).parent().next('.division-name').text();

	            let alert_text = 'Are you sure you want to delete '+ division_name +' Division ?';

	            $('#division-delete-alert').find('.notification-text').text(alert_text);
	            $('#division-delete-alert').find('.notification-delete').attr('data-division-id', division_id);
	            $('#division-delete-alert').removeAttr('hidden');
	        });

	        function deleteDivision(delete_btn) {
	        	let division_id = $(delete_btn).data('division-id');

	        	// Ajax call to delete the division
	        	$.ajax({
	                type: 'POST',
	                url: '<?php echo base_url('delete-division') ?>',
	                dataType: 'json',
	                data: {division_id:division_id},
	                success: function(response) {
	                    console.log(response); 

	                    $('#division-delete-alert').find('.notification-text').text('');
	                    $('#division-delete-alert').find('.notification-delete').attr('data-region-id', '');

	                    $('#division-delete-alert').attr('hidden', true);

	                    $('.toast-body').text('Division deleted successfully');
	                    $('.toast').toast('show');

	                    setTimeout(function() {
	                        location.reload(true)
	                    }, 3000);
	                }, 
	                error: function(xhr, status, error) {
	                    console.log(xhr.responseText);
	                }
	            });
	        }
        </script>

	</body>
</html>