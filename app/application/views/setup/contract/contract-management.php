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
        <title>MPPKVVCL - Contract Management</title>

        <!-- BOOTSTRAP CSS -->
        <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

        <!-- STYLE CSS -->
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/toast.css');?>" rel="stylesheet">

        <!-- PLUGINS CSS -->
        <link href="<?php echo base_url('assets/css/plugins.css'); ?>" rel="stylesheet">

        <!--- FONT-ICONS CSS -->
        <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet">

        <!-- INTERNAL Switcher css -->
        <link href="<?php echo base_url('assets/switcher/css/switcher.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/switcher/demo.css'); ?>" rel="stylesheet">        
        
        <!-- DATERANGEPICKER CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">
        
    </head>

	<body class="app sidebar-mini ltr light-mode">
        <div id="toasts"></div>
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
                <?php $this->load->view('include/side-bar');?>

                <!-- App-Content -->
                <div class="main-content app-content mt-0">
                    <div class="side-app">                       

                        <!-- Container -->
                        <div class="main-container container-fluid">

                            <!-- Page-Header -->
                            <div class="page-header">
                                <h1 class="page-title">Contract Management</h1>
                                <!-- <div>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Contract Management</li>
                                    </ol>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-12 mt-2 mb-3">
                                        <?php if(user_module($access_key, 'add')) { ?>
                                        <a  href="<?php echo base_url('contract-management/add');?>" class="btn btn-success btn-add">Add</a>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Page-Header Ends -->

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <!-- <div class="card-header">
                                            <h3 class="card-title" style="width:100%">Contract Lists</h3>
                                            <a  href="add-contract.php" class="btn btn-success">Add</a>
                                        </div> -->

                                        <div class="card-body">
                                            <!-- Search Block -->
                                            <div class="accordion mb-2" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <?php $accordion_btn_class = (isset($filters)) ? 'filters-on' : '';
                                                              $accordion_btn_style = (isset($filters)) ? 'style="height:57px;"' : '';
                                                              $clear_btn_visibility = (isset($filters)) ? '' : 'hidden';
                                                        ?>
                                                        <button class="accordion-button collapsed active m-0 prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>
                                                            Search Contract Management
                                                        </button>
                                                    </h2>
                                                    <div class="clear-data" <?php echo $clear_btn_visibility; ?>>
                                                        <a href="#" class="text-danger clear-search-filters" id="clear-btn"> Clear</a>
                                                    </div>
                                                    <div class="lab-value">
                                                        <ul>
                                                        <?php   if (isset($filters)) {
                                                                    foreach ($filters as $key => $value) {
                                                                        if (!empty($value['value'])) { ?>
                                                        <li><?php echo $value['label'].' : '.$value['value']; ?></li>      
                                                        <?php           }
                                                                    }
                                                                } 
                                                        ?> 
                                                        </ul>
                                                    </div>
                                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body p-1">
                                                           <form name="search_contract" action="<?php echo base_url('contract-management')?>" method="GET">
                                                                <!-- Row1 -->
                                                                <div class="row">
                                                                    <!-- Contractor (TKC) -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="contractor">Contractor (TKC)</label>
                                                                            <input type="text" name="contractor" class="form-control" id="contractor" onkeyup="showtkc1(this.value)" value="<?php echo empty($_GET['contractor']) ? "" : $_GET['contractor'] ?>">
                                                                            <div class="list-group list-view-contractor" id="list-view"></div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Contract No -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="tenderAwardNo">Contract No.</label>
                                                                            <input class="form-control" type="text" name="tenderAwardNo" id="tenderAwardNo" value="<?php echo empty($_GET['tenderAwardNo']) ? "" : $_GET['tenderAwardNo'] ?>">
                                                                        </div>
                                                                    </div> 
                                                                    <!-- Contract Date -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="tenderAwardDate">Tender Award Date</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-text dates">
                                                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                                                </div> 
                                                                                <input type="text" class="form-control" name="tenderAwardDate" id="tenderAwardDate"  value="<?php echo empty($_GET['tenderAwardDate']) ? "" : $_GET['tenderAwardDate'] ?>"/>  
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    <!-- Status -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="status">Status</label>
                                                                            <select multiple="multiple" class="filter-multi" name="status[]" id="status">
                                                                                <?php $selected_status = (isset($filters) && !empty($filters['status']['id'])) ? $filters['status']['id'] : ''; ?>
                                                                                <?php foreach ($status_list as $key => $value) { ?>
                                                                                <?php $selected = (is_array($selected_status) && in_array($value['status_id'], $selected_status)) ? 'selected' : ''; ?>
                                                                                <option value="<?php echo $value['status_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Row2 -->
                                                                <div class="row">
                                                                    <!-- Search Button -->
                                                                    <div class="col-md-3">
                                                                        <button type="submit" class="btn btn-primary mt-1 mb-1 search-contract-btn">Search</button>
                                                                        <button type="button" class="btn default-clear clear-search-filters mt-1 mb-1">Clear</button>
                                                                    </div>
                                                                </div>
                                                           </form> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Search Block Ends -->

                                           <!-- Table -->
                                           <div class="table-responsive">
										  
                                               <div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
											   
                                                    <div class="row">
													 
                                                        <div class="col-sm-12">
                                                            <!-- Export Button -->
                                                            <div class="col-sm-12 col-md-9s mb-2">
                                                                <div class="dts-buttons btn-group flex-wrap" style="float:right;">
                                                                    <button class="btn btn-primary" type="button"><span>Export</span></button>
                                                                </div>
                                                            </div>
                                                            <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" id="basic-datatable" role="grid" aria-describedby="basic-datatable_info">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th class="wd-10p border-bottom-0" tabindex="0" aria-controls="basic-datatable" rowspan="1" colspan="1"style="width: 95.5156px;">Actions</th>
                                                                        <th class="wd-10p border-bottom-0 sorting sorting_asc" tabindex="1" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Tender Award No: activate to sort column descending" style="width: 95.5156px;">Contract No</th>
                                                                        <th class="wd-15p border-bottom-0 sorting" tabindex="2" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Tender Award Date: activate to sort column descending" style="width: 88.5469px;">Contract Date</th>
                                                                        <th class="wd-25p border-bottom-0 sorting" tabindex="3" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Name of Contractor: activate to sort column ascending" style="width: 178.531px;">Name of Contractor</th>
                                                                        <th class="wd-25p border-bottom-0 sorting" tabindex="4" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Type of Work: activate to sort column ascending" style="width: 92.5312px;">Type of Work</th>
                                                                        <th class="wd-20p border-bottom-0 sorting" tabindex="5" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Period: activate to sort column descending" style="width: 67.7031px;">Period</th>
                                                                        <th class="wd-15p border-bottom-0 sorting" tabindex="6" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Quantity: activate to sort column descending" style="width: 185.141px;">Quantity</th>
                                                                        <th class="wd-20p border-bottom-0 sorting" tabindex="7" aria-controls="basic-datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 185.141px;">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
																<?php foreach($contractlist as $list) { ?>
                                                                    <tr class="odd">
                                                                        <td class="d-flex">
                                                                              <?php if(user_module($access_key, 'view')) { ?>
                                                                            <a href="<?php echo base_url();?>view-contract-management/<?php echo $list->contract_id;?>" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                        <?php } ?>
                                                                            &nbsp;&nbsp;
                                                                            <?php if(user_module($access_key, 'update')) { ?>
                                                                            <a href="<?php echo base_url();?>contract-management/<?php echo $list->contract_id;?>" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                        <?php } ?>
                                                                            &nbsp;&nbsp;
                                                                            <?php if(user_module($access_key, 'delete')) { ?>
                                                                            <button  type="button" class="btn m-0 btn-sm deletecompany" id='<?php echo $list->contract_id;?>'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td class="sorting_1"><?php echo $list->tender_award_no;?></td>
                                                                        <td><?php echo date('d-m-Y', strtotime($list->tender_award_date));?></td>
                                                                        <td><?php echo $list->contractor_name;?></td>
                                                                        <td><?php echo $list->name;?></td>
                                                                        <td>
                                                                            <?php 

                                                                            $now = strtotime($list->completion_date); // or your date as well
$your_date = strtotime($list->effective_date);
$datediff = $now - $your_date;

round($datediff / (60 * 60 * 24));
echo date('d-m-Y', strtotime($list->effective_date))." - ".date('d-m-Y', strtotime($list->completion_date));

                                                                            ?>
                                                                           
                                                                           </td>
                                                                        <td><?php echo $list->quantity;?></td>
                                                                        <td><?php echo $list->status_name;?></td>
                                                                    </tr>
																<?php } ?>
                                                                    <!--tr class="even">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">451</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s Shreem Electric, Jaysinghnagar (MH)</td>
                                                                        <td>Substation(SR & RR)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="odd">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">452</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s UMEP, Mumbai</td>
                                                                        <td>Capacitor Bank</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">453</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s AK Infra, Gaziabad</td>
                                                                        <td>Capacitor Bank</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="odd">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">454</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s MDP, Gwalior</td>
                                                                        <td>Capacitor Bank</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">455</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s Kishor Infra Pvt. Ltd., Hyderabad</td>
                                                                        <td>Substation(JR & SDLR)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="odd">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">456</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s Ashoka Buildcon, Nashik</td>
                                                                        <td>Substation(SR & RR)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">457</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s Ashoka Buildcon, Nashik</td>
                                                                        <td>Feeder Separation(SDLR)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="odd">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">458</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s Ashoka Buildcon, Nashik</td>
                                                                        <td>Feeder Separation(Sidhi & Singrauli Circle)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">459</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s Agarwal Power</td>
                                                                        <td>Feeder Separation(Balaghat Circle)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="odd">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">460</td>
                                                                        <td>02.09.2022</td>
                                                                        <td>M/s RVNL</td>
                                                                        <td>Feeder Separation(Rewa Circle)</td>
                                                                        <td>30 days</td>
                                                                        <td>100</td>
                                                                        <td>Open</td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <td>
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a href="edit-contract.php" class="btn btn-sm">
                                                                                <span class="fe fe-edit fa-lg action-btn-table"></span>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <button  type="button" class="btn  btn-sm" id='deletecompany'>
                                                                                <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                            </button>
                                                                        </td>
                                                                        <td class="sorting_1">461</td>
                                                                        <td>10.09.2022</td>
                                                                        <td>M/s Agarwal Power</td>
                                                                        <td>Feeder Separation(Satna Circle)</td>
                                                                        <td>50 days</td>
                                                                        <td>200</td>
                                                                        <td>Close</td>
                                                                    </tr-->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row">
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="dataTables_info" id="basic-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 50 entries</div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="dataTables_paginate paging_simple_numbers" id="basic-datatable_paginate">
                                                                <ul class="pagination">
                                                                    <li class="paginate_button page-item previous disabled" id="basic-datatable_previous">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                                                    </li>
                                                                    <li class="paginate_button page-item active">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                                                    </li>
                                                                    <li class="paginate_button page-item ">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                                                    </li>
                                                                    <li class="paginate_button page-item ">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a>
                                                                    </li>
                                                                    <li class="paginate_button page-item ">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a>
                                                                    </li>
                                                                    <li class="paginate_button page-item ">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a>
                                                                    </li>
                                                                    <li class="paginate_button page-item next" id="basic-datatable_next">
                                                                        <a href="#" aria-controls="basic-datatable" data-dt-idx="6" tabindex="0" class="page-link">Next</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                           </div>
                                           <!-- Table Ends -->
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
		
		<script>
			var baseUrl = "<?php echo base_url(); ?>";
			
			</script>

        <!-- BACK-TO-TOP -->
        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

        <!-- JQUERY JS -->
        <script src="assets/js/jquery.min.js"></script>

        <!-- BOOTSTRAP JS -->
        <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <!-- INPUT MASK JS-->
        <script src="assets/plugins/input-mask/jquery.mask.min.js"></script>

        <!-- TypeHead js -->
        <script src="assets/plugins/bootstrap5-typehead/autocomplete.js"></script>
        <script src="assets/js/typehead.js"></script>

        <!-- SELECT2 JS -->
        <script src="assets/plugins/select2/select2.full.min.js"></script>

        <!-- FORMVALIDATION JS -->
        <script src="assets/js/form-validation.js"></script>

        <!-- Perfect SCROLLBAR JS-->
        <script src="assets/plugins/p-scroll/perfect-scrollbar.js"></script>
        <script src="assets/plugins/p-scroll/pscroll.js"></script>
        <script src="assets/plugins/p-scroll/pscroll-1.js"></script>


         <!-- SWEET-ALERT JS -->
         <script src="<?php echo base_url('assets/plugins/edit-table/contract/contract-session.js');?>"></script>

        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js');?>"></script>

        <!-- SIDE-MENU JS -->
        <script src="assets/plugins/sidemenu/sidemenu.js"></script>

        <!-- SIDEBAR JS -->
        <script src="assets/plugins/sidebar/sidebar.js"></script>

        <!-- Color Theme js -->
        <script src="assets/js/themeColors.js"></script>

        <!-- Sticky js -->
        <script src="assets/js/sticky.js"></script>

        <!-- CUSTOM JS -->
        <script src="assets/js/custom.js"></script>

        <!-- Custom-switcher -->
        <script src="assets/js/custom-swicher.js"></script>
        <script src="<?php echo base_url('assets/plugins/toast/toaster.js');?>"></script>

        <!-- Switcher js -->
        <script src="assets/switcher/js/switcher.js"></script>

        <!-- MULTI JS -->
        <script src="<?php echo base_url('assets/plugins/multi/multi.min.js'); ?>"></script>

        <!-- MULTIPLE SELECT JS -->
        <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script> 

         <!-- DATA TABLE JS-->
        <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
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
        <script src="assets/js/table-data.js"></script>


         <?php   if(!empty($this->session->flashdata('success'))) {   ?>
            <script>
            $(function(){
                
          $.toast("success", '<?php  echo $this->session->flashdata('success');?>');   
            });
            </script>
            <?php } ?>


            <?php   if(!empty($this->session->flashdata('error'))) {   ?>
            <script>
            $(function(){
              
             $.toast("error", '<?php  echo $this->session->flashdata('error');?>');   
            });
            </script>
                                        <?php } ?>

        <!-- SWEET-ALERT JS -->
        <script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
        <script src="assets/js/sweet-alert.js"></script>
        
        <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>        

         <script>
        /*$(document).ready(function() {
            $('#basic-datatable').dataTable( {
                "bPaginate": false,
                "bFilter": false,
                "bInfo": false,
                "bDestroy": true
            } );
        });*/
        </script>

        <script type="text/javascript">
            $('input[name="tenderAwardDate"]').daterangepicker({
                //autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            <?php if(empty($posttenderAwardDate))  {  ?>
            $('input[name="tenderAwardDate"]').val("");
            <?php } ?>


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

            $('.clear-search-filters').on('click', function(event) {
                event.preventDefault();

                $('.lab-value').find('ul').empty();
                $('#headingOne').find('button').removeClass('filters-on');
                $('#headingOne').find('button').removeAttr('style');

                let search_form = $('#searchNCRReview')[0];

                //Clearing all input[type=text] values
                $(search_form).find('input.form-control:text').each(function() {
                    $(this).val('');
                });

                //Clearing all select values
                $(search_form).find('.select2').each(function() {
                    $(this).val('select');
                    $(this).trigger('change');
                });

                //Clearing Status filter values
                let status_select = $(search_form).find('.filter-multi:eq(1)');
                $(status_select).find('li.selected').each(function() {
                    $(this).removeClass('selected');
                    $(this).find('input:checkbox').prop('checked', false);
                });             
                $(status_select).find('.ms-choice span').text('');

                $('#clear-btn').hide();

                window.location.replace('<?php echo base_url("contract-management") ?>');
            });


        </script>

        <script>

        </script>

       


	</body>
</html>