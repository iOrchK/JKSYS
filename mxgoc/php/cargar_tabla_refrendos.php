<?php
	include ("../../php/functions.php");

	$folio=$_GET["folio"];
	$color="";
	$salcap=0;
	$estcon="";

	$sql="SELECT estado, capital FROM datos_generales WHERE id='$folio'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			if($registro[0]==="Vigente"){ $color="#FFFF99"; }
			if($registro[0]==="Cancelado"){ $color="plum"; }
			if($registro[0]==="Liquidado"){ $color="lightcoral"; }
			$estcon=$registro[0];
			$salcap=$registro[1];
		}	
	}

	$sql="SELECT fechaVencimiento, fechaPagado, interes, abonoCapital, recargo, id, idDatosGenerales, estado, observaciones FROM refrendos WHERE idDatosGenerales='$folio'";
	if($resultado=_val_con($sql, $mysqli)){
		$datos="";
		$i=0;
		$totpag=0;
		while($registro=mysqli_fetch_row($resultado)){
			if($registro[0]==="0000-00-00"){ $registro[0]=""; }
			else{ $registro[0]=_convert_date_lit($registro[0]); }
			if($registro[1]==="0000-00-00"){ $registro[1]=""; }
			else{ $registro[1]=_convert_date_lit($registro[1]); }

			if($estcon==="Vigente"){
				$dis="";
				if($registro[7]==="Vencido"){ 
					$color="cornsilk";
					$totpag=0;
					$salcap=$salcap-0;
				}else{
					$totpag=$registro[2]+$registro[3]+$registro[4];
					$salcap=$salcap-$registro[3];
				}
			}else{
				$dis="disabled";
				if($registro[7]==="Vencido"){ 
					$totpag=0;
					$salcap=$salcap-0;
				}else{
					$totpag=$registro[2]+$registro[3]+$registro[4];
					$salcap=$salcap-$registro[3];
				}
			}

			if($registro[8]===""){
				$notify="";
			}else{
				$notify="<font color='red' style='font-size:15px;'>●</font>";
			}

			$i=$i+1;
			$datos=$datos."<tr bgcolor='$color'>
								<td><input type='radio' class='$registro[6]' name='refrendo' value='$registro[5]' $dis>$i".$notify."</td>
								<td>$registro[0]</td>
								<td>$registro[1]</td>
								<td>$$registro[2]</td>
								<td>$$registro[3]</td>
								<td>$$registro[4]</td>
								<td>$$totpag</td>
								<td>$$salcap</td>
							</tr>";
		}
		echo $datos;
	}

	$mysqli->close();
	exit;
?>