<?php
	include ("functions.php");
	$produc=$_POST["txt-prod"];
	$cantid=$_POST["txt-cant"];
	$passwd=$_POST["txt-pass"];
	$hoy=_get_hoy();
	$time=_get_time_now();

	$sql="SELECT idUser, name FROM user WHERE estado='Alta' AND pass='$passwd' AND type='admin' AND estado='Alta'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){
			echo "Passinv";
			$mysqli->close();
			exit;
		}else{
			if($rows===1){
				if($registro=mysqli_fetch_row($resultado)){
					$sql="INSERT INTO stock(datReg, timReg, idProd, quant, moveme, idUser, estado, eliminado) VALUES('$hoy', '$time', '$produc', '$cantid', 'Ingreso', '$registro[0]', 'Almacenado', 'No')";
					$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
					_val_con($sql, $mysqli);
					echo $registro[1]; // imprimir usuario
					$mysqli->close();
					exit;
				}
			}
		}
	}
?>