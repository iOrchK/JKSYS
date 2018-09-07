<?php
	include ("../../php/functions.php");

	$folref=$_GET["folref"];
	$folemp=$_GET["folemp"];
	$salcap=0;

	$sql="SELECT capital FROM datos_generales WHERE id='$folemp'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$salcap=$registro[0];
		}
	}

	$sql="SELECT abonoCapital FROM refrendos WHERE idDatosGenerales='$folemp' AND id<'$folref'";
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$salcap=$salcap-$registro[0];
		}
	}

	$sql="SELECT fechaVencimiento, fechaPagado, interes, abonoCapital, recargo, estado, observaciones FROM refrendos WHERE id='$folref'";
	if($resultado=_val_con($sql, $mysqli)){
		$dato="";
		while($registro=mysqli_fetch_row($resultado)){
			if($registro[1]==="0000-00-00"){ $registro[1]=""; }
			$dato=$registro[0]."/-/".$registro[1]."/-/".$registro[2]."/-/".$registro[3]."/-/".$registro[4]."/-/".$registro[5]."/-/".$salcap."/-/".$registro[6];
		}
		echo $dato;
	}

	$mysqli->close();
	exit;
?>