<!DOCTYPE html>
<html>
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
	    <title>MPPKVVCL - <?php echo $title; ?></title>

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

	    <!-- TABLER ICONS CSS -->
	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

        <!-- DATERANGEPICKER CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
         />
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

                <!-- App Content -->
                <div class="main-content app-content mt-0">
                	<div class="side-app">
                		
                		<!-- Container -->
                		<div class="main-container container-fluid">
                			
                			<!-- Page Header -->
                			<div class="page-header">
                				<h1 class="page-title">Add TKC Weekly Plan</h1>
                			</div>
                			<!-- Page Header Ends -->

                			<!-- Row -->
                			<div class="row row-sm">
                				<div class="col-lg-12">
                					<div class="card">
                						<div class="card-body mt-3">
                                            <form name="addTKCWeeklyPlan" id="addTKCWeeklyPlan" method="post" action="<?php echo base_url('save-tkc-weekly-plan'); ?>">
                                                <!-- Row1 -->
                                                <div class="row">
                                                    <!-- Date Range -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="weeklyPlanDateRange">Select Date Range
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="weeklyPlanDateRange" name="weeklyPlanDateRange">
                                                        </div>
                                                    </div>
                                                    <!-- Contractor Name -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="contractorTKC">Contractor(TKC)
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="contractorTKC" id="contractorTKC" value="<?php echo $contractor_name; ?>" readonly>
                                                    </div>
                                                </div>                                                
                                                <div id="weeklyPlan" class="mt-3">
                                                    <!-- Row2 -->
                                                    <div class="row">
                                                        <!-- Weekly Plan Title -->
                                                        <div class="col-xl-12" style="text-align: center;" id="weeklyPlanHeading">
                                                            <h4>Weekly Plan <span>(15-01-2024 To 21-01-2024)</span></h4>
                                                        </div>    
                                                    </div> 
                                                    <!-- Row3 -->
                                                    <div class="row">
                                                        <!-- Weekly Plan Table -->
                                                        <div class="col-xl-12">
                                                            <div class="table-responsive">
                                                                <!-- Table -->
                                                                <table class="table table-bordered border mb-0" id="new-add-weekly-tkc-plan-details">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr No.</th>
                                                                            <th>Lot No.</th>
                                                                            <th>Day</th>
                                                                            <th>Date of Work</th>
                                                                            <th>Name of Circle</th>
                                                                            <th>Name of Division</th>
                                                                            <th>Name of Site/Feeder</th>
                                                                            <th>Brief description of work to be executed</th>
                                                                            <th>Remark</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr data-row-id=0>
                                                                            <td class="sr-no"></td>
                                                                            <td class="lot-no"></td>
                                                                            <td class="day"></td>
                                                                            <td class="date-of-work"></td>
                                                                            <td class="circle"></td>
                                                                            <td class="division"></td>
                                                                            <td class="site-location"></td>
                                                                            <td class="description-of-work"></td>
                                                                            <td class="remark"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <button id="table2-new-row-button-weekly-tkc-plan-details" class="btn btn-primary mb-4 mt-4">Add New Row</button>
                                                        </div>
                                                    </div>
                                                    <!-- Row4 -->
                                                    <div class="row">
                                                        <!-- Submit Button -->
                                                        <div class="col-xl-12 mt-3 mb-3">
                                                            <button type="submit" class="btn btn-warning" id="draft-plan">Save as draft</button>
                                                            <button type="submit" class="btn btn-success" id="save-plan">Submit</button>
                                                            <a href="<?php echo base_url('tkc-weekly-plan'); ?>" type="button" class="btn btn-primary">Back</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                						</div>
                					</div>
                				</div>
                			</div>
                			<!-- Row Ends -->

                            <!-- Plan Modal -->
                            <div class="modal fade" id="dailyPlanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dailyPlanModalLabel" aria-hidden="true" data-row-id="">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="dailyPlanModalLabel">Daily Plan</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                            <!-- Toaster Alert -->
                                            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-animation="true" id="daily-plan-alert">
                                                <div class="d-flex toster-out">
                                                   <div class="toast-body"> Hello, world! This is a toast message. </div>
                                                   <button aria-label="Close" class="btn-close text-white ms-auto  pe-2" data-bs-dismiss="toast" style="margin: -6px;">
                                                      <span aria-hidden="true">×</span>
                                                   </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <form name="addDailyPlan" id="addDailyPlan">
                                                <!-- Row1 -->
                                                <div class="row">
                                                    <!-- Lot No. -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="lotNo">Select Lot No.
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <select name="lotNo" id="lotNo" class="form-control form-select" data-bs-placeholder="Select Lot No.">
                                                            <option value="select" selected disabled>Select Lot No.</option>
                                                            <?php foreach ($packages as $key => $value) { ?>
                                                            <option value="<?php echo $value['package_no']; ?>"><?php echo $value['package_no']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- Date -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="weekDates">Select Date
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="weekDates" name="weekDates">
                                                        </div>
                                                    </div>
                                                    <!-- Day -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="weekDay">Day
                                                            <span class="text-red">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="weekDay" id="weekDay" value="">
                                                    </div>
                                                </div>
                                                <!-- Row2 -->
                                                <div class="row">
                                                    <!-- Circle -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="circle">Select Circle</label>
                                                        <select name="circle" id="circle" class="form-control form-select" data-bs-placeholder="Select Circle">
                                                            <option value="select" selected disabled>Select Circle</option>
                                                            <?php foreach ($circles as $key => $value) { ?>
                                                            <option value="<?php echo $value['circle_name']; ?>"><?php echo $value['circle_name']; ?></option>    
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- Division -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="division">Select Division</label>
                                                        <select name="division" id="division" class="form-control form-select" data-bs-placeholder="Select Division">
                                                            <option value="select" selected disabled>Select Division</option>
                                                            <?php foreach ($divisions as $key => $value) { ?>
                                                            <option value="<?php echo $value['division_name']; ?>"><?php echo $value['division_name']; ?></option>    
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- Site Location / Feeder Name -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="site_location">Site Location / Feeder Name</label>
                                                        <input type="text" class="form-control" name="site_location" id="site_location" value="">  
                                                    </div>
                                                </div>
                                                <!-- Row3 -->
                                                <div class="row">
                                                    <!-- Work Description -->
                                                    <div class="col-xl-8">
                                                        <label class="form-label" for="description_of_work">Brief description of work to be executed</label>
                                                        <textarea class="form-control" id="description_of_work" name="description_of_work" rows="2"></textarea>
                                                    </div>
                                                    <!-- Remark -->
                                                    <div class="col-xl-4">
                                                        <label class="form-label" for="remark">Remark</label>
                                                        <input type="text" class="form-control" name="remark" id="remark" value="">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="btn-saveDailyPlan">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Plan Modal Ends -->

                		</div>
                		<!-- Container Ends -->

                	</div>
                </div>
                <!-- App Content Ends -->

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
        <script src="<?php  echo base_url('assets/plugins/bootstrap/js/popper.min.js'); ?>"></script>
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

        <!-- EDIT-TABLE JS -->
        <script src="<?php echo base_url('assets/plugins/edit-table/tkc-weekly-plan/tkc-weekly-plan.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/tkc-weekly-plan/tkc-weekly-plan-edit-table.js'); ?>"></script>

        <!-- DATA TABLE JS-->
        <!-- <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.php5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script> -->

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

        <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">
            let from_date, to_date;
            let weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];

            $('input[name="weeklyPlanDateRange"]').daterangepicker({
                autoUpdateInput: false,
                // autoApply: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            $('input[name="weeklyPlanDateRange"]').on('apply.daterangepicker', function(ev, picker) {
                from_date = getModifiedDate(picker.startDate.format('DD-MM-YYYY'));
                to_date = getModifiedDate(picker.endDate.format('DD-MM-YYYY'));

                let milli_secs = from_date.getTime() - to_date.getTime();

                // Convert the milli seconds to Days
                let days = milli_secs / (1000 * 3600 * 24); //Returns no. of days

                let day = from_date.getDay(); //Returns day of the week

                if (days == -6 && day == 1) {
                    $(this).val(picker.startDate.format('DD-MM-YYYY') +' - '+ picker.endDate.format('DD-MM-YYYY'));
                    $('#weeklyPlanHeading').find('h4 > span').text(picker.startDate.format('DD-MM-YYYY') +' To '+ picker.endDate.format('DD-MM-YYYY'));

                    // Initializing the daterangepicker on modal
                    $('input[name="weekDates"]').daterangepicker({
                        singleDatePicker: true,
                        parentEl: '#dailyPlanModal',
                        autoUpdateInput: false,
                        minDate: from_date,
                        maxDate: to_date,
                        locale: {
                            format: 'DD-MM-YYYY'
                        }
                    });

                    $('#weeklyPlan').attr('hidden', false);
                } else {
                    $('.toast-body').text('Select a date range of 7 days starting from Monday');
                    $('.toast').toast('show');

                    $(this).val('');
                    $('#weeklyPlan').attr('hidden', true);

                    return false;
                }
            });

            $('input[name="weekDates"]').on('apply.daterangepicker', function(ev, picker) {
                let selected_date = picker.startDate.format('DD-MM-YYYY');
                $(this).val(selected_date);

                let day = getModifiedDate(selected_date).getDay(); //Returns day of the week
                let day_name = weekDays[day];
                $('input[name="weekDay"]').val(day_name);
                $('input[name="weekDay"]').prop('readonly', true);
            });

            /*$('#addDailyPlan').submit(function(event) {
                alert('here');
            });*/

            $('#table2-new-row-button-weekly-tkc-plan-details').click(function(event) {
                event.preventDefault();
            });

            $('#btn-saveDailyPlan').click(function(event) {
                let lot_no = $('select[name="lotNo"] option:selected').val();
                let date = $('input[name="weekDates"]').val();

                if (lot_no == 'select') {
                    $('#daily-plan-alert').find('.toast-body').text('Select Lot No.');
                    $('#daily-plan-alert').toast('show');

                    return false;
                } else if (date == '') {
                    $('#daily-plan-alert').find('.toast-body').text('Select Date');
                    $('#daily-plan-alert').toast('show');

                    return false;
                } else {
                    let day = $('input[name="weekDay"]').val();
                    let circle = $('select[name="circle"] option:selected').val();
                    let division = $('select[name="division"] option:selected').val();
                    let site_location = $('input[name="site_location"]').val();
                    let work_description = $('textarea[name="description_of_work"]').val();
                    let remark = $('input[name="remark"]').val();

                    let row_id = $('#dailyPlanModal').attr('data-row-id');
                    let tr = $('#new-add-weekly-tkc-plan-details tbody').find('tr[data-row-id="'+row_id+'"]');

                    $(tr).find('.sr-no').text(++row_id);
                    $(tr).find('.lot-no').text(lot_no);
                    $(tr).find('.day').text(day);
                    $(tr).find('.date-of-work').text(date);

                    if (circle != 'select') {
                        $(tr).find('.circle').text(circle);
                    }

                    if (division != 'select') {
                        $(tr).find('.division').text(division);
                    }

                    if (site_location != '') {
                        $(tr).find('.site-location').text(site_location);
                    }

                    if (work_description != '') {
                        $(tr).find('.description-of-work').text(work_description);
                    }

                    if (remark != '') {
                        $(tr).find('.remark').text(remark);
                    }

                    $('#dailyPlanModal').modal('hide');
                    $('#addDailyPlan').trigger('reset');

                    let tr_btn = $(tr).find('#bEdit');
                    _actionsModeNormal(tr_btn);
                }
            });

            $('#addTKCWeeklyPlan').submit(function(event) {
                // console.log($(this)); return false;
                // alert('here');
                let weekly_plan_form = $('#addTKCWeeklyPlan')[0];
                // console.log(weekly_plan_form); 

                let formData = new FormData(weekly_plan_form);
                /*console.log('formData:');
                console.log(formData);*/

                let trs = $('#new-add-weekly-tkc-plan-details tbody').find('tr');

                let weekly_plan_array = [];

                $(trs).each(function(index, value) {
                    let tds = $(value).find('td');

                    // let plan_array = [];
                    let plan_array = new Object();
                    // let sr_no, lot_no, day, date_of_work, circle, division, site_location, work_description, remark;
                    $(tds).each(function(ind, val) {
                        if (ind == 0) {
                            return;
                        }

                        let field = $(val).attr('class').replace(/-/g,'_');
                        /*field.replace(/-/g,'_');
                        console.log('field: ' +field);
                        console.log(field.replace(/-/g,'_'));*/
                        // console.log('field: ' +field);
                        

                        /*if (field == 'sr-no') {
                            sr_no = $(val).text();
                        } else if (field == 'lot-no') {
                            lot_no = $(val).text();
                        } else if (field == 'day') {
                            day = $(val).text();
                        } else if (field == 'date-of-work') {
                            date_of_work = $(val).text();
                        } else if (field == 'circle') {
                            circle = $(val).text();
                        } else if (field == 'division') {
                            division = $(val).text();
                        } else if (field == 'site-location') {
                            site_location = $(val).text();
                        } else if (field == 'description-of-work') {
                            work_description = $(val).text();
                        } else if (field == 'remark') {
                            remark = $(val).text();
                        }*/

                        plan_array[field] = $(val).text();
                        
                        // return false;
                    });

                    /*console.log('plan_array:');
                    console.log(plan_array);*/

                    /*console.log('plan_array stringify:');
                    console.log(JSON.stringify(plan_array));*/

                    // return false;

                    // weekly_plan_array.push({'sr_no':sr_no, 'lot_no':lot_no, 'day':day, 'date_of_work':date_of_work, 'circle':circle, 'division':division, 'site_location':site_location, 'work_description':work_description, 'remark':remark});
                    weekly_plan_array.push(plan_array);
                    // formData.append('weekly_plan_array[]', JSON.stringify(plan_array));
                });

                /*console.log('weekly_plan_array:');
                console.log(weekly_plan_array);*/

                // return false;

                formData.append('weekly_plan_array', JSON.stringify(weekly_plan_array));
                /*console.log('formData:');
                console.log(formData);*/

                let form_url = $(weekly_plan_form).attr('action');
                // console.log('form_url: ' + form_url);

                // Ajax call to save the weekly plan
                $.ajax({
                    type: 'POST',
                    url: form_url,
                    // dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {

                    }
                });

                event.preventDefault();
            });

            function _actionsModeNormal(button) {
                $(button).parent().find('#bAcep').hide();
                $(button).parent().find('#bCanc').hide();
                $(button).parent().find('#bEdit').show();
                $(button).parent().find('#bDel').show();
                let $currentRow = $(button).parents('tr'); // get the row
                $currentRow.attr('data-status', ''); // remove editing status
            }

            function getModifiedDate(date) {
                var parts = date.split("-")
                return new Date(parts[2], parts[1] - 1, parts[0])
            }
        </script>
	</body>
</html>