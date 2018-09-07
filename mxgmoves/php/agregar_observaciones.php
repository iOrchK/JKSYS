<?php
	include ("/../../php/functions.php");

	$folemp=$_GET["folemp"];
	$observ=$_GET["obs"];
	$sql="UPDATE datos_generales SET observacion='$observ' WHERE id='$folemp'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Se modificaron las observaciones del movimiento seleccionado!"; }
	
	$mysqli->close();
	exit;
?>