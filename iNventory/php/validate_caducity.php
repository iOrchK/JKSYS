<?php
	include ("functions.php");

	$sql="SELECT limDat FROM numserial WHERE idSeri=1";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		if($registro=mysqli_fetch_row($resultado)){
			$limDat=strtotime($registro[0]);
			$hoy=strtotime(_get_hoy());
			$diff=abs($limDat-$hoy);
			$dias=floor($diff/60/60/24);
			if($dias<=0){
				$sql="UPDATE numserial SET estado='Caducado' WHERE idSeri=1";
				_val_con($sql, $mysqli);
				$asunto="JK Inventory: Caducado!";
				$msg="El programa ha caducado. Para continuar con sus labores contacte con el desarrollador y solicite su renovación anual por $1500. La seguridad de su negocio no tiene precio.";
				_notify_for_email($asunto, $msg);
				/************* Notify to Developer Email **************
				$msg="Ofrecer RENOVACIÓN anual por $1500.";
				_notify_developer_email($asunto, $msg);*/
				echo "Caducado";
			}else{
				if($dias<=30){
					echo "El programa caduca en ".$dias." días. Contacte al desarrollador.-1";
				}else{
					if($dias>30){
						echo "El programa caduca en ".$dias." días.-2";
					}
				}
			}
			$mysqli->close();
			exit;
		}
	}
?>