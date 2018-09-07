$(document).ready(function(){
	// Cargar nuevo id del movil y lista de dispositivos
	funCargaCodMovil();
	funCargaDispositivos();

	// Limpiar Campos
	$("#btn-borrar").click(function(){
		funCargaCodMovil();
	});

	// Limpiar Input con Lista al hacer click
	$("#txt-descripcion").click(function(){
		$("#txt-descripcion").val("");
	});

	// Guardar nuevo registro
	$("#btn-guardar").click(function(){
		console.log("Iniciando Evento Guardar Registro");
		var id=$("#txt-cod-movil").val();
		var descripcion=$("#txt-descripcion").val();
		var añolanzamiento=$("#txt-año-lanzamiento").val();
		var so=$("#txt-so").val();
		var memint=$("#txt-mem-int").val();
		var maxmsd=$("#txt-max-msd").val();
		var ram=$("#txt-ram").val();
		var camfront=$("#txt-cam-front").val();
		var campost=$("#txt-cam-post").val();
		var usb=$("#txt-usb").val();
		var datad=$("#txt-dat-ad").val();
		var precionuevo=$("#txt-precio-nuevo").val();
		var valuacion1y1=$("#txt-precio-usado-valuacion-1").val();
		var valuacion1y2=$("#txt-prestamo-valuacion-1").val();
		var valuacion2y1=$("#txt-precio-usado-valuacion-2").val();
		var valuacion2y2=$("#txt-prestamo-valuacion-2").val();
		var valuacion3y1=$("#txt-precio-usado-valuacion-3").val();
		var valuacion3y2=$("#txt-prestamo-valuacion-3").val();
		var valuacion4y1=$("#txt-precio-usado-valuacion-4").val();
		var valuacion4y2=$("#txt-prestamo-valuacion-4").val();
		// Validar campos vacios (Excepto #txt-max-msd, #txt-cam-front, #txt-cam-post, #txt-dat-ad)
		if(id === "" || descripcion === "" || añolanzamiento === "" || so === "" || memint === "" || ram === "" || usb === "" || 
			precionuevo === "" || valuacion1y1 === "" || valuacion1y2 === "" || valuacion2y1 === "" || valuacion2y2 === "" || 
			valuacion3y1 === "" || valuacion3y2 === "" || valuacion4y1 === "" || valuacion4y2 === ""){
			alert("HAY CAMPOS VACIOS!");
			console.log("Error: Hay Campos Vacios.");
		}else{
			console.log("OK Variables cargadas!");
			$.ajax({
				type: "post",
				url: "./php/set_new_movil.php",
				data: $("#form-captura-movil").serialize(),
				success: function(respuesta){
					console.log("OK AJAX 1");		
				    if(parseInt(respuesta)===0){ 
						alert("DBERROR!"); 
						console.log("Error: Conexion a la base de datos."); 
					}else{
						if(parseInt(respuesta)===1){ 
							alert("MYSQLIERROR!"); 
							console.log("Error: Consulta mysqli sintaxis."); 
						}else{
							if(parseInt(respuesta)===2){
								$("#txt-descripcion").val("");
								$("#txt-año-lanzamiento").val("");
								$("#txt-so").val("");
								$("#txt-mem-int").val("");
								$("#txt-max-msd").val("");
								$("#txt-ram").val("");
								$("#txt-cam-front").val("");
								$("#txt-cam-post").val("");
								$("#txt-usb").val("");
								$("#txt-dat-ad").val("");
								$("#txt-precio-nuevo").val("");
								$("#txt-precio-usado-valuacion-1").val("");
								$("#txt-prestamo-valuacion-1").val("");
								$("#txt-precio-usado-valuacion-2").val("");
								$("#txt-prestamo-valuacion-2").val("");
								$("#txt-precio-usado-valuacion-3").val("");
								$("#txt-prestamo-valuacion-3").val("");
								$("#txt-precio-usado-valuacion-4").val("");
								$("#txt-prestamo-valuacion-4").val("");
								funCargaCodMovil();	/// Recargar id_movil en #txt-cod-movil
								funCargaDispositivos(); /// Recargar lista de dispositivos
								alert("Movil guardado! Codigo: "+id);
								console.log("Registro guardado!");
							}
						}
					}
				},
				error: function(errorThrown){
					alert(errorThrown);
					console.log("OK AJAX 1");
					console.log("Error: No se encontró algún objeto.");
				}
			});
		}
		console.log("Finalizó evento.");
	});
});

// Cargar id_movil en #txt-cod-movil
	function funCargaCodMovil(){
		$.ajax({
			url: "./php/get_id_movil.php",
			success: function(respuesta){
				$("#txt-cod-movil").val(respuesta);
			},
			error: function(errorThrown){
				alert(errorThrown);
			}
		});
	}

// Cargar lista de dispositivos para evitar el duplicado de registros
	function funCargaDispositivos(){
		$.ajax({
			url: "./php/get_moviles.php",
			success: function(respuesta){
				if(parseInt(respuesta) === 0){
					swal({
						title: "DBERROR",
						text: "Contacte al Administrador de T.I.",
						type: "error",
						showCancelButton: false,
						closeOnConfirm: true,
						showLoaderOnConfirm: false,
					});							
					}else{
						if(parseInt(respuesta) === 1){
							swal({
								title: "MYSQLIERROR",
								text: "Contacte al Administrador de T.I.",
								type: "error",
								showCancelButton: false,
								closeOnConfirm: true,
								showLoaderOnConfirm: false,
							});
						}else{
							$("#contenedor-data-list-dispositivos").html(respuesta);
						}
					}
			},
			error: function(errorThrown){
				alert(errorThrown);
			}
		});
	}