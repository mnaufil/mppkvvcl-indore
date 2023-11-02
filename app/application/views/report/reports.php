<!doctype html>
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
        <title>MPPKVVCL - Reports</title>

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

                <!--app-content open-->
                <div class="main-content app-content mt-0">
                    <div class="side-app">

                        <!-- CONTAINER -->
                        <div class="main-container container-fluid">

                            <!-- PAGE-HEADER -->
                            <div class="page-header">
                                <h1 class="page-title">Reports</h1>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body mt-3 mb-3">
                                            <div class="table-responsive">
                                                <div class="card-body">
                                                    <div class=""> 
                                                        <ul class="list-group"> 
                                                            <!-- <a href="view-report.php">1. 33/11 kv New Sub-Station</a> -->
                                                            <?php if (in_array('Physical Progress', $report_list)) { ?>
                                                            <li class="list-group-item">
                                                                <a href="<?php echo base_url('view-report'); ?>"><i class="ti ti-player-record-filled"></i> Physical Progress</a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Non Conformance Report', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('non-conformance-report'); ?>"><i class="ti ti-player-record-filled"></i> Non Conformance Report</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Contract Summary', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('contract-summary-report'); ?>"><i class="ti ti-player-record-filled"></i> Contract Summary</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('BG Summary', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('bg-summary-report'); ?>"><i class="ti ti-player-record-filled"></i> BG Summary</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Mobilisation Summary', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('mobilisation-summary-report'); ?>"><i class="ti ti-player-record-filled"></i> Mobilisation Summary</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Cash Flow', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('cash-flow-report'); ?>"><i class="ti ti-player-record-filled"></i> Cash Flow</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Material Status Report', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('material-status-report'); ?>"><i class="ti ti-player-record-filled"></i> Material Status Report</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Material Status Summary', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('material-status-summary'); ?>"><i class="ti ti-player-record-filled"></i> Material Status Summary</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Visit  Report', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('visit-report');?>"><i class="ti ti-player-record-filled"></i> Visit  Report</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('NCR Data', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('ncr-report');?>"><i class="ti ti-player-record-filled"></i> NCR Data</a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if (in_array('Updated Position of Invoicing and Payment', $report_list)) { ?>
                                                                <li class="list-group-item">
                                                                    <a href="<?php echo base_url('invoicing-payment-report');?>"><i class="ti ti-player-record-filled"></i> Updated Position of Invoicing and Payment</a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->

                        </div>
                        <!-- CONTAINER CLOSED -->

                    </div>
                </div>
                <!--app-content closed-->

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
       
        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>
        
    </body>
</html>