<?php
	include("conexion.php");
	$respuesta="";
	$idmetal=$_GET["id_metal"];
	$grspzanue=$_GET["grs_pza_nueva"];
	$grspzasemi=$_GET["grs_pza_semi"];
	$grsretac=$_GET["grs_retac"];
	$metal=$_GET["metal"];
	$kilataje=$_GET["kilataje"];
	$dmetal=$_GET["dmetal"];
	$estfis="";

	// Consulta de valuacion
	$sql="SELECT valor_comercial, valor_empeno FROM valuaciones WHERE id_metal='$idmetal' AND id_estado_fisico=1";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}
	while($registro=mysqli_fetch_row($resultado)){
		$valorcomercialgrspzanue=$registro[0];
		$valorgrspzanue=$registro[1];
	}

	$sql="SELECT valor_comercial, valor_empeno FROM valuaciones WHERE id_metal='$idmetal' AND id_estado_fisico=2";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}
	while($registro=mysqli_fetch_row($resultado)){
		$valorcomercialgrsretac=$registro[0];
		$valorgrsretac=$registro[1];
	}

	$sql="SELECT valor_comercial, valor_empeno FROM valuaciones WHERE id_metal='$idmetal' AND id_estado_fisico=4";
	if(!$resultado=$mysqli->query($sql)) {
		$respuesta=1; 
		echo $respuesta; 
		$mysqli->close();
		exit;
	}
	while($registro=mysqli_fetch_row($resultado)){
		$valorcomercialgrspzasemi=$registro[0];
		$valorgrspzasemi=$registro[1];
	}

	$gramostotal=$grspzanue+$grspzasemi+$grsretac;

	$avaluo=($valorcomercialgrspzanue*$grspzanue)+($valorcomercialgrspzasemi*$grspzasemi)+($valorcomercialgrsretac*$grsretac);
	$prestamorecomendado=($valorgrspzanue*$grspzanue)+($valorgrspzasemi*$grspzasemi)+($valorgrsretac*$grsretac);
	$valorgrslote=($valorgrspzanue+$valorgrspzasemi+$valorgrsretac)/3;

	// Validar estado fisico
	if($grspzanue==0 && $grspzasemi==0){ 
		$estfis='Retacería'; 
		$labelvalorgramo='<label id="lbl-retac">Al empeñar, el gramo por '.$estfis.' vale $'.$valorgrsretac.' pesos.</label><br>';
		if($metal=="Oro"){ $img='img/ro1.jpg'; }
		if($metal=="Plata"){ $img='img/rp1.jpg'; }
	}else{
		if($grspzanue==0 && $grsretac==0){ 
			$estfis='Prenda(s) Seminueva(s)';
			$labelvalorgramo='<label id="lbl-prendas-semi">Al empeñar, el gramo por '.$estfis.' vale $'.$valorgrspzasemi.' pesos.</label><br>';
			if($metal=="Oro"){ $img='img/po1.jpg'; }
			if($metal=="Plata"){ $img='img/pp1.jpg'; }
		}else{
			if($grspzasemi==0 && $grsretac==0){ 
				$estfis='Prenda(s) Nueva(s)';
				$labelvalorgramo='<label id="lbl-prendas-nuevas">Al empeñar, el gramo por '.$estfis.' vale $'.$valorgrspzanue.' pesos.</label><br>';
				if($metal=="Oro"){ $img='img/po1.jpg'; }
				if($metal=="Plata"){ $img='img/pp1.jpg'; }
			}else{ 
				$estfis='Lote'; 
				$labelvalorgramo='<label id="lbl-lote">Al empeñar, el gramo por '.$estfis.' vale $'.$valorgrslote.' pesos en promedio.</label><br>';
				if($metal=="Oro"){ $img='img/lo1.jpg'; }
				if($metal=="Plata"){ $img='img/lp1.jpg'; }
			}
		}
	}

	$respuesta='<div id="contenedor-imagen">
					<img src="'.$img.'" id="img-est-fis" width="410" height="410">
				</div>
				<div id="contenedor-detalle-metal">
					<h4>Detalles Comerciales del Metal</h4>
					<label id="lbl-metal">'.$dmetal.'.</label><br>
					<label id="lbl-valor-comercial">Su valor comercial por gramo es de $'.$valorcomercialgrspzanue.' pesos.</label><br>		
				</div>
				<div id="contenedor-detalle-prenda">
					<h4>Detalles de Empeño</h4>
					<label id="lbl-estfi">'.$estfis.' de '.$metal.' '.$kilataje.' ó '.$gramostotal.' grs. aprox. en total.</label><br>
					<label id="lbl-sin-piedras">No cuenta el peso de las gemas.</label>	
					<label id="lbl-avalu">En estas condiciones vale $'.$avaluo.' pesos.</label><br>
					'.$labelvalorgramo.'
					<label id="lbl-prere">El préstamo máximo como empeño es de $'.$prestamorecomendado.' pesos.</label>
				</div>';
				
	echo $respuesta;
	$mysqli->close();
	exit;
?>