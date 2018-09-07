<?php
	include ("conexion.php");
	$respuesta="";

	$sql="SELECT MAX(id_movil) FROM moviles";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1;
		echo $respuesta;
		$mysqli->query();
		exit;
	}

	if($registro=mysqli_fetch_row($resultado)){ $respuesta=$registro[0]+1; }

	echo $respuesta;
	$mysqli->close();
	exit;
?>