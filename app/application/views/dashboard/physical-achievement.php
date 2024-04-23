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
        <title>MPPKVVCL - Dashboard</title>

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

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css'); ?>">

        <style>
            #myTable {
              width: 100%;
            }

            #myTable th, #myTable td {
              border: 1px solid #ddd;
              padding: 8px;
              text-align: left;
            }

            #myTable thead th {
              position: sticky;
              top: -2px;
              background-color: white;
              z-index: 1;
            }
        </style>

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
                                <h1 class="page-title">Physical Progress in RDSS Project MPPKVVCL, Indore</h1>
                                <div class="col-md-2 milestone-border">
                                    <div class="form-group">
                                       <!--  <select class="form-control form-select select2 select2-hidden-accessible" name="status" data-bs-placeholder="Select Status" tabindex="-1" aria-hidden="true" onchange="changepp(this.value);">
                                            <option value="">Select Milestone</option>
                                            <?php foreach ($stages as $stage) { ?>
                                                // code...
                                          
                                            <option value="<?php echo $stage->stage_id;?>" <?php if($milestoneid==$stage->stage_id) { ?> selected <?php } ?>><?php echo $stage->name;?></option>
                                          
                                             <?php } ?>
                                        </select> -->
                                        <input class="form-control" type="date" name="monthdate" onchange="changepp(this.value);" value="<?php echo $milestoneid; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW-1 -->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">                                        
                                        <div class="card-body mt-3 mb-3">
                                            <form id="physicalAchievementFilter" name="physicalAchievementFilter" method="POST" action="<?php echo base_url('progress'); ?>">
                                                <div class="row">
                                                    <!-- Contractor(TKC) -->
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="contractor">Contractor(TKC)</label>
                                                        <?php $contractor_value = ($contractor != 'NULL') ? $contractor : ''; ?>
                                                        <input type="text" name="contractor" id="contractor" class="form-control" onkeyup="showtkclist(this.value)" value="<?php echo $contractor_value; ?>">
                                                        <div class="list-group list-view-contractor" id="list-view"></div>
                                                    </div>
                                                    <!-- Type of Work -->
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="typeOfWork">Type of Work</label>
                                                        <select class="form-control" name="typeOfWork" id="typeOfWork">
                                                            <option value="select" selected disabled>Select Type of Work</option>
                                                            <?php foreach ($type_of_work as $key => $value) { ?>
                                                            <?php $selected = ($type_of_work_id == $value['typeofwork_id']) ? 'selected' : ''; ?>
                                                            <option value="<?php echo $value['typeofwork_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="filterDate" value="<?php echo $milestoneid; ?>">
                                                    <!-- Filter Button -->
                                                    <div class="col-md-4">
                                                        <button class="btn btn-primary mt-4 p-2" type="submit">Apply Filters</button>
                                                        <button type="button" class="btn btn-danger mt-4 ml-0 p-2" onclick="clearFilterProgress()">CLEAR</button>
                                                    </div>
                                                </div>
                                            </form> 
                                            <!-- <div class="table-responsive mt-3" style="overflow: scroll;height: calc(100vh - 129px);">  -->
                                            <div class="table-responsive mt-3" style="height: calc(100vh - 250px); border-top: 1px solid #ddd;"> 
                                                <table class="table border text-wrap text-md-nowrap table-bordered mb-0 physical-progress-dashboard" id="myTable">
                                                    <thead >
                                                        <tr>
                                                            <!--th>Sr No.</th-->  
                                                            <th>Lot No</th> 
                                                            <th>TKC</th> 
                                                            <th>Type of Work</th> 
                                                            <th colspan=2>Total Provision as per LoA</th> 
                                                            <!-- <th colspan=2>As per Milestone</th> -->
                                                            <th>Completed Till - <?php echo $previousMonth;?></th> 
                                                            <th>Target Upto - <?php echo $actualMonth;?></th> 
                                                            <th>Physical Achievement - <?php echo $actualMonth;?></th> 
                                                            <th>Cummulative Physical Achievment</th> 
                                                            <th>Status of Commissioning (%)</th> 
                                                            <th>Slippage in percentage (%) </th>
                                                        </tr>
                                                        <tr style="position: sticky; width: 100%; top: 58px; background: #fff;" >
                                                            <!--th></th-->   
                                                            <th></th>   
                                                            <th></th>   
                                                            <th></th>   
                                                            <th>S/S</th>
                                                            <th>FEEDERS</th>
                                                            <!-- <th>Target</th>
                                                            <th>Date</th>  -->
                                                            <th></th>
                                                            <th></th>   
                                                            <th></th>   
                                                            <th></th>
                                                       </tr>
                                                    </thead> 
                                                    <tbody>
                                                       
                                                        
                                                        <?php foreach ($physicals as $key) {
                                                            
                                                        ?>
                                                        <tr>
                                                            <!--td><?php //echo $key->srno;?></td-->   
                                                            <!--td class="text-nowrap"><a href="javascript:;" data-bs-target="#package-modal" data-bs-toggle="modal"><?php echo $key->package_no;?></a></td-->
                                                            <td class="text-nowrap">
                                                                <a href="javascript:;" onclick="showModal('<?php echo $key->contractor_name ?>', <?php echo $key->package_no;?>)"><?php echo $key->package_no;?></a></td>
                                                            <td class="text-nowrap" style="text-align: left"><?php echo $key->contractor_name;?></td>
                                                            <td class="text-nowrap" style="text-align: left"><?php echo $key->typeofwork;?></td>
                                                            <td style="text-align: center;" ><?php echo $key->ss;?></td>
                                                            <td style="text-align: center;"><?php echo $key->feeders;?></td>
                                                            <!-- <td><?php echo $key->target_upto;?></td>
                                                           <td class="text-nowrap"><?php echo date('d-m-Y', strtotime($key->date));?></td> -->
                                                            <td style="text-align: center;"><?php echo $key->completed_till;?></td>
                                                            <td style="text-align: center;"><?php echo $key->target_upto;?></td>
                                                            <td style="text-align: center;"><?php echo $key->physical_achievement_during_the_month;?></td>
                                                            <td style="text-align: center;"><?php echo $key->cummulative_physical_achievement;?></td>
                                                            <td style="text-align: center;"><?php echo $key->status_of_commissioning;?></td>
                                                            <td style="text-align: center;"><?php echo number_format((float)$key->slippage_in_percentage, 2, '.', ''); ?></td>
                                                        </tr>  
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                            
                        </div>
                        <!-- ROW-1 END -->
                    </div>
                    <!-- CONTAINER END -->
                </div>
                <!--app-content close-->

            </div>
        </div>

        <!-- Package Modal -->
        <div class="modal fade" id="package-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title"></h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body physical-popup">
                        <!-- <p>Modal body text goes here.</p> -->
                        <form class="form-horizontal">
                            <div class="row">
                                <!-- Region -->
                                <div class="col-md-3">
                                    <label class="form-label" for="select-region">Region</label>
                                    <select name="select-region" class="form-control form-select" data-bs-placeholder="Select Region" id="select-region" onchange="selectCircle(this.value);">
                                        <option value="" selected disabled>Select Region</option>
                                        <?php foreach ($regions as $reg) { ?>
                                            <option value="<?php echo $reg->region_id;?>"><?php echo $reg->region_name;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- Circle -->
                                <div class="col-md-3">
                                    <label class="form-label" for="select-circle">Circle</label>
                                    <select name="select-circle" class="form-control form-select" data-bs-placeholder="Select Circle" id="select-circle" onchange="selectDivisions(this.value);">
                                        <option value="" selected disabled>Select Circle</option>
                                    </select>
                                </div>
                                <!-- Division -->
                                <div class="col-md-3">
                                    <label class="form-label" for="select-division">Division</label>
                                    <select name="select-division" class="form-control form-select" data-bs-placeholder="Select Division" id="select-division">
                                        <option value="" selected disabled>Select Division</option>
                                    </select>
                                </div>
                                <input type="hidden" name="packageNo" id="packageNo">
                                <div class="col-md-3">
                                    <button class="btn btn-primary mt-6 p-2" type="button" onclick="applyFilter()">Apply Filters</button>
                                    <button type="button" class="btn btn-danger mt-6 ml-0 p-2" onclick="clearFilter()">CLEAR</button>
                                </div>
                            </div>
                        </form>
                        <!-- Table -->
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table text-nowrap text-md-nowrap mb-0 mt-3 text-center table-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th>Contract No</th>
                                            <th>Contractor</th>
                                            <th>Type of Work</th> -->
                                            <th>Region</th>
                                            <th>Circle</th>
                                            <th>Division</th>
                                            <th>Substation</th>
                                            <th>Feeder ID</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="htmlload">
                                        <!--tr>
                                            <td>Jabalpur</td>
                                            <td>Jabalpur City</td>
                                            <td>City Dn East</td>
                                            <td>VIJAYRAGHAVGARH</td>
                                            <td>42446</td>
                                            <td class="text-green">Completed</td>
                                            <td>
                                                <a href="<?php echo base_url('add-physical-progress'); ?>" id="bEdit" type="button" class="btn btn-sm " style="">
                                                    <span class="fa fa-eye fa-lg action-btn-table"></span>
                                                </a>
                                            </td>
                                        </tr-->
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Table Ends -->

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Package Modal Ends -->

        <!-- Footer -->
        <?php $this->load->view('include/footer');?>
        <!-- Footer Ends -->

        <script>
            var baseUrl = "<?php echo base_url(); ?>";
        </script>

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
        <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.html5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>        
        
        <script>
            window.onload = function() {
                var tableHead = document.querySelector("#myTable thead");
                var tableBody = document.querySelector("#myTable tbody");

                tableBody.addEventListener("scroll", function() {
                    tableHead.style.transform = "translateY(" + this.scrollTop + "px)";
                });
            };

            function changepp(stageId)
            {
                window.location.href = baseUrl+"progress/"+stageId;
            }

            function showModal(name, package_no)
            {
                $("#modal_title").empty();
                $("#packageNo").val(package_no);
                $("#modal_title").text(name);

                $.ajax({
                    url: baseUrl+"getlocations/"+package_no, 
                    success: function(result){
                        inputs = result;
                        $("#htmlload").empty();
                        $("#htmlload").html(inputs);
                    }
                });
                                
                $("#package-modal").modal("show");
            }

            function selectCircle(region_id)
            {
                $.ajax({url: baseUrl+"getcircles/"+region_id, success: function(result){
                                    inputs = result;
                                   $("#select-circle").empty();
                                   $("#select-circle").html(inputs);
                                }});
            }

            function selectDivisions(circle_id)
            {
                $.ajax({url: baseUrl+"getdivisions/"+circle_id, success: function(result){
                                    inputs = result;
                                   $("#select-division").empty();
                                   $("#select-division").html(inputs);
                                }});
            }

            function applyFilter()
            {
                var region_id = $("#select-region").val();
                var circle_id = $("#select-circle").val();
                var division_id = $("#select-division").val();

                var package_no = $("#packageNo").val();

                 $.ajax({
                    url: baseUrl+"getlocationsfilter/"+package_no+"/"+region_id+"/"+circle_id+"/"+division_id, 
                    success: function(result){
                        // console.log(result); return false;
                        inputs = result;
                        $("#htmlload").empty();
                        $("#htmlload").html(inputs);
                    }
                });
            }

            function clearFilter() {
                $('#select-region').val('').change();
                $('#select-circle').val('').change();
                $('#select-division').val('').change();

                let packageNo = $("#packageNo").val();

                $.ajax({
                    url: baseUrl+"getlocations/"+packageNo, 
                    success: function(result){
                        inputs = result;
                        $("#htmlload").empty();
                        $("#htmlload").html(inputs);
                    }
                });

                $('#select-circle').empty().append('<option value="" selected disabled>Select Circle</option>');
                $('#select-division').empty().append('<option value="" selected disabled>Select Division</option>');
            }

            //Displays contractor search list view
            function showtkclist(tkcValue) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('search-contractor-pp') ?>',
                    dataType: 'json',
                    data: {contractor: tkcValue},
                    success: function(response){
                        console.log(response); 

                        $('#list-view').show();
                        $('#list-view').empty();

                        var html = '';

                        let contractor_data = response.contractor_data;

                        if ($.isEmptyObject(contractor_data)) {
                            html += 'No Contractor Found';
                        } else {
                            $.each(contractor_data, function(index, value) {
                                html += '<a href="javascript:void(0)" class="p-2 list-group-item list-group-item-action flex-column align-items-start" data-typeofwork-id="'+value.typeofwork_id+'" data-contract-id="'+value.contract_id+'" onclick=applyContractorDetails(this)>';
                                html += '<div class="d-flex w-100 justify-content-between">';
                                html += '<h4 class="mb-1 contractor-name"><strong>'+value.contractor_name+'</strong></h4>';
                                html += '<small class="text-muted contract-date">Contract Date : <span class="text-primary"> '+value.tender_award_date+'</span></small>';
                                html += '</div>';
                                html += '<p class="mb-0 type-of-work">Type Of Work: <span class="text-primary"> '+value.typeofwork_name+'</span></p>';
                                html += '<small class="text-muted contract-no">Contract No: <span class="text-primary">'+value.tender_award_no+'</span></small>';
                                html += '</a>';
                            });
                        }

                        $('#list-view').append(html);
                    },
                    error: function(xhr, status, error){
                        console.log(xhr.responseText);
                    }
                });
            }

            function applyContractorDetails(anchor) {
                $('#list-view').hide();

                let contractor_name = $(anchor).find('.contractor-name').text();
                $('input[name="contractor"]').val(contractor_name);
            }

            $(document).click(function() {
                var list_view = $('#list-view');
                if (!list_view.is(event.target) && !list_view.has(event.target).length) {
                    list_view.hide();
                }
            });

            function clearFilterProgress() {
                window.location.href = baseUrl + "progress";
            }
        </script>

    </body>

</html>