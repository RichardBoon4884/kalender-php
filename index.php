<?php 
	include "core.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="style/main.css">
	<script type="text/javascript" src="scripts/main.js"></script>
	<script type="text/javascript" src="scripts/jquery-3.1.1.min.js"></script>
</head>
<body>
	<nav id="top"><h1>Kalander</h1><span id="buttonAdd">Toevoegen</span></nav>
	<?php 
		echo $htmlCalander;
	?>
</body>
</html>