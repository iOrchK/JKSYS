<?php
	include ("../../php/functions.php");

	$folref=$_POST["txt-fol-pag"];
	$fecref=$_POST["txt-fec-ref"];
	$fecpag=$_POST["txt-fec-pag"];
	$int=$_POST["txt-int-pag"];
	$abo=$_POST["txt-abo-pag"];
	$rec=$_POST["txt-rec-pag"];
	$estref=$_POST["estadoRefrendo"];
	$tot=$_POST["txt-tot-pag"];
	$salcap=$_POST["txt-nue-sal-cap"];
	$observ=$_POST["txt-obs-ref"];

	// Actualizar refrendo
	$salcap=$salcap-$abo;
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	$sql="UPDATE refrendos SET fechaVencimiento='$fecref', fechaPagado='$fecpag', interes='$int', abonoCapital='$abo', recargo='$rec', estado='$estref', observaciones='$observ' WHERE id='$folref'";
	if($resultado=_val_con($sql, $mysqli)){ 
		$msg="";
		echo "✔ Cargo modificado! Es necesario que revise y/o modifique los demas cargos"; 
	}

	/* // 
	// Obtener id de empeño
	$folemp=0;
	$sql="SELECT idDatosGenerales FROM refrendos WHERE id='$folref'";
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$folemp=$registro[0];
		}
	}

	// Obtener capital y tasa de interés
	$t="";
	$c=0;
	$sql="SELECT capital, tasa FROM datos_generales WHERE id='$folemp'";
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$c=$registro[0];
			$t=$registro[1];
		}
	}

	// Obtener  fecha de vencimiento y abono a capital
	$a=$c;
	$sql="SELECT fechaVencimiento, abonoCapital FROM refrendos WHERE idDatosGenerales='$folemp'";
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$diffec=_diff_two_dates($registro[0]);
			if($registro[1]>=1 && ($diffec<0 || $diffec>=11)){ $a=$a-$registro[1]; }
		}
	}

	// Actualizar refrendos cargados
	$int=$a/$t;
	$sql="UPDATE refrendos SET interes='$int' WHERE estado='Cargado' AND id>'$folref'";
	if($resultado=_val_con($sql, $mysqli)){ 
		$msg=$msg."\nRefrendos actualizados"; 
	}
	*/

	$mysqli->close();
	exit;
?>