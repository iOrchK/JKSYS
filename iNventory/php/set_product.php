<?php
	include ("functions.php");
	$marca=$_POST["txt-marca"];
	$descri=$_POST["txt-desc"];
	$passwd=$_POST["txt-pass"];

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
					$sql="INSERT INTO products(descri, marca, idUser, estado) VALUES('$descri', '$marca', '$registro[0]', 'Activo')";
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