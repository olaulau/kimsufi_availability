<?php

require_once '../classes/ServersAvailabilitiesCache.class.php';


// get data
$sac = new ServersAvailabilitiesCache();
$sa = $sac->get();


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
			<?php
			foreach(reset($sa) as $header => $val) {
				?>
				<th><?= $header ?></th>
				<?php
			}
			?>
		</tr>
		<?php
		foreach($sa as $ref => $server) {?>
			<tr>
				<td><?= $ref ?></td>
			<?php
			foreach ($server as $val) {
				?>
				<td><?= $val ?></td>
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

