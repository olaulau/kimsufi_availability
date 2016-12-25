<?php

require_once __DIR__ . '/../classes/ServersCache.class.php';

$sc = new ServersCache();
$servers = $sc->get();


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
		foreach($servers as $ref => $row) {
			?>
			<tr>
				<td><?= $ref ?></td>
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

