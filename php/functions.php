<?php
	error_reporting(0);
	/********************** Funciones ***********************/
	function _con_db($host, $user, $pass, $db){
		$mysqli = new mysqli($host, $user, $pass, $db);
		// Validar conexión a la base de datos
		if ($mysqli->connect_errno) { 
			echo "<p><b>❌ ERROR CODIGO DBCON</b> Sugerencias: 1️⃣  Cierre el programa y vuelva a abrirlo. Si no dio resultado 2️⃣ Desconecte el modem 10 segundos y vuelva a conectarlo. 👨‍💻 Si el problema persiste contacte al programador.</p>";
			$mysqli->close(); 
			exit; 
		}
		return $mysqli;
	}

	function _val_con($sql, $mysqli){
		if (!$resultado=$mysqli->query($sql)) {
			echo "<p><b>❌ ERROR CODIGO QUERY</b> Sugerencias: 1) Cierre el programa y vuelva a abrirlo. Si no dio resultado 2) Desconecte el modem 10 segundos y vuelva a conectarlo. 👨‍💻 Si el problema persiste contacte al programador.</p>";
			$mysqli->close();
			exit;
		}
		return $resultado;
	}

	function _get_hoy(){
		date_default_timezone_set('America/Mexico_City');
		$hoy = date('Y-m-d', strtotime(date('Y/m/d')));
		return $hoy;
	}

	function _get_time_now(){
		date_default_timezone_set('America/Mexico_City');
		$now=date('H:i:s');
		return $now;
	}

	function _get_delivery_time(){
		date_default_timezone_set('America/Mexico_City');
		$now=date('g:i a');
		$fecha=strtotime('+1 hour', strtotime($now));
		$fecha=strtotime('+30 minutes', $fecha);
		$fecha=date('g:i a', $fecha);
		return $fecha;
	}

	// Conversión a formato de telefono 999-123-45-67 ó 912-34-56
	function _convert_num_tel($tel){
		if($tel=="No proporcionado"){
			$tel="No proporcionado";
		}else{
			if(is_int((int) $tel)){
				$strlen=strlen($tel);
				if($strlen==10){
					$part1=substr($tel, 0, 3);  // 999
					$part2=substr($tel, 3, 3);  // 123
					$part3=substr($tel, 6, 2);  // 45
					$part4=substr($tel, 8, 2);  // 67
					$tel=$part1."-".$part2."-".$part3."-".$part4;
				}else{
					if($strlen==7){
						$part1=substr($tel, 0, 3);  // 912
						$part2=substr($tel, 3, 2);  // 34
						$part3=substr($tel, 5, 2);  // 56
						$tel=$part1."-".$part2."-".$part3;
					}else{
						$tel="Inválido";
					}
				}
			}else{
				$tel="Inválido";
			}	
		}
		return $tel;
	}

	// conversion a formato de fecha 01 de Enero del 2000
	function _convert_date($fecha){
		$explode=explode("-", $fecha);
		$d=$explode[2]; // 01
		$m=$explode[1]; // 12
		$a=$explode[0]; // 1999
		if($m=="01"){ $m="Enero"; }
		if($m=="02"){ $m="Febrero"; }
		if($m=="03"){ $m="Marzo"; }
		if($m=="04"){ $m="Abril"; }
		if($m=="05"){ $m="Mayo"; }
		if($m=="06"){ $m="Junio"; }
		if($m=="07"){ $m="Julio"; }
		if($m=="08"){ $m="Agosto"; }
		if($m=="09"){ $m="Septiembre"; }
		if($m=="10"){ $m="Octubre"; }
		if($m=="11"){ $m="Noviembre"; }
		if($m=="12"){ $m="Diciembre"; }
		$fecha=(int)$d." de ".$m." del ".$a;
		return $fecha;
	}

	function _convert_date_lit($fecha){
		$explode=explode("-", $fecha);
		$a=$explode[0]; // 1999
		$m=$explode[1]; // 12
		$d=$explode[2]; // 01
		if($m=="01"){ $m="Ene"; }
		if($m=="02"){ $m="Feb"; }
		if($m=="03"){ $m="Mar"; }
		if($m=="04"){ $m="Abr"; }
		if($m=="05"){ $m="May"; }
		if($m=="06"){ $m="Jun"; }
		if($m=="07"){ $m="Jul"; }
		if($m=="08"){ $m="Ago"; }
		if($m=="09"){ $m="Sep"; }
		if($m=="10"){ $m="Oct"; }
		if($m=="11"){ $m="Nov"; }
		if($m=="12"){ $m="Dic"; }
		$a=$a-2000;
		$fecha=(int)$d."/".$m."/".$a;
		return $fecha;
	}

	function _cut_date_yyyymm($fecha){
		$explode=explode("-", $fecha);
		$a=$explode[0]; // 1999
		$m=$explode[1]; // 12
		return $a."-".$m;
	}

	function _convert_date_month_year($fecha){
		$explode=explode("-", $fecha);
		$m=$explode[1]; // 12
		$a=$explode[0]; // 1999
		if($m=="01" || $m=="1"){ $m="Ene"; }
		if($m=="02" || $m=="2"){ $m="Feb"; }
		if($m=="03" || $m=="3"){ $m="Mar"; }
		if($m=="04" || $m=="4"){ $m="Abr"; }
		if($m=="05" || $m=="5"){ $m="May"; }
		if($m=="06" || $m=="6"){ $m="Jun"; }
		if($m=="07" || $m=="7"){ $m="Jul"; }
		if($m=="08" || $m=="8"){ $m="Ago"; }
		if($m=="09" || $m=="9"){ $m="Sep"; }
		if($m=="10"){ $m="Oct"; }
		if($m=="11"){ $m="Nov"; }
		if($m=="12"){ $m="Dic"; }
		$fecha=$m."/".$a;
		return $fecha;
	}

	function _generate_next_month($fecven){
		date_default_timezone_set('America/Mexico_City');
		$fecven=date('Y-m-d', strtotime('+1 month', strtotime($fecven)));
		return $fecven;
	}

	function _generate_previous_year($fecven){
		$fecven=date('Y-m-d', strtotime('-1 year', strtotime($fecven)));
		return $fecven;
	}

	function _generate_next_year($fecven){
		$fecven=date('Y-m-d', strtotime('+1 year', strtotime($fecven)));
		return $fecven;
	}

	function _data_last_month_day(){ 
    	$month = date('m');
    	$year = date('Y');
    	$day = date("d", mktime(0,0,0, $month+1, 0, $year));
    	return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
	};

	function _diff_two_dates($fecven){
		$fechoy=_get_hoy();
		$diffec=0;
		$fec1 = strtotime($fecven);
	    $fechoy = strtotime($fechoy);
	    $diffec = $fechoy - $fec1;
	    $diffec = (( ( $diffec / 60 ) / 60 ) / 24);
	    return $diffec;
	}

	function _notify_for_email($asunto, $msg){
		$from="app.desbloq.002@gmail.com";
		$email="";
		$sql="SELECT email FROM user WHERE type='admin'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		if($resultado=_val_con($sql, $mysqli)){
			$registro=mysqli_fetch_row($resultado);
			$email=$registro[0];
			$mysqli->close();
			if($email!=""){
				$mail = $msg;
				//cabecera
				$headers = "MIME-Version: 1.0\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
				//dirección del remitente 
				$headers .= "From: JK iNventory<".$from.">\n";
				//Enviamos el mensaje a tu_dirección_email 
				$bool = mail($email,$asunto,$mail,$headers);
				return $bool;
			}
		}
	}

	function _notify_developer_email($asunto, $msg){
		$sql="SELECT name, email FROM user WHERE type='admin'";
		$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
		_val_con($sql, $mysqli);
		$registro=mysqli_fetch_row($resultado);
		$adminname=$registro[0];
		$adminemai=$registro[1];
		$mysqli->close();
		$msg="Cliente: ".$adminname." (".$adminemai."). ".$msg;

		//$from="app.desbloq.002@gmail.com";
		$email="yahicimosclick9193@gmail.com";
		$mail = $msg;
		//cabecera
		$headers = "MIME-Version: 1.0\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
		//dirección del remitente 
		$headers .= "From: JK iNventory<iNventory@email.com>\n";
		//Enviamos el mensaje a tu_dirección_email 
		$bool = mail($email,$asunto,$mail,$headers);

		return $bool;
	}

	function _convert_date_month($month){
		switch ($month) {
			case '01':
				return "Enero";
				break;
			case '02':
				return "Febrero";
				break;
			case '03':
				return "Marzo";
				break;
			case '04':
				return "Abril";
				break;
			case '05':
				return "Mayo";
				break;
			case '06':
				return "Junio";
				break;
			case '07':
				return "Julio";
				break;
			case '08':
				return "Agosto";
				break;
			case '09':
				return "Septiembre";
				break;
			case '10':
				return "Octubre";
				break;
			case '11':
				return "Noviembre";
				break;
			case '12':
				return "Diciembre";
				break;
			default:
				return $month;
				break;
		}
	}

	function _get_antiquity($fecreg){
		$explode=explode("-", $fecreg);
		$year=$explode[0];

		$hoy=_get_hoy();
		$explode=explode("-", $hoy);

		$antiguedad=$explode[0]-$year;
		// " año/años aprox."
		if($antiguedad===1){
			$antiguedad=$antiguedad." año";
		}else{
			$antiguedad=$antiguedad." años";
		}
		return $antiguedad;
	}

	function _round_five($num){
		if($num<=9){ 
			$num=10;
		}else{
			if($num%5>=1){
				$num=($num-($num%5))+5;
			}
		}
		return $num;
	}
?>