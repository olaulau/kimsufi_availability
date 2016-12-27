<?php

class SimpleGetterThread extends Thread {
	//TODO transform to be handled by background processes
	
	private $className;

	public function __construct($className) {
		require_once __DIR__ . '/' . $className . '.class.php';
		$this->className = $className;
	}
	
	public function run() {
		$o = new $className();
		$o->get();
	}
}
