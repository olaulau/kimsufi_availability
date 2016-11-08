<?php

//  config
$url = 'https://www.kimsufi.com/fr/serveurs.xml';
$json_filename = '../data/servers.json';
$use_cache = true;


//  get data
if(!$use_cache) {
	$doc = new DOMDocument();
	@$doc->loadHTMLFile($url);

	$rows = $doc->getElementsByTagName('tr');
	$json_array = array();
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
			$json_array[] = array(
				'ref' => $ref,
				'actions' => $actions,
				'availability' => $availability,
				'name' => $name,
				'price' => $price,
				'currency' => $currency,
			);
		}
	}

	file_put_contents($json_filename, json_encode($json_array));
}
else {
	$json_array = json_decode(file_get_contents($json_filename), true);
}


//  display data
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Servers</title>
</head>
<body>
	<table>
		<tr>
			<th>ref</th>
			<th>actions</th>
			<th>availability</th>
			<th>name</th>
			<th>price</th>
			<th>currency</th>
		</tr>
		<?php
		foreach($json_array as $row) {
			?>
			<tr>
				<td><?= $row['ref'] ?></td>
				<td><?= $row['actions'] ?></td>
				<td><?= $row['availability'] ?></td>
				<td><?= $row['name'] ?></td>
				<td><?= $row['price'] ?></td>
				<td><?= $row['currency'] ?></td>
			</tr>
			<?php
		}
		?>
	</table>
</body>
</html>

