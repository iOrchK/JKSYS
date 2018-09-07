<?php
	include ("/../../php/functions.php");

	$init=$_GET["init"];
	$limit=$_GET["limit"];
	$tbody="";
	$title="";
	$ex1=explode("-", $init);
	$ex2=explode("-", $limit);
	$min=$ex1[1];
	$day=$ex1[2];

	// WHERE B.estado='Vigente'
	$sql="SELECT A.num_cte, A.nom_tit, B.descripcion, B.tasa, B.estado, A.id_cliente, B.id , B.capital, B.fecha FROM db_adminclientes.clientes A, datos_generales B, refrendos C WHERE C.idDatosGenerales=B.id AND B.idCliente=A.id_cliente AND C.fechaVencimiento LIKE '%$ex1[2]' ORDER BY B.estado DESC, B.id ASC, C.fechaVencimiento ASC";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");

	if($resultado=_val_con($sql, $mysqli)){
		$client="";
		$operac="";
		$operacion="";
		while($registro=mysqli_fetch_row($resultado)){
			if($operacion!=$registro[6]){
					$numcte=$registro[0];
			$nomtit=$registro[1];
			$descri=$registro[2];
			$tasa=$registro[3];
			$estope=$registro[4];
			$idcte=$registro[5];
			$idope=$registro[6];
			$capit=$registro[7];
			$fecha=_convert_date_lit($registro[8]);

			if($estope==="Vigente"){
				$color="#FFFF99";
				$hide="";
			}else{
				if($estope==="Liquidado"){
					$color="lightcoral";
					$hide="class='row-hidden-l'";
				}else{
					$color="plum";
					$hide="class='row-hidden-c'";
				}
			}

			if($tasa==="0%"){
				$op="($".$capit.") Préstamo ".$descri." ".$fecha."\nSin interés";
			}else{
				if($tasa==="VEN"){
					$op="($".$capit.") Venta".$descri." ".$fecha."\nA crédito";
				}else{
					$op="($".$capit.") Empeño|Préstamo ".$descri." ".$fecha."\nTasa ".$tasa;
				}
			}
			$title=$nomtit." #".$numcte."\n".$op."\n".$estope;
			if($registro[9]===$client && $registro[10]===$operac){
				$tbody=$tbody.cargarrefrendos($idope, $min, $day, $init, $limit, $tasa, $color, $estope, $idcte);
			}else{
				if($i>=2){
					$tbody=$tbody."</tr>";
				}
				$tbody=$tbody."<tr title='$title' $hide>
						<td bgcolor='$color'>$registro[1] #$registro[0]</td>
						<td bgcolor='$color'>$registro[3]</td>";
				$tbody=$tbody.cargarrefrendos($idope, $min, $day, $init, $limit, $tasa, $color, $estope, $idcte);
			}	
			}
			$operacion=$idope;
		}

		$tot=calcularTotales($day, $init, $limit);
		$tbody=$tbody."</tr>".$tot;

		echo $tbody;
	}

	$mysqli->close();
	exit;

	function cargarrefrendos($idop, $min, $day, $init, $limit, $tasa, $color, $estope, $idcte){
		$e=explode("-", $init);
		$year=$e[0];

		$cadena="<td style='font-size:8px; color:black !important'>REF".$init."</td>";
		$yyyy=$year;
		for($i=0; $i<10; $i++){
			$min=(int)$min+1;
			if($min===13){
				$min=1;
				$yyyy=$yyyy+1;
			}
			if($min<=9){
				$min="0".$min;
			}
			$cadena=$cadena."<td style='font-size:8px; color:black !important'>REF".$yyyy."-".$min."-".$day."</td>";
		}
		$cadena=$cadena."<td style='font-size:8px; color:black !important'>REF".$limit."</td>
					</tr>";

		$sql1="SELECT fechaVencimiento, interes, abonoCapital, estado FROM refrendos WHERE idDatosGenerales='$idop' AND fechaVencimiento LIKE '%$day' AND fechaVencimiento>='$init' AND fechaVencimiento<='$limit'";

		$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");

		if($resultado1=_val_con($sql1, $mysqli1)){
			while($registro1=mysqli_fetch_row($resultado1)){
				if($estope==="Vigente"){
					if($registro1[3]==="Vencido" || $registro1[3]==="Cargado"){
						$color="white";
					}
				}
	
				$fecven=$registro1[0];
				$param1="<td style='font-size:8px; color:black !important'>REF".$fecven;
				$param2="<td bgcolor='$color'>$";
				// los que tiene tasa del 0% solo se programan, no se suman a los acumuladores
				if($tasa==="0%" || $tasa==="VEN"){
					$param2=$param2.$registro1[2];
				}else{
					$param2=$param2.$registro1[1];
				}
				$remplazado=str_replace($param1, $param2, $cadena);
				$cadena=$remplazado;
			}
		}

		$tbody=$tbody.$cadena;

		$mysqli1->close();

		$client=$idcte;
		$operac=$idop;
		return $tbody;
	}

	function calcularTotales($day, $init, $limit){
		$totales="<tr>
					<td colspan='2' style='color:white; text-align: right; padding-right:5px'><b>Totales = </b></td>";
		$exp=explode("-", $init);

		$mm=(int)$exp[1];
		$yy=$exp[0];
		$dd=$exp[2];
		for($i=0; $i<12; $i++){
			if($mm>=13){
				$mm=1;
				$yy=$yy+1;
			}
			if($mm<=9){
				$mm="0".$mm;
			}

			$acum=0; $sipag=0; $nopag=0;
			$ymd=$yy."-".$mm."-".$dd;
			$sql2="SELECT A.fechaVencimiento, A.interes, A.abonoCapital, A.estado, B.tasa FROM refrendos A, datos_generales B WHERE A.idDatosGenerales=B.id AND A.fechaVencimiento='$ymd'";

			$mysqli2=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
			if($resultado2=_val_con($sql2, $mysqli2)){
				while($registro2=mysqli_fetch_row($resultado2)){
					// los que tiene tasa del 0% solo se programan, no se suman a los acumuladores
					if($registro2[3]==="Pagado"){
						if($registro2[4]==="VEN"){
							$acum=$acum+$registro2[2];
							$sipag=$sipag+$registro2[2];
						}else{
							$acum=$acum+$registro2[1];
							$sipag=$sipag+$registro2[1];
						}
					}else{
						if($registro2[4]==="VEN"){
							$acum=$acum+$registro2[2];
							$nopag=$nopag+$registro2[2];
						}else{
							$acum=$acum+$registro2[1];
							$nopag=$nopag+$registro2[1];
						}
					}
				}
			}

			$sipag=($acum-$nopag); // Cuadra los
			if($sipag===0){ 
				$color="white";
			}else{
				$color="#FFFF99";
			}
			$tit=" + $$acum Gran total\n - $$nopag No pagados \n = $$sipag Pagados";
			$totales=$totales."<td style='background:$color' title='$tit'><b>$$sipag</b></td>";

			$mm=(int)$mm+1;
		}

		$totales=$totales."</tr>";

		$mysqli2->close();
		return $totales;
	}
?>