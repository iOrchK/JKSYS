<?php
	include ("../../php/functions.php");

	$folio=0;
	if(isset($_POST["txt-fecha"])){ 
		$fecha=$_POST["txt-fecha"]; 
	}else{ 
		$fecha=_get_hoy();
	}	
	$idcte=$_POST["txt-id-cte"];
	$cotit=$_POST["txt-nom-cot"];
	$capit=$_POST["txt-capital"];
	$tasai=$_POST["txt-tasa-int"];
	$inter=$_POST["txt-interes"];
	$descr=$_POST["txt-des-gen"];
	$carac=$_POST["txt-car-pre"];
	$ancla="";
	$entre="";
	$valid="";
	$obser=$_POST["txt-obs-ope"];
	$refre=_generate_next_month($fecha);
	$msg="";

	if (isset($_POST["txt-anclaje"])){ $ancla=$_POST["txt-anclaje"]; }
	if (isset($_POST["txt-ent-inm"])) { $entre=$_POST["txt-ent-inm"]; }
	if (isset($_POST["txt-validado"])) { $valid=$_POST["txt-validado"]; }

	//echo $fecha." - ".$idcte." - ".$cotit." - ".$capit." - ".$tasai." - ".$inter." - ".$descr." - ".$carac." - ".$notas." - ".$ancla." - ".$entre." - ".$valid;

	$sql="INSERT INTO datos_generales(fecha, idCliente, cotitular, capital, tasa, interes, descripcion, caracteristicas, anclaje, entregaInmediata, validado, estado, observacion) VALUES('$fecha', '$idcte', '$cotit', '$capit', '$tasai', '$inter', '$descr', '$carac', '$ancla', '$entre', '$valid', 'Vigente', '$obser')";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ $msg="✔ Operación guardada! "; }

	$sql="SELECT max(id) FROM datos_generales";
	if($resultado=_val_con($sql, $mysqli)){ 
		while($registro=mysqli_fetch_row($resultado)){
			$folio=$registro[0]; 
		}
	}

	$sql="INSERT INTO refrendos(idDatosGenerales, fechaVencimiento, interes, estado) VALUES('$folio', '$refre', '$inter', 'Vencido')";
	if($resultado=_val_con($sql, $mysqli)){ $msg=$msg."✔ Cargo generado!"; }

	echo $msg;
	$mysqli->close();
	exit;
?>