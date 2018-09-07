<?php
	include ("/../../php/functions.php");

	$fol=$_GET["folio"];

	$sql="UPDATE egresos SET estado='Cargado' WHERE id='$fol'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Egreso reactivado!"; }

	//echo $fol;
	$mysqli->close();
	exit;
?>