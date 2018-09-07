<?php
	include ("../../php/functions.php");

	$folemp=$_GET["folemp"];
	$salcap=0;
	$tasa="";
	$sql="SELECT capital, tasa, fecha FROM datos_generales WHERE id='$folemp'";
	$int=0;
	$fecven="";
	$fec="";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$salcap=$registro[0];
			$tasa=$registro[1];
			$fec=$registro[2];
		}
	}

	$sql="SELECT MAX(fechaVencimiento) FROM refrendos WHERE idDatosGenerales='$folemp'";
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){
			$fecven=$fec;
		}else{
			while($registro=mysqli_fetch_row($resultado)){
				$fecven=$registro[0];
			}
			$sql="SELECT fechaVencimiento, abonoCapital FROM refrendos WHERE idDatosGenerales='$folemp'";
			if($resultado=_val_con($sql, $mysqli)){
				while($registro=mysqli_fetch_row($resultado)){
					$diffec=_diff_two_dates($registro[0]);
					if($registro[1]>=1 && ($diffec<0 || $diffec>=11)){ 
						$salcap=$salcap-$registro[1];
					}
				}
			}
		}
	}

	$fecven=_generate_next_month($fecven);
	$int=($salcap*$tasa)/100;
	$int=_round_five((int)$int);
	$sql="INSERT INTO refrendos(idDatosGenerales, fechaVencimiento, fechaPagado, interes, abonoCapital, recargo, estado) VALUES('$folemp', '$fecven', '0000-00-00', '$int', 0, 0, 'Vencido')";
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Nuevo cargo generado!"; }

	$mysqli->close();
	exit;

?>