<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
			table, th, td {
				border: 1px solid black;
			 	border-collapse: collapse;
			 	font-family: "Times New Roman", Times, serif;
			}

			th, td {
			  	padding: 5px;
			  	text-align: left;
			}

			h1 {
				font-family: "Times New Roman", Times, serif;
			}

			table {
				page-break-after: always;
			}

			body > table:last-of-type {
				page-break-after: auto;
			}
		</style>
	</head>
	<body>
		<h1>Compliance By TKC Report</h1>
		<table width="100%">
		<?php foreach ($report_data as $key => $value) { ?>
		<?php foreach ($value as $k => $v) { ?>
		<?php if ($k == 0) { ?>
		<!-- DISCOM -->
		<tr>
			<td><b>DISCOM</b></td>
			<td>MPPKVVCL</td>
		</tr>
		<!-- TKC -->
		<tr>
			<td><b>TKC</b></td>
			<td><?php echo $v['contractor_name']; ?></td>
		</tr>
		<!-- Package No -->
		<tr>
			<td><b>Package No</b></td>
			<td><?php echo $v['package_no']; ?></td>
		</tr>
		<!-- Contractor Name -->
		<tr>
			<td><b>Contractor Name</b></td>
			<td><?php echo $v['contractor_name']; ?></td>
		</tr>
		<!-- Region Name -->
		<tr>
			<td><b>Region Name</b></td>
			<td><?php echo $v['region_name']; ?></td>
		</tr>
		<!-- Circle Name -->
		<tr>
			<td><b>Circle Name</b></td>
			<td><?php echo $v['circle_name']; ?></td>
		</tr>
		<!-- Division Name -->
		<tr>
			<td><b>Division Name</b></td>
			<td><?php echo $v['division_name']; ?></td>
		</tr>
		<!-- Feeder ID -->
		<tr>
			<td><b>Feeder ID</b></td>
			<td><?php echo $v['feeder_id']; ?></td>
		</tr>
		<!-- Feeder Name -->
		<tr>
			<td><b>Feeder Name</b></td>
			<td><?php echo $v['feeder_name']; ?></td>
		</tr>
		<!-- Substation -->
		<tr>
			<td><b>Substation</b></td>
			<td><?php echo $v['substation']; ?></td>
		</tr>
		<!-- Standards -->
		<tr>
			<td><b>Standards</b></td>
			<td><?php echo $v['standards']; ?></td>
		</tr>
		<!-- Line Break -->
		<tr>
	    	<!-- <td border='0'></td>
	    	<td></td> -->
	    	<td colspan="2" style="height:40px"></td>
	    </tr>
		<?php } ?>
		<!-- NCR ID -->
		<tr>
			<td><b>NCR ID</b></td>
			<td><?php echo $v['ncr_id']; ?></td>
		</tr>
		<!-- NCR Date -->
		<tr>
			<td><b>NCR Date</b></td>
			<td><?php echo $v['ncr_date']; ?></td>
		</tr>
		<!-- Raised By -->
		<tr>
			<td><b>Raised By</b></td>
			<td><?php echo (!empty($v['raised_by'])) ? $v['raised_by'] : $v['Inspected_by']; ?></td>
		</tr>
		<!-- Designation -->
		<tr>
			<td><b>Designation</b></td>
			<td><?php echo $v['designation']; ?></td>
		</tr>
		<!-- Distribution Centre -->
		<tr>
			<td><b>Distribution Centre</b></td>
			<td><?php echo $v['distribution_centre']; ?></td>
		</tr>
		<!-- Activity -->
		<tr>
			<td><b>Activity</b></td>
			<td><?php echo $v['activity']; ?></td>
		</tr>
		<!-- Observation Type -->
		<tr>
			<td><b>Observation Type</b></td>
			<td><?php echo $v['observation_type']; ?></td>
		</tr>
		<!-- Other Observation Type -->
		<?php if ($v['observation_type'] == 'Others') { ?>
		<tr>
			<td><b>Other Observation Type</b></td>
			<td><?php echo $v['other_observation_name']; ?></td>
		</tr>	
		<?php } ?>
		<!-- Observation -->
		<tr>
			<td><b>Observation</b></td>
			<td><?php echo $v['observation_remark']; ?></td>
		</tr>
		<!-- Observation Photos -->
		<tr>
			<td><b>Observation Photos</b></td>
			<td>
				<?php $obs_photos = explode(',', $v['observation_photos']); ?>
				<?php foreach ($obs_photos as $obs_value) { ?>
				<!-- <img src="<?php //echo $obs_value; ?>" width="150"/> -->
				<img src="<?php echo $obs_value; ?>" alt="Observation Photo" width="100" height="100" style="margin-top: 30px;">
				<?php } ?>
			</td>
		</tr>
		<!-- Observation Photos By TKC -->
		<tr>
			<td><b>Observation Photos By TKC</b></td>
			<td>
				<?php $obs_photos_by_tkc = explode(',', $v['tkc_observation_photos']); ?>
				<?php foreach ($obs_photos_by_tkc as $obs_value) { ?>
				<!-- <img src="<?php //echo $obs_value; ?>" width="150"/> -->
				<img src="<?php echo $obs_value; ?>" alt="Observation By TKC Photo" width="100" height="100" style="margin-top: 30px;">
				<?php } ?>
			</td>
		</tr>
		<!-- Compliance Remark -->
		<tr>
			<td><b>Compliance Remark</b></td>
			<td><?php echo $v['observation']; ?></td>
		</tr>
		<!-- Compliance Photos -->
		<tr>
			<td><b>Compliance Photos</b></td>
			<td>
				<?php if (!empty($v['completion_photos'])) {
						$obs_completion_photo = explode(',', $v['completion_photos']);
						foreach ($obs_completion_photo as $obs_value) {
				?>
				<!-- <img src="<?php //echo $obs_value; ?>" width="150"/> -->
				<img src="<?php echo $obs_value; ?>" alt="Observation Completion Photo" width="100" height="100" style="margin-top: 30px;">
				<?php 		  } 
					   }
				?>
			</td>
		</tr>
		<!-- Compliance Date -->
		<tr>
			<td><b>Compliance Date</b></td>
			<td><?php echo (!empty($v['completion_date'])) ? date('d-m-Y', strtotime($v['completion_date'])) : ''; ?></td>
		</tr>
		<!-- Line Break -->
		<tr>
			<!-- <td border='0'></td>
			<td></td> -->
			<td colspan="2" style="height:20px"></td>
		</tr>
		<?php } ?>
		<!-- Line Break -->
		<tr>
			<!-- <td border='0'></td>
			<td></td> -->
			<td colspan="2" style="height:80px"></td>
		</tr>
		<?php } ?>	
		</table>
	</body>
</html>