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
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

        <!-- DATEPICKER CSS -->
        <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>

        <!-- MULTIPLE SELECT CSS -->
        <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.css">
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
                                                </div>                                                
                                                <div id="weeklyPlan" class="mt-3" hidden>
                                                    <!-- Row2 -->
                                                    <div class="row">
                                                        <!-- Weekly Plan Title -->
                                                        <div class="col-xl-12" style="text-align: center;" id="weeklyPlanHeading">
                                                            <h4>Weekly Plan <span>(15-01-2024 To 21-01-2024)</span></h4>
                                                        </div>    
                                                    </div> 

                                                    <!-- Loading Spinner -->
                                                    <div class="row plan-loader m-0 mt-2 mb-2" hidden>
                                                        <div class="d-flex align-items-center rounded-2 pt-1 pb-1" style="background: #efefef">
                                                            <strong class="plan-loader-message">Loading...</strong>
                                                            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                                        </div>  
                                                    </div>
                                                    <!-- Loading Spinner Ends -->

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
                                                                            <th>Date of Work</th>
                                                                            <th>Day</th>
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
                                                                            <td class="date-of-work"></td>
                                                                            <td class="day"></td>
                                                                            <td class="circle"></td>
                                                                            <td class="division"></td>
                                                                            <td class="feeder"></td>
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
                                                        <div class="col-xl-12 mt-3 mb-3" id="weekly-tkc-plan-form-btns">
                                                            <button type="submit" class="btn btn-warning" id="draft-plan" data-type="draft">Save as draft</button>
                                                            <button type="submit" class="btn btn-success" id="save-plan" data-type="submit">Submit</button>
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

        <!-- JQUERY UI JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

        <script type="text/javascript">
        	let packages = '<?php echo $packages ?>';
        	packages_arr = packages.split(',');

        	let circles = <?php echo json_encode($circles) ?>;

        	let divisions = <?php echo json_encode($divisions) ?>;
        </script>

        <!-- EDIT-TABLE JS -->
        <script src="<?php echo base_url('assets/plugins/edit-table/tkc-weekly-plan/tkc-weekly-plan.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/edit-table/tkc-weekly-plan/tkc-weekly-plan-edit-table.js'); ?>"></script>

        <!-- SWEET-ALERT JS -->
        <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

        <!-- DATERANGE PICKER JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- MULTIPLE SELECT JS -->
        <script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js"></script>

        <script type="text/javascript">
        	let weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];
            var form_change = false;

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

                    let fromDate = picker.startDate.format('DD-MM-YYYY');
                    let toDate = picker.endDate.format('DD-MM-YYYY');

                    // Check if weekly plan for selected date range already exists for logged in user
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('check-date-range-exists') ?>',
                        dataType: 'json',
                        data: {from_date: fromDate, to_date: toDate},
                        success: function(response) {
                            // console.log(response);

                            if (!$.isEmptyObject(response.date_range_result)) {
                                $('.toast-body').text('Weekly plan for selected date range already exists');
                                $('.toast').toast('show');

                                return false;
                            } else {
                                $('#weeklyPlan').attr('hidden', false);                                
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                        }
                    });
                } else {
                    $('.toast-body').text('Select a date range of 7 days starting from Monday');
                    $('.toast').toast('show');

                    $(this).val('');
                    $('#weeklyPlan').attr('hidden', true);

                    return false;
                }
            });

            function initializeDatepicker() {
            	let start_date = $('input[name="weeklyPlanDateRange"]').data('daterangepicker').startDate._d;
                let end_date = $('input[name="weeklyPlanDateRange"]').data('daterangepicker').endDate._d;

                $('input[name="weekDates"]').daterangepicker({
                    singleDatePicker: true,
                    autoUpdateInput: false,
                    minDate: start_date,
                    maxDate: end_date,
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                });

                $('input[name="weekDates"]').on('apply.daterangepicker', function(ev, picker) {
                    let selected_date = picker.startDate.format('DD-MM-YYYY');
                    $(this).val(selected_date);

                    let day = getModifiedDate(selected_date).getDay(); //Returns day of the week
                    let day_name = weekDays[day];
                    $('input[name="weekDay"]').val(day_name);
                    $('input[name="weekDay"]').prop('readonly', true);

                    form_change = true;
                });
            }

            $(document).on('change', 'select[name="circle"]', function(event) {
            	let selected_circle = $(this).val();
            	let division_arr = divisions[selected_circle];

            	let option_html = '';
                option_html += '<option value="select" selected disabled>Select Division</option>';

                $.each(division_arr, function(index, value) {
                    option_html += '<option value="'+value+'">'+value+'</option>';
                });

                $('select[name="division"]').empty().append(option_html);

                form_change = true;
            });

            $(document).on('change', 'select[name="division"]', function(event) {
            	let selected_division = $(this).val();

            	let selected_cirlce = $('select[name="circle"] option:selected').val();
            	
            	getFeedersList(selected_cirlce, selected_division);

                form_change = true;
            });

            function getFeedersList(circle_name, division_name) {
                // Ajax call to get list of feeders belonging to selected circle and division
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('get-feeders-list-tkc') ?>',
                    dataType: 'json',
                    data: {circle_name: circle_name, division_name: division_name},
                    success: function(response) {
                    	// console.log(response); 
                        let feeder_td = $('#new-add-weekly-tkc-plan-details > tbody > tr[data-status="editing"]').find('.feeder');
                        $(feeder_td).empty();

                        initializeMultipleSelect(response.feeder_list);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                    }
                });
            }

            function initializeMultipleSelect(feeder_list) {
                let feeder_td = $('#new-add-weekly-tkc-plan-details > tbody > tr[data-status="editing"]').find('.feeder');

                let feeder_html = '';

                feeder_html += '<select name="feeder" id="feeder"" multiple="multiple" class="form-control form-select">';
                feeder_html += '</select>';

                $(feeder_td).append(feeder_html);

                let options = {};
                let select_options = [];
                $.each(feeder_list, function(ind, val) {
                    options = {
                        text: val.feeder_id,
                        value: val.feeder_id
                    }

                    select_options.push(options);
                });

                $('select[name="feeder"]').multipleSelect({
                    filter: true,
                    data: select_options
                });

                form_change = true;
            }

            $('#table2-new-row-button-weekly-tkc-plan-details').click(function(event) {
                event.preventDefault();
            });

            $('#addTKCWeeklyPlan button[type="submit"]').click(function(event) {
                let selected_submit_btn = $(this).data('type');
                let weekly_plan_form = $('#addTKCWeeklyPlan')[0];

                let selected_date_range = $('input[name="weeklyPlanDateRange"]').val();

                let table_rows = $('#new-add-weekly-tkc-plan-details tbody').find('tr');

                if (selected_date_range == '') {
                    $('.toast-body').text('Select a date range of 7 days starting from Monday');
                    $('.toast').toast('show');

                    return false;
                } else if (form_change == false || table_rows.length == 0) {
                    $('.toast-body').text('Kindly enter plan for the entire week before submitting.');
                    $('.toast').toast('show');

                    return false;
                } else if (selected_submit_btn == 'submit') {
                    let no_values_count = 0;
                    let days_count = 7;

                    let days_arr = [];
                    $(table_rows).each(function(index, value){
                        days_arr.push($(value).find('td[class="day"]').text());
                    });

                    $.each(weekDays, function(index, value) {
                        if ($.inArray(value, days_arr) == -1) {
                            days_count--;
                        }
                    });

                    if (days_count != 7) {
                        $('.toast-body').text('Kindly enter plan for the entire week before submitting.');
                        $('.toast').toast('show');

                        return false;
                    } else if (days_count == 7) {
                        $(table_rows).each(function(index, value) {
                            $(value).find('td').each(function(ind, val){
                                if (ind == 0 || ind == 1 || ind == 2 || ind == 3 || ind == 4) {
                                    return
                                }

                                if ($(val).text() == '') {
                                    no_values_count++;
                                }
                            });
                        });

                        if (no_values_count > 0) {
                            $('.toast-body').text('Kindly fill data for weekly plan for the entire week before submitting.');
                            $('.toast').toast('show');

                            return false;
                        } else if (no_values_count == 0) {
                            saveWeeklyPlan(weekly_plan_form, selected_submit_btn);
                        }
                    }
                } else if (selected_submit_btn == 'draft') {
                    saveWeeklyPlan(weekly_plan_form, selected_submit_btn);
                }

                event.preventDefault();
            });

            function saveWeeklyPlan(weekly_plan_form, selected_submit_btn) {
                let form_btns = $(weekly_plan_form).find('#weekly-tkc-plan-form-btns .btn');

                $(form_btns).each(function(index, value) {
                    $(value).prop('disabled', true);
                });

                $('.plan-loader').removeAttr('hidden');
                $('.plan-loader').find('.plan-loader-message').html('Please wait while the system saves the TKC weekly plan.');

                let formData = new FormData(weekly_plan_form);

                let trs = $('#new-add-weekly-tkc-plan-details tbody').find('tr');

                let weekly_plan_array = [];
                
                $(trs).each(function(index, value) {
                    let tds = $(value).find('td');

                    let plan_array = new Object();

                    $(tds).each(function(ind, val) {
                        if (ind == 0) {
                            return;
                        }

                        let field = $(val).attr('class').replace(/-/g,'_');
                        plan_array[field] = $(val).text();
                    });

                    weekly_plan_array.push(plan_array);
                });

                formData.append('weekly_plan_array', JSON.stringify(weekly_plan_array));

                if (selected_submit_btn == 'submit') {
                    formData.append('is_draft', 0);
                } else if (selected_submit_btn == 'draft') {
                    formData.append('is_draft', 1);
                }

                let form_url = $(weekly_plan_form).attr('action');

                // Ajax call to save the weekly plan
                $.ajax({
                    type: 'POST',
                    url: form_url,
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // console.log(response); 

                        $('.plan-loader').attr('hidden', true);

                        $('.toast-body').text(response.message);
                        $('.toast').toast('show');

                        setTimeout(function() {
                            window.location.replace('<?php echo base_url('tkc-weekly-plan') ?>');
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                    }
                });
            }

            function getModifiedDate(date) {
                var parts = date.split("-")
                return new Date(parts[2], parts[1] - 1, parts[0])
            }
        </script>
	</body>
</html>