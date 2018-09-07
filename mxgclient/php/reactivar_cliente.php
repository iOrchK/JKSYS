<?php
	include ("../../php/functions.php");

	$folcte=$_GET["txt-fol-cte"];

	$sql="UPDATE clientes SET estado='Alta' WHERE id_cliente='$folcte'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Cliente reactivado!"; }

	$mysqli->close();
	exit;
?>