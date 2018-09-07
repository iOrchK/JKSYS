<?php
	include ("/../../php/functions.php");

	$folref=$_GET["folref"];
	$observ=$_GET["obs"];
	$sql="UPDATE refrendos SET observaciones='$observ' WHERE id='$folref'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Se modificaron las observaciones del ingreso seleccionado!"; }
	
	$mysqli->close();
	exit;
?>