#!/usr/bin/php
<?php

/*
 * crontab example :
 * *      *       *       *       *       cd <dir>/kimsufi_availability/ && ./cron.php 2>&1
 */

require_once './classes/ServersAvailabilitiesCache.class.php';

$searched_ref = '160sk1';
$searched_zone = 'fr';
$not_available = 'unavailable';


// get data
$sac = new ServersAvailabilitiesCache();
$sa = $sac->get();


//  display data
foreach ($sa as $ref => $server) {
	if($ref === $searched_ref) {
		foreach ($server as $zone => $availability) {
			if($zone === $searched_zone) {
				if($availability !== $not_available) {
// 					echo 'kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!';
					$cmd = 'cd ./scripts/ && ./mail.sh email@gmail.com "kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!" "kimsufi server ' . $server['name'] . ' is available ' . $availability . ' in zone ' . $zone . ' !!!"';
					exec ( $cmd.' 2>&1' , $output , $return_var );
					
					echo "<pre>$cmd</pre>";
					echo "<pre>$return_var</pre>";
					echo "<pre>" . var_export($output, true) . "</pre>";
				}
			}
		}
	}
}
