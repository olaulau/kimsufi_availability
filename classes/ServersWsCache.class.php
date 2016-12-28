<?php

require_once __DIR__ . '/SimpleCache.class.php';

class ServersWsCache extends SimpleCache {
	
	public function __construct() {
		parent::__construct('servers_ws', 10);
	}
	
	
	public function realQuery() {
		//  config
		$url = 'https://www.kimsufi.com/fr/serveurs.xml';
		
		//  get data
		$content = file_get_contents($url);
		return $content;
	}
}
