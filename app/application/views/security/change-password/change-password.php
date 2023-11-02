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

                <!-- App-Sidebar Ends -->
                <?php $this->load->view('include/side-bar');?>
                <!-- App-Sidebar Ends -->

                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                    <div class="side-app">

                        <!-- Container -->
                        <div class="main-container container-fluid">

                            <!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title">Change Password</h1>
                                <!-- <div>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                                    </ol>
                                </div> -->
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <!-- <div class="card-header">
                                            <h3 class="card-title">Change Password</h3>
                                        </div> -->
                                        <div class="card-body p-2">
                                            <!-- <form class="needs-validation" novalidate> -->
                                            <form id="changePassword" method="post" action="<?php echo base_url('save-change-password'); ?>">
                                                <div class="form-row">
                                                    <div class="col-xl-4 mb-3">
                                                        <label class="form-label" for="newPassword">New Password
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                                                    </div>
                                                    <div class="col-xl-4 mb-3">
                                                        <label class="form-label" for="reTypePassword">Re-Type Password
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" id="reTypePassword" name="reTypePassword">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary mb-3" type="submit">Change Password</button>
                                            </form>
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
        <!-- <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
        <script src="assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
        <script src="assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
        <script src="assets/plugins/datatable/js/buttons.php5.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
        <script src="assets/js/table-data.js"></script> -->

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

        <script type="text/javascript">
            $('#changePassword').submit(function(event) {
                let new_password = $('input[name="newPassword"]').val();
                console.log('new_password:' + new_password);

                let retype_password = $('input[name="reTypePassword"]').val();
                console.log('retype_password:' + retype_password);

                if (new_password == '' && retype_password == '') {
                    $('.toast-body').text('Enter values for New Password and Re-Type Password');
                    $('.toast').toast('show');

                    event.preventDefault();
                }

                if (new_password == '') {
                    $('.toast-body').text('Enter value for New Password');
                    $('.toast').toast('show');

                    event.preventDefault();
                }

                if (retype_password == '') {
                    $('.toast-body').text('Enter value for Re-Type Password');
                    $('.toast').toast('show');

                    event.preventDefault();
                }

                if (new_password != '' && retype_password != '' && new_password !== retype_password) {
                    $('.toast-body').text('Password values do not match');
                    $('.toast').toast('show');

                    event.preventDefault();
                }
            });
        </script>

    </body>

</html>