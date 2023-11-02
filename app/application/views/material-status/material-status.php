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
        
      <!-- DATERANGEPICKER CSS -->
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
            <!-- App-Sidebar Ends -->

            <!-- App-Content -->
            <div class="main-content app-content mt-0">
               <div class="side-app">
                     
                  <!-- Container -->
                  <div class="main-container container-fluid">
                        
                     <!-- Page-Header -->
                     <div class="page-header">
                        <h1 class="page-title"><?php echo $title; ?></h1>
                        <?php if (!empty($user_access) && isset($user_access['add'])) { ?>
                        <div class="row">
                           <div class="col-md-12 mt-2 mb-3">
                              <a href="<?php echo base_url('add-material-status'); ?>" class="btn btn-success btn-add">Add</a>
                           </div>
                        </div>   
                        <?php } ?>                        
                     </div>
                     <!-- Page-Header Ends -->

                     <!-- Row -->
                     <div class="row row-sm">
                        <div class="col-lg-12">
                           <div class="card">

                              <div class="card-body">
                                 <!-- SEARCH BLOCK -->
                                 <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                       <h2 class="accordion-header" id="headingOne">
                                          <?php    $accordion_btn_class = (isset($filter_data)) ? 'filters-on' : '';
                                                   $accordion_btn_style = (isset($filter_data)) ? 'style="height:57px;"' : '';
                                                   $clear_btn_visibility = (isset($filter_data)) ? '' : 'hidden';
                                          ?>
                                          <button class="accordion-button collapsed active prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>
                                          Search Material Status
                                          </button>
                                       </h2>
                                       <div class="clear-data" <?php echo $clear_btn_visibility; ?>>
                                          <a href="#" class="text-danger clear-search-filters" id="material-clear-btn" style="right: 60px !important;"> Clear</a>
                                       </div>
                                       <div class="lab-value">
                                          <ul>
                                             <?php if (isset($filter_data)) { 
                                                      foreach ($filter_data as $key => $value) { 
                                                         if (!empty($value['value'])) {
                                             ?>
                                             <li><?php echo $value['label'].' : '.$value['value']; ?></li>
                                             <?php       }
                                                      }
                                                   }
                                             ?>
                                          </ul>
                                       </div>
                                       <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                          <div class="accordion-body p-1">
                                             <form name="search_material_status" id="search_material_status" method="post" action="<?php echo base_url('search-material-status'); ?>">
                                                <!-- Row1 -->
                                                <div class="row">
                                                   <!-- Contractor (TKC) -->
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label class="form-label m-0" for="contractor">Contractor (TKC)</label>
                                                         <?php $contractor = (isset($filter_data)) ? $filter_data['contractor']['value'] : ''; ?>
                                                         <input class="form-control material-input" type="text" name="contractor" id="contractor" value="<?php echo $contractor; ?>" onkeyup="showtkclist(this.value)">
                                                         <div class="list-group list-view-contractor" id="list-view"></div>
                                                      </div>
                                                   </div>
                                                   <!-- Contract No -->
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label class="form-label m-0" for="tenderAwardNo">Contract No.</label>
                                                         <?php $tender_award_no = (isset($filter_data)) ? $filter_data['tender_award_no']['value'] : ''; ?>
                                                         <input class="form-control material-input" type="text" name="tenderAwardNo" id="tenderAwardNo" value="<?php echo $tender_award_no; ?>">
                                                      </div>
                                                   </div>                                                
                                                   <!-- TKC Offer Letter No -->
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label class="form-label m-0" for="tkcOfferLetterNo">TKC Offer Letter No.</label>
                                                         <?php $tkc_offer_letter_no = (isset($filter_data)) ? $filter_data['tkc_offer_letter_no']['value'] : ''; ?>
                                                         <input class="form-control material-input" type="text" name="tkcOfferLetterNo" id="tkcOfferLetterNo" value="<?php echo $tkc_offer_letter_no; ?>">
                                                      </div>
                                                   </div>
                                                   <!-- DI Letter No -->
                                                   <!-- <div class="col-md-2">
                                                      <div class="form-group">
                                                         <label class="form-label" for="diLetterNo">DI Letter No.</label>
                                                         <?php //$di_letter_no = (isset($filter_data)) ? $filter_data['di_letter_no'] : ''; ?>
                                                         <input class="form-control" type="text" name="diLetterNo" id="diLetterNo" value="<?php //echo $di_letter_no; ?>">
                                                      </div>
                                                   </div> -->
                                                   <!-- Status -->
                                                   <div class="col-md-2">
                                                      <div class="form-group">
                                                         <label class="form-label m-0" for="status">Status</label>
                                                         <select multiple="multiple" class="filter-multi" name="status[]" id="status">
                                                            <!-- <option value="All">All</option> -->
                                                            <?php $selected_status = (isset($filter_data)) ? $filter_data['status']['id'] : ''; ?>
                                                            <?php foreach ($status_data as $value) { ?>
                                                            <?php $selected = (is_array($selected_status) && in_array($value['status_id'], $selected_status)) ? 'selected' : ''; ?>
                                                            <option value="<?php echo $value['status_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                                                            <?php } ?>
                                                         </select>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Row2 -->
                                                <div class="row">
                                                   <!-- Search Button -->
                                                   <div class="col-md-3">
                                                      <button type="submit" class="btn btn-primary mt-2 mb-1 search-material-btn">Search</button>
                                                      <button type="button" class="btn default-clear clear-search-filters mt-2 mb-1">Clear</button>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- SEARCH BLOCK -->

                                 <!-- Alert -->
                                 <div class="row war-pop" id="material-notification-alert" hidden>
                                    <div class="col-xl-3 col-sm-6 war-pop-1">
                                       <div class="card border p-0 pb-3">
                                          <div class="card-header border-0 pt-3">
                                             <div class="card-options">
                                                <!-- <a href="javascript:void(0)" class="card-options-remove" data-bs-toggle="card-remove" onclick="closeNotificationAlert(this)">
                                                   <i class="fe fe-x"></i>
                                                </a> -->
                                             </div>
                                          </div>
                                          <div class="card-body text-center">
                                             <span class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="60" width="60" viewBox="0 0 24 24">
                                                   <path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"></path>
                                                   <circle cx="12" cy="17" r="1" fill="#e62a45"></circle>
                                                   <path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"></path>
                                                </svg>
                                             </span>
                                             <h4 class="h4 mb-0 mt-3">Warning</h4>
                                             <p class="card-text notification-text">Are you sure you want to delete 20 items</p>
                                          </div>
                                          <div class="card-footer text-center border-0 pt-0">
                                             <div class="row">
                                                <div class="text-center">
                                                   <a href="javascript:void(0)" class="btn btn-danger notification-delete" data-material-status-id="" onclick="deleteMaterialStatus(this)">Delete</a>
                                                   <a href="javascript:void(0)" class="btn btn-white me-2" onclick="closeNotificationAlert(this)">Cancel</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>   
                                 </div>

                                 <!-- Table -->
                                 <div class="table-responsive mt-3">
                                   <div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                       <div class="row">
                                          <div class="col-sm-12">
                                             <!-- Export Button -->
                                             <!-- <div class="col-sm-12 col-md-9s">
                                                <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                                   <button class="btn btn-primary" type="button"><span>Export</span></button>
                                                </div>
                                             </div> -->
                                             <!-- Table -->
                                             <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" id="basic-datatable" role="grid" aria-describedby="basic-datatable_info">
                                                <thead>
                                                   <tr role="row">
                                                      <th class="wd-10p border-bottom-0" tabindex="0" aria-controls="basic-datatable" rowspan="1" colspan="1"style="width: 95.5156px;">Actions</th>
                                                      <th class="wd-20p border-bottom-0 sorting" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contractor (TKC): activate to sort column descending" style="width: 67.7031px;">Contractor (TKC)</th>
                                                      <th class="wd-15p border-bottom-0 sorting" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Type Of Work: activate to sort column descending" style="width: 185.141px;">Type Of Work</th>
                                                      <th class="wd-25p border-bottom-0 sorting" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contract No: activate to sort column ascending" style="width: 178.531px;">Contract No</th>
                                                      <th class="wd-25p border-bottom-0 sorting" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Contract Date: activate to sort column ascending" style="width: 92.5312px;">Contract Date</th>
                                                      <!-- <th class="wd-20p border-bottom-0 sorting" tabindex="5" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Period: activate to sort column ascending" style="width: 185.141px;">Period</th> -->
                                                      <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="6" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="TKC Offer Letter No.: activate to sort column descending" style="width: 95.5156px;">TKC Offer Letter No.</th>
                                                      <th class="wd-15p border-bottom-0 sorting" tabindex="7" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="TKC Offer Letter Date: activate to sort column descending" style="width: 88.5469px;">TKC Offer Letter Date</th>
                                                      <th class="wd-20p border-bottom-0 sorting" tabindex="8" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 185.141px;">Status</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php foreach ($material_status_data as $key => $value) { ?>
                                                      <tr>
                                                         <td>
                                                            <!-- Complete Later -->
                                                            <?php if (!empty($user_access) && isset($user_access['view'])) { ?>
                                                            <!-- <a href="<?php echo base_url('view-material-status'); ?>" class="btn btn-sm">
                                                               <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                            </a>
                                                            &nbsp;&nbsp; -->   
                                                            <?php } ?>

                                                            <?php if (!empty($user_access) && isset($user_access['update'])) { ?>
                                                            <a href="<?php echo base_url('edit-material-status/'.$value['material_status_id']); ?>" class="btn btn-sm">
                                                               <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                            </a>
                                                            &nbsp;&nbsp;   
                                                            <?php } ?>
                                                            
                                                            <?php if (!empty($user_access) && isset($user_access['delete'])) { ?>
                                                            <button  type="button" class="btn  btn-sm deleteMaterialStatus" name="deleteMaterialStatus" data-material-status-id="<?php echo $value['material_status_id']; ?>">
                                                               <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                            </button>   
                                                            <?php } ?>                                                  
                                                         </td>
                                                         <td style="text-align: left;"><?php echo $value['contractor_name']; ?></td>
                                                         <td style="text-align: left;"><?php echo $value['typeofwork_name']; ?></td>
                                                         <td style="text-align: center;"><?php echo $value['tender_award_no']; ?></td>
                                                         <td style="text-align: center;"><?php echo $value['tender_award_date']; ?></td>
                                                         <td style="text-align: center;"><?php echo $value['offer_letter_no']; ?></td>
                                                         <td style="text-align: center;"><?php echo $value['offer_letter_date']; ?></td>
                                                         <td style="text-align: center;"><?php echo $value['status']; ?></td>
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
                        </div>
                     </div>
                     <!-- Row Ends -->

                  </div>
                  <!-- Container Ends -->
               </div>
            </div>
            <!-- App-Content Ends-->

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
      <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.html5.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

      <!-- SWEET-ALERT JS -->
      <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>
        
      <!-- DATERANGE PICKER JS -->
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

      <!-- MULTI JS -->
      <script src="<?php echo base_url('assets/plugins/multi/multi.min.js'); ?>"></script>

      <!-- MULTIPLE SELECT JS -->
      <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

      <script type="text/javascript">
         $('input[name="tenderAwardDate"]').daterangepicker({
            //autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
               format: 'DD-MM-YYYY'
            }
         });

         $('.deleteMaterialStatus').click(function() {
            let material_status_id = $(this).attr('data-material-status-id');
            console.log($('#material-notification-alert').attr('hidden'));
            $('#material-notification-alert').removeAttr('hidden');
            $('#material-notification-alert').find('.notification-delete').attr('data-material-status-id', material_status_id);

            $('.notification-text').text('Are you sure you want to delete the material status record?');
            console.log($('#material-notification-alert').attr('hidden'));
         });

         //Deleting Material Status Record
         function deleteMaterialStatus(btn) {
            let material_status_id = $(btn).attr('data-material-status-id');
            console.log('material_status_id:' + material_status_id);

            //Ajax Call to delete material status
            $.ajax({
               type: 'POST',
               url: '<?php echo base_url('delete-material-status') ?>',
               dataType: 'json',
               data: {material_status_id: material_status_id},
               success: function(response) {
                  console.log(response);
                  location.reload();

               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });
         }

         function closeNotificationAlert(anchor) {
            let notification_alert = $(anchor).closest('#material-notification-alert');
            console.log($(notification_alert).attr('hidden'));
            $(notification_alert).attr('hidden', true);
            console.log($(notification_alert).attr('hidden'));
         }

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

         $(document).click(function() {
            var list_view = $('#list-view');
            if (!list_view.is(event.target) && !list_view.has(event.target).length) {
               list_view.hide();
            }
         });

         //Applying selected contractor values
         function applyContractorDetails(anchor) {
            $('#list-view').hide();

            let contractor_name = $(anchor).find('.contractor-name').text();

            $('input[name="contractor"]').val(contractor_name);
         }

         $('#search_material_status').submit(function(event) {            
            let contractor = $('input[name="contractor"]').val();
            let contract_no = $('input[name="tenderAwardNo"]').val();
            let tkc_offer_letter_no = $('input[name="tkcOfferLetterNo"]').val();
            let di_letter_no = $('input[name="diLetterNo"]').val();
            let status = $('#status').val();

            // if (contractor == '' && contract_no == '' && tkc_offer_letter_no == '' && di_letter_no == '' && status == '') {
            if (contractor == '' && contract_no == '' && tkc_offer_letter_no == '' && status == '') {
               $('.toast-body').text('Enter value for atleast one filter');
               $('.toast').toast('show');

               event.preventDefault();
            }
         });

         $('.clear-search-filters').click(function(event) {
            event.preventDefault();
            $('.lab-value').find('ul').empty();
            $('#headingOne').find('button').removeClass('filters-on');
            $('#headingOne').find('button').removeAttr('style');

            let search_form = $('#search_material_status')[0];

            //Clearing all input[type=text] values
            $(search_form).find('input.form-control:text').each(function() {
              $(this).val('');
            });

            //Clearing Status filter values
            let status_select = $(search_form).find('.filter-multi:eq(1)');
            $(status_select).find('li.selected').each(function() {
              $(this).removeClass('selected');
              $(this).find('input:checkbox').prop('checked', false);
            });
            $(status_select).find('.ms-choice span').text('');

            $('#material-clear-btn').hide();

            window.location.replace('<?php echo base_url("material-status") ?>');
         });
      </script>
   </body>
</html>