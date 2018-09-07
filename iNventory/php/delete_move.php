<?php
	include ("functions.php");

	$move=$_POST["txt-moves"];
	$passwd=$_POST["txt-pass"];

	$sql="SELECT idUser, name FROM user WHERE estado='Alta' AND pass='$passwd' AND type='admin'  AND estado='Alta'";
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
					$user=$registro[1];
					$sql="UPDATE stock SET eliminado='Si' WHERE idStoc='$move'";
					_val_con($sql, $mysqli);
					echo $user; // imprimir usuario
					$mysqli->close();
					exit;
				}
			}
		}
	}
?>