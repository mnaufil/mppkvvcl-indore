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
      
      <style type="text/css">
         .feeder-class
         {
            z-index: 999;
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
            <div class="main-content app-content mt-0">
               <div class="side-app">

                  <!-- CONTAINER -->
                  <div class="main-container container-fluid">

                     <!-- PAGE-HEADER -->
                     <div class="page-header">
                        <h1 class="page-title">Report Name: Physical Progress</h1>
                     </div>
                     <!-- PAGE-HEADER END -->

                     <!-- ROW OPEN -->
                     <div class="row">
                        <div class="col-lg-12 col-md-12">
                           <div class="card">
                              <div class="card-body">
                                 <div class="form-row mt-2 mb-2">
                                    <div class="col-xl-12">
                                       <label class="form-label">Report Description:</label>
                                       <p class="report-desc">Choose the Package No and/or the Feeder ID to view the status summary.</p>
                                    </div>
                                 </div>
                                 <!-- <form class="needs-validation" novalidate method="post" action="<?php //echo base_url('generate-report'); ?>"> -->
                                    <!-- For time being -->
                                 <form id="generatePhysicalReport" name="generatePhysicalReport" method="post" action="<?php echo base_url('generate-physical-report'); ?>">
                                    <div class="form-row">
                                       <!-- Package No -->
                                       <div class="col-xl-4 mb-3">
                                          <label for="packageNo" class="form-label">Package No.
                                             <span class="text-red">*</span>
                                          </label>
                                          <select  class="form-control select2-show-search form-select select2-hidden-accessible" id="packageNo" name="packageNo" required>
                                             <option value="select" selected disabled>Select Package</option>
                                             <?php foreach($packages as $package) { ?>
                                                   <option value="<?php echo $package->package_no;?>" <?php if($postpackage==$package->package_no) { ?> selected <?php } ?>><?php echo $package->package_no;?></option>
                                                <?php } ?>
                                           </select>
                                       </div>
                                       <!-- Region -->
                                       <div class="col-xl-4 mb-3">
                                          <label class="form-label" for="region">Region</label>
                                          <select class="filter-multi" id="region" name="region[]" multiple="multiple">
                                             <?php //foreach($regions as $region) { ?>
                                             <!-- <option value="<?php //echo $region->region_id;?>" <?php //if(in_array($region->region_id, $allRegion)) { ?> selected <?php //} ?>><?php //echo $region->region_name;?></option> -->
                                             <?php //} ?>

                                             <?php foreach ($regions as $key => $value) { ?>
                                                <?php $selected = (isset($sel_region) && in_array($value->region_id, $sel_region)) ? 'selected' : ''; ?>
                                             <option value="<?php echo $value->region_id; ?>" <?php echo $selected; ?>><?php echo $value->region_name; ?></option>
                                             <?php } ?>
                                          </select>
                                       </div>
                                       <!-- Circle -->
                                       <div class="col-xl-4 mb-3">
                                          <label class="form-label" for="circle">Circle</label>
                                          <select class="filter-multi" id="circle" name="circle[]" multiple="multiple">
                                             <?php //foreach($circles as $circle) { ?>
                                             <!-- <option value="<?php //echo $circle->circle_id;?>" <?php //if(in_array($circle->circle_id, $allCircle)) { ?> selected <?php //} ?>><?php //echo $circle->circle_name;?></option> -->
                                             <?php //} ?>

                                             <?php foreach ($circles as $key => $value) { 
                                                      foreach ($value as $k => $val) {
                                                         $selected = (isset($sel_circle) && in_array($k, $sel_circle)) ? 'selected' : ''; 
                                             ?>
                                             <option value="<?php echo $k ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                                             <?php    }
                                                   }
                                             ?>
                                          </select>
                                       </div>
                                       <!-- Division -->
                                       <div class="col-xl-4 mb-3">
                                          <label class="form-label" for="division">Division</label>
                                          <select class="filter-multi" id="division" name="division[]" multiple="multiple">
                                             <?php //foreach($divisions as $division) { ?>
                                             <!-- <option value="<?php //echo $division->division_id;?>" <?php //if(in_array($division->division_id, $allDivision)) { ?> selected <?php //} ?>><?php //echo $division->division_name;?></option> -->
                                             <?php //} ?>

                                             <?php foreach ($divisions as $key => $value) { 
                                                      foreach ($value as $k => $val) {
                                                         $selected = (isset($sel_division) && in_array($k, $sel_division)) ? 'selected' : '';
                                             ?>
                                             <option value="<?php echo $k ?>" <?php echo $selected; ?>><?php echo $val ?></option>
                                             <?php    }
                                                   }
                                             ?>
                                          </select>
                                       </div>
                                       <!-- Feeder ID -->
                                       <div class="col-xl-4 mb-3">
                                          <label for="feederId" class="form-label">Feeder ID</label>
                                          <input type="text" class="form-control" id="feederId" name="feederId" value="<?php echo $postfeederId; ?>" onkeyup="showfeeders(this.value)">
                                          <div class="list-group list-view-contractor" id="list_view_feeders" style="width:100%"></div>
                                       </div>
                                    </div>

                                    <div class="form-row">
                                       <!-- Report Type -->
                                       <div class="col-xl-12 mb-3">
                                          <label class="form-label" for="reportType">Report Type<span class="text-red">*</span></label>
                                          <div class="form-group">
                                             <div class="custom-controls">
                                                <label class="custom-control custom-radio status-radio">
                                                   <input type="radio" class="custom-control-input" name="reportType" value="1" <?php if($reportType=='1') { ?> checked <?php } ?>  required />
                                                   <span class="custom-control-label">Feeder ID Wise</span>
                                                </label>
                                                <label class="custom-control custom-radio status-radio">
                                                   <input type="radio" class="custom-control-input" name="reportType" value="2" <?php if($reportType=='2') { ?> checked <?php } ?> required>
                                                   <span class="custom-control-label">Consolidated Activity Wise</span>
                                                </label>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <button class="btn btn-success mb-3 mt-3" type="submit" >Generate</button>
                                    <a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('view-report'); ?>">Clear</a>
                                    <a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports'); ?>">Back</a>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- ROW CLOSED -->

                     <?php if (isset($feeder_access) && $feeder_access) { ?>
                        <!-- Report Row -->
                        <?php if(!empty($reportData) && $reportType == 2) { ?>
                           <?php if (is_array($reportData)) { ?>
                           <div class="row" id="report-table" >
                              <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-body">

                                       <?php if ($download_access) { ?>
                                       <div class="row">
                                          <!-- Export Button -->
                                          <div class="col-sm-12 col-md-9s mt-3 mb-3">
                                             <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                                <a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" ><span>Export</span></a>
                                             </div>
                                          </div>
                                       </div>   
                                       <?php } ?>
                                       
                                       <div class="row">
                                          <div class="table-responsive mb-3">
                                             <table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
                                                <tbody>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Scheme Name</b></td>
                                                      <td colspan="5"><?php echo @$reportData['scheme_name'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>DISCOM</b></td>
                                                      <td colspan="5"><?php echo @$reportData['discom'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Feeder Id</b></td>
                                                      <td colspan="5"><?php echo @$reportData['feeder_id'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Feeder Name</b></td>
                                                      <td colspan="5"><?php echo @$reportData['feeder_name'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Region</b></td>
                                                      <td colspan="5"><?php echo @$reportData['region_name'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Circle</b></td>
                                                      <td colspan="5"><?php echo @$reportData['circle_name'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Division</b></td>
                                                      <td colspan="5"><?php echo @$reportData['division_name'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Award No</b></td>
                                                      <td colspan="5"><?php echo @$reportData['award_no'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Contractor Name</b></td>
                                                      <td colspan="5"><?php echo @$reportData['contractor_name'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-transform: uppercase;"><b>Date & Time</b></td>
                                                      <td colspan="5"><?php echo @$reportData['datetime'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <th style="width: 150px;">S.No.</th>
                                                      <th style="width: 300px;">Items</th>
                                                      <th>Unit</th>
                                                      <th>BOQ Qty</th>
                                                      <th>Erection Qty</th>
                                                      <th>Progress in %</th>
                                                   </tr>
                                                   <?php $i=1; 
                                                         foreach($reportData['result'] as $report) { 
                                                   ?>
                                                   <tr align="center">
                                                      <td><?php echo $i;?></td>
                                                      <td align="left"><?php echo $report->item;?></td>
                                                      <td><?php echo $report->unit;?></td>
                                                      <td><?php echo $report->boq_qty;?></td>
                                                      <td><?php echo $report->erection_qty;?></td>
                                                      <td><?php echo number_format((float)$report->progress_in_percent,2, '.', '');?></td>
                                                   </tr>
                                                   <?php    $i++; 
                                                         } 
                                                   ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>   
                           <?php } else { ?>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-body">
                                       <div class="row">
                                          <h4 class="pt-3"><strong><?php echo $reportData; ?></strong></h4>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        <?php } ?>
                        <!-- Report Row Ends -->

                        <!-- Report Row -->
                        <?php if(!empty($reportData) && $reportType == 1) { ?>
                           <?php if (is_array($reportData)) { ?>
                           <div class="row" id="report-table">
                              <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-body">

                                       <?php if ($download_access) { ?>
                                       <div class="row">
                                          <!-- Export Button -->
                                          <div class="col-sm-12 col-md-9s mt-3 mb-3">
                                             <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                                <a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" ><span>Export</span></a>
                                             </div>
                                          </div>
                                       </div>   
                                       <?php } ?>
                                       
                                       <div class="row">
                                          <div class="table-responsive mb-3">
                                             <table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
                                                <tbody>
                                                   <tr>
                                                      <td></td>
                                                      <?php foreach ($mainHeadingArray as $key => $value) { ?>
                                                      <!-- <th colspan="3"><?php //echo str_replace("_", " ", $key1);?></th> -->
                                                      <th colspan="<?php echo $value; ?>"><?php echo $key;?></th>
                                                      <?php  } ?>
                                                   </tr> 

                                                   <tr>
                                                     <th>Feeder ID</th>
                                                     <?php foreach ($subHeadingArray as $key) { ?>
                                                      <th style="text-align:left"><?php echo str_replace("_", " ", $key);?></th>
                                                      <?php  } ?>
                                                   </tr> 
                                                   <tr>
                                                      <th></th>
                                                      <?php foreach ($subSubHeadingArray as $val) { ?>  
                                                      <th><?php echo str_replace("_", " ", $val);?></th>
                                                      <?php } ?>
                                                   </tr> 
                                                   <?php foreach ($reportData as $key => $value) {
                                                   ?>                                            
                                                   <tr>
                                                      <td><?php echo $key; ?></td>
                                                      <?php foreach ($value as $val) { ?>
                                                      <td><?php echo $val; ?></td>
                                                      <?php } ?>
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
                           <?php } else { ?>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="card">
                                    <div class="card-body">
                                       <div class="row">
                                          <h4 class="pt-3"><strong><?php echo $reportData; ?></strong></h4>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        <?php } ?>
                        <!-- Report Row Ends -->   
                        <?php } elseif(isset($feeder_access) && !$feeder_access) { ?>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="card">
                                 <div class="card-body bg-danger text-white pt-2 rounded-2">
                                    <div class="row">
                                       <h3 class="pt-3"><strong>Authorization failed.</strong></h3>
                                       <p>You don't have access to this record. Ask your administrator for help or request for access.</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } ?>

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
      <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
      <script src="<?php echo base_url('assets/js/select2.js');?>"></script>

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

      <!-- MULTIPLE SELECT JS -->
      <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

       <script>
         var baseUrl = "<?php echo base_url(); ?>";

         let circles = <?php echo json_encode($circles) ?>;         
         let divisions = <?php echo json_encode($divisions) ?>;

         let regions_select = 0;
         let circles_select = 0;

         $('#region').on('change', function() {
            let selected_regions = [];
            let circle_data = [];            

            let circle_html = '';

            if ($('#region option:selected').length == 0) {
               regions_select = 0;

               $.each(circles, function(index, value) {
                  $.each(value, function(ind, val) {
                     circle_html += '<option value="'+ ind +'">'+ val +'</option>';
                  });
               });
            } else {
               regions_select = 1;
               $('#region option:selected').each(function(index, value) {
                  selected_regions.push($(value).text());
               });

               $.each(selected_regions, function(index, value) {
                  circle_data.push(circles[value]);
               });

               $.each(circle_data, function(index, value) {
                  $.each(value, function(ind, val) {
                     circle_html += '<option value="'+ ind +'">'+ val +'</option>';
                  });
               });
            }

            $('#circle').empty();
            $('#circle').append(circle_html);
            $('#circle').multipleSelect();
         });

         $('#circle').on('change', function() {
            let selected_circles = [];
            let division_data = [];

            let division_html = '';

            if ($('#circle option:selected').length == 0) {
               $.each(divisions, function(index, value) {
                  $.each(value, function(ind, val) {
                     division_html += '<option value="'+ ind +'">'+ val +'</option>';
                  });
               });
            } else {
               circles_select = 1;
               $('#circle option:selected').each(function(index, value) {
                  selected_circles.push($(value).text());
               });

               $.each(selected_circles, function(index, value) {
                  division_data.push(divisions[value]);
               });

               if ((regions_select && circles_select) || circles_select) {
                  $.each(division_data, function(index, value) {
                     $.each(value, function(ind, val) {
                        division_html += '<option value="'+ ind +'">'+ val +'</option>';
                     });
                  });
               } else {
                  $.each(divisions, function(index, value) {
                     $.each(value, function(ind, val) {
                        division_html += '<option value="'+ ind +'">'+ val +'</option>';
                     });
                  });   
               }
            }                        

            $('#division').empty();
            $('#division').append(division_html);
            $('#division').multipleSelect();
         });

         $('#generatePhysicalReport').on('submit', function(event) {
            let package_no = $('#packageNo option:selected').val();
            let report_type = $('input[name="reportType"]:checked');

            if (package_no == 'select' && report_type.length == 0) {
               $('.toast-body').text('Select mandatory filters to generate the report');
               $('.toast').toast('show');

               event.preventDefault();
            } else if (package_no == 'select') {
               $('.toast-body').text('Select Package no');
               $('.toast').toast('show');

               event.preventDefault();
            } else if (report_type.length == 0) {
               $('.toast-body').text('Select Report Type');
               $('.toast').toast('show');

               event.preventDefault();
            }
         });

         function showReport() {
            $('#report-table').removeAttr('hidden');
         }

         function showfeeders(feederId)
         {
            if (feederId.length >= 3) {
               $.ajax({
                  type: "POST",
                  url: baseUrl+"show-feeders/"+feederId,
                  //data: data,
                  success: function(data) {
                     $("#list_view_feeders").html(data);
                  },
                  error: function(xhr, status, error) {
                     console.error(xhr);
                  }
               });
            } else if (feederId.length == 0) {
               $('#list_view_feeders').empty();
            }
         }

         $(document).click(function(event) {
            var list_view = $('#list_view_feeders');

            if (list_view.children().length > 0) {
               if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                  list_view.empty();
               }   
            }
         });

         function feeder(feederId)
         {
            $("#feederId").empty();
            $("#feederId").val(feederId);
            $("#list_view_feeders").html("");
         }         
      </script>
   </body>

</html>