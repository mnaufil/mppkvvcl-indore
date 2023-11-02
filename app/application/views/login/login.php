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
        <title>MPPKVVCL - Login</title>

        <!-- BOOTSTRAP CSS -->
        <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/temp.css'); ?>" rel="stylesheet">

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

    <body class="app sidebar-mini ltr login-img">

        <!-- BACKGROUND-IMAGE -->
        <div class="">

            <!-- GLOABAL LOADER -->
            <div id="global-loader">
                <img src="<?php echo base_url('assets/images/loader.svg'); ?>" class="loader-img" alt="Loader">
            </div>
            <!-- /GLOABAL LOADER -->

            <!-- PAGE -->
            <div class="page">
                <div class="">
                    <!-- Theme-Layout -->

                    <!-- CONTAINER OPEN -->
                    <div class="col col-login mx-auto mt-7">
                       <!-- <div class="text-center">
                          <a href="index.php"><img src="assets/images/brand/newlogo.png" class="header-brand-img" alt="" ></a> 
                        </div>-->
                    </div>

                    <div class="container-login100">
                        
                        <div class="wrap-login100 p-6" style="position: relative;">
                            <div class="sgs-logo1 mb-4 text-center">
                                <img src="<?php echo base_url('assets/images/brand/sgs_logo.png'); ?>" class="header-brand-img" alt="" style="width: 130px !important;">
                            </div>
                            <hr>
                            <div class="text-center" style="margin-top: 40px;">
                                <a href="index.php">
                                    <img src="<?php echo base_url('assets/images/brand/newlogo.png'); ?>" class="header-brand-img" alt="" >
                                </a> 
                            </div>

                            <form class="needs-validation" method="post" novalidate action="<?php echo base_url('check-login')?>">
                                <br>

                                <span class="login100-form-title pb-5">Login</span>

                                <div class="panel panel-primary">
                                    <div class="tab-menu-heading" style="border: none !important;">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                           <!--  <ul class="nav panel-tabs">
                                                <li class="mx-0"><a href="#tab5" class="active" data-bs-toggle="tab">Email</a></li>
                                                <li class="mx-0"><a href="#tab6" data-bs-toggle="tab">Mobile</a></li>
                                            </ul> -->
                                        </div>
                                    </div>
                                    
                                    <div class="panel-body tabs-menu-body p-0">
                                        <div class="tab-content">
                                        <?php   if($this->session->flashdata('error')) {   ?>
                                        <p style="color:red"><?php  echo $this->session->flashdata('error');?></p>  
                                        <?php } ?>
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-email text-muted p-2" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 form-control ms-0" type="text" placeholder="Email/UserId" value="" required id="validationCustom01" name="email" tabindex="1">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted p-2" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 form-control ms-0" type="password" placeholder="Password" value="" required name="password" tabindex="2">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                            <div class="text-end pt-4">
                                                <p class="mb-0">
                                                    <a href="<?php echo base_url('forgot-password');?>" class="text-primary ms-1">Forgot Password?</a>
                                                </p>
                                            </div>
                                            <div class="container-login100-form-btn">
                                                <button type="submit" class="login100-form-btn btn-primary">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!-- End PAGE -->

        </div>
        <!-- BACKGROUND-IMAGE CLOSED -->

        <!-- JQUERY JS -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

        <!-- BOOTSTRAP JS -->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

        <!-- SHOW PASSWORD JS -->
        <script src="<?php echo base_url('assets/js/show-password.min.js'); ?>"></script>

        <!-- GENERATE OTP JS -->
        <script src="<?php echo base_url('assets/js/generate-otp.js'); ?>"></script>

        <!-- Perfect SCROLLBAR JS-->
        <script src="<?php echo base_url('assets/plugins/p-scroll/perfect-scrollbar.js'); ?>"></script>

        <!-- Color Theme js -->
        <script src="<?php echo base_url('assets/js/themeColors.js'); ?>"></script>

        <!-- CUSTOM JS -->
        <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>

        <!-- Custom-switcher -->
        <script src="<?php echo base_url('assets/js/custom-swicher.js'); ?>"></script>

        <!-- Switcher js -->
        <script src="<?php echo base_url('assets/switcher/js/switcher.js'); ?>"></script>


        <!-- FORMVALIDATION JS -->
        <script>
            (function() {
                'use strict';
                
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');

                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                       // form.classList.add('was-validated');
						
                    }, false);
                });
                }, false);
    
            })();
        </script>

    </body>
</html>