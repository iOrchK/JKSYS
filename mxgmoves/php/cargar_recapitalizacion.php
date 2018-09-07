<?php
	include ("/../../php/functions.php");

	$mesano=$_GET["mesano"];
	$capret=0;
	// No va a incluir los que tengan tasa='VEN' por que son ventas ni tasa=ACR porque son deudas a acreedores
	$sql="SELECT A.abonoCapital FROM refrendos A, datos_generales B WHERE A.fechaPagado LIKE '$mesano%' AND A.idDatosGenerales=B.id AND B.tasa!='VEN' AND tasa!='ACR'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$capret=$capret+$registro[0];
		}
		echo "$".$capret;
	}

	$mysqli->close();
	exit;
?>