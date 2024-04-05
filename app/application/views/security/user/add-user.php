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
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/brand/favicon.ico');?>">

        <!-- TITLE -->
        <title>MPPKVVCL - Users</title>

        <!-- BOOTSTRAP CSS -->
        <link id="style" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">

        <!-- STYLE CSS -->
        <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/toast.css');?>" rel="stylesheet">

        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/css/plugins.css');?>" rel="stylesheet">

        <!--- FONT-ICONS CSS -->
        <link href="<?php echo base_url('assets/css/icons.css');?>" rel="stylesheet">

        <!-- INTERNAL Switcher css -->
        <link href="<?php echo base_url('assets/switcher/css/switcher.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/switcher/demo.css');?>" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css');?>">
         
        <style>
            #page-wrap {
              margin: auto 0;
            }

            .treeview {
              margin: 10px 0 0 20px;
            }

            ul { 
              list-style: none;
            }

            .treeview li {
              background: url(http://jquery.bassistance.de/treeview/images/treeview-default-line.gif) 0 0 no-repeat;
              padding: 2px 0 2px 16px;
            }

            .treeview > li:first-child > label {
              /* style for the root element - IE8 supports :first-child
              but not :last-child ..... */
            }

            .treeview li.last {
              background-position: 0 -1766px;
            }

            .treeview li > input {
              height: 16px;
              width: 16px;
              /* hide the inputs but keep them in the layout with events (use opacity) */
              opacity: 0;
              filter: alpha(opacity=0); /* internet explorer */ 
              -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)"; /*IE8*/
            }

            .treeview li > label {
              background: url(https://www.thecssninja.com/demo/css_custom-forms/gr_custom-inputs.png) 0 -1px no-repeat;
              /* move left to cover the original checkbox area */
              margin-left: -20px;
              /* pad the text to make room for image */
              padding-left: 20px;
            }

            /* Unchecked styles */

            label {
                margin-block-end:0.1rem
            }

            .treeview .custom-unchecked {
              background-position: 0 1px;
            }

            .treeview .custom-unchecked:hover {
              background-position: 0 -21px;
            }

            /* Checked styles */

            .treeview .custom-checked { 
              background-position: 0 -81px;
            }

            .treeview .custom-checked:hover { 
              background-position: 0 -101px; 
            }

            /* Indeterminate styles */

            .treeview .custom-indeterminate { 
              background-position: 0 -141px; 
            }

            .treeview .custom-indeterminate:hover { 
              background-position: 0 -121px; 
            }
        </style>
    </head>

    <body class="app sidebar-mini ltr light-mode">
        <!-- <div id="toasts"></div> -->
        <!-- GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="<?php echo base_url('assets/images/loader.svg');?>" class="loader-img" alt="Loader">
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
                                <h1 class="page-title">Users</h1>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW OPEN -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <?php  if($this->session->flashdata('error')) { ?>
                                            <div class="alert alert-primary" role="alert"> 
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                                <p style="color:red"><?php  echo $this->session->flashdata('error');?></p>
                                            </div>
                                        <?php } ?>

                                        <?php  if($this->session->flashdata('success')) { ?>
                                            <div class="alert alert-primary" role="alert"> 
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                                <p style="color:green"><?php  echo $this->session->flashdata('success');?></p>
                                            </div>
                                        <?php } ?>

                                        <div class="card-body mt-3">
                                            <form action="<?php echo base_url('add-users')?>" method="POST" id="saveUser">
                                                <div class="form-row">
                                                    <!-- Name -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="name" class="form-label">Name <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="name"
                                                            value="" name="name" onblur="charlimit('name', 100)">
                                                    </div>
                                                    <!-- Email Address -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="email" class="form-label">Email Address  <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="email" value="" name="email" onblur="charlimit('email', 100)">
                                                    </div>
                                                    <!-- Contact No -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="contact" class="form-label">Contact No  <span class="text-red">*</span></label>
                                                        <input type="tel" class="form-control" id="contact" value="" name="contact" onblur="charlimit('contact', 10)" onkeyup="intOnly('contact',this.value);">
                                                    </div>
                                                    <!-- Designation -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="designation" class="form-label">Designation  <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="designation" value="" name="designation" onblur="charlimit('designation', 100)">
                                                    </div>
                                                    <!-- Location -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="location" class="form-label">Location<span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" id="location" value="" name="location"  onblur="charlimit('location', 100)">
                                                    </div>
                                                    <!-- Reporting Manager -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="reportingManager" class="form-label">Reporting Manager </label>
                                                        <select class="form-control select2-show-search form-select select2-hidden-accessible" id="reportingManager" name="reportingManager">
                                                            <option selected disabled value="">Select Reporting Manager</option>
                                                            <?php foreach($users as $user) { ?>
                                                            <option value="<?php echo $user->user_id;?>"><?php echo $user->username;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- Role -->
                                                    <div class="col-xl-4 mb-3">
                                                        <label for="role" class="form-label">Role  <span class="text-red">*</span></label>
                                                        <select class="form-control select2" id="role" name="role">
                                                            <option selected disabled value="">Select Role</option>
                                                            <?php foreach($roles as $role) { ?>
                                                            <option value="<?php echo $role->role_id;?>"><?php echo $role->name;?></option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- Package Grant Access -->
                                                    <div class="col-xl-4 mb-3" id="package_access_div" hidden>
                                                        <div class="form-group">
                                                            <label class="form-label" for="">Package Grant Access <span class="text-red">*</span></label>
                                                            <select multiple="multiple" class="filter-multi" name="package_access[]" id="package_access">
                                                                <?php foreach ($packages as $key => $value) { ?>
                                                                    <option value="<?php echo $value['package_group_no']; ?>"><?php echo $value['package_group_no']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Site Grant Access -->
                                                    <div class="col-xl-12 mb-3" id="site_access_div" hidden>
                                                        <label for="validationCustom02" class="form-label">Site Grant Access <span class="text-red">*</span></label>
                                                        <div class="form-row">
                                                            <ul class="treeview">
                                                                <?php foreach ($regions as $region) {?>
                                                                <li>
                                                                    <?php $regionCheckboxesName = "regions[]";?>
                                                                    <input type="checkbox" name=<?php echo $regionCheckboxesName; ?> value="<?php echo $region->region_id;?>">
                                                                    <label  class="custom-unchecked"><?php echo $region->region_name;?></label>
                                                                    
                                                                    <?php   foreach ($circles as $circle) {
                                                                                if($circle->region_id == $region->region_id) {
                                                                    ?>
                                                                    <ul>
                                                                        <li>
                                                                            <?php $circleCheckboxesName = "circles".$region->region_id."[]";?>
                                                                            <input type="checkbox" name=<?php echo $circleCheckboxesName; ?> value="<?php echo $circle->circle_id;?>">
                                                                            <label  class="custom-unchecked"><?php echo $circle->circle_name;?></label>
                                                                            <?php   foreach ($divisions as $division) {
                                                                                        if($division->circle_id == $circle->circle_id) {
                                                                            ?>
                                                                            <ul>
                                                                                <?php $divisionCheckboxesName = "divisions".$circle->circle_id."[]";?>
                                                                                <li>
                                                                                    <input type="checkbox" name=<?php echo $divisionCheckboxesName; ?> value="<?php echo $division->division_id;?>">
                                                                                    <label  class="custom-unchecked"><?php echo $division->division_name;?></label>
                                                                                </li>
                                                                            </ul>
                                                                            <?php       }
                                                                                    }
                                                                            ?>
                                                                        </li>
                                                                    </ul>
                                                                    <?php       }
                                                                            }
                                                                    ?>
                                                                </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                        <input type="hidden" name="full_site_access" value="0">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-row">
                                                    <!-- Submit -->
                                                    <div class="col-xl-6  mb-3 mt-4">
                                                        <button class="btn btn-success" type="submit">Submit</button>
                                                        <a class="btn btn-primary" href="<?php echo base_url();?>users">Back</a>        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW CLOSED -->

                        </div>
                        <!-- CONTAINER CLOSED -->

                    </div>
                </div>
                <!--app-content closed-->
            </div>        

            <!-- Footer -->
            <?php $this->load->view('include/footer');?>
            <!-- Footer Ends -->
        </div>

        <!-- BACK-TO-TOP -->
        <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

        <!-- JQUERY JS -->
        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>

        <!-- BOOTSTRAP JS -->
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>

        <!-- INPUT MASK JS-->
        <script src="<?php echo base_url('assets/plugins/input-mask/jquery.mask.min.js');?>"></script>

        <!-- TypeHead js -->
        <!--script src="<?php //echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js');?>"></script>
        <script src="<?php //echo base_url('assets/js/typehead.js');?>"></script-->
        
        <script src="<?php echo base_url('assets/plugins/fancyuploder/jquery.ui.widget.js');?>"></script>

        <!-- SELECT2 JS -->
        <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
        
        <script src="<?php echo base_url('assets/js/select2.js');?>"></script>

        <!-- FORMVALIDATION JS -->
        <script src="<?php echo base_url('assets/js/form-validation.js');?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/bootstrap-daterangepicker/moment.min.js');?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/sumoselect/jquery.sumoselect.js');?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/jQuerytransfer/jquery.transfer.js');?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/multi/multi.min.js');?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/date-picker/jquery-ui.js');?>"></script>
        
        <script src="<?php echo base_url('assets/plugins/intl-tel-input-master/utils.js');?>"></script>

        <!-- Perfect SCROLLBAR JS-->
        <script src="<?php echo base_url('assets/plugins/p-scroll/perfect-scrollbar.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/p-scroll/pscroll-1.js');?>"></script>

        <!-- SIDE-MENU JS -->
        <script src="<?php echo base_url('assets/plugins/sidemenu/sidemenu.js');?>"></script>

        <!-- SIDEBAR JS -->
        <script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js');?>"></script>
        
        <script src="<?php echo base_url('assets/js/formelementadvnced.js');?>"></script>
        
        <script src="<?php echo base_url('assets/js/form-elements.js');?>"></script>
        
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

        <script src="<?php echo base_url('assets/plugins/edit-table/contract/contract-session.js');?>"></script>

        <!-- SWEET-ALERT JS -->
        <!--script src="<?php //echo base_url('assets/plugins/sweet-alert/sweetalert.min.js');?>"></script>
        <script src="<?php //echo base_url('assets/js/sweet-alert.js');?>"></script-->

        <!-- MULTI JS -->
        <script src="<?php echo base_url('assets/plugins/multi/multi.min.js'); ?>"></script>

        <!-- MULTIPLE SELECT JS -->
        <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script>
    
        <script>
            $(function() {
                var form_change = false;
                var email_exists = false;

                // Site Grant Access Script
                $('input[type="checkbox"]').change(checkboxChanged);

                function checkboxChanged() {
                    var $this = $(this),
                        checked = $this.prop("checked"),
                        container = $this.parent(),
                        siblings = container.siblings();

                        container.find('input[type="checkbox"]')
                        .prop({
                            indeterminate: false,
                            checked: checked
                        })
                        .siblings('label')
                        .removeClass('custom-checked custom-unchecked custom-indeterminate')
                        .addClass(checked ? 'custom-checked' : 'custom-unchecked');

                    checkSiblings(container, checked);
                }

                function checkSiblings($el, checked) {
                var parent = $el.parent().parent(),
                    all = true,
                    indeterminate = false;

                $el.siblings().each(function() {
                    return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                });

                if (all && checked) {
                parent.children('input[type="checkbox"]')
                    .prop({
                        indeterminate: false,
                        checked: checked
                    })
                    .siblings('label')
                    .removeClass('custom-checked custom-unchecked custom-indeterminate')
                    .addClass(checked ? 'custom-checked' : 'custom-unchecked');

                    checkSiblings(parent, checked);
                } 
                else if (all && !checked) {
                    indeterminate = parent.find('input[type="checkbox"]:checked').length > 0;

                    parent.children('input[type="checkbox"]')
                          .prop("checked", checked)
                          .prop("indeterminate", indeterminate)
                          .siblings('label')
                          .removeClass('custom-checked custom-unchecked custom-indeterminate')
                          .addClass(indeterminate ? 'custom-indeterminate' : (checked ? 'custom-checked' : 'custom-unchecked'));

                    checkSiblings(parent, checked);
                }
                else {
                    $el.parents("li").children('input[type="checkbox"]')
                       .prop({
                            indeterminate: true,
                            checked: false
                        })
                        .siblings('label')
                        .removeClass('custom-checked custom-unchecked custom-indeterminate')
                        .addClass('custom-indeterminate');
                    }
                }
                // Site Grant Access Script Ends

                $('#role').on('change', function() {
                    let selected_role = $('#role').find('option:selected').text();

                    if (selected_role == 'TKC') {
                        if ((typeof $('#package_access_div').attr('hidden') !== 'undefined') && ($('#package_access_div').attr('hidden') !== false)) {
                            $('#package_access_div').attr('hidden', false);
                        }

                        if ((typeof $('#site_access_div').attr('hidden') == 'undefined')) {
                            $('#site_access_div').attr('hidden', true);
                        }
                    } else {
                        if ((typeof $('#site_access_div').attr('hidden') !== 'undefined') && ($('#site_access_div').attr('hidden') !== false)) {
                            $('#site_access_div').attr('hidden', false);
                        }

                        if ((typeof $('#package_access_div').attr('hidden') == 'undefined')) {
                            $('#package_access_div').attr('hidden', true);
                        }
                    }

                    // form_change = true;
                });

                $('input[name="email"]').focusout(function() {
                    let user_email = $(this).val();
                    if (user_email != '' && isEmail(user_email)) {
                        checkEmailExist(user_email);
                        setTimeout(function() {
                            if (email_exists == true) {
                                $('.toast-body').text('Email already exist');
                                $('.toast').toast('show');
                            }
                        }, 1000);
                    }
                });

                $('#saveUser').on('submit', function(event) {
                    let user_name = $('input[name="name"]').val();
                    let user_email = $('input[name="email"]').val();
                    let user_contact = $('input[name="contact"]').val();
                    let user_designation = $('input[name="designation"]').val();
                    let user_location = $('input[name="location"]').val();
                    let user_role = $('#role').find('option:selected').text();

                    if (user_email != '' && !isEmail(user_email)) {
                        $('.toast-body').text('Enter valid email');
                        $('.toast').toast('show');
                        return false;
                        event.preventDefault();
                    } 

                    if (user_contact != '') {
                        if (!isMobileNumber(user_contact)) {
                            $('.toast-body').text('Enter valid contact number. Only digits allowed.');
                            $('.toast').toast('show');
                            return false;
                            event.preventDefault();
                        } else if (user_contact.length != 10) {
                            $('.toast-body').text('Enter 10 digit contact number.');
                            $('.toast').toast('show');
                            return false;
                            event.preventDefault();
                        }
                    }

                    if (user_name == '') {
                        $('.toast-body').text('Enter Name');
                        $('.toast').toast('show');
                        event.preventDefault();
                    } else if (user_email == '') {
                        $('.toast-body').text('Enter Email');
                        $('.toast').toast('show');
                        event.preventDefault();
                    } else if (user_contact == '') {
                        $('.toast-body').text('Enter Contact');
                        $('.toast').toast('show');
                        event.preventDefault();
                    } else if (user_designation == '') {
                        $('.toast-body').text('Enter Designation');
                        $('.toast').toast('show');
                        event.preventDefault();
                    } else if (user_location == '') {
                        $('.toast-body').text('Enter Location');
                        $('.toast').toast('show');
                        event.preventDefault();
                    } else if (user_role == 'Select Role') {
                        $('.toast-body').text('Select Role');
                        $('.toast').toast('show');
                        event.preventDefault();
                    } else if (user_role != '' && user_role == 'TKC') {
                        let tkc_package = $('#package_access').find('option:selected').text();
                        if (tkc_package == '') {
                            $('.toast-body').text('Grant Package Access');
                            $('.toast').toast('show');
                            return false;
                            event.preventDefault();
                        }
                    } else if (user_role != '' && user_role != 'TKC') {
                        let region_checkboxes = $('input[name="regions[]"]');
                        let region_checkboxes_selected = $('input[name="regions[]"]:checked');

                        let circle_checkboxes = $('input[name^="circles"]');
                        let circle_checkboxes_selected = $('input[name^="circles"]:checked');

                        let division_checkboxes = $('input[name^="divisions"]');
                        let division_checkboxes_selected = $('input[name^="divisions"]:checked');

                        if (region_checkboxes_selected.length == 0) {
                            $('.toast-body').text('Grant Site Access');
                            $('.toast').toast('show');
                            return false;
                            event.preventDefault();
                        }

                        if ((region_checkboxes.length == region_checkboxes_selected.length) && (circle_checkboxes.length == circle_checkboxes_selected.length) && (division_checkboxes.length == division_checkboxes_selected.length)) 
                        {
                            $('input[name="full_site_access"]').val(1);

                        }
                    }

                    if (form_change === false) {
                        checkEmailExist(user_email);

                        if (email_exists == true) {
                            $('.toast-body').text('Email already exist');
                            $('.toast').toast('show');

                            return false;
                            event.preventDefault();    
                        }
                    }
                });

                function checkEmailExist(user_email) {
                    // action = 'add';
                    // Ajax call to check if email already exists
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('check-user-exists'); ?>',
                        dataType: 'json',
                        data: {email:user_email, action:action},
                        success: function(response) {
                            if (!$.isEmptyObject(response)) {
                                form_change = false;
                                email_exists = true;
                            } else {
                                form_change = true;
                                email_exists = false;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            return false;
                            event.preventDefault();
                        }
                    });
                }

                function isEmail(email) {
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return regex.test(email);
                }

                function isMobileNumber(number) {
                    var regex = /^\d*(?:\.\d{1,2})?$/;
                    return regex.test(number);
                }
            });
        </script>
    </body>

</html>