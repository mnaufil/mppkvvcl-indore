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
                                <h1 class="page-title">Regions</h1>
                                <div class="row">
                                    <div class="col-md-12 mt-2 mb-3">
                                        <a  href="<?php echo base_url('add-region'); ?>" class="btn btn-success btn-add">Add</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-body">
                                            <!-- Delete Alert -->
                                            <div class="row war-pop" id="region-delete-alert" hidden>
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
                                                            <p class="card-text notification-text">Are you sure you want to delete Region?</p>
                                                        </div>
                                                        <div class="card-footer text-center border-0 pt-0">
                                                            <div class="row">
                                                                <div class="text-center">
                                                                    <a href="javascript:void(0)" class="btn btn-danger notification-delete" data-region-id="" onclick="deleteRegion(this)">Delete</a>
                                                                    <a href="javascript:void(0)" class="btn btn-white me-2" onclick="closeNotificationAlert(this)">Cancel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>   
                                            </div>
                                            <!-- Delete Alert Ends -->

                                            <!-- Table -->
                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p border-bottom-0">Actions</th>
                                                            <th class="wd-15p border-bottom-0">Regions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($regions as $value) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="<?php echo base_url('edit-region/'.$value['region_id']); ?>" class="btn btn-sm">
                                                                        <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                    </a>&nbsp;&nbsp;
                                                                    <button type="button" class="btn btn-sm deleteRegion" data-region-id="<?php echo $value['region_id']; ?>">
                                                                        <span class="fe fe-trash-2 fa-lg action-btn-table"></span>
                                                                    </button>
                                                                </td>
                                                                <td class="region-name"><?php echo $value['region_name']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                               </table>
                                           </div>
                                           <!-- Table Ends -->
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
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

        <script type="text/javascript">
            $('.deleteRegion').click(function() {
                let region_id = $(this).data('region-id');
                let region_name = $(this).parent().next('.region-name').text();

                let alert_text = 'Are you sure you want to delete '+ region_name +' Region ?';
                
                $('#region-delete-alert').find('.notification-text').text(alert_text);
                $('#region-delete-alert').find('.notification-delete').attr('data-region-id', region_id);
                $('#region-delete-alert').removeAttr('hidden');
            });

            function deleteRegion(delete_btn) {
                let region_id = $(delete_btn).data('region-id');

                // Ajax call to delete the role
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('delete-region') ?>',
                    dataType: 'json',
                    data: {region_id:region_id},
                    success: function(response) {
                        console.log(response);

                        $('#region-delete-alert').find('.notification-text').text('');
                        $('#region-delete-alert').find('.notification-delete').attr('data-region-id', '');

                        $('#region-delete-alert').attr('hidden', true);

                        $('.toast-body').text('Region and its corresponding circles and divisions deleted successfully');
                        $('.toast').toast('show');

                        setTimeout(function() {
                            location.reload(true)
                        }, 5000);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }

            function closeNotificationAlert(close_btn) {
                $('#region-delete-alert').find('.notification-text').text('');
                $('#region-delete-alert').find('.notification-delete').attr('data-region-id', '');

                $('#region-delete-alert').attr('hidden', true);
            }
        </script>
    </body>  

</html>