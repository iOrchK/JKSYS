<?php
	include ("../../php/functions.php");

	$folio=$_POST["txt-folio"];
	$fecha=$_POST["txt-fecha"];
	$idcte=$_POST["txt-id-cte"];
	$cotit=$_POST["txt-nom-cot"];
	$capit=$_POST["txt-capital"];
	$tasai=$_POST["txt-tasa-int"];
	$inter=$_POST["txt-interes"];
	$descr=$_POST["txt-des-gen"];
	$carac=$_POST["txt-car-pre"];
	$obser=$_POST["txt-obs-ope"];
	$ancla="";
	$entre="";
	$valid="";
	$refre=_generate_next_month($fecha);
	$msg="";

	if (isset($_POST["txt-anclaje"])) { $ancla=$_POST["txt-anclaje"]; }
	if (isset($_POST["txt-ent-inm"])) { $entre=$_POST["txt-ent-inm"]; }
	if (isset($_POST["txt-validado"])) { $valid=$_POST["txt-validado"]; }

	//echo $folio." - ".$fecha." - ".$idcte." - ".$cotit." - ".$capit." - ".$tasai." - ".$inter." - ".$descr." - ".$carac." - ".$notas." - ".$ancla." - ".$entre." - ".$valid;

	$sql="UPDATE datos_generales SET fecha='$fecha', idCliente='$idcte', cotitular='$cotit', capital='$capit', tasa='$tasai', interes='$inter', descripcion='$descr', caracteristicas='$carac', anclaje='$ancla', entregaInmediata='$entre', validado='$valid', observacion='$obser' WHERE id='$folio'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ $msg="✔ Operación modificada! Revisa y/o actualiza los datos de los cargos"; }

	/*
	//validar si hay refrendos anteriores
	$sql="UPDATE refrendos SET fechaVencimiento='$refre', interes='$inter' WHERE idDatosGenerales='$folio' AND estado='Cargado'";
	if($resultado=_val_con($sql, $mysqli)){ $msg=$msg."Refrendo modificado!"; }
	*/

	echo $msg;
	$mysqli->close();
	exit;
?>