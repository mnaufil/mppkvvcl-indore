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
         <img src="assets/images/loader.svg" class="loader-img" alt="Loader">
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
            <!-- App-Sidebar Ends -->

            <!-- App-Content -->
            <div class="main-content app-content mt-0">
               <div class="side-app">

                  <!-- Container -->
                  <div class="main-container container-fluid">
                     
                     <!-- Page-Header -->
                     <div class="page-header">
                        <h1 class="page-title">Add Material Status</h1>
                     </div>
                     <!-- Page-Header Ends -->

                     <!-- Row -->
                     <div class="row">
                        <div class="col-lg-12 col-md-12">
                           <div class="card">
                              <!-- <form class="needs-validation" novalidate> -->
                              <div class="card-body">
                                 <form id="addMaterialStatus" method="post" action="<?php echo base_url('save-material-status'); ?>">
                                       <!-- Contract ID Hidden -->
                                       <input type="hidden" name="contract_id" value="">
                                       <!--  -->
                                       <input type="hidden" name="material_status_id" value="">
                                       <!-- Row1 -->
                                       <div class="form-row">
                                          <!-- Contractor (TKC) -->
                                          <div class="col-xl-6 mb-3">
                                             <label class="form-label" for="contractorTKC">Contractor (TKC)
                                                <span class="text-red">*</span>
                                             </label>
                                             <input class="form-control" type="text" id="contractorTKC" name="contractorTKC" onkeyup="showtkclist(this.value)">
                                             <div class="list-group list-view-contractor" id="list-view"></div>
                                          </div>
                                          <!-- Contract No -->
                                          <div class="col-xl-3 mb-3">
                                             <label class="form-label" for="tenderAwardNo">Contract No.
                                                <span class="text-red">*</span>
                                             </label>
                                             <input class="form-control" type="text" id="tenderAwardNo" name="tenderAwardNo">
                                          </div>
                                          <!-- Contract Date -->
                                          <div class="col-xl-3 mb-3">
                                             <label class="form-label" for="tenderAwardDate">Contract Date
                                                <span class="text-red">*</span>
                                             </label>
                                             <div class="input-group">
                                                <div class="input-group-text dates">
                                                   <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                                <input type="text" class="form-control" name="tenderAwardDate"/>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- Row2 -->
                                       <div class="form-row">
                                          <!-- <div class="col-xl-3 mb-3">
                                             <label class="form-label" for="discom">DISCOM
                                                <span class="text-red">*</span>
                                             </label>
                                             <input class="form-control" type="text" name="discom" id="disocm" required>
                                          </div> -->
                                          <!-- Type Of Work -->
                                          <div class="col-xl-3 mb-3">
                                             <label class="form-label" for="typeOfWork">Type Of Work
                                                <span class="text-red">*</span>
                                             </label>
                                             <select class="form-control select2" id="typeOfWork" name="typeOfWork">
                                                <option value="select" selected>Select Type Of Work</option>
                                                <?php foreach ($work_list as $value) { ?>
                                                <option value="<?php echo $value['typeofwork_id']; ?>"><?php echo $value['name'] ?></option>
                                                <?php } ?>
                                             </select>                           
                                          </div>
                                          <!-- TKC Offer Letter No -->
                                          <div class="col-xl-3 mb-3">
                                             <label class="form-label" for="TKCOfferLetterNo">TKC Offer Letter No.
                                                <span class="text-red">*</span>
                                             </label>
                                             <input class="form-control" type="text" name="TKCOfferLetterNo" id="TKCOfferLetterNo">
                                          </div>
                                          <!-- TKC Offer Letter Date -->
                                          <div class="col-xl-3 mb-3">
                                             <label class="form-label" for="TKCOfferLetterDate">TKC Offer Letter Date
                                                <span class="text-red">*</span>
                                             </label>
                                             <div class="input-group">
                                                <div class="input-group-text dates">
                                                   <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                                <input type="text" class="form-control" name="TKCOfferLetterDate"/>
                                            </div>
                                          </div>
                                       </div>
                                       <!-- Row3 -->
                                       <div class="form-row">
                                          <div class="col-lg-12 mt-6">
                                             <div class="table-responsive">
                                                <!-- Table -->
                                                <table class="table table-bordered border mb-0" id="new-add-material-details">
                                                   <thead>
                                                      <tr>
                                                         <th>Sr No.</th>
                                                         <th style="width:25% !important">Material</th>
                                                         <th>Orginal BOQ Quantity</th>
                                                         <th>Revised BOQ Quantity</th>
                                                         <th>Earlier Approved Quantity</th>
                                                         <th>Balance Quantity</th>
                                                         <th>Offer Letter Quantity</th>
                                                         <th>Date of Readiness</th>
                                                         <!-- <th>PDI Letter No.</th>
                                                         <th>PDI Letter Date</th> -->
                                                         <th>Inspection Letter No.</th>
                                                         <th>Inspection Letter Date</th>
                                                         <th>DI No.</th>
                                                         <th>DI Date</th>
                                                         <th>DI Quantity</th>
                                                         <th>Material Received Date</th>
                                                         <th>Material Received Quantity</th>
                                                         <th>Sample Size</th>
                                                         <th>Sampling Date</th>
                                                         <th>Date Of Acceptance</th>
                                                         <th>Acceptance Quantity</th>
                                                         <th>MRC Generated No</th>
                                                         <th>File Upload</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td class="sr-no"></td>
                                                         <td class="material-name"></td>
                                                         <td class="og-boq-qty"></td>
                                                         <td class="revised-boq-qty"></td>
                                                         <td class="approved-qty"></td>
                                                         <td class="bal-qty"></td>
                                                         <td class="offer-letter-qty"></td>
                                                         <td class="date-of-readiness"></td>
                                                         <!-- <td class="pdi-letter-no"></td>
                                                         <td class="pdi-letter-date"></td> -->
                                                         <td class="inspection-letter-no"></td>
                                                         <td class="inspection-letter-date"></td>
                                                         <td class="di-material-no"></td>
                                                         <td class="di-material-date"></td>
                                                         <td class="di-qty"></td>
                                                         <td class="material-received-date"></td>
                                                         <td class="material-received-qty"></td>
                                                         <td class="sample-size"></td>
                                                         <td class="sampling-date"></td>
                                                         <td class="date-of-acceptance"></td>
                                                         <td class="acceptance-quantity"></td>
                                                         <td class="mrc-generated-no"></td>
                                                         <td class="file-upload"></td>
                                                     </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                             <button id="table2-new-row-button-material-details" class="btn btn-primary mb-4 mt-4">Add New Row</button>
                                          </div>
                                       </div>
                                       <!-- Row4 -->
                                       <div class="form-row">
                                          <!-- Submit Button -->
                                          <div class="col-xl-6 mb-3 mt-4">
                                             <button type="submit" class="btn btn-success">Submit</button>
                                             <a href="<?php echo base_url('material-status'); ?>" type="button" class="btn btn-primary">Back</a>
                                          </div>
                                       </div>
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

         <!-- Material Details Modal -->
         <div class="modal fade" id="materail-details-modal" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header material-status-pop-header">
                     <div class="col-xl-6">
                        <h6 class="modal-title">
                           <p>Material Status Details</p>
                        </h6>   
                     </div>

                     <!-- Material Quantity -->
                     <div class="col-xl-6">
                        <button class="btn-close material-status-pop-cls-btn" data-bs-dismiss="modal" aria-label="Close" onclick="findtr()">
                           <span aria-hidden="true">×</span>
                        </button>
                        <div id="material-quantity" style="margin-right: 45px;" hidden>
                           <p class="text-end">Material Quantity: <span class="material-qty text-danger"></span></p>
                        </div>
                     </div>

                     <!-- Toaster Alert -->
                     <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-animation="true" id="material-alert">
                        <div class="d-flex toster-out">
                           <div class="toast-body"> Hello, world! This is a toast message. </div>
                           <button aria-label="Close" class="btn-close text-white ms-auto  pe-2" data-bs-dismiss="toast" style="margin: -6px;">
                              <span aria-hidden="true">×</span>
                           </button>
                        </div>
                     </div>
                  </div>
                  <form class="form-horizontal" name="saveMaterialDetails" id="saveMaterialDetails">
                     <div class="modal-body pt-2 material-details-modal-body">                          
                        <!-- Row1 -->
                        <div class="row mb-3">
                           <!-- Contract Material ID -->
                           <input type="hidden" name="contract_material_id">
                           <!-- Earlier Approved Quantity -->
                           <input type="hidden" name="earlier_approved_quantity">
                           <!-- Material Status Detail ID -->
                           <input type="hidden" name="material_status_detail_id">
                           <!-- Material Name -->
                           <div class="col-md-12">
                              <label for="" class="form-label">Material Name
                                 <span class="text-red">*</span>
                              </label>
                              <!-- <input type="text" class="form-control" id="" name=""> -->
                              <!-- <textarea class="form-control" rows="1"></textarea> -->
                              <select name="materials" id="materials" class="form-control form-select" data-bs-placeholder="Select Material">
                                 <!-- <option value="select" selected disabled>Select Material</option> -->
                              </select>
                           </div>
                        </div>
                        <!-- Row2 -->
                        <div class=" row mb-1">
                           <!-- Offer Letter Quantity -->
                           <div class="col-md-3">
                              <label for="offerLetterQuantity" class="form-label">Offer Material Quantity
                                 <span class="text-red">*</span>
                              </label>
                              <input type="text" class="form-control" id="offerLetterQuantity" name="offerLetterQuantity">
                           </div>
                           <!-- Date of Readiness -->
                           <div class="col-md-3">
                              <label for="dateOfReadiness" class="form-label">Date of Readiness</label>
                              <div class="input-group">
                                 <div class="input-group-text dates">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                 </div>
                                 <input type="text" class="form-control" id="dateOfReadiness" name="dateOfReadiness" disabled>
                              </div>
                           </div>
                           <!-- PDI Letter No. -->
                           <!-- <div class="col-md-3">
                              <label for="pdiLetterNo" class="form-label">PDI Letter No.</label>
                              <input type="text" class="form-control" id="pdiLetterNo" name="pdiLetterNo" disabled>
                           </div> -->
                           <!-- PDI Letter Date -->
                           <!-- <div class="col-md-3">
                              <label for="pdiLetterDate" class="form-label">PDI Letter Date</label>
                              <div class="input-group">
                                 <div class="input-group-text dates">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                 </div>
                                 <input type="text" class="form-control" name="pdiLetterDate" id="pdiLetterDate" disabled />
                              </div>
                           </div> -->
                           <!-- Inspection Letter No. -->
                           <div class="col-md-3">
                              <label for="inspectionLetterNo" class="form-label">Inspection Letter No.</label>
                              <input type="text" class="form-control" id="inspectionLetterNo" name="inspectionLetterNo" disabled>
                           </div>
                           <!-- Inspection Letter Date -->
                           <div class="col-md-3">
                              <label for="inspectionLetterDate" class="form-label">Inspection Letter Date</label>
                              <div class="input-group">
                                 <div class="input-group-text dates">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                 </div>
                                 <input type="text" class="form-control" name="inspectionLetterDate" id="inspectionLetterDate" disabled />
                              </div>
                           </div>
                        </div>
                        <!-- Row3 -->
                        <div class="row mb-3">
                           <!-- Inspecting Agency -->
                           <!-- <div class="col-md-3">
                              <label for="inspectionAgency" class="form-label">Inspecting Agency</label>
                              <select name="inspectionAgency" class="form-control form-select" data-bs-placeholder="Select Agency" disabled>
                              </select>
                           </div> -->
                           <!-- Date Of Inspection -->
                           <div class="col-md-3">
                              <label for="dateofInspection" class="form-label">Date of Inspection</label>
                              <div class="input-group">
                                 <div class="input-group-text dates">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                 </div>
                                 <input type="text" class="form-control" name="dateofInspection" id="dateofInspection" disabled />
                              </div>
                           </div>
                           <!-- Material Serial Nos -->
                           <div class="col-md-6">
                              <label for="materialSerialNos" class="form-label">Material Serial Nos.
                                 <!-- <span class="text-red">*</span> -->
                              </label>
                              <input type="text" class="form-control" id="materialSerialNos" name="materialSerialNos" disabled>    
                           </div>
                        </div>
                        <!-- Row4 -->
                        <div class="row mb-3">
                           <!-- DI Material No. -->
                           <div class="col-md-3">
                              <label for="diMaterialNo" class="form-label">DI No.
                                 <!-- <span class="text-red">*</span> -->
                              </label>
                              <input type="text" class="form-control" id="diMaterialNo" name="diMaterialNo" disabled>
                           </div>
                           <!-- DI Material Date -->
                           <div class="col-md-3">
                              <label for="diMaterialDate" class="form-label">DI Date
                                 <!-- <span class="text-red">*</span> -->
                              </label>
                              <div class="input-group">
                                 <div class="input-group-text dates">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                 </div>
                                 <input type="text" class="form-control" name="diMaterialDate" id="diMaterialDate" disabled />
                              </div>
                           </div>
                           <!-- DI Quantity -->
                           <div class="col-md-3">
                              <label for="diQuantity" class="form-label">DI Quantity
                                 <!-- <span class="text-red">*</span> -->
                              </label>
                              <input type="text" class="form-control" id="diQuantity" name="diQuantity" disabled>
                           </div>
                           <!-- DI Remark -->
                           <div class="col-md-3">
                              <label for="diRemark" class="form-label">DI Remark
                                 <!-- <span class="text-red">*</span> -->
                              </label>
                              <input type="text" class="form-control" id="diRemark" name="diRemark" disabled>
                           </div>
                        </div>
                        <!-- Row5 -->
                        <div class=" row mb-3">
                        </div>
                        <!-- Row6 -->
                        <div class=" row mb-3">
                           <!-- File Upload -->
                           <div class="col-md-12">
                              <label for="fileUpload" class="form-label">File Upload</label>
                              <input class="form-control" type="file" id="formFileMultiple" name="formFileMultiple[]" multiple>
                              <div class="text-wrap mt-2" id="preview-material_img"></div>
                           </div>
                        </div>
                        <!-- Row7 Material Received Detail -->
                        <div class="row mb-3">
                           <label class="form-label">Material Received Details</label>
                        </div>
                        <!-- Row8 Material Received Detail Table -->
                        <div class="row mb-3">
                           <div class="col-lg-12">
                              <div class="table-responsive">
                                 <table class="table table-bordered border text-nowrap mb-0" id="new-edit-material-received-details">
                                    <thead>
                                       <tr>
                                          <th>Circle</th>
                                          <th>Quantity</th>
                                          <th>Serial Nos</th>
                                          <th>DRR Date</th>
                                          <!-- <th name="bstable-actions">Actions</th> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr id="row-0">
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                    </tbody>
                                </table>
                              </div>
                              <button id="table2-new-row-button-material-received-details" class="btn btn-primary mb-4 mt-4"> Add New Row</button>
                           </div>
                        </div>
                        <!-- Row9 Random Sampling Details -->
                        <div class="row mb-3">
                           <label class="form-label">Random Sampling Details</label>
                        </div>
                        <!-- Row10 Random Sampling Details Table -->
                        <div class="row mb-3">
                           <div class="col-lg-12">
                              <div class="table-responsive">
                                 <table class="table table-bordered border text-nowrap mb-0" id="new-edit-material-sampling-details">
                                    <thead>
                                       <tr>
                                          <th>Circle</th>
                                          <th>Sampling Quantity</th>
                                          <th>Sampling Serial Nos</th>
                                          <th>Sampling Date</th>
                                          <th>Sampling Letter No</th>
                                          <th>Sampling Lab</th>
                                          <th>Accepted Report No</th>
                                          <th>Accepted Report Date</th>
                                          <!-- <th>Accepted Yes/No</th> -->
                                          <th>Accepted Quantity</th>
                                          <!-- <th name="bstable-actions">Actions</th> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                    </tbody>
                                </table>
                              </div>
                              <button id="table2-new-row-button-material-sampling-details" class="btn btn-primary mt-4"> Add New Row</button>
                           </div>
                        </div>
                        <!-- Row11 -->
                        <div class="row mb-3">
                           <!-- MRC Generated No -->
                           <div class="col-md-3">
                              <label for="mrcGeneratedNo" class="form-label">MRC Generated No</label>
                              <input type="text" class="form-control" id="mrcGeneratedNo" name="mrcGeneratedNo">
                           </div>
                           <!-- MRC Generated Date -->
                           <div class="col-md-3">
                              <label for="mrcGeneratedDate" class="form-label">MRC Generated Date</label>
                              <div class="input-group">
                                 <div class="input-group-text dates">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                 </div>
                                 <input type="text" class="form-control" id="mrcGeneratedDate" name="mrcGeneratedDate">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <!-- <button class="btn ripple btn-success" type="button" data-bs-dismiss="modal">Submit</button> -->
                        <button class="btn ripple btn-success" type="submit" data-action="save">Submit</button>
                        <button class="btn ripple btn-primary" data-bs-dismiss="modal" type="button" onclick="findtr()">Close</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!-- Material Details Modal Ends -->

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
      <!-- <script src="<?php //echo base_url('assets/js/form-validation.js'); ?>"></script> -->

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

      <script type="text/javascript">
         let sampling_lab_data = <?php echo json_encode($sampling_lab_data) ?>;
         let circle_list;
      </script>

      <!-- EDIT-TABLE JS -->
      <!-- <script src="assets/plugins/edit-table/bst-edittable.js"></script> -->
      <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-status.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-status-received.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-status-random-sampling.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-edit-table.js'); ?>"></script>

      <!-- DATERANGE PICKER JS -->
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

      <script type="text/javascript">
         $('input[name="TKCOfferLetterDate"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            maxDate: new Date(), 
            locale: {
               format: 'DD-MM-YYYY',
            }
         });

         $('input[name="TKCOfferLetterDate"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
         });

         $('input[name="tenderAwardDate"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
               format: 'DD-MM-YYYY',
            }
         });         

         $(document).ready(function() {
            let edit_btn = $('#new-add-material-details > tbody').find('.b-Edit');

            $(edit_btn).each(function(index, value) {
               // console.log(value); return false;
               $(value).attr('data-action', 'add');
            });
         });

         var form_change = false;

         $('#addMaterialStatus').on('submit', function(event) {            
            let contractor = $('input[name="contractorTKC"]').val();
            let tkc_offer_letter_no = $('input[name="TKCOfferLetterNo"]').val();
            let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();
            
            let first_tr = $('#new-add-material-details').find('tbody tr:first');
            let material = $(first_tr).find('.material-name').text();

            if (contractor === '') {
               $('.toast-body').text('Enter Contractor Details');
               $('.toast').toast('show');
               event.preventDefault();
            }

            if (tkc_offer_letter_no === '') {
               $('.toast-body').text('Enter TKC Offer Letter No');
               $('.toast').toast('show');
               event.preventDefault();
            }

            if (tkc_offer_letter_date === '') {
               $('.toast-body').text('Enter TKC Offer Letter Date');
               $('.toast').toast('show');
               event.preventDefault();  
            }

            if (material === '') {
               $('.toast-body').text('No Material Details added');
               $('.toast').toast('show');
               event.preventDefault();    
            }
         });

         //Ajax Call to get Contractor Details
         function showtkclist(tkcValue) {
            $.ajax({
               type: 'POST',
               url: '<?php echo base_url('search-contractor') ?>',
               dataType: 'json',
               data: {contractor: tkcValue},
               success: function(response){
                  // console.log(response);

                  $('#list-view').show();
                  $('#list-view').empty();

                  var html = '';

                  let contractor_data = response.contractor_data;
                  if ($.isEmptyObject(contractor_data)) {
                     html += 'No Contractor Found';
                  } else {
                     $.each(contractor_data, function(index, value){
                        // console.log(value);
                        html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start" data-typeofwork-id="'+value.typeofwork_id+'" data-contract-id="'+value.contract_id+'" onclick=applyContractorDetails(this)>';
                        html += '<div class="d-flex w-100 justify-content-between">';
                        html += '<h4 class="mb-1 contractor-name"><strong>'+value.contractor_name+'</strong></h4>';
                        html += '<small class="text-muted contract-date">Contract Date : <span class="text-primary"> '+value.tender_award_date+'</span></small>';
                        html += '</div>';
                        html += '<p class="mb-1 type-of-work">Type Of Work: <span class="text-primary"> '+value.typeofwork_name+'</span></p>';
                        html += '<small class="text-muted contract-no">Contract No: <span class="text-primary">'+value.tender_award_no+'</span></small>';
                        html += '</a>';
                     });
                  }

                  $('#list-view').append(html);
               },
               error: function(xhr, status, error){
                  console.log(xhr.responseText);
               }
            });
         }

         //Applying selected contractor values
         function applyContractorDetails(anchor) {
            $('#list-view').hide();

            let contractor_name = $(anchor).find('.contractor-name').text();
            let contract_id = $(anchor).attr('data-contract-id');
            let tender_award_no = $(anchor).find('.contract-no span').text();
            let tender_award_date = $(anchor).find('.contract-date span').text();
            let typeofwork_name = $(anchor).find('.type-of-work span').text();
            let typeofwork_id = $(anchor).attr('data-typeofwork-id');            

            $('input[name="contractorTKC"]').val(contractor_name);
            $('input[name="contract_id"]').val(contract_id);

            $('input[name="tenderAwardNo"]').val(tender_award_no);
            $('input[name="tenderAwardNo"]').prop('readonly', true);

            $('input[name="tenderAwardDate"]').val(tender_award_date);
            $('input[name="tenderAwardDate"]').prop('disabled', true);

            $('#typeOfWork').val([typeofwork_id, typeofwork_name]).trigger('change');
            $('#typeOfWork').prop('disabled', true);

            getMaterials(contract_id);
            getCircles(contract_id);
         }

         //Closes the contractor search list view on document click
         $(document).click(function() {
            // alert('click');
            var list_view = $('#list-view');
            if (!list_view.is(event.target) && !list_view.has(event.target).length) {
               list_view.hide();
            }
         });         

         //Displaying Material Details Modal
         function showMaterialDetails(btn) {
            let contractor = $('input[name="contractorTKC"]').val();
            let tkc_offer_letter_no = $('input[name="TKCOfferLetterNo"]').val();
            let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();

            if (contractor === '') {
               $('.toast-body').text('Select Contractor (TKC)');
               $('.toast').toast('show');

               return false;
            } else if (tkc_offer_letter_no === '') {
               $('.toast-body').text('Enter TKC Offer Letter No.');
               $('.toast').toast('show');

               return false;
            } else if (tkc_offer_letter_date === '') {
               $('.toast-body').text('Enter TKC Offer Letter Date');
               $('.toast').toast('show');

               return false;
            } else {
               actionsModeEdit(btn);

               let contract_id = $('input[name="contract_id"]').val();
               let attr = $(btn).attr('data-material-status-details-id');

               if (typeof attr !== 'undefined' && attr !== false) {
                  let material_status_detail_id = $(btn).attr('data-material-status-details-id');                  
                  $('input[name="material_status_detail_id"]').val(material_status_detail_id);

                  //Ajax call to get material details to display on the modal
                  $.ajax({
                     type: 'POST',
                     url: '<?php echo base_url('get-material-details') ?>',
                     dataType: 'json',
                     data: {material_status_detail_id: material_status_detail_id, contract_id: contract_id},
                     success: function(response) {
                        /*console.log('response:');
                        console.log(response);*/
                        if (!$.isEmptyObject(response.material_details_data)) {
                           let materialDetailsData = response.material_details_data;
                           // console.log(materialDetailsData);

                           //Setting Contract Material ID
                           $('input[name="contract_material_id"]').val(response.material_details_data['contract_material_id']);

                           //Displaying Material Name
                           let material_name = materialDetailsData.material_name;
                           // $('select[name="materials"] option:contains(' + material_name + ')').attr('selected', 'selected');
                           $('select[name="materials"]').val(response.material_details_data['contract_material_id']);

                           //Displaying Offer Material Quantity
                           $('input[name="offerLetterQuantity"]').val(materialDetailsData.offer_letter_quantity);

                           //Displaying Date of Readiness
                           $('input[name="dateOfReadiness"]').val(materialDetailsData.date_of_readiness);

                           //Displaying Inspection Letter No.
                           if (materialDetailsData.inspection_letter_no != null) {
                              $('input[name="inspectionLetterNo"]').val(materialDetailsData.inspection_letter_no);   
                           }

                           //Displaying Inspection Letter Date
                           if (materialDetailsData.inspection_letter_date != null) {
                              $('input[name="inspectionLetterDate"]').val(materialDetailsData.inspection_letter_date);
                           }

                           //Displaying Date of Inspection
                           if (materialDetailsData.date_of_inspection != null) {
                              $('input[name="dateofInspection"]').val(materialDetailsData.date_of_inspection);
                           }

                           //Displaying Material Serial Nos.
                           if (materialDetailsData.material_serial_nos != null) {
                              $('input[name="materialSerialNos"]').val(materialDetailsData.material_serial_nos);
                           }

                           //Displaying DI No.
                           if (materialDetailsData.di_material_no != null) {
                              $('input[name="diMaterialNo"]').val(materialDetailsData.di_material_no);
                           }
                           
                           //Displaying DI Date
                           if (materialDetailsData.di_material_date != null) {
                              $('input[name="diMaterialDate"]').val(materialDetailsData.di_material_date);
                           }

                           //Displaying DI Quantity
                           if (materialDetailsData.di_quantity != null) {
                              $('input[name="diQuantity"]').val(materialDetailsData.di_quantity);
                           }

                           //Displaying DI Remark
                           if (materialDetailsData.di_remarks != null) {
                              $('input[name="diRemark"]').val(materialDetailsData.di_remarks);
                           }

                           //Displaying File Upload
                           if (!$.isEmptyObject(materialDetailsData.material_files)) {
                              $('#preview-material_img').empty();
                              let file_html = '';
                              $.each(materialDetailsData.material_files, function(index, value) {
                                 var file_path = '<?php echo base_url() ?>'+value.file_path;

                                 file_html += '<div class="file-image-1">';
                                 file_html += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
                                 file_html += '<img src="'+file_path+'" class="br-5" alt="">';
                                 file_html += '</a>';
                                 /*file_html += '<ul class="icons">';
                                 file_html += '<li>';
                                 file_html += '<a href="javascript:void(0)" class="btn bg-danger">';
                                 file_html += '<i class="fe fe-trash"></i>';
                                 file_html += '</a>';
                                 file_html += '</li>';
                                 file_html += '</ul>';*/
                                 file_html += '</div>';
                              });

                              $('#preview-material_img').append(file_html);
                           }

                           //Displaying Material Received Details
                           if (!$.isEmptyObject(materialDetailsData.received_materials_details)) {
                              $('#new-edit-material-received-details tbody').empty();
                              let material_html = '';

                              $.each(materialDetailsData.received_materials_details, function(index, value) {
                                 material_html += '<tr>';
                                 material_html += '<td name="bstable-actions">';
                                 material_html += '<div class="btn-list">';
                                 material_html += '<button id="bEdit" type="button" class="btn btn-sm">';
                                 material_html += '<span class="fe fe-edit fa-lg action-btn-table"> </span>';
                                 material_html += '</button>';
                                 material_html += '<button id="bDel" type="button" class="btn  btn-sm">';
                                 material_html += '<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>';
                                 material_html += '</button>';
                                 material_html += '</div>';
                                 material_html += '</td>';
                                 material_html += '<td>'+value.circle_name+'</td>';
                                 material_html += '<td class="received-qty">'+value.quantity+'</td>';
                                 material_html += '<td>'+value.serial_nos+'</td>';
                                 material_html += '<td class="received-date">'+value.received_date+'</td>';
                                 material_html += '</tr>';
                              });

                              $('#new-edit-material-received-details tbody').append(material_html);
                           }

                           //Displaying Random Sampling Details
                           if (!$.isEmptyObject(materialDetailsData.received_materials_details)) {
                              $('#new-edit-material-sampling-details > tbody').empty();
                              let sampling_html = '';

                              $.each(materialDetailsData.random_sampling_details, function(index, value) {
                                 sampling_html += '<tr>';
                                 sampling_html += '<td name="bstable-actions">';
                                 sampling_html += '<div class="btn-list">';
                                 sampling_html += '<button id="bEdit" type="button" class="btn btn-sm">';
                                 sampling_html += '<span class="fe fe-edit fa-lg action-btn-table"> </span>';
                                 sampling_html += '</button>';
                                 sampling_html += '<button id="bDel" type="button" class="btn  btn-sm">';
                                 sampling_html += '<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>';
                                 sampling_html += '</button>';
                                 sampling_html += '</div>';
                                 sampling_html += '</td>';
                                 sampling_html += '<td>'+value.circle_name+'</td>';
                                 sampling_html += '<td>'+value.sampling_quantity+'</td>';
                                 sampling_html += '<td>'+value.sampling_serial_nos+'</td>';
                                 sampling_html += '<td>'+value.sampling_date+'</td>';
                                 sampling_html += '<td>'+value.sampling_letter_no+'</td>';
                                 sampling_html += '<td>'+value.lab_name+'</td>';
                                 sampling_html += '<td>'+value.accepted_report_no+'</td>';
                                 sampling_html += '<td>'+value.accepted_report_date+'</td>';
                                 sampling_html += '<td>'+value.accepted_quantity+'</td>';
                                 sampling_html += '</tr>';
                              });

                              $('#new-edit-material-sampling-details > tbody').append(sampling_html);
                           }

                           //Displaying MRC Generated No
                           if (materialDetailsData.mrc_generated_no != null) {
                              $('input[name="mrcGeneratedNo"]').val(materialDetailsData.mrc_generated_no);
                           }

                           //Displaying MRC Generated Date
                           if (materialDetailsData.mrc_generated_date != null) {
                              $('input[name="mrcGeneratedDate"]').val(materialDetailsData.mrc_generated_date);
                           }

                           //Changing text of submit button
                           $('#materail-details-modal').find('button[type="submit"]').text('Update');
                           $('#materail-details-modal').find('button[type="submit"]').attr('data-action', 'update');
                        }
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                     }
                  });
               } else {
                  getMaterials(contract_id);

                  //Changing text of submit button
                  $('#materail-details-modal').find('button[type="submit"]').text('Submit');
                  $('#materail-details-modal').find('button[type="submit"]').attr('data-action', 'save');
               }

               // $('#materail-details-modal').find('button[type="submit"]').text('Submit');
               $('#materail-details-modal').modal('show');   
            }
         }

         function getMaterials(contract_id) {
            // Ajax call to get list of materials
            $.ajax({
               type: 'POST',
               url: '<?php echo base_url('get-materials') ?>',
               dataType: 'json',
               data: {contract_id: contract_id},
               success: function(response) {
                  // console.log(response); return false;
                  let material_data = response.material_data;
                  let inspecting_agencies = response.inspecting_agency_data;
                  let html = '';
                  let agency_html = '';

                  //Appending Materials
                  $('select[name="materials"]').empty();

                  if ($.isEmptyObject(material_data)) {
                     html += '<option value="na">No Material Found</option>';
                  } else {
                     html += '<option value="select" selected disabled>Select Material</option>';
                     $.each(material_data, function(index, value) {
                        html += '<option value="'+value.contract_material_id+'">'+value.item_code + ' - ' + value.equipment_material_name+'</option>';
                     });                     
                  }

                  $('select[name="materials"]').append(html);

                  //Appending Inspecting Agencies
                  /*$('select[name="inspectionAgency"]').empty();

                  if ($.isEmptyObject(inspecting_agencies)) {
                     agency_html += '<option value="0">No Inspecting Agency Found</option>'
                  } else {
                     agency_html += '<option value="select" selected disabled>Select Agency</option>';
                     $.each(inspecting_agencies, function(index, value) {
                        agency_html += '<option value="'+value.inspecting_agency_id+'">'+value.name+'</option>'
                     });
                  }

                  $('select[name="inspectionAgency"]').append(agency_html);*/
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });  
         }

         function getCircles(contract_id) {
            //Ajax call to get list of circles
            $.ajax({
               type: 'POST',
               url: '<?php echo base_url('get-circles') ?>',
               dataType: 'json',
               data: {contract_id: contract_id},
               success: function(response) {
                  // console.log(response);
                  circle_list = response.circle_data;
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });
         }

         $('select[name="materials"]').on('change', function() {
            //Changing status of form to edited by setting below variable true
            form_change = true;

            let material_id = this.value;
            let contract_id = $('input[name="contract_id"]').val();
            let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();

            $.ajax({
               type: 'POST',
               url: '<?php echo base_url('get-material-quantity') ?>',
               dataType: 'json',
               data: {material_id: material_id, contract_id: contract_id, tkc_offer_letter_date: tkc_offer_letter_date},
               success: function(response) {
                  // console.log(response); return false;
                  $('#material-quantity').removeAttr('hidden');
                  $('.material-qty').text(response.material_qty);

                  $('input[name="contract_material_id"]').val(response.contract_material_id);
                  $('input[name="earlier_approved_quantity"]').val(response.approve_quantity);
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });
         });

         $('input[name="offerLetterQuantity"]').keyup(function() {
            let offer_letter_qty = parseInt(this.value);            
            let material_qty = parseInt($('.material-qty').text());

            if (offer_letter_qty > material_qty) {
               $('#material-alert').find('.toast-body').text('Offer Letter quantity cannot exceed Material quantity');
               $('#material-alert').toast('show');

               $('input[name="dateOfReadiness"]').prop('disabled', true);

               return false;
            } else {
               if (isNaN(offer_letter_qty)) {
                  $('input[name="dateOfReadiness"]').prop('disabled', true);
               } else {

                  enableInputBlock();

                  setDateOfReadiness();
               }
            }
         });

         function enableInputBlock() {
            $('input[name="dateOfReadiness"]').prop('disabled', false);
            /*$('input[name="pdiLetterNo"]').prop('disabled', false);
            $('input[name="pdiLetterDate"]').prop('disabled', false);*/
            $('input[name="inspectionLetterNo"]').prop('disabled', false);
            $('input[name="inspectionLetterDate"]').prop('disabled', false);
            // $('select[name="inspectionAgency"]').prop('disabled', false);
            $('input[name="dateofInspection"]').prop('disabled', false);
            $('input[name="materialSerialNos"]').prop('disabled', false);
            $('input[name="diMaterialNo"]').prop('disabled', false);
            $('input[name="diMaterialDate"]').prop('disabled', false);
            $('input[name="diQuantity"]').prop('disabled', false);
            $('input[name="diRemark"]').prop('disabled', false);
         }

         function setDateOfReadiness() {
            let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();

            $('input[name="dateOfReadiness"]').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoUpdateInput: false,
               minDate: getModifiedDate(tkc_offer_letter_date),
               parentEl: '#materail-details-modal .modal-body',
               locale: {
                  format: 'DD-MM-YYYY'
               }
            });

            $('input[name="dateOfReadiness"]').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('DD-MM-YYYY'));
               form_change = true;
            });
         }

         /*$('input[name="pdiLetterDate"]').focus(function() {
            let dateOfReadiness = $('input[name="dateOfReadiness"]').val();

            if (dateOfReadiness == '') {
               $('#material-alert').find('.toast-body').text('Select Date of Readiness');
               $('#material-alert').toast('show');
               return false;
            } else {
               let pdiLetterNo = $('input[name="pdiLetterNo"]').val();
               
               if (pdiLetterNo == '') {
                  $('#material-alert').find('.toast-body').text('Enter PDI Letter No');
                  $('#material-alert').toast('show');
                  return false;
               } else {
                  setPdiLetterDate(dateOfReadiness);   
               }
            }
         });*/

         /*function setPdiLetterDate(dateOfReadiness) {
            $('input[name="pdiLetterDate"]').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoUpdateInput: false,
               minDate: getModifiedDate(dateOfReadiness),
               opens: 'left',
               parentEl: '#materail-details-modal .modal-body',
               locale: {
                  format: 'DD-MM-YYYY'
               }
            });

            $('input[name="pdiLetterDate"]').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });
         }*/

         $('input[name="inspectionLetterDate"]').focus(function() {
            let dateOfReadiness = $('input[name="dateOfReadiness"]').val();

            if (dateOfReadiness == '') {
               $('#material-alert').find('.toast-body').text('Select Date of Readiness');
               $('#material-alert').toast('show');
               return false;
            } else {
               let inspectionLetterNo = $('input[name="inspectionLetterNo"]').val();

               if (inspectionLetterNo == '') {
                  $('#material-alert').find('.toast-body').text('Enter Inspection Letter No');
                  $('#material-alert').toast('show');
                  return false;
               } else {
                  setInspectionLetterDate(dateOfReadiness);   
               }
            }
         });

         function setInspectionLetterDate(dateOfReadiness) {
            $('input[name="inspectionLetterDate"]').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoUpdateInput: false,
               minDate: getModifiedDate(dateOfReadiness),
               maxDate: new Date(), 
               opens: 'left',
               parentEl: '#materail-details-modal .modal-body',
               locale: {
                  format: 'DD-MM-YYYY'
               }                     
            });

            $('input[name="inspectionLetterDate"]').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('DD-MM-YYYY'));
               form_change = true;
            });
         }

         $('input[name="dateofInspection"]').focus(function() {
            let inspectionLetterDate = $('input[name="inspectionLetterDate"]').val();

            if (inspectionLetterDate == '') {
               $('#material-alert').find('.toast-body').text('Select Inspection Letter Date');
               $('#material-alert').toast('show');
               return false;
            } else {
               /*let inspectionAgency = $('select[name="inspectionAgency"] :selected').text();
               console.log('inspectionAgency: '+ inspectionAgency);

               if (inspectionAgency == 'Select Agency') {
                  $('#material-alert').find('.toast-body').text('Select Inspection Agency');
                  $('#material-alert').toast('show');
                  return false;
               } else {
                  setDateofInspection(inspectionLetterDate);   
               }*/

               setDateofInspection(inspectionLetterDate);
            }
         });

         function setDateofInspection(inspectionLetterDate) {
            $('input[name="dateofInspection"]').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoUpdateInput: false,
               minDate: getModifiedDate(inspectionLetterDate),
               // maxDate: new Date(), 
               opens: 'right',
               parentEl: '#materail-details-modal .modal-body',
               locale: {
                  format: 'DD-MM-YYYY'
               }
            });

            $('input[name="dateofInspection"]').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('DD-MM-YYYY'));
               form_change = true;
            });
         }

         $('input[name="diMaterialDate"]').focus(function() {
            let inspectionLetterDate = $('input[name="inspectionLetterDate"]').val();

            if (inspectionLetterDate == '') {
               $('#material-alert').find('.toast-body').text('Select Inspection Letter Date');
               $('#material-alert').toast('show');
               return false;
            } else {
               let diMaterialNo = $('input[name="diMaterialNo"]').val();

               if (diMaterialNo == '') {
                  $('#material-alert').find('.toast-body').text('Enter Di Material No');
                  $('#material-alert').toast('show');
                  return false;
               } else {
                  setDiMaterialDate(inspectionLetterDate);   
               }
            }
         });

         function setDiMaterialDate(inspectionLetterDate) {
            $('input[name="diMaterialDate"]').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoUpdateInput: false,
               minDate: getModifiedDate(inspectionLetterDate),
               // maxDate: new Date(), 
               opens: 'left',
               parentEl: '#materail-details-modal .modal-body',
               locale: {
                  format: 'DD-MM-YYYY'
               }                     
            });

            $('input[name="diMaterialDate"]').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('DD-MM-YYYY'));
               form_change = true;
            });
         }

         $('input[name="diQuantity"]').focus(function() {
            let diMaterialNo = $('input[name="diMaterialNo"]').val();
            let diMaterialDate = $('input[name="diMaterialDate"]').val();

            if (diMaterialNo == '') {
               $('#material-alert').find('.toast-body').text('Enter Di No');
               $('#material-alert').toast('show');
               return false;
            }

            if (diMaterialDate == '') {
               $('#material-alert').find('.toast-body').text('Enter Di Date');
               $('#material-alert').toast('show');
               return false;
            }
         });

         $('input[name="diRemark"]').focus(function() {
            let diMaterialNo = $('input[name="diMaterialNo"]').val();
            let diMaterialDate = $('input[name="diMaterialDate"]').val();
            let diQuantity = $('input[name="diQuantity"]').val();

            if (diMaterialNo == '') {
               $('#material-alert').find('.toast-body').text('Enter Di No');
               $('#material-alert').toast('show');
               return false;
            }

            if (diMaterialDate == '') {
               $('#material-alert').find('.toast-body').text('Enter Di Date');
               $('#material-alert').toast('show');
               return false;
            }

            if (diQuantity == '') {
               $('#material-alert').find('.toast-body').text('Enter Di Quantity');
               $('#material-alert').toast('show');
               return false;
            }
         });

         $('input[name="mrcGeneratedDate"]').focus(function() {
            let random_sampling_tr = $('#new-edit-material-sampling-details > tbody').find('tr').eq(0);
            
            let accepted_report_date = $(random_sampling_tr).find('td').eq(8).text();

            if (accepted_report_date != '') {
               setMrcGeneratedDate(accepted_report_date);
            }
         });

         function setMrcGeneratedDate(accepted_report_date) {
            $('input[name="mrcGeneratedDate"]').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               drops: "up",
               autoUpdateInput: false,
               minDate: getModifiedDate(accepted_report_date),
               maxDate: new Date(), 
               parentEl: '#materail-details-modal .modal-body',
               locale: {
                  format: 'DD-MM-YYYY'
               }
            });

            $('input[name="mrcGeneratedDate"]').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('DD-MM-YYYY'));
               form_change = true;
            });   
         }         

         function findtr() {
            let tr = $('tr[data-status="editing"]');
            actionsModeNormal(tr);

            // resetModal();
         }

         function actionsModeNormal(button) {
            $(button).find('#bAcep').hide();
            $(button).find('#bCanc').hide();
            $(button).find('#bEdit').show();
            $(button).find('#bDel').show();
             
            $(button).attr('data-status', ''); // remove editing status
         }

         function actionsModeEdit(button) {
            $(button).parent().find('#bAcep').show();
            $(button).parent().find('#bCanc').show();
            $(button).parent().find('#bEdit').hide();
            $(button).parent().find('#bDel').hide();
            let $currentRow = $(button).parents('tr'); // get the row
            $currentRow.attr('data-status', 'editing'); // indicate the editing status
         }

         /*function resetModal() {
            $('#saveMaterialDetails')[0].reset();
         }*/

         //Saving material details
         $('#saveMaterialDetails').on('submit', function(event) {
            /*console.log(form_change);
            event.preventDefault();*/

            var inputs = $('#saveMaterialDetails').find(':input');
            $(inputs).each(function(index, value) {
               $(this).change(function(){
                  form_change = true;
               });
            });

            // console.log('form_change:'+ form_change);

            let select_val = $('select[name="materials"]').val();
            let offer_letter_qty = $('input[name="offerLetterQuantity"]').val();            

            if (select_val == null && offer_letter_qty === '') {
               $('#material-alert').find('.toast-body').text('Enter value for mandatory fields');
               $('#material-alert').toast('show');

               event.preventDefault();
            } else if (select_val == null) {
               $('#material-alert').find('.toast-body').text('Select Material');
               $('#material-alert').toast('show');

               event.preventDefault();
            } else if (offer_letter_qty === '') {
               $('#material-alert').find('.toast-body').text('Enter Offer Letter Quantity');
               $('#material-alert').toast('show');

               event.preventDefault();
            } else if (form_change == false) {
               $('#material-alert').find('.toast-body').text('No changes occurred on the form to be submitted');
               $('#material-alert').toast('show');

               event.preventDefault();
            } else {
               let tr = $('tr[data-status="editing"]');               
               let tds = $(tr).find('td'); //check if required
               let modal = $('#materail-details-modal');

               let contract_id = $('input[name="contract_id"]').val();
               let material_status_id = $('input[name="material_status_id"]').val(); 
               let discom = 'MPPKVVCL/Jabalpur';
               let tkc_offer_letter_no = $('input[name="TKCOfferLetterNo"]').val();
               let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();
               let material_status_detail_id = $('input[name="material_status_detail_id"]').val();

               //Pushing material details from modal in an object
               let materialData = {};
               var key;

               let contract_material_id = $('input[name="contract_material_id"]').val();
               key = 'contract_material_id';
               materialData[key] = contract_material_id;

               let material_name = $(modal).find('select[name="materials"] option:selected').text();
               key = 'material_name';
               materialData[key] = material_name;

               let offerLetterQuantity = $(modal).find('input[name="offerLetterQuantity"]').val();
               key = 'offerLetterQuantity';
               materialData[key] = offerLetterQuantity;

               let dateOfReadiness = $(modal).find('input[name="dateOfReadiness"]').val();
               key = 'dateOfReadiness';
               materialData[key] = dateOfReadiness;

               /*let pdiLetterNo = $(modal).find('input[name="pdiLetterNo"]').val();
               key = 'pdiLetterNo';
               materialData[key] = pdiLetterNo;*/

               /*let pdiLetterDate = $(modal).find('input[name="pdiLetterDate"]').val();
               key = 'pdiLetterDate';
               materialData[key] = pdiLetterDate;*/

               let inspectionLetterNo = $(modal).find('input[name="inspectionLetterNo"]').val();
               key = 'inspectionLetterNo';
               materialData[key] = inspectionLetterNo;

               let inspectionLetterDate = $(modal).find('input[name="inspectionLetterDate"]').val();
               key = 'inspectionLetterDate';
               materialData[key] = inspectionLetterDate;

               /*let inspectionAgency = $(modal).find('select[name="inspectionAgency"]').val();
               key = 'inspectionAgency';
               materialData[key] = inspectionAgency;*/

               let dateofInspection = $(modal).find('input[name="dateofInspection"]').val();
               key = 'dateofInspection';
               materialData[key] = dateofInspection;

               let materialSerialNos = $(modal).find('input[name="materialSerialNos"]').val();
               key = 'materialSerialNos';
               materialData[key] = materialSerialNos;

               let diMaterialNo = $(modal).find('input[name="diMaterialNo"]').val();
               key = 'diMaterialNo';
               materialData[key] = diMaterialNo;

               let diMaterialDate = $(modal).find('input[name="diMaterialDate"]').val();
               key = 'diMaterialDate';
               materialData[key] = diMaterialDate;

               let diQuantity = $(modal).find('input[name="diQuantity"]').val();
               key = 'diQuantity';
               materialData[key] = diQuantity;

               let diRemark = $(modal).find('input[name="diRemark"]').val();
               key = 'diRemark';
               materialData[key] = diRemark;

               //Material Received Details
               let material_received_table_body = $(modal).find('#new-edit-material-received-details > tbody');
               let material_received_trs = $(material_received_table_body).find('tr');

               let material_received_arr = [];
               $.each(material_received_trs, function(index, value) {

                  let material_tds = $(value).find('td');                  
                  let circle, qty, serial_nos, received_date;

                  $.each(material_tds, function(ind, val) {
                     switch(ind) {
                        case 1:
                           circle = $(val).text();
                        case 2: 
                           qty = $(val).text();
                        case 3:
                           serial_nos = $(val).text();
                        case 4:
                           received_date = $(val).text();
                        default:
                           return;
                     }
                  });

                  material_received_arr.push({'circle' : circle, 'received_qty' : qty, 'received_serial_nos' : serial_nos, 'received_date' : received_date});
               });

               key = 'materialReceivedData';
               materialData[key] = material_received_arr;

               //Random Sampling Details
               let sampling_details_table_body = $(modal).find('#new-edit-material-sampling-details > tbody');
               let sampling_details_trs = $(sampling_details_table_body).find('tr');

               let sampling_details_arr = [];
               $.each(sampling_details_trs, function(index, value) {
                  let sampling_tds = $(value).find('td');
                  let circle, sampling_qty, sampling_serial_nos, sampling_date, sampling_letter_no, sampling_lab, accepted_report_no, accepted_report_date, accepted_qty;

                  $.each(sampling_tds, function(ind, val) {
                     switch(ind) {
                        case 1:
                           circle = $(val).text();
                        case 2:
                           sampling_qty = $(val).text();
                        case 3:
                           sampling_serial_nos = $(val).text();
                        case 4:
                           sampling_date = $(val).text();
                        case 5:
                           sampling_letter_no = $(val).text();
                        case 6:
                           sampling_lab = $(val).text();
                        case 7:
                           accepted_report_no = $(val).text();
                        case 8:
                           accepted_report_date = $(val).text();
                        case 9:
                           accepted_qty = $(val).text();
                        default:
                           return;
                     }
                  });

                  sampling_details_arr.push({'circle' : circle, 'sampling_qty' : sampling_qty, 'sampling_serial_nos' : sampling_serial_nos, 'sampling_date' : sampling_date, 'sampling_letter_no' : sampling_letter_no, 'sampling_lab' : sampling_lab, 'accepted_report_no' : accepted_report_no, 'accepted_report_date' : accepted_report_date, 'accepted_qty' : accepted_qty})
               });

               key = 'randomSamplingData';
               materialData[key] = sampling_details_arr;

               let mrcGeneratedNo = $(modal).find('input[name="mrcGeneratedNo"]').val();
               key = 'mrcGeneratedNo';
               materialData[key] = mrcGeneratedNo;

               let mrcGeneratedDate = $(modal).find('input[name="mrcGeneratedDate"]').val();
               key = 'mrcGeneratedDate';
               materialData[key] = mrcGeneratedDate;

               // File Upload
               let form_data = new FormData();

               let uploadedFiles = $('#formFileMultiple')[0].files;
               for (var i = 0; i < uploadedFiles.length; i++) {
                  form_data.append('material_files[]', uploadedFiles[i]);
               }

               form_data.append('contract_id', contract_id);
               form_data.append('material_status_id', material_status_id);
               form_data.append('material_status_detail_id', material_status_detail_id);
               form_data.append('discom', discom);
               form_data.append('tkc_offer_letter_no', tkc_offer_letter_no);
               form_data.append('tkc_offer_letter_date', tkc_offer_letter_date);
               form_data.append('material_details', JSON.stringify(materialData));

               /*console.log('form_data:');
               console.log(form_data); */

               let action = $('#materail-details-modal').find('button[type="submit"]').attr('data-action');

               $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url('save-material-details') ?>',
                  // url: form_url,
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  data: form_data,
                  success: function(response) {
                     /*console.log('response:');
                     console.log(response); 
                     console.log('materialData:');
                     console.log(materialData);*/
                     if (response.material_status_detail_id) {
                        //Assigning material_status_id value
                        $('input[name="material_status_id"]').val(response.material_status_id);

                        //Adding material details id to action buttons via data-material-details-id attr
                        let action_btns = $(tr).find('button');
                        $(action_btns).each(function(index, value) {
                           $(value).attr('data-material-status-details-id', response.material_status_detail_id);
                        });

                        let sr_no; 
                        if (action == 'save') {
                           //Finding all table rows
                           let trs = $('#new-add-material-details > tbody').find('tr');
                           let prev_sr_no;      
                           if (trs.length == 1) {
                              prev_sr_no = 0;      
                           } else {
                              //Finding second last tr
                              let last_tr_index = (trs.length) - 2;
                              
                              let last_tr = $('#new-add-material-details > tbody').find('tr').eq(last_tr_index);
                              prev_sr_no = $(last_tr).find('td.sr-no').text();
                           }
                           
                           sr_no = parseInt(prev_sr_no) + 1;
                           
                        } else if (action == 'update') {
                           let editing_tr = $('#new-add-material-details').find('tr[data-status="editing"]');
                           sr_no = $(editing_tr).find('td.sr-no').text();
                        }

                        //Displaying SR No
                        $(tr).find('td.sr-no').text(sr_no);                        

                        //Displaying Material Name
                        $(tr).find('td.material-name').text(materialData['material_name']);

                        let quantities = response.quantities;

                        //Displaying Original BOQ Quantity
                        $(tr).find('td.og-boq-qty').text(quantities.quantity);

                        //Displaying Revised BOQ Quantity
                        $(tr).find('td.revised-boq-qty').text(quantities.revised_quantity);

                        //Displaying Earlier Approved Quantity
                        let earlier_approved_qty = $('input[name="earlier_approved_quantity"]').val();
                        // let earlier_approved_qty = parseFloat(0);
                        $(tr).find('td.approved-qty').text(parseFloat(earlier_approved_qty).toFixed(2)); // Need to calculate

                        //Displaying Balance Quantity
                        let bal_qty = parseFloat(quantities.revised_quantity - earlier_approved_qty);
                        $(tr).find('td.bal-qty').text(bal_qty.toFixed(2));

                        //Displaying Offer Letter Quantity                        
                        $(tr).find('td.offer-letter-qty').text(parseFloat(offerLetterQuantity).toFixed(2));

                        //Displaying Date of Readiness
                        $(tr).find('td.date-of-readiness').text(materialData['dateOfReadiness']);

                        //Displaying PDI Letter No.
                        // $(tr).find('td.pdi-letter-no').text(materialData['pdiLetterNo']);

                        //Displaying PDI Letter Date.
                        // $(tr).find('td.pdi-letter-date').text(materialData['pdiLetterDate']);

                        //Displaying Inspection Letter No.
                        $(tr).find('td.inspection-letter-no').text(materialData['inspectionLetterNo']);

                        //Displaying Inspection Letter Date
                        $(tr).find('td.inspection-letter-date').text(materialData['inspectionLetterDate']);

                        //Displaying DI Material No.
                        $(tr).find('td.di-material-no').text(materialData['diMaterialNo']);

                        //Displaying DI Material Date
                        $(tr).find('td.di-material-date').text(materialData['diMaterialDate']);

                        //Displaying DI Quantity
                        $(tr).find('td.di-qty').text(materialData['diQuantity']);
                        
                        //Displaying Material Received Date
                        $(tr).find('td.material-received-date').text(materialData['materialReceivedData'][0].received_date);
                        
                        //Displaying Material Received Quantity
                        $(tr).find('td.material-received-qty').text(materialData['materialReceivedData'][0].received_qty);

                        //Displaying Sample Size
                        $(tr).find('td.sample-size').text(materialData['randomSamplingData'][0].sampling_qty);

                        //Displaying Sampling Date
                        $(tr).find('td.sampling-date').text(materialData['randomSamplingData'][0].sampling_date);

                        //Displaying Date of Acceptance
                        $(tr).find('td.date-of-acceptance').text(materialData['randomSamplingData'][0].accepted_report_date);

                        //Displaying Acceptance Quantity
                        $(tr).find('td.acceptance-quantity').text(materialData['randomSamplingData'][0].accepted_qty);

                        //Displaying MRC Generated No
                        $(tr).find('td.mrc-generated-no').text(materialData['mrcGeneratedNo']);

                        //Displaying File Upload
                        $(tr).find('.file-upload').empty();
                        let file_html = '';
                        $.each(response.material_files, function(index, value) {
                           var file_path = '<?php echo base_url(); ?>' + value;

                           file_html += '<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block">';
                           file_html += '<img src="'+file_path+'" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">';
                           file_html += '</a>';
                        });

                        $(tr).find('.file-upload').append(file_html);

                        //Closing the material details modal
                        $(modal).modal('hide');

                        //Clearing data of material details modal on close
                        $(modal).on('hidden.bs.modal', function () {
                          $(this).removeData('bs.modal');
                          $('#material-quantity').attr('hidden', true);
                          actionsModeNormal(tr);
                          form_change = false;
                        });
                        $(modal).find('form').trigger('reset');
                     }

                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                  }
               });

               event.preventDefault();
            }            
         });

         $('#table2-new-row-button-material-details').click(function(e) {
            e.preventDefault();
         });

         function getModifiedDate(date) {
            var parts = date.split("-")
            return new Date(parts[2], parts[1] - 1, parts[0])
         }
      </script>

   </body>
</html>