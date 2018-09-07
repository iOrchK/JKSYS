<?php
	/***************** INICIAR CONEXIÓN A LA BD *******************/
	include ("conexion.php");
	
	/***************** INICIAR VARIABLES ******************/
	$respuesta="";
	$id=$_POST["txt-cod-movil"];
	$descripcion=$_POST["txt-descripcion"];
	$yearlanzamiento=$_POST["txt-año-lanzamiento"];
	$so=$_POST["txt-so"];
	$memint=$_POST["txt-mem-int"];
	$maxmsd=$_POST["txt-max-msd"];
	$ram=$_POST["txt-ram"];
	$camfront=$_POST["txt-cam-front"];
	$campost=$_POST["txt-cam-post"];
	$usb=$_POST["txt-usb"];
	$datad=$_POST["txt-dat-ad"];
	$precionuevo=$_POST["txt-precio-nuevo"];
	

		// Validar Si el dispositivo movil tiene cámara frontal
		if($camfront == ""){ $camfront="No Cam. Front."; 
		}else{ $camfront="Cam. Front. ".$camfront." MP"; }

		// Validar Si el dispositivo movil tiene cámara posterior
		if($campost == ""){	$campost="No Cam. Post."; 
		}else{ $campost="Cam. Post. ".$campost." MP"; }

		// Validar Si el dispositivo movil tiene capacidad para mem. ext.
		if($maxmsd == ""){ $maxmsd="No Mem. Ext.";
		}else{ $maxmsd="Max. Micro SD ".$maxmsd; }

		// Validar si el dispositivo movil tiene datos adicionales.
		if($datad == ""){
			$descripcion=$descripcion.": ".$so.", Mem. Int. ".$memint.", RAM ".$ram.", ".$maxmsd.", ".$camfront.", ".$campost.", ".$usb.".";
		}else{
			$descripcion=$descripcion.": ".$so.", ".$datad.", Mem. Int. ".$memint.", RAM ".$ram.", ".$maxmsd.", Cam. Front. ".$camfront." MP, Cam. Post. ".$campost." MP, ".$usb.".";
		}

	/***************** CONSULTAS *****************/
		// Alta de Dispositivo Movil
	$sql="INSERT INTO moviles(descripcion, year, precio_nuevo, estado) VALUES('$descripcion', '$yearlanzamiento', '$precionuevo', 1)";
	if (!$mysqli->query($sql)) {
		$respuesta=1;
		echo $respuesta;
		$mysqli->close();
		exit;
	}

	/******************** RESPUESTA Y CIERRE DE CONEXIÓN A LA BD *********************/
	$respuesta=2;
	echo $respuesta;
	$mysqli->close();
	exit;
?>