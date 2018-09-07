<?php
	include ("functions.php");

	$sql="UPDATE securitykey SET estado='Bloqueado' WHERE idKey=1";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	_val_con($sql, $mysqli);

	$asunto="JK Inventory: Blockeado!";
	$msg="El programa se ha bloqueado por seguridad del negocio debido a que el usuario actual ha introducido claves de usuario inválidas. Tras haberle notificado 3 veces antes del bloqueo, reincidió. Costo por desbloqueo $750. La seguridad de su negocio no tiene precio. Contacte al desarrollador para solicitar el desbloqueo.";
	_notify_for_email($asunto, $msg);

	/************* Notify to Developer Email **************
	$msg="Ofrecer DESBLOQUEO por $750.";
	_notify_developer_email($asunto, $msg);*/
	
	echo "Blocked";
	$mysqli->close();
	exit;
?>