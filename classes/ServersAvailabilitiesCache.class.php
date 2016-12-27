<?php

require_once __DIR__ . '/SimpleCache.class.php';
require_once __DIR__ . '/ServersCache.class.php';
require_once __DIR__ . '/AvailabilitiesCache.class.php';
require_once __DIR__ . '/SimpleGetterThread.class.php';

class ServersAvailabilitiesCache extends SimpleCache {
	
	public function __construct() {
		parent::__construct('servers_availabilities_ws', 10);
	}
	
	
	public function realQuery() {
		// precache  with multiple threads
		$sct = new SimpleGetterThread('ServersCache');
		$sct->start();
		$sat = new SimpleGetterThread('AvailabilitiesCache');
		$sat->start();
		$sct->join();
		$sat->join();
		
		// re get from cache
		$sc = new ServersCache();
		$servers = $sc->get();
		
		$ac = new AvailabilitiesCache();
		$availabilities = $ac->get();
		
		// data treatment
		$zones = array();
		foreach(reset($availabilities) as $id => $value) {
			$zones[] = $id;
		}
		
		$res = array();
		foreach ($servers as $ref => $server) {
			$res[$ref] = $server;
			foreach($zones as $zone) {
				$res[$ref][$zone] = $availabilities[$ref][$zone];
			}
		}
		
		return $res;
	}
}
