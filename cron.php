#!/usr/bin/php
<?php

/*
crontab example :
*	*	*	*	*	cd <dir>/kimsufi_availability/ && /usr/bin/php cron.php 2>&1
*/

require_once __DIR__ . '/classes/ServersAvailabilitiesCache.class.php';
require_once __DIR__ . '/config.inc.php';


$not_available = 'unavailable';


// get data
$sac = new ServersAvailabilitiesCache();
$sa = $sac->get();


//  display data
foreach ($sa as $ref => $server) {
	if($ref === $conf['searched_ref']) {
		foreach ($server as $zone => $availability) {
			if($zone === $conf['searched_zone']) {
				if($availability !== $not_available) {
					echo 'kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!';
					$cmd = 'cd ./scripts/ && ./mail.sh ' . $conf['recipient_email'] . ' "kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!" "kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!"';
					exec ( $cmd.' 2>&1' , $output , $return_var );
					
					echo "<pre>$cmd</pre>";
					echo "<pre>$return_var</pre>";
					echo "<pre>" . var_export($output, true) . "</pre>";
				}
			}
		}
	}
}
