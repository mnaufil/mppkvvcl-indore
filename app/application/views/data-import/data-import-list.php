<!DOCTYPE html>
<html>
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

	   <!-- TABLER ICONS CSS -->
	   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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

            <!-- App Content -->
            <div class="main-content app-content mt-0">
               <div class="side-app">
                		
                  <!-- Container -->
                	<div class="main-container container-fluid">
                			
                	   <!-- Page Header -->
                		<div class="page-header">
                		   <h1 class="page-title">Data Import</h1>
                			<div class="row">
                			   <div class="col-md-12 mt-2 mb-3">
                              <a  href="<?php echo base_url('add-data-import'); ?>" class="btn btn-success btn-add">Add </a>
                           </div>
             				</div>
             			</div>
                		<!-- Page Header Ends -->

                		<!-- Row -->
                		<div class="row row-sm">
                		   <div class="col-lg-12">
                			   <div class="card">
                				   <div class="card-body mt-3">
                					   <div class="table-responsive">
                						   <div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                       <div class="row">
                                          <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" id="basic-datatable" role="grid" aria-describedby="basic-datatable_info">
                                             <thead>
                                                <tr role="row">
                                                   <th class="wd-10p border-bottom-0" tabindex="0" aria-controls="basic-datatable" rowspan="1" colspan="1">Actions</th>
                                                   <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Import Date: activate to sort column descending">Import Date</th>
                                                   <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Import Type: activate to sort column descending">Import Type</th>
                                                   <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Import Sub Type: activate to sort column descending">Import Sub Type</th>
                                                   <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#Records: activate to sort column descending">#Records</th>
                                                   <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="5" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Imported By: activate to sort column descending">Imported By</th>
                                                   <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="6" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status: activate to sort column descending">Status</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php foreach ($import_details as $key => $value) { ?>
                                                <tr>
                                                   <!-- Action Buttons -->
                                                   <td class="d-flex">
                                                      <?php $status = $value['status'];
                                                            if ($status == 1) {
                                                      ?>
                                                      <a href="<?php echo base_url('edit-data-import/'.$value['import_hdr_id']); ?>" class="btn btn-sm">
                                                         <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                      </a>   
                                                      <?php }
                                                      ?>
                                                   </td>
                                                   <!-- Import Date -->
                                                   <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($value['createddate'])); ?></td>
                                                   <!-- Import Type -->
                                                   <td style="text-align: center;"><?php echo $value['import_type']; ?></td>
                                                   <!-- Import Sub Type -->
                                                   <td style="text-align: center;"><?php echo $value['sub_type']; ?></td>
                                                   <!-- Records -->
                                                   <td style="text-align: center;"><?php echo $value['import_records']; ?></td>
                                                   <!-- Imported By -->
                                                   <td style="text-align: center;"><?php echo $value['imported_by']; ?></td>
                                                   <!-- Status -->
                                                   <?php $status_text = ($status == 1) ? 'Open' : (($status == 2) ? 'Completed' : 'Cancelled');
                                                         $status_text_color = ($status == 1) ? 'text-muted' : (($status == 2) ? 'text-success' : 'text-danger');
                                                   ?>
                                                   <td style="text-align: center;">
                                                      <h6 class="<?php echo $status_text_color; ?>">
                                                         <?php echo $status_text; ?>   
                                                      </h6>
                                                   </td>
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
                		<!-- Row Ends -->
                			
             		</div>
                	<!-- Container Ends -->

             	</div>
            </div>
            <!-- App Content Ends -->

        	</div>

        	<!-- Footer -->
         <?php $this->load->view('include/footer');?>
         <!-- Footer Ends -->
      </div>
      <!-- PAGE ENDS -->

      <!-- BACK-TO-TOP -->
      <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

      <!-- JQUERY JS -->
      <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

      <!-- BOOTSTRAP JS -->
      <script src="<?php  echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

      <!-- TypeHead js -->
      <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

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