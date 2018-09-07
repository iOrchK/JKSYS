<?php
	include ("../../php/functions.php");

	$cte=$_GET["cte"];
	$tipo=$_GET["tipo"];
	$sql="";

	if($tipo==="id"){
		$sql="SELECT id_cliente, num_cte, nom_tit, nom_cot FROM clientes WHERE num_cte LIKE '%$cte%' AND estado='Alta' ORDER BY id_cliente ASC LIMIT 5";
	}else{
		$sql="SELECT id_cliente, num_cte, nom_tit, nom_cot FROM clientes WHERE nom_tit LIKE '%$cte%' OR nom_cot LIKE '%$cte%' AND estado='Alta' ORDER BY id_cliente ASC LIMIT 5";
	}

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	//$sql="SELECT id_cliente, num_cte, nom_tit FROM clientes WHERE estado='Alta' ORDER BY id_cliente ASC";

	if($resultado=_val_con($sql, $mysqli)){
		$lista="";
		$rows=mysqli_num_rows($resultado);
		if($rows===0){
			$lista=$lista."invalid";
		}else{
			while($registro=mysqli_fetch_row($resultado)){
				$lista=$lista."<option id='$registro[0]' value='$registro[2]' title='Cotitular: $registro[3]'>$registro[1]</option>";
			}
		}
		echo $lista;
	}

	$mysqli->close();
	exit;
?>