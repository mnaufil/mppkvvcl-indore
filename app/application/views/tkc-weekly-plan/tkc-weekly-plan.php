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
                				<h1 class="page-title">TKC Weekly Plan</h1>
                				<div class="row">
                                    <div class="col-md-12 mt-2 mb-3">
                                        <a  href="<?php echo base_url('add-tkc-weekly-plan'); ?>" class="btn btn-success btn-add">Add </a>
                                    </div>
                                </div>
                			</div>
                			<!-- Page Header Ends -->

                			<!-- Row -->
                			<div class="row row-sm">
                				<div class="col-lg-12">
                					<div class="card">
                						<div class="card-body mt-3">
                							<div class="table-responsive">
                								<div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" id="basic-datatable" role="grid" aria-describedby="basic-datatable_info">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th class="wd-10p border-bottom-0" tabindex="0" aria-controls="basic-datatable" rowspan="1" colspan="1"style="width: 95.5156px;">Actions</th>
                                                                        <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Date Range: activate to sort column descending" style="width: 95.5156px;">Date Range</th>
                                                                        <th class="wd-15p border-bottom-0 sorting" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Lot No.: activate to sort column descending" style="width: 88.5469px;">Lot No.</th>
                                                                        <th class="wd-25p border-bottom-0 sorting" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contractor(TKC): activate to sort column ascending" style="width: 178.531px;">Contractor(TKC)</th>
                                                                        <th class="wd-25p border-bottom-0 sorting" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 92.5312px;">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($result as $key => $value) { ?>
                                                                    <tr>
                                                                        <?php $mode = ($value['is_draft'] == '0') ? 'view' : 'edit'; ?>
                                                                        <!-- Action Buttons -->
                                                                        <td name="bstable-actions">
                                                                            <div class="btn-list">
                                                                            <?php if (!empty($user_access) && (isset($user_access['view']) || isset($user_access['update']))) { ?>
                                                                                <a id="bView" type="button" class="btn btn-sm" href="<?php echo base_url('edit-tkc-weekly-plan/'.$mode.'/'.$value['tkc_plan_id']); ?>">
                                                                                    <span class="<?php echo ($mode == 'view') ? 'fa fa-eye' : 'fe fe-edit'; ?> fa-lg action-btn-table"></span>
                                                                                </a>
                                                                            <?php } ?>
                                                                            </div>
                                                                        </td>
                                                                        <!-- Date Range -->
                                                                        <td style="text-align: center;">
                                                                            <?php echo $value['date_range']; ?>
                                                                        </td>
                                                                        <!-- Lot No. -->
                                                                        <td style="text-align: center;">
                                                                            <?php echo $value['lot_no']; ?>
                                                                        </td>
                                                                        <!-- Contractor (TKC) -->
                                                                        <td style="text-align: center;">
                                                                            <?php echo $value['contractor_name']; ?>
                                                                        </td>
                                                                        <!-- Status -->
                                                                        <td style="text-align: center;">
                                                                            <?php   if ($value['draft_status'] == 'Draft') {
                                                                                        $text_color = 'text-yellow';
                                                                                    } else {
                                                                                        $text_color = 'text-green';
                                                                                    }
                                                                            ?>
                                                                            <h5 class="<?php echo $text_color; ?> text-status">
                                                                                <?php echo $value['draft_status']; ?>
                                                                            </h5>
                                                                        </td>
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
                		<!-- Container Ends -->

                	</div>
                </div>
                <!-- App Content Ends -->

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
        <script src="<?php  echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
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
	</body>
</html>