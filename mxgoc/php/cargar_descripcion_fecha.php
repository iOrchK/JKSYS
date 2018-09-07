<?php
	include ("../../php/functions.php");

	$fecha=$_GET["fecha"];

	if($fecha==="" || $fecha==="0//-2000"){
		$feconv="";
	}else{
		$feconv=_convert_date_lit($fecha);
	}

	echo $feconv;
	exit;
?>