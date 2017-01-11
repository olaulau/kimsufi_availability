<?php

require_once __DIR__ . '/SimpleCache.class.php';
require_once __DIR__ . '/ServersWsCache.class.php';

class ServersCache extends SimpleCache {
	
	public function __construct() {
		parent::__construct('servers', 10);
	}
	
	
	// http://stackoverflow.com/questions/2087103/how-to-get-innerhtml-of-domnode/2087136#2087136
	private static function DOMinnerHTML(DOMNode $element) {
		$innerHTML = "";
		$children  = $element->childNodes;
		
		foreach ($children as $child)
		{
			$innerHTML .= $element->ownerDocument->saveHTML($child);
		}
		
		return $innerHTML;
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
				
				// server name
				$col = $cols->item(0);
				$spans = $col->getElementsByTagName('span');
				$span = $spans->item(0);
				$name = $col->nodeValue;
				
				// cpu
				$col = $cols->item(1);
				$cpu = explode('<br>', str_replace('™', '', self::DOMinnerHTML($col)));
				
				// indice
				$col = $cols->item(2);
				$indice = explode('<br>', self::DOMinnerHTML($col));
				
				// cores
				$col = $cols->item(3);
				$cores = explode('<br>', self::DOMinnerHTML($col));
				
				// freq
				$col = $cols->item(4);
				$freq = explode('<br>', self::DOMinnerHTML($col));
				
				// ram
				$col = $cols->item(5);
				$ram = $col->nodeValue;
				
				// disk
				$col = $cols->item(6);
				$disk = $col->nodeValue;
				
				// network
				$col = $cols->item(7);
				$network = $col->nodeValue;
				
				// ipv6
				$col = $cols->item(8);
				$ipv6 = $col->nodeValue;
				
				// price
				$col = $cols->item(9);
				$spans = $col->getElementsByTagName('span');
				$span = $spans->item(0);
				$price = $span->nodeValue;
				$span = $spans->item(2);
				$currency = $span->nodeValue;

				
				$res[$ref] = array(
// 					'actions' => $actions,
// 					'availability' => $availability,
					'name' => $name,
					'cpu' => $cpu,
					'indice' => $indice,
					'cores' => $cores,
					'freq' => $freq,
					'ram' => $ram,
					'disk' => $disk,
					'network' => $network,
					'ipv6' => $ipv6,
					'price' => $price,
					'currency' => $currency,
				);
			}
		}
		
		return $res;
	}
}
