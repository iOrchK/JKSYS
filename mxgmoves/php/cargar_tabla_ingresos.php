<?php
	include ("/../../php/functions.php");

	$mesano=$_GET["mesano"];
	$datos="";
	// No va a contar registros con tasa ACR porque son deudas acreedoras
	$sql="SELECT A.fechaPagado, A.interes, A.recargo, A.abonoCapital, A.fechaVencimiento, B.capital, B.descripcion, B.fecha, B.estado, B.tasa, CONCAT(C.nom_tit, ' #', C.num_cte), A.observaciones, A.id FROM refrendos A, datos_generales B, db_adminclientes.clientes C WHERE A.fechaPagado LIKE '$mesano%' AND A.estado='Pagado' AND B.id=A.idDatosGenerales AND B.tasa!='ACR' AND C.id_cliente=B.idCliente ORDER BY A.fechaPagado, C.id_cliente, A.fechaVencimiento ASC";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){ 
			$datos="<tr><td colspan='5'><center style='background:white'><b>😢 No hay ingresos</b></center></td></tr>";
		}else{
			$i=0;
			$acum=0;
			$fecant="";
			$tri="";
			$trf="";
			$cont=0;
			while($registro=mysqli_fetch_row($resultado)){
				$i=$i+1;
				$cont=$cont+1;
				$fecpag=$registro[0];
				$intere=$registro[1];
				$recarg=$registro[2];
				$abocap=$registro[3];
				$fecven=$registro[4];
				$capita=$registro[5];
				$descri=$registro[6];
				$fecemp=$registro[7];
				$estado=$registro[8];
				$tasa=$registro[9];
				$cliente=$registro[10];
				$observ=$registro[11];
				$idref=$registro[12];

				$descri=_convert_date_lit($fecven)." ".$descri;
				switch ($tasa) {
					case 'VEN':
						$ingmen=$abocap+$recarg;
						$descri="Abono/Venta ".$descri." $".$ingmen;
						break;
					case 'ACR':
						# code...
						break;
					default:
						$ingmen=$intere+$recarg;
						if($recarg>=1){ 
							$descri="Interés ".$descri." $".$intere." con recargo $".$recarg;
						}else{ $descri="Interés ".$descri." $".$intere; }
						break;
				}

				$tempfecant=_convert_date_lit($fecant);
				if($fecant===$fecpag || $fecant===""){ 
					$tri="";
					$acum=$acum+$ingmen;
					if($i===$rows){ 
						if($rows===1){ $tempfecant=_convert_date_lit($fecven); }
						$tri="";
						$trf="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td></tr>";
						//$acum=0;
					}
				}else{
					$trf="";
					$tri="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td></tr>";
					$acum=$ingmen;
				}

				$class="";
				//if($ingmen===0){ $class="trHidden"; $cont=$cont-1; }

				$diffirows=$i-$rows;
				if($diffirows===0){
					$tempfecant=_convert_date_lit($fecpag);
					$trf="<tr class='cap-tot-dia $class'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td></tr>";
					$acum=0;
				}

				$color="white";
				$classiRadio="";
				switch ($estado) {
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

				if($observ===""){
					$notify="";
				}else{
					$notify="<font color='red' style='font-size:15px;'>●</font>";
				}

				$datos=$datos.$tri."<tr bgcolor='$color' class='$class'>
										<td><input type='radio' name='ingreso' value='$idref' $classiRadio>$cont".$notify."</td>
										<td>"._convert_date_lit($fecpag)."</td>
										<td>$cliente</td>
										<td>$$ingmen</td>
										<td>$descri</td>
										<td><font color='red' style='font-size:15px;'>$observ</font></td>
									</tr>".$trf;

				$fecant=$fecpag;
			}
		}
		echo $datos;
	}

	$mysqli->close();
	exit;
?>