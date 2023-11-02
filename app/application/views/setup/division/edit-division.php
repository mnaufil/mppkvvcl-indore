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
                                <h1 class="page-title">Division</h1>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-body">
                                            <form id="updateDivision" name="updateDivision" method="post" action="<?php echo base_url('update-division'); ?>">
                                                <div class="row">
                                                    <input type="hidden" name="division_id" value="<?php echo $division_data['division_id']; ?>">
                                                    <!-- Region -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label class="form-label" for="region">Region <span class="text-red">*</span></label>
                                                        <select class="form-control select2 select-hidden-accessible" id="region" name="region" onchange="changeFormStatus()">
                                                            <option value="select" disabled>Select Region</option>
                                                            <?php foreach ($regions as $key => $value) { ?>
                                                            <?php $selected = ($value['region_name'] == $division_data['region_name']) ? 'selected' : ''; ?>
                                                            <option value="<?php echo $value['region_id']; ?>" <?php echo $selected; ?>><?php echo $value['region_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- Circle -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label class="form-label" for="circle">Circle <span class="text-red">*</span></label>
                                                        <select class="form-control select2 select-hidden-accessible" id="circle" name="circle" onchange="changeFormStatus()">
                                                            <option value="select" disabled>Select Circle</option>
                                                        </select>
                                                    </div>
                                                    <!-- Division -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label class="form-label" for="division">Division Name <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="division" name="division" value="<?php echo $division_data['division_name']; ?>" onpaste="changeFormStatus()" onkeyup="changeFormStatus()">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Submit -->
                                                    <div class="col-xl-6">
                                                        <button class="btn btn-success mb-3" type="submit">Submit</button>
                                                        <a class="btn btn-primary mb-3" href="<?php echo base_url('division'); ?>">Back</a>
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
            let form_change = false;
            let circles = <?php echo json_encode($circles) ?>;

            $(document).ready(function() {
                let selected_region = '<?php echo $division_data['region_name'] ?>';
                let selected_region_circle = circles[selected_region];

                let selected_circle = '<?php echo $division_data['circle_name'] ?>';

                let circle_html = '';

                circle_html += '<option value="select" disabled>Select Circle</option>';
                $.each(selected_region_circle, function(index, value) {
                    let selected = (selected_circle == value) ? 'selected' : '';
                    circle_html += '<option value="'+ index +'" '+ selected +'>'+ value +'</option>';
                });

                $('#circle').empty();
                $('#circle').append(circle_html);
            });

            function changeFormStatus() {
                form_change = true;
            }

            $('#region').on('change', function() {
                let selected_data = $('#region').select2('data');
                let selected_region = selected_data[0].text;

                let selected_region_circles = circles[selected_region];

                let circle_html = '';

                circle_html += '<option value="select" selected disabled>Select Circle</option>';
                $.each(selected_region_circles, function(index, value) {
                    circle_html += '<option value="'+ index +'">'+ value +'</option>';
                });

                $('#circle').empty();
                $('#circle').append(circle_html);
            });

            $('#updateDivision').submit(function(event) {
                let selected_region_data = $('#region').select2('data');
                let selected_region = selected_region_data[0].text;

                let selected_circle_data = $('#circle').select2('data');
                let selected_circle = selected_circle_data[0].text;

                let division = $('#division').val();

                if (selected_region.includes('Select Region')) {
                    $('.toast-body').text('Select Region');
                    $('.toast').toast('show');

                    event.preventDefault();
                    return false;
                } else if (selected_circle.includes('Select Circle')) {
                    $('.toast-body').text('Select Circle');
                    $('.toast').toast('show');

                    event.preventDefault();
                    return false;
                } else if (division == '') {
                    $('.toast-body').text('Enter Division');
                    $('.toast').toast('show');

                    event.preventDefault();
                    return false;
                } else if (form_change == false) {
                    $('.toast-body').text('No changes occurred. Kindly update division to submit the form.');
                    $('.toast').toast('show');

                    event.preventDefault();
                    return false;
                }
            });
        </script>
    </body>
</html>