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
        <title>MPPKVVCL - Dashboard</title>

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
                                <h1 class="page-title">Dashboard</h1>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW-1 -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form name="filter_dashboard" id="filter-dashboard">
                                                        <div class="form-row">
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" for="region">Region</label>
                                                                <select class="form-control select2 select-hidden-accessible" id="select-region" name="select-region">
                                                                    <option value="">Select Region</option>
                                                                    <option value="jabalpur" selected>Jabalpur</option>
                                                                    <option value="rewa">Rewa</option>
                                                                    <option value="sagar">Sagar</option>
                                                                    <option value="shedol">Shedol</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" for="select-circle">Circle</label>
                                                                <select class="form-control select2 select-hidden-accessible" id="select-circle" name="select-circle">
                                                                    <option value="">Select Circle</option>
                                                                    <option value="jabalpur_city" selected>Jabalpur City</option>
                                                                    <option value="jabalpur_om">Jabalpur O&M</option>
                                                                    <option value="dindori">Dindori</option>
                                                                    <option value="balaghat">Balaghat</option>
                                                                    <option value="mandla">Mandla</option>
                                                                    <option value="chindwara">Chindwara</option>
                                                                    <option value="narsinghpur">Narsinghpur</option>
                                                                    <option value="katni">Katni</option>
                                                                    <option value="seoni">Seoni</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" for="select-division">Division</label>
                                                                <select class="form-control select2 select-hidden-accessible" id="select-division" name="select-division">
                                                                    <option value="city_dn_east" selected>City Dn East </option>
                                                                    <option value="city_dn_west">City Dn West</option>
                                                                    <option value="city_dn_north">City Dn North</option>
                                                                    <option value="city_dn_south">City Dn South</option>
                                                                    <option value="vijay_nagar">Vijay Nagar</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" for="select-typeofwork">Type of Work</label>
                                                                <select class="form-control select2 select-hidden-accessible" id="select-typeofwork" name="select-typeofwork">
                                                                    <option value="capacitor_bank" selected>Capacitor Bank</option>
                                                                    <option value="33_KV_11_KV_New_Substation">33 KV / 11 KV New Substation</option>
                                                                    <option value="11_KV_Feeder Separation">11 KV Feeder Separation</option>
                                                                    <option value="33_KV_Interconnection_Line">33 KV Interconnection Line</option>
                                                                    <option value="11_KV_Interconnection_Line">11 KV Interconnection Line</option>
                                                                    <option value="LT_Line_LT_Cabling">LT Line / LT Cabling</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="contractorTKC">Contractor (TKC)</label>
                                                                <input class="form-control"
                                                                type="text" id="contractorTKC" name="contractorTKC" onkeyup="showtkc(this.value)">
                                                                <div class="list-group list-view-contractor" id="list-view"></div>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" for="tenderAwardNo">Tender Award No</label>
                                                                <input class="form-control" type="text" id="tenderAwardNo" name="tenderAwardNo">
                                                            </div>
                                                            <div class="col-md-3 mb-3 mt-6">
                                                                <button type="button" class="btn btn-primary">Apply Filter</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">Field Supervisors</h6>
                                                            <h2 class="mb-0 number-font">59</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <!-- <div class="chart-wrapper mt-1">
                                                                <canvas id="costchart"
                                                                    class="h-8 w-9 chart-dropshadow"></canvas>
                                                            </div> -->
                                                            <div class="media-icon bg-indigo bradius me-3 mt-1">
                                                                <i class="fa fa-male fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">Field Engineers</h6>
                                                            <h2 class="mb-0 number-font">21</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-red bradius me-3 mt-1">
                                                                <!-- <i class="fe fe-users fs-20 text-white"></i> -->
                                                                <i class="fa fa-user fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">Total TKC</h6>
                                                            <h2 class="mb-0 number-font">12</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-primary bradius me-3 mt-1">
                                                                <!-- <i class="fe fe-aperture fs-20 text-white"></i> -->
                                                                <i class="fa fa-user-circle-o fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">Total Cost (Cr)</h6>
                                                            <h2 class="mb-0 number-font">1400</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-secondary bradius me-3 mt-1">
                                                                <!-- <i class="fe fe-package fs-20 text-white"></i> -->
                                                                <i class="fa fa-inr fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><b>Weekly Progress Report</b></p>    
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">Capacitor <br> Bank </h6>
                                                            <h2 class="mb-0 number-font">3</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-primary bradius me-3 mt-1">
                                                                <!-- <i class="fe fe-radio fs-20 text-white"></i> -->
                                                                <i class="fa fa-tasks fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">33/11 KV New <br> Substation</h6>
                                                            <h2 class="mb-0 number-font">12</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-warning bradius me-3 mt-1">
                                                                <i class="fa fa-tasks fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">33 KV <br>Interconnection line</h6>
                                                            <h2 class="mb-0 number-font">18</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-danger bradius me-3 mt-1">
                                                                <i class="fa fa-tasks fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">11 KV Interconnection line / LT Line Cabling</h6>
                                                            <h2 class="mb-0 number-font">58</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-cyan bradius me-3 mt-1">
                                                                <i class="fa fa-tasks fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                                            <div class="card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="mt-2">
                                                            <h6 class="">11 KV Feeder<br>Seperation</h6>
                                                            <h2 class="mb-0 number-font">1</h2>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <div class="media-icon bg-secondary bradius me-3 mt-1">
                                                                <i class="fe fe-more-vertical fs-20 text-white"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Graph -->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Statistics Graph</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div id="chart-sracked" class="chartsh c3" style="max-height: 256px; position: relative;"><svg width="965" height="256" style="overflow: hidden;"><defs><clipPath id="c3-1683701750212-clip"><rect width="923" height="222"></rect></clipPath><clipPath id="c3-1683701750212-clip-xaxis"><rect x="-41" y="-20" width="995" height="50"></rect></clipPath><clipPath id="c3-1683701750212-clip-yaxis"><rect x="-39" y="-4" width="60" height="246"></rect></clipPath><clipPath id="c3-1683701750212-clip-grid"><rect width="923" height="222"></rect></clipPath><clipPath id="c3-1683701750212-clip-subchart"><rect width="923" height="0"></rect></clipPath></defs><g transform="translate(40.5,4.5)"><text class="c3-text c3-empty" text-anchor="middle" dominant-baseline="middle" x="461.5" y="111" style="opacity: 0;"></text><g clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip)" class="c3-regions" style="visibility: visible;"></g><g clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip-grid)" class="c3-grid" style="visibility: visible;"><g class="c3-xgrid-focus"><line class="c3-xgrid-focus" x1="-10" x2="-10" y1="0" y2="222" style="visibility: hidden;"></line></g></g><g clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip)" class="c3-chart"><g class="c3-event-rects" style="fill-opacity: 0;"><rect class="c3-event-rect" x="0" y="0" width="923" height="222"></rect></g><g class="c3-chart-bars"><g class="c3-chart-bar c3-target c3-target-data1" style="pointer-events: none;"><g class=" c3-shapes c3-shapes-data1 c3-bars c3-bars-data1" style="cursor: pointer;"></g></g></g><g class="c3-chart-lines"><g class="c3-chart-line c3-target c3-target-data1" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-data1 c3-lines c3-lines-data1"><path class=" c3-shape c3-shape c3-line c3-line-data1" d="M52,222C52,222,120.66666666666667,179.5858585858586,155,161.72727272727275C189.33333333333331,143.8686868686869,223.83333333333334,126.01010101010101,258,114.84848484848484C292.1666666666667,103.68686868686868,325.8333333333333,110.38383838383838,360,94.75757575757575C394.1666666666667,79.13131313131312,428.8333333333333,27.78787878787879,463,21.090909090909093C497.1666666666667,14.393939393939396,530.8333333333334,42.29797979797979,565,54.575757575757564C599.1666666666666,66.85353535353534,633.8333333333334,80.24747474747474,668,94.75757575757575C702.1666666666666,109.26767676767676,735.8333333333334,120.42929292929293,770,141.63636363636363C804.1666666666666,162.84343434343432,873,222,873,222" style="stroke: rgb(108, 95, 252); opacity: 1;"></path></g><g class=" c3-shapes c3-shapes-data1 c3-areas c3-areas-data1"><path class=" c3-shape c3-shape c3-area c3-area-data1" d="M52,222C52,222,120.66666666666667,179.5858585858586,155,161.72727272727275C189.33333333333331,143.8686868686869,223.83333333333334,126.01010101010101,258,114.84848484848484C292.1666666666667,103.68686868686868,325.8333333333333,110.38383838383838,360,94.75757575757575C394.1666666666667,79.13131313131312,428.8333333333333,27.78787878787879,463,21.090909090909093C497.1666666666667,14.393939393939396,530.8333333333334,42.29797979797979,565,54.575757575757564C599.1666666666666,66.85353535353534,633.8333333333334,80.24747474747474,668,94.75757575757575C702.1666666666666,109.26767676767676,735.8333333333334,120.42929292929293,770,141.63636363636363C804.1666666666666,162.84343434343432,873,222,873,222L873,222C873,222,804.1666666666666,222,770,222C735.8333333333334,222,702.1666666666666,222,668,222C633.8333333333334,222,599.1666666666666,222,565,222C530.8333333333334,222,497.1666666666667,222,463,222C428.8333333333333,222,394.1666666666667,222,360,222C325.8333333333333,222,292.1666666666667,222,258,222C223.83333333333334,222,189.33333333333331,222,155,222C120.66666666666667,222,52,222,52,222Z" style="fill: rgb(108, 95, 252); opacity: 0.1;"></path></g><g class=" c3-selected-circles c3-selected-circles-data1"></g><g class=" c3-shapes c3-shapes-data1 c3-circles c3-circles-data1" style="cursor: pointer;"><circle class=" c3-shape c3-shape-0 c3-circle c3-circle-0" cx="52" cy="222" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-1 c3-circle c3-circle-1" cx="155" cy="161.72727272727275" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-2 c3-circle c3-circle-2" cx="258" cy="114.84848484848484" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-3 c3-circle c3-circle-3" cx="360" cy="94.75757575757575" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-4 c3-circle c3-circle-4" cx="463" cy="21.090909090909093" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-5 c3-circle c3-circle-5" cx="565" cy="54.575757575757564" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-6 c3-circle c3-circle-6" cx="668" cy="94.75757575757575" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-7 c3-circle c3-circle-7" cx="770" cy="141.63636363636363" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle><circle class=" c3-shape c3-shape-8 c3-circle c3-circle-8" cx="873" cy="222" r="2.5" style="fill: rgb(108, 95, 252); opacity: 1;"></circle></g></g></g><g class="c3-chart-arcs" transform="translate(461.5,106)"><text class="c3-chart-arcs-title" style="text-anchor: middle; opacity: 0;"></text></g><g class="c3-chart-texts"><g class="c3-chart-text c3-target c3-target-data1  " style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-data1"></g></g></g></g><g clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip-grid)" class="c3-grid c3-grid-lines"><g class="c3-xgrid-lines"></g><g class="c3-ygrid-lines"></g></g><g class="c3-axis c3-axis-x" clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip-xaxis)" transform="translate(0,222)" style="visibility: visible; opacity: 1;"><text class="c3-axis-x-label" transform="" style="text-anchor: end;" x="923" dx="-0.5em" dy="-0.5em"></text><g class="tick" transform="translate(52, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Jan</tspan></text></g><g class="tick" transform="translate(155, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Feb</tspan></text></g><g class="tick" transform="translate(258, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Mar</tspan></text></g><g class="tick" transform="translate(360, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Apr</tspan></text></g><g class="tick" transform="translate(463, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">May</tspan></text></g><g class="tick" transform="translate(565, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Jun</tspan></text></g><g class="tick" transform="translate(668, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Jul</tspan></text></g><g class="tick" transform="translate(770, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Aug</tspan></text></g><g class="tick" transform="translate(873, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="0"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Sep</tspan></text></g><path class="domain" d="M0,6V0H923V6"></path></g><g class="c3-axis c3-axis-y" clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip-yaxis)" transform="translate(0,0)" style="visibility: visible; opacity: 1;"><text class="c3-axis-y-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="1.2em"></text><g class="tick" transform="translate(0,222)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">0</tspan></text></g><g class="tick" transform="translate(0,189)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">5</tspan></text></g><g class="tick" transform="translate(0,156)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">10</tspan></text></g><g class="tick" transform="translate(0,122)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">15</tspan></text></g><g class="tick" transform="translate(0,89)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">20</tspan></text></g><g class="tick" transform="translate(0,55)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">25</tspan></text></g><g class="tick" transform="translate(0,22)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">30</tspan></text></g><path class="domain" d="M-6,1H0V222H-6"></path></g><g class="c3-axis c3-axis-y2" transform="translate(923,0)" style="visibility: hidden; opacity: 1;"><text class="c3-axis-y2-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="-0.5em"></text><g class="tick" transform="translate(0,222)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0</tspan></text></g><g class="tick" transform="translate(0,200)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.1</tspan></text></g><g class="tick" transform="translate(0,178)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.2</tspan></text></g><g class="tick" transform="translate(0,156)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.3</tspan></text></g><g class="tick" transform="translate(0,134)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.4</tspan></text></g><g class="tick" transform="translate(0,112)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.5</tspan></text></g><g class="tick" transform="translate(0,90)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.6</tspan></text></g><g class="tick" transform="translate(0,68)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.7</tspan></text></g><g class="tick" transform="translate(0,46)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.8</tspan></text></g><g class="tick" transform="translate(0,24)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.9</tspan></text></g><g class="tick" transform="translate(0,1)" style="opacity: 1;"><line x2="6"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">1</tspan></text></g><path class="domain" d="M6,1H0V222H6"></path></g></g><g transform="translate(20.5,256.5)" style="visibility: hidden;"><g clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip-subchart)" class="c3-chart"><g class="c3-chart-bars"></g><g class="c3-chart-lines"></g></g><g clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip)" class="c3-brush" fill="none" pointer-events="all" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><rect class="overlay" pointer-events="all" cursor="crosshair" x="0" y="0" width="943" height="0"></rect><rect class="selection" cursor="move" fill="#777" fill-opacity="0.3" stroke="#fff" shape-rendering="crispEdges" style="display: none;"></rect><rect class="handle handle--e" cursor="ew-resize" style="display: none;"></rect><rect class="handle handle--w" cursor="ew-resize" style="display: none;"></rect></g><g class="c3-axis-x" transform="translate(0,0)" clip-path="url(http://localhost/MPPKVVCL_local/prototype/test.php#c3-1683701750212-clip-xaxis)" style="opacity: 1;"><g class="tick" transform="translate(52, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Jan</tspan></text></g><g class="tick" transform="translate(155, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Feb</tspan></text></g><g class="tick" transform="translate(258, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Mar</tspan></text></g><g class="tick" transform="translate(360, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Apr</tspan></text></g><g class="tick" transform="translate(463, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">May</tspan></text></g><g class="tick" transform="translate(565, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Jun</tspan></text></g><g class="tick" transform="translate(668, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Jul</tspan></text></g><g class="tick" transform="translate(770, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Aug</tspan></text></g><g class="tick" transform="translate(873, 0)" style="opacity: 1;"><line x1="52" x2="52" y2="0"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">Sep</tspan></text></g><path class="domain" d="M0,6V0H923V6"></path></g></g><g transform="translate(0,256)" style="visibility: hidden;"></g><text class="c3-title" x="482.5" y="0"></text></svg><div class="c3-tooltip-container" style="position: absolute; pointer-events: none; display: none;"></div></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <!-- Graph Ends -->
                                </div>
                            </div>
                            <!-- ROW-1 END -->

                            <!-- ROW-2 -->
                           
                            <!-- ROW-2 END -->

                            <!-- ROW-3 -->
                           
                            <!-- ROW-3 END -->

                            <!-- ROW-4 -->
                           
                            <!-- ROW-4 END -->
                        </div>
                        <!-- CONTAINER END -->
                    </div>
                </div>
                <!--app-content close-->

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
        <script src="<?php  echo base_url('assets/plugins/apexchart/irregular-data-series.js'); ?>"></script>

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
        <script src="<?php  echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

        <!-- INTERNAL INDEX JS -->
        <script src="<?php echo base_url('assets/js/index1.js'); ?>"></script>

        <!-- Color Theme js -->
        <script src="<?php  echo base_url('assets/js/themeColors.js'); ?>"></script>

        <!-- CUSTOM JS -->
        <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

        <!-- Custom-switcher -->
        <script src="<?php echo base_url('assets/js/custom-swicher.js'); ?>"></script>

        <!-- Switcher js -->
        <script src="<?php echo base_url('assets/switcher/js/switcher.js'); ?>"></script>

    </body>
</html>