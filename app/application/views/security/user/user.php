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

        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/css/plugins.css');?>" rel="stylesheet">

        <!--- FONT-ICONS CSS -->
        <link href="<?php echo base_url('assets/css/icons.css');?>" rel="stylesheet">

        <!-- INTERNAL Switcher css -->
        <link href="<?php echo base_url('assets/switcher/css/switcher.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/switcher/demo.css');?>" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css');?>">
    </head>

    <body class="app sidebar-mini ltr light-mode">

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

                        <!-- CONTAINER -->
                        <div class="main-container container-fluid">

                            <!-- PAGE-HEADER -->
                            <div class="page-header">
                                <h1 class="page-title">Users</h1>
                                <div class="row">
                                    <div class="col-md-12 mt-2 mb-3">
                                        <?php if(user_module($access_key, 'add')) { ?>
                                        <a href="<?php echo base_url('users/add');?>" class="btn btn-success btn-add">Add</a>
                                          <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <!-- Search Block -->
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <?php $accordion_btn_class = (isset($filters)) ? 'filters-on' : '';
                                                              $accordion_btn_style = (isset($filters)) ? 'style="height:57px;"' : '';
                                                              $clear_btn_visibility = (isset($filters)) ? '' : 'hidden';
                                                        ?>
                                                        <button class="accordion-button collapsed active prog-btn <?php echo $accordion_btn_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" <?php echo $accordion_btn_style; ?>>
                                                            Search Users
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
                                                            <form name="search_user" id="search_user" action="<?php echo base_url('users')?>" method="get">
                                                                <!-- Row1 -->
                                                                <div class="row">
                                                                    <!-- Name -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="userName">Name</label>
                                                                            <input type="text" class="form-control" onpaste="changeFormStatus()" oninput="changeFormStatus()" name="userName" id="userName" value="<?php echo (isset($filters) && !empty($filters['userName']['value']) ? $filters['userName']['value'] : ''); ?>">
                                                                        </div>
                                                                    </div>
                                                                    <!-- Email -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="userEmail">Email</label>
                                                                            <input type="text" class="form-control" onpaste="changeFormStatus()" oninput="changeFormStatus()" name="userEmail" id="userEmail" value="<?php echo (isset($filters) && !empty($filters['userEmail']['value']) ? $filters['userEmail']['value'] : ''); ?>">
                                                                        </div>
                                                                    </div>
                                                                    <!-- Role -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="form-label m-0" for="userRole">Role</label>
                                                                            <select class="form-control form-select select2 select2-hidden-accessible" name="userRole" onchange="changeFormStatus()" data-bs-placeholder="Select Role" tabindex="-1" aria-hidden="true" id="userRole" style="width:100%">
                                                                                <option value="select" <?php echo (isset($filters) && !empty($filters['userRole']['id'])) ? '' : 'selected' ?> disabled>Select Role</option>
                                                                                <?php $selected_role = (isset($filters) && !empty($filters['userRole']['id'])) ? $filters['userRole']['id'] : ''; ?>
                                                                                <?php foreach ($roles as $role) { ?>
                                                                                <?php $selected = ($role->role_id == $selected_role) ? 'selected' : ''; ?>
                                                                                <option value="<?php echo $role->role_id;?>" <?php echo $selected; ?>><?php echo $role->name;?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Status -->
                                                                    <div class="col-md-3">
                                                                       <div class="form-group">
                                                                           <label class="form-label m-0" for="status">Status</label>
                                                                           <select multiple="multiple" class="filter-multi" name="status[]" id="status">
                                                                                <?php $selected_status = (isset($filters) && !empty($filters['status']['id'])) ? $filters['status']['id'] : ''; ?>
                                                                                <option value="1" <?php echo (is_array($selected_status) && in_array('1', $selected_status)) ? 'selected' : ''; ?>>Active</option>
                                                                                <option value="0" <?php echo (is_array($selected_status) && in_array('0', $selected_status)) ? 'selected' : ''; ?>>In-Active</option>
                                                                           </select>
                                                                       </div> 
                                                                    </div>
                                                                </div>
                                                                <!-- Row2 -->
                                                                <div class="row">
                                                                    <!-- Search Button -->
                                                                    <div class="col-md-3 mt-3">
                                                                        <button type="submit" class="btn btn-primary mt-1 mb-1 search-user-btn">Search</button>
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
                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p border-bottom-0">Actions</th>
                                                            <th class="wd-15p border-bottom-0">Name</th>
                                                            <th class="wd-25p border-bottom-0">E-mail</th>
                                                            <th class="wd-25p border-bottom-0">Contact</th>
                                                            <th class="wd-25p border-bottom-0">Designation</th>
                                                            <th class="wd-25p border-bottom-0">Location</th>
                                                            <th class="wd-25p border-bottom-0">Reporting Manager</th>
                                                            <th class="wd-15p border-bottom-0">Role</th>
                                                            <th class="wd-20p border-bottom-0">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php foreach($userslist as $list) { ?>
                                                        <tr>
                                                            <td>
                                                                 <?php if(user_module($access_key, 'view')) { ?>
                                                                <a href="<?php echo base_url();?>users/<?php echo $list->user_id;?>" class="btn btn-sm">
                                                                    <span class="fe fe-edit fa-lg action-btn-table"> </span>
                                                                </a>&nbsp;&nbsp;
                                                                  <?php } ?>
                                                                   <?php if(user_module($access_key, 'delete')) { ?>
                                                                <button  type="button" class="btn  btn-sm deleteuser"  id='<?php echo $list->user_id;?>'>
                                                                    <span class="fe fe-trash-2 fa-lg action-btn-table"> </span>
                                                                </button>
                                                                 <?php } ?>
                                                            </td>
                                                            <td><?php echo $list->username;?></td>
                                                            <td><?php echo $list->email;?></td>
                                                            <td><?php echo $list->contact_no;?></td>
                                                            <td><?php echo $list->designation;?></td>
                                                            <td><?php echo $list->location;?></td>
                                                            <td><?php echo $list->reportingto_user_name;?></td>
                                                            <td><?php echo $list->rolename;?></td>
                                                            <td>Active </td>
                                                        </tr>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->

                        </div>
                        <!-- CONTAINER CLOSED -->

                    </div>
                </div>
                <!--App-Content Ends -->
        </div>

       

      

        <!-- Footer -->
        <?php $this->load->view('include/side-bar');?>
        <!-- Footer Ends -->
    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <script>
            var baseUrl = "<?php echo base_url(); ?>";
            
            </script>


    <!-- JQUERY JS -->
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>

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

     <!-- DATA TABLE JS-->
    <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.buttons.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.bootstrap5.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/jszip.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/pdfmake.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/pdfmake/vfs_fonts.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.php5.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.print.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/js/buttons.colVis.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/table-data.js');?>"></script>


    <!-- SWEET-ALERT JS -->
    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/sweet-alert.js');?>"></script>

    <!-- MULTI JS -->
    <script src="<?php echo base_url('assets/plugins/multi/multi.min.js'); ?>"></script>

    <!-- MULTIPLE SELECT JS -->
    <script src="<?php echo base_url('assets/plugins/multipleselect/multiple-select.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/multipleselect/multi-select.js'); ?>"></script>
    
    <script>
        function resetform()
        {
           // alert($("#statusdb").val());
            $("#statusdb").php('<option value="">Select Status</option><option>Active</option> <option>In-active</option>');
            $("#roledb").php(' <option value="">Select Role</option><option>Admin</option> <option>Executive</option>');
        }

        let form_change = false;

        function changeFormStatus() {
            form_change = true;
        }

        $('#search_user').on('submit', function(event) {
            let inputs = $(this).find('input.form-control');
            $(inputs).each(function(index, value) {
                if ($(value).attr('value') != '') {
                    form_change = true;
                }
            });

            let selects = $(this).find('select.form-control');
            $(selects).each(function(index, value) {
                let selected_data = $(value).select2('data');
                if (!selected_data[0].text.includes('Select')) {
                    form_change = true;
                }
            });

            let multi_select = $(this).find('#status');
            if ($(multi_select).val().length > 0) {
                form_change = true;
            }

            if (form_change === false) {
                $('.toast-body').text('Select atleast one filter');
                $('.toast').toast('show');
                event.preventDefault(); 
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

            window.location.replace('<?php echo base_url("users") ?>');
        });
    </script>


</body>

</html>