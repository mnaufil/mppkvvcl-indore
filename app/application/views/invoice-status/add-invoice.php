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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">

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
                <!-- App-Sidebar Ends-->

                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                    <div class="side-app">
                        
                        <!-- Container -->
                        <div class="main-container container-fluid">
                            
                            <!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title">Add Invoice Status</h1>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        
                                        <form id="addSupplyInvoiceStatus" name="addSupplyInvoiceStatus" method="post" action="<?php echo base_url('add-invoice-status'); ?>">
                                            <div class="card-body mt-3">
                                                <!-- Row1 -->
                                                <div class="form-row">
                                                    <!-- Contractor (TKC) -->
                                                    <div class="col-xl-6 mb-3">
                                                        <label class="form-label" for="contractorTKC">Contractor (TKC)
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="contractorTKC" id="contractorTKC" onkeyup="showtkc(this.value)">
                                                        <div class="list-group list-view-contractor" id="list-view"></div>
                                                    </div>
                                                    <!-- Package No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="packageNo">Package No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="packageNo" id="packageNo">
                                                    </div>
                                                    <!-- Type of Work -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="typeOfWork">Type of Work
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <select class="form-control select2" id="typeOfWork">
                                                            <option value="select" selected disabled>Select Type Of Work</option>
                                                            <option value="capacitorBank">Capacitor Bank</option>
                                                            <option value="33KV/11KVNewSubstation">33 KV / 11 KV New Substation</option>
                                                            <option value="11KVFeederSeparation">11 KV Feeder Separation</option>
                                                            <option value="33KVInterconnectionLine">33 KV Interconnection Line</option>
                                                            <option value="11KVInterconnectionLine">11 KV Interconnection Line</option>
                                                            <option value="LTLine/LTCabling">LT Line / LT Cabling</option>
                                                        </select>
                                                    </div>                                                    
                                                </div>
                                                <!-- Row2 -->
                                                <div class="form-row">
                                                    <!-- Contract No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="tenderAwardNo">Contract No.
                                                            <span class="text-red">*</span>
                                                            <span class="invoice-file"><a href="<?php echo base_url('get-invoice'); ?>"><i class="fa fa-file-text-o fa-lg" aria-hidden="true"></i></a></span>
                                                        </label>
                                                        <input class="form-control" type="text" name="tenderAwardNo" id="tenderAwardNo">
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
                                                            <input class="form-control" type="text" name="tenderAwardDate" id="tenderAwardDate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row3 -->
                                                <div class="form-row">
                                                    <!-- Type of Invoice -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="typeOfInvoice">Type of Invoice
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <select class="form-control select2" id="typeOfInvoice" name="typeOfInvoice">
                                                            <!-- <option value="select" selected disabled>Select Type Of Invoice</option>
                                                            <option value="60%_supply">60% Supply</option>
                                                            <option value="30%_supply">30% Supply</option>
                                                            <option value="90%_installation">90% Installation</option>
                                                            <option value="RA_Bills">RA Bills</option>
                                                            <option value="Final_Bill/OA">Final Bill/OA</option> -->
                                                            <option value="select" selected disabled>Select Type Of Invoice</option>
                                                            <option value="supply">Supply</option>
                                                            <option value="erection">Erection</option>
                                                        </select>
                                                    </div>
                                                    <!-- Invoice No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceNo">Invoice No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="invoiceNo" id="invoiceNo">
                                                    </div>
                                                    <!-- Invoice Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceDate">
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input class="form-control" type="text" name="invoiceDate" id="invoiceDate">
                                                        </div>
                                                    </div>
                                                    <!-- CIS Portal Booking Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="cisPortalBookingDate">CIS Portal Booking Date
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input class="form-control" type="text" name="cisPortalBookingDate" id="cisPortalBookingDate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row4 -->
                                                <div class="form-row">
                                                    <!-- Invoice Amount without GST -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceAmtwithoutGST">Invoice Amount
                                                            <span class="mb-0 text-muted fs-11">(Without GST)</span>
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="invoiceAmtwithoutGST" id="invoiceAmtwithoutGST">
                                                    </div>
                                                    <!-- GST -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="gst">GST
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="gst" id="gst">
                                                    </div>
                                                    <!-- Invoice Amount with GST -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceAmtwithGST">Invoice Amount
                                                            <span class="mb-0 text-muted fs-11">(With GST)</span>
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="invoiceAmtwithGST" id="invoiceAmtwithGST">
                                                    </div>
                                                    <!-- DI No. / EMB No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="e-No">DI No. / EMB No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="e-No" id="e-No">
                                                    </div>
                                                </div>
                                                <!-- Row5 -->
                                                <div class="form-row">
                                                    <!-- Balance to Claim -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="balanceToClaim">Balance to Claim
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="balanceToClaim" id="balanceToClaim" readonly>
                                                    </div>
                                                    <!-- Balance to Pay -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="balanceToPay">Balance to Pay
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="balanceToPay" id="balanceToPay" readonly>
                                                    </div>
                                                </div>
                                                <!-- Row6 -->
                                                <div class="form-row mt-3">
                                                    <!-- Claim For Payment -->
                                                    <div class="col-xl-6">
                                                        <label class="form-label">Claim For Payment</label>
                                                    </div>  
                                                </div>
                                                <!-- Row7 -->
                                                <div class="form-row mt-2">
                                                    <!-- Claim For Payment Table -->
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered border text-nowrap mb-0" id="new-edit-claim-details">
                                                            <thead>
                                                                <tr>
                                                                    <!-- <th>Claim Date</th> -->
                                                                    <th>Claim Type</th>
                                                                    <th>Claim Amount (With GST)</th>
                                                                    <th>Mobilisation Advance Adjusted</th>
                                                                    <th>LD</th>
                                                                    <th>Interest on Mobilisation Advance</th>
                                                                    <th>Other Deductions</th>
                                                                    <th>TDS/GST-TDS</th>
                                                                    <th>Payable Amount</th>
                                                                    <th>Balance To Pay</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <!-- <td></td> -->
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
                                                    <button id="table2-new-row-button-claim-details" class="btn btn-primary mb-4 mt-4"> Add New Row</button>
                                                </div>
                                                <!-- Row8 -->
                                                <div class="form-row">
                                                    <!-- Submit -->
                                                    <div class="col-xl-6 mb-3 mt-4">
                                                        <button type="button" class="btn btn-success">Submit</button>
                                                        <a href="<?php echo base_url('invoice-status'); ?>" type="button" class="btn btn-primary">Back</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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

            <!-- Payment Details Modal -->
            <div class="modal fade" id="paymentDetails" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Payment Details</h5>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- <p>Modal body text goes here.</p> -->
                            <div class="table-responsive">
                                <table class="table border table-bordered text-nowrap text-md-nowrap table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Payment Amount</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>50</td>
                                            <td>01-08-2023</td>
                                        </tr>
                                        <tr>
                                            <td>30</td>
                                            <td>31-12-2023</td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>31-01-2024</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button class="btn ripple btn-success" type="button">Save changes</button> -->
                            <button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Payment Details Modal Ends -->
        </div>

        <!-- BACK-TO-TOP -->
        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

        <!-- JQUERY JS -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

        <!-- BOOTSTRAP JS -->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>

        <!-- INPUT MASK JS-->
        <script src="<?php //echo base_url('assets/plugins/input-mask/jquery.mask.min.js'); ?>"></script>

        <!-- TypeHead js -->
        <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/typehead.js'); ?>"></script>

        <!-- SELECT2 JS -->
        <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>

        <!-- FORMVALIDATION JS -->
        <script src="<?php //echo base_url('assets/js/form-validation.js'); ?>"></script>

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

        <!-- EDIT-TABLE JS -->
        <script src="<?php echo base_url('assets/plugins/edit-table/invoice-status/claim.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/invoice-status/claim-edit-table.js'); ?>"></script>

        <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">
            /*$('input[name="tenderAwardDate"]').daterangepicker({
                //autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });*/

            $('input[name="invoiceDate"], input[name="paymentDate"], input[name="contractDate"], input[name="cisPortalBookingDate"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            //Displays contractor search list view
            function showtkc(tkcValue) {
                // alert(tkcValue);
                $('#list-view').show();
                if (tkcValue !== '') {
                    var html = '';
                    $('#list-view').empty();

                    for (var i = 0; i < 3; i++) {
                        html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start ">';
                        html += '<div class="d-flex w-100 justify-content-between">';
                        html += '<h4 class="mb-1"><strong>M/s Shreem Capcitor</strong></h4>';
                        html += '<p>Package - 1 </p>';
                        html += '</div>';
                        html += '<p class="mb-1">Type Of Work: <span class="text-primary"> Capacitor Bank</span></p>';
                        html += '<small class="text-muted">Award No: <span class="text-primary">483</span></small><br>';
                        html += '<small class="text-muted">Award Date : <span class="text-primary"> 25-09-2023</span></small>';
                        html += '</a>';
                    }

                    $('#list-view').append(html);
                } else {
                    $('#list-view').empty();
                }

                /*if(tkcValue!=='')
                {
                    $("#tkclist").show();
                }
                else
                {
                    $("#tkclist").hide();
                }*/
            }

            $(document).click(function() {
                // alert('click');
                var list_view = $('#list-view');
                if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                    list_view.hide();
                }
            });
        </script>

    </body>
</html>