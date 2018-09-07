<?php
	include ("functions.php");
	$hoy=_get_hoy();
	$mesHoy="";
	$mesDatSta="";
	$difDay="";
	$difYear="";
	$datSta="";
	$datFin="";
	$estado="";
	$inventario="";

	$sql="SELECT datSta, estado FROM binnacle WHERE idBinn=(SELECT MAX(idBinn) FROM binnacle)";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($registro=mysqli_fetch_row($resultado)){ // ... Revisa si existe bitacora del mes presente
		$mesHoy=explode("/", $hoy);
		$mesDatSta=explode("/", $datSta);
		if($mesHoy[1]==$mesDatSta[1]){
			echo "Actualizando bitacora de "._convert_date_month_year($mesHoy)." ...";
			$mysqli->close();
			exit;
		}
		$difDay=$mesHoy[2]-$mesDatSta[2];
		$difYear=$mesHoy[0]-$mesDatSta[0];
		/*
			$sql="INSERT INTO binnacle (datSta, datFin, estado) VALUES ('$datSta', '$datFin', 'Iniciado')";
			$resultado=_val_con($sql, $mysqli);
			$datSta=$registro[0];
			$datFin=$registro[1];
			$estado=$registro[2];
			$inventario=$inventario."<p>".$datSta." | ".$datFin." | ".$estado;
			*/
		if($mesHoy[1]>$mesDatSta[1]){ // Si ya paso al siguiente mes del mismo año ...
			if($diff==1){ // Crear la nueva bitacora
				$inventario=$inventario."<p>".$datSta." | ".$datFin." | ".$estado;
			}else{ // Sino marca el error con la diferencia de meses
				echo "Error. Bad Date. Clave diff: ".$diff;
				$mysqli->close();
				exit;
			}
		}
		if($mesHoy[1]<$mesDatSta[1]){ // Si ya paso el siguiente mes del siguiente año ... && (($dif==1)||($diff))
			if($diff==(-11)){ // Crear nueva bitacora
				$inventario=$inventario."<p>".$datSta." | ".$datFin." | ".$estado;
			}else{ // Sino marca el error con la diferencia de meses
				echo "Error. Bad Date. Clave diff: ".$diff;
				$mysqli->close();
				exit;
			}
		}
		
	}		
	
?>