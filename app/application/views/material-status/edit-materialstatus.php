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
        <title>MPPKVVCL - Material Status</title>

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
                <!-- App-Sidebar Ends -->

                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                    <div class="side-app">
                        
                        <!-- Container -->
                        <div class="main-container container-fluid">
                            
                            <!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title"><?php echo $title; ?></h1>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-add me-3"><?php echo $material_data['status']; ?></a>
                                            </div>
                                        </div>

                                        <!-- <form class="needs-validation" novalidate> -->
                                        <form id="editMaterialStatus" method="post" action="<?php echo base_url('save-material-status'); ?>">
                                            <!-- Material Status ID -->
                                            <input type="hidden" name="material_status_id" id="material_status_id" value="<?php echo $material_data['material_status_id']; ?>">
                                            <!-- Contract ID -->
                                            <!-- <input type="hidden" name="contract_id" id="contract_id" value="<?php echo $material_data['contract_id']; ?>"> -->
                                            <input type="hidden" name="package_group_no" id="package_group_no" value="<?php echo $material_data['package_group_no']; ?>">

                                            <div class="card-body">
                                                <!-- Row1 -->
                                                <div class="form-row">
                                                    <!-- Contractor (TKC) -->
                                                    <div class="col-xl-6 mb-3">
                                                        <label class="form-label" for="contractorTKC">Contractor (TKC)
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" id="contractorTKC" name="contractorTKC" value="<?php echo $material_data['contractor_name']; ?>" readonly>
                                                        <div class="list-group list-view-contractor" id="list-view"></div>
                                                    </div>
                                                    <!-- Contract No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="tenderAwardNo">Contract No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" id="tenderAwardNo" name="tenderAwardNo" value="<?php echo $material_data['tender_award_no']; ?>" readonly>
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
                                                            <input type="text" class="form-control" name="tenderAwardDate" value="<?php echo $material_data['tender_award_date']; ?>" readonly disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row2 -->
                                                <div class="form-row">
                                                    <!-- DISCOM -->
                                                    <!-- <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="discom">DISCOM
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="discom" id="disocm" value="<?php echo $material_data['discom']; ?>">
                                                    </div> -->
                                                    <!-- Type of Work -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="typeOfWork">Type of Work
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <select class="form-control select2" id="typeOfWork" disabled>
                                                            <option value="select" disabled>Select Type Of Work</option>
                                                            <?php foreach ($work_list as $key => $value) { ?>
                                                                <?php $selected = ($material_data['typeofwork_id'] == $value['typeofwork_id']) ? 'selected' : ''; ?>
                                                                <option value="<?php echo $value['typeofwork_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- TKC Offer Letter No. -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="TKCOfferLetterNo">TKC Offer Letter No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input class="form-control" type="text" name="TKCOfferLetterNo" id="TKCOfferLetterNo" value="<?php echo $material_data['offer_letter_no']; ?>" readonly>
                                                    </div>
                                                    <!-- TKC Offer Letter Date -->
                                                    <div class="col-xl-3 mb-3">
                                                        <label class="form-label" for="TKCOfferLetterDate">TKC Offer Letter Date
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-text dates">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input type="text" class="form-control" name="TKCOfferLetterDate" value="<?php echo $material_data['offer_letter_date']; ?>" readonly disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row3 -->
                                                <div class="form-row">
                                                    <div class="col-lg-12 mt-6">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered border mb-0" id="new-edit-material-details" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr No.</th>
                                                                        <th style="width:25% !important">Material</th>
                                                                        <th>Orginal BOQ Quantity</th>
                                                                        <th>Revised BOQ Quantity</th>
                                                                        <th>Earlier Approved Quantity</th>
                                                                        <th>Balance Quantity</th>
                                                                        <th>Offer Letter Quantity</th>
                                                                        <th>Date of Readiness</th>
                                                                        <!-- <th>PDI Letter No.</th>
                                                                        <th>PDI Letter Date</th> -->
                                                                        <th>Inspection Letter No.</th>
                                                                        <th>Inspection Letter Date</th>
                                                                        <th>DI No.</th>
                                                                        <th>DI Date</th>
                                                                        <th>DI Quantity</th>
                                                                        <th>Material Received Date</th>
                                                                        <th>Material Received Quantity</th>
                                                                        <th>Sample Size</th>
                                                                        <th>Sampling Date</th>
                                                                        <th>Date Of Acceptance</th>
                                                                        <th>Acceptance Quantity</th>
                                                                        <th>MRC Generated No</th>
                                                                        <th>File Upload</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($material_data['material_details'] as $key => $value) { ?>
                                                                    <tr data-row-id="<?php echo $key; ?>" data-ms-detail-id="<?php echo $value['material_status_detail_id']; ?>">
                                                                        <td class="sr-no">
                                                                            <?php echo ++$key; ?>
                                                                        </td>
                                                                        <td class="material-name">
                                                                            <?php echo $value['material_name']; ?>
                                                                        </td>
                                                                        <td class="og-boq-qty">
                                                                            <?php echo $value['quantity']; ?>
                                                                        </td>
                                                                        <td class="revised-boq-qty">
                                                                            <?php echo $value['revised_quantity']; ?>
                                                                        </td>
                                                                        <td class="approved-qty">
                                                                            <?php echo $value['earlier_approved_quantity']; ?>
                                                                        </td>
                                                                        <td class="bal-qty">
                                                                            <?php $balance_qty = $value['revised_quantity'] - $value['earlier_approved_quantity']; ?>
                                                                            <?php echo (number_format((float)$balance_qty, 2, '.', '')); ?>
                                                                        </td>
                                                                        <td class="offer-letter-qty">
                                                                            <?php echo $value['offer_letter_quantity']; ?>
                                                                        </td>
                                                                        <td class="date-of-readiness">
                                                                            <?php echo $value['date_of_readiness']; ?>
                                                                        </td>
                                                                        <!-- <td class="pdi-letter-no">
                                                                            <?php //echo $value['pdi_letter_no']; ?>
                                                                        </td>
                                                                        <td class="pdi-letter-date">
                                                                            <?php //echo $value['pdi_letter_date']; ?>
                                                                        </td> -->
                                                                        <td class="inspection-letter-no">
                                                                            <?php echo $value['inspection_letter_no']; ?>
                                                                        </td>
                                                                        <td class="inspection-letter-date">
                                                                            <?php echo $value['inspection_letter_date']; ?>
                                                                        </td>
                                                                        <td class="di-material-no">
                                                                            <?php echo $value['di_material_no']; ?>
                                                                        </td>
                                                                        <td class="di-material-date">
                                                                            <?php echo $value['di_material_date']; ?>
                                                                        </td>
                                                                        <td class="di-qty">
                                                                            <?php echo $value['di_quantity']; ?>
                                                                        </td>
                                                                        <td class="material-received-date">
                                                                            <?php echo (!empty($value['received_materials_details'])) ? date('d-m-Y', strtotime($value['received_materials_details'][0]['received_date'])) : ''; ?>
                                                                        </td>
                                                                        <td class="material-received-qty">
                                                                            <?php echo (!empty($value['received_materials_details'])) ? $value['received_materials_details'][0]['quantity'] : ''; ?>
                                                                        </td>
                                                                        <td class="sample-size">
                                                                            <?php echo (!empty($value['random_sampling_details'])) ? $value['random_sampling_details'][0]['sampling_quantity'] : ''; ?>
                                                                        </td>
                                                                        <td class="sampling-date">
                                                                            <?php echo (!empty($value['random_sampling_details'])) ? date('d-m-Y', strtotime($value['random_sampling_details'][0]['sampling_date']))  : ''; ?>
                                                                        </td>
                                                                        <td class="date-of-acceptance">
                                                                            <?php echo (!empty($value['random_sampling_details'])) ? date('d-m-Y', strtotime($value['random_sampling_details'][0]['accepted_report_date']))  : ''; ?>
                                                                        </td>
                                                                        <td class="acceptance-quantity">
                                                                            <?php echo (!empty($value['random_sampling_details'])) ? $value['random_sampling_details'][0]['accepted_quantity']  : ''; ?>
                                                                        </td>
                                                                        <td class="mrc-generated-no">
                                                                            <?php echo $value['mrc_generated_no'] ?>
                                                                        </td>
                                                                        <td class="file-upload">
                                                                            <?php if (!empty($value['material_files'])) { ?>
                                                                                <?php foreach ($value['material_files'] as $file) { ?>
                                                                                <a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block">
                                                                                    <img src="<?php echo base_url($file['file_path']); ?>" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">
                                                                                </a>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row4 -->
                                                <div class="form-row">
                                                    <div class="col-xl-6 mb-3 mt-4">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                        <a href="<?php echo base_url('material-status'); ?>" type="button" class="btn btn-primary">Back</a>
                                                        <!-- <button type="button" class="btn btn-warning">Print</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Container Ends -->
                    </div>
                </div>
                <!-- App-Content Ends -->

            </div>
            <!-- Page Main Ends -->

            <!-- Material Details Modal -->
            <div class="modal fade" id="material-details-modal" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header material-status-pop-header">
                            <div class="col-xl-6">
                                <h6 class="modal-title">
                                   <p>Material Status Details</p>
                                </h6>   
                            </div>

                            <!-- Material Quantity -->
                            <div class="col-xl-6">
                                <button class="btn-close material-status-pop-cls-btn" data-bs-dismiss="modal" aria-label="Close" onclick="findtr()">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div id="material-quantity" style="margin-right: 45px;">
                                    <p class="text-end">Material Quantity: <span class="material-qty text-danger"></span></p>
                                </div>
                            </div>

                            <!-- Toaster Alert -->
                            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-animation="true" id="material-alert">
                                <div class="d-flex toster-out">
                                    <div class="toast-body"> Hello, world! This is a toast message. </div>
                                    <button aria-label="Close" class="btn-close text-white ms-auto  pe-2" data-bs-dismiss="toast" style="margin: -6px;">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <form class="form-horizontal" name="saveMaterialDetails" id="saveMaterialDetails" enctype="multipart/form-data">
                            <div class="modal-body pt-2 material-details-modal-body">                          
                                <!-- Row1 -->
                                <div class="row mb-3">
                                    <!-- Contract Material ID -->
                                    <input type="hidden" name="material_status_detail_id">
                                    <!-- Material Name -->
                                    <div class="col-md-12">
                                        <label for="" class="form-label">Material Name
                                            <span class="text-red">*</span>
                                        </label>
                                        <!-- <input type="text" class="form-control" id="" name=""> -->
                                        <!-- <textarea class="form-control" rows="1"></textarea> -->
                                        <select name="materials" id="materials" class="form-control form-select" data-bs-placeholder="Select Material" disabled>
                                            <!-- <option value="select" selected disabled>Select Material</option> -->
                                        </select>
                                    </div>
                                </div>
                                <!-- Row2 -->
                                <div class=" row mb-1">
                                    <!-- Offer Letter Quantity -->
                                    <div class="col-md-3">
                                        <label for="offerLetterQuantity" class="form-label">Offer Material Quantity
                                            <span class="text-red">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="offerLetterQuantity" name="offerLetterQuantity">
                                    </div>
                                    <!-- Date of Readiness -->
                                    <div class="col-md-3">
                                        <label for="dateOfReadiness" class="form-label">Date of Readiness</label>
                                        <div class="input-group">
                                            <div class="input-group-text dates">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                            <input type="text" class="form-control" id="dateOfReadiness" name="dateOfReadiness" disabled>
                                        </div>
                                    </div>
                                    <!-- PDI Letter No. -->
                                    <!-- <div class="col-md-3">
                                        <label for="pdiLetterNo" class="form-label">PDI Letter No.</label>
                                        <input type="text" class="form-control" id="pdiLetterNo" name="pdiLetterNo" disabled>
                                    </div> -->
                                    <!-- PDI Letter Date -->
                                    <!-- <div class="col-md-3">
                                        <label for="pdiLetterDate" class="form-label">PDI Letter Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text dates">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                            <input type="text" class="form-control" name="pdiLetterDate" id="pdiLetterDate" disabled />
                                        </div>
                                    </div> -->
                                    <!-- Inspection Letter No. -->
                                    <div class="col-md-3">
                                        <label for="inspectionLetterNo" class="form-label">Inspection Letter No.</label>
                                        <input type="text" class="form-control" id="inspectionLetterNo" name="inspectionLetterNo" disabled>    
                                    </div>
                                    <!-- Inspection Letter Date -->
                                    <div class="col-md-3">
                                        <label for="inspectionLetterDate" class="form-label">Inspection Letter Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text dates">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div> 
                                            <input type="text" class="form-control" name="inspectionLetterDate" id="inspectionLetterDate" disabled />
                                        </div>
                                    </div>
                                </div>
                                <!-- Row3 -->
                                <div class="row mb-3">
                                    <!-- Inspecting Agency -->
                                    <!-- <div class="col-md-3">
                                        <label for="inspectionAgency" class="form-label">Inspecting Agency</label>
                                        <select name="inspectionAgency" class="form-control form-select" data-bs-placeholder="Select Agency" disabled>
                                        </select>
                                    </div> -->
                                    <!-- Date Of Inspection -->
                                    <div class="col-md-3">
                                        <label for="dateofInspection" class="form-label">Date of Inspection</label>
                                        <div class="input-group">
                                            <div class="input-group-text dates">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                            <input type="text" class="form-control" name="dateofInspection" id="dateofInspection" disabled />
                                        </div>
                                    </div>
                                    <!-- Material Serial Nos -->
                                    <div class="col-md-6">
                                        <label for="materialSerialNos" class="form-label">Material Serial Nos.
                                        <!-- <span class="text-red">*</span> -->
                                        </label>
                                        <input type="text" class="form-control" id="materialSerialNos" name="materialSerialNos" disabled>    
                                    </div>
                                </div>
                                <!-- Row4 -->
                                <div class="row mb-3">
                                    <!-- DI Material No. -->
                                    <div class="col-md-3">
                                        <label for="diMaterialNo" class="form-label">DI No.
                                            <!-- <span class="text-red">*</span> -->
                                        </label>
                                        <input type="text" class="form-control" id="diMaterialNo" name="diMaterialNo" disabled>
                                    </div>
                                    <!-- DI Material Date -->
                                    <div class="col-md-3">
                                        <label for="diMaterialDate" class="form-label">DI Date
                                            <!-- <span class="text-red">*</span> -->
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-text dates">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                            <input type="text" class="form-control" name="diMaterialDate" id="diMaterialDate" disabled />
                                        </div>
                                    </div>
                                    <!-- DI Quantity -->
                                    <div class="col-md-3">
                                        <label for="diQuantity" class="form-label">DI Quantity
                                            <!-- <span class="text-red">*</span> -->
                                        </label>
                                        <input type="text" class="form-control" id="diQuantity" name="diQuantity" disabled>
                                    </div>
                                    <!-- DI Remark -->
                                    <div class="col-md-3">
                                        <label for="diRemark" class="form-label">DI Remark
                                            <!-- <span class="text-red">*</span> -->
                                        </label>
                                        <input type="text" class="form-control" id="diRemark" name="diRemark" disabled>
                                    </div>
                                </div>
                                <!-- Row5 -->
                                <div class=" row mb-3">
                                </div>
                                <!-- Row6 -->
                                <div class=" row mb-3">
                                    <!-- File Upload -->
                                    <div class="col-md-12">
                                        <label for="fileUpload" class="form-label">File Upload</label>
                                        <input class="form-control" type="file" id="material_file" name="material_file[]" multiple>
                                        <div class="text-wrap mt-2" id="preview-material_img"></div>
                                    </div>
                                </div>
                                <!-- Row7 Material Received Detail -->
                                <div class="row mb-3">
                                    <label class="form-label">Material Received Details</label>
                                </div>
                                <!-- Row8 Material Received Detail Table -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered border text-nowrap mb-0" id="new-edit-material-received-details">
                                                <thead>
                                                    <tr>
                                                        <th>Circle</th>
                                                        <th>Quantity</th>
                                                        <th>Serial Nos</th>
                                                        <th>DRR Date</th>
                                                        <!-- <th name="bstable-actions">Actions</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td class="received-qty"></td>
                                                        <td></td>
                                                        <td class="received-date"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button id="table2-new-row-button-material-received-details" class="btn btn-primary mb-4 mt-4"> Add New Row</button>
                                    </div>
                                </div>
                                <!-- Row9 Random Sampling Details -->
                                <div class="row mb-3">
                                    <label class="form-label">Random Sampling Details</label>
                                </div>
                                <!-- Row10 Random Sampling Details Table -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered border text-nowrap mb-0" id="new-edit-material-sampling-details">
                                                <thead>
                                                    <tr>
                                                        <th>Circle</th>
                                                        <th>Sampling Quantity</th>
                                                        <th>Sampling Serial Nos</th>
                                                        <th>Sampling Date</th>
                                                        <th>Sampling Letter No</th>
                                                        <th>Sampling Lab</th>
                                                        <th>Accepted Report No</th>
                                                        <th>Accepted Report Date</th>
                                                        <!-- <th>Accepted Yes/No</th> -->
                                                        <th>Accepted Quantity</th>
                                                        <!-- <th name="bstable-actions">Actions</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button id="table2-new-row-button-material-sampling-details" class="btn btn-primary mt-4"> Add New Row</button>
                                    </div>
                                </div>
                                <!-- Row11 -->
                                <div class="row mb-3">
                                    <!-- MRC Generated No -->
                                    <div class="col-md-3">
                                        <label for="mrcGeneratedNo" class="form-label">MRC Generated No</label>
                                        <input type="text" class="form-control" id="mrcGeneratedNo" name="mrcGeneratedNo">
                                    </div>
                                    <!-- MRC Generated Date -->
                                    <div class="col-md-3">
                                        <label for="mrcGeneratedDate" class="form-label">MRC Generated Date</label>
                                        <div class="input-group">
                                            <div class="input-group-text dates">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                            <input type="text" class="form-control" id="mrcGeneratedDate" name="mrcGeneratedDate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="submit" data-action="save">Submit</button>
                                <button class="btn ripple btn-primary" data-bs-dismiss="modal" type="button" onclick="findtr()">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Material Details Modal Ends -->

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

        <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">
            //For material-status-received.js to access circle list
            let circle_list = <?php echo json_encode($circle_data) ?>;
            let sampling_lab_data = <?php echo json_encode($sampling_lab_data) ?>;

            var form_change = false;
        </script>

        <!-- EDIT-TABLE JS -->
        <!-- <script src="assets/plugins/edit-table/bst-edittable.js"></script> -->
        <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-status.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-status-received.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-status-random-sampling.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/material-status/material-edit-table.js'); ?>"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                let edit_btn = $('#new-edit-material-details > tbody').find('.b-Edit');

                $(edit_btn).each(function(index, value) {
                    // console.log(value); return false;
                    $(value).attr('data-action', 'edit');
                });

                const tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();

                /*const circle_list = '<?php echo json_encode($circle_data) ?>';
                console.log(circle_list);*/
            });

            $('input[name="TKCOfferLetterDate"], input[name="tenderAwardDate"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            $('input[name="dateOfAcceptance"], input[name="materialReceivedDate"], input[name="sampleDate"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                parentEl: '#input-modal .modal-body',
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });      

            $('input[name="materialReceivedDate"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                parentEl: '#new-edit-material-received-details tbody .received-date',
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });


            /*$('input[name="pdiLetterNo"], input[name="inspectionLetterNo"], input[name="materialSerialNos"], input[name="diMaterialNo"], input[name="diQuantity"], input[name="mrcGeneratedNo"]').change(function(){
                form_change = true;
            });*/

            $('input[name="inspectionLetterNo"], input[name="materialSerialNos"], input[name="diMaterialNo"], input[name="diQuantity"], input[name="diRemark"], input[name="mrcGeneratedNo"]').change(function(){
                form_change = true;
            });


            //Displays contractor search list view
            function showtkclist(tkcValue) {
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

            //Closes the contractor search list view on document click
            $(document).click(function() {
                // alert('click');
                var list_view = $('#list-view');
                if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                    list_view.hide();
                }
            });

            //Getting Uploaded File data and displaying the image
            $('#material_file').on('change', function(event) {
                form_change = true; 

                //Clearing previously uploaded images
                $('#preview-material_img').empty();

                // Get the selected image files
                let files = event.target.files;

                if (files.length > 0) {
                    //Loop through all the selected images
                    for(let file of files) {
                        const reader = new FileReader();

                        // Convert each image file to a string
                        reader.readAsDataURL(file);

                        reader.onload = function() {
                            let html_img = '';
                            html_img += '<div class="file-image-1">';
                            html_img += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
                            html_img += '<img src="'+reader.result+'" class="br-5" alt="">';
                            html_img += '</a>';
                            /*html_img += '<ul class="icons">';
                            html_img += '<li>';
                            html_img += '<a href="javascript:void(0)" class="btn bg-danger">';
                            html_img += '<i class="fe fe-trash"></i>';
                            html_img += '</a>';
                            html_img += '</li>';
                            html_img += '</ul>';*/
                            // html_img += '<span class="file-name-1">'+file.name+'</span>';
                            html_img += '</div>';

                            $('#preview-material_img').append(html_img);
                        }
                    }
                }
            });

            //Displaying Material Details Modal
            function showMaterialDetails(btn) {
                console.log('inside showMaterialDetails function');
                let contractor = $('input[name="contractorTKC"]').val();
                let tkc_offer_letter_no = $('input[name="TKCOfferLetterNo"]').val();
                let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();

                if (contractor === '') {
                    $('.toast-body').text('Select Contractor (TKC)');
                    $('.toast').toast('show');

                    return false;
                } else if (tkc_offer_letter_no === '') {
                    $('.toast-body').text('Enter TKC Offer Letter No.');
                    $('.toast').toast('show');

                    return false;
                } else if (tkc_offer_letter_date === '') {
                    $('.toast-body').text('Enter TKC Offer Letter Date');
                    $('.toast').toast('show');

                    return false;
                } else {
                    actionsModeEdit(btn);

                    let action = $(btn).attr('data-action');

                    if (action == 'edit') {
                        let tr = $(btn).closest('tr');
                        let row_id = $(tr).attr('data-row-id');
                        let ms_detail_id = $(tr).attr('data-ms-detail-id');
                        let contract_id = $('input[name="contract_id"]').val();
                        
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url('get-material-details') ?>',
                            dataType: 'json',
                            data: {material_status_detail_id: ms_detail_id, contract_id: contract_id},
                            success: function(response){
                                console.log('response:');
                                console.log(response); 
                                let material_details = response.material_details_data;
                                let agencies = response.inspecting_agency_data;

                                let modal = $('#material-details-modal');

                                //setting value of material_status_detail_id input
                                $('input[name="material_status_detail_id"]').val(ms_detail_id);

                                //Displaying Material Revised Quantity
                                $(modal).find('#material-quantity span.material-qty').text(material_details.revised_quantity);

                                //Displaying Material Name
                                let html = '<option value="" selected>'+material_details.material_name+'</option>';
                                $(modal).find('select[name="materials"]').append(html);

                                //Displaying Offer Letter Quantity
                                $(modal).find('input[name="offerLetterQuantity"]').val(material_details.offer_letter_quantity);

                                // Enabling all the input fields on the modal
                                if (material_details.offer_letter_quantity != '') {
                                    enableInputBlock();
                                }
                                
                                //Displaying Date of Readiness
                                if (material_details.date_of_readiness != null) {
                                    $(modal).find('input[name="dateOfReadiness"]').val(material_details.date_of_readiness);
                                } else {
                                    setDateOfReadiness();
                                }

                                //Displaying PDI Letter No
                                /*if (material_details.pdi_letter_no != null) {
                                    // $(modal).find('input[name="pdiLetterNo"]').prop('disabled', false);
                                    $(modal).find('input[name="pdiLetterNo"]').val(material_details.pdi_letter_no);
                                }*/

                                //Displaying PDI Letter Date
                                /*if (material_details.pdi_letter_date != null) {
                                    // $(modal).find('input[name="pdiLetterDate"]').prop('disabled', false);
                                    $(modal).find('input[name="pdiLetterDate"]').val(material_details.pdi_letter_date);
                                }*/

                                //Displaying Inspection Letter No
                                if (material_details.inspection_letter_no != null) {
                                    $(modal).find('input[name="inspectionLetterNo"]').val(material_details.inspection_letter_no);
                                }

                                //Displaying Inspection Letter Date
                                if (material_details.inspection_letter_date != null) {
                                    $(modal).find('input[name="inspectionLetterDate"]').val(material_details.inspection_letter_date);
                                }

                                //Displaying Inspecting Agency
                                /*if (material_details.inspecting_agency_id != null) {
                                    // $(modal).find('input[name="inspectionAgency"]').prop('disabled', false);
                                    
                                    let agency_html = '';

                                    $('select[name="inspectionAgency"]').empty();

                                    agency_html += '<option value="select" disabled>Select Agency</option>';
                                    $.each(agencies, function(index, value) {
                                        let selected = (material_details.inspecting_agency_id == value.inspecting_agency_id) ? 'selected' : '';

                                        agency_html += '<option value="'+value.inspecting_agency_id+'" '+selected+'>'+value.name+'</option>';
                                    });

                                    $('select[name="inspectionAgency"]').append(agency_html);
                                } else {
                                    let inspecting_agency_data = response.inspecting_agency_data;

                                    let agency_html = '';

                                    agency_html += '<option value="select" selected disabled>Select Agency</option>';
                                    $.each(inspecting_agency_data, function(index, value) {
                                        agency_html += '<option value="'+value.inspecting_agency_id+'">'+value.name+'</option>';
                                    });

                                    $('select[name="inspectionAgency"]').append(agency_html);
                                }*/

                                //Displaying Date of Inspection
                                if (material_details.date_of_inspection != null) {
                                    $(modal).find('input[name="dateofInspection"]').val(material_details.date_of_inspection);
                                }

                                //Displaying Material Serial Nos
                                if (material_details.material_serial_nos != null) {
                                    $(modal).find('input[name="materialSerialNos"]').val(material_details.material_serial_nos);
                                }

                                //Displaying DI Material No
                                if (material_details.di_material_no != null) {
                                    $(modal).find('input[name="diMaterialNo"]').val(material_details.di_material_no);
                                }

                                //Displaying DI Material Date
                                if (material_details.di_material_date != null) {
                                    $(modal).find('input[name="diMaterialDate"]').val(material_details.di_material_date);
                                }

                                //Displaying DI Quantity
                                if (material_details.di_quantity != null) {
                                    $(modal).find('input[name="diQuantity"]').val(material_details.di_quantity);
                                }

                                //Displaying DI Quantity
                                if (material_details.di_remarks != null) {
                                    $(modal).find('input[name="diRemark"]').val(material_details.di_remarks);
                                }

                                //Displaying Uploaded Files
                                if (!$.isEmptyObject(material_details.material_files)) {
                                    $('#preview-material_img').empty();
                                    let file_html = '';
                                    $.each(material_details.material_files, function(index, value) {
                                        var file_path = '<?php echo base_url() ?>'+value.file_path;
                                        file_html += '<div class="file-image-1">';
                                        file_html += '<a href="javascript:void(0)" onclick="showImageModal(this)">';
                                        file_html += '<img src="'+file_path+'" class="br-5" alt="">';
                                        file_html += '</a>';
                                        /*file_html += '<ul class="icons">';
                                        file_html += '<li>';
                                        file_html += '<a href="javascript:void(0)" class="btn bg-danger">';
                                        file_html += '<i class="fe fe-trash"></i>';
                                        file_html += '</a>';
                                        file_html += '</li>';
                                        file_html += '</ul>';*/
                                        file_html += '</div>';
                                    });

                                    $('#preview-material_img').append(file_html);    
                                }                                

                                //Displaying Material Received Details
                                if (!$.isEmptyObject(material_details.received_materials_details)) {
                                    var material_received = new BSTableMaterialReceived("new-edit-material-received-details", {
                                        $addButton: $("#table2-new-row-button-material-received-details"),
                                        onEdit:function() {
                                            console.log("EDITED");
                                        },
                                        materialData: material_details.received_materials_details
                                    });
                                    material_received.refresh();
                                    /*$('#new-edit-material-received-details tbody').empty();
                                    let material_html = '';

                                    $.each(material_details.received_materials_details, function(index, value) {
                                        material_html += '<tr>';
                                        material_html += '<td name="bstable-actions">';
                                        material_html += '<div class="btn-list">';
                                        material_html += '<button id="bEdit" type="button" class="btn btn-sm" >';
                                        material_html += '<span class="fe fe-edit fa-lg action-btn-table"> </span>';
                                        material_html += '</button>';
                                        material_html += '<button id="bDel" type="button" class="btn  btn-sm">';
                                        material_html += '<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>';
                                        material_html += '</button>';
                                        material_html += '</div>';
                                        material_html += '</td>';
                                        material_html += '<td>'+value.circle_name+'</td>';
                                        material_html += '<td class="received-qty">'+value.quantity+'</td>';
                                        material_html += '<td>'+value.serial_nos+'</td>';
                                        material_html += '<td class="received-date">'+value.received_date+'</td>';
                                        material_html += '</tr>';
                                    });

                                    $('#new-edit-material-received-details tbody').append(material_html);*/
                                }                                

                                //Displaying Sampling Details
                                if (!$.isEmptyObject(material_details.random_sampling_details)) {
                                    var random_sampling = new BSTableMaterialRandomSampling("new-edit-material-sampling-details", {
                                        $addButton: $("#table2-new-row-button-material-sampling-details"),
                                        onEdit:function() {
                                            console.log("EDITED");
                                        },
                                        samplingData: material_details.random_sampling_details
                                    });
                                    random_sampling.refresh();
                                    /*$('#new-edit-material-sampling-details > tbody').empty();
                                    let sampling_html = '';

                                    $.each(material_details.random_sampling_details, function(index, value) {
                                        sampling_html += '<tr>';
                                        sampling_html += '<td name="bstable-actions">';
                                        sampling_html += '<div class="btn-list">';
                                        sampling_html += '<button id="bEdit" type="button" class="btn btn-sm">';
                                        sampling_html += '<span class="fe fe-edit fa-lg action-btn-table"> </span>';
                                        sampling_html += '</button>';
                                        sampling_html += '<button id="bDel" type="button" class="btn  btn-sm">';
                                        sampling_html += '<span class="fe fe-trash-2 fa-lg action-btn-table"> </span>';
                                        sampling_html += '</button>';
                                        sampling_html += '</div>';
                                        sampling_html += '</td>';
                                        sampling_html += '<td>'+value.circle_name+'</td>';
                                        sampling_html += '<td>'+value.sampling_quantity+'</td>';
                                        sampling_html += '<td>'+value.sampling_serial_nos+'</td>';
                                        sampling_html += '<td>'+value.sampling_date+'</td>';
                                        sampling_html += '<td>'+value.sampling_letter_no+'</td>';
                                        // sampling_html += '<td>'+value.lab_name+'</td>';
                                        sampling_html += '<td>'+value.sampling_lab_id+'</td>';
                                        sampling_html += '<td>'+value.accepted_report_no+'</td>';
                                        sampling_html += '<td>'+value.accepted_report_date+'</td>';
                                        sampling_html += '<td>'+value.accepted_quantity+'</td>';
                                        sampling_html += '</tr>';
                                    });

                                    $('#new-edit-material-sampling-details > tbody').append(sampling_html);*/
                                }

                                //Displaying MRC Generated No
                                if (material_details.mrc_generated_no != null) {
                                    $(modal).find('input[name="mrcGeneratedNo"]').val(material_details.mrc_generated_no);
                                }

                                //Displaying MRC Generated Date
                                if (material_details.mrc_generated_date != null) {
                                    $(modal).find('input[name="mrcGeneratedDate"]').val(material_details.mrc_generated_date);
                                }
                            },
                            error: function(xhr, status, error){
                                console.log(xhr.responseText);
                            }
                        }); 
                    }

                    $('#material-details-modal').modal('show');   
                }
            }

            function enableInputBlock() {
                $('input[name="dateOfReadiness"]').prop('disabled', false);
                /*$('input[name="pdiLetterNo"]').prop('disabled', false);
                $('input[name="pdiLetterDate"]').prop('disabled', false);*/
                $('input[name="inspectionLetterNo"]').prop('disabled', false);
                $('input[name="inspectionLetterDate"]').prop('disabled', false);
                // $('select[name="inspectionAgency"]').prop('disabled', false);
                $('input[name="dateofInspection"]').prop('disabled', false);
                $('input[name="materialSerialNos"]').prop('disabled', false);
                $('input[name="diMaterialNo"]').prop('disabled', false);
                $('input[name="diMaterialDate"]').prop('disabled', false);
                $('input[name="diQuantity"]').prop('disabled', false);
                $('input[name="diRemark"]').prop('disabled', false);
            }

            function setDateOfReadiness() {
                console.log('inside setDateOfReadiness block');
                let tkc_offer_letter_date = $('input[name="TKCOfferLetterDate"]').val();
                
                $('input[name="dateOfReadiness"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    minDate: getModifiedDate(tkc_offer_letter_date),
                    parentEl: '#material-details-modal .modal-body',
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                });                
                

                $('input[name="dateOfReadiness"]').on('apply.daterangepicker', function(ev, picker) {
                   $(this).val(picker.startDate.format('DD-MM-YYYY'));
                   form_change = true;
                });
            }

            /*$('input[name="pdiLetterDate"]').focus(function() {
                let pdiLetterDate = $(this).val();

                if (pdiLetterDate == '') {
                    let dateOfReadiness = $('input[name="dateOfReadiness"]').val();    

                    if (dateOfReadiness == '') {
                       $('#material-alert').find('.toast-body').text('Select Date of Readiness');
                       $('#material-alert').toast('show');
                       return false;
                    } else {
                       let pdiLetterNo = $('input[name="pdiLetterNo"]').val();
                       
                       if (pdiLetterNo == '') {
                          $('#material-alert').find('.toast-body').text('Enter PDI Letter No');
                          $('#material-alert').toast('show');
                          return false;
                       } else {
                          setPdiLetterDate(dateOfReadiness);   
                       }
                    }
                }
            });*/

            /*function setPdiLetterDate(dateOfReadiness) {
                $('input[name="pdiLetterDate"]').daterangepicker({
                   singleDatePicker: true,
                   showDropdowns: true,
                   autoUpdateInput: false,
                   minDate: getModifiedDate(dateOfReadiness),
                   opens: 'left',
                   parentEl: '#material-details-modal .modal-body',
                   locale: {
                      format: 'DD-MM-YYYY'
                   }
                });

                $('input[name="pdiLetterDate"]').on('apply.daterangepicker', function(ev, picker) {
                   $(this).val(picker.startDate.format('DD-MM-YYYY'));
                });
            }*/

            $('input[name="inspectionLetterDate"]').focus(function() {
                let inspectionLetterDate = $(this).val();

                if (inspectionLetterDate == '') {
                    let dateOfReadiness = $('input[name="dateOfReadiness"]').val();
                    
                    if (dateOfReadiness == '') {
                       $('#material-alert').find('.toast-body').text('Select Date of Readiness');
                       $('#material-alert').toast('show');
                       return false;
                    } else {
                       let inspectionLetterNo = $('input[name="inspectionLetterNo"]').val();

                       if (inspectionLetterNo == '') {
                          $('#material-alert').find('.toast-body').text('Enter Inspection Letter No');
                          $('#material-alert').toast('show');
                          return false;
                       } else {
                          setInspectionLetterDate(dateOfReadiness);   
                       }
                    }
                }
            });

            function setInspectionLetterDate(dateOfReadiness) {
                $('input[name="inspectionLetterDate"]').daterangepicker({
                   singleDatePicker: true,
                   showDropdowns: true,
                   autoUpdateInput: false,
                   minDate: getModifiedDate(dateOfReadiness),
                   maxDate: new Date(), 
                   opens: 'left',
                   parentEl: '#material-details-modal .modal-body',
                   locale: {
                      format: 'DD-MM-YYYY'
                   }                     
                });

                $('input[name="inspectionLetterDate"]').on('apply.daterangepicker', function(ev, picker) {
                   $(this).val(picker.startDate.format('DD-MM-YYYY'));
                });
            }

            $('input[name="dateofInspection"]').focus(function() {
                let dateofInspection = $(this).val();

                if (dateofInspection == '') {
                    let inspectionLetterDate = $('input[name="inspectionLetterDate"]').val();

                    if (inspectionLetterDate == '') {
                        $('#material-alert').find('.toast-body').text('Select Inspection Letter Date');
                        $('#material-alert').toast('show');
                        return false;
                    } else {
                        /*let inspectionAgency = $('select[name="inspectionAgency"] :selected').text();
                        console.log('inspectionAgency: '+ inspectionAgency);

                        if (inspectionAgency == 'Select Agency') {
                            $('#material-alert').find('.toast-body').text('Select Inspection Agency');
                            $('#material-alert').toast('show');
                            return false;
                        } else {
                            setDateofInspection(inspectionLetterDate);   
                        }*/

                        setDateofInspection(inspectionLetterDate);
                    }
                }
            });

            function setDateofInspection(inspectionLetterDate) {
                $('input[name="dateofInspection"]').daterangepicker({
                   singleDatePicker: true,
                   showDropdowns: true,
                   autoUpdateInput: false,
                   minDate: getModifiedDate(inspectionLetterDate),
                   // maxDate: new Date(), 
                   opens: 'left',
                   parentEl: '#material-details-modal .modal-body',
                   locale: {
                      format: 'DD-MM-YYYY'
                   }
                });

                $('input[name="dateofInspection"]').on('apply.daterangepicker', function(ev, picker) {
                   $(this).val(picker.startDate.format('DD-MM-YYYY'));
                });
            }

            $('input[name="diMaterialDate"]').focus(function() {
                let diMaterialDate = $(this).val();

                if (diMaterialDate == '') {
                    let inspectionLetterDate = $('input[name="inspectionLetterDate"]').val();

                    if (inspectionLetterDate == '') {
                       $('#material-alert').find('.toast-body').text('Select Inspection Letter Date');
                       $('#material-alert').toast('show');
                       return false;
                    } else {
                       let diMaterialNo = $('input[name="diMaterialNo"]').val();

                        if (diMaterialNo == '') {
                            $('#material-alert').find('.toast-body').text('Enter Di Material No');
                            $('#material-alert').toast('show');
                            return false;
                        } else {
                          setDiMaterialDate(inspectionLetterDate);   
                        }
                    }
                }
            });

            function setDiMaterialDate(inspectionLetterDate) {
                $('input[name="diMaterialDate"]').daterangepicker({
                   singleDatePicker: true,
                   showDropdowns: true,
                   autoUpdateInput: false,
                   minDate: getModifiedDate(inspectionLetterDate),
                   // maxDate: new Date(), 
                   opens: 'left',
                   parentEl: '#material-details-modal .modal-body',
                   locale: {
                      format: 'DD-MM-YYYY'
                   }                     
                });

                $('input[name="diMaterialDate"]').on('apply.daterangepicker', function(ev, picker) {
                   $(this).val(picker.startDate.format('DD-MM-YYYY'));                  
                });
            }

            $('input[name="diQuantity"]').focus(function() {
                let diMaterialNo = $('input[name="diMaterialNo"]').val();
                let diMaterialDate = $('input[name="diMaterialDate"]').val();

                if (diMaterialNo == '') {
                   $('#material-alert').find('.toast-body').text('Enter Di No');
                   $('#material-alert').toast('show');
                   return false;
                }

                if (diMaterialDate == '') {
                   $('#material-alert').find('.toast-body').text('Enter Di Date');
                   $('#material-alert').toast('show');
                   return false;
                }
            });

            $('input[name="diRemark"]').focus(function() {
                let diMaterialNo = $('input[name="diMaterialNo"]').val();
                let diMaterialDate = $('input[name="diMaterialDate"]').val();
                let diQuantity = $('input[name="diQuantity"]').val();

                if (diMaterialNo == '') {
                   $('#material-alert').find('.toast-body').text('Enter Di No');
                   $('#material-alert').toast('show');
                   return false;
                }

                if (diMaterialDate == '') {
                   $('#material-alert').find('.toast-body').text('Enter Di Date');
                   $('#material-alert').toast('show');
                   return false;
                }

                if (diQuantity == '') {
                   $('#material-alert').find('.toast-body').text('Enter Di Quantity');
                   $('#material-alert').toast('show');
                   return false;
                }
            });

            $('input[name="mrcGeneratedDate"]').focus(function() {
                console.log('inside mrcGeneratedDate block');
                let random_sampling_tr = $('#new-edit-material-sampling-details > tbody').find('tr').eq(0);
                
                let accepted_report_date = $(random_sampling_tr).find('td').eq(8).text();

                if (accepted_report_date != '') {
                   setMrcGeneratedDate(accepted_report_date);
                }
            });

            function setMrcGeneratedDate(accepted_report_date) {
                $('input[name="mrcGeneratedDate"]').daterangepicker({
                   singleDatePicker: true,
                   showDropdowns: true,
                   drops: "up",
                   autoUpdateInput: false,
                   minDate: getModifiedDate(accepted_report_date),
                   maxDate: new Date(), 
                   parentEl: '#material-details-modal .modal-body',
                   locale: {
                      format: 'DD-MM-YYYY'
                   }
                });

                $('input[name="mrcGeneratedDate"]').on('apply.daterangepicker', function(ev, picker) {
                   $(this).val(picker.startDate.format('DD-MM-YYYY'));                  
                });   
            }            

            function findtr() {
                let tr = $('tr[data-status="editing"]');
                actionsModeNormal(tr);

                resetModal();
            }

            function resetModal() {
                $('#saveMaterialDetails')[0].reset();
            }

            function actionsModeNormal(button) {
                $(button).find('#bAcep').hide();
                $(button).find('#bCanc').hide();
                $(button).find('#bEdit').show();
                $(button).find('#bDel').show();
                
                $(button).attr('data-status', ''); // remove editing status
            }

            function actionsModeEdit(button) {
                $(button).parent().find('#bAcep').show();
                $(button).parent().find('#bCanc').show();
                $(button).parent().find('#bEdit').hide();
                $(button).parent().find('#bDel').hide();
                let $currentRow = $(button).parents('tr'); // get the row
                $currentRow.attr('data-status', 'editing'); // indicate the editing status
            }

            //Saving material details
            $('#saveMaterialDetails').on('submit', function(event) {
                let offer_letter_qty = $('input[name="offerLetterQuantity"]').val();            

                if (offer_letter_qty === '') {
                   $('#material-alert').find('.toast-body').text('Enter Offer Letter Quantity');
                   $('#material-alert').toast('show');

                   event.preventDefault();
                } else if (form_change == false) {
                   $('#material-alert').find('.toast-body').text('No changes occurred on the form to be submitted');
                   $('#material-alert').toast('show');

                   event.preventDefault();
                } else {
                    let tr = $('tr[data-status="editing"]');               
                    let tds = $(tr).find('td'); //check if required
                    let modal = $('#material-details-modal');                    

                    //Get form data
                    let form = $('#saveMaterialDetails')[0];
                    let formData = new FormData(form);

                    //Pushing material details from modal in an object
                    let materialData = {};
                    var key;

                    let material_status_detail_id = $(tr).attr('data-ms-detail-id');
                    key = 'material_status_detail_id';
                    materialData[key] = material_status_detail_id;

                    let material_id = $(modal).find('select[name="materials"]').val();
                    key = 'material_id';
                    materialData[key] = material_id;

                    let contract_material_id = $('input[name="contract_material_id"]').val();
                    key = 'contract_material_id';
                    materialData[key] = material_id;

                    let material_name = $(modal).find('select[name="materials"] option:selected').text();
                    key = 'material_name';
                    materialData[key] = material_name;

                    let offerLetterQuantity = $(modal).find('input[name="offerLetterQuantity"]').val();
                    key = 'offerLetterQuantity';
                    materialData[key] = offerLetterQuantity;

                    let dateOfReadiness = $(modal).find('input[name="dateOfReadiness"]').val();
                    key = 'dateOfReadiness';
                    materialData[key] = dateOfReadiness;

                    /*let pdiLetterNo = $(modal).find('input[name="pdiLetterNo"]').val();
                    key = 'pdiLetterNo';
                    materialData[key] = pdiLetterNo;*/

                    /*let pdiLetterDate = $(modal).find('input[name="pdiLetterDate"]').val();
                    key = 'pdiLetterDate';
                    materialData[key] = pdiLetterDate;*/

                    let inspectionLetterNo = $(modal).find('input[name="inspectionLetterNo"]').val();
                    key = 'inspectionLetterNo';
                    materialData[key] = inspectionLetterNo;

                    let inspectionLetterDate = $(modal).find('input[name="inspectionLetterDate"]').val();
                    key = 'inspectionLetterDate';
                    materialData[key] = inspectionLetterDate;

                    /*let inspectionAgency = $(modal).find('select[name="inspectionAgency"]').val();
                    key = 'inspectionAgency';
                    materialData[key] = inspectionAgency;*/

                    let dateofInspection = $(modal).find('input[name="dateofInspection"]').val();
                    key = 'dateofInspection';
                    materialData[key] = dateofInspection;

                    let materialSerialNos = $(modal).find('input[name="materialSerialNos"]').val();
                    key = 'materialSerialNos';
                    materialData[key] = materialSerialNos;

                    let diMaterialNo = $(modal).find('input[name="diMaterialNo"]').val();
                    key = 'diMaterialNo';
                    materialData[key] = diMaterialNo;

                    let diMaterialDate = $(modal).find('input[name="diMaterialDate"]').val();
                    key = 'diMaterialDate';
                    materialData[key] = diMaterialDate;

                    let diQuantity = $(modal).find('input[name="diQuantity"]').val();
                    key = 'diQuantity';
                    materialData[key] = diQuantity;

                    let diRemark = $(modal).find('input[name="diRemark"]').val();
                    key = 'diRemark';
                    materialData[key] = diRemark;

                    let mrcGeneratedNo = $(modal).find('input[name="mrcGeneratedNo"]').val();
                    key = 'mrcGeneratedNo';
                    materialData[key] = mrcGeneratedNo;

                    let mrcGeneratedDate = $(modal).find('input[name="mrcGeneratedDate"]').val();
                    key = 'mrcGeneratedDate';
                    materialData[key] = mrcGeneratedDate;

                    var files = $('#material_file').prop('files');
                    key = 'material_files'
                    materialData[key] = files;

                    //Getting data from Material Received Details
                    let material_received_table = $('#new-edit-material-received-details');
                    let mr_table_rows = $(material_received_table).find('tbody tr');

                    let materialReceivedData = {};

                    $.each(mr_table_rows, function(index, row) {
                        let mr_tds = $(row).find('td');

                        materialReceivedData[index] = {};
                        $.each(mr_tds, function(i, td) {

                        switch (i) {
                            case 0:
                                return;
                            case 1:
                                materialReceivedData[index]['circle'] = $(td).text();
                            case 2:
                                materialReceivedData[index]['received_qty'] = $(td).text();
                            case 3:
                                materialReceivedData[index]['serial_no'] = $(td).text();
                            case 4:
                                materialReceivedData[index]['received_date'] = $(td).text();
                        }
                        });
                    });

                    formData.append('materialReceivedData', JSON.stringify(materialReceivedData));

                    //Getting data from Random Sampling Details
                    let random_sampling_table = $('#new-edit-material-sampling-details');
                    let rs_table_rows = $(random_sampling_table).find('tbody tr');

                    let randomSamplingData = {};

                    $.each(rs_table_rows, function(index, row) {
                        let rs_tds = $(row).find('td');
                        // console.log(rs_tds); return false;
                        randomSamplingData[index] = {};
                        $.each(rs_tds, function(i,td) {

                            switch (i) {
                                case 0:
                                    return;
                                case 1:
                                    randomSamplingData[index]['circle'] = $(td).text();
                                case 2:
                                    randomSamplingData[index]['sampling_qty'] = $(td).text();
                                case 3:
                                    randomSamplingData[index]['sampling_serial_no'] = $(td).text();
                                case 4:
                                    randomSamplingData[index]['sampling_date'] = $(td).text();
                                case 5:
                                    randomSamplingData[index]['sampling_letter_no'] = $(td).text();
                                case 6:
                                    randomSamplingData[index]['sampling_lab'] = $(td).text();
                                case 7:
                                    randomSamplingData[index]['accepted_report_no'] = $(td).text();
                                case 8:
                                    randomSamplingData[index]['accepted_report_date'] = $(td).text();
                                case 9:
                                    randomSamplingData[index]['accepted_qty'] = $(td).text();
                            }

                        });
                    });

                    formData.append('randomSamplingData', JSON.stringify(randomSamplingData));
                    // console.log(formData); return false;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('update-material-details') ?>',
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // console.log(response); return false;
                            if (response.material_details_id) {

                            //Displaying Offer Letter Quantity                        
                            $(tr).find('td.offer-letter-qty').text(parseFloat(offerLetterQuantity).toFixed(2));

                            //Displaying Date of Readiness
                            $(tr).find('td.date-of-readiness').text(materialData['dateOfReadiness']);

                            //Displaying PDI Letter No.
                            // $(tr).find('td.pdi-letter-no').text(materialData['pdiLetterNo']);

                            //Displaying PDI Letter Date.
                            // $(tr).find('td.pdi-letter-date').text(materialData['pdiLetterDate']);

                            //Displaying Inspection Letter No.
                            $(tr).find('td.inspection-letter-no').text(materialData['inspectionLetterNo']);

                            //Displaying Inspection Letter Date
                            $(tr).find('td.inspection-letter-date').text(materialData['inspectionLetterDate']);

                            //Displaying DI Material No.
                            $(tr).find('td.di-material-no').text(materialData['diMaterialNo']);

                            //Displaying DI Material Date
                            $(tr).find('td.di-material-date').text(materialData['diMaterialDate']);

                            //Displaying DI Quantity
                            $(tr).find('td.di-qty').text(materialData['diQuantity']);
                            
                            //Displaying Material Received Date
                            $(tr).find('td.material-received-date').text(materialReceivedData[0].received_date);
                            
                            //Displaying Material Received Quantity
                            $(tr).find('td.material-received-qty').text(materialReceivedData[0].received_qty);

                            //Displaying Sample Size
                            $(tr).find('td.sample-size').text(randomSamplingData[0].sampling_qty);

                            //Displaying Sampling Date
                            $(tr).find('td.sampling-date').text(randomSamplingData[0].sampling_date);

                            //Displaying Date of Acceptance
                            $(tr).find('td.date-of-acceptance').text(randomSamplingData[0].accepted_report_date);

                            //Displaying Acceptance Quantity
                            $(tr).find('td.acceptance-quantity').text(randomSamplingData[0].accepted_qty);

                            //Displaying MRC Generated No
                            $(tr).find('td.mrc-generated-no').text(materialData['mrcGeneratedNo']);

                            //Displaying File Upload
                            $(tr).find('.file-upload').empty();
                            let file_html = '';
                            $.each(response.file_data, function(index, value) {
                                var file_path = '<?php echo base_url(); ?>'+ value;

                                file_html += '<a href="javascript:void(0)" class="thumbnail m-0 border-0 d-inline-block">';
                                file_html += '<img src="'+file_path+'" alt="thumb1" class="thumbimg p-1 rounded-1" style="width:50px; border: 1px solid #ddd;">';
                                file_html += '</a>';
                            });
                            $(tr).find('.file-upload').append(file_html);

                            //Closing the material details modal
                            $(modal).modal('hide');

                            //Clearing data of material details modal on close
                            $(modal).on('hidden.bs.modal', function () {
                                $(this).removeData('bs.modal');
                                $('#material-quantity').attr('hidden', true);
                                actionsModeNormal(tr);

                            });
                            $(modal).find('form').trigger('reset');
                        }

                        // event.preventDefault();
                      },
                      error: function(xhr, status, error) {
                         console.log(xhr.responseText);
                      }
                   });

                   event.preventDefault();
                }            
             });

            function getModifiedDate(date) {
                var parts = date.split("-")
                return new Date(parts[2], parts[1] - 1, parts[0])
            }
        </script>

    </body>
</html>