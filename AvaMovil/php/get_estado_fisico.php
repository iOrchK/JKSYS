<?php
	include ("conexion.php");
	$respuesta="";

	$sql="SELECT id_estado_fisico, descripcion, caracteristicas FROM estados_fisicos WHERE estado = 1";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}

	$respuesta="<datalist id='data-list-estados'>";
	while($registro=mysqli_fetch_row($resultado)){
		$idestadofisico=$registro[0];
		$descripcion=$registro[1];
		$caracteristicas=$registro[2];
		$respuesta=$respuesta."<option id='$idestadofisico' value='$descripcion'>$caracteristicas</option>";
	}
	$respuesta=$respuesta."</datalist>";

	echo $respuesta;
	$mysqli->close();
	exit;
?>