<?php
	include ("functions.php");
	$datemove="";
	if(isset($_GET["txt-date-moves"])){ $datemove=$_GET["txt-date-moves"]; }
	else{ $datemove=_get_hoy(); }
	$moves="";
	$quant=0;
	

	$sql="SELECT idProd, descri, marca FROM products WHERE estado='Activo'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$idProd=$registro[0];
			$descri=$registro[1];
			$marca=$registro[2];
			$sql1="SELECT quant FROM stock WHERE idProd='$idProd' AND datReg='$datemove' AND moveme='Egreso' AND eliminado='No'";
			$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_inventory");
			if($resultado1=_val_con($sql1, $mysqli1)){
				$acum=0;
				while($registro1=mysqli_fetch_row($resultado1)){
					$quant=$registro1[0];
					$acum=$acum+$quant;
				}
				if($acum>=1){ $moves=$moves."<hr><p>".$marca.": ".$descri." (".$acum.")</p>"; }
			}
		}
		if($moves==""){ $moves="<p>- Sin salidas -</p>"; }
	}

	echo $moves;
	$mysqli->close();
	exit;
?>