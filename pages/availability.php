<?php

require_once __DIR__ . '/../classes/AvailabilitiesCache.class.php';


/* data structure :
answer
availability
[]
reference = 
metaZones
availability
*/

/* ideas :
- separate CLI and web
- use cache to prevent web DDOS (30s)
- cron every minute, send email if available
- store last mail send date & last unavailable date to prevent massive mail flood when available
- configure display and cron through GUI (servers, zone ...)
*/


function exec_cmd($cmd, $debug=false, $path='') {
	$prefix = 'PATH=$PATH:/usr/bin:'.$path.' &&';
	$suffix = '2>&1';
	$cmd_full = "$prefix $cmd $suffix";
	exec ($cmd_full, $output, $res);
	if($debug) {
		echo "command = <pre> " . var_export($cmd, true) . "</pre>";
		echo "output = <pre> " . var_export($output, true) . "</pre>";
		echo "return status = <pre> " . var_export($res, true) . "</pre>";
	}
	return $output;
}
/*
$cmd = 'whoami';
exec_cmd($cmd, true);
die;
*/


//  get data
$ac = new AvailabilitiesCache();
$availabilities = $ac->get();
$zones = array();
foreach(reset($availabilities) as $id => $value) {
	$zones[] = $id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Availability</title>
<!-- Bootstrap -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<?php
	//  display table
	?>
	<table class="table">
	<tr>
		<th>server</th>
		<?php
		foreach($zones as $zone) {
			?>
			<th><?= $zone ?></th>
			<?php
		}
		?>
	</tr>
	
	<?php
	foreach($availabilities as $ref => $availability) {
		?>
		<tr>
			<td><?= $ref ?></td>
			<?php
			foreach ($zones as $zone) {
				?>
				<td><?= $availabilities[$ref][$zone] ?></td>
				<?php
			}
			?>
		</tr>
		<?php
	}
	?>
	</table>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../vendor/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>