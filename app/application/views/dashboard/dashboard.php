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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">
    <style type="text/css">
        .table tbody td
        {
            border-color: #c5c5c5 !important;       
        }
        
    </style>
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
                        <div class="page-header m-0 mb-2" style="border-bottom: 1px solid #ddd;">
                            <h1 class="page-title d-flex mt-2 mb-1" style="font-size: 17px; ">My Dashboard <p class="stat-lab mb-1">Statistics</p></h1>
                            <div class="btn-group d-flex" style=" position: absolute;  right: -15px; top: 5px;">
                                <h6 class="" style="margin-top: 5px; margin-right: 10px;"><strong>View As:</strong> </h6>
                                <p style="font-weight: bold;" class="list-ico"><a href="<?php echo base_url();?>statistics-table"><i class="fa fa-bars"></i></a></p>
                                <p class="list-ico"><a href="<?php echo base_url();?>statistics"><i class="fa fa-th-large for-card" style="color:  #20146a;"></i></a></p>
                                <div class="d-flex">
                                    <!--h6 class="" style="margin-top: 5px; margin-right: 10px; margin-left: 25px;"><strong>Filter By:</strong> </h6>
                                    <p style="font-weight: bold;" class="list-ico"><i class="fa fa-filter"></i></p-->
                                </div>
                            </div>
                            <div></div>
                        </div>
                        <!-- PAGE-HEADER END -->

                        <!-- ROW-2 -->
                        <div class="row">
                            <!-- Flash Alert -->
                            
                            <!-- <div class="alert alert-primary" role="alert"> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                <p style="color:green"><?php  echo $this->session->flashdata('success');?></p>
                            </div> -->
                            <div class="col-lg-6">
                                <?php  if($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert"> 
                                    <span class="alert-inner--icon">
                                        <i class="fe fe-thumbs-up"></i>
                                    </span> 
                                    <span class="alert-inner--text"><strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?></span> 
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> 
                                        <span aria-hidden="true">×</span> 
                                    </button> 
                                </div>
                                <?php } else if ($this->session->flashdata('error')) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                                        <span class="alert-inner--icon">
                                            <i class="fe fe-slash"></i>
                                        </span> 
                                        <span class="alert-inner--text"><strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?></span> 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> 
                                            <span aria-hidden="true">×</span> 
                                        </button> 
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- Flash Alert -->                            
                            

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                <div class="row">
                                    <?php foreach($statistics as $stats) { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3 out-box">
                                        <a onclick="showmodal('<?php echo $stats->package_no;?>', '<?php echo $stats->typeofwork;?>', '<?php echo $stats->contract_id;?>', <?php echo $stats->stage_id; ?>);">
                                            <div class="card  rounded-0">
                                                <div class="card-body p-1" style="    background: #f4f4f4;">
                                                    <div class="row main-box-start">
                                                        <div class="">
                                                            <p class=" fw-medium company-name text-truncate mb-2 mt-1">
                                                                <b><?php echo $stats->contractor_name;?></b></p>
                                                            <span class="badge badge-soft-danger fs-12"
                                                                style="background-color: #f79a48;"><?php echo 'Lot '.$stats->package_no;?></span>
                                                            <p class="box-with-company-name mb-0"></p>
                                                        </div>
                                                        <div class="col-sm-7 mt-1 first-col-data">
                                                            <div class=" align-items-center mb-2">
                                                                <div class="field-col">
                                                                    <p class="mb-0 value-lable">Type of Work</p>
                                                                    <h4 class=" flex-grow-1 mb-0 value-with-text text-man ">
                                                                        <span class="counter-value"><span><?php echo $stats->typeofwork;?>
                                                                    </h4>
                                                                </div>
                                                                <div class="field-col mt-2">
                                                                    <p class="mb-0 value-lable">Award Date</p>
                                                                    <h4 class=" flex-grow-1 mb-0 value-with-text text-man">
                                                                        <span class="counter-value"><span><?php echo date('d-m-Y', strtotime($stats->contract_date));?>
                                                                    </h4>
                                                                </div>
                                                                <div class="field-col mt-2">
                                                                    <p class="mb-0 value-lable">Contract Value</p>
                                                                    <h4 class=" flex-grow-1 mb-0 value-with-text text-man">
                                                                        <span class="counter-value"><span>Rs. <?php echo $stats->contract_value;?>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5 p-0 mt-1 secound-col-data">
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <div class=" align-items-center mb-2">
                                                                    <div class="field-col">
                                                                        <p class="mb-0 value-lable">Stage <?php echo $stats->stage_id;?>-Target Date
                                                                        </p>
                                                                        <h4 class=" flex-grow-1 mb-0 value-with-text text-man">
                                                                            <?php if($stats->target_date=="")
                                                                            { ?>

                                                                                    <span class="counter-value">--</span>

                                                                          <?php } else { ?>      
                                                                            <span class="counter-value"><span><?php echo date('d-m-Y', strtotime($stats->target_date));?>
                                                                        <?php } ?>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="field-col mt-2">
                                                                        <p class="mb-0 value-lable">Stage <?php echo $stats->stage_id;?>-Value</p>
                                                                        <h4 class=" flex-grow-1 mb-0 value-with-text text-man">
                                                                            <span class="counter-value"><span>Rs. <?php echo $stats->target_value;?>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="field-col mt-2">
                                                                        <p class="mb-0 value-lable">Payment Disbursed
                                                                        </p>
                                                                        <h4 class=" flex-grow-1 mb-0 value-with-text text-man">
                                                                            <span class="counter-value"><span>Rs. <?php echo $stats->payment_disbursed_amount;?> <span
                                                                                        class="payment-disbursed-value">
                                                                                        <?php echo $stats->payment_disbursed_percent;?>%</span>
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4 class="text-center mb-0 prog-per" style="color: #ffc824;"><?php echo $stats->physical_progress;?>%</h4>
                                                            <progress class="prog1" id="file" value="<?php echo $stats->physical_progress;?>" max="100"> </progress>
                                                            <div class="bottom-progress">
                                                                <p class="mb-1" style="float: left; margin-top: -4px;font-size: 9px;">Physical Progress</p>
                                                                <p class="left-date"><i class="fa fa-clock-o"></i> <?php echo $stats->days_left;?> Days Left</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4 class="text-center mb-0 prog-per" style="color: #ffc824;"><?php echo $stats->financial_physical_progress;?> </h4>
                                                            <?php $explode = explode(" ", $stats->financial_physical_progress);?>
                                                            <progress class="prog1" id="file" value="<?php echo $explode[0];?>" max="100"> </progress>
                                                            <div class="bottom-progress">
                                                                <p class="mb-1" style="float: right; margin-top: -4px;font-size: 9px;">Financial Progress</p>
                                                               <!--  <p class="left-date"><i class="fa fa-clock-o"></i> <?php echo $stats->days_left;?> Days Left</p> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                                 
                                </div>



                             
                            </div>
                        </div>
                        <!-- ROW-2 END -->

                        <!-- Observation List Modal -->
                        <div class="modal fade" id="obs_list_modal" data-bs-backdrop="static" aria-hidden="true"
                            aria-labelledby="obs_list_modalLabel" tabindex="-1" style="display: none;"
                            data-bs-focus="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="obs_list_modalLabel"
                                            style="font-family: 'Poppins', sans-serif;"><strong>Physical Achievement -
                                                <span id="psa"></span></strong></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" onclick="findtr()">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
									<div id="loadpopup_body"></div>
                                    <?php foreach($statistics as $stats) { ?>
                                    <div class="tohide row" style="display: none;" id="tohide<?php echo $stats->package_no;?>">
                                        <div class="col-lg-6 col-md-12" id="physical-graph-div">
                                            <div class="card" >
                                                <div class="card-header">
                                                    <h3 class="card-title"><?php echo $stats->package_no;?> - Physical Progress</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <!-- <canvas id="pp<?php //echo $stats->contract_id;?>" class="h-275"></canvas> -->
                                                        <canvas id="pp<?php echo $stats->package_no;?>" class="h-275"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12" id="financial-graph-div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title"><?php echo $stats->package_no?> - Financial Progress</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <!-- <canvas id="fd<?php //echo $stats->contract_id;?>" class="h-275"></canvas> -->
                                                        <canvas id="fd<?php echo $stats->package_no;?>" class="h-275"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>




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
 <!--    <script src="<?php echo base_url('assets/plugins/charts-c3/d3.v5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/charts-c3/c3-chart.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/charts.js'); ?>"></script> -->

    <!-- PIETY CHART JS-->
    <script src="<?php echo base_url('assets/plugins/peitychart/jquery.peity.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/peitychart/peitychart.init.js'); ?>"></script>

    <!-- SIDEBAR JS -->
    <script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js'); ?>"></script>

     <!-- ECHART JS -->
<!--     <script src="<?php echo base_url('assets/js/echarts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/echarts/echarts.js'); ?>"></script> -->


    <!-- Perfect SCROLLBAR JS-->
    <script src="<?php echo base_url('assets/plugins/p-scroll/perfect-scrollbar.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll-1.js'); ?>"></script>

    <!-- INTERNAL CHARTJS CHART JS-->
    <script src="<?php echo base_url('assets/plugins/chart/Chart.bundle.js'); ?>"></script>
       <!-- <script src="<?php echo base_url('assets/js/chart.js'); ?>"></script> -->
       <script src="<?php echo base_url('assets/js/bar-chart-custom.js'); ?>"></script>
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
	
	<script>
			var baseUrl = "<?php echo base_url(); ?>";
            var baseDate = "<?php echo date("Y-m-d");?>";
			</script>

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
        $(document).click(function() {
            // alert('click');
            var list_view = $('#list-view');
            if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                list_view.hide();
            }
        });
		
		
		function showmodal(package_no, typeofwork, contractId, stage_id)
		{
            // console.log(package_no);  return false;
            $("#psa").html(typeofwork);
            // linechart(contractId);
            // linechart(package_no);
            linechart(package_no, stage_id);
            // return false;
            // var package = package_no.split(' ');

            // console.log(baseUrl+"statistics-popup/"+package_no+"/"+contractId);
			$.ajax({
                // url: baseUrl+"statistics-popup/"+package[1]+"/"+contractId, //Original
                // url: baseUrl+"statistics-popup/"+package_no+"/"+contractId, 
                url: baseUrl+"statistics-popup/"+package_no+"/"+stage_id,
                success: function(result)
                {
    			    $("#loadpopup_body").empty();
    				$("#loadpopup_body").html(result);
    				$("#obs_list_modal").modal("show");
			    }
            });
		}

        function changeweekMonthVal(dateValue)
        {
            // console.log('dateValue:' + dateValue);
            var package_no = $("#packageNo").val();
            // var contract_id = $("#contractId").val();
            var stageValue = $("#stageChange").val();
            //alert(package_no);

            // console.log('package_no: '+ package_no);
            // console.log('contract_id: '+ contract_id);
            // console.log('stageValue: '+ stageValue);
            // return false;

            if(dateValue=="week")
            {
                $.ajax({
                    // url: baseUrl+"changeweekmonthval/"+dateValue+"/"+package_no+"/"+"/"+contract_id+"/"+stageValue, /*Original Code*/
                    url: baseUrl+"changeweekmonthval/"+dateValue+"/"+package_no+"/"+stageValue,
                    success: function(result) {
                        // console.log(result); return false;
                        $("#weekMonthChange").empty();
                        $("#weekMonthChange").html(result);
                    }
                });
            }

            if(dateValue=="month")
            {
                $("#weekMonthChange").empty();
                $.ajax({
                    // url: baseUrl+"getweekdate/"+contract_id+"/"+stageValue,  /*Original Code*/
                    url: baseUrl+"getweekdate/"+package_no+"/"+stageValue, 
                    success: function(result) {
                        // console.log(result);
                        var res = JSON.parse(result);
                        //console.log("res="+res[0].contract_start_date);
                        var min = res[0].contract_start_date;
                        var max = res[0].stage_date;
                        $("#weekMonthChange").html('<input type="date" name="monthdate" id="monthdate" onchange="selectdate(this.value)" value="'+max+'" min="'+min+'" max="'+max+'"/>');
                    }
                });

                /*  $("#weekMonthChange").html('<input type="date" name="monthdate" id="monthdate" onchange="selectdate(this.value)" value="'+baseDate+'" min="2023-01-01" max="2023-12-31"/>');*/
            }
        }

        function changeStage(stageValue, package_no)
        {
            console.log('stageValue: ' + stageValue); 
            let stage_arr = stageValue.split(' ');
            var weekmonthselect = $("#weekmonthselect").val();
            if(weekmonthselect=="week" || weekmonthselect=="month")
            {
                /*var package_no = $("#packageNo").val();
                $.ajax({url: baseUrl+"change-stage/"+stageValue+"/"+package_no, success: function(result){
                // $.ajax({
                    url: baseUrl+"statistics-popup/"+package_no, 
                    success: function(result){
                        $("#loadpopup_body").empty();
                        $("#loadpopup_body").html(result);
                        $("#obs_list_modal").modal("show");
                    }});*/
                changeweekMonthVal(weekmonthselect);
            }

            setTimeout(formhtmltable, 1000);
            setTimeout(function() {
                linechart(package_no, stage_arr[1]);
            }, 2000);
        }

        function selectdate(dateValue)
        {
            formhtmltable();
        }

        function weekdatedropdown()
        {            
            formhtmltable();
        }

        function formhtmltable()
        {
            var stageValue = $("#stageChange").val();
            var weekmonthselect = $("#weekmonthselect").val();
            var monthdate = $("#monthdate").val();
            var weekdatedropdown = $("#weekdatedropdown").val();
            var package_no = $("#packageNo").val();

            var data = {};
            data.stageValue = stageValue;
            data.weekmonthselect = weekmonthselect;
            data.monthdate = monthdate;
            data.weekdatedropdown = weekdatedropdown;
            data.packageno = package_no;
            $("#showvalues").empty();
            $("#showvalues").append("<center>Please wait...</center>");
            
            $.ajax({
                type: "POST",
                url: baseUrl+"formhtmltable",
                //data: {name: 'John'},
                data: data,
                success: function(data){                
                    $("#showvalues").html(data);
                },
                error: function(xhr, status, error){
                    console.error(xhr);
                }
            });
        }

        // function weekdatedropdownload(contractId, stage) /*Original Code*/
        function weekdatedropdownload(packageNo, stage)
        {  
            $.ajax({
                type: "GET",
                // url: baseUrl+"weekdatedropdownload/"+contractId+"/"+stage, /*Original Code*/
                url: baseUrl+"weekdatedropdownload/"+packageNo+"/"+stage,
                //data: {name: 'John'},
                //data: data,
                success: function(data) {
                    $("#weekMonthChange").empty();
                    $("#weekMonthChange").html(data);
                },
                error: function(xhr, status, error){
                    console.error(xhr);
                }
            });
        }
    </script>

</body>

</html>