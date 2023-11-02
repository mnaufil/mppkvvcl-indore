
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
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico">

    <!-- TITLE -->
    <title>MPPKVVCL - Dashboard Statistics</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">

    <!-- STYLE CSS -->
     <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet">
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
            <div class="main-content app-content mt-0" style="background-color: #f4f4f4;">
                <div class="side-app" style="padding: 0px 0px 0 0px; ">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">

                        <!-- PAGE-HEADER -->
                        <div class="page-header m-0 mb-2" >
                            <h1 class="page-title d-flex mt-2 mb-1" style="font-size: 17px; ">My Dashboard <p class="stat-lab mb-1">Statistics</p></h1>
                            <div class="btn-group d-flex" style=" position: absolute;  right: -15px; top: 5px;">
                                <h6 class="" style="margin-top: 5px; margin-right: 10px;"><strong>View As:</strong> </h6>
                                <p style="font-weight: bold;" class="list-ico"><a href="<?php echo base_url();?>statistics-table"><i class="fa fa-bars" style="color:  #20146a;"></i></a></p>
                                <p class="list-ico"><a href="<?php echo base_url();?>statistics"><i class="fa fa-th-large for-card"></i></a></p>
                                <!--div class="d-flex">
                                    <h6 class="" style="margin-top: 5px; margin-right: 10px; margin-left: 25px;"><strong>Filter By:</strong> </h6>
                                <p style="font-weight: bold;" class="list-ico"><i class="fa fa-filter"></i></p>
                                </div-->
                            </div>
                            <div>
                            </div>
                        </div>
                        <!-- PAGE-HEADER END -->


                        <!-- ROW-2 -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                             <div class="row">
                                <div class="p-3" style="background-color:#fff">
                                     <div class="table-responsive">
                                                <table class="table table-bordered border text-nowrap mb-0 teble-th-left mb-2">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Package</th>
                                                        <th>TKC</th>
                                                        <th class="text-left" style="width:200px; text-align: left;">Type of Work</th>
                                                        <th class="text-center">Award Date</th>
                                                        <th class="text-center">Contract Value</th>
                                                        <th class="text-center">Stage</th>
                                                        <th class="text-center">Target Date</th>
                                                        <th class="text-center">Value</th>
                                                        <th colspan="2" class="text-center">Payment Disbursed</th>
                                                        <th class="text-center">Physical Progress</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php $i=0; foreach($statistics as $stats) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $stats->package_no;?></td>
                                                        <td><?php echo $stats->contractor_name;?></td>
                                                        <td><?php echo $stats->typeofwork;?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($stats->contract_date));?></td>
                                                        <td class="text-center">Rs. <?php echo $stats->contract_value;?></td>
                                                        <td class="text-center"><?php echo $stats->stage_id;?></td>
                                                        <td class="text-center">

                                                            <?php
                                                            if($stats->target_date=="")
                                                            {
                                                                echo '--';
                                                            }
                                                            else {
                                                             echo date('d-m-Y', strtotime($stats->target_date));
                                                            
                                                            }
                                                                ?>

                                                            </td>
                                                        <td class="text-center">Rs. <?php echo $stats->target_value;?></td>
                                                        <td class="text-center">Rs. <?php echo $stats->payment_disbursed_amount;?> </td>
                                                        <td class="text-center"> <?php echo $stats->payment_disbursed_percent;?> %</td>
                                                        <td class="text-center"> <?php echo $stats->physical_progress;?> %</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> <?php echo $stats->days_left;?> Days Left</p>
                                                        </td>
                                                    </tr>

                                                     <?php } ?>
                                                    <!-- <tr>
                                                        <td class="text-center">2</td>
                                                        <td> M/s UMEP, Mumbai</td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td> M/s AK Infra, Gaziabad </td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td> M/s AK Infra, Gaziabad </td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td> M/s AK Infra, Gaziabad </td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td> M/s AK Infra, Gaziabad </td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>M/s Shreem Electric</td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>M/s Shreem Electric</td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>M/s Shreem Electric</td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>M/s Shreem Electric</td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>M/s Shreem Electric</td>
                                                        <td>Capacitor Bank (589)</td>
                                                        <td class="text-center">02/09/2022</td>
                                                        <td class="text-center">Rs. 84.44 Cr</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">30.07.2023</td>
                                                        <td class="text-center">Rs. 25.45 Cr</td>
                                                        <td class="text-center">Rs. 10.50 Cr</td>
                                                        <td class="text-center">41%</td>
                                                        <td class="text-center">70%</td>
                                                        <td>
                                                            <p class="left-date-grid mb-0"><i class="fa fa-clock-o"></i> 55 Days Left</p>
                                                        </td>
                                                    </tr> -->
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                                                    <!-- ROW-2 END -->

                        <!-- Observation List Modal -->
                        <div class="modal fade" id="obs_list_modal" data-bs-backdrop="static" aria-hidden="true"
                            aria-labelledby="obs_list_modalLabel" tabindex="-1" style="display: none;"
                            data-bs-focus="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="obs_list_modalLabel"
                                            style="font-family: 'Poppins', sans-serif;"><strong>Physical Achievement -
                                                Capacitor Bank</strong></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" onclick="findtr()">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Show a second modal and hide this one with the button below. -->
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered border text-nowrap mb-0 table-striped change-font"
                                                id="new-edit-observations-details">
                                                <thead>
                                                    <tr style="background: #eee;">
                                                        <th style="text-align: left !important;">Scheme Name</th>
                                                        <th style="text-align: left !important;">RDSS</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>DISCOM</td>
                                                        <td>MPPKVVCL, Jabalpur</td>
                                                        <td>Observation 1</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>TKC</td>
                                                        <td>M/s Shreem Electric</td>
                                                        <td>Observation 1</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Award No</td>
                                                        <td>480 dated 02.09.2022</td>
                                                        <td>Contract Value</td>
                                                        <td>844467204</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Milestone 1 / All</td>
                                                        <td>01.06.2023</td>
                                                        <td># Feeders/SS</td>
                                                        <td>589</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Week/Month</td>
                                                        <td>05.05.2023 - 11.05.2023 / Apr 23</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive mt-4">
                                            <table class="table table-bordered border text-nowrap mb-0 change-font"
                                                id="new-edit-observations-details">
                                                <thead>
                                                    <tr style="background: #eee;">
                                                        <th>Milestone</th>
                                                        <th colspan="3">Weekly/Month</th>
                                                        <th colspan="3">Cummulative</th>
                                                        <th>Slippage (%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>M1</td>
                                                        <td>Foundation</td>
                                                        <td>Equipment</td>
                                                        <td>Commissioning</td>
                                                        <td>Foundation</td>
                                                        <td>Equipment</td>
                                                        <td>Commissioning</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>148</td>
                                                        <td>5</td>
                                                        <td>8</td>
                                                        <td>4</td>
                                                        <td>60(40%)</td>
                                                        <td>54(35%)</td>
                                                        <td>38(25%)</td>
                                                        <td>20</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-1">
                                        <!-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> -->
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"
                                            onclick="findtr()">Close</button>
                                        <!-- <button class="btn btn-primary">Save</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Observation List Modal Ends -->

                        <!-- ROW-4 END -->
                    </div>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->

        </div>

        
       <?php $this->load->view('include/footer');?>

        <!-- FOOTER END -->
        <!-- BACK-TO-TOP -->
         <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JQUERY JS -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

    <!-- BOOTSTRAP JS -->
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- INPUT MASK JS-->
    <script src="<?php echo base_url('assets/plugins/input-mask/jquery.mask.min.js'); ?>"></script>

    <!-- SPARKLINE JS-->
    <script src="<?php echo base_url('assets/js/jquery.sparkline.min.js'); ?>"></script>

    <!-- Sticky js -->
    <script src="<?php echo base_url('assets/js/sticky.js'); ?>"></script>

    <!-- CHART-CIRCLE JS-->
    <script src="<?php echo base_url('assets/js/circle-progress.min.js'); ?>"></script>

    <!-- CHART-LINE JS -->
    <script src="<?php echo base_url('assets/plugins/charts-c3/d3.v5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/charts-c3/c3-chart.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/charts.js'); ?>"></script>

    <!-- PIETY CHART JS-->
    <script src="<?php echo base_url('assets/plugins/peitychart/jquery.peity.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/peitychart/peitychart.init.js'); ?>"></script>

    <!-- SIDEBAR JS -->
    <script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js'); ?>"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="<?php echo base_url('assets/plugins/p-scroll/perfect-scrollbar.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll-1.js'); ?>"></script>

    <!-- INTERNAL CHARTJS CHART JS-->
    <script src="<?php echo base_url('assets/plugins/chart/Chart.bundle.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/chart/utils.js'); ?>"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

    <!-- FORMVALIDATION JS -->
    <script src="<?php echo base_url('assets/js/form-validation.js'); ?>"></script>

    <!-- INTERNAL Data tables js-->
    <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>

    <!-- INTERNAL APEXCHART JS -->
    <script src="<?php echo base_url('assets/js/apexcharts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/apexchart/irregular-data-series.js'); ?>"></script>

    <!-- INTERNAL Flot JS -->
    <script src="<?php echo base_url('assets/plugins/flot/jquery.flot.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/flot/jquery.flot.fillbetween.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/flot/chart.flot.sampledata.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/flot/dashboard.sampledata.js'); ?>"></script>

    <!-- INTERNAL Vector js -->
    <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>

    <!-- SIDE-MENU JS-->
    <script src="<?php echo base_url('assets/plugins/sidemenu/sidemenu.js'); ?>"></script>

    <!-- TypeHead js -->
    <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

    <!-- INTERNAL INDEX JS -->
    <script src="<?php echo base_url('assets/js/index1.js'); ?>"></script>

    <!-- Color Theme js -->
    <script src="<?php echo base_url('assets/js/themeColors.js'); ?>"></script>

    <!-- CUSTOM JS -->
    <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

    <!-- Custom-switcher -->
    <script src="<?php echo base_url('assets/js/custom-swicher.js'); ?>"></script>

    <!-- Switcher js -->
    <script src="<?php echo base_url('assets/switcher/js/switcher.js'); ?>"></script>

        <script type="text/javascript">
            //Displays contractor search list view
            function showtkc(tkcValue) {
                $('#list-view').show();
                if (tkcValue !== '') {
                    var html = '';
                    $('#list-view').empty();

                    for (var i = 0; i < 3; i++) {
                        html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start ">';
                        html += '<div class="d-flex w-100 justify-content-between">';
                        html += '<h4 class="mb-1"><strong>M/s Shreem Capcitor</strong></h4>';
                        html += '<small class="text-muted">Award Date : <span class="text-primary"> 25-09-2023</span></small>';
                        html += '</div>';
                        html += '<p class="mb-1">Type Of Work: <span class="text-primary"> Capacitor Bank</span></p>';
                        html += '<small class="text-muted">Award No: <span class="text-primary">483</span></small>';
                        html += '</a>';
                    }

                    $('#list-view').append(html);
                } else {
                    $('#list-view').empty();
                }
            }

            //Closes the contractor search list view on document click
            $(document).click(function () {
                // alert('click');
                var list_view = $('#list-view');
                if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                    list_view.hide();
                }
            });
        </script>

</body>

</html>