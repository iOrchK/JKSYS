<?php
	include ("functions.php");
	$produc=$_POST["txt-prod"];
	$cantid=$_POST["txt-cant"];
	$passwd=$_POST["txt-pass"];

	$sql="SELECT idUser, name FROM user WHERE estado='Alta' AND pass='$passwd'";
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
					$idUser=$registro[0];
					$user=$registro[1];
					_validate_stock($produc, $cantid, $idUser, $user);
				}
			}
		}
	}

	/*********************************************************************/
	function _validate_stock($produc, $cantid, $idUser, $user){
		$hoy=_get_hoy();
		$time=_get_time_now();
		$msg="";
		$sql="SELECT quant, estado FROM stock WHERE idProd='$produc'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			$rows=mysqli_num_rows($resultado);
			if($rows===0){
				echo "Vacio";
				$mysqli->close();
				exit;
			}else{
				$disponible=0;
				while($registro=mysqli_fetch_row($resultado)){
					if($registro[1]==="Almacenado"){ $disponible=$disponible+$registro[0]; }
					if($registro[1]==="Retirado"){ $disponible=$disponible-$registro[0]; }				
				}
				if($disponible==0){ 
					echo "No disponible";
					$mysqli->close();
					exit;
				}
				if($disponible>=1){
					$disponible=$disponible-1;
					$sql="INSERT INTO stock(datReg, timReg, idProd, quant, moveme, idUser, estado, eliminado) VALUES('$hoy', '$time', '$produc', '$cantid', 'Egreso', '$idUser', 'Retirado', 'No')";
					$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
					_val_con($sql, $mysqli);
					$sql="SELECT descri FROM products WHERE idProd='$produc'";
					$resultado=_val_con($sql, $mysqli);
					$registro=mysqli_fetch_row($resultado);
					$descri=$registro[0];
					$msg=$user." retiró ".$cantid." unidades de ".$descri;
					_notify_for_email("JK Inventory: Salida de producto", $msg);
					echo $user.":".$disponible;
					$mysqli->close();
					exit;
				}
			}
		}
	}

	function _set_binnacle(){
		
	}
?>