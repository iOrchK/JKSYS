<?php
	include ("../../php/functions.php");

	$id=$_GET["id"];
	$sql="SELECT id_cliente, num_cte, nom_tit, tel_tit, dom_tit, nom_cot FROM clientes WHERE id_cliente='$id'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$datos="";
		while($registro=mysqli_fetch_row($resultado)){
			if($registro[5]!="" || $registro[5]!="No proporcionado"){ 
				$registro[2]=$registro[2]." / ".$registro[5]; 
			}
			$datos=$datos.$registro[0]."/-/".$registro[1]."/-/".$registro[2]."/-/".$registro[3]."/-/".$registro[4];
		}
		echo $datos;
	}

	$mysqli->close();
	exit;
?>