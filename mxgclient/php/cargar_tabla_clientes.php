<?php
	include ("../../php/functions.php");

	$busqueda=$_GET["busqueda"];
	if($busqueda==="No client" || $busqueda===""){
		$sql="SELECT id_cliente, num_cte, nom_tit, fec_reg, clasificacion, estado, nom_cot FROM clientes ORDER BY id_cliente LIMIT 30";
	}else{
		$sql="SELECT id_cliente, num_cte, nom_tit, fec_reg, clasificacion, estado, nom_cot FROM clientes WHERE (nom_tit LIKE '%$busqueda%' OR nom_cot LIKE '%$busqueda%') OR num_cte LIKE '%$busqueda%' ORDER BY id_cliente LIMIT 30";
	}

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){
		$datos="";
		$rows=mysqli_num_rows($resultado);
		if($rows>=1){
			while($registro=mysqli_fetch_row($resultado)){
				$antiguedad=_get_antiquity($registro[3]);
				if($registro[5]==="Alta"){
					$color="#FFFF99";
				}else{
					$color="lightcoral";
				}
				$datos=$datos."<tr bgcolor='$color'>
									<td style='width:10%'><input type='radio' class='$registro[1]' name='cliente' value='$registro[0]'>$registro[1]</td>
									<td style='width:40%'><img src='./img/$registro[4].png' width='20' height='20' style='margin-top:1px; margin-bottom:-3px'>$registro[2]</td>
									<td style='width:40%'>$registro[6]</td>
									<td style='width:10%'>$antiguedad</td>
								</tr>";
			}
		}else{
			$datos="<tr><td colspan='4'><center><b>🙄 No hay coincidencias</b></center></td></tr>";	
		}		
		echo $datos;
	}

	$mysqli->close();
	exit;
?>