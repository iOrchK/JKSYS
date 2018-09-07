<?php
	include ("functions.php");
	$date="";
	if(isset($_POST["txt-date"])){ $date=$_POST["txt-date"];
	}else{ $date=_get_hoy(); }
	$listmoves="";

	$sql="SELECT idStoc, idProd, timReg, quant, moveme, idUser FROM stock WHERE datReg='$date' AND eliminado='No' ORDER BY timReg ASC";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$idStoc=$registro[0];
			$idProd=$registro[1];
			$descri="";
			$cant=$registro[3];
			$move=$registro[4];
			if($move=="Ingreso"){ $move="entrada"; }else{ $move="salida"; }
			$explode=explode(":", $registro[2]);
			$time=$explode[0].":".$explode[1]." hrs";
			$idUser=$registro[5];
			$user="";
			$sql1="SELECT descri, marca FROM products WHERE idProd='$idProd'";
			$mysqli1=_con_db("localhost", "root", "<3JK271015", "db_inventory");
			if($resultado1=_val_con($sql1, $mysqli1)){
				while($registro1=mysqli_fetch_row($resultado1)){
					$descri=$registro1[1]." ".$registro1[0];
				}
			}
			$sql2="SELECT name FROM user WHERE idUser='$idUser' AND estado='Alta'";
			$mysqli2=_con_db("localhost", "root", "<3JK271015", "db_inventory");
			if($resultado2=_val_con($sql2, $mysqli2)){
				while($registro2=mysqli_fetch_row($resultado2)){
					$user=$registro2[0];
				}
			}
			$listmoves=$listmoves."<option value='".$idStoc."'>$time - $user, $move de $cant unidades de $marca $descri</option>";
		}
		echo $listmoves;
		$mysqli->close();
		exit;
	}
?>