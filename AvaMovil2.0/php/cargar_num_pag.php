<?php
	require "../../webscrapping/simple_html_dom.php";

	$html = new simple_html_dom();
	$html->load_file("https://tiendatelcel.com.mx/telefono-celular/pag/1");

	$pagin = $html->find("div[class=links] ul[class=pagination] li a");
	$p="";
	foreach ($pagin as $pag) {
		$p=$pag->innertext;
	}
	echo $p;

	exit;
?>