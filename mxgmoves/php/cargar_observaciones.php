<?php
	include ("/../../php/functions.php");

	$folemp=$_GET["folemp"];
	$sql="SELECT observacion FROM datos_generales WHERE id='$folemp'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$obs="";
		while($registro=mysqli_fetch_row($resultado)){
			$obs=$registro[0];
		}
		echo $obs;
	}

	$mysqli->close();
	exit;
?>