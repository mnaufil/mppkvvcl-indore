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
	    <title>MPPKVVCL - Add Activity</title>

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
	                            <h1 class="page-title">List of Activity</h1>
	                        </div>
	                        <!-- PAGE-HEADER END -->

	                        <!-- ROW OPEN -->
	                        <div class="row">
                            	<div class="col-lg-12">
                                	<div class="card">
                                    	<div class="card-body mt-3">
                                        	<form method="post" id="save_activity" name="save_activity" action="<?php echo base_url('save-activity'); ?>">
                                        		<!-- Type of Work -->
                                            	<div class="form-row">
                                                	<div class="col-xl-4 mb-3">
                                                    	<label for="typeOfWork" class="form-label">Type of work <span class="text-red">*</span></label>
                                                    	<select class="form-control select2" id="typeOfWork" name="typeOfWork" 
                                                        required disabled>
                                                        	<option selected><?php echo $typeofwork_name; ?></option>
	                                                    </select>
                                                	</div>
                                            	</div>
												<div class="row mt-6">
													<div class="panel panel-primary">
														<div class="tab-menu-heading tab-menu-heading-boxed">
															<div class="tabs-menu-boxed">
																<!-- Tabs -->
																<ul class="nav panel-tabs" role="tablist">
																	<li>
																		<?php if (!empty($activity_data_withoutBOQ)) {
																			$active = 'active';
																		} elseif (empty($activity_data_withoutBOQ) && empty($activity_data_withBOQ)) {
																			$active = 'active';
																		} else {
																			$active = '';
																		} ?>
																		<a href="#withoutBOQ" class="<?php echo $active; ?>" data-bs-toggle="tab" aria-selected="true" role="tab">Without BOQ</a>
																	</li>
																	<li>
																		<?php $active = (empty($activity_data_withoutBOQ) && !empty($activity_data_withBOQ)) ? 'active' : ''; ?>						
																		<a href="#withBOQ" class="<?php echo $active; ?>" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">With BOQ</a>
																	</li>
																</ul>
															</div>
														</div>
														<div class="panel-body tabs-menu-body">
															<div class="tab-content">
																<?php 	if (!empty($activity_data_withoutBOQ)) {
																			$active = 'active';
																		} elseif (empty($activity_data_withoutBOQ) && empty($activity_data_withBOQ)) {
																			$active = 'active';
																		} else {
																			$active = '';
																		} 
																?>
																<div class="tab-pane <?php echo $active; ?>" id="withoutBOQ" role="tabpanel">
																	<div class="table-responsive"> 
																		<table class="table table-bordered border text-nowrap mb-0" id="new-edit-withoutBOQ">
																			<thead>
																				<tr>
																					<th style="width: 20px !important;">Seq No 
																						<span class="text-red">*</span>
																					</th>
																					<th>Type of Activity 
																						<span class="text-red">*</span>
																					</th>
																					<th>Activity Name 
																						<span class="text-red">*</span>
																					</th>
																					<th>Observations</th>
																					<th>Dashboard Head 
																						<span class="text-red">*</span>
																					</th>
																					<th>Weightage 
																						<span class="text-red">*</span>
																					</th>
																					<th>Report Head 
																						<span class="text-red">*</span>
																					</th>
																					<th>Item Code 
																						<span class="text-red">*</span>
																					</th>
																					<th>ERP Item Name 
																						<span class="text-red">*</span>
																					</th>
																				</tr> 
																			</thead> 
																			<tbody>
																				<?php 	if (!empty($activity_data_withoutBOQ)) { ?>
																				<?php  		foreach ($activity_data_withoutBOQ as $key => $value) { ?>
																				<tr id="row-<?php echo $key; ?>">
																					<input type="hidden" name="activity_id" value="<?php echo $value['typeofwork_activity_id'] ?>" />
																					<td><?php echo $value['seqno']; ?></td>
																					<td style="position: relative;"><?php echo $value['activity_group_name']; ?></td>
																					<td><?php echo $value['activity']; ?></td>
																					<td>
																					<?php 	if (count($value['observations']) > 2) {
																								echo $value['observations_str'].', ...';	
																							} else { 
																								echo $value['observations_str'];
																						  	} 
																					?>
																					</td>
																					<td style="position: relative;"><?php echo $value['dashboard_head']; ?></td>
																					<td><?php echo $value['weightage']; ?></td>
																					<td style="position: relative;"><?php echo $value['report_head']; ?></td>
																					<td><?php echo $value['item_code']; ?></td>
																					<td><?php echo $value['erp_item_name']; ?></td>
																				</tr>			
																				<?php 		} ?>
																				<?php 	} else { ?>
																				<tr id="row-0">
																					<td></td>
																					<td style="position: relative;"></td>
																					<td></td>
																					<td>
																						<!-- <button type="button" class="btn btn-sm btn-obs" data-bs-toggle="modal" data-bs-target="#input-modal" data-bs-whatever="@mdo"><span class="fe fe-more-vertical"> </span></button> -->
																					</td>
																					<td style="position: relative;"></td>
																					<td></td>
																					<td style="position: relative;"></td>
																					<td></td>
																					<td></td>
																				</tr>	
																				<?php 	} ?>
																				
																			</tbody>
																		</table>
																		<button type="button" id="table2-new-row-button-withoutBOQ" class="btn btn-primary mb-4 mt-4"> Add New Row</button>
																	</div>
																</div>
																<?php $active = (empty($activity_data_withoutBOQ) && !empty($activity_data_withBOQ)) ? 'active' : ''; ?>
																<div class="tab-pane <?php echo $active; ?>" id="withBOQ" role="tabpanel">
																	<div class="table-responsive"> 
																		<table class="table table-bordered border text-nowrap mb-0" id="new-edit-withBOQ">
																			<thead>
																				<tr>
																					<th style="width: 20px !important;">Seq No 
																						<span class="text-red">*</span>
																					</th>
																					<th>Type of Activity 
																						<span class="text-red">*</span>
																					</th>
																					<th>Activity Name 
																						<span class="text-red">*</span>
																					</th>
																					<th>Observations</th>
																					<th>Dashboard Head 
																						<span class="text-red">*</span>
																					</th>
																					<th>Report Head 
																						<span class="text-red">*</span>
																					</th>
																					<th>Multiply Factor 
																						<span class="text-red">*</span>
																					</th>
																					<th>Item Code 
																						<span class="text-red">*</span>
																					</th>
																					<th>ERP Item Name 
																						<span class="text-red">*</span>
																					</th>
																				</tr> 
																			</thead> 
																			<tbody>
																				<?php 	if (!empty($activity_data_withBOQ)) { ?>
																				<?php 		foreach ($activity_data_withBOQ as $key => $value) { ?>
																				<tr id="row-<?php echo $key; ?>">
																					<input type="hidden" name="activity_id" value="<?php echo $value['typeofwork_activity_id'] ?>" />
																					<td><?php echo $value['seqno']; ?></td>
																					<td style="position: relative;"><?php echo $value['activity_group_name']; ?></td>
																					<td><?php echo $value['activity']; ?></td>
																					<td>
																					<?php 	if (count($value['observations']) > 2) {
																								echo $value['observations_str'].', ...';	
																							} else { 
																								echo $value['observations_str'];
																						  	} 
																					?>
																					</td>
																					<td style="position: relative;"><?php echo $value['dashboard_head']; ?></td>
																					<td style="position: relative;"><?php echo $value['report_head']; ?></td>
																					<td><?php echo $value['multiply_factor']; ?></td>
																					<td><?php echo $value['item_code']; ?></td>
																					<td><?php echo $value['erp_item_name']; ?></td>	
																				</tr>	
																				<?php 		} ?>
																				<?php } else { ?>
																				<tr id="row-0">
																					<td></td>
																					<td style="position: relative;"></td>
																					<td></td>
																					<td>
																						<!-- <button type="button" class="btn btn-sm btn-obs" data-bs-toggle="modal" data-bs-target="#input-modal" data-bs-whatever="@mdo"><span class="fe fe-more-vertical"> </span></button> -->
																					</td>
																					<td style="position: relative;"></td>
																					<td style="position: relative;"></td>
																					<td></td>
																					<td></td>
																					<td></td>
																				</tr>
																				<?php } ?>
																				
																			</tbody>
																		</table>
																		<button type="button" id="table2-new-row-button-withBOQ" class="btn btn-primary mb-4 mt-4"> Add New Row</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
 												</div>
 												<?php if ($mode == 'add') { ?>
 													<button class="btn btn-success mb-3" type="submit">Submit</button>
 												<?php } elseif ($mode == 'update') { ?>
 													<button class="btn btn-success mb-3" id="update-btn">Update</button>
 												<?php } ?>
	                                            
	                                            <a class="btn btn-primary mb-3" href="<?php echo base_url('typeofwork-activities'); ?>">Back</a>
                                        	</form>
                                    	</div>
                                	</div>
                            	</div>
                        	</div>
                        	<!-- ROW CLOSED -->

                        	<!-- Observation Modal -->
							<div class="modal fade" id="input-modal" style="display: none;" aria-hidden="true">
 								<div class="modal-dialog" role="document">
 									<div class="modal-content modal-content-demo"> 
 										<div class="modal-header"> 
 											<h6 class="modal-title">Add Observations</h6>
 											<button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
 												<span aria-hidden="true">×</span> 
 											</button> 
 										</div> 
 										<div class="modal-body">
 											<form> 
 												<div class="mb-3">
 													<ul class="list-group" id="columns"> 
 														<!-- <li class="column list-group-item justify-content-between" draggable="true" id="listitems1">
 															<input type="text" class="form-control-diff" value="Observation 1">
 															<span class="badgetext badge bg-primary rounded-pill">
 																<span aria-hidden="true" id="close1" onclick="close(1)">×</span>
 															</span>
 														</li> 
 														<li class="column list-group-item justify-content-between" draggable="true" id="listitems2">
 															<input type="text" class="form-control-diff"  value="Observation 2">
 																<span class="badgetext badge bg-primary rounded-pill">
 																	<span aria-hidden="true" id="close2"onclick="close(2)">×</span>
 																</span>
 														</li>
  														<li class="column list-group-item justify-content-between" draggable="true" id="listitems3">
  															<input type="text" class="form-control-diff"  value="Observation 3">
 															<span class="badgetext badge bg-primary rounded-pill">
 																<span aria-hidden="true" id="close3" onclick="closeli(3)">×</span>
 															</span>
 														</li> -->
													</ul>
												</div>
 												<div class="container">
 													<div class="row add_observation" id="addObservations" onclick="addObservations();">
														<span class="fe fe-plus-circle"> </span>
 													</div> 
												</div>
 											</form>
 										</div>
 										<div class="modal-footer"> 
											<button class="btn ripple btn-success" type="button" onclick="applyObservations()">Apply</button> 
 										</div>
 									</div>
 								</div>
 							</div>
 							<!-- Observation Modal Ends -->

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

	    <script type="text/javascript">
	    	let group_withBOQ = '<?php echo json_encode($activity_group_withBOQ) ?>';
	    	let group_withoutBOQ = '<?php echo json_encode($activity_group_withoutBOQ) ?>';

	    	let data_withoutBOQ = [];
	    	let data_withBOQ = [];
	    </script>

	    <!-- EDIT TABLE JS -->
		<script src="<?php echo base_url('assets/plugins/edit-table/typeofwork-activities/activity-edit-table.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/edit-table/typeofwork-activities/withoutBOQ.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/edit-table/typeofwork-activities/withBOQ.js'); ?>"></script>

	    <!-- DATA TABLE JS-->
	    <script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
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
		<script src="<?php echo base_url('assets/js/table-data.js'); ?>"></script>

	    <!-- SWEET-ALERT JS -->
	    <script src="<?php echo base_url('assets/plugins/sweet-alert/sweetalert.min.js'); ?>"></script>
	    <script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>

		<script>
			/*OBSERVATION POPUP CODE*/
			var dragSrcEl = null;

			function handleDragStart(e) {
  				// Target (this) element is the source node.
  				dragSrcEl = this;
  				console.log("handleDragStart="+JSON.stringify(e));

  				e.dataTransfer.effectAllowed = 'move';
  				e.dataTransfer.setData('text/html', this.outerHTML);

				this.classList.add('dragElem');
			}

			function handleDragOver(e) {
	  			console.log("handleDragOver="+JSON.stringify(e));

  				if (e.preventDefault) {
    				e.preventDefault(); // Necessary. Allows us to drop.
  				}

  				this.classList.add('over');

  				e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  				return false;
			}

			function handleDragEnter(e) {
			  	// this / e.target is the current hover target.
				console.log("handleDragEnter="+JSON.stringify(e));
			}

			function handleDragLeave(e) {
				console.log("handleDragEnter="+JSON.stringify(e));

			  	this.classList.remove('over');  // this / e.target is previous target element.
			}

			function handleDrop(e) {

			  	// this/e.target is current target element.

			  	if (e.stopPropagation) {
			    	e.stopPropagation(); // Stops some browsers from redirecting.
			  	}

			  	// Don't do anything if dropping the same column we're dragging.
			  	if (dragSrcEl != this) {
			    	// Set the source column's HTML to the HTML of the column we dropped on.
			    	//alert(this.outerHTML);
			    	//dragSrcEl.innerHTML = this.innerHTML;
				    //this.innerHTML = e.dataTransfer.getData('text/html');
				    this.parentNode.removeChild(dragSrcEl);
				    var dropHTML = e.dataTransfer.getData('text/html');
				    this.insertAdjacentHTML('beforebegin',dropHTML);
				    var dropElem = this.previousSibling;
				    addDnDHandlers(dropElem);
			  	}
				
				this.classList.remove('over');
				return false;
			}

			function handleDragEnd(e) {
				console.log("handleDragEnd="+JSON.stringify(e));

			  	// this/e.target is the source node.
			  	this.classList.remove('over');

				/*[].forEach.call(cols, function (col) {
				    col.classList.remove('over');
				});*/
			}

			function addDnDHandlers(elem) {
				console.log("addDnDHandlers="+JSON.stringify(elem));

			  	elem.addEventListener('dragstart', handleDragStart, false);
			  	elem.addEventListener('dragenter', handleDragEnter, false)
			  	elem.addEventListener('dragover', handleDragOver, false);
			  	elem.addEventListener('dragleave', handleDragLeave, false);
			  	elem.addEventListener('drop', handleDrop, false);
			  	elem.addEventListener('dragend', handleDragEnd, false);
			}

			var cols = document.querySelectorAll('#columns .column');
			[].forEach.call(cols, addDnDHandlers);

			function addObservations()
			{
				var listItems;
				var cols = document.querySelectorAll('#columns .column');
				console.log("cols="+cols.length);
				var colsLenght = cols.length+1;
				$("#columns").append('<li class="column list-group-item justify-content-between" draggable="true" id="listitems'+colsLenght+'"> <input type="text" class="form-control-diff" ><span class="badgetext badge bg-primary rounded-pill"><span aria-hidden="true" id="close'+colsLenght+'" onclick="closeli('+colsLenght+')">×</span></span></li>');
				
				[].forEach.call(cols, addDnDHandlers);
			}

			let observations_withBOQ = [];
			let observations_withoutBOQ = [];	

			let mode = '<?php echo $mode ?>';

			if (mode == 'update') {
				let withoutBOQ_data = <?php echo json_encode($activity_data_withoutBOQ); ?>;
				let withBOQ_data = <?php echo json_encode($activity_data_withBOQ); ?>;

				$.each(withoutBOQ_data, function(index, value) {
					let row = 'row-' + index;
					let observation_temp = [];
					$.each(value.observations, function(ind, val) {
						observation_temp.push(val.observation_name);
					});

					observations_withoutBOQ.push({[row]: observation_temp});
				});

				$.each(withBOQ_data, function(index, value) {
					let row = 'row-' + index;
					let observation_temp = [];
					$.each(value.observations, function(ind, val) {
						observation_temp.push(val.observation_name);
					});

					observations_withBOQ.push({[row]: observation_temp});
				});
			}

			function applyObservations() {
				console.log('inside applyObservations function');

				//Getting editing tr
				let tr = $('tr[data-status="editing"]');				
				let tr_id = $(tr).attr('id');

				let tab = $(tr).closest('.tab-pane');
				let tab_type = $(tab).attr('id');

				let obs_li = $('#columns').find('li');

				// observations = [];
				observations_temp = [];

				$.each($(obs_li), function(index, value) {
					// observations.push($(value).find('input').val());
					observations_temp.push($(value).find('input').val());
				});				

				if (tab_type == 'withoutBOQ') {
					if (!$.isEmptyObject(observations_withoutBOQ)) {
						$.each(observations_withoutBOQ, function(index, value) {
							$.each(value, function(ind, val) {
								if (tr_id == ind) {
									observations_withoutBOQ.splice(index, 1);
								}
							});
						});
					}

					observations_withoutBOQ.push({[tr_id]: observations_temp});
				} else if (tab_type == 'withBOQ') {
					if (!$.isEmptyObject(observations_withBOQ)) {
						$.each(observations_withBOQ, function(index, value) {
							$.each(value, function(ind, val) {
								if (tr_id == ind) {
									observations_withBOQ.splice(index, 1);
								}
							});
						});
					}

					observations_withBOQ.push({[tr_id]: observations_temp});
				}				

				/*let observations_arr = (observations.length > 2) ? observations.slice(0,2) : observations;
				let observations_text = (observations.length > 2) ? observations_arr.join(", ")+', ..' : observations_arr.join(", ");*/

				let observations_arr = (observations_temp.length > 2) ? observations_temp.slice(0,2) : observations_temp;
				let observations_text = (observations_temp.length > 2) ? observations_arr.join(", ")+', ..' : observations_arr.join(", ");

				//Applying Observations
				$(tr).find('.obs-list').text(observations_text);

				//Clearing the modal
				$('#columns').empty();

				//Closing the modal
				$('#input-modal').modal('hide');
			}

			function closeli(id)
			{
				//alert(id);
				$("#listitems"+id).remove();
			}

			function openObservationsModal() {
				console.log('inside openObservationsModal function');
				let tr = $('tr[data-status="editing"]');
				let tr_id = $(tr).attr('id');

				let tab = $(tr).closest('.tab-pane');
				let tab_type = $(tab).attr('id');

				/*let mode = '<?php echo $mode ?>';

				if (mode == 'update') {
					let row_no = tr_id.split('-').pop();

					if (tab_type == 'withoutBOQ') {
						let withoutBOQ_data = <?php echo json_encode($activity_data_withoutBOQ); ?>;						
						let activity_data = withoutBOQ_data[row_no];

						if (!$.isEmptyObject(activity_data)) {
							if (!$.isEmptyObject(activity_data.observations)) {
								let obs_temp = [];
								$.each(activity_data.observations, function(index, value) {
									obs_temp.push(value.observation_name);
								});

								observations_withoutBOQ.push({[tr_id]: obs_temp});
							}	
						}
					} else if (tab_type == 'withBOQ') {
						let withBOQ_data = <?php echo json_encode($activity_data_withBOQ); ?>;
						let activity_data = withBOQ_data[row_no];

						if (!$.isEmptyObject(activity_data)) {
							if (!$.isEmptyObject(activity_data.observations)) {
								let obs_temp = [];
								$.each(activity_data.observations, function(index, value) {
									obs_temp.push(value.observation_name);
								});

								observations_withBOQ.push({[tr_id]: obs_temp});
							}	
						}
					}
				}*/

				if (tab_type == 'withoutBOQ') {
					if (!$.isEmptyObject(observations_withoutBOQ)) {
						$('#columns').empty();
						let obs_html = '';
						
						$.each(observations_withoutBOQ, function(index, value) {
							$.each(value, function(ind, val) {
								if (tr_id == ind) {
									$.each(val, function(i, v) {
										i++;

										obs_html += '<li class="column list-group-item justify-content-between" draggable="true" id="listitems'+i+'">';
										obs_html += '<input type="text" class="form-control-diff" value="'+v+'">';
										obs_html += '<span class="badgetext badge bg-primary rounded-pill">';
										obs_html += '<span aria-hidden="true" id="close'+i+'" onclick="closeli('+i+')">×</span>';
										obs_html += '</span>';
										obs_html += '</li>';		
									})
									
								}
							});
						});

						$('#columns').append(obs_html);
					}
				} else if (tab_type == 'withBOQ') {
					if (!$.isEmptyObject(observations_withBOQ)) {
						$('#columns').empty();
						let obs_html = '';

						$.each(observations_withBOQ, function(index, value) {
							$.each(value, function(ind, val) {
								if (tr_id == ind) {
									$.each(val, function(i, v) {
										i++;

										obs_html += '<li class="column list-group-item justify-content-between" draggable="true" id="listitems'+i+'">';
										obs_html += '<input type="text" class="form-control-diff" value="'+v+'">';
										obs_html += '<span class="badgetext badge bg-primary rounded-pill">';
										obs_html += '<span aria-hidden="true" id="close'+i+'" onclick="closeli('+i+')">×</span>';
										obs_html += '</span>';
										obs_html += '</li>';		
									})
									
								}
							});
						});

						$('#columns').append(obs_html);
					}
				}				

				$('#input-modal').modal('show');
			}
			/*OBSERVATION POPUP CODE ENDS*/
		</script>

		<script type="text/javascript">
			let activity_group_withoutBOQ = JSON.parse(group_withoutBOQ);
			let activity_group_withBOQ = JSON.parse(group_withBOQ);

			let dashboard_without_BOQ = [];
			let report_without_BOQ = [];

			let dashboard_with_BOQ = [];
			let report_with_BOQ = [];

			function showWithoutBOQOptions(input) {
				$('#activity-group-view').empty();
				
				let activities = [];				

				let input_val = $(input).val();
				if (input_val != '') {
					$.each(activity_group_withoutBOQ, function(index, value) {
						var str = value.name;
						
						if (str.includes(input_val)) {
							if (!activities.includes(str)) {
								activities.push(str);	
							}
						} else {
							if (!activities.includes(input_val + '(New Type)')) {
								activities.push(input_val + '(New Type)');	
							}
						}
					});
					
					let html = '';
					html += '<ul class="list-group">';
					$.each(activities, function(index, value) {
						html += '<li class="list-group-item"><a href="javascript:void(0)" data-activity-type="withoutBOQ" onclick="selectActivity(this)">' + value + '</a></li>';
					});
					html += '</ul>';

					$('#activity-group-view').append(html);
				} else {
					let html = '';
					html += '<ul class="list-group">';
					$.each(activity_group_withoutBOQ, function(index, value) {
						html += '<li class="list-group-item"><a href="javascript:void(0)" data-activity-type="withoutBOQ" onclick="selectActivity(this)">' + value.name + '</a></li>';
					});
					html += '</ul>';

					$('#activity-group-view').append(html);
				}
			}

			function showWithBOQOptions(input) {
				$('#activity-group-view').empty();

				let activities = [];

				let input_val = $(input).val();

				if (input_val != '') {
					$.each(activity_group_withBOQ, function(index, value) {
						var str = value.name;

						if (str.includes(input_val)) {
							if (!activities.includes(str)) {
								activities.push(str);
							}
						} else {
							if (!activities.includes(input_val + '(New Type)')) {
								activities.push(input_val + '(New Type)');
							}
						}
					});

					let html = '';
					html += '<ul class="list-group">';
					$.each(activities, function(index, value) {
						html += '<li class="list-group-item"><a href="javascript:void(0)" data-activity-type="withBOQ" onclick="selectActivity(this)">' + value + '</a></li>';
					});
					html += '</ul>';

					$('#activity-group-view').append(html);	
				} else {
					let html = '';
					html += '<ul class="list-group">';
					$.each(activity_group_withBOQ, function(index, value) {
						html += '<li class="list-group-item"><a href="javascript:void(0)" data-activity-type="withBOQ" onclick="selectActivity(this)">' + value.name + '</a></li>';
					});
					html += '</ul>';

					$('#activity-group-view').append(html);	
				}
			}

			function selectActivity(list_anchor) {
				//Getting selected activity
				let selected_activity = $(list_anchor).text();
				let activity_type = $(list_anchor).attr('data-activity-type');

				if (selected_activity.includes('(New Type)')) {
					selected_activity = selected_activity.replace('(New Type)', '');

					//Ajax call to save new Activity Type
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url("save-activity-group") ?>',
						dataType: 'json',
						data: {new_activity_group: selected_activity, activity_type: activity_type},
						success: function(response) {
							console.log(response);
						},
						error: function(xhr, status, error) {
							console.log(xhr.responseText);
						}
					});

				}

				//Setting selected activity as input value
				$('.type_of_activity').val(selected_activity);

				$('#activity-group-view').empty();
			}

			function showDashboardHeadOptions(input) {				
				$('#dashboard-head').empty();

				let input_val = $(input).val();
				let activity_type = $(input).attr('data-activity-type');
				let dashboard_head = [];

				if (input_val != '') {
					if (!dashboard_head.includes(input_val)) {
						dashboard_head.push(input_val + '(New Type)');
					}

					if (activity_type == 'withoutBOQ') {
						$.merge(dashboard_head, dashboard_without_BOQ);
					} else if (activity_type == 'withBOQ') {
						$.merge(dashboard_head, dashboard_with_BOQ);
					}

					let html = '';
					html += '<ul class="list-group">';
					$.each(dashboard_head, function(index, value) {
						html += '<li class="list-group-item"><a href="javascript:void(0)" data-activity-type="' + activity_type + '" onclick="selectDashboardHead(this)">' + value+ '</a></li>';
					});
					html += '</ul>';

					$('#dashboard-head').append(html);
				}
			}

			function selectDashboardHead(list_anchor) {
				//Getting selected Dashboard Head text
				let selected_dashboard_head = $(list_anchor).text();
				console.log(selected_dashboard_head);
				let activity_type = $(list_anchor).attr('data-activity-type');

				if (selected_dashboard_head.includes('(New Type)')) {
					selected_dashboard_head = selected_dashboard_head.replace('(New Type)', '');

					if (activity_type == 'withoutBOQ') {
						dashboard_without_BOQ.push(selected_dashboard_head);
					} else if (activity_type == 'withBOQ') {
						dashboard_with_BOQ.push(selected_dashboard_head);
					}
				}

				//Setting the selected dashboard head value
				$('.dashboard_head').val(selected_dashboard_head);
				$('#dashboard-head').empty();
			}

			function showReportHeadOptions(input) {
				$('#report-head').empty();

				let input_val = $(input).val();
				let activity_type = $(input).attr('data-activity-type');
				let report_head = [];

				if (input_val != '') {
					if (!report_head.includes(input_val)) {
						report_head.push(input_val + '(New Type)');
					}

					if (activity_type == 'withoutBOQ') {
						$.merge(report_head, report_without_BOQ);
					} else if (activity_type == 'withBOQ') {
						$.merge(report_head, report_with_BOQ);
					}

					let html = '';
					html += '<ul class="list-group">';
					$.each(report_head, function(index, value) {
						html += '<li class="list-group-item"><a href="javascript:void(0)" data-activity-type="' + activity_type + '" onclick="selectReportHead(this)">' + value+ '</a></li>'
					});
					html += '</ul>';

					$('#report-head').append(html);
				}				
			}

			function selectReportHead(list_anchor) {
				//Getting selected Report Head text
				let selected_report_head = $(list_anchor).text();
				let activity_type = $(list_anchor).attr('data-activity-type');

				if (selected_report_head.includes('(New Type)')) {
					selected_report_head = selected_report_head.replace('(New Type)', '');

					if (activity_type == 'withoutBOQ') {
						report_without_BOQ.push(selected_report_head);
					} else if (activity_type == 'withBOQ') {
						report_with_BOQ.push(selected_report_head);
					}
				}

				//Setting the selected report head value
				$('.report_head').val(selected_report_head);
				$('#report-head').empty();
			}

			/*Saving TypeofWork-Activities and observations*/
			$('#save_activity').submit(function(event) {
				event.preventDefault();
				console.log('form submit clicked');
				/*console.log(data_withoutBOQ);
				console.log(data_withBOQ);*/

				if ($.isEmptyObject(data_withoutBOQ) && $.isEmptyObject(data_withBOQ)) {
					$('.toast-body').text('Add atleast one activity');
					$('.toast').toast('show');
				} else {
					//Getting selected Type Of Work
					let typeofwork_data = $('select[name="typeOfWork"]').select2('data');
					let typeofwork_name = typeofwork_data[0].text;

					//Getting form action url
					let form_action_url = $(this).attr('action');

					//Ajax call to save the activities 
					$.ajax({
						type: 'POST',
						url: form_action_url,
						dataType: 'json',
						data: {typeofwork_name: typeofwork_name, data_withoutBOQ: data_withoutBOQ, data_withBOQ: data_withBOQ},
						success: function(response) {
							console.log(response);

							window.location = '<?php echo base_url("typeofwork-activities") ?>';
						},
						error: function(xhr, status, error) {
							console.log(xhr.responseText);
						}
					});
				}
			});

			$('#update-btn').click(function(event) {
				console.log('update button clicked');
				event.preventDefault();

				/*console.log('data_withoutBOQ:');
				console.log(data_withoutBOQ);
				console.log('data_withBOQ:');
				console.log(data_withBOQ);*/

				if ($.isEmptyObject(data_withoutBOQ) && $.isEmptyObject(data_withBOQ)) {
					$('.toast-body').text('No activity updated');
					$('.toast').toast('show');
				} else {
					//Getting selected Type Of Work
					let typeofwork_data = $('select[name="typeOfWork"]').select2('data');
					let typeofwork_name = typeofwork_data[0].text;

					// Ajax call to update the activities
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('update-activity') ?>',
						dataType: 'json',
						data: {typeofwork_name: typeofwork_name, data_withoutBOQ: data_withoutBOQ, data_withBOQ: data_withBOQ},
						success: function(response) {
							console.log(response);

							window.location = '<?php echo base_url("typeofwork-activities") ?>';
						}, 
						error: function(xhr, status, error) {
							console.log(xhr.responseText);
						} 
					});

				}

			});

			function deleteActivity(button) {
				console.log($(button)); 
				let tr = $(button).closest('tr');
				let activity_id = $(tr).find('input[name="activity_id"]').val();

				// Ajax call to delete the activity
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url('delete-activity') ?>',
					dataType: 'json',
					data: {typeofwork_activity_id: activity_id},
					success: function(response) {
						console.log(response); 

						$('.toast-body').text(response.message);
                		$('.toast').toast('show');
					},
					error: function(xhr, status, error) {
						console.log(xhr.responseText);
					}
				});
			}

			/*$(document).click(function() {
		    	// alert('click');
		      	var activity_group_view = $('#activity-group-view');
		      	if (!activity_group_view.is(event.target) && !activity_group_view.has(event.target).length) {
		      		activity_group_view.hide();
		      	}
		    });*/
		</script>

	</body>

</html>