<?php
	include("conexion.php");
	$respuesta="";

	$sql="SELECT id_accesorios, descripcion, caracteristicas FROM accesorios_incluidos WHERE estado=1";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}

	$respuesta="<datalist id='data-list-accesorios'>";
	while($registro=mysqli_fetch_row($resultado)){
		$idaccesorios=$registro[0];
		$descripcion=$registro[1];
		$caracteristicas=$registro[2];
		$respuesta=$respuesta."<option id='$idaccesorios' value='$descripcion'>$caracteristicas</option>";
	}
	$respuesta=$respuesta."</datalist>";

	echo $respuesta;
	$mysqli->close();
	exit;
?>