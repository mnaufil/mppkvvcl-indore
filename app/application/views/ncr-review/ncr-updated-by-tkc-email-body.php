<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title; ?></title>

	<style>
		table, tbody, td, th{
		  	border:1px solid black;
		  	border-collapse: collapse;
		}
	</style>
</head>
<body>
	<!-- <?php //echo 'ncr_data: <pre>'; print_r($ncr_data); echo '</pre>'; ?> -->
	<p>NCR ID: <?php echo $ncr_data['ncr_id']; ?> has been updated by TKC. Following are the details:</p>
	<table>
		<tr>
			<th>NCR ID: </th>
			<td><?php echo $ncr_data['ncr_id']; ?></td>
		</tr>
		<tr>
			<th>Observation Type: </th>
			<td><?php echo $ncr_data['observation_name']; ?></td>
		</tr>
		<tr>
			<th>Observation: </th>
			<td><?php echo $ncr_data['remark']; ?></td>
		</tr>
		<tr>
			<th>Observation Photos: </th>
			<td>
				<?php foreach ($ncr_data['observation_files'] as $key => $value) { ?>
				<img src="<?php echo base_url($value['file_path']); ?>" width= "200">
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>Observation Photos uploaded by TKC: </th>
			<td>
				<?php foreach ($ncr_data['observation_tkc_files'] as $key => $value) { ?>
				<img src="<?php echo base_url($value['file_path']) ?>" width="200">
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>Completion Date</th>
			<td><?php echo (!empty($ncr_data['completion_date'])) ? date('d-m-Y', strtotime($ncr_data['completion_date'])) : ''; ?></td>
		</tr>
		<tr>
			<th>Completion Photos</th>
			<td>
				<?php if (!empty($ncr_data['observation_completion_files'])) {
						foreach ($ncr_data['observation_completion_files'] as $key => $value) {
				?>
				<img src="<?php echo base_url($value['file_path']) ?>" width="200">
				<?php  	} 
					  }
				?>
			</td>
		</tr>
	</table>
</body>
</html>