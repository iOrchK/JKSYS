<?php
	$mysqli = new mysqli("localhost", "root", "", "db_avamovil");
	// Validar conexión a la base de datos
	if ($mysqli->connect_errno) { 
		$respuesta=0; 
		echo $respuesta;
		$mysqli->close(); 
		exit; 
	}
?>