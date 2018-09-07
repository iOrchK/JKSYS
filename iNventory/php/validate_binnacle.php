<?php
	include ("functions.php");
	$inventario="";
	$idbinn="";
	$datSta="";
	$datFin="";
	$observ="";
	$estado="";
	$i=0;
	//$hoy=_get_hoy();

	$sql="SELECT datSta, datFin, observ, estado FROM binnacle WHERE idBinn=(SELECT MAX(idBinn) FROM binnacle)";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows==0){ // Cuando no hay bitacoras ... Registra la primera bitacora
			$datSta=$hoy;
			$datFin=_data_last_month_day();
			$inventario=$inventario."<p>No hay inventarios. Programando primer inventario del "._convert_date($datSta)." al "._convert_date($datFin)." ...</p>";
			$sql="INSERT INTO binnacle (datSta, datFin, estado) VALUES ('$datSta', '$datFin', 'Iniciado')";
			$resultado=_val_con($sql, $mysqli);
		}else{ // Cuando hay bitacoras ...
			if($rows>=1){ // ... Arma la tabla
				$sql="SELECT idBinn, datSta, datFin, observ, estado FROM binnacle";
				if($resultado=_val_con($sql, $mysqli)){
					$inventario=$inventario."<table border='0' cellspacing='0' cellpadding='0'>
												<thead>
													<tr>
														<th id='id'>ID</th>
														<th>Inició</th>
														<th>Finalizó</th>
														<th>Observaciones</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>";
					$i=$rows;
					while($registro=mysqli_fetch_row($resultado)){
						$idbinn=$registro[0];
						$datSta=$registro[1];
						$datFin=$registro[2];
						$observ=$registro[3];
						$estado=$registro[4];
						$inventario=$inventario."<tr class='trBit' id='$idbinn'>
													<td>$i</td>
													<td>"._convert_date($datSta)."</td>
													<td>"._convert_date($datFin)."</td>
													<td>".$observ."</td>
													<td>".$estado."</td>
												</tr>";
						$i=$i-1;
					}
					$inventario=$inventario."</tbody>
											</table>";
				}
			}
		}
	}
	echo $inventario;
	$mysqli->close();
	exit;
?>