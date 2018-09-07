<?php
	include ("/../../php/functions.php");

	$egr=$_GET["egreso"];
	$datos="";
	
	$sql="SELECT A.id, A.fecha, B.descripcion, A.descripcion, A.monto, A.estado, A.idCategoria FROM egresos A, categresos B WHERE A.id='$egr' AND A.idCategoria=B.id";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$datos=$registro[0]."/--/".$registro[1]."/--/".$registro[2]."/--/".$registro[3]."/--/".$registro[4]."/--/".$registro[5]."/--/".$registro[6]."/--/"._convert_date($registro[1]);
		}
		echo $datos;
	}

	//echo $egr;
	$mysqli->close();
	exit;
?>