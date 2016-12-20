<?php

require_once 'SimpleCache.class.php';

class AvailabilitiesCache extends SimpleCache {

	public function __construct() {
		parent::__construct('availability', 10);
	}


	public function realQuery() {
		//  config
		$ws_url = "https://ws.ovh.com/dedicated/r2/ws.dispatcher/getAvailability2";	
		
		//  fetch data
		$availability2_content = file_get_contents($ws_url);
		$availability2_object = json_decode($availability2_content);
	
		//  convert data to a zone-based array
		$res = array();
		$array = $availability2_object->answer->availability;
		foreach($array as $element) {
			$res[$element->reference] = array();
			foreach($element->metaZones as $metazone) {
				$res[$element->reference][$metazone->zone] = $metazone->availability;
			}
		}

		return $res;
	}
}
