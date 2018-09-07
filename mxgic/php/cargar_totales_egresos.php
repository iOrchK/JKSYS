<?php
	include ("/../../php/functions.php");
 	
 	$fec=$_GET["fecha"];
 	$monto=0;
 	$datos="";
 	$exp=explode("-", $fec);
 	$sql="SELECT monto FROM egresos WHERE fecha='$fec' AND estado='Pagado'";
 	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$monto=$monto+$registro[0];
		}
		$datos=$datos.(int)$exp[2].": $".$monto."/--/";
		$monto=0;
	}
	
	$fec=$exp[0]."-".$exp[1];
	$sql="SELECT monto FROM egresos WHERE fecha LIKE '$fec%' AND estado='Pagado'";
 	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$monto=$monto+$registro[0];
		}
		$datos=$datos._convert_date_month($exp[1]).": $".$monto."/--/";
		$monto=0;
	}

	$fec=$exp[0];
	$sql="SELECT monto FROM egresos WHERE fecha LIKE '$fec%' AND estado='Pagado'";
 	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$monto=$monto+$registro[0];
		}
		$datos=$datos.$fec.": "."$".$monto;
		$monto=0;
	}

 	//echo $fec;
 	echo $datos;
 	$mysqli->close();
 	exit;
?>