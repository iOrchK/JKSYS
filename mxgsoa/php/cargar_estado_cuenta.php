<?php
	include ("/../../php/functions.php");

	$idcte=$_GET["idcte"];
	$datos="";
	$i=0;
	$descri="";
	$gratot=0;
	$subtot=0;
	$cont=0;
	$idcontrato=0;
	$datcli="";
	$salcap=0;
	$sql="SELECT A.num_cte, A.nom_tit, A.nom_cot, A.tel_tit, A.dom_tit, B.descripcion, B.tasa, B.capital, C.fechaVencimiento, C.interes, C.abonoCapital, B.id, B.fecha FROM db_adminclientes.clientes A, datos_generales B, refrendos C WHERE A.id_cliente='$idcte' AND B.idCliente='$idcte' AND B.estado='Vigente' AND B.id=C.idDatosGenerales AND C.estado!='Pagado' ORDER BY B.id, B.fecha, C.fechaVencimiento ASC";

	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
	if($resultado=_val_con($sql, $mysqli)){
		while($registro=mysqli_fetch_row($resultado)){
			$i=$i+1;
			if($i===1){
				$numcte=$registro[0];
				$nomtit=$registro[1];
				$nomcot=$registro[2];
				$teltit=$registro[3];
				$domtit=$registro[4];
				$datcli=$datcli."<div style='background:whitesmoke; margin:10px; padding:10px; display:inline-block; width:385px; max-width: 100%; height:80px; vertical-align:top'>
									<p style='margin-top:0px; margin-bottom:0px;'><b>Cliente Número $numcte</b> <br> 🎫 $nomtit /  $nomcot <br>📱 $teltit  🏡 $domtit</p>
								</div>";	
			}


			$tasint=$registro[6];
			$capita=$registro[7];
			$fecven=$registro[8];
			if($idcontrato!=$registro[11]){
				$cont=$cont+1;
				$descri=$registro[5];
				$fecemp=$registro[12];
				$salcap=calcularSaldoCapital($registro[11], $capita);
				if($tasint==="0%"){
					if($cont===1){
						$datos=$datos."<p><b>$cont) Préstamo $descri "._convert_date_lit($fecemp)."<br>Saldo capital $$salcap | Sin interés</b></p>";
					}else{
						$datos=$datos."<p style='margin:0px; color:darkblue'><b>[$$subtot] = total</p><hr> <p style='font-weight:bold'>$cont) Préstamo $descri "._convert_date_lit($fecemp)."<br>Saldo capital $$salcap | Sin interés</b></p>";
					}
					$subtot=0;
				}else{
					if($tasint==='VEN'){
						if($cont===1){
							$datos=$datos."<p><b>$cont) Venta $descri "._convert_date_lit($fecemp)."<br>Saldo capital $$salcap | Sin interés<b></p>";
						}else{
							$datos=$datos."<p style='margin:0px; color:darkblue'><b>[$$subtot] = total</p><hr> <p style='font-weight:bold'>$cont) Venta $descri "._convert_date_lit($fecemp)."<br>Saldo capital $$salcap | Sin interés</b></p>";
						}
						$subtot=0;
					}else{
						if($cont===1){
							$datos=$datos."<p><b>$cont) Empeño/préstamo $descri "._convert_date_lit($fecemp)."<br>Saldo capital $$salcap | $tasint</b></p>";
						}else{
							$datos=$datos."<p style='margin:0px; color:darkblue'><b>[$$subtot] = total</p><hr> <p style='font-weight:bold'>$cont) Empeño/préstamo $descri "._convert_date_lit($fecemp)."<br>Saldo capital $$salcap | $tasint</b></p>";
						}
						$subtot=0;				
					}
				}
			}
			$idcontrato=$registro[11];

			$intere=$registro[9];
			$abocap=$registro[10];
			if($tasint==='VEN'){
				$subtot=$subtot+$abocap;
				$gratot=$gratot+$abocap;
				$datos=$datos."<p style='margin:0px'>($$abocap) Abono "._convert_date_lit($fecven)."</p>";
			}else{
				if($tasint==="0%"){
					$gratot=$gratot+$abocap;
					$subtot=$subtot+$abocap;
					$datos=$datos."<p style='margin:0px'>($$abocap) Recapitalización "._convert_date_lit($fecven)."</p>";
				}else{
					$gratot=$gratot+$intere;
					$subtot=$subtot+$intere;
					$datos=$datos."<p style='margin:0px'>($$intere) Interés "._convert_date_lit($fecven)."</p>";
				}
			}

		}
		if($datos===""){ 
			$datos="<p><center><b>😄 Este cliente esta al día</b></center></p>"; 
		}else{
			$datos=$datcli."<div style='background:whitesmoke; margin:10px; padding:10px; display: inline-block; width:385px; max-width: 100%; height:80px; vertical-align:top'>
								<p style='margin-top:0px; margin-bottom:5px;'><b>Resumen</b><br> Subtotal <input type='text' value='$$gratot' disabled='disabled' size='5'> + Recargos <input type='number' id='txt-recargos' value='0' min='0' max='9999' size='5'></p>
								= Total a pagar <input type='text' id='txt-gra-tot' value='$$gratot' disabled='disabled' style='color:blue;'>
								<input type='hidden' id='txt-sub-tot' value='$gratot'>
							</div>
							<center><a id='btn-dwld' href='#'>Descargar</a></center><hr>
							<div style='display:block; margin:10px; padding:10px; width:calc(100%-40px);'>".$datos."<p style='margin:0px; color:darkblue'><b>[$$subtot] = total</b></p>
							</div>";
		}
		echo $datos;
	}

	$mysqli->close();
	exit;

	function calcularSaldoCapital($iddg, $capita){
		$salcap=0;
		$sql="SELECT abonoCapital FROM refrendos WHERE idDatosGenerales='$iddg' AND estado='Pagado'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_katun_prestamos");
		if($resultado=_val_con($sql, $mysqli)){
			$salcap=$capita;
			while($registro=mysqli_fetch_row($resultado)){
				$salcap=$salcap-$registro[0];
			}
		}
		$mysqli->close();
		return $salcap;
	}
?>