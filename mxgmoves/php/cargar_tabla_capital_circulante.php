<?php
	include ("../../php/functions.php");

	$mesano=$_GET["mesano"];
	$mesano=_cut_date_yyyymm($mesano);
	$datos="";
	// No va a contar los registros con tasa de interés VEN, porque son ventas ni tasa ACR porque son deudas acreedoras
	$sql="SELECT fecha, idCliente, capital, tasa, descripcion, estado, observacion, id FROM datos_generales WHERE fecha LIKE '$mesano%' AND tasa!='VEN' AND tasa!='ACR' ORDER BY fecha";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$i=0;
		$acum=0;
		$fecant="";
		$tri="";
		$trf="";
		$rows=mysqli_num_rows($resultado);
		if($rows===0){ 
			$datos="<tr><td colspan='7'><center style='background:white'><b>😢 No hay capital circulante</b></center></td></tr>";
		}else{
			while($registro=mysqli_fetch_row($resultado)){
				$cliente="";
				$iMysqli1=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
				$iSql1="SELECT CONCAT(nom_tit, ' #', num_cte) FROM clientes WHERE id_cliente='$registro[1]'";
				if($iResultado1=_val_con($iSql1, $iMysqli1)){
					while($iRegistro1=mysqli_fetch_row($iResultado1)){ $cliente=$iRegistro1[0]; }
				}

				$i=$i+1;
				$fecven=_convert_date_lit($registro[0]);

				$color="white";
				$classiRadio="";
				switch ($registro[5]) {
					case 'Vigente':
						$color="#FFFF99";
						break;
					case 'Liquidado':
						$classiRadio="disabled='disabled'";
						$color="lightcoral";
						break;
					case 'Cancelado':
						$classiRadio="disabled='disabled'";
						$color="plum";
						break;
					default:
						$classiRadio="title='DATO ERRONEO: estado->$estado'";
						break;
				}

				if($fecant===$registro[0] || $fecant===""){ 
					$tri="";
					$acum=$acum+$registro[2];
					$tempfecant=_convert_date_lit($fecant);
					if($i===$rows){ 
						if($rows===1){ $tempfecant=$fecven; }
						$tri="";
						$trf="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td> <td></td></tr>";
						//$acum=0;
					}
				}else{
					$tempfecant=_convert_date_lit($fecant);
					$tri="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td> <td></td></tr>";
					$acum=$registro[2];
				}

				$diffirows=$i-$rows;
				if($diffirows===0){
					$tempfecant=_convert_date_lit($registro[0]);
					$trf="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td> <td></td></tr>";
					$acum=0;
				}

				if($registro[6]===""){
					$notify="";
				}else{
					$notify="<font color='red' style='font-size:15px;'>●</font>";
				}
				
				$datos=$datos.$tri."<tr bgcolor='$color'>
									<td><input type='radio' name='movimiento' value='$registro[7]' $classiRadio>$i".$notify."</td>
									<td>$fecven</td>
									<td>$cliente</td>
									<td>$$registro[2]</td>
									<td>$registro[3]</td>
									<td>$registro[4]</td>
									<td><font color='red' style='font-size:15px;'>$registro[6]</font></td>
								</tr>".$trf;
				$fecant=$registro[0];
			}
		}
		echo $datos;
	}
	
	$mysqli->close();
	exit;
?>