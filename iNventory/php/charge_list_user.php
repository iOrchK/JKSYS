<?php
	include ("functions.php");
	$iduser="";
	$users="";
	$i=0;
	if(isset($_POST["txt-list-user"])){
		$iduser=$_POST["txt-list-user"];
		$sql="UPDATE user SET estado='Baja' WHERE idUser='$iduser'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			echo "El empleado ha sido eliminado";
			$mysqli->close();
			exit;
		}
	}else{
		$sql="SELECT idUser, name FROM user WHERE type='employer' AND estado='Alta'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			while($registro=mysqli_fetch_row($resultado)){
				$i=$i+1;
				$namemp=$registro[1];
				$users=$users."<option value='".$registro[0]."'>Empleado #$i $namemp</option>";
			}
			echo $users;
			$mysqli->close();
			exit;
		}
	}
?>