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
        <title>MPPKVVCL - Type Of Work</title>

        <!-- BOOTSTRAP CSS -->
        <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">

        <!-- STYLE CSS -->
         <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/css/plugins.css'); ?>" rel="stylesheet">

        <!--- FONT-ICONS CSS -->
        <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet">

        <!-- INTERNAL Switcher css -->
        <link href="<?php echo base_url('assets/switcher/css/switcher.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/switcher/demo.css'); ?>" rel="stylesheet">

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
                                <h1 class="page-title">Type of Work</h1>
                                <div class="row">
                                    <div class="col-md-12 mt-2 mb-3">
                                        <a  href="<?php echo base_url('add-typeofwork'); ?>" class="btn btn-success btn-add">Add </a>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->

                             <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body mt-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p border-bottom-0">Actions</th>
                                                            <th class="wd-15p border-bottom-0">Type Of Work</th>
                                                            <th class="wd-20p border-bottom-0">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo base_url('edit-typeofwork'); ?>" class="btn btn-sm">
                                                                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                                                                </a>&nbsp;&nbsp;
                                                                <button  type="button" class="btn btn-sm" id='deletecompany'>
                                                                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                </button>
                                                            </td>
                                                            <td>Capacitor Bank </td>
                                                            <td>Active </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo base_url('edit-typeofwork'); ?>" class="btn btn-sm">
                                                                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                                                                </a>&nbsp;&nbsp;
                                                                <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                </button>
                                                            </td>
                                                            <td>33 KV / 11 KV New Substation</td>
                                                            <td>Active </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo base_url('edit-typeofwork'); ?>" class="btn btn-sm">
                                                                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                                                                </a>&nbsp;&nbsp;
                                                                <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                </button>
                                                            </td>
                                                            <td>11 KV Feeder Separation </td>
                                                            <td>Active </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo base_url('edit-typeofwork'); ?>" class="btn btn-sm">
                                                                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                                                                </a>&nbsp;&nbsp;
                                                                <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                </button>
                                                            </td>
                                                            <td>11 KV Interconnection Line / LT AB Cabling</td>
                                                            <td>Active </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a href="<?php echo base_url('edit-typeofwork'); ?>" class="btn btn-sm">
                                                                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                                                                </a>&nbsp;&nbsp;
                                                                <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                </button>
                                                            </td>
                                                            <td>33 KV Interconnection Line</td>
                                                            <td>Active </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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