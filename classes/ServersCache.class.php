<?php

require_once 'SimpleCache.class.php';

class ServersCache extends SimpleCache {
	
	public function __construct() {
		parent::__construct('servers', 10);
	}
	
	
	public function realQuery() {
		//  config
		$url = 'https://www.kimsufi.com/fr/serveurs.xml';
		
		//  get data
		$doc = new DOMDocument();
		@$doc->loadHTMLFile($url);
	
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
						$name = $span->ownerDocument->saveHTML($span);
					}
					if($id === 9) {
						// price
						$spans = $col->getElementsByTagName('span');
						$span = $spans->item(1);
						$price = $span->nodeValue;
						$span = $spans->item(3);
						$currency = $span->nodeValue;
					}
				}
				$res[] = array(
						'ref' => $ref,
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
