<?php
	include ("../../php/functions.php");

	$folcte=$_POST["txt-fol-cte"];
	$numcte=$_POST["txt-num-cte"];
	$fecreg=$_POST["txt-fec-reg"];
	$nomtit=$_POST["txt-nom-tit"];
	$idetit=$_POST["txt-ide-tit"];
	$claide=$_POST["txt-cla-ide"];
	$nomcot=$_POST["txt-nom-cot"];
	$telefo=$_POST["txt-tels"];
	$domici=$_POST["txt-doms"];
	$emails=$_POST["txt-emails"];
	$clacli=$_POST["txt-cla-cli"];
	$anoadi=$_POST["txt-ano-adi"];

	if($claide===""){ $claide="No proporcionado"; }
	if($nomcot===""){ $nomcot="No proporcionado"; }
	if($telefo===""){ $telefo="No proporcionado"; }
	if($domici===""){ $domici="No proporcionado"; }
	if($emails===""){ $emails="No proporcionado"; }

	$sql="UPDATE clientes SET num_cte='$numcte', fec_reg='$fecreg', nom_tit='$nomtit', ide_tit='$idetit', cla_ide='$claide', nom_cot='$nomcot', tel_tit='$telefo', dom_tit='$domici', ema_tit='$emails', ano_adi='$anoadi', clasificacion='$clacli', estado='Alta' WHERE id_cliente='$folcte'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Cliente modificado!"; }

	$mysqli->close();
	exit;
?>