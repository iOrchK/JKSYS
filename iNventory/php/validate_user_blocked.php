<?php
	include ("functions.php");
	$pass="";
	$sql="";

	if(isset($_POST["txt-pass"])){
		$pass=$_POST["txt-pass"];
		$sql="SELECT idKey FROM securitykey WHERE descri='$pass' AND estado='Bloqueado'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			$rows=mysqli_num_rows($resultado);
			if($rows==0){
				echo "Passinv";
				$mysqli->close();
				exit;
			}else{
				$sql1="UPDATE securitykey SET estado='Activado' WHERE idKey=1";
				$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_inventory");
				if($resultado1=_val_con($sql1, $mysqli1)){
					$asunto="JK Inventory: Desbloqueado!";
					$msg="El programa ha sido desbloqueado nuevamente para su disposición.";
					_notify_for_email($asunto, $msg);
					/************* Notify to Developer Email **************
					$msg="Desbloqueo exitoso.";
					_notify_developer_email($asunto, $msg);*/
					echo "Activado";
					$mysqli1->close();
				}
			}
			$mysqli->close();
			exit;
		}
	}else{
		$sql="SELECT estado FROM securitykey WHERE idKey=1";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			if($registro=mysqli_fetch_row($resultado)){
				echo $registro[0];
				$mysqli->close();
				exit;
			}
		}
	}	
?>