<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<style>
			table, tbody, td {
			  border:1px solid black;
			  border-collapse: collapse;
			}

			.center{
				line-height: 5px;
				padding: 15px 0;
			}
		</style>
	</head>

	<body>
		<h2>Non Conformance Report By PMA (SGS)</h2>
		<table style="width:100%">
			<tbody>
				<?php 	/*$i = 0;
						foreach ($variable as $key => $value) {
							// code...
						}*/
				?>
				<!-- DISCOM -->
				<tr>
					<td><b>DISCOM</b></td>
					<td>MPPKVVCL</td>
				</tr>
				<!-- TKC -->
				<tr>
					<td><b>TKC</b></td>
					<td><?php echo $report_data['contractor_name'];?></td>
				</tr>
				<!-- Package No -->
				<tr>
					<td><b>Package No</b></td>
					<td><?php echo $report_data['package_no']; ?></td>
				</tr>
				<!-- Standards -->
				<tr>
					<td><b>Standards</b></td>
					<td><?php echo $report_data['standards']; ?></td>
				</tr>
				<tr class="blank_row">
					<td colspan="2" style="line-height:50px;">&nbsp;</td>
				</tr>
				<!-- Region -->
				<tr>
					<td><b>Region Name</b></td>
					<td><?php echo $report_data['region_name']; ?></td>
				</tr>
				<!-- Circle -->
				<tr>
					<td><b>Circle Name</b></td>
					<td><?php echo $report_data['circle_name']; ?></td>
				</tr>
				<!-- Division -->
				<tr>
					<td><b>Division Name</b></td>
					<td><?php echo $report_data['division_name']; ?></td>
				</tr>
				<!-- Feeder ID -->
				<tr>
					<td><b>Feeder ID</b></td>
					<td><?php echo $report_data['feeder_id']; ?></td>
				</tr>
				<!-- Feeder Name -->
				<tr>
					<td><b>Feeder Name</b></td>
					<td><?php echo $report_data['feeder_name']; ?></td>
				</tr>
				<!-- Substation -->
				<tr>
					<td><b>Substation</b></td>
					<td><?php echo $report_data['substation']; ?></td>
				</tr>
				<!-- NCR ID -->
				<tr>
					<td><b>NCR ID</b></td>
					<td><?php echo $report_data['ncr_id'] ?></td>
				</tr>
				<!-- NCR Date -->
				<tr>
					<td><b>NCR Date</b></td>
					<td><?php echo date('d-m-Y', strtotime($report_data['ncr_date'])); ?></td>
				</tr>
				<!-- Raised By -->
				<tr>
					<td><b>Raised By</b></td>
					<td><?php echo (!empty($report_data['raised_by'])) ? $report_data['raised_by'] : $report_data['Inspected_by']; ?></td>
				</tr>
				<!-- Designation -->
				<tr>
					<td><b>Designation</b></td>
					<td><?php echo $report_data['designation']; ?></td>
				</tr>
				<!-- Distribution Centre -->
				<tr>
					<td><b>Distribution Centre</b></td>
					<td><?php echo $report_data['distribution_centre']; ?></td>
				</tr>
				<!-- Activity -->
				<tr>
					<td><b>Activity</b></td>
					<td><?php echo $report_data['activity']; ?></td>
				</tr>
				<!-- Observation Type -->
				<tr>
					<td><b>Observation Type</b></td>
					<td><?php echo $report_data['observation_type']; ?></td>
				</tr>
				<!-- Other Observation Type -->
				<?php if ($report_data['observation_type'] == 'Others') { ?>
				<tr>
					<td><b>Other Observation Type</b></td>
					<td><?php echo $report_data['other_observation_name']; ?></td>
				</tr>
				<?php } ?>
				<!-- Observation Remark -->
				<tr>
					<td><b>Observation</b></td>
					<td><?php echo $report_data['observation_remark']; ?></td>
				</tr>
				<!-- Observation Photos -->
				<tr>
					<td><b>Observation Photos</b></td>
					<td>
						<?php 	$obs_photos = explode(', ', $report_data['observation_photos']);
								for ($j = 0; $j < count($obs_photos); $j++) { 
						?>
						<img src="<?php echo $obs_photos[$j] ?>" width="100" height="100">
						<br/><br/>
						<?php 	} ?>
					</td>
				</tr>
				<!-- Observation Photos By TKC -->
				<tr>
					<td><b>Observation Photos By TKC</b></td>
					<td>
						<?php 	$obs_photos = explode(', ', $report_data['observation_by_tkc_photos']);
								for ($j = 0; $j < count($obs_photos); $j++) { 
						?>
						<img src="<?php echo $obs_photos[$j] ?>" width="100" height="100">
						<br/><br/>
						<?php 	} ?>
					</td>
				</tr>
				<!-- Compliance Report -->
				<tr>
					<td colspan="2" class="center"><b>Compliance Report</b></td>
				</tr>
				<!-- Compliance Remark -->
				<tr>
					<td><b>Compliance Remark</b></td>
					<td><?php echo $report_data['observation']; ?></td>
				</tr>
				<!-- Compliance Verification Date -->
				<tr>
					<td><b>Completion Date</b></td>
					<td><?php echo (!empty($report_data['completion_date']) ? date('d-m-Y', strtotime($report_data['completion_date'])) : ''); ?></td>
				</tr>
				<!-- Compliance Photos -->
				<tr>
					<td><b>Completed Photos</b></td>
					<td>
						<?php 	$obs_completion_photos = (!empty($report_data['completion_photos'])) ? explode(', ', $report_data['completion_photos']) : [];
								if (!empty($obs_completion_photos)) {
									for ($j = 0; $j < count($obs_completion_photos); $j++) {
						?>
						<img src="<?php echo $obs_completion_photos[$j] ?>" width="100" height="100">
						<br/><br/>
						<?php 		} 
								}
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<footer>
			<p style="text-align: center;"><strong>Note:</strong> This is computer generated report and no signature is required</p>
		</footer>
	</body>
</html>