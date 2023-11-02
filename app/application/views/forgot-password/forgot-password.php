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
        <title>MPPKVVCL - Forgot Password</title>

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

    </head>

    <body class="app sidebar-mini ltr login-img">

        <!-- BACKGROUND-IMAGE -->
        <div class="">

            <!-- GLOABAL LOADER -->
            <div id="global-loader">
                <img src="<?php echo base_url('assets/images/loader.svg'); ?>" class="loader-img" alt="Loader">
            </div>
            <!-- End GLOABAL LOADER -->

            <!-- PAGE -->
            <div class="page">
                <div class="">
                    <!-- Theme-Layout -->

                    <!-- CONTAINER OPEN -->
                    <div class="col col-login mx-auto">
                      <!--  <div class="text-center">
                         <a href="index.php"><img src="assets/images/brand/newlogo.png" class="header-brand-img" alt=""></a> 
                        </div>-->
                    </div>

                    <!-- CONTAINER OPEN -->
                    <div class="container-login100">
                        <div class="wrap-login100 p-6">
                            <div class="text-center">
                                <a href="index.php">
                                    <img src="<?php echo base_url('assets/images/brand/newlogo.png'); ?>" class="header-brand-img" alt="">
                                </a> 
                            </div>

                            <form class="login100-form validate-form">
                                <br>
                                <span class="login100-form-title pb-5">Forgot Password</span>
                                <p class="text-muted">Enter the email address registered on your account</p>
                                
                                <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                        <i class="zmdi zmdi-email" aria-hidden="true"></i>
                                    </a>
                                    <input class="input100 border-start-0 ms-0 form-control" type="email" placeholder="Email">
                                </div>
                                <div class="submit">
                                    <a class="btn btn-primary d-grid" href="login.php">Submit</a>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="text-dark mb-0 d-inline-flex">Go to
                                        <!-- <a class="text-primary ms-1" href="login.php">Login</a> -->
                                        <a class="text-primary ms-1" href="<?php echo base_url('login') ?>">Login</a>
                                    </p>
                                </div>
                                <!--<label class="login-social-icon"><span>OR</span></label>
                                    <div class="d-flex justify-content-center">
                                        <a href="javascript:void(0)">
                                            <div class="social-login me-4 text-center">
                                                <i class="fa fa-google"></i>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="social-login me-4 text-center">
                                                <i class="fa fa-facebook"></i>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="social-login text-center">
                                                <i class="fa fa-twitter"></i>
                                            </div>
                                        </a>
                                    </div> -->
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!--END PAGE -->

        </div>
        <!-- BACKGROUND-IMAGE CLOSED -->

        <!-- JQUERY JS -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

        <!-- BOOTSTRAP JS -->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

        <!-- SHOW PASSWORD JS -->
        <script src="<?php echo base_url('assets/js/show-password.min.js'); ?>"></script>

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

    </body>

</html>