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
	$prestamo=0;

	// Validacion de estado del celular, si es deteriorado o no.
	if($idestado==3){
		$respuesta="<div id='contenedor-detalles-comerciales'>
						<img src='img/error.ico' width='15' height='15'>
						<font color='red'>
							<label>No se aceptan MOVILES DETERIORADOS, es decir:</label>
						</font>
					</div>
					<div id='contenedor-detalles-comerciales'>
						<ol>
							<li>Pantalla rota, rayada, raspada, golpeada, o fallas en el touch.</li>
							<li>No carga, o falla en el centro de carga.</li>
							<li>No conecta a internet, o fallas en el WiFi.</li>
							<li>No se escucha el audio, o fallas en las bocinas y microfono.</li>
							<li>Caratula rota, rayada, incompleta, o desgastada.</li>
							<li>No lee la SIM (el chip), falla en el lector de la SIM.</li>
							<li>No lee la tarjeta de memoria, o fallas en el lector de memoria.</li>
							<li>Algún botón no funciona.</li>
							<li>Celular no enciende.</li>
						</ol>
					</div>";		
	}else{
		/**************** CONSULTAS ***************/
			// Consulta de dispositivo movil
		$sql="SELECT descripcion, year, precio_nuevo FROM moviles WHERE estado=1 AND id_movil=$idmovil";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		while($registro=mysqli_fetch_row($resultado)){
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
			if($antiguedad<=2){ $color="forestgreen"; }
			if($antiguedad<=4 && $antiguedad>=3){ $color="darkorange"; }
			if($antiguedad>=5){ $color="red"; }

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

			// Consulta de valuación
		$sql="SELECT precio_usado, prestamo FROM valuaciones WHERE estado = 1 AND id_movil=$idmovil AND id_accesorios=$idaccesorio AND id_estado_fisico=$idestado";
		if (!$resultado=$mysqli->query($sql)) {
			$respuesta=1;
			echo $respuesta;
			$mysqli->close();
			exit;
		}
		if($registro=mysqli_fetch_row($resultado)){ 
			$preciousado=$registro[0];
			$prestamo=$registro[1]; 
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
						<label id="lbl-avaluo">Precio en estas condiciones $'.$preciousado.'.</label><br>
						<label id="lbl-prestamo">Préstamo recomendado $'.$prestamo.'.</label>
					</div>';
	}

	echo $respuesta;
	$mysqli->close();
	exit;
?>