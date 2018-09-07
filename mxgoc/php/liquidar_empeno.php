<?php
	include ("../../php/functions.php");

	// Validar para acreedores

	$folio=$_GET["folio"];
	$sql="UPDATE datos_generales SET estado='Liquidado' WHERE id='$folio'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){ $msg="✔ Operación liquidada! "; }

	$sql="SELECT entregaInmediata FROM datos_generales WHERE id='$folio'";
	if($resultado=_val_con($sql, $mysqli)){
		$ent="";
		while($registro=mysqli_fetch_row($resultado)){
			$ent=$registro[0];
		}
		if($ent==="Checked"){ 
			$msg="⚡ Ya puede entregar las garantias"; 
		}else{ 
			$entrega=_get_delivery_time();
			$exp=explode(":", $entrega);
			$hora=$exp[0];
			$min=$exp[1];
			$exp=explode(" ", $min);
			$min=$exp[0];
			$ampm=$exp[1];
			if(($hora>=7 && $hora<=11 && $ampm==="am") || ($hora===12 && $ampm==="pm")  || ($hora<=7 && $ampm==="pm")){ 
				$entrega="🕟 Entrega hoy a partir de las ".$entrega; 
			}else{ 
				$entrega="📅 Entrega al siguiente día hábil a partir de las 9 am".$entrega;
			}
			$msg=$msg.$entrega; 
		}
	}

	/*
	$sql="UPDATE refrendos SET estado='Pagado' WHERE idDatosGenerales='$folio' WHERE estado='Cargado'";
	if($resultado=_val_con($sql, $mysqli)){ $msg="Refrendos adeudados cancelados!"; }
	*/

	echo $msg;
	$mysqli->close();
	exit;
?>