<?php

class Searched {
	
	private static $searched_filename = __DIR__ . '/../data/searched.json';
	
	private $tab = NULL;
	
	
	public function load() {
		if(file_exists(self::$searched_filename)) {
			$this->tab = json_decode(file_get_contents(self::$searched_filename), TRUE);
		}
		else {
			$this->tab = array();
		}
	}
	
	public function save() {
		file_put_contents(self::$searched_filename, json_encode($this->tab));
	}
	
	
	public function getAvailability($res, $zone) {
		//TODO uninitialized exception if tab not array
		if(isset($this->tab[$res.'_'.$zone])) {
			return $this->tab[$res.'_'.$zone]['availability'];
		}
		else { // maybe a new searched added to config file
			return NULL;
		}
		
	}
	
	public function getTime($res, $zone) {
		//TODO uninitialized exception if tab not array
		return $this->tab[$res.'_'.$zone]['time'];
	}
	
	public function setAvailability($res, $zone, $availability) {
		$this->tab[$res.'_'.$zone] = array('availability' => $availability, 'time' => time());
	}
	
}
