<?php
/**** Notificaciones de control de navegador html ****/
	include ("functions.php");
	$asunto=$_GET["txt-asunto"];
	$msg=$_GET["txt-msg"];
	
	if(_notify_for_email($asunto, $msg)){ echo "Acción notificada";
	}else{ echo "Mensaje no enviado"; }
	exit;
?>