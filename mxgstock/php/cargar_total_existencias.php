<?php
	include ("../../php/functions.php");

	$rows=0;
	$sql="SELECT COUNT(estado) AS 'Vigente' FROM datos_generales WHERE estado='Vigente' AND descripcion NOT LIKE '%sin garant%' AND descripcion NOT LIKE '%prestamo%' AND descripcion NOT LIKE '%préstamo%' AND descripcion NOT LIKE '%sin inter%'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$rows=$registro[0];
		}
	}
	echo "Total de existencias: ".$rows;
	$mysqli->close();
	exit;
?>