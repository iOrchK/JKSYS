<?php
	include ("../../php/functions.php");

	$sql="SELECT num_cte, nom_tit FROM clientes";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$lista="";
		while($registro=mysqli_fetch_row($resultado)){
			$lista=$lista."<option id='$registro[0]' value='$registro[0]'>$registro[1]</option>";
		}
		echo $lista;
	}

	$mysqli->close();
	exit;
?>