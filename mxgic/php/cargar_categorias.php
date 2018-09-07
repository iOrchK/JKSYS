<?php
	include ("/../../php/functions.php");
	$datos="";

	$sql="SELECT id, descripcion FROM catEgresos ORDER BY descripcion ASC";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){ 
		while($registro=mysqli_fetch_row($resultado)){
			$datos=$datos."<option id='$registro[0]' value='$registro[1]'></option>";
		}
		echo $datos;
	}
	
	$mysqli->close();
	exit;
?>