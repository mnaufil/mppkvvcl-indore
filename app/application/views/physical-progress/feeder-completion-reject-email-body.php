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
		<p>Admin/DTL has rejected the Feeder Completion photo submitted by FE/FS for Feeder ID: <?php echo $feeder_data['feeder_id']; ?>. Following are the details:</p>
		<table>
			<!-- Contractor Name -->
			<tr>
				<th>Contractor (TKC): </th>
				<td><?php echo $feeder_data['contractor_name']; ?></td>
			</tr>
			<!-- Contract No -->
			<tr>
				<th>Contract No:</th>
				<td><?php echo $feeder_data['tender_award_no']; ?></td>
			</tr>
			<!-- Contract Date -->
			<tr>
				<th>Contract Date:</th>
				<td><?php echo date('d-m-Y', strtotime($feeder_data['tender_award_date'])); ?></td>
			</tr>
			<!-- Lot No -->
			<tr>
				<th>Lot No:</th>
				<td><?php echo $feeder_data['package_group_no'] ?></td>
			</tr>
			<!-- Type of Work -->
			<tr>
				<th>Type of Work:</th>
				<td><?php echo $feeder_data['typeofwork_name']; ?></td>
			</tr>
			<!-- Region -->
			<tr>
				<th>Region:</th>
				<td><?php echo $feeder_data['region_name']; ?></td>
			</tr>
			<!-- Circle -->
			<tr>
				<th>Circle:</th>
				<td><?php echo $feeder_data['circle_name']; ?></td>
			</tr>
			<!-- Division -->
			<tr>
				<th>Division:</th>
				<td><?php echo $feeder_data['division_name']; ?></td>
			</tr>
			<!-- Site Location -->
			<tr>
				<th>Site Location:</th>
				<td><?php echo $feeder_data['location_name']; ?></td>
			</tr>
			<!-- Feeder ID -->
			<tr>
				<th>Feeder ID:</th>
				<td><?php echo $feeder_data['feeder_id']; ?></td>
			</tr>
			<!-- Feeder Name -->
			<tr>
				<th>Feeder Name:</th>
				<td><?php echo $feeder_data['feeder_name']; ?></td>
			</tr>
			<!-- Task Ratio -->
			<tr>
				<th>Task Ratio:</th>
				<td><?php echo $feeder_data['cc_task'].' / '.$feeder_data['tt_task']; ?></td>
			</tr>
			<!-- Observation Ratio -->
			<tr>
				<th>Observation Ratio:</th>
				<td>
					<?php if ($feeder_data['tt_observation'] != 0) {
									echo $feeder_data['cc_task'].' / '.$feeder_data['tt_task'];
					 			} else { 
									echo "-";
								} 
					?>
				</td>
			</tr>
			<!-- Completion File -->
			<tr>
				<th>Completion File:</th>
				<td>
					<?php $files = $feeder_data['feeder_completion_file'];
								foreach ($files as $key => $value) {
					?>
					<img src="cid:<?php echo $key; ?>" width="100" height="100">
					<br/><br/>
					<?php	}
				 	?>
				</td>
			</tr>
			<!-- Feeder Completion Rejection Message -->
			<tr>
				<th>Feeder Completion Rejection Message: </th>
				<td>
					<?php echo $feeder_data['reject_msg']; ?>
				</td>
			</tr>
		</table>
	</body>
</html>