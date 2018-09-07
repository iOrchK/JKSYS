<?php
	include ("/../../php/functions.php");

	$cat=$_POST["txt-cat"];
	$mon=$_POST["txt-mon"];
	$des=$_POST["txt-des"];
	$est=$_POST["estado"];
	$fec=$_POST["txt-fec-egr"];

	$sql="INSERT INTO egresos(fecha, idCategoria, descripcion, monto, estado) VALUES('$fec', '$cat', '$des', '$mon', '$est')";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Egreso registrado!"; }

	//echo $cat." ".$mon." ".$des." ".$est." ".$fec;
	$mysqli->close();
	exit;
?>