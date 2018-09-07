<?php
	include ("functions.php");

	$sql="UPDATE numserial SET estado='Desactivado' WHERE idSeri=1";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	_val_con($sql, $mysqli);

	/************** Notify to User Admin Email **************/
	$asunto="JK Inventory: Desactivado!";
	$msg="El programa ha sido desactivado por ingresar códigos de activación inválidos 3 veces seguidas. Tras notificarle sobre la desactivación del programa, reincidió. Para continuar con sus labores contacte con el desarrollador y solicite la reactivación por $2500 incluida renovación más penalización por reincidencia de códigos de activación inválidos. La seguridad de su negocio no tiene precio.";
	_notify_for_email($asunto, $msg);

	/************* Notify to Developer Email **************
	$msg="Ofrecer ACTIVACIÓN CON PENALIZACIÓN por $2,500.";
	_notify_developer_email($asunto, $msg);*/
	
	echo "Desactivado";
	$mysqli->close();
	exit;
?>