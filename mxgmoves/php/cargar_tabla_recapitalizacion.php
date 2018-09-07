<?php
	include ("/../../php/functions.php");

	$mesano=$_GET["mesano"];
	$datos="";

	$sql="SELECT A.fechaPagado, A.abonoCapital, CONCAT(B.descripcion,' $',B.capital), B.fecha, B.estado, CONCAT(C.nom_tit, ' #', C.num_cte), B.tasa, A.observaciones, A.id FROM refrendos A, datos_generales B, db_adminclientes.clientes C WHERE A.fechaPagado LIKE '$mesano%' AND A.abonoCapital > 0 AND B.id=A.idDatosGenerales AND B.tasa != 'VEN' AND B.tasa!='ACR' AND B.idCliente=C.id_cliente ORDER BY A.fechaPagado ASC";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){ 
			$datos="<tr><td colspan='6'><center style='background:white'><b>😢 No hay recapitalizaciones</b></center></td></tr>"; 
		}else{
			$i=0;
			$acum=0;
			$fecant="";
			$tri="";
			$trf="";
			while($registro=mysqli_fetch_row($resultado)){
				$i=$i+1;
				$fecpag=$registro[0];
				$abocap=$registro[1];
				$operac=_convert_date_lit($registro[3])." ".$registro[2];
				$estado=$registro[4];
				$client=$registro[5];
				$fecven=$fecpag;
				$tasa=$registro[6];
				$observ=$registro[7];
				$idref=$registro[8];

				if($tasa==="0%") {
					$operac="Préstamo de la amistad ".$operac;
				}else{
					$operac="Empeño/Préstamo ".$operac;
				}

				$tempfecant=_convert_date_lit($fecant);
				if($fecant===$fecpag || $fecant===""){ // si son del mismo dia o es el primer registro
					$tri="";
					$acum=$acum+$abocap;
					if($i===$rows){ 
						if($rows===1){ $tempfecant=_convert_date_lit($fecven); }
						$tri="";
						$trf="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td></tr>";
						//$acum=0;
					}
				}else{
					$trf="";
					$tri="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td></tr>";
					$acum=$abocap;
				}
				
				$diffirows=$i-$rows;
				if($diffirows===0){
					$tempfecant=_convert_date_lit($fecven);
					$trf="<tr class='cap-tot-dia'><td></td> <td></td> <td style='text-align:right'><b>Total $tempfecant =</b></td> <td><b>$$acum</b></td> <td></td> <td></td></tr>";
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

				$datos=$datos.$tri."<tr bgcolor='$color'>
										<td><input type='radio' name='recap' value='$idref' $classiRadio>$i".$notify."</td>
										<td>"._convert_date_lit($fecpag)."</td>
										<td>$client</td>
										<td>$$abocap</td>
										<td>$operac</td>
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