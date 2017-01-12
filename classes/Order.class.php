<?php

class Order {
	
	private $_ref;
	
	
	public function __construct($ref) {
		$this->_ref = $ref;
	}
	
	public function getUrl() {
		return 'https://www.kimsufi.com/fr/commande/kimsufi.xml?reference=' . $this->_ref;
	}
	
	public function getCpuModel() {
		
	}
	
	public function getAnonymousSession() {
		/*
		https://ws.ovh.com/sessionHandler/r4/ws.dispatcher/getAnonymousSession?callback=angular.callbacks._0&params=%7B%22language%22:%22fr%22%7D
		
		angular.callbacks._0(
		{"answer":{"__class":"sessionType:sessionWithToken","session":{"__class":"sessionType:session","language":"fr","billingCountry":null,"id":"classic/anonymous-f838e6268842f6b9de34171cf5e5823c","startDate":"2017-01-12T00:18:03+01:00","login":null},"token":null},"version":"1.0","error":null,"id":0}
		);
		
		https://ws.ovh.com/sessionHandler/r4/ws.dispatcher/getAnonymousSession?callback=angular.callbacks._0&params=%7B%22language%22:%22fr%22%7D
		 */
	}
	
	public function getPossibleDurationAndFee() {
		/*
		https://ws.ovh.com/order/dedicated/servers/ws.dispatcher/getPossibleDurationsAndFees?callback=angular.callbacks._1&params=%7B%22sessionId%22:%22classic%2Fanonymous-f838e6268842f6b9de34171cf5e5823c%22,%22billingCountry%22:%22KSFR%22,%22dedicatedServer%22:%22161sk2%22%7D
		
		angular.callbacks._1(
		{"answer":{"cost":[{"__class":"dedicatedServersType:subscriptionAndFee","fee":{"__class":"dedicatedServersType:fees","installation":{"__class":"dedicatedServersType:installation","progressive":-1,"directly":9.99}},"duration":"1m","subscription":14.99},{"__class":"dedicatedServersType:subscriptionAndFee","fee":{"__class":"dedicatedServersType:fees","installation":{"__class":"dedicatedServersType:installation","progressive":-1,"directly":9.99}},"duration":"12m","subscription":14.99},{"__class":"dedicatedServersType:subscriptionAndFee","fee":{"__class":"dedicatedServersType:fees","installation":{"__class":"dedicatedServersType:installation","progressive":-1,"directly":9.99}},"duration":"3m","subscription":14.99},{"__class":"dedicatedServersType:subscriptionAndFee","fee":{"__class":"dedicatedServersType:fees","installation":{"__class":"dedicatedServersType:installation","progressive":-1,"directly":9.99}},"duration":"6m","subscription":14.99}],"__class":"dedicatedServersType:installationFeesAndModes","server":{"__class":"dedicatedServersType:server","reference":{"designation":"Serveur Kimsufi KS - 4G Atom N2800 1x2000 Go","__class":"dedicatedServersType:reference","price":14.99},"name":null,"range":null}},"version":"1.0","error":null,"id":0}
		);
		*/
	}
}
