<!-- App-Header -->
<div class="app-header header sticky">
    <!-- main-container -->
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>

            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>

                <!-- nav-bar -->
                <div class="navbar navbar-collapse responsive-navbar p-0" style="position: relative;">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">
                            <?php   /*foreach ($this->session->totalData as $key) { 
                                        if($key->keyword=="Total") {
                                            $var = "green";
                                        } else {
                                            $var = "yellow";
                                        }*/
                            ?>
                            <!-- <div class="mt-2" style="margin-right: 10px;">  
                                <?php //if($key->keyword=="Total") { ?>  
                                <h4 class="mb-0 text-<?php //echo $var;?> fw-semibold"> <b> <?php //echo $key->target;?></b></h4>
                                <?php //} else {  ?>
                                <h4 class="mb-0 text-<?php //echo $var;?> fw-semibold"> <b> <?php //echo $key->actual;?></b></h4>
                                <?php //} ?>   
                                <h7 class="fw-normal" style="font-size: 12px;"><?php //echo $key->keyword;?></h7> 
                            </div>  -->
                            <?php   //}  ?>
                            <div class="tot-amount-hed" style="margin-right: 10px;">
                                <?php $totalData = $this->session->totalData; ?>
                                <div class="row contract-value">
                                    <span style="text-align: right;">Total Contract Value  <br><h6 class="mb-0 text-green fw-semibold"><b><?php echo $totalData[0]['target'];?></b></h6></span>
                                    <span style="text-align: right;">Total Financial Value of the Work<br><h6 class="mb-0 text-green fw-semibold"><b><?php echo isset($totalData[1]['Total_financial_physical_progress']) ? $totalData[1]['Total_financial_physical_progress'] : 0; ?></b>(<?php echo isset($totalData[1]['Total_financial_physical_progress_per']) ? $totalData[1]['Total_financial_physical_progress_per'].'%' : 0; ?>)</h6></span>
                                </div>
                                <div class="row financial-value">
                                    <span style="text-align: right;">Financial Value - WIP <br><h6 class="mb-0 text-green fw-semibold"><b><?php echo $totalData[1]['wip_financial_physical_progress'];?></b>(<?php echo $totalData[1]['wip_financial_physical_progress_per'].'%'; ?>)</h6></span>
                                    <span style="text-align: right;">Financial Value - Completed <br><h6 class="mb-0 text-green fw-semibold"><b><?php echo $totalData[1]['completed_financial_physical_progress'];?></b>(<?php echo $totalData[1]['completed_financial_physical_progress_per'].'%'; ?>)</h6></span>
                                </div>
                            </div>
                         </div> 

                        <div class="d-flex order-lg-2">
                            <div class="dropdown d-lg-none d-flex">
                                <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                                    <i class="fe fe-search"></i>
                                </a>
                                <div class="dropdown-menu header-search dropdown-menu-start">
                                    <div class="input-group w-100 p-2">
                                        <input type="text" class="form-control" placeholder="Search....">
                                        <div class="input-group-text btn btn-primary">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex country">
                                <a class="nav-link icon text-center">
                                    <i class="fe fe-user"></i>
                                    <span class="fs-16 ms-2 d-none d-xl-block"><?php echo $this->session->username;?> (<?php echo $this->session->userdata['loggedData']->designation;?>)</span>
                                </a> 
                                <a class="nav-link icon text-center" href="<?php echo base_url();?>logout">
                                    <i class="fe fe-log-out"></i>
                                    <span class="fs-16 ms-2 d-none d-xl-block">Logout</span>
                                </a> 
                                <span class="logo-horizontal">
                                    <img src="<?php echo base_url('assets/images/brand/sgs_logo.png'); ?>" class="header-brand-img desktop-logo" alt="logo">    
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- nav-bar ends -->
                <!-- Toaster Alert -->
                <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true">
                    <div class="d-flex toster-out">
                    <div class="toast-body"> Hello, world! This is a toast message. </div>
                        <button aria-label="Close" class="btn-close text-white ms-auto  pe-2" data-bs-dismiss="toast">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
                <!-- Toaster Alert Ends-->
            </div>
        </div>
    </div>
    <!-- main container ends -->
</div>
<!-- App-Header Ends -->