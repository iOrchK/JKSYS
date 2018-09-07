<?php
	include ("functions.php");
	$username=$_POST["txt-user-name"];
	$userpass=$_POST["txt-user-pass"];

	$sql="INSERT INTO user(name, type, pass, estado) VALUES('$username', 'employer', '$userpass', 'Alta')";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		echo "El usuario ha sido registrado";
		$mysqli->close();
		exit;
	}
?>