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
		<h1>Non Conformance Report By PMA (SGS)</h1>
		
		<?php foreach ($report_data as $key => $value) { ?>		
		<table width="100%">
			<!-- DISCOM -->
			<tr>
				<th>DISCOM</th>
				<td><?php echo $value[0]['discom']; ?></td>
			</tr>
			<!-- TKC -->
			<tr>
				<th>TKC</th>
				<td><?php echo $value[0]['contractor_name']; ?></td>
			</tr>
			<!-- Package No -->
			<tr>
				<th>Package No</th>
				<td><?php echo $value[0]['package_no']; ?></td>
			</tr>
			<!-- Region Name -->
			<tr>
				<th>Region Name</th>
				<td><?php echo $value[0]['region_name']; ?></td>
			</tr>
			<!-- Circle Name -->
			<tr>
				<th>Circle Name</th>
				<td><?php echo $value[0]['circle_name']; ?></td>
			</tr>
			<!-- Division Name -->
			<tr>
				<th>Division Name</th>
				<td><?php echo $value[0]['division_name']; ?></td>
			</tr>
			<!-- Feeder ID -->
			<tr>
				<th>Feeder ID</th>
				<td><?php echo $value[0]['feeder_id']; ?></td>
			</tr>
			<!-- Feeder Name -->
			<tr>
				<th>Feeder Name</th>
				<td><?php echo $value[0]['feeder_name']; ?></td>
			</tr>
			<!-- Substation -->
			<tr>
				<th>Substation</th>
				<td><?php echo $value[0]['substation']; ?></td>
			</tr>
			<!-- Standards -->
			<tr>
				<th>Standards</th>
				<td><?php echo $value[0]['standards']; ?></td>
			</tr>
			<!-- NCR Details -->
			<tr>
				<th colspan="2">NCR Details</th>
			</tr>
			<?php $i = 1; ?>
			<?php foreach ($value[0]['ncr_data'] as $ncr_key => $ncr_value) { ?>
			<!-- NCR ID -->
			<tr>
				<th>NCR ID</th>
				<td><?php echo $ncr_value['ncr_id']; ?></td>
			</tr>
			<!-- NCR Date -->
			<tr>
				<th>NCR Date</th>
				<td><?php echo $ncr_value['ncr_date']; ?></td>
			</tr>
			<!-- Inspected By -->
			<tr>
				<th>Inspected By</th>
				<td><?php echo $ncr_value['Inspected_by']; ?></td>
			</tr>
			<!-- Activity -->
			<tr>
				<th>Activity</th>
				<td><?php echo $ncr_value['activity']; ?></td>
			</tr>
			<!-- Observation Type -->
			<tr>
				<th>Observation Type</th>
				<td><?php echo $ncr_value['observation_type']; ?></td>
			</tr>
			<!-- Observation -->
			<tr>
				<th>Observation</th>
				<td><?php echo $ncr_value['observation']; ?></td>
			</tr>
			<!-- Observation Photos -->
			<tr>
				<th>Observation Photo(s)</th>
				<td>
					<?php foreach ($ncr_value['observation_photos'] as $obs_value) { ?>
					<img src="<?php echo $obs_value; ?>" alt="Observation Photo" width="100" height="100" style="margin-top: 30px;">	
					<?php } ?>					
				</td>
			</tr>
			<!-- Compliance Photos -->
			<tr>
				<th>Compliance Photo(s)</th>
				<td>
					<?php if (!empty($ncr_value['completion_photos'])) { 
							foreach ($ncr_value['completion_photos'] as $obs_value) {
					?>
					<img src="<?php echo $obs_value; ?>" alt="Observation Completion Photo" width="100" height="100" style="margin-top: 30px;">
					<?php 	}
						  }
					?>
				</td>
			</tr>
			<!-- Compliance Verification Date -->
			<tr>
				<th>Compliance Verification Date</th>
				<td><?php echo (!empty($ncr_value['completion_date'])) ? date('d-m-Y', strtotime($ncr_value['completion_date'])) : ''; ?></td>
			</tr>
			<?php if (count($value[0]['ncr_data']) > 1) { 
					if ($i < count($value[0]['ncr_data'])) {
			?>
			<tr>
				<th colspan="2" style="height:40px"></th>
			</tr>
			<?php 	}
				  } 
			?>
			<?php $i++; ?>
			<?php } ?>
		</table>
		<br/> <br/> <br/> <br/> <br/>		
		<?php } ?>
	</body>
</html>