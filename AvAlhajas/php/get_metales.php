<?php
	include("conexion.php");
	$respuesta="";

	$sql="SELECT A.id_metal, A.descripcion, B.valor_comercial FROM metales A, valuaciones B WHERE A.estado=1 AND B.id_estado_fisico=1 AND B.id_metal=A.id_metal";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}

	$respuesta="<datalist id='dat-list-metal'>";
	while($registro=mysqli_fetch_row($resultado)){
		$idmetal=$registro[0];
		$descripcion=$registro[1];
		$valorcomercial=$registro[2];
		$respuesta=$respuesta."<option id='$idmetal' value='$descripcion'>$$valorcomercial</option>";
	}
	$respuesta=$respuesta."</datalist>";

	echo $respuesta;
	$mysqli->close();
	exit;
?>