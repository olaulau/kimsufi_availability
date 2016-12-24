<?php

require_once __DIR__ . '/SimpleCache.class.php';

class SimpleCacheTest extends SimpleCache {
	
	public function realQuery() {
		return 'TEST @ ' . time();
	}
}

