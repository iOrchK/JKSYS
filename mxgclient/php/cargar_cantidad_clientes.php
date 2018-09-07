<?php
	include ("../../php/functions.php");

	$sql="SELECT MAX(id_cliente) FROM clientes";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$cancte=0;
		while($registro=mysqli_fetch_row($resultado)){
			$cancte=$registro[0];
		}
		echo $cancte;
	}

	$mysqli->close();
	exit;
?>