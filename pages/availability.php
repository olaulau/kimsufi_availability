<?php

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
- store last mail send date & last unavailable date to prevent massive mail flood whena vailable
- get server list from HTML to have labels corresponding to ids
- configure display and cron throurh GUI (servers, zone ...)
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
$ws_url = "https://ws.ovh.com/dedicated/r2/ws.dispatcher/getAvailability2";
$seached_reference = "160sk1"; // KS1
//$seached_reference = "161sk2"; // KS-2E
$searched_zone = "fr";
$email_recipient = "olaulau@gmail.com";
$mail_cmd = '/data/home/a/d/admindl/bin/mail.sh'; //TODO try to use this directory
$mail_cmd = '/data/home/a/d/admindl/admindlweb/admin.d-l.fr-web/htdocs/kimsufi' . '/mail.sh';
$request_filename = '../data/getAvailability2.json';
$json_filename = '../data/availability.json';
$use_cache = true;


//  get data
if(!$use_cache) {
	//  fetch data
	if(!$use_cache) {
		$availability2_content = file_get_contents($ws_url);
		file_put_contents($request_filename, $availability2_content);
	}
	else {
		$availability2_content = file_get_contents($request_filename);
	}
	$availability2_object = json_decode($availability2_content);


	//  convert data to a zone-based array
	$availability_array = array();
	$array = $availability2_object->answer->availability;
	foreach($array as $element) {
		$availability_array[$element->reference] = array();
		foreach($element->metaZones as $metazone) {
			$availability_array[$element->reference][$metazone->zone] = $metazone->availability;
		}
	}
	//echo "<pre>";
	//var_dump($availability_array);
	//echo "</pre>";
	//die;
	file_put_contents($json_filename, json_encode($availability_array));
}
else {
	$availability_array = json_decode(file_get_contents($json_filename), true);
}



//  display data
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
	if(isset($availability_array[$seached_reference])) {
		if(isset($availability_array[$seached_reference][$searched_zone])) {
			if($availability_array[$seached_reference][$searched_zone] != "unavailable" ) {
				//echo "envoi email ... <br/>";
				$cmd = $mail_cmd . " " . $email_recipient . " " .
				"\"Kimsufi availability\"" . " " .
				"\"$seached_reference has availability " . $availability_array[$seached_reference][$searched_zone] . " in zone $searched_zone !!!";
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
		foreach(reset($availability_array) as $id => $value) {
			?>
			<th><?= $id ?></th>
			<?php
		}
		?>
	</tr>
	<?php
	
	foreach($availability_array as $id =>  $row) {
		?>
		<tr>
			<td><?= $id ?></td>
			<td><?= $row['centralEurope'] ?></td>
			<td><?= $row['fr'] ?></td>
			<td><?= $row['northAmerica'] ?></td>
			<td><?= $row['westernEurope'] ?></td>
			<td><?= $row['hardzone'] ?></td>
		</tr>
		<?php
	}
	?>
	</table>
</body>
</html>


