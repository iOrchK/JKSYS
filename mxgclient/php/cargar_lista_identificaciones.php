<?php
	include ("../../php/functions.php");

	$sql="SELECT id, descripcion FROM identificaciones";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$lista="";
		while($registro=mysqli_fetch_row($resultado)){
			$lista=$lista."<option id='".$registro[0]."' value='$registro[1]'></option>";
		}
		echo $lista;
	}

	$mysqli->close();
	exit;
?>