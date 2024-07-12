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
	<?php //echo 'ncr_data: <pre>'; print_r($ncr_data); echo '</pre>'; die();?>
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
				<!-- <?php //foreach ($ncr_data['observation_files'] as $key => $value) { ?>
				<img src="<?php //echo base_url($value['file_path']); ?>" width= "200">
				<?php //} ?> -->
				<!-- <?php 	//$obs_files = explode(', ', $ncr_data['observation_files']); 
						//$obs_files = $ncr_data['observation_files'];
						//for ($i = 0; $i < count($obs_files); $i++) {
				?>
				<img src="<?php //echo $obs_files[$i]; ?>" width="100" height="100">
				<br/><br/>
				<?php 	//}
				?> -->

				<?php  	$obs_files = $ncr_data['observation_files'];
						foreach ($obs_files as $key => $value) {
							//foreach ($value as $k => $v) {
				?>
				<img src="cid:<?php echo $key; ?>" width="100" height="100">
				<br/><br/>
				<?php		//}
						}
				?>
			</td>
		</tr>
		<tr>
			<th>Observation Photos uploaded by TKC: </th>
			<td>
				<!-- <?php //foreach ($ncr_data['observation_tkc_files'] as $key => $value) { ?>
				<img src="<?php //echo base_url($value['file_path']) ?>" width="200">
				<?php //} ?> -->
				<!-- <?php 	//$obs_files_by_tkc = explode(', ', $ncr_data['observation_tkc_files']); 
						//$obs_files_by_tkc = $ncr_data['observation_tkc_files'];
						//for ($i = 0; $i < count($obs_files_by_tkc); $i++) {
				?>
				<img src="<?php //echo $obs_files_by_tkc[$i]; ?>" width="100" height="100">
				<br/><br/>
				<?php 	//}
				?> -->

				<?php  	$obs_files_by_tkc = $ncr_data['observation_tkc_files'];
						foreach ($obs_files_by_tkc as $key => $value) {
							//foreach ($value as $k => $v) {
				?>
				<img src="cid:<?php echo $key; ?>" width="100" height="100">
				<br/><br/>
				<?php		//}
						}
				?>
			</td>
		</tr>
		<tr>
			<th>Completion Date</th>
			<td><?php echo (!empty($ncr_data['completion_date'])) ? date('d-m-Y', strtotime($ncr_data['completion_date'])) : ''; ?></td>
		</tr>
		<tr>
			<th>Completion Photos</th>
			<td>
				<!-- <?php //if (!empty($ncr_data['observation_completion_files'])) {
						//foreach ($ncr_data['observation_completion_files'] as $key => $value) {
				?>
				<img src="<?php //echo base_url($value['file_path']) ?>" width="200">
				<?php  	//} 
					  //}
				?> -->
				<!-- <?php 	//if (!empty($ncr_data['observation_completion_files'])) {
							//$obs_completion_files = explode(', ', $ncr_data['observation_completion_files']);
							//for ($i = 0; $i < count($obs_completion_files); $i++) { 
				?>
				<img src="<?php //echo $obs_completion_files[$i] ?>" width="100" height="100">
				<br/><br/>
				<?php		//}
						//} 
				?> -->

				<?php  	$obs_completion_files = $ncr_data['observation_completion_files'];
						foreach ($obs_completion_files as $key => $value) {
							//foreach ($value as $k => $v) {
				?>
				<img src="cid:<?php echo $key; ?>" width="100" height="100">
				<br/><br/>
				<?php		//}
						}
				?>
			</td>
		</tr>
	</table>
</body>
</html>