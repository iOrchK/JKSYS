<?php
	include ("../../php/functions.php");

	$id=$_GET["id"];
	$sql="SELECT id, fecha, cotitular, capital, tasa, interes, descripcion, caracteristicas, anclaje, entregaInmediata, validado, estado, observacion FROM datos_generales WHERE id='$id'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$datos="";
		while($registro=mysqli_fetch_row($resultado)){
			$datos=$datos.$registro[0]."/-/".$registro[1]."/-/".$registro[2]."/-/".$registro[3]."/-/".$registro[4]."/-/".$registro[5]."/-/".$registro[6]."/-/".$registro[7]."/-/".$registro[8]."/-/".$registro[9]."/-/".$registro[10]."/-/".$registro[11]."/-/".$registro[12];
		}
		echo $datos;
	}

	$mysqli->close();
	exit;
?>