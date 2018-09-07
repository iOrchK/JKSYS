<?php
	include ("functions.php");
	$datemove="";
	if(isset($_GET["txt-date-moves"])){ $datemove=$_GET["txt-date-moves"]; }
	else{ $datemove=_get_hoy(); }
	$moves="";

	$sql="SELECT timReg, idProd, quant, idUser, eliminado FROM stock WHERE datReg='$datemove' AND moveme='Ingreso' ORDER BY idStoc DESC";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		$moves="<h4>Entradas</h4>";
		$line="";
		$style="";
		$rows=mysqli_num_rows($resultado);
		if($rows<=0){
			$line="<p>- Sin entradas -</p>";
			$moves=$moves.$line;
		}else{
			while($registro=mysqli_fetch_row($resultado)){
				$timReg=$registro[0];
				$idProd=$registro[1];
				$quant=$registro[2];
				$idUser=$registro[3];
				$eliminado=$registro[4];
				$style="";
				$sql1="SELECT descri FROM products WHERE idProd='$idProd'";
				$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_inventory");
				if($resultado1=_val_con($sql1, $mysqli1)){
					if($registro1=mysqli_fetch_row($resultado1)){
						$descri=$registro1[0];
						$line=$descri;
					}
				}
				$line=$quant." ".$line." recibido por ";
				$sql2="SELECT name FROM user WHERE idUser='$idUser' AND estado='Alta'";
				$mysqli2=_con_db("localhost", "root", "<3JK271015", "db_inventory");
				if($resultado2=_val_con($sql2, $mysqli2)){
					if($registro2=mysqli_fetch_row($resultado2)){
						$name=$registro2[0];
						$line=$line.$name;
					}
				}
				$explode=explode(":", $timReg);
				$line=$line." a las ".$explode[0].":".$explode[1]." hrs.";
				if($eliminado=="Si"){ $style="text-decoration:line-through;"; }
				$line="<hr><p style='$style'>".$line."</p>";
				$moves=$moves.$line;
			}
		}
	}

	$sql="SELECT timReg, idProd, quant, idUser, eliminado FROM stock WHERE datReg='$datemove' AND moveme='Egreso' ORDER BY idStoc DESC";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		$moves=$moves."<br><h4>Salidas</h4>";
		$line="";
		$style="";
		$rows=mysqli_num_rows($resultado);
		if($rows<=0){
			$line="<p>- Sin salidas -</p>";
			$moves=$moves.$line;
		}else{
			while($registro=mysqli_fetch_row($resultado)){
				$timReg=$registro[0];
				$idProd=$registro[1];
				$quant=$registro[2];
				$idUser=$registro[3];
				$eliminado=$registro[4];
				$sql1="SELECT descri FROM products WHERE idProd='$idProd'";
				$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_inventory");
				if($resultado1=_val_con($sql1, $mysqli1)){
					if($registro1=mysqli_fetch_row($resultado1)){
						$descri=$registro1[0];
						$line=$descri;
					}
				}
				$line=$quant." ".$line." retirado por ";
				$sql2="SELECT name FROM user WHERE idUser='$idUser' AND estado='Alta'";
				$mysqli2=_con_db("localhost", "root", "<3JK271015", "db_inventory");
				if($resultado2=_val_con($sql2, $mysqli2)){
					if($registro2=mysqli_fetch_row($resultado2)){
						$name=$registro2[0];
						$line=$line.$name;
					}
				}
				$explode=explode(":", $timReg);
				$line=$line." a las ".$explode[0].":".$explode[1]." hrs.";
				if($eliminado=="Si"){ $style="text-decoration:line-through;"; }
				$line="<hr><p style='$style'>".$line."</p>";
				$moves=$moves.$line;
			}
		}
	}

	echo $moves;
	$mysqli->close();
	exit;
?>