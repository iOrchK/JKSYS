<?php
	include ("../../php/functions.php");

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

	if($claide===""){ $claide="No presentado"; }
	if($nomcot===""){ $nomcot="No proporcionado"; }
	if($telefo===""){ $telefo="No proporcionado"; }
	if($domici===""){ $domici="No proporcionado"; }
	if($emails===""){ $emails="No proporcionado"; }

	$sql="INSERT INTO clientes(num_cte, fec_reg, nom_tit, ide_tit, cla_ide, nom_cot, tel_tit, dom_tit, ema_tit, ano_adi, clasificacion, estado) VALUES('$numcte', '$fecreg', '$nomtit', '$idetit', '$claide', '$nomcot', '$telefo', '$domici', '$emails', '$anoadi', '$clacli', 'Alta')";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_adminclientes");
	if($resultado=_val_con($sql, $mysqli)){ echo "✔ Cliente agregado!"; }

	$mysqli->close();
	exit;
?>