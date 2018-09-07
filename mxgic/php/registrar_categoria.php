<?php
	include ("/../../php/functions.php");

	$cat=$_GET["cat"];

	$sql="INSERT INTO categresos(descripcion) VALUES('$cat')";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Categoría registrada!"; }
	
	$mysqli->close();
	exit;
?>