<?php

require_once 'SimpleCache.class.php';
require_once 'ServersWsCache.class.php';

class ServersCache extends SimpleCache {
	
	public function __construct() {
		parent::__construct('servers', 10);
	}
	
	
	public function realQuery() {
		//  get data
		$swc = new ServersWsCache();
		$content = $swc->get();
		$doc = new DOMDocument();
		@$doc->loadHTML($content);
	
		$rows = $doc->getElementsByTagName('tr');
		$res = array();
		foreach($rows as $row) {
			$ref = $row->getAttribute('data-ref');
			if(!empty($ref)) {
				$actions = $row->getAttribute('data-actions');
				$availability = $row->getAttribute('data-availability');
				$cols = $row->getElementsByTagName('td');
				foreach($cols as $id => $col) {
					if($id === 0) {
						// server name
						$spans = $col->getElementsByTagName('span');
						$span = $spans->item(0);
						$name = $col->nodeValue;
					}
					if($id === 9) {
						// price
						$spans = $col->getElementsByTagName('span');
						$span = $spans->item(0);
						$price = $span->nodeValue;
						$span = $spans->item(2);
						$currency = $span->nodeValue;
					}
				}
				$res[$ref] = array(
						'actions' => $actions,
						'availability' => $availability,
						'name' => $name,
						'price' => $price,
						'currency' => $currency,
				);
			}
		}
		
		return $res;
	}
}
