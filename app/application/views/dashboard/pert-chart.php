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
        <title>MPPKVVCL - Pert Chart</title>

        <!-- BOOTSTRAP CSS -->
        <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">

        <!-- STYLE CSS -->
         <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/css/plugins.css'); ?>" rel="stylesheet">

        <!--- FONT-ICONS CSS -->
        <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet">

        <!-- INTERNAL Switcher css -->
        <link href="<?php echo base_url('assets/switcher/css/switcher.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/switcher/demo.css'); ?>" rel="stylesheet">

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
                                <h1 class="page-title">Pert Chart</h1>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW-1 -->
                            <div class="row">                            
                                <div class="col-xl-12">
                                    <div class="card"> 
                                        <div class="card-header"> 
                                            <h3 class="card-title">Physical and Financial Progress of Capacitor Bank Works under RDSS As on 28.02.2023</h3> 
                                        </div> 
                                        <div class="card-body">
                                            <form name="search_material_status" class="needs-validation">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Contractor(TKC)</label>
                                                            <input class="form-control" type="text" placeholder="Enter TKC name" onkeyup="showtkc(this.value);">
                                                            <div class="list-group list-view-contractor" id="list-view"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">MileStone</label>
                                                            <select class="form-control form-select select2 select2-hidden-accessible" name="status" data-bs-placeholder="Select Status" tabindex="-1" aria-hidden="true">
                                                                <option value="Milestone 1">Milestone 1</option>
                                                                <option value="Milestone 2">Milestone 2</option>
                                                                <option value="Milestone 3">Milestone 3</option>             <option value="Milestone 4">Milestone 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary mt-6 mb-0">Search</button>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <div class="header-dropdown-list message-menu" id="tkclist" style="position: absolute; background: #fff; border: 1px solid #e9edf4; margin-top: -14px; border-radius: 1px; border-top: 0px; display:none;">
                                                <div class="dropdown-item d-flex p-4">
                                                    <a href="#" class="open-file"></a>
                                                    <div class="wd-50p">
                                                        <h5 class="mb-1">M/s Shreem Capcitor</h5>
                                                        <span>Type Of Work: <span class="text-success">Capacitor Bank</span></span>
                                                        <p class="fs-13 text-muted mb-0">Award No: 481</p>
                                                    </div>
                                                    <div class="ms-auto text-end d-flex fs-16">
                                                        <span class="fs-13 text-muted mb-0 d-sm-block px-4">
                                                            Award Date : 25-09-2023
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <div class="dropdown-item d-flex p-4">
                                                    <a href="#" class="open-file"></a>
                                                    <div class="wd-50p">
                                                        <h5 class="mb-1">M/s Universal MEP</h5>
                                                        <span>Type Of Work: <span class="text-success">Substation</span></span>
                                                        <p class="fs-13 text-muted mb-0">Award No: 483</p>
                                                    </div>
                                                    <div class="ms-auto text-end d-flex fs-16">
                                                        <span class="fs-13 text-muted mb-0 d-sm-block px-4">
                                                            Award Date : 25-09-2023
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <div class="dropdown-divider m-0"></div>
                                                <div class="dropdown-item d-flex p-4">
                                                    <a href="#" class="open-file"></a>
                                                    <div class="wd-50p">
                                                        <h5 class="mb-1">M/s A.K. Infra</h5>
                                                        <span>Type Of Work: <span class="text-success">Substation</span></span>
                                                        <p class="fs-13 text-muted mb-0">Award No: 484</p>
                                                    </div>
                                                    <div class="ms-auto text-end d-flex fs-16">
                                                        <span class="fs-13 text-muted mb-0 d-sm-block px-4">
                                                            Award Date : 25-09-2023
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="media-body pt-0">
                                                <div class="float-md-end d-flex fs-15">
                                                    <small class="me-3 mt-3 text-muted">Award Date : 25-09-2023</small> 
                                                </div> 
                                                <div class="media-title text-dark font-weight-semibold mt-1">DISCOMM - MPPKVVCL
                                                    <span class="text-muted font-weight-semibold">( TKC Name - M/s Shreem Capcitor)</span>
                                                </div>
                                                <small class="mb-0">Project Award NO - 480 </small> 
                                            </div>

                                            <div class="table-responsive"> 
                                                <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr No.</th>  
                                                            <th>Month</th> 
                                                            <th>Particular<br> of work</th> 
                                                            <th>Unit</th> 
                                                            <th>BoQ</th> 
                                                            <th>Work Plan As Per Pert Chart</th>
                                                            <th>Achievement During the<br> Month</th> 
                                                            <th>Progressive <br>Achievement since<br> begining</th> 
                                                            <th>Physical<br> Progress in %<br> (Col I/ Col J)</th> 
                                                            <th>Slippage in % 100 <br>- (Col-J)</th>
                                                            <th>Upload <br>Photo</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>
                                                                <table>
                                                                    <tr>
                                                                        <td>Sep'22 to <br>May'23</td>
                                                                        <td>Upto <br>Feb23</td>
                                                                        <td>Upto <br>March'23</td>
                                                                        <td>Upto <br>Apr'23</td>
                                                                        <td>Upto <br>May'23</td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th>
                                                                <table>
                                                                    <tr>
                                                                        <td>Physical <br>(In No)</td>
                                                                        <td>Financial <br>(In Cr.)</td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th>
                                                                <table>
                                                                    <tr>
                                                                        <td>Physical <br>(In No)</td>
                                                                        <td>Financial <br>(In Cr.)</td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <tr>
                                                            <td>Feb-23</td>   
                                                            <td>Installation <br>and Commissioning <br>of 1500<br> KVAR 11kv <br>auto Switch <br>Capacitor Bank</td>
                                                            <td>Nos.</td>
                                                            <td>589</td>
                                                            <td>148</td>
                                                            <td>30</td>
                                                            <td>60</td>
                                                            <td>104</td>
                                                            <td>148</td>
                                                            <td>Nil</td>
                                                            <td>1.29 Cr<br> (Against 179 No<br> Foundations For<br> Capacitor bank)</td>
                                                            <td>Nil</td>
                                                            <td>1.29 Cr<br> (Against 179 No<br> Foundations For<br> Capacitor bank)</td>
                                                            <td>Nil</td>
                                                            <td>Nil</td>
                                                            <td>Nil</td>
                                                        </tr>
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
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
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
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
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
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW-1 END -->

                            <!-- ROW-2 -->
                           
                            <!-- ROW-2 END -->

                            <!-- ROW-3 -->
                           
                            <!-- ROW-3 END -->

                            <!-- ROW-4 -->
                           
                            <!-- ROW-4 END -->
                        </div>
                        <!-- CONTAINER END -->
                    </div>
                </div>
                <!--app-content close-->

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
        <script src="<?php echo base_url('assets/switcher/js/switcher.js') ?>"></script>

         <!-- DATA TABLE JS-->
        <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php  echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js'); ?>"></script>
        <script src="<?php  echo base_url('assets/plugins/datatable/js/buttons.html5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>
        
        <script>
            //Displays contractor search list view
            function showtkc(tkcValue) {
                $('#list-view').show();
                if (tkcValue !== '') {
                    var html = '';
                    $('#list-view').empty();

                    for (var i = 0; i < 3; i++) {
                        html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start ">';
                        html += '<div class="d-flex w-100 justify-content-between">';
                        html += '<h4 class="mb-1"><strong>M/s Shreem Capcitor</strong></h4>';
                        html += '<small class="text-muted">Award Date : <span class="text-primary"> 25-09-2023</span></small>';
                        html += '</div>';
                        html += '<p class="mb-1">Type Of Work: <span class="text-primary"> Capacitor Bank</span></p>';
                        html += '<small class="text-muted">Award No: <span class="text-primary">483</span></small>';
                        html += '</a>';
                    }

                    $('#list-view').append(html);
                } else {
                    $('#list-view').empty();
                }
            }

            $(document).click(function() {
                var list_view = $('#list-view');
                if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                    list_view.hide();
                }
            });
        </script>
    </body>

</html>