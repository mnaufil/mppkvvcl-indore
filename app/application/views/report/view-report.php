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
      <title>MPPKVVCL - View Report</title>

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
                                 <form class="needs-validation2" novalidate method="post" action="<?php echo base_url('generate-physical-report'); ?>">                                 
                                    <!-- <div class="form-row mt-2 mb-2">
                                       <div class="col-xl-4">
                                          <h4 class="card-title">Report Filter</h4>
                                       </div>
                                    </div> -->
                                    <div class="form-row">
                                       <div class="col-xl-4 mb-3">
                                          <label for="packageNo" class="form-label">Package No.
                                             <span class="text-red">*</span>
                                          </label>
                                          <select  class="form-control select2-show-search form-select select2-hidden-accessible" id="packageNo" name="packageNo" required>
                                             <?php foreach($packages as $package) { ?>
			                									<option value="<?php echo $package->package_no;?>" <?php if($postpackage==$package->package_no) { ?> selected <?php } ?>><?php echo $package->package_no;?></option>
																<?php } ?>
                                           </select>
                                          <!-- <input type="text" class="form-control" id="" value="" required>
                                          <div class="valid-feedback">Looks good!</div> -->
                                       </div>
                                       <div class="col-xl-4 mb-3">
                                          <label for="feederId" class="form-label">Feeder ID<span class="text-red">*</span></label>
                                          <input type="text" class="form-control" id="feederId" name="feederId" required value="<?php echo $postfeederId; ?>" onkeyup="showfeeders(this.value)">
                                        <!--   <div class="valid-feedback">Looks good!</div> -->
                                          
                                          <div class="list-group list-view-contractor" id="list_view_feeders" style="width:100%">
                                          
                                       </div>

                                       </div>

                                       <div class="col-xl-4 mb-3">
                                             <label class="form-label" for="region">Region
                                                <span class="text-red">*</span>
                                             </label>
                                             <select class="filter-multi" id="region" name="region[]" required multiple="multiple">
                                                        
                                                            <?php foreach($regions as $region) { ?>

                                                            <option value="<?php echo $region->region_id;?>" <?php if(in_array($region->region_id, $allRegion)) { ?> selected <?php } ?>><?php echo $region->region_name;?></option>
                                                <?php } ?>  

                                                    </select>
                                          </div>


                                          <div class="col-xl-4 mb-3">
                                             <label class="form-label" for="circle">Circle
                                                <span class="text-red">*</span>
                                             </label>
                                             <select class="filter-multi" id="circle" name="circle[]" required multiple="multiple">
                                                           
                                                  <?php foreach($circles as $circle) { ?>
                                                   <option value="<?php echo $circle->circle_id;?>" <?php if(in_array($circle->circle_id, $allCircle)) { ?> selected <?php } ?>><?php echo $circle->circle_name;?></option>
                                                <?php } ?>  
                                                    </select>
                                          </div>


                                          <div class="col-xl-4 mb-3">
                                             <label class="form-label" for="division">Division
                                                <span class="text-red">*</span>
                                             </label>
                                             <select class="filter-multi" id="division" name="division[]" required multiple="multiple">
                                                           
                                                  <?php foreach($divisions as $division) { ?>
                                                   <option value="<?php echo $division->division_id;?>" <?php if(in_array($division->division_id, $allDivision)) { ?> selected <?php } ?>><?php echo $division->division_name;?></option>
                                                <?php } ?>  
                                                    </select>
                                          </div>

                                    </div>


                                    <div class="form-row">
                                          <div class="col-xl-12 mb-3">
                                             <label class="form-label" for="reportType">Report Type
                                                <span class="text-red">*</span>
                                             </label>
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

                                    <!-- <button class="btn btn-success mb-3 mt-3" type="submit">Generate</button> -->
                                    <!-- For time being -->
                                    <button class="btn btn-success mb-3 mt-3" type="submit" >Generate</button>
									<a class="btn btn-light mb-3 mt-3" href="<?php echo base_url('view-report'); ?>">Clear</a>
                                    <a class="btn btn-primary mb-3 mt-3" href="<?php echo base_url('reports'); ?>">Back</a>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- ROW CLOSED -->

                     <!-- Report Row -->
					 <?php if(!empty($reportData) && $reportType == 2) { ?>
                     <div class="row" id="report-table" >
                        <div class="col-lg-12">
                           <div class="card">
                              <div class="card-body">
                                 <div class="row">
                                    <!-- Export Button -->
                                    <div class="col-sm-12 col-md-9s mt-3 mb-3">
                                       <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                          <a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" ><span>Export</span></a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="table-responsive mb-3">
                                       <table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
                                          <tbody>
                                             <tr>
                                                <td>Scheme Name</td>
                                                <td colspan="5"><?php echo @$reportData['scheme_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td>DISCOM</td>
                                                <td colspan="5"><?php echo @$reportData['discom'];?></td>
                                             </tr>
                                             <tr>
                                                <td>11 kv feeder Id</td>
                                                <td colspan="5"><?php echo @$reportData['feeder_id'];?></td>
                                             </tr>
                                             <tr>
                                                <td>11 kv feeder Name</td>
                                                <td colspan="5"><?php echo @$reportData['feeder_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td>Region</td>
                                                <td colspan="5"><?php echo @$reportData['region_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td>Circle</td>
                                                <td colspan="5"><?php echo @$reportData['circle_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td>Division</td>
                                                <td colspan="5"><?php echo @$reportData['division_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td>Award No</td>
                                                <td colspan="5"><?php echo @$reportData['award_no'];?></td>
                                             </tr>
                                             <tr>
                                                <td>Contractor Name</td>
                                                <td colspan="5"><?php echo @$reportData['contractor_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td>Date & Time</td>
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
											 <?php $i=1; foreach($reportData['result'] as $report) { ?>
                                             <tr align="center">
                                                <td><?php echo $i;?></td>
                                                <td align="left"><?php echo $report->item;?></td>
                                                <td><?php echo $report->unit;?></td>
                                                <td><?php echo $report->boq_qty;?></td>
                                                <td><?php echo $report->erection_qty;?></td>
												<td><?php echo number_format((float)$report->progress_in_percent,2, '.', '');?></td>

                                             </tr>
                                            	<?php $i++; } ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
					 <?php } ?>
                     <!-- Report Row Ends -->


                     <?php if(!empty($reportData) && $reportType == 1) { ?>


                        <!-- Report Row -->
                  <div class="row" id="report-table">
                     <div class="col-lg-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <!-- Export Button -->
                                 <div class="col-sm-12 col-md-9s mt-3 mb-3">
                                     <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                          <a href="<?php echo base_url('export-excel-sp');?>" class="btn btn-primary" ><span>Export</span></a>
                                       </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="table-responsive mb-3">
                                    <table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
                                       <tbody>

                                          <tr>
                                            
                                            <?php foreach ($mainHeadingArray as $key1) { ?>
                                             <th colspan="3"><?php echo str_replace("_", " ", $key1);?></th>
                                             <?php  } ?>
                                          </tr> 

                                          <tr>
                                            <th>Feeder ID</th>
                                            <?php foreach ($subHeadingArray as $key) { ?>
                                             <th><?php echo str_replace("_", " ", $key);?></th>
                                             <?php  } ?>
                                          </tr> 
                                          <tr>
                                              <th></th>
                                           <?php foreach ($subSubHeadingArray as $val) {
                                          ?>  
                                          <th><?php echo str_replace("_", " ", $val);?></th>
                                       <?php } ?>
                                        </tr> 
                                          <?php foreach ($reportData as $value) {
                                          ?>                                            
                                          <tr>
                                             <td><?php echo $value->feeder_id;?></td>
                                             <td><?php echo $value->Civil_Work__Foundation__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Civil_Work__Foundation__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__11_KV_Capacitor_Bank__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__11_KV_Capacitor_Bank__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__11_KV_Potential_X_mer_Installation__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__11_KV_Potential_X_mer_Installation__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__11_KV_VCB_slash_CT_Installation__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__11_KV_VCB_slash_CT_Installation__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Bus_Bar_Erection__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Bus_Bar_Erection__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Cabling_Connection__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Cabling_Connection__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Commissioning_of_Capacitor_Bank__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Commissioning_of_Capacitor_Bank__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Earthing_Network__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Earthing_Network__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Isolator_Installation__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Isolator_Installation__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Lightining_Arrester_Installation__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Lightining_Arrester_Installation__NOS__erection_qty;?></td>
                                             <td><?php echo $value->Electrical__Residual_Voltage_X_mer_Installation__NOS__boq_qty;?></td>
                                             <td><?php echo $value->Electrical__Residual_Voltage_X_mer_Installation__NOS__erection_qty;?></td>
                                            

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
                  <!-- Report Row Ends -->



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
         function showReport() {

            $('#report-table').removeAttr('hidden');
         }

         function showfeeders(feederId)
         {
           // alert(feederId);
            $.ajax({
                 type: "POST",
                 url: baseUrl+"show-feeders/"+feederId,
                 //data: {name: 'John'},
                 //data: data,
                 success: function(data){
                 //alert(data);
                
                 $("#list_view_feeders").html(data);
                 },
                 error: function(xhr, status, error){
                 console.error(xhr);
                 }
             });
         }

         function feeder(feederId)
         {
            $("#feederId").empty();
            $("#feederId").val(feederId);
             $("#list_view_feeders").html("");

         }

            let circle_data = <?php echo json_encode($circle_data) ?>;
        /* $('#region').on('change', function(event) {
            let selected_region = this.value;

            let circles = circle_data[selected_region];

            let html = '';          

            html += '<option value="" selected disabled>Select Circle</option>'; 
            $.each(circles, function(index, value) {
               html += '<option value="'+ value +'">'+ value + '</option>';
            });

            // Clearing previous appended circle list
            $('#circle').empty();

            // Appending new circle list
            $('#circle').append(html);
         });*/
      </script>

   </body>

</html>