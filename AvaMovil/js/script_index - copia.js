$(document).ready(function(){
	var img="";

	// Carga lista en #txt-dispositivo
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

	// Carga lista en #txt-accesorios
	$.ajax({
		url: "./php/get_accesorios.php",
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
						$("#contenedor-data-list-accesorios").html(respuesta);
					}
				}
		},
		error: function(errorThrown){
			alert(errorThrown);
		}
	});

	// Carga lista en #txt-estado-fisico
	$.ajax({
		url: "./php/get_estado_fisico.php",
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
						$("#contenedor-data-list-estados").html(respuesta);
					}
				}
		},
		error: function(errorThrown){
			alert(errorThrown);
		}
	});

	// Limpiar Input con Lista al hacer click
	$("#txt-dispositivo").click(function(){
		$("#txt-dispositivo").val("");
	});
	$("#txt-accesorios").click(function(){
		$("#txt-accesorios").val("");
	});
	$("#txt-estado-fisico").click(function(){
		$("#txt-estado-fisico").val("");
	});

	// Obtener id's de los campos para consultar la base 
	$("#btn-avaluar").click(function(){
		var dispositivo=$("#txt-dispositivo").val();
		var accesorio=$("#txt-accesorios").val();
		var estado=$("#txt-estado-fisico").val();

		// Validar campos vacios
		if(dispositivo === "" || accesorio === "" || estado === ""){
			swal({
				title: "HAY CAMPOS VACIOS",
				text: "Acomplete los campos para continuar con el avaluo.",
				type: "warning",
				showCancelButton: false,
				closeOnConfirm: true,
				showLoaderOnConfirm: false,
			});
		}else{
			var iddispositivo=$('#data-list-dispositivos').find('option').filter(function(){ 
				return $.trim( $(this).val()) === dispositivo; 
			}).attr('id');
			var idaccesorios=$('#data-list-accesorios').find('option').filter(function(){ 
				return $.trim( $(this).val()) === accesorio; 
			}).attr('id');
			var idestado=$("#data-list-estados").find("option").filter(function(){
				return $.trim( $(this).val()) === estado;
			}).attr("id");
			
			// Validar datos validos
			if(isNaN(iddispositivo) || isNaN(idestado) || isNaN(idaccesorios)){
				swal({
					title: "VALORES INVALIDOS",
					text: "Revise que los valores de los campos coincidan con sus respectivas listas.",
					type: "warning",
					showCancelButton: false,
					closeOnConfirm: true,
					showLoaderOnConfirm: false,
				});
			}else{				
				$.ajax({
					type: "get",
					url: "php/get_valuacion.php?id_movil="+iddispositivo+"&id_estado="+idestado+"&id_accesorios="+idaccesorios,
					success: function(respuesta){
						img="img/"+iddispositivo+".jpg";
						$("#img-movil").attr("src", img);
						$("#contenedor-respuesta").html(respuesta);
						$("#contenedor-background").fadeIn("slow");
					},
					error: function(errorThrown){
						alert(errorThrown);
					}
				});
			}
		}
	});

	$("#btn-consultar").click(function()){
		var dispositivo=$("#txt-dispositivo").val();
		var accesorio=$("#txt-accesorios").val();
		var estado=$("#txt-estado-fisico").val();

		// Validar campos vacios
		if(dispositivo === "" || accesorio === "" || estado === ""){
			swal({
				title: "HAY CAMPOS VACIOS",
				text: "Acomplete los campos para continuar con el avaluo.",
				type: "warning",
				showCancelButton: false,
				closeOnConfirm: true,
				showLoaderOnConfirm: false,
			});
		}else{
			var iddispositivo=$('#data-list-dispositivos').find('option').filter(function(){ 
				return $.trim( $(this).val()) === dispositivo; 
			}).attr('id');
			var idaccesorios=$('#data-list-accesorios').find('option').filter(function(){ 
				return $.trim( $(this).val()) === accesorio; 
			}).attr('id');
			var idestado=$("#data-list-estados").find("option").filter(function(){
				return $.trim( $(this).val()) === estado;
			}).attr("id");
			
			// Validar datos validos
			if(isNaN(iddispositivo) || isNaN(idestado) || isNaN(idaccesorios)){
				swal({
					title: "VALORES INVALIDOS",
					text: "Revise que los valores de los campos coincidan con sus respectivas listas.",
					type: "warning",
					showCancelButton: false,
					closeOnConfirm: true,
					showLoaderOnConfirm: false,
				});
			}else{				
				$.ajax({
					type: "get",
					url: "php/get_valuacion.php?id_movil="+iddispositivo+"&id_estado="+idestado+"&id_accesorios="+idaccesorios,
					success: function(respuesta){
						img="img/"+iddispositivo+".jpg";
						$("#img-movil").attr("src", img);
						$("#contenedor-respuesta").html(respuesta);
						$("#contenedor-background").fadeIn("slow");
					},
					error: function(errorThrown){
						alert(errorThrown);
					}
				});
			}
		}
	});

	$("#btn-aceptar").click(function(){
		$("#contenedor-background").fadeOut("slow");
		delay(2000);
		img="img/bg1.png";
		$("#img-movil").attr("src", img);
		$("#contenedor-respuesta").html("");
	});
});