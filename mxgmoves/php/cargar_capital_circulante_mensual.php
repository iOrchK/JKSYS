<?php
	include ("/../../php/functions.php");

	$mesano=$_GET["mesano"];
	$capcir=0;
	$sql="SELECT capital FROM datos_generales WHERE fecha LIKE '$mesano%' AND tasa!='VEN' AND tasa!='ACR'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$capcir=$capcir+$registro[0];
		}
		echo "$".$capcir;
	}

	$mysqli->close();
	exit;
?>