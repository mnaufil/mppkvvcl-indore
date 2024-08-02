<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<style type="text/css">
			table, tbody, td, th {
			  	border:1px solid black;
			  	border-collapse: collapse;
			},
			th {
				text-align: center;
			}

		</style>
	</head>
	<body>
		
		<div class="col-xl-12">
			<div class="col-xl-12">
				<h2 style="text-align: center;">TKC Weekly Plan</h2>
				 <p style="text-align: center;"> <span style="margin-right: 50px;">Date Range : <?php echo $date_range; ?></span> Lot No : <?php echo $package_group_no; ?></p> 
			</div>
		</div>
		<table>
			<thead>
				<th>Sr No.</th>
				<th>Lot No.</th>
				<th>Date of Work</th>
				<th>Day</th>
				<th>Name of Circle</th>
				<th>Name of Division</th>
				<th>Name of Site/Feeder</th>
				<th>Brief Description of work to be executed</th>
				<th>Remark</th>
			</thead>
			<tbody>
				<?php foreach ($weekly_plan_details as $key => $value) { ?>
				<tr>
					<td style="text-align: center;"><?php echo ++$key; ?></td>
					<td style="text-align: center;"><?php echo $value['package_no']; ?></td>
					<td style="text-align: center;"><?php echo $value['plan_date']; ?></td>
					<td style="text-align: center;"><?php echo $value['plan_day']; ?></td>
					<td style="text-align: center;"><?php echo $value['circle_name']; ?></td>
					<td style="text-align: center;"><?php echo $value['division_name']; ?></td>
					<td><?php echo $value['feeders']; ?></td>
					<td><?php echo $value['description']; ?></td>
					<td><?php echo $value['remark']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>


	</body>
</html>