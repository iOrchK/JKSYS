<?php
	include ("conexion.php");

	$respuesta="";
	$idmovil=$_GET["id_movil"];
	$idestado=$_GET["id_estado"];
	$idaccesorio=$_GET["id_accesorios"];
	$descripcion="";
	$precionuevo=0;
	$year=0;
	$caracteristicas="";
	$antiguedad=0;
	$estado="";
	$accesorios="";
	$preciousado=0;
	$preciousadofinal=0;
	$prestamo=0;
	$prestamofinal=0;
	$iddevaluacionestado=0;
	$porcentajede=0;
	$porcentajeda=0;
	$msgcapmax="";
	$stylemsgmaxcap="display:none;";
	$styleprestamo="text-decoration:underline;";


		/**************** CONSULTAS ***************/
			// Consulta de dispositivo movil
		$sql="SELECT descripcion, year, precio_nuevo FROM moviles WHERE estado=1 AND id_movil=$idmovil";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		if($registro=mysqli_fetch_row($resultado)){
			$descripcion=$registro[0];
			$year=$registro[1];
			$precionuevo=$registro[2];
		}

			// Separacion de la descripcion y características
			$explode=explode(": ", $descripcion);
			$descripcion=$explode[0];
			$caracteristicas=$explode[1];

			// Cálculo de antiguedad
			date_default_timezone_set('America/Mexico_City');
			$hoy = date('Y-m-d', strtotime(date('Y/m/d')));
			$explode=explode("-", $hoy);
			$antiguedad=$explode[0]-$year;

			// Validacion de color de texto de #lbl-antiguedad
			if($antiguedad==1){ $color="forestgreen"; }
			if($antiguedad<=3 && $antiguedad>=2){ $color="darkorange"; }
			if($antiguedad>=4){ $color="red"; }

			// Consulta de estado fisico del dispositivo movil
		$sql="SELECT descripcion FROM estados_fisicos WHERE estado=1 AND id_estado_fisico=$idestado";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		if($registro=mysqli_fetch_row($resultado)){ $estado=$registro[0]; }

			// Consulta de accesorios del dispositivo movil
		$sql="SELECT descripcion FROM accesorios_incluidos WHERE estado=1 AND id_accesorios=$idaccesorio";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		if($registro=mysqli_fetch_row($resultado)){ $accesorios=$registro[0]; }

			// Validación obtener el porcentaje de devaluación
			if($idaccesorio==1 && $idestado==1){ $iddevaluacionestado=1; }
			if($idaccesorio==2 && $idestado==1){ $iddevaluacionestado=2; }
			if($idaccesorio==1 && $idestado==2){ $iddevaluacionestado=3; }
			if($idaccesorio==2 && $idestado==2){ $iddevaluacionestado=4; }
			if($idaccesorio==1 && $idestado==3){ $iddevaluacionestado=5; }
			if($idaccesorio==2 && $idestado==3){ $iddevaluacionestado=6; }

			// Consulta de porcentaje de devaluo x estado
		$sql="SELECT porcentaje FROM devaluacion_estado WHERE id_devaluacion_estado = '$iddevaluacionestado'";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		if($registro=mysqli_fetch_row($resultado)){ $porcentajede=$registro[0]; }

			// Consulta de porcentaje de devaluo x antiguedad
		$sql="SELECT porcentaje FROM devaluacion_antiguedad WHERE id_devaluacion_antiguedad=1";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		if($registro=mysqli_fetch_row($resultado)){ $porcentajeda=$registro[0]; }

			// Cálculo de Precio usado
			$preciousado=$precionuevo*$porcentajede;
			for ($i=0; $i < $antiguedad; $i++) { 
				$preciousado=$preciousado*$porcentajeda;
				$preciousado=round($preciousado, 0);
			}

			// Redondearlo a multiplo de 50
			while ($preciousadofinal<=$preciousado) { $preciousadofinal=$preciousadofinal+50; }

			// Cálculo de préstamo
			$prestamo=$preciousado/2;
			for ($i=0; $i < $antiguedad; $i++) { 
				$prestamo=$prestamo*$porcentajeda;
				$prestamo=round($prestamo, 0);
			}

			// Redondearlo a multiplo de 50
			while ($prestamofinal<=$prestamo) { $prestamofinal=$prestamofinal+50; }

			// Validar préstamo máximo de capital
			if($prestamofinal>3000){ 
				$stylemsgmaxcap="text-decoration:underline; color:blue; display:block;";
				$msgcapmax="<br><label style='".$stylemsgmaxcap."'>El capital máximo autorizado por Nuevo Sol es de $3000.</label>";
				$styleprestamo="text-decoration:line-through; color: black;";
			}

		$respuesta='<div id="contenedor-detalles-comerciales">
						<h4>Detalles Comerciales del Dispositivo Movil</h4>
						<label id="lbl-descripcion">'.$descripcion.'.</label><br>
						<label id="lbl-lanzamiento">Lanzamiento en el '.$year.'.</label><br>
						<label id="lbl-precio-nuevo">Precio Nuevo $'.$precionuevo.'.</label><br>
						<label id="lbl-caracteristicas">Características: '.$caracteristicas.'</label>
					</div>
					<div id="contenedor-detalles-empeño">
						<h4>Detalles de Empeño</h4>
						<label id="lbl-estado-actual">Equipo '.$estado.' con Accesorios '.$accesorios.'.</label><br>
						<font color="'.$color.'"><label id="lbl-antiguedad">'.$antiguedad.' Años de Antiguedad.</label><br></font>
						<label id="lbl-avaluo">Precio en estas condiciones $'.$preciousadofinal.'.</label><br>
						<label id="lbl-prestamo" style="'.$styleprestamo.'">Préstamo recomendado $'.$prestamofinal.'.</label>
						'.$msgcapmax.'
					</div>';

	echo $respuesta;
	$mysqli->close();
	exit;
?>