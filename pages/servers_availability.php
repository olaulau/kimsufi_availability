<?php

require_once '../classes/ServersCache.class.php';
require_once '../classes/AvailabilitiesCache.class.php';


// get data
$sc = new ServersCache();
$servers = $sc->get();

$ac = new AvailabilitiesCache();
$availabilities = $ac->get();
$zones = array();
foreach(reset($availabilities) as $id => $value) {
	$zones[] = $id;
}


//  display data
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Servers availability</title>
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
			<?php
			foreach($zones as $zone) {
				?>
				<th><?= $zone ?></th>
				<?php
			}
			?>
		</tr>
		<?php
		foreach($servers as $ref => $server) {
			?>
			<tr>
				<td><?= $ref ?></td>
				<td><?= $server['actions'] ?></td>
				<td><?= $server['availability'] ?></td>
				<td><?= $server['name'] ?></td>
				<td><?= $server['price'] ?></td>
				<td><?= $server['currency'] ?></td>
				<?php
				foreach ($zones as $zone) {
					?>
					<td><?= $availabilities[$ref][$zone] ?></td>
					<?php
				}
				?>
			</tr>
			<?php
		}
		?>
	</table>
</body>
</html>

