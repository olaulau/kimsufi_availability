#!/usr/bin/php
<?php

/*
crontab example :
*	*	*	*	*	cd <dir>/kimsufi_availability/ && /usr/bin/php cron.php 2>&1
*/

require_once __DIR__ . '/classes/ServersAvailabilitiesCache.class.php';
require_once __DIR__ . '/classes/Searched.class.php';
require_once __DIR__ . '/config.inc.php';


$not_available = 'unavailable';


// get data
$sac = new ServersAvailabilitiesCache();
$sa = $sac->get();

$searched = new Searched();
$searched->load();


function is_searched($ref, $zone) {
	global $conf;
	foreach ($conf['searched'] as $searched) {
		if($searched['ref'] == $ref  &&  $searched['zone'] == $zone) {
			return TRUE;
		}
	}
	return FALSE;
}


//  display data
foreach ($sa as $ref => $server) {
	foreach ($server as $zone => $availability) {
		if(is_searched($ref, $zone)) {
			$last_availability = $searched->getAvailability($ref, $zone);
			if($availability !== $not_available  &&  $availability !== $last_availability) { // is available
				$searched->setAvailability($ref, $zone, $availability);
				$message = 'kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!';
				echo $message;
				$cmd = 'cd ./scripts/ && ./mail.sh ' . $conf['recipient_email'] . ' "' . $message . '" "' . $message . '"';
				exec ( $cmd.' 2>&1' , $output , $return_var );
				echo "<pre>$cmd</pre>";
				echo "<pre>$return_var</pre>";
				echo "<pre>" . var_export($output, true) . "</pre>";
			}
			else if($availability === $not_available  &&  $availability !== $last_availability  &&  $availability !== NULL) { // became unavailable
				$searched->setAvailability($ref, $zone, $availability);
				$message = 'kimsufi server ' . $server['name'] . ' is ' . $availability . ' in zone ' . $zone . ' !!!';
				echo $message;
				$cmd = 'cd ./scripts/ && ./mail.sh ' . $conf['recipient_email'] . ' "' . $message . '" "' . $message . '"';
				exec ( $cmd.' 2>&1' , $output , $return_var );
				echo "<pre>$cmd</pre>";
				echo "<pre>$return_var</pre>";
				echo "<pre>" . var_export($output, true) . "</pre>";
			}
		}
	}
}


// save data
$searched->save();
