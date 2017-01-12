<?php

require_once __DIR__ . '/SimpleCache.class.php';
require_once __DIR__ . '/ServersCache.class.php';
require_once __DIR__ . '/AvailabilitiesCache.class.php';

class ServersAvailabilitiesCache extends SimpleCache {
	
	public function __construct() {
		parent::__construct('servers_availabilities_ws', 10);
	}
	
	
	public function realQuery() {
		$sc = new ServersCache();
		$servers = $sc->get();
		
		$ac = new AvailabilitiesCache();
		$availabilities = $ac->get();
		
		$res = array();
		foreach ($servers as $ref => $server) {
			$res[$ref]['server'] = $server;
			$res[$ref]['availabilities'] = $availabilities[$ref];
		}
		return $res;
	}
}
