<?php

require_once '../classes/AvailabilitiesCache.class.php';


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
	if($debug)
		echo "command = <pre> " . var_export($cmd, true) . "</pre>";
	exec ($cmd_full, $output, $res);
	if($debug)
		echo "output = <pre> " . var_export($output, true) . "</pre>";
	if($debug)
		echo "return status = <pre> " . var_export($res, true) . "</pre>";
	return $output;
}
/*
$cmd = 'whoami';
exec_cmd($cmd, true);
die;
*/


//  config
$seached_reference = "160sk1"; // KS1
//$seached_reference = "161sk2"; // KS-2E
$searched_zone = "fr";
$email_recipient = "olaulau@gmail.com";
$mail_cmd = '/data/home/a/d/admindl/bin/mail.sh'; //TODO try to use this directory
$mail_cmd = '/data/home/a/d/admindl/admindlweb/admin.d-l.fr-web/htdocs/kimsufi' . '/mail.sh';


//  get data
$ac = new AvailabilitiesCache();
$availabilities = $ac->get();
$zones = array();
foreach(reset($availabilities) as $id => $value) {
	$zones[] = $id;
}


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Availability</title>
</head>
<body>
	<?php
	//  search and notify
	if(isset($availabilities[$seached_reference])) {
		if(isset($availabilities[$seached_reference][$searched_zone])) {
			if($availabilities[$seached_reference][$searched_zone] != "unavailable" ) {
				//echo "envoi email ... <br/>";
				$cmd = $mail_cmd . " " . $email_recipient . " " .
				"\"Kimsufi availability\"" . " " .
				"\"$seached_reference has availability " . $availabilities[$seached_reference][$searched_zone] . " in zone $searched_zone !!!";
				//echo $cmd; die;
				$output = exec_cmd($cmd, true);
				//die;
			}
		}
	}
	
	
	//  display table
	?>
	<table>
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
</body>
</html>

