<?php
	include ("/../../php/functions.php");

	$datos="";

	$sql="SELECT MAX(id) FROM egresos";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){ 
		while($registro=mysqli_fetch_row($resultado)){
			$datos=$registro[0]+1;
		}
		echo $datos;
	}
	
	$mysqli->close();
	exit;
?>