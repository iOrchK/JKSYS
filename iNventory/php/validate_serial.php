<?php
	include ("functions.php");
	$pass=$_POST["txt-pass"];

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	$sql="SELECT estado FROM numserial WHERE desKey='$pass'";
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){
			echo "Invalido";
			$mysqli->close();
			exit;
		}else{
			if($registro=mysqli_fetch_row($resultado)){
				$estado=$registro[0];
				if($estado=="Caducado"){ 
					$limDat=_get_hoy();
					$limDat=_generate_next_year($limDat);
					$sql="UPDATE numserial SET limDat='$limDat', estado='Activado' WHERE desKey='$pass'";
					_val_con($sql, $mysqli);
					$limDat=_convert_date($limDat);
					$asunto="JK Inventory: Activado!";
					$msg="Renovación exitosa. Gracias por usar JK iNventory. Ya esta listo para continuar con su trabajo. Nueva fecha de caducidad: ".$limDat.".";
					_notify_for_email($asunto, $msg);
					/************* Notify to Developer Email **************
					$msg="Renovación exitosa. Nueva fecha de caducidad: ".$limDat.".";
					_notify_developer_email($asunto, $msg);*/
					echo "Vigente";
					$mysqli->close();
					exit;
				}
			}
		}
	}
?>