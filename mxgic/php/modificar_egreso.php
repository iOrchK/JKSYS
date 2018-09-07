<?php
	include ("/../../php/functions.php");

	$fol=$_POST["txt-fol"];
	$cat=$_POST["txt-cat"];
	$mon=$_POST["txt-mon"];
	$des=$_POST["txt-des"];
	$est=$_POST["estado"];
	$fec=$_POST["txt-fec-egr"];

	$sql="UPDATE egresos SET fecha='$fec', idCategoria='$cat', descripcion='$des', monto='$mon', estado='$est' WHERE id='$fol'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Egreso modificado!"; }

	//echo $cat." ".$mon." ".$des." ".$est." ".$fec;
	$mysqli->close();
	exit;
?>