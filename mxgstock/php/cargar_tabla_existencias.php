<?php
	include ("../../php/functions.php");

	$filtro=$_GET["filtro"];
	$busq=$_GET["busqueda"];
	$rows="";
	$sql="SELECT A.nom_tit, B.fecha, A.num_cte, B.descripcion, B.caracteristicas FROM db_adminclientes.clientes A, datos_generales B WHERE B.idCliente=A.id_cliente AND B.estado='Vigente' AND B.descripcion NOT LIKE '%sin garant%' AND B.descripcion NOT LIKE '%prestamo%' AND B.descripcion NOT LIKE '%préstamo%' AND B.descripcion NOT LIKE '%sin inter%'";

	switch ($filtro) {
		case 'nombre':
			$sql=$sql." AND A.nom_tit LIKE '%$busq%'";
			break;
		case 'numcte':
			$sql=$sql." AND A.num_cte LIKE '$busq'";
			break;
		case 'fecha':
			$sql=$sql." AND B.fecha LIKE '$busq'";
			break;
		case 'tipo':
			$sql=$sql." AND B.descripcion LIKE '%$busq%'";
			break;
		default:
			# code...
			break;
	}

	$sql=$sql." ORDER BY B.descripcion, B.fecha DESC";	

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){ 
			$datos="<center><b>😨 No hay operaciones</b></center>"; 
		}else{
			$i=0;
			while($registro=mysqli_fetch_row($resultado)){
				$i=$i+1;
				$fecha=_convert_date_lit($registro[1]);
				$etiqueta="$registro[0]<br>$fecha<br>#$registro[2]";
				$rows=$rows."<tr>
								<td>$i</td>
								<td>$etiqueta</td>
								<td>$registro[3]</td>
								<td>$registro[4]</td>
							</tr>";
			}
			echo $rows;
		}
	}

	$mysqli->close();
	exit;
?>