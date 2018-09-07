<?php
	/********************** Funciones ***********************/
	function _con_db($host, $user, $pass, $db){
		$mysqli = new mysqli($host, $user, $pass, $db);
		// Validar conexión a la base de datos
		if ($mysqli->connect_errno) { 
			$respuesta=0; 
			echo $respuesta;
			$mysqli->close(); 
			exit; 
		}
		return $mysqli;
	}

	function _val_con($sql, $mysqli){
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
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
		date_default_timezone_set('America/Los_Angeles');
		$now=date('H:i:s');
		return $now;
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
		$fecha=$d." de ".$m." del ".$a;
		return $fecha;
	}

	function _convert_date_lit($fecha){
		$explode=explode("-", $fecha);
		$d=$explode[2]; // 01
		$m=$explode[1]; // 12
		$a=$explode[0]; // 1999
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
		$fecha=$d."/".$m."/".$a;
		return $fecha;
	}

	function _convert_date_month_year($fecha){
		$explode=explode("-", $fecha);
		$m=$explode[1]; // 12
		$a=$explode[0]; // 1999
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
		$fecha=$m." del ".$a;
		return $fecha;
	}

	function _generate_next_month($fecven){
		$fecven=date('Y-m-d', strtotime('+1 month', strtotime($fecven)));
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
?>