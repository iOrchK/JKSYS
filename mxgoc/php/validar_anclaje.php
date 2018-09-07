<?php
	include ("../../php/functions.php");

	$idcte=$_GET["idcte"];
	$folio=$_GET["folio"];
	$band="";
	$sql="SELECT fecha, capital, descripcion, anclaje, id FROM datos_generales WHERE estado='Vigente' AND anclaje='Checked' AND idCliente='$idcte'";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		$msg="";
		$i=0;
		$rows=mysqli_num_rows($resultado);
		if($rows>=1){
			while($registro=mysqli_fetch_row($resultado)){
				$i=$i+1;
				$registro[0]=_convert_date_lit($registro[0]);
				$msg=$msg.$i.") ".$registro[0]." $".$registro[1]." emp. ".$registro[2]."\n";
				if($registro[3]==="Checked" && $registro[4]===$folio){ $band="liberar"; }
			}
			if($band==="liberar"){ $msg=""; }
		}else{
			$msg="";
		}
		echo $msg;
	}

	$mysqli->close();
	exit;
?>