<?php
	include ("conexion.php");
	$respuesta="";

	$sql="SELECT id_movil, descripcion, precio_nuevo FROM moviles WHERE estado = 1 ORDER BY descripcion";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}

	$respuesta="<datalist id='data-list-dispositivos'>";
	while($registro=mysqli_fetch_row($resultado)){
		$id=$registro[0];
		$descripcion=$registro[1];
		$precionuevo=$registro[2];
		$explode=split(": ", $descripcion);
		$descripcion=$explode[0];
		$respuesta=$respuesta."<option id='$id' value='$descripcion'>$$precionuevo</option>";
	}
	$respuesta=$respuesta."</datalist>";

	echo $respuesta;
	$mysqli->close();
	exit;
?>