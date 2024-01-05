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
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/brand/favicon.ico');?>">

        <!-- TITLE -->
        <title>MPPKVVCL - Contract Management</title>

        <!-- BOOTSTRAP CSS -->
        <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">        

		<style>
			input[type='date'] {
    			position: relative;
    			width: 150px; height: 33px;
    			color: white;
			}

			input[type='date']:before {
			    position: absolute;
			    top: 3px; left: 3px;
			    content: attr(data-date);
			    display: inline-block;
			    color: black;
			}

			input[type='date']::-webkit-datetime-edit, input[type='date']::-webkit-inner-spin-button, input[type='date']::-webkit-clear-button {
			    display: none;
			}

			input[type='date']::-webkit-calendar-picker-indicator {
			    position: absolute;
			    top: 3px;
			    right: 0;
			    color: black;
			    opacity: 1;
			}
		</style>		
		
        <!-- STYLE CSS -->
        <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
  		<link href="<?php echo base_url('assets/css/toast.css');?>" rel="stylesheet">
        <!-- PLUGINS CSS -->
        <link href="<?php echo base_url('assets/css/plugins.css');?>" rel="stylesheet">

        <!--- FONT-ICONS CSS -->
        <link href="<?php echo base_url('assets/css/icons.css');?>" rel="stylesheet">

        <!-- INTERNAL Switcher css -->
        <link href="<?php echo base_url('assets/switcher/css/switcher.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/switcher/demo.css" rel="stylesheet');?>" rel="stylesheet">

        <!-- DATERANGEPICKER CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css');?>">
    </head>
		
	<body class="app sidebar-mini ltr light-mode">
	<div id="toasts"></div>
		<!-- GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="<?php echo base_url('assets/images/loader.svg');?>" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOBAL-LOADER -->

        <!-- PAGE -->
        <div class="page">
        	<!-- Page Main -->
        	<div class="page-main">

        		 <?php $this->load->view('include/header');?>
                 <?php $this->load->view('include/side-bar');?>



                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                	<div class="side-app">
                		
                		<!-- Container -->
                		<div class="main-container container-fluid">
                		
                			<!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title">Add Contract</h1>
                            </div>
                            <!-- Page-Header Ends -->

                           

		                   

	                        <!-- Row -->
	                        <div class="row">
	                        	<div class="col-lg-12 col-md-12">
	                        		<div class="card">
	                        			<!-- <div class="card-header">
	                        				<h3 class="card-title">Add Contract</h3>
	                        			</div> -->
	                        			<?php   if($this->session->flashdata('error')) {   ?>
	                        			<div class="alert alert-primary" role="alert"> 
	                        				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button> 	                        				
										<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>  
										

	                        				</div>
										<?php } ?>

										<?php   if($this->session->flashdata('success')) {   ?>
	                        			<div class="alert alert-primary" role="alert"> 
	                        				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button> 	                        				
										<p style="color:green"><?php  echo $this->session->flashdata('success');?></p>  
										

	                        				</div>
										<?php } ?>
	                        			
                        				<!-- <form class="needs-validation" novalidate> -->
                        				<form id="addContract" class="needs-validation" novalidate action="<?php echo base_url('add-contract-management')?>" method="POST">
	                        				<div class="card-body mt-3">
	                        					<!-- Row1 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-6 mb-3">
	                        							<label class="form-label" for="nameOfContractor">Contractor (TKC)
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" id="nameOfContractor" name="nameOfContractor" required onblur="charlimit('nameOfContractor', 200)">
	                        							<div class="list-group list-view-contractor" id="list-view"></div>
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="tenderAwardNo">Contract No.
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" id="tenderAwardNo" required name="tenderAwardNo" onblur="charlimit('tenderAwardNo', 20)">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="tenderAwardDate">Contract Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                                                        <div class="input-group-text dates">
	                                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                                                        </div>
	                                                        <input type="text" class="form-control" name="tenderAwardDate" id="tenderAwardDate"/>
	                                                    </div>
	                        						</div>
	                        					</div>
	                        					<!-- Row2 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="packageNo">Lot No.
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="packageNo" id="packageNo" required onblur="charlimit('packageNo', 20)">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="typeOfWork">Type Of Work
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<select class="form-control select2" id="typeOfWork" name="typeOfWork" required onchange="showboq(this.value);">
	                        								<option value="select" selected disabled>Select Type Of Work</option>
	                        								<!--option value="1">Capacitor Bank</option>
	                        								<option value="2">33 KV / 11 KV New Substation</option>
	                        								<option value="3">11 KV Feeder Separation</option>
	                        								<option value="4">33 KV Interconnection Line</option>
	                        								<option value="5">11 KV Interconnection Line</option>
	                        								<option value="6">LT Line / LT Cabling</option-->
															<?php foreach($worktypes as $worktype) { ?>
															<option value="<?php echo $worktype->typeofwork_id;?>"><?php echo $worktype->name;?></option>
															<?php } ?>
	                        							</select>
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="effectiveDate">Effective Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
	                        								<input class="form-control" type="text" id="effectiveDate" name="effectiveDate" required onchange="checkDate('effectiveDate', this.value);">
	                        							</div>
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="completionDate">Completion Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
	                        								<input class="form-control" type="text" id="completionDate" name="completionDate" required onchange="checkDate('completionDate', this.value);">
	                        							</div>
	                        						</div>
	                        					</div>
	                        					<!-- Row3 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="eTenderNo">E-Tender No.
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" id="eTenderNo" name="eTenderNo" required onblur="charlimit('eTenderNo', 20)">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="bidOpeningDate">Bid Opening Date
	                        								<span class="text-red">*</span>						
	                        							</label>
                        								<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
                        									<input class="form-control" type="text" name="bidOpeningDate" id="bidOpeningDate" required>
	                        							</div>
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="priceBidOpeningDate">Price Bid Opening Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
	                        								<input class="form-control" type="text" name="priceBidOpeningDate" id="priceBidOpeningDate" required>
	                        							</div>
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="systemRefNo">System Ref No
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								
	                        								<input class="form-control" type="text" name="systemRefNo" id="systemRefNo" required onblur="charlimit('systemRefNo', 20)">
	                        							</div>
	                        						</div>
	                        					</div>
	                        					<!-- Row4 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="estimatedCostWithoutGST">Estimated Cost <span class="mb-0 text-muted fs-11">(Without GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="estimatedCostWithoutGST" id="estimatedCostWithoutGST" required onblur="charlimit('estimatedCostWithoutGST', 12);" onkeyup="intOnly('estimatedCostWithoutGST',this.value);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="estimatedCostWithGST">Estimated Cost <span class="mb-0 text-muted fs-11">(With GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="estimatedCostWithGST" id="estimatedCostWithGST" required onblur="charlimit('estimatedCostWithGST', 12);" onkeyup="intOnly('estimatedCostWithGST',this.value);" >
	                        						</div>
	                        						
	                        						
	                        					</div>
	                        					<!-- Row5 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="supplyOfGoods">Supply of Goods <span class="mb-0 text-muted fs-11">(ExW Price)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="supplyOfGoods" id="supplyOfGoods" required onblur="addcontractprice()" onkeyup="intOnly('supplyOfGoods',this.value);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="installationServices">Installation and Other Services
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="installationServices" id="installationServices" required onblur="addcontractprice()" onkeyup="intOnly('installationServices',this.value);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="quotedPriceWithoutGST">Contract Price<span class="mb-0 text-muted fs-11">(Without GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="quotedPriceWithoutGST" readonly id="quotedPriceWithoutGST" required  onblur="charlimit('quotedPriceWithoutGST', 12);" onkeyup="intOnly('quotedPriceWithoutGST',this.value);">
	                        						</div>

	                        						

	                        					</div>

	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="gst">GST
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="gst" id="gst" required onblur="addcontractpricewithgst()" onkeyup="intOnly('gst',this.value);" onfocusout="charlimit('gst', 12);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="quotedPriceWithGST">Contract  Price <span class="mb-0 text-muted fs-11">(With GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="quotedPriceWithGST" readonly id="quotedPriceWithGST" required onblur="charlimit('quotedPriceWithGST', 12);" onkeyup="intOnly('quotedPriceWithGST',this.value);">
	                        						</div>

	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="quotedPriceWithoutGST">Email
	                        								<!-- <span class="text-red">*</span> -->
	                        							</label>
	                        							<input class="form-control" type="text" name="contractEmail"  id="contractEmail">
	                        						</div>


	                        					</div>


	                        					<!-- Row6 -->
	                        					<div class="form-row">
	                        						<!-- Apply Validation below -->
	                        						<div class="col-xl-4">
	                        							<label class="form-label" for="quantity">Quantity (No. of feeders / Sub Stations)
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="quantity" id="quantity" required onblur="charlimit('quantity', 7);" onkeyup="intOnly('quantity',this.value);">	
	                        						</div>
	                        						
	                        					</div>
	                        					<!-- Row7 -->
	                        					<div class="form-row mt-3">
	                        						<div class="col-xl-6">
	                        							<label class="form-label">Stage Details <span class="text-red">*</span></label>
	                        						</div>
	                        					</div>
	                        					<!-- Row8 -->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">
													<input type="hidden" name="milestonehiddentable" id="milestonehiddentable" />
	                        							<div class="table-responsive" id="milestone_table">
	                        								<table class="table table-bordered border text-nowrap mb-0" id="new-edit-milestone">
	                        									<thead>
	                        										<tr>
	                        											<th>Stages</th>
	                        											<th>Date</th>
	                        											<th>Quantity</th>
	                        											<th>Amount</th>
	                        										</tr>
	                        									</thead>
	                        									<tbody>
	                        										<tr>
	                        											<td id="td_dynamicstages0"></td>
	                        											<td id="td_dynamicdatepickerstage0"></td>
	                        											<td id="td_dynamicqtystage0"></td>
	                        											<td id="td_dynamicamountstage0"></td>
	                        										</tr>
	                        										
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-milestone" class="btn btn-primary mt-4" type="button"> Add New Row</button>
	                        						</div>
	                        					</div>
	                        					<!-- Row9 -->
	                        					<div class="form-row mt-3">
	                        						<div class="col-xl-6">
	                        							<label class="form-label">Region and Circle wise breakup</label>	
	                        						</div>
	                        					</div>
	                        					<!-- Row10 -->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">
	                        							<input type="hidden" name="regionhiddentable" id="regionhiddentable" />
	                        							<div class="table-responsive" id="region_table">
	                        								<table class="table table-bordered border text-nowrap mb-0" id="new-edit-region">
	                        									<thead>
	                        										<tr>
	                        											<th>Region</th>
	                        											<th>Circle</th>
	                        											<th>Division</th>
	                        											<th>Location/Referance Name</th>
	                        											<th>Feeder Name</th>
	                        											<th>Feeder ID</th>
	                        											<th>Project Id</th>
	                        											<th>GeoCode(Lat,Long)</th>
	                        											<th>Quantity</th>
	                        											<th>BOQ</th>
	                        										</tr>
	                        									</thead>
	                        									<tbody>
	                        										<tr>
	                        											<td id="td_dynamicregion0"></td>
	                        											<td id="td_dynamiccircle0"></td>
	                        											<td id="td_dynamicdivision0"></td>
	                        											<td id="td_dynamiclocationregion0"></td>
	                        											<td id="td_dynamicfeedernameregion0"></td>
	                        											<td id="td_dynamicfeederidregion0"></td>
	                        											<td id="td_dynamicprojectidregion0"></td>
	                        											<td id="td_dynamicgeocoderegion0"></td>
	                        											<td id="td_dynamicqtyregion0"></td>
	                        											<td>
	                        												
	                        											</td>
	                        											<!-- <td name="bstable-actions">
	                        												<div class="btn-list">
	                        													<button id="bEdit" type="button" class="btn btn-sm btn-primary">
										                                            <span class="fe fe-edit"> </span>
										                                        </button>
										                                        <button id="bDel" type="button" class="btn btn-sm btn-danger">
										                                            <span class="fe fe-trash-2"> </span>
										                                        </button>
	                        												</div>
	                        											</td> -->
	                        										</tr>
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-region" class="btn btn-primary mt-4" type="button"> Add New Row</button>
	                        						</div>
	                        					</div>
	                        					<!-- Row11 -->
	                        					<div class="form-row mt-3">
	                        						<div class="col-xl-6">
	                        							<label class="form-label">Material Details</label>	
	                        						</div>
	                        					</div>
	                        					<!-- Row12 -->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">
	                        							<input type="hidden" name="installationhiddentable" id="installationhiddentable" />
	                        							<div class="table-responsive" id="installation_table">
	                        								<table class="table table-bordered border mb-0" id="new-edit-installation">
	                        									<thead>
	                        										<tr>
	                        											<th>Item Code</th>
	                        											<th>Equipment/Material Name</th>
	                        											<th>Unit</th>
	                        											<th>Total Quantity</th>
	                        										</tr>
	                        									</thead>
	                        									<tbody>
	                        										<tr>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        										</tr>
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-installation" class="btn btn-primary mt-4" type="button"> Add New Row</button>
	                        						</div>
	                        					</div>
	                        					<!-- Row13 -->
	                        					<div class="form-row mt-3">
	                        						<div class="col-xl-6">
	                        							<label class="form-label">Mobilisation Details</label>
	                        						</div>
	                        					</div>
	                        					<!-- Row14 -->
	                        					<!--div class="form-row">
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="mobilisationAdvance">Mobilisation Advance</label>
	                        							<input class="form-control" type="text" name="mobilisationAdvance" id="mobilisationAdvance" >
	                        						</div>
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="invoiceNo">Invoice No.</label>
	                        							<input class="form-control" type="text" name="invoiceNo" id="invoiceNo" >
	                        						</div>
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="invoiceDate">Invoice Date</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
                        									<input class="form-control" type="text" name="invoiceDate" id="invoiceDate" >
	                        							</div>
	                        						</div>
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="mobilisationAdvAdjusted">Mobilisation Advance Adjusted</label>
	                        							<input class="form-control" type="text" name="mobilisationAdvAdjusted" id="mobilisationAdvAdjusted" >
	                        						</div>
	                        					</div-->
	                        					<!-- Row15 -->

	                        					<div class="form-row">
	                        						<div class="col-lg-12">
	                        							<div class="table-responsive">
	                        								<table class="table table-bordered border text-nowrap mb-0" id="new-edit-mobilisation-details">
	                        									<thead>
	                        										<tr>
	                        											<!-- <th>Sr.No</th> -->
	                        											<th>Type</th>
	                        											<th>Invoice No.</th>
	                        											<th>Invoice Date</th>
	                        											<th>MOBILISATION ADVANCE AMOUNT PAID</th>
	                        											<th>Date of Payment</th>
	                        											<th>Advance Adjusted</th>
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
	                        										</tr>
	                        										
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-mobilisation" class="btn btn-primary mt-4" type="button"> Add New Row</button>
	                        						</div>
	                        					</div>

	                        					<div class="form-row">
	                        						<div class="col-xl-6 mt-3">
	                        							<label class="form-label">Bank Guarantee Details (BG)</label>
	                        						</div>
	                        					</div>
	                        					<!-- Row16 -->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">
	                        							<input type="hidden" name="bankhiddentable" id="bankhiddentable" />
	                        							<div class="table-responsive" id="bank_table">
	                        								
	                        								<table class="table table-bordered border text-nowrap mb-0" id="new-edit-bank-details">
	                        									<thead>
	                        										<tr>
	                        											<!-- <th>Sr.No</th> -->
	                        											<th>Type</th>
	                        											<th>BG No.</th>
	                        											<th>BG Date</th>
	                        											<th>BG Amount</th>
	                        											<th>Bank</th>
	                        											<th>BG Valid till</th>
	                        										</tr>
	                        									</thead>
	                        									<tbody>
	                        										<tr>
	                        											<!-- <td></td> -->
	                        											<td id="td_dynamictype0"></td>
	                        											<td id="td_dynamicbgno0"></td>
	                        											<td id="td_dynamicbgdate0"></td>
	                        											<td id="td_dynamicbgamount0"></td>
	                        											<td id="td_dynamicbank0"></td>
	                        											<td id="td_dynamicvalidtill0"></td>
	                        										</tr>
	                        										
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-bank-details" class="btn btn-primary mt-4" type="button"> Add New Row</button>
	                        						</div>
	                        					</div>
	                        					<!-- Row17 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-6 mt-5 mb-3">
	                        							<button type="button" class="btn btn-success" onclick="addContract()">Submit</button>
                                            			<!-- <button type="reset" class="btn btn-primary" onclick="resetform()">Reset</button> -->
                                            			<a href="<?php echo base_url();?>contract-management" class="btn btn-primary">Back</a>
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



                  <!-- BOQ Modal Ends -->

            <div class="modal fade" id="boq-modal" tabindex="-1" aria-hidden="true" style="display: none;">
            	<div class="modal-dialog modal-lg " role="document">
            		<div class="modal-content">
            			<form id="boqform" method="POST">
            			<div class="modal-header">
            				<h5 class="modal-title" id="boq-modal-text"></h5>
            				<!-- <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">×</span>
            				</button> -->
            			</div>
            			<div class="modal-body">
            				<!-- <p>Modal body text goes here.</p> -->
            				<input type="hidden" name="rowid" id="rowid">
            					<div class="panel panel-primary" id="boqtoadd" >
            						
            					</div>
            				
            			</div>
            			<div class="modal-footer">
            				<button class="btn ripple btn-success" type="button" onclick="saveboq()">Save changes</button>
            				<button class="btn ripple btn-danger" data-bs-dismiss="modal" type="button">Close</button>
            			</div>
            			</form>
            		</div>
            	</div>
            </div>

        		
        	</div>
        	<!-- Page Main Ends -->

        	<!-- Footer -->
                 <?php $this->load->view('include/side-bar');?>
            <!-- Footer Ends -->
        </div>

        <!-- BACK-TO-TOP -->
        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
		
		<!-- BaseUrl -->	
			
			<script>
			var baseUrl = "<?php echo base_url(); ?>";
			
			</script>
		
		<!-- BaseUrl -->	

        <!-- JQUERY JS -->
		
		
        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
		<script>
		$("input").on("change", function() {
			//alert("ssas");
   /*  this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    ) */
	
	/*  this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( 'DD-MM-YYYY' )
    )
	 */
	
}).trigger("change");
		</script>
        <!-- BOOTSTRAP JS -->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
		
        <!-- INPUT MASK JS-->
        <script src="<?php echo base_url('assets/plugins/input-mask/jquery.mask.min.js');?>"></script>

        <!-- TypeHead js -->
        <script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js');?>"></script>
        <script src="<?php echo base_url('assets/js/typehead.js');?>"></script>

        <!-- SELECT2 JS -->
        <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>

        <!-- FORMVALIDATION JS -->
        <script src="<?php echo base_url('assets/js/form-validation.js');?>"></script>

        <!-- Perfect SCROLLBAR JS-->
        <script src="<?php echo base_url('assets/plugins/p-scroll/perfect-scrollbar.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll-1.js');?>"></script>

        <!-- SIDE-MENU JS -->
        <script src="<?php echo base_url('assets/plugins/sidemenu/sidemenu.js');?>"></script>

        <!-- SIDEBAR JS -->
        <script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js');?>"></script>

        <!-- Color Theme js -->
        <script src="<?php echo base_url('assets/js/themeColors.js');?>"></script>

        <!-- Sticky js -->
        <script src="<?php echo base_url('assets/js/sticky.js');?>"></script>

        <!-- CUSTOM JS -->
        <script src="<?php echo base_url('assets/js/custom.js');?>"></script>

        <!-- Custom-switcher -->
        <script src="<?php echo base_url('assets/js/custom-swicher.js');?>"></script>

        <!-- Switcher js -->
        <script src="<?php echo base_url('assets/switcher/js/switcher.js');?>"></script>

        		<script src="<?php echo base_url('assets/plugins/toast/toaster.js');?>"></script>

		
		 <!-- EDIT TABLE JS -->
		<script src="<?php echo base_url('assets/plugins/edit-table/contract/stage.js');?>"></script>

        <script src="<?php echo base_url('assets/plugins/edit-table/contract/region.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/edit-table/contract/installation.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/edit-table/contract/bank.js');?>"></script>
				<script src="<?php echo base_url('assets/plugins/edit-table/contract/mobilisation.js');?>"></script>

        <script src="<?php echo base_url('assets/plugins/edit-table/contract/contract-edit-table.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/contract/contract-session.js');?>"></script>

         <!-- DATA TABLE JS-->
        <!-- <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.html5.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/table-data.js');?>"></script> -->

       
        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js');?>"></script>

        <!-- DATERANGE PICKER JS -->
        <!--script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">
        	/*$('input[name="tenderAwardDate"]').daterangepicker({
                //autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });*/

            $('input[name="effectiveDate"], input[name="completionDate"], input[name="bidOpeningDate"], input[name="priceBidOpeningDate"], input[name="invoiceDate"], input[name="tenderAwardDate"]').daterangepicker({
    			singleDatePicker: true,
    			showDropdowns: true,
    			locale: {
                    format: 'DD-MM-YYYY'
                }
    		});
    		  /*$('input[name="dynamicdatepickerstage"]').daterangepicker({
    			singleDatePicker: true,
    			showDropdowns: true,
    			locale: {
                    format: 'DD-MM-YYYY'
                }
    		});*/
        	function resetform() {        		
        		document.getElementById("addContract").reset();

        		// Resetting TypeOfWork dropdown
        		$('#typeOfWork').select2({
        			placeholder: 'Select Type Of Work',
        			allowClear: true
        		});
        	}
        </script>


        <script type="text/javascript">
        	$(document).click(function() {
        	var mainArray = [];
        	var singleArray = {};
        	singleArray['milestones'] = [];
        	$("#bAcep_Milestone").click(function(){
        		
        	singleArray['milestones'].push({name:"Milestone1", date : "4545-54-54", qty:"1", amount:"333"});

        	mainArray.push(singleArray);

        		console.log(mainArray);

        	});

        	});


        	

        </script>
		
		

	</body>
</html>