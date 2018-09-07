<?php
	include ("../../php/functions.php");

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	$sql="SELECT id_cliente, num_cte, nom_tit FROM clientes WHERE estado='Alta' ORDER BY id_cliente ASC";

	if($resultado=_val_con($sql, $mysqli)){
		$lista="";
		while($registro=mysqli_fetch_row($resultado)){
			$lista=$lista."<option id='".$registro[0]."' value='".$registro[1]."'>".$registro[2]."</option>";
		}
		echo $lista;
	}

	$mysqli->close();
	exit;
?>