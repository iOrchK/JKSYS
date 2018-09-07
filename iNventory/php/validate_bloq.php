<?php
	include ("functions.php");
	$estado="";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	$sql="SELECT estado FROM numserial WHERE idSeri=1";
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$estado=$registro[0];
			echo $estado;
			$mysqli->close();
			exit;
		}
	}
?>