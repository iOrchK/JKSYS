<?php
	include ("functions.php");
	$sql="";
	if(isset($_GET["txt-stock-prod"])){ 
		$search=$_GET["txt-stock-prod"];
		$sql="SELECT idProd, descri, marca FROM products WHERE estado='Activo' AND descri LIKE '%$search%' ORDER BY marca ASC, descri ASC";
	}
	else{ $sql="SELECT idProd, descri, marca FROM products WHERE estado='Activo' ORDER BY marca ASC, descri ASC"; }
	$stock="";

	$i=0;
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$ingresos=0;
			$egresos=0;
			$final=0;
			$color="";
			$line="";
			$idProd=$registro[0];
			$descri=$registro[1];
			$marca=$registro[2];
			$line=$line.$marca." ".$descri." (";
			$sql1="SELECT quant FROM stock WHERE idProd='$idProd' AND moveme='Ingreso' AND eliminado='No'";
			$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_inventory");
			if($resultado1=_val_con($sql1, $mysqli1)){
				while($registro1=mysqli_fetch_row($resultado1)){
					$ingresos=$ingresos+$registro1[0];
				}
				$mysqli1->close();
			}
			$sql2="SELECT quant FROM stock WHERE idProd='$idProd' AND moveme='Egreso' AND eliminado='No'";
			$mysqli2=_con_db("localhost", "root", "<3JK271015", "db_inventory");
			if($resultado2=_val_con($sql2, $mysqli2)){
				while($registro2=mysqli_fetch_row($resultado2)){
					$egresos=$egresos+$registro2[0];
				}
				$mysqli2->close();
			}
			$final=$ingresos-$egresos;
			if($final==0){ $color="crimson"; }
			if($final>=1 && $final<=3){ $color="darkorange"; }
			if($final>=4){ $color="green"; }
			$i=$i+1;
			$line="<hr><p style='background-color: $color; color: whitesmoke;'>".$line.$final.")</p></font>";
			$stock=$stock.$line;
		}
		$stock="<font color='gray'><label>".$i." encontrados</label></font>".$stock;
		echo $stock;
		$mysqli->close();
		exit;
	}
?>