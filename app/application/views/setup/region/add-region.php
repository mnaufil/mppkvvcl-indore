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
                            <h1 class="page-title">Add Regions</h1>
                        </div>
                        <!-- Page-Header Ends -->

                        <!-- Row -->
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <form name="saveRegion" id="saveRegion" method="post" action="<?php echo base_url('save-region'); ?>">
                                	<div class="card">
	                                    <div class="card-body mt-3">
	                                       	<div class="form-row">
	                                       		<div class="col-xl-4 mb-3">
	                                       			<label class="form-label" for="regionName">Region Name<span class="text-red">*</span></label>
	                                       			<input type="text" class="form-control" id="regionName" name="regionName" value="">
	                                       		</div>
                                                <div class="col-xl-3 mt-5">
                                                    <!-- <input type="hidden" name="circle_arr[]" value=""> -->
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#circle-modal" data-bs-whatever="@mdo" id="add-circle-btn">Add Circle</button>
                                                </div>
	                                       	</div>
                                           <button class="btn btn-success mb-3" id="save-region-submit" type="button">Submit</button>
                                            <a class="btn btn-primary mb-3" href="<?php echo base_url('region'); ?>">Back</a>
	                                    </div>
                                	</div>
                                </form>
                            </div>                            
                        </div>
                        <!-- Row Ends -->

                    </div>
                    <!-- Container Ends -->
                </div>                
            </div>
            <!-- App-Content Ends -->

        </div>

        <!-- Add Circle Modal -->
        <div class="modal fade" id="circle-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Add Circle</h6>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <ul class="list-group" id="circle_row">
                                    <li class="column list-group-item justify-content-between" id="listitems-0">
                                        <input type="text" name="circle0" class="form-control-diff" value="">
                                        <span class="badgetext badge bg-primary rounded-pill">
                                            <span aria-hidden="true" id="close-0" onclick="closeli(0)">×</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="container">
                                <div class="row add_circle" id="addCircle" onclick="addCircle();">
                                    <span class="fe fe-plus-circle fa-lg"></span>
                                </div> 
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button class="btn ripple btn-success" type="button" data-bs-dismiss="modal" id="modal-submit">Submit</button> 
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Circle Modal Ends -->

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

    <!-- SWEET-ALERT JS -->
    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

    <script type="text/javascript">
        let circle_arr = [];

        function addCircle() {
            var list_items;
            var rows = document.querySelectorAll('#circle_row .column');

            if ($(rows).length == 0) {
                rows_length = 0;
            } else {
                let last_row = $(rows).last();
                let last_row_id = $(last_row).attr('id');
                let row_no_arr = last_row_id.split('-');
                let row_no = row_no_arr.pop();
                rows_length = parseInt(row_no) + 1;
            }
            
            var html = '';
            html += '<li class="column list-group-item" id="listitems-'+rows_length+'">';
            html += '<input type="text" name="circle'+ rows_length +'" class="form-control-diff" value="">';
            html += '<span class="badgetext badge bg-primary rounded-pill">';
            html += '<span aria-hidden="true" id="close-'+rows_length+'" onclick="closeli('+rows_length+')">×</span>';
            html += '</span>';
            html += '</li>';

            $('#circle_row').append(html);
        }

        function closeli(row_no) {
            delete circle_arr[row_no];

            $("#listitems-"+row_no).remove();
        }

        $('#modal-submit').click(function(event) {
            let circle_inputs = $('#circle_row').find('input[name^="circle"]');

            circle_arr = [];
            $(circle_inputs).each(function(index, value) {
                let circle = $(value).val();
                circle_arr.push(circle);
            });

            $('#add-circle-btn').html('Add/Edit Circle');
        });

        $('#save-region-submit').click(function(event) {
            let region_name = $('#saveRegion').find('input[name="regionName"]').val();

            if (region_name == '') {
                $('.toast-body').text('No changes occurred. Kindly add a region to submit the form.');
                $('.toast').toast('show');

                event.preventDefault();
                return false;
            } else {
                let form = $('#saveRegion')[0];
                let formData = new FormData(form);

                $.each(circle_arr, function(index, value) {
                    formData.append('circle[]', value);
                });

                let form_url = $('#saveRegion').attr('action');

                $.ajax({
                    type: 'POST',
                    url: form_url,
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);

                        window.location.replace('<?php echo base_url('region') ?>');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>

</body>
</html>