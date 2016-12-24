<?php

abstract class SimpleCache {

	private static $cacheDir = '../data';
	
	private $name;
	private $ttl;
	
	
	public function __construct($name, $ttl) {
		$this->name = $name;
		$this->ttl = $ttl;
	}
	
	private function filename() {
		return __DIR__ . '/' . self::$cacheDir . '/' . $this->name . '.json';
	}
	
	private function hasExpired() {
		if(file_exists($this->filename())) {
			$stat = stat($this->filename());
			$file_last_mod = $stat['mtime'];
			return ($file_last_mod + $this->ttl <= time());
		}
		else {
			return TRUE;
		}
	}
	
	
	public function get() {
		if($this->hasExpired()) {
			$data = $this->realQuery();
			$this->set($data);
		}
		else {
			$data = json_decode(file_get_contents($this->filename()), TRUE);
		}
		return $data;
	}
	
	public abstract function realQuery();
	
	
	public function set($data) {
		file_put_contents($this->filename(), json_encode($data));
	}
	
}

