<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<!-- BOOTSTRAP CSS -->
		<!-- <link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

		<style>
			table, tbody, td {
			  border:1px solid black;
			  border-collapse: collapse;
			},
			/*.blank_row {
				line-height: 100px !important;
			}*/
		</style>
	</head>

	<body>
		<!-- <p>Testing mPDF</p> -->
		<table style="width:100%">
			<tbody>				
				<?php 	$i = 0;
						foreach ($report_data as $key => $value) {
							if ($i == 0) {
				?>
				<tr>
					<td><b>DISCOM</b></td>
					<td>MPPKVVCL</td>
				</tr>
				<tr>
					<td><b>TKC</b></td>
					<td><?php echo $value['contractor_name'];?></td>
				</tr>
				<tr>
					<td><b>Package No</b></td>
					<td><?php echo $value['package_no']; ?></td>
				</tr>
				<tr>
					<td><b>Standards</b></td>
					<td><?php echo $value['standards']; ?></td>
				</tr>				
				<tr class="blank_row">
					<td colspan="2" style="line-height:50px;">&nbsp;</td>
				</tr>
				<?php		} ?>
				<tr>
					<td><b>Region Name</b></td>
					<td><?php echo $value['region_name']; ?></td>
				</tr>
				<tr>
					<td><b>Circle Name</b></td>
					<td><?php echo $value['circle_name']; ?></td>
				</tr>
				<tr>
					<td><b>Division Name</b></td>
					<td><?php echo $value['division_name']; ?></td>
				</tr>
				<tr>
					<td><b>Feeder ID</b></td>
					<td><?php echo $value['feeder_id']; ?></td>
				</tr>
				<tr>
					<td><b>Feeder Name</b></td>
					<td><?php echo $value['feeder_name']; ?></td>
				</tr>
				<tr>
					<td><b>Substation</b></td>
					<td><?php echo $value['substation']; ?></td>
				</tr>
				<tr>
					<td><b>NCR ID</b></td>
					<td><?php echo $value['ncr_id'] ?></td>
				</tr>
				<tr>
					<td><b>NCR Date</b></td>
					<td><?php echo date('d-m-Y', strtotime($value['ncr_date'])); ?></td>
				</tr>
				<tr>
					<td><b>Raised By</b></td>
					<td><?php echo $value['Inspected_by']; ?></td>
				</tr>
				<tr>
					<td><b>Activity</b></td>
					<td><?php echo $value['activity']; ?></td>
				</tr>
				<tr>
					<td><b>Observation Type</b></td>
					<td><?php echo $value['observation_type']; ?></td>
				</tr>
				<tr>
					<td><b>Observation</b></td>
					<td><?php echo $value['observation']; ?></td>
				</tr>
				<tr>
					<td><b>Observation Photos</b></td>
					<td>
						<?php 	$obs_photos = explode(', ', $value['observation_photos']);
								for ($j = 0; $j < count($obs_photos); $j++) { 
						?>
						<img src="<?php echo $obs_photos[$j] ?>" width="100" height="100">
						<br/><br/>
						<?php 	} ?>
					</td>
				</tr>
				<tr>
					<td><b>Completion Date</b></td>
					<td><?php echo (!empty($value['completion_date']) ? date('d-m-Y', strtotime($value['completion_date'])) : ''); ?></td>
				</tr>
				<tr>
					<td><b>Completed Photos</b></td>
					<td>
						<?php 	$obs_completion_photos = (!empty($value['completion_photos'])) ? explode(', ', $value['completion_photos']) : [];
								if (!empty($obs_completion_photos)) {
									for ($j = 0; $j < count($obs_completion_photos); $j++) {
						?>
						<img src="<?php echo $obs_completion_photos[$j] ?>" width="100" height="100">
						<?php 		} 
								}
						?>
					</td>
				</tr>
				<tr class="blank_row">
					<td colspan="2" style="line-height:30px;">&nbsp;</td>
				</tr>
				<?php $i++; ?>
				<?php	} ?>				
			</tbody>
		</table>


		<!-- BOOTSTRAP JS -->
		<!-- <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script> -->
	</body>
</html>