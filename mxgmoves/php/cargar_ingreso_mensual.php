<?php
	include ("/../../php/functions.php");

	$mesano=$_GET["mesano"];
	$ingmen=0;
	// Cuando los intereses esten pagados los va a sumar
	$sql="SELECT A.interes, A.recargo FROM refrendos A, datos_generales B WHERE A.fechaPagado LIKE '$mesano%' AND A.estado='Pagado' AND A.idDatosGenerales=B.id AND B.tasa!='VEN' AND B.tasa!='ACR'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$ingmen=$ingmen+$registro[0]+$registro[1];
		}
	}

	$sql="SELECT A.abonoCapital FROM refrendos A, datos_generales B WHERE A.fechaPagado LIKE '$mesano%' AND A.estado='Pagado' AND B.id=A.idDatosGenerales AND B.tasa='VEN'";
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$ingmen=$ingmen+$registro[0];
		}
		echo "$".$ingmen;
	}

	$mysqli->close();
	exit;
?>