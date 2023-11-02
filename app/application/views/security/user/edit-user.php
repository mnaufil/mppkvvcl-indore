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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/temp.css');?>">

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

label
{
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
     <div id="toasts"></div>
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="<?php echo base_url('assets/images/loader.svg');?>" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

                 <?php $this->load->view('include/header');?>
                 <?php $this->load->view('include/side-bar');?>


            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">

                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <h1 class="page-title">Users</h1>
                            <!-- <div>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a href="user.php">User list</a></li>
                                     <li class="breadcrumb-item active" aria-current="page">Add User</li>
                                </ol>
                            </div> -->
                        </div>
                        <!-- PAGE-HEADER END -->

                        <!-- ROW OPEN -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <!-- <div class="card-header">
                                        <h3 class="card-title">Add User</h3>
                    

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

                                    <div class="card-body mt-3">
                                        <form class="needs-validation" novalidate action="<?php echo base_url('update-users')?>" method="POST">
                                            <div class="form-row">
                                                <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom01" class="form-label">Name <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="<?php echo $singleUser->username?>" required name="name" onblur="charlimit('name', 100)">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                <input type="hidden" name="user_id" value="<?php echo $singleUser->user_id;?>">
                                                <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom02" class="form-label">Email Address  <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" id="email"
                                                        value="<?php echo $singleUser->email?>" required name="email" onblur="charlimit('email', 100)" onfocusout ="ValidateEmail(this.value)">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                 <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom02" class="form-label">Contact No  <span class="text-red">*</span></label>
                                                    <input type="number" class="form-control" id="contact"
                                                        value="<?php echo $singleUser->contact_no?>" required name="contact" onblur="charlimit('contact', 10)" onkeyup="intOnly('contact',this.value);">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                 <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom02" class="form-label">Designation  <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" id="designation"
                                                        value="<?php echo $singleUser->designation?>" required name="designation"  onblur="charlimit('designation', 100)">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                 <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom02" class="form-label">Location<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" id="location"
                                                        value="<?php echo $singleUser->location?>" required name="location" onblur="charlimit('location', 100)">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                 <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom02" class="form-label">Reporting Manager </label>
                                                   <!--  <input type="text" class="form-control" id="validationCustom02"
                                                        value="" required name="reportingManager"> -->

                                                        <select class="form-control select2-show-search form-select select2-hidden-accessible" id="reportingManager"
                                                        name="reportingManager">
                                                        <option selected disabled value="">Select </option>
                                                         <?php foreach($users as $user) { ?>
                                                            <option value="<?php echo $user->user_id;?>" <?php if($singleUser->reportingto_user_id == $user->user_id) { ?> selected <?php } ?>><?php echo $user->username;?></option>
                                                            <?php } ?>
                                                        

                                                    </select>
                                                    <div class="invalid-feedback">Please Select</div>
                                                </div>
                                                 <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom04" class="form-label">Role  <span class="text-red">*</span></label>
                                                    <select class="form-control select2" id="role"
                                                        required name="role">
                                                        <option selected disabled value="">Select Role</option>
                                                        <option value="">Select Role</option>
                                                        <!-- <option>Admin</option>
                                                        <option>Field Engineers</option>
                                                        <option>Field Supervisor</option>
                                                        <option>Key Experts</option>
                                                        <option>Clients</option> -->
                                                        <?php foreach($roles as $role) { ?>
                                                            <option value="<?php echo $role->role_id;?>" <?php if($singleUser->role_id == $role->role_id) { ?> selected <?php } ?>><?php echo $role->name;?></option>
                                                            <?php } ?>

                                                    </select>
                                                    <div class="invalid-feedback">Please select Role</div>
                                                </div>
                                                 <!-- <div class="col-xl-4 mb-3">
                                                    <label for="validationCustom02" class="form-label">System Details  <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" id="validationCustom02"
                                                        value="" required>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div> -->
                                                 <div class="col-xl-12 mb-3">
                                                    <label for="validationCustom02" class="form-label">Site Grant Access <span class="text-red">*</span></label>
                                                   <div class="form-row">
                                                <!--div class="col-xl-4 mb-3">
                                                    <label class="custom-control custom-radio-md"> 
                                                    <input type="radio" class="custom-control-input" name="example-radios1" value="single"> <span class="custom-control-label">Single</span> </label>
                                                </div>
                                                <div class="col-xl-4 mb-3">
                                                    <label class="custom-control custom-radio-md"> 
                                                    <input type="radio" class="custom-control-input" name="example-radios1" value="multiple"> <span class="custom-control-label">Multiple</span> </label>
                                                </div-->



        <ul class="treeview">
           
            <?php foreach ($regions as $region) {?>
                <li>
                    <?php $regionCheckboxesName = "regions[]";?>
                <input type="checkbox" name=<?php echo $regionCheckboxesName; ?> value="<?php echo $region->region_id;?>" <?php echo in_array($region->region_id,$selectedRegionsArray) ? "checked" : ""; ?>>
                
                <label  class="<?php echo in_array($region->region_id,$selectedRegionsArray) ? "custom-checked" : "custom-unchecked"; ?>"><?php echo $region->region_name;?></label>


                    <?php foreach ($circles as $circle) {?>

                        <?php if($circle->region_id == $region->region_id) { ?>

                            <ul>
                                <li>
                                    <?php $circleCheckboxesName = "circles".$region->region_id."[]";?>
                            <input type="checkbox" name=<?php echo $circleCheckboxesName; ?> value="<?php echo $circle->circle_id;?>" <?php echo in_array($circle->circle_id,$selectedCirclesArray) ? "checked" : ""; ?>>

                                 <label  class="<?php echo in_array($circle->circle_id,$selectedCirclesArray) ? "custom-checked" : "custom-unchecked"; ?>"><?php echo $circle->circle_name;?></label>           

                                    <?php foreach ($divisions as $division) {?>

                                        <?php if($division->circle_id == $circle->circle_id) { ?>

                                             <ul>
                                                 <?php $divisionCheckboxesName = "divisions".$circle->circle_id."[]";?>
                                                 <li>
                                   <input type="checkbox" name=<?php echo $divisionCheckboxesName; ?> value="<?php echo $division->division_id;?>" <?php echo in_array($division->division_id,$selectedDivisionsArray) ? "checked" : ""; ?>>
                                 <label  class="<?php echo in_array($division->division_id,$selectedDivisionsArray) ? "custom-checked" : "custom-unchecked"; ?>"><?php echo $division->division_name;?></label>
                                               </li>
                                            </ul>

                                        <?php } ?>

                                    <?php } ?>

                                </li>
                            </ul>

                        <?php } ?>

                    <?php } ?>              

                </li>
          <?php } ?>
                           
                            
        </ul>




                         <!--  <ul class="treeview">
                            <li>
                                 <input type="checkbox">
                                  <label  class="custom-unchecked">1</label>
                                  <ul>
                                    <li>
                                        <input type="checkbox">
                                        <label  class="custom-unchecked">1.1</label>
                                    </li>
                                    <li>
                                        <input type="checkbox">
                                        <label  class="custom-unchecked">1.2</label>
                                    </li>
                                     <li>
                                        <input type="checkbox">
                                        <label  class="custom-unchecked">1.3</label>
                                        <ul>
                                            <li>
                                                <input type="checkbox">
                                        <label  class="custom-unchecked">1.3.1</label>
                                            </li>
                                            <li>
                                                <input type="checkbox">
                                        <label  class="custom-unchecked">1.3.2</label>
                                            </li>
                                        </ul>
                                    </li>
                                  </ul>
                            </li>
                             <li>
                                 <input type="checkbox">
                                  <label  class="custom-unchecked">2</label>
                              </li>
                          </ul> -->
                                                
                                                 <!-- <ul class="treeview">
        <li>
            <input type="checkbox" name="tall" id="tall">
            <label for="tall" class="custom-unchecked">Jabalpur</label>
            
            <ul>
                 <li>
                     <input type="checkbox" name="tall-1" id="tall-1">
                     <label for="tall-1" class="custom-unchecked">Jabalpur City</label>
                     <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">City Dn East </label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">City Dn West</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">City Dn North</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">City Dn South</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Vijay Nagar</label>
                         </li>
                          
                     </ul>
                 </li>
                 <li>
                     <input type="checkbox" name="tall-2" id="tall-2">
                     <label for="tall-2" class="custom-unchecked">Jabalpur O&M </label>
                         <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">Patan</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Jabalpur O&M </label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Sihora</label>
                         </li>
                     </ul>
                 </li>
                 <li>
                             <input type="checkbox" name="tall-2-1" id="tall-2-1">
                             <label for="tall-2-1" class="custom-unchecked">Katni</label>
                              <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">Katni City</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Katni O&M</label>
                         </li>
                          
                     </ul>
                 </li>
                 <li class="last">
                     <input type="checkbox" name="tall-2-2" id="tall-2-2">
                     <label for="tall-2-2" class="custom-unchecked">Mandla</label>
                        <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">Mandla O&M</label>
                         </li>
                         
                     </ul>
                    </li>
                          <li class="last">
                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
                             <label for="tall-2-2" class="custom-unchecked">Narsinghpur</label>
                              <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">Narsinghpur</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Gadarwara</label>
                         </li>
                         
                     </ul>
                         </li>
                          <li class="last">
                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
                             <label for="tall-2-2" class="custom-unchecked">Seoni</label>
                              <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">Seoni</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Lakhnadon</label>
                         </li>
                         
                     </ul>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
                             <label for="tall-2-2" class="custom-unchecked">Balaghat</label>
                              <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked">Waraseoni</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Baihar</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Balaghat O&M</label>
                         </li>
                          
                     </ul>
                         </li>
                         
                          <li class="last">
                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
                             <label for="tall-2-2" class="custom-unchecked">Chhindwara</label>
                              <ul>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3">
                             <label for="tall-2-1" class="custom-unchecked"> Chhindwara City</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Amarwada</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Parasia </label>
                         </li>
                         
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Pandhurna </label>
                         </li>
                         
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Junnardev  </label>
                         </li>
                         
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Chhindwara East </label>
                         </li>
                         
                          <li>
                             <input type="checkbox" name="tall-3" id="tall-3-1">
                             <label for="tall-2-1" class="custom-unchecked">Chourai </label>
                         </li>
                          
                     </ul>
                         </li>
            </ul>
        </li>
        
         <li>
            <input type="checkbox" name="tall-1-shahdol" id="tall-1-shahdol">
            <label for="tall-1-shahdol" class="custom-unchecked">Shahdol</label>
            
            <ul>
                 
                 <li>
                     <input type="checkbox" name="tall-2" id="tall-1-2">
                     <label for="tall-2" class="custom-unchecked">Shahdol</label>
                    <ul>
                    <li>
                     <input type="checkbox" name="tall-2-1-1" id="tall-1-3-1">
                     <label for="tall-1-3-1" class="custom-unchecked">Shahdol Circle</label>
                    </li>
                    </ul>
                 </li>
                 <li>
                     <input type="checkbox" name="tall-annu" id="tall-annu">
                     <label for="tall-annu" class="custom-unchecked">Anuppur</label>
                     <ul>
                    <li>
                     <input type="checkbox" name="tall-2-1-annu" id="tall-1-3-annu">
                     <label for="tall-1-3-annu" class="custom-unchecked">Anuppur</label>
                    </li>
                    </ul>
                 </li>
                 
                 <li>
                     <input type="checkbox" name="tall-2-uma" id="tall-1-uma">
                     <label for="tall-1-uma" class="custom-unchecked">Umariya</label>
                     <ul>
                    <li>
                     <input type="checkbox" name="tall-2-1-uma" id="tall-1-3-uma">
                     <label for="tall-1-3-uma" class="custom-unchecked">Umariya</label>
                    </li>
                    </ul>
                 </li>
                 
                 <li>
                     <input type="checkbox" name="tall-2-1-din" id="tall-1-3-din">
                     <label for="tall-1-3-din" class="custom-unchecked">Dindori</label>
                     
                     <ul>
                    <li>
                     <input type="checkbox" name="tall-2-1-umaom" id="tall-1-3-umaom">
                     <label for="tall-1-3-umaom" class="custom-unchecked">Dindori O&M </label>
                    </li>
                    </ul>
                 </li>
                         
            </ul>
        </li>
        
        <li>
            <input type="checkbox" name="tall" id="tall">
            <label for="tall" class="custom-unchecked">Sagar</label>
            
            <ul>
                 <li>
                     <input type="checkbox" name="tall-1" id="tall-1">
                     <label for="tall-1" class="custom-unchecked">Sagar</label>
                 </li>
                 <li>
                     <input type="checkbox" name="tall-2" id="tall-2">
                     <label for="tall-2" class="custom-unchecked">Damoh</label>
                    
                 </li>
                 <li>
                             <input type="checkbox" name="tall-2-1" id="tall-2-1">
                             <label for="tall-2-1" class="custom-unchecked">Tikamgarh</label>
                         </li>
                         <li class="last">
                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
                             <label for="tall-2-2" class="custom-unchecked">Chhatarpur</label>
                         </li>
                          <li class="last">
                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
                             <label for="tall-2-2" class="custom-unchecked">Panna</label>
                         </li>
                         
            </ul>
        </li>
        
        
        <li class="last">
            <input type="checkbox" name="short" id="short">
            <label for="short" class="custom-unchecked">Sagar</label>
            
            <ul>
                
                 <li>
                     <input type="checkbox" name="tall-2-sagar" id="tall-2-sagar">
                     <label for="tall-2-sagar" class="custom-unchecked">Sagar </label>
                     <ul>
                        <li>
                             <input type="checkbox" name="tall-2-damoh-sagar-city" id="tall-2-damoh-sagar-city">
                             <label for="tall-2-damoh-sagar-city" class="custom-unchecked">Sagar City</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-2-damoh-sagar-om" id="tall-2-damoh-sagar-om">
                             <label for="tall-2-damoh-sagar-om" class="custom-unchecked">Sagar O&M </label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-2-damoh-banda" id="tall-2-damoh-banda">
                             <label for="tall-2-damoh-banda" class="custom-unchecked">Banda</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-2-damoh-khurai" id="tall-2-damoh-khurai">
                             <label for="tall-2-damoh-khurai" class="custom-unchecked">Khurai</label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-2-damoh-bina" id="tall-2-damoh-bina">
                             <label for="tall-2-damoh-bina" class="custom-unchecked">Bina</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-2-damoh-rehli" id="tall-2-damoh-rehli">
                             <label for="tall-2-damoh-rehli" class="custom-unchecked">Rehli</label>
                         </li>
                     </ul>
                 </li>
                 <li>
                             <input type="checkbox" name="tall-2-damoh" id="tall-2-damoh">
                             <label for="tall-2-damoh" class="custom-unchecked">Damoh</label>
                             <ul>
                                 <li>
                             <input type="checkbox" name="tall-2-damoh-n" id="tall-2-damoh-n">
                             <label for="tall-2-damoh-n" class="custom-unchecked">Damoh (N)</label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-2-damoh-s" id="tall-2-damoh-s">
                             <label for="tall-2-damoh-s" class="custom-unchecked">Damoh (S)</label>
                         </li>
                             </ul>
                         </li>
                         <li class="last">
                             <input type="checkbox" name="tall-2-tika" id="tall-2-tika">
                             <label for="tall-2-tika" class="custom-unchecked">Tikamgarh</label>
                             <ul>
                             <li>
                             <input type="checkbox" name="tall-2-Niwari " id="tall-2-Niwari ">
                             <label for="tall-2-Niwari " class="custom-unchecked">Niwari </label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-2-Tikamgarh " id="tall-2-Tikamgarh ">
                             <label for="tall-2-Tikamgarh " class="custom-unchecked">Tikamgarh </label>
                         </li>
                             </ul>
                         </li>
                          <li class="last">
                             <input type="checkbox" name="tall-2-chat" id="tall-2-chat">
                             <label for="tall-2-chat" class="custom-unchecked">Chhatarpur</label>
                             <ul>
                             <li>
                             <input type="checkbox" name="tall-2-Bijawar " id="tall-2-Bijawar ">
                             <label for="tall-2-Bijawar " class="custom-unchecked">Bijawar </label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-2-Chhatarpur " id="tall-2-Chhatarpur ">
                             <label for="tall-2-Chhatarpur " class="custom-unchecked">Chhatarpur </label>
                         </li>
                         <li>
                             <input type="checkbox" name="tall-2-Khajuraho " id="tall-2-Khajuraho ">
                             <label for="tall-2-Khajuraho " class="custom-unchecked">Khajuraho </label>
                         </li>
                             </ul>
                         </li>
                          <li class="last">
                             <input type="checkbox" name="tall-2-panna" id="tall-2-panna">
                             <label for="tall-2-panna" class="custom-unchecked">Panna</label>
                             <ul>
                             <li>
                             <input type="checkbox" name="tall-2-1-Panna" id="Panna">
                             <label for="Panna" class="custom-unchecked">Panna </label>
                         </li>
                          <li>
                             <input type="checkbox" name="tall-2-Pawai" id="tall-2-Pawai">
                             <label for="tall-2-Pawai" class="custom-unchecked">Pawai</label>
                         </li>
                        
                             </ul>
                         </li>
                          
            </ul>
        </li>
    </ul> -->
                                                
                                                
                                                </div>
                                                
                                                
                                                </div>

                                                <!-- <div class="card-body">
                                                    <p>Select <code class="highlighter-rouge">checkboxes</code>below to give access to paricular user</p>
                                        <div class="table-responsive">
                                            <table class="table text-nowrap text-md-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Module Name</th>
                                                        <th>Full access</th>
                                                        <th>View</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                        <th>Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Dashboard</td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                    </tr>
                                                   
                                                    <tr>
                                                        <td>Users</td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                    </tr>
                                                     <tr>
                                                        <td>Activity Log</td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                    </tr>
                                                   
                                                     <tr>
                                                        <td>Change Password</td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                        <td><input type="checkbox"></td>
                                                    </tr>
                                                     

                                                </tbody>
                                            </table>
                                        </div>
                                                </div> -->

                                            </div>
                                           
                                            <div class="form-row">
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



<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Set Roles</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
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

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Update</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



                         <!-- Row -->
                        
                        <!-- End Row -->
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!--app-content closed-->
        </div>

       
        

                  <?php $this->load->view('include/side-bar');?>

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
    <!--script src="<?php echo base_url('assets/plugins/bootstrap5-typehead/autocomplete.js');?>"></script>
    <script src="<?php echo base_url('assets/js/typehead.js');?>"></script-->
    
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
    <!--script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/sweet-alert.js');?>"></script-->
    
    <script>
    $(function() {

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
});
    </script>


</body>

</html>