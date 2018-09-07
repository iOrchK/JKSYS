<?php
	$name="Virus-J";
	$ip=gethostbyname($name);
	$exp=explode(".", $ip);
	$char1=substr($exp[2], -1);
	$char2=substr($exp[2], -2, 1);
	$ip=$exp[0].".".$exp[1].".".$exp[3].".".$char1.$char2;
	echo "Para usar iNventory en tu celular o tableta escribe el siguiente link en el navegador: ".$ip."/websys/inventory";
	exit;
?>