<?php
	include ("functions.php");
	$respuesta="";

	$sql="SELECT idProd, descri, marca FROM products WHERE estado='Activo' ORDER BY marca ASC";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$respuesta=$respuesta."<option value='".$registro[0]."'>$registro[2]: $registro[1]</option>";
		}
		echo $respuesta;
		$mysqli->close();
		exit;
	}
?>