<?php
	include ("../../php/functions.php");

	$idcte=$_GET["idcte"];
	$sql="SELECT id_cliente, num_cte, fec_reg, nom_tit, tel_tit, dom_tit, ema_tit, ide_tit, cla_ide, nom_cot, ano_adi, clasificacion, estado FROM clientes WHERE id_cliente='$idcte'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$datos="";
		while($registro=mysqli_fetch_row($resultado)){
			$antiguedad=_get_antiquity($registro[3]);
			$datos=$datos.$registro[0]."/--/".$registro[1]."/--/".$registro[2]."/--/".$registro[3]."/--/".$registro[4]."/--/".$registro[5]."/--/".$registro[6]."/--/".$registro[7]."/--/".$registro[8]."/--/".$registro[9]."/--/".$registro[10]."/--/".$registro[11]."/--/".$registro[12];
		}
		echo $datos;
	}

	$mysqli->close();
	exit;
?>