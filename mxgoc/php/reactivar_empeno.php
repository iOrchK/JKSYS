<?php
	include ("../../php/functions.php");

	$folio=$_GET["folio"];
	$sql="UPDATE datos_generales SET estado='Vigente' WHERE id='$folio'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ $msg="✔ Operación reactivada!"; }

	echo $msg;
	$mysqli->close();
	exit;
?>