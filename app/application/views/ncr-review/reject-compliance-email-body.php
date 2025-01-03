<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<style>
			table, tbody, td, th{
			  	border:1px solid black;
			  	border-collapse: collapse;
			}
		</style>
	</head>

	<body>
		<p>Admin/DTL has rejected the Compliance submitted by FE/FS for NCR ID: <?php echo $ncr_data['ncr_id']; ?>. Following are the details:</p>
		<table>
			<!-- NCR ID -->
			<tr>
				<th>NCR ID: </th>
				<td><?php echo $ncr_data['ncr_id']; ?></td>
			</tr>
			<!-- Feeder ID -->
			<tr>
				<th>Feeder ID: </th>
				<td><?php echo $ncr_data['feeder_id']; ?></td>
			</tr>
			<!-- Raised By -->
			<tr>
				<th>Raised By: </th>
				<td><?php echo $ncr_data['raised_by']; ?></td>
			</tr>
			<!-- Designation -->
			<tr>
				<th>Designation: </th>
				<td><?php echo $ncr_data['designation']; ?></td>
			</tr>
			<!-- Distribution Centre -->
			<tr>
				<th>Distribution Centre: </th>
				<td><?php echo $ncr_data['distribution_centre']; ?></td>
			</tr>
			<!-- Observation Type -->
			<tr>
				<th>Observation Type: </th>
				<td><?php echo $ncr_data['observation_name']; ?></td>
			</tr>
			<?php if ($ncr_data['observation_id'] == 0) { ?>
			<!-- Other Observation -->
			<tr>
				<th>Other Observation: </th>
				<td><?php echo $ncr_data['other_observation_name']; ?></td>
			</tr>
			<?php } ?>
			<!-- Observation -->
			<tr>
				<th>Observation: </th>
				<td><?php echo $ncr_data['observation_remark']; ?></td>
			</tr>
			<!-- Observation Photos -->
			<tr>
				<th>Observation Photos: </th>
				<td>
					<?php 	$obs_files = $ncr_data['observation_files'];
							foreach ($obs_files as $key => $value) {
					?>
					<img src="cid:<?php echo $key; ?>" width="100" height="100">
					<br/><br/>
					<?php 	} ?>
				</td>
			</tr>
			<!-- Observation Photos By TKC -->
			<tr>
				<th>Observation Photos uploaded by TKC: </th>
				<td>
					<?php 	$obs_files_by_tkc = $ncr_data['observation_tkc_files'];
							if (!empty($obs_files_by_tkc)) {
								foreach ($obs_files_by_tkc as $key => $value) {
					?>
					<img src="cid:<?php echo $key; ?>" width="100" height="100">
					<br/><br/>
					<?php		}
							}
					?>
				</td>
			</tr>			
			<!-- Completion Remark -->
			<tr>
				<th>Compliance Remark: </th>
				<td><?php echo $ncr_data['remark']; ?></td>
			</tr>
			<!-- Completion Photo -->
			<tr>
				<th>Compliance Photo: </th>
				<td>
					<?php 	$obs_completion_files = $ncr_data['observation_completion_files'];
							foreach ($obs_completion_files as $key => $value) {
					?>
					<img src="cid:<?php echo $key; ?>" width="100" height="100">
					<br/><br/>
					<?php 	}
					?>
				</td>
			</tr>
			<!-- Completion Date -->
			<tr>
				<th>Compliance Date: </th>
				<td><?php echo (!empty($ncr_data['completion_date'])) ? date('d-m-Y', strtotime($ncr_data['completion_date'])) : ''; ?></td>
			</tr>
			<!-- Compliance Rejection Message -->
			<tr>
				<th>Compliance Rejection Message: </th>				
				<td>
					<?php echo $ncr_data['reject_msg']; ?>
				</td>
			</tr>
		</table>
	</body>
</html>