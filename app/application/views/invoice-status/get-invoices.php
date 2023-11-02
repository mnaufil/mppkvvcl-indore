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
        
        <!-- DATERANGE PICKER CSS -->
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
                <!-- App-Sidebar Ends-->

                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                    <div class="side-app">
                        
                        <!-- Container -->
                        <div class="main-container container-fluid">

                            <!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title"><?php echo $title; ?></h1>
                            </div>
                            <!-- Page-Header Ends-->

                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">

                                        <!-- <form> -->
                                            <div class="card-body mt-3">
                                                <!-- Row1 -->
                                                <div class="form-row">
                                                    <!-- Contractor (TKC) -->
                                                    <div class="col-xl-6 mb-3">
                                                        <label class="form-label" for="contractorTKC">Contractor (TKC)</label>
                                                        <input class="form-control" type="text" name="contractorTKC" id="contractorTKC" value="<?php echo $invoice_details['contractor_name']; ?>" readonly>
                                                    </div>
                                                    <!-- Contract No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="contractNo">Contract No.</label>
                                                        <input class="form-control" type="text" name="contractNo" id="contractNo" value="<?php echo $invoice_details['tender_award_no']; ?>" readonly>
                                                    </div>
                                                    <!-- Contract Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="contractDate">Contract Date</label>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input class="form-control" type="text" name="contractDate" id="contractDate" value="<?php echo $invoice_details['tender_award_date']; ?>" readonly disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row2 -->
                                                <div class="form-row">
                                                    <!-- DISCOM -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="discom">DISCOM</label>
                                                        <input class="form-control" type="text" name="discom" id="discom" value="<?php echo $invoice_details['discom']; ?>" readonly>
                                                    </div>
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="typeOfWork">Type Of Work</label>
                                                        <!-- <select class="form-control select2" id="typeOfWork">
                                                            <option value="select" disabled>Select Type Of Work</option>
                                                            <option value="capacitorBank" selected>Capacitor Bank</option>
                                                            <option value="33KV/11KVNewSubstation">33 KV / 11 KV New Substation</option>
                                                            <option value="11KVFeederSeparation">11 KV Feeder Separation</option>
                                                            <option value="33KVInterconnectionLine">33 KV Interconnection Line</option>
                                                            <option value="11KVInterconnectionLine">11 KV Interconnection Line</option>
                                                            <option value="LTLine/LTCabling">LT Line / LT Cabling</option>
                                                        </select> -->
                                                        <input class="form-control" type="text" name="typeOfWork" id="typeOfWork" value="<?php echo $invoice_details['typeofwork_name']; ?>" readonly>
                                                    </div>
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="contractAmount">Contract Amount</label>
                                                        <input class="form-control" type="text" name="contractAmount" id="contractAmount" value="<?php echo '&#8377;'.number_format($invoice_details['contract_amount'], 2); ?>" readonly>
                                                    </div>
                                                </div>
                                                <!-- Row3 -->
                                                <!-- Table -->
                                                <div class="table-responsive">
                                                    <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No.</th>
                                                                <th>Month</th>
                                                                <th>DI No. / EMB No.</th>
                                                                <th>Invoice No</th>
                                                                <th>Invoice Date</th>
                                                                <th>Type Of Invoice</th>
                                                                <th>Invoice Amount</th>
                                                                <th>Payable Amount</th>
                                                                <th>Progressive Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($invoice_details['invoice_data'] as $key => $value) { ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo ++$key; ?></td>
                                                                <td style="text-align: center;"><?php echo $value['invoice_month']; ?></td>
                                                                <td style="text-align: center;"><?php echo $value['di_emb_no']; ?></td>
                                                                <td style="text-align: center;"><?php echo $value['invoice_no']; ?></td>
                                                                <td style="text-align: center;"><?php echo $value['invoice_date']; ?></td>
                                                                <td style="text-align: center;"><?php echo $value['invoice_type']; ?></td>
                                                                <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['invoice_amount_with_gst'], 2); ?></td>
                                                                <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['payable_amount'], 2); ?></td>
                                                                <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['progressive_amount'], 2); ?></td>
                                                            </tr>    
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-3 mt-5">
                                                        <a href="<?php echo base_url('edit-invoice/'.$invoice_details['invoice_id']); ?>" type="button" class="btn btn-primary">Back</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- </form> -->
                                    </div>
                                </div>
                            </div>
                            <!-- Row Ends -->
                            
                        </div>
                        <!-- Container Ends-->

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
        <script src="<?php //echo base_url('assets/plugins/input-mask/jquery.mask.min.js'); ?>"></script>

        <!-- TypeHead js -->
        <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

        <!-- SELECT2 JS -->
        <script src="<?php //echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

        <!-- FORMVALIDATION JS -->
        <!-- <script src="assets/js/form-validation.js"></script> -->

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

        <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>        

    </body>
</html>