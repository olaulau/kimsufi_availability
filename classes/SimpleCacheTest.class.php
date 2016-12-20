<?php

require_once 'SimpleCache.class.php';

class SimpleCacheTest extends SimpleCache {
	
	public function realQuery() {
		return 'TEST @ ' . time();
	}
}

