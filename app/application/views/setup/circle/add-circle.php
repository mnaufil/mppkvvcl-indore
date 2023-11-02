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
                            <h1 class="page-title">Add Cirlces</h1>
                        </div>
                        <!-- Page-Header Ends -->

                        <!-- Row -->
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="card">

                                    <div class="card-body">
                                        <form name="saveCircle" id="saveCircle" method="post" action="<?php echo base_url('save-circle'); ?>">
                                            <div class="form-row">
                                                <div class="col-xl-4 mb-3">
                                                    <label class="form-label" for="region">Region Name<span class="text-red">*</span></label>
                                                    <select class="form-control select2 select-hidden-accessible" name="region" id="region">
                                                        <option value="select" selected disabled>Select Region</option>
                                                        <?php foreach ($regions as $key => $value) { ?>
                                                        <option value="<?php echo $value['region_id'] ?>"><?php echo $value['region_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <label class="form-label" for="circle">Circle Name<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="circle" id="circle">
                                                </div>
                                            </div>
                                            <button class="btn btn-success mb-3" type="button" id="save-circle-submit">Submit</button>
                                            <a class="btn btn-primary mb-3" href="<?php echo base_url('circle'); ?>">Back</a>
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
        $('#save-circle-submit').click(function(event) {
            let region_select = $('#saveCircle').find('select.form-control');
            let selected_region_data = $(region_select).select2('data');

            if (selected_region_data[0].text.includes('Select')) {
                $('.toast-body').text('Select region');
                $('.toast').toast('show');

                return false;
            }

            let circle_input = $('#saveCircle').find('input.form-control');
            if ($(circle_input).val() == '') {
                $('.toast-body').text('Enter Circle Name');
                $('.toast').toast('show');

                return false;
            }

            let form = $('#saveCircle')[0];
            let formData = new FormData(form);

            let form_url = $('#saveCircle').attr('action');

            // Ajax call to save Circle
            $.ajax({
                type: 'POST',
                url: form_url,
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);

                    window.location.replace('<?php echo base_url('circle') ?>');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

        });
    </script>

</body>
</html>