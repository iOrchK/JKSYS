<?php
	include ("../../php/functions.php");

	$hoy=_get_hoy();
	$hoy=_cut_date_yyyymm($hoy);
	echo $hoy;
?>