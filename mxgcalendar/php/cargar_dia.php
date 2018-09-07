<?php
	include ("/../../php/functions.php");

	$hoy=_get_hoy();
	$exp=explode("-", $hoy);
	echo $exp[2];
?>