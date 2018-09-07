<?php
	// codigo webscrapping	http://www.josemanuelvazquez.es/php/Scraping-php/
	require "../../webscrapping/simple_html_dom.php";

	$numpag=$_GET["numpag"];
	$numpag=(int)$numpag;
	$search=$_GET["search"];
	$result="";

	$html = new simple_html_dom();
	$html->load_file("https://tiendatelcel.com.mx/telefono-celular/pag/".$numpag);

	$imagen=$html->find("div[class=article-image] a img");
	$titulo=$html->find("h2[class=indexequipo_titulo] a");
	$precio=$html->find("span[class=lab_p]");

	$i=0;
	foreach ($titulo as $tit) {
		//$tit->innertext;
		$caract=$tit->attr["href"];
		$cel=$tit->plaintext;
		$avaluo="";
		if (preg_match("/".$search."/i", $cel)){
			$urlimg=$imagen[$i]->attr["src"];
			$pre=$precio[$i]->plaintext;
			$avaluo="<font color='red'>Consultar avalúo con un experto.</font>";
			$condic="";
			if(preg_match("/Pendiente/i", $pre)){ 
				$pre="Sin referencia de precio.";
			}else{
				$exp=explode(" ", $pre);
				$num=$exp[2];
				if(strlen($num)>=4){
					$exp=explode(",", $num);
					$num=$exp[0].$exp[1];
				}
				$avaluo=($num)/3;
				$avaluo=$avaluo-($avaluo*.3);
				$avaluo="Avalúo $ ".(int)$avaluo;
				$condic="Condiciones: equipo nuevo, accesorios originales y completos.";
			}
			$result=$result. "<div class='results' style='display:inline-block; margin-left:10px; margin-top:10px; margin-bottom:10px; padding:5px; width:350px; height:480px; background:white; vertical-align:top'>
								<div>
									<img src='$urlimg' width='350' height='350'>
								</div>
								<div>
									<h4 style='margin:5px; padding:0px'><font color='blue'>$cel</font></h4>
									<p class='precio' style='margin:5px; padding:0px'>$pre</p>
									<p style='margin:5px; padding:0px'><b>$avaluo</b></p>
									<p style='margin:5px; padding:0px; font-size:12px'>$condic</p>
								</div>
								<a href='$caract' class='precio'>Características</a>
							</div>";
		}
		$i=$i+1;
	}
	echo $result;

	exit;
?>