<?php
	include ("/../../php/functions.php");

	$fecha=$_GET["fecha"];
	echo _convert_date($fecha);
	exit;
?>