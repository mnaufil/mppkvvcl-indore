<!DOCTYPE html>
<html>

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

			.table-responsive
			{
				max-height: 200px;
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
                                <h1 class="page-title">Edit Contract</h1>
                                <!-- <div>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="contract_management.php">Contract Management</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Edit Contract</li>
                                    </ol>
                                </div> -->
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Modal -->
	                        <div class="modal" id="myModal">
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                    <!-- Modal-Header -->
	                                    <div class="modal-header">
	                                        <h4 class="modal-title">Set Regions</h4>
	                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
	                                    </div>
	                                    <!-- Modal-Header Ends -->

	                                    <!-- Modal-Body -->
	                                    <div class="modal-body">
	                                        <label class="custom-control custom-checkbox">
	                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
	                                            <span class="custom-control-label">View</span>
	                                        </label>
	                                        <label class="custom-control custom-checkbox">
	                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
	                                            <span class="custom-control-label">Edit</span>
	                                        </label>
	                                        <label class="custom-control custom-checkbox">
	                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
	                                            <span class="custom-control-label">Delete</span>
	                                        </label>
	                                        <label class="custom-control custom-checkbox">
	                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
	                                            <span class="custom-control-label">Download</span>
	                                        </label>
	                                    </div>
	                                    <!-- Modal-Body Ends -->

	                                    <!-- Modal-Footer -->
	                                    <div class="modal-footer">
	                                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Update</button>
	                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
	                                    </div>
	                                    <!-- Modal-Footer Ends -->
	                                </div>
	                            </div>                            
	                        </div>
	                        <!-- Modal Ends -->

	                        <!-- Row -->
	                        <div class="row">
	                        	<div class="col-lg-12">
	                        		<div class="card">
	                        			<!-- <div class="card-header">
	                        				<h3 class="card-title">Edit Contract</h3>
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
	                        			<form id="addContract"  action="<?php echo base_url('update-contract-management')?>" method="POST">
	                        				<div class="card-body">
	                        					<!-- Row1 -->
	                        					<div class="form-row">
	                        						<input type="hidden" name="contractID"  id="contractID"value="<?php echo $contractdetails->contract_id;?>"/>
	                        						<div class="col-xl-6 mb-3">
	                        							<label class="form-label" for="nameOfContractor">Contractor (TKC)
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" id="nameOfContractor" name="nameOfContractor" required value="<?php echo $contractdetails->contractor_name;?>" onblur="charlimit('nameOfContractor', 200)">
	                        							<div class="list-group list-view-contractor" id="list-view"></div>
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="tenderAwardNo">Contract No.
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" id="tenderAwardNo" required name="tenderAwardNo" value="<?php echo $contractdetails->tender_award_no;?>" onblur="charlimit('tenderAwardNo', 20)">
	                        						</div>
													<input type="hidden" name="contractID" value="<?php echo $contractdetails->contract_id; ?>"/>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="tenderAwardDate">Contract Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                                                        <div class="input-group-text dates">
	                                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                                                        </div>
	                                                        <input type="text" class="form-control" id="tenderAwardDate" name="tenderAwardDate" value="<?php echo date('d-m-Y', strtotime($contractdetails->tender_award_date));?>" required/>
	                                                    </div>
	                        							<!-- <input type="text" name="tenderAwardDate" id="tenderAwardDate" class="form-control" required value="02.09.2022"> -->
	                        						</div>
	                        					</div>
	                        					<!-- Row2 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="packageNo">Lot No.
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="packageNo" id="packageNo" required value="<?php echo $contractdetails->package_no;?>" onblur="charlimit('packageNo', 20)">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="typeOfWork">Type Of Work
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<select class="form-control select2" id="typeOfWork" required name="typeOfWork" readonly  >
	                        								<option value="select" disabled>Select Type Of Work</option>
	                        								<?php foreach($worktypes as $worktype) { ?>
															<option value="<?php echo $worktype->typeofwork_id;?>" <?php if($contractdetails->typeofwork_id==$worktype->typeofwork_id) { ?> selected <?php } else {  ?> disabled <?php } ?>><?php echo $worktype->name;?></option>
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
	                        								<input class="form-control" type="text" id="effectiveDate" name="effectiveDate" value="<?php echo date('d-m-Y', strtotime($contractdetails->effective_date));?>" required onchange="checkDate('effectiveDate', this.value);">
	                        							</div>
	                        							<!-- <input class="form-control" type="text" id="effectiveDate" name="effectiveDate" required value="02/09/2022"> -->
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="completionDate">Completion Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
	                        								<input class="form-control" type="text" id="completionDate" name="completionDate" value="<?php echo date('d-m-Y', strtotime($contractdetails->completion_date));?>" required onchange="checkDate('completionDate', this.value);">
	                        							</div>
	                        							<!-- <input class="form-control" type="text" id="completionDate" name="completionDate" required value="01/09/2024"> -->
	                        						</div>
	                        					</div>
	                        					<!-- Row3 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="eTenderNo">E-Tender No.
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" id="eTenderNo" name="eTenderNo" required value="<?php echo $contractdetails->etender_no;?>" onblur="charlimit('eTenderNo', 20)">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="bidOpeningDate">Bid Opening Date
	                        								<span class="text-red">*</span>						
	                        							</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
                        									<input class="form-control" type="text" name="bidOpeningDate" id="bidOpeningDate" value="<?php echo date('d-m-Y', strtotime($contractdetails->bid_opening_date));?>" required>
	                        							</div>
                        								<!-- <input class="form-control" type="text" name="bidOpeningDate" id="bidOpeningDate" required value="05/08/2022"> -->
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="priceBidOpeningDate">Price Bid Opening Date
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
	                        								<input class="form-control" type="text" name="priceBidOpeningDate" id="priceBidOpeningDate" value="<?php echo date('d-m-Y', strtotime($contractdetails->price_bid_opening_date));?>" required>
	                        							</div>
	                        							<!-- <input class="form-control" type="text" name="priceBidOpeningDate" id="priceBidOpeningDate" required value="23/08/2022"> -->
	                        						</div>

	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="systemRefNo">System Ref No
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<div class="input-group">
	                        								
	                        								<input class="form-control" type="text" name="systemRefNo" id="systemRefNo" required value="<?php echo $contractdetails->system_ref_no;?>" onblur="charlimit('systemRefNo', 20)">
	                        							</div>
	                        						</div>


	                        					</div>
	                        					<!-- Row4 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="estimatedCostWithoutGST">Estimated Cost <span class="mb-0 text-muted fs-11">(Without GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="estimatedCostWithoutGST" id="estimatedCostWithoutGST" required value="<?php echo $contractdetails->estimated_cost_without_gst;?>" onblur="charlimit('estimatedCostWithoutGST', 12);" onkeyup="intOnly('estimatedCostWithoutGST',this.value);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="estimatedCostWithGST">Estimated Cost <span class="mb-0 text-muted fs-11">(With GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="estimatedCostWithGST" id="estimatedCostWithGST" required value="<?php echo $contractdetails->estimated_cost_with_gst;?>" onblur="charlimit('estimatedCostWithGST', 12);" onkeyup="intOnly('estimatedCostWithGST',this.value);">
	                        						</div>
	                        						
	                        						
	                        					</div>
	                        					<!-- Row5 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="supplyOfGoods">Supply of Goods <span class="mb-0 text-muted fs-11">(ExW Price)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="supplyOfGoods" id="supplyOfGoods" value="<?php echo $contractdetails->supply_of_goods;?>" required onblur="addcontractprice()" onkeyup="intOnly('supplyOfGoods',this.value);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="installationServices">Installation and Other Services
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="installationServices" id="installationServices" value="<?php echo $contractdetails->installation_other_services;?>" required onblur="addcontractprice()" onkeyup="intOnly('installationServices',this.value);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="quotedPriceWithoutGST">Contract  Price<span class="mb-0 text-muted fs-11">(Without GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="quotedPriceWithoutGST" id="quotedPriceWithoutGST" required value="<?php echo $contractdetails->quoted_price_without_gst;?>" readonly onblur="charlimit('quotedPriceWithoutGST', 12);" onkeyup="intOnly('quotedPriceWithoutGST',this.value);">
	                        						</div>
	                        					</div>

	                        					<div class="form-row">
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="gst">GST
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="number" name="gst" id="gst"  value="<?php echo $contractdetails->GST;?>" required onblur="addcontractpricewithgst()" onkeyup="intOnly('gst',this.value);" onfocusout="charlimit('gst', 12);">
	                        						</div>
	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="quotedPriceWithGST">Contract  Price <span class="mb-0 text-muted fs-11">(With GST)</span>
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="quotedPriceWithGST" id="quotedPriceWithGST" required value="<?php echo $contractdetails->quoted_price_with_gst;?>" readonly onblur="charlimit('quotedPriceWithGST', 12);" onkeyup="intOnly('quotedPriceWithGST',this.value);">
	                        						</div>


	                        						<div class="col-xl-3 mb-3">
	                        							<label class="form-label" for="quotedPriceWithoutGST">Email
	                        								<!-- <span class="text-red">*</span> -->
	                        							</label>
	                        							<input class="form-control" type="text" name="contractEmail"  id="contractEmail" value="<?php echo $contractdetails->contractor_email;?>">
	                        						</div>



	                        					</div>

	                        					<!-- Row6 -->
	                        					<div class="form-row">
	                        						<!-- Apply Validation below -->
	                        						<div class="col-xl-4">
	                        							<label class="form-label" for="quantity">Quantity (No. of feeders / Sub Stations)
	                        								<span class="text-red">*</span>
	                        							</label>
	                        							<input class="form-control" type="text" name="quantity" id="quantity" value="<?php echo $contractdetails->quantity;?>" required onblur="charlimit('quantity', 7);" onkeyup="intOnly('quantity',this.value);">	
	                        						</div>
	                        						
	                        					</div>
	                        					<!-- Row7 -->
	                        					<div class="form-row mt-3">
	                        						<div class="col-xl-6">
	                        							<label class="form-label">Stage Details</label>
	                        						</div>
	                        					</div>
	                        					<!-- Row8 -->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">
											<!-- <input type="hidden" name="milestonehiddentable" id="milestonehiddentable" />
 -->
	                        							<div class="table-responsive" id="milestone_table">
	                        								<table class="table table-bordered border text-nowrap mb-0" id="new-edit-milestone">
	                        									<thead>
	                        										<tr>
	                        											<th>Stage</th>
	                        											<th>Date</th>
	                        											<th>Quantity</th>
	                        											<th>Amount</th>
	                        										</tr>
	                        									</thead>
	                        									<tbody>
	                        										<?php if(!empty($contractmilestonesdetails)) { ?>	
																<?php foreach($contractmilestonesdetails as $milestone) { ?>
	                        										<tr>
	                        											<td id="td_dynamicstages<?php echo $milestone['rowId'];?>"><?php echo $milestone['stage_text'];?></td>
	                        											<td id="td_dynamicdatepickerstage<?php echo $milestone['rowId'];?>"><?php echo date('d-m-Y', strtotime($milestone['date']));?></td>
	                        											<td id="td_dynamicqtystage<?php echo $milestone['rowId'];?>"><?php echo $milestone['quantity'];?></td>
	                        											<td id="td_dynamicamountstage<?php echo $milestone['rowId'];?>"><?php echo $milestone['amount'];?></td>
	                        										</tr>
	                        									<?php } ?>	
	                        								<?php } else {  ?>	
	                        									<tr>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        										</tr>
	                        								<?php } ?>
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
	                        					<!-- Row10-->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">

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
	                        											<th name="bstable-actions">Boq</th> 
	                        										</tr>
	                        									</thead>
	                        									<tbody>
	                        										<?php if(!empty($contractregionsdetails)) { ?>	
																<?php foreach($contractregionsdetails as $region) { ?>
	                        										<tr>
	                        											<td id="td_dynamicregion<?php echo $region['rowId'];?>"><?php echo $region['region_text'];?></td>
	                        											<td id="td_dynamiccircle<?php echo $region['rowId'];?>"><?php echo $region['circle_text'];?></td>
	                        											<td id="td_dynamicdivision<?php echo $region['rowId'];?>"><?php echo $region['division_text'];?></td>
	                        											<td id="td_dynamiclocationregion<?php echo $region['rowId'];?>"><?php echo $region['location'];?></td>
	                        											<td id="td_dynamicfeedernameregion<?php echo $region['rowId'];?>"><?php echo $region['feedername'];?></td>
	                        											<td id="td_dynamicfeederidregion<?php echo $region['rowId'];?>"><?php echo $region['feederid'];?></td>
	                        											<td id="td_dynamicprojectidregion<?php echo $region['rowId'];?>"><?php echo $region['projectid'];?></td>
	                        											<td id="td_dynamicgeocoderegion<?php echo $region['rowId'];?>"><?php echo $region['geocode'];?></td>
	                        											<td id="td_dynamicqtyregion<?php echo $region['rowId'];?>"><?php echo  $region['quantity'];?></td>
	                        											<?php if(isset($_SESSION['boq_worktype']) && $_SESSION['boq_worktype']==1) { ?>
	                        											<td>
	                        												<button id="bEdit" type="button" class="btn btn-sm btn-obs" ><span class="fe fe-more-vertical"> </span> </button>
	                        											</td>
	                        										<?php } ?>
	                        										</tr>
	                        									<?php } ?>	
	                        									<?php } else { ?>	
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
	                        									<?php } ?>
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
	                        						<!-- <div class="col-xl-6 mt-5" style="text-align: right;">
	                        							<label class="form-label-sm mb-4">Period: Sept 2022 - Aug 2024</label>
	                        						</div> -->
	                        					</div>
	                        					<!-- Row12 -->
	                        					<div class="form-row">
	                        						<div class="col-lg-12">
													<!-- <input type="hidden" name="installationhiddentable" id="installationhiddentable" /> -->
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
	<?php if(!empty($contractinstallationsdetails)) { ?>	
													<?php foreach($contractinstallationsdetails as $installaton) { ?>
                        										<tr>
	                        											<td><?php echo $installaton['sr_no'];?></td>
	                        											<td><?php echo $installaton['equipment_material_name'];?></td>
	                        											<td><?php echo $installaton['unit_text'];?></td>
	                        											<td><?php echo $installaton['total_quantity'];?></td>
	                        										</tr>
	                        										<?php } ?>
	                        										<?php } else {  ?>	
	                        										<tr>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        										</tr>

	                        											<?php } ?>
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-installation" class="btn btn-primary mt-4"  type="button"> Add New Row</button>
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
	                        							<input class="form-control" type="text" name="mobilisationAdvance" id="mobilisationAdvance" required value="<?php echo $contractdetails->mobilisation_advance;?>">
	                        						</div>
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="invoiceNo">Invoice No.</label>
	                        							<input class="form-control" type="text" name="invoiceNo" id="invoiceNo" required value="<?php echo $contractdetails->invoice_no;?>">
	                        						</div>
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="invoiceDate">Invoice Date</label>
	                        							<div class="input-group">
	                        								<div class="input-group-text dates">
	                        									<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
	                        								</div>
                        									<input class="form-control" type="text" name="invoiceDate" id="invoiceDate" required value="<?php echo $contractdetails->invoice_date;?>">
	                        							</div>
	                        						</div>
	                        						<div class="col-xl-3">
	                        							<label class="form-label" for="mobilisationAdvAdjusted">Mobilisation Advance Adjusted</label>
	                        							<input class="form-control" type="text" name="mobilisationAdvAdjusted" id="mobilisationAdvAdjusted" required value="<?php echo $contractdetails->mobilisation_advance_adjusted;?>">
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
	                        										<?php if(!empty($materialdetails)) { ?>		
	                        											<?php foreach($materialdetails as $material) { ?>
	                        										<tr>
	                        											<!-- <td><?php //echo $material['sr_no'];?></td> -->
	                        											<td><?php echo $material['mobilisation_text'];?></td>
	                        											<td><?php echo $material['invoice_no'];?></td>
	                        											<td><?php echo date('d-m-Y', strtotime($material['invoice_date']));?></td>
	                        											<td><?php echo $material['advance_amount'];?></td>
	                        											<td><?php echo date('d-m-Y', strtotime($material['date_of_payment']));?></td>
	                        											<td><?php echo $material['advance_adjusted'];?></td>
	                        										</tr>

	                        									<?php } ?>
	                        								<?php } else { ?>
	                        									<tr>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        										</tr>
	                        								<?php } ?>
	                        										
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
	                        						<div class="col-lg-12">																					<!-- <input type="hidden" name="milestonehiddentable" id="milestonehiddentable" />
 -->
	                        							<div class="table-responsive" id="milestone_table">
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
			<tbody>																						<?php if(!empty($contractbanksdetails)) { ?>																					<?php foreach($contractbanksdetails as $bank) { ?>

<tr>
<!-- <td><?php echo $bank['sr_no'];?></td> -->
<td><?php echo $bank['bank_text'];?></td>
<td><?php echo $bank['bg_no'];?></td>
<td><?php echo date('d-m-Y', strtotime($bank['bg_date']));?></td>
<td><?php echo $bank['bg_amount'];?></td>
<td><?php echo $bank['bank'];?></td>
<td><?php echo date('d-m-Y', strtotime($bank['bg_till_date']));?></td>
</tr>
	                        										<?php } ?>	
	                        									<?php } else {  ?>	
<tr>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        											<td></td>
	                        										</tr>
	                        										
	                        									<?php } ?>
	                        									</tbody>
	                        								</table>
	                        							</div>
	                        							<button id="table2-new-row-button-bank-details" class="btn btn-primary mt-4"  type="button"> Add New Row</button>
	                        						</div>
	                        					</div>
	                        					<!-- Row17 -->
	                        					<div class="form-row">
	                        						<div class="col-xl-6 mt-5 mb-3">
	                        							<button type="button" class="btn btn-success" onclick="addContract()">Submit</button>
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
            			<!-- 	<button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            					<span aria-hidden="true">×</span>
            				</button> -->
            			</div>
            			<div class="modal-body">
            				<!-- <p>Modal body text goes here.</p> -->
            				<input type="hidden" name="rowid" id="rowid">
            					<div class="panel panel-primary" id="boqtoadd">
            						
            					</div>
            				
            			</div>
            			<div class="modal-footer">
            				<button class="btn ripple btn-success" type="button" onclick="saveboqedit()">Save changes</button>
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

        

       
        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js');?>"></script>

        <!-- DATERANGE PICKER JS -->
        <!--script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">

        	function resetform() {
        		document.getElementById("addContract").reset();

        		// Changing TypeOfWork dropdown back to default value
        		var sel = $('span[class="selection"] > span >span[class*="selection__rendered"]');
        		sel.attr('title', 'Select Type Of Work');
        		sel.text('Select Type Of Work');
        	}

        	$(function(){

        		$('input[name="effectiveDate"], input[name="completionDate"], input[name="bidOpeningDate"], input[name="priceBidOpeningDate"], input[name="tenderAwardDate"], input[name="invoiceDate"]').daterangepicker({
        			singleDatePicker: true,
        			showDropdowns: true,
        			locale: {
	                    format: 'DD-MM-YYYY'
	                }
        		});
        	});

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

            //Closes the contractor search list view on document click
          /*  $(document).click(function() {
                //alert('click');
                var list_view = $('#list-view');
                if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                    list_view.hide();
                }
            });*/

            var typeofwork = $("#typeOfWork").val();
            var contractId = $("#contractID").val();

            showboqedit(typeofwork, contractId);

        </script>

	</body>
</html>