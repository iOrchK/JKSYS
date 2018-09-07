<?php
	include ("../../php/functions.php");

	$sql="SELECT num_cte FROM clientes WHERE id_cliente=(SELECT MAX(id_cliente) FROM clientes)";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$numcte=0;
		while($registro=mysqli_fetch_row($resultado)){
			$numcte=$registro[0]+1;
		}
		echo $numcte;
	}

	$mysqli->close();
	exit;
?>