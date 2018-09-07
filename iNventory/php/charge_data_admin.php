<?php
	include ("functions.php");
	$adminname="";
	$adminemai="";
	$adminpass="";
	$sql="";
	if(isset($_POST["txt-admin-name"]) && isset($_POST["txt-email"]) && isset($_POST["txt-admin-pass"])){
		$adminname=$_POST["txt-admin-name"];
		$adminemai=$_POST["txt-email"];
		$adminpass=$_POST["txt-admin-pass"];
		$sql="UPDATE user SET name='$adminname', email='$adminemai', pass='$adminpass' WHERE idUser=1 AND type='admin' AND estado='Alta'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			echo "Los datos del administrador han sido actualizados. Recuerde siempre su clave de administrador.";
			$mysqli->close();
			exit;
		}
	}else{
		$sql="SELECT name, email, pass FROM user WHERE type='admin' AND estado='Alta'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			if($registro=mysqli_fetch_row($resultado)){
				$adminname=$registro[0];
				$adminemai=$registro[1];
				$adminpass=$registro[2];
			}
			echo $adminname.":".$adminpass.":".$adminemai;
			$mysqli->close();
			exit;
		}
	}

?>