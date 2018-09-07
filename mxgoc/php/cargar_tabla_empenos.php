<?php
	include ("../../php/functions.php");

	$id=$_GET["id"];;
	$est=$_GET["est"];
	$sql="";

	if($id===0 || $id==="0"){
		$datos="<center><b>🤔 Realice una búsqueda de cliente</b></b></center>";
	}else{
		if($est==="Todos"){
			if($id===0){
				$sql="SELECT id, idCliente, cotitular, capital, anclaje, entregaInmediata, validado, estado, fecha, descripcion, tasa, observacion FROM datos_generales ORDER BY estado DESC, fecha DESC";
			}else{
				$sql="SELECT id, idCliente, cotitular, capital, anclaje, entregaInmediata, validado, estado, fecha, descripcion, tasa, observacion FROM datos_generales WHERE idCliente='$id' ORDER BY estado DESC, fecha DESC";
			}
		}else{
			if($id===0){
				$sql="SELECT id, idCliente, cotitular, capital, anclaje, entregaInmediata, validado, estado, fecha, descripcion, tasa, observacion FROM datos_generales WHERE estado='$est' ORDER BY estado DESC, fecha DESC";
			}else{
				$sql="SELECT id, idCliente, cotitular, capital, anclaje, entregaInmediata, validado, estado, fecha, descripcion, tasa, observacion FROM datos_generales WHERE estado='$est' AND idCliente='$id' ORDER BY estado DESC, fecha DESC";
			}
		}	

		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
		if($resultado=_val_con($sql, $mysqli)){
			$rows=mysqli_num_rows($resultado);
			if($rows===0){ 
				$datos="<center><b>😨 No hay operaciones</b></center>"; 
			}else{
				$datos="";
				$i=0;
				while($registro=mysqli_fetch_row($resultado)){
					$anc="";
					$ent="";
					$val="";
					$i=$i+1;
					$registro[8]=_convert_date_lit($registro[8]);
					if($registro[4]==="Checked"){ $anc="⚓"; }
					if($registro[5]==="Checked"){ $ent="⚡"; }
					if($registro[6]==="Checked"){ $val="✅"; }

					$color="#FFFF99";
					if($registro[7]==="Cancelado"){ $color="plum"; }
					if($registro[7]==="Liquidado"){ $color="lightcoral"; }

					if($registro[2]!=""){ $registro[2]=" [Cot. Ad: ".$registro[2]."]"; }
					else{ $registro[2]=""; }

					$desc="";
					if($registro[10]==="VEN"){ $desc="Venta ".$registro[8]." ".$registro[9]." $".$registro[3].$registro[2]; }
						else{ $desc="Empeño/Préstamo ".$registro[8]." ".$registro[9]." $".$registro[3].$registro[2]; }

					if($registro[11]===""){
						$notify="";
					}else{
						$notify="<font color='red' style='font-size:15px;'>●</font>";
					}

					$datos=$datos."<tr bgcolor='$color'>
										<td style='width: 10%'><input type='radio' class='$registro[1]' name='empeno' value='$registro[0]'>$i".$notify."</td>
										<td style='width: 60%'>$desc</td>
										<td style='width: 10%'><center><b>$anc</b></center></td>
										<td style='width: 10%'><center><b>$ent</b></center></td>
										<td style='width: 10%'><center><b>$val</b></center></td>
									</tr>";
				}
			}
		}
		$mysqli->close();
	}

	echo $datos;
	exit;
?>