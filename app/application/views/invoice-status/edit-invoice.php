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
        
        <!-- DATERANGE PICKER CSS -->
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
                <!-- App-Sidebar Ends-->

                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                    <div class="side-app">
                        
                        <!-- Container -->
                        <div class="main-container container-fluid">
                            
                            <!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title"><?php echo ($mode == 'edit') ? 'Edit' : 'View'; ?> <?php echo $title; ?></h1>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row">
                                            <!-- Invoice Status -->
                                            <div class="col-md-12 mt-2">
                                                <!-- <h3><span class="badge bg-primary badge-xl btn-add me-3 mb-2 mt-2">PENDING</span></h3> -->
                                                <a href="javascript:void(0)" class="btn btn-primary btn-add me-3">Pending</a>
                                            </div>
                                        </div>
                                        <!-- <form class="needs-validation" novalidate> -->
                                        <form id="editSupplyInvoiceStatus" name="editSupplyInvoiceStatus" method="post" action="<?php echo base_url('edit-invoice-status'); ?>">
                                            <div class="card-body">
                                                <!-- Row1 -->
                                                <div class="form-row">
                                                    <!-- Contractor (TKC) -->
                                                    <div class="col-xl-6 mb-3">
                                                        <label class="form-label" for="contractorTKC">Contractor (TKC)
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="contractorTKC" id="contractorTKC" value="<?php echo $invoice_details['contractor_name']; ?>" readonly>
                                                    </div>
                                                    <!-- Package No -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="packageNo">Package No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="packageNo" id="packageNo" value="<?php echo $invoice_details['package_no']; ?>" readonly>
                                                    </div>
                                                    <!-- Type of Work -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="typeOfWork">Type of Work
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <select class="form-control select2" id="typeOfWork" disabled>
                                                            <option><?php echo $invoice_details['typeofwork_name']; ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Row2 -->
                                                <div class="form-row">
                                                    <!-- Contract No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="contractNo">Contract No.
                                                            <span class="text-red">*</span>
                                                            <span class="invoice-file"><a href="<?php echo base_url('get-invoice/'.$invoice_details['contract_id'].'/'.$invoice_details['invoice_id']); ?>"><i class="fa fa-file-text-o fa-lg" aria-hidden="true"></i></a></span>
                                                        </label>
                                                        <input class="form-control" type="text" name="tenderAwardNo" id="tenderAwardNo" value="<?php echo $invoice_details['tender_award_no']; ?>" readonly>
                                                    </div>
                                                    <!-- Contract Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="contractDate">Contract Date
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input class="form-control" type="text" name="tenderAwardDate" id="tenderAwardDate" value="<?php echo $invoice_details['tender_award_date']; ?>" readonly>
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
                                                        <?php if ($mode == 'edit') { ?>
                                                        <select class="form-control select2" id="typeOfInvoice" required>
                                                            <option value="select" disabled>Select Type Of Invoice</option>
                                                            <?php foreach ($type_of_invoices as $key => $value) { ?>
                                                                <?php $selected = ($value['name'] == $invoice_details['invoice_type']) ? 'selected' : ''; ?>
                                                                <option value="<?php echo $value['type_of_invoice_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                                                            <?php } ?>
                                                        </select>    
                                                        <?php } elseif ($mode == 'view') { ?>
                                                            <input class="form-control" type="text" name="typeOfInvoice" id="typeOfInvoice" value="<?php echo $invoice_details['invoice_type']; ?>" readonly>
                                                        <?php } ?>
                                                    </div>
                                                    <!-- Invoice No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceNo">Invoice No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <input class="form-control" type="text" name="invoiceNo" id="invoiceNo" value="<?php echo $invoice_details['invoice_no']; ?>" <?php echo $readonly; ?>>
                                                    </div>
                                                    <!-- Invoice Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceDate">Invoice Date
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <?php $disabled = ($mode == 'view') ? 'disabled' : ''; ?>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input class="form-control" type="text" name="invoiceDate" id="invoiceDate" value="<?php echo $invoice_details['invoice_date']; ?>" <?php echo $readonly; ?> <?php echo $disabled; ?>>
                                                        </div>
                                                    </div>
                                                    <!-- CIS Portal Booking Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="cisPortalBookingDate">CIS Portal Booking Date
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <?php $disabled = ($mode == 'view') ? 'disabled' : ''; ?>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input class="form-control" type="text" name="cisPortalBookingDate" id="cisPortalBookingDate" value="<?php echo $invoice_details['cis_booking_portal_date']; ?>" <?php echo $readonly; ?> <?php echo $disabled; ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row4 -->
                                                <div class="form-row">
                                                    <!-- Invoice Amount without GST -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceAmount">Invoice Amount
                                                            <span class="mb-0 text-muted fs-11">(Without GST)</span>
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <input class="form-control" type="text" name="invoiceAmount" id="invoiceAmount" value="<?php echo '&#8377;'.number_format($invoice_details['invoice_amount_without_gst'], 2); ?>" <?php echo $readonly; ?>>
                                                    </div>
                                                    <!-- GST -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="gst">GST
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <input class="form-control" type="text" name="gst" id="gst" value="<?php echo '&#8377;'.number_format($invoice_details['gst_amount'], 2); ?>" <?php echo $readonly; ?>>
                                                    </div>
                                                    <!-- Invoice Amount with GST -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="invoiceAmtwithGST">Invoice Amount
                                                            <span class="mb-0 text-muted fs-11">(With GST)</span>
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <input class="form-control" type="text" name="invoiceAmtwithGST" id="invoiceAmtwithGST" value="<?php echo '&#8377;'.number_format($invoice_details['invoice_amount_with_gst'], 2); ?>" <?php echo $readonly; ?>>
                                                    </div>
                                                    <!-- Di No./Emb No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="e-No">DI No. / EMB No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <?php $readonly = ($mode == 'view') ? 'readonly' : ''; ?>
                                                        <input class="form-control" type="text" name="e-No" id="e-No" value="<?php echo $invoice_details['di_emb_no']; ?>" <?php echo $readonly; ?>>
                                                    </div>
                                                </div>
                                                <!-- Row5 -->
                                                <div class="form-row">
                                                    <!-- Balance to Claim -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="balanceToClaim">Balance to Claim
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="balanceToClaim" id="balanceToClaim" value="<?php echo '&#8377;'.number_format($invoice_details['balance_to_claim'], 2); ?>" readonly>
                                                    </div>
                                                    <!-- Balance to Pay -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="balanceToPay">Balance to Pay
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="balanceToPay" id="balanceToPay" value="<?php echo '&#8377;'.number_format($invoice_details['balance_to_pay'], 2); ?>" readonly>
                                                    </div>
                                                </div>
                                                <!-- Row6 -->
                                                <div class="form-row mt-3">
                                                    <!-- Claim for Payment -->
                                                    <div class="col-xl-6">
                                                        <label class="form-label">Claim For Payment</label>
                                                    </div>  
                                                </div>
                                                <!-- Row7 -->
                                                <div class="form-row mt-2">
                                                    <!-- Claim for Payment Table -->
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
                                                                <?php foreach ($invoice_details['claim_payment_data'] as $key => $value) { ?>
                                                                <tr data-row-id="<?php echo $key; ?>">
                                                                    <td style="text-align: center;"><?php echo $value['claim_type']; ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['claim_amount_with_gst'], 2); ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['moblisation_adv_adjusted_amount'], 2); ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['ld_amount'], 2); ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['interest_on_moblisation_adv_amount'], 2); ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['other_deductions_amount'], 2); ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['tds_gsttds_amount'], 2); ?></td>
                                                                    <td style="text-align: center;"><?php echo '&#8377;'.number_format($value['payable_amount'], 2); ?></td>
                                                                    <!-- <td style="text-align: center;"><a href="javascript:void(0)" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#paymentDetails" data-claim-row="<?php //echo $key; ?>"><?php //echo '&#8377;'.$value['balance_to_pay_amount']; ?></a></td> -->
                                                                    <td style="text-align: center;"><a href="javascript:void(0)" class="btn btn-link" data-claim-row="<?php echo $key; ?>" onclick="openPaymentDetailsModal(this);"><?php echo '&#8377;'.number_format($value['balance_to_pay_amount'], 2); ?></a></td>
                                                                </tr>    
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php if ($mode == 'edit') { ?>
                                                    <button id="table2-new-row-button-claim-details" class="btn btn-primary mb-4 mt-4"> Add New Row</button>    
                                                    <?php } ?>
                                                </div>
                                                <!-- Row8 -->
                                                <div class="form-row">
                                                    <!-- Submit -->
                                                    <div class="col-xl-6 mb-3 mt-4">
                                                        <?php if ($mode == 'edit') { ?>
                                                        <button type="submit" class="btn btn-success">Submit</button>    
                                                        <?php } ?>
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
                <!-- App-Content Ends-->

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
                                    <tbody id="columns">
                                        <tr id="listitems1" class="column">
                                            <td><input type="text" class="form-control"></td>
                                            <td><input type="text" class="form-control"></td>
                                            <td>
                                                <span class="badgetext badge bg-primary rounded-pill">
                                                    <span aria-hidden="true" id="close1" onclick="close(1)">×</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- <tr id="listitems2" class="column">
                                            <td>30</td>
                                            <td>31-12-2023</td>
                                            <td>
                                                <span class="badgetext badge bg-primary rounded-pill">
                                                    <span aria-hidden="true" id="close2"onclick="close(2)">×</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr id="listitems3" class="column">
                                            <td>10</td>
                                            <td>31-01-2024</td>
                                            <td>
                                                <span class="badgetext badge bg-primary rounded-pill">
                                                    <span aria-hidden="true" id="close3" onclick="closeli(3)">×</span>
                                                </span>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- <ul class="list-group" id="columns"> 
                                <li class="column list-group-item justify-content-between" draggable="true" id="listitems1">
                                    <input type="text" class="form-control-diff" value="Observation 1">
                                    <span class="badgetext badge bg-primary rounded-pill">
                                        <span aria-hidden="true" id="close1" onclick="close(1)">×</span>
                                    </span>
                                </li> 
                                <li class="column list-group-item justify-content-between" draggable="true" id="listitems2">
                                    <input type="text" class="form-control-diff"  value="Observation 2">
                                    <span class="badgetext badge bg-primary rounded-pill">
                                        <span aria-hidden="true" id="close2"onclick="close(2)">×</span>
                                    </span>
                                </li> 
                                <li class="column list-group-item justify-content-between" draggable="true" id="listitems3">
                                    <input type="text" class="form-control-diff"  value="Observation 3">
                                    <span class="badgetext badge bg-primary rounded-pill">
                                        <span aria-hidden="true" id="close3" onclick="closeli(3)">×</span>
                                    </span>
                                </li> 
                            </ul> -->
                            <?php if ($mode == 'edit') { ?>
                            <div class="container mt-2 me-3">
                                <div class="row add_observation" id="addObservations" onclick="addObservations();">
                                    <span class="fe fe-plus-circle"> </span>
                                </div> 
                            </div>
                            <?php } ?>
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
        <!-- <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
        <script src="assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
        <script src="assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
        <script src="assets/plugins/datatable/js/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
        <script src="assets/js/table-data.js"></script> -->

        <script type="text/javascript">
            let mode = '<?php echo $mode ?>';
            let type_of_claims = <?php echo json_encode($type_of_claims) ?>;
            let form_change = false;
        </script>

        <!-- EDIT-TABLE JS -->
        <!-- <script src="assets/plugins/edit-table/bst-edittable.js"></script>
        <script src="assets/plugins/edit-table/edit-table.js"></script> -->
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

            $('input[name="invoiceDate"], input[name="paymentDate"], input[name="cisPortalBookingDate"], input[name="contractDate"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            let invoice_details = <?php echo json_encode($invoice_details) ?>;
            /*console.log('invoice_details: ');
            console.log(invoice_details);*/

            function openPaymentDetailsModal(anchor) {
                let claim_row_no = $(anchor).attr('data-claim-row');

                if (typeof invoice_details['claim_payment_data'][claim_row_no] !== 'undefined') {
                    let claim_payment_data = invoice_details['claim_payment_data'][claim_row_no]['payment_details_data'];
                    /*console.log('claim_payment_data:');
                    console.log(claim_payment_data);*/

                    // Clearing modal
                    $('#paymentDetails').find('#columns').empty();

                    let html = '';

                    $.each(claim_payment_data, function(index, value) {
                        let new_index = ++index;
                        let tr_id = 'listitems'+ new_index;
                        let span_id = 'close'+ new_index;
                        let click_func = 'close('+ new_index +')';

                        html += 'tr id="'+ tr_id +'" class="column"';
                        html += '<td>'+ value.paid_amount +'</td>';
                        html += '<td>'+ value.paid_date +'</td>';
                        
                        if (mode == 'edit') {
                            html += '<td>';
                            html += '<span class="badgetext badge bg-primary rounded-pill">';
                            html += '<span aria-hidden="true" id="'+ span_id +'"onclick="'+ click_func +'">×</span>';
                            html += '</span>';
                            html += '</td>';
                        }                    
                        
                        html += '</tr>';
                    });

                    $('#paymentDetails').find('#columns').append(html);
                }

                $('#paymentDetails').modal('show');
            }

            function addObservations()
            {
                var listItems;
                var cols = document.querySelectorAll('#columns .column');
                var colsLenght = cols.length+1;

                var html = '';
                
                html += '<tr id="listitems'+colsLenght+'" class="column">';
                html += '<td><input type="text" class="form-control"></td>';
                html += '<td><input type="text" class="form-control"></td>';
                html += '<td>';
                html += '<span class="badgetext badge bg-primary rounded-pill">';
                html += '<span aria-hidden="true" id="close'+colsLenght+'" onclick="closeli('+colsLenght+')">×</span>';
                html += '</span>';
                html += '</td>';
                html += '</tr>';


                $("#columns").append(html);
            }

            function closeli(id)
            {
                //alert(id);
                $("#listitems"+id).remove();
            }

            $('#table2-new-row-button-claim-details').click(function(event) {
                event.preventDefault();
            });
        </script>

    </body>
</html>