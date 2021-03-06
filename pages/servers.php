<?php

require_once __DIR__ . '/../classes/ServersCache.class.php';

$sc = new ServersCache();
$servers = $sc->get();

$cols = array();
foreach (reset($servers) as $col => $value) {
	$cols[] = $col;
}


//  display data
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Servers</title>
<!-- Bootstrap -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<table class="table">
		<tr>
			<th>ref</th>
			<?php
			foreach ($cols as $col) {
				?>
				<th><?= $col ?></th>
				<?php
			}
			?>
		</tr>
		<?php
		foreach($servers as $ref => $row) {
			?>
			<tr>
				<td><?= $ref ?></td>
				<?php
				foreach ($cols as $col) {
					?>
					<td><?= is_array($row[$col]) ? implode('<br>', $row[$col]) : $row[$col] ?></td>
					<?php
				}
				?>
			</tr>
			<?php
		}
		?>
	</table>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../vendor/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>