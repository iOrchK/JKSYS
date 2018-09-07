<?php
	include ("../../php/functions.php");

	$folio=$_GET["folio"];
	$sql="UPDATE datos_generales SET estado='Cancelado' WHERE id='$folio'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ $msg="✔ Operación cancelada!"; }

	echo $msg;
	$mysqli->close();
	exit;
?>