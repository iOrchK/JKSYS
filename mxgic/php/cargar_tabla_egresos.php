<?php
	include ("/../../php/functions.php");

	$fec=$_GET["fec"];
	$datos="";
	$i=0;

	$sql="SELECT A.id, B.descripcion, A.descripcion, A.monto, A.estado FROM egresos A, categresos B WHERE A.fecha='$fec' AND A.idCategoria=B.id";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_egresos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$i=$i+1;
			$color="white";
			if($registro[4]==="Cancelado"){ $color="plum"; }
			if($registro[4]==="Vencido"){ $color="#FFFF99"; }
			if($registro[4]==="Pagado"){ $color="lightcoral"; }

			$datos=$datos."<tr bgcolor='$color'>
								<td style='width: 10%'><input type='radio' name='egreso' value='$registro[0]'>$i</td>
								<td style='width: 30%'>$registro[1]</td>
								<td style='width: 45%'>$registro[2]</td>
								<td style='width: 15%'>$$registro[3]</td>
							</tr>";
		}
		if($datos===""){
			$datos="<tr><td colspan='4'><center>😃 No hay egresos en este día</center></td></tr>";
		}
		echo $datos;
	}

	//echo $fec;
	$mysqli->close();
	exit;
?>