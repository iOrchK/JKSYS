$(document).ready(function(){
	cargarCantidadClientes()
	cargarNuevoNumeroCliente();
	cargarFechaHoy();
	cargarListaClientes();
	cargarListaNumerosCliente();
	cargarListaClasificaciones();
	cargarListaIdentificaciones();
	cargarTablaClientes("No client");
});

	// Funciones autoejecutables
	(function(){
		// Al presionar Enter - Cargar #listaClientes
		$("#txt-buscar").keyup(function(e) {
		    if(e.which == 13) {
		        //alert('Has presionado ENTER');
		        if($("#txt-buscar").val()===""){
					$("#txt-buscar").prop("readonly", true);
				}
				$("#contenedor-clientes").html("<tr><td colspan='4'><center><img src='img/load.gif' width='20' height='20' style='background:none'><b> Cargando clientes</b></center></td></tr>");
				cargarTablaClientes($("#txt-buscar").val());
				$("#txt-buscar").prop("readonly", false);
				$("#txt-buscar").focus();
		    }
		});

		// Enfocar en campo de búsqueda
		$("#txt-buscar").focus();

		// Click en botón nuevo - limpiar formulario
		$("#btn-nuevo").click(function(){
			limpiar();
			$("#txt-nom-tit").focus();
		});

		//Click en botón agregar - Agregar cliente
		$("#btn-agregar").click(function(){
			$("#btn-agregar").removeAttr("disabled");
			agregarCliente();
		});

		// Click en botón modificar - Actualizar cliente
		$("#btn-modificar").click(function(){
			$("#btn-modificar").attr("disabled", "disabled");
			modificarCliente();
		});

		// Click en botón eliminar - eliminar cliente
		$("#btn-eliminar").click(function(){
			eliminarCliente();
		});

		// Click en botón reactivar - Reactivar cliente
		$("#btn-reactivar").click(function(){
			reactivarCliente();
		});

		// Click en campo clasificación - Limpiar campo clasificación
		$("#txt-cla-cli").click(function(){
			$("#txt-cla-cli").val("");
		});

		// Al ingresar en campo clasificación - Mostrar imagen
		$("#txt-cla-cli").on("input", function(){
			var id=$('#listClasificaciones').find('option').filter(function(){ 
				return $.trim( $(this).val()) === $("#txt-cla-cli").val();
			}).attr('id');
			if(id!=undefined){
				$("#imgClass").attr("src", "img/"+$("#txt-cla-cli").val()+".png");
			}
		});

		// Activa todos los tooltips - Agregar la etiqueta tittle="Texto del tooltip" al elemento html
		$(document).tooltip();
	})();

function limpiar(){
	$("#formCliente")[0].reset();
	$("#formCliente :input").css("background", "white");
	$("#imgClass").attr("src", "img/Nuevo.png");
	$("#txtClass").text("Cliente clasificado: Nuevo");
	cargarCantidadClientes()
	cargarNuevoNumeroCliente();
	cargarFechaHoy();
	cargarTablaClientes("No client");
	cargarListaClientes();
	cargarListaNumerosCliente();
	cargarListaIdentificaciones();
	$("#txt-buscar").val("");
	$("#btn-agregar").removeAttr("disabled");
	$("#btn-modificar").attr("disabled", "disabled");
	$("#btn-eliminar").attr("disabled", "disabled");
	$("#btn-reactivar").attr("disabled", "disabled");
}

function onClickCliente(){
	$("input[name=cliente]").click(function(){
		cargarDatosCliente($(this).val());
	});
}

/************* CONSULTAS ***************/

function cargarCantidadClientes(){
	$.ajax({
		url: "php/cargar_cantidad_clientes.php",
		success: function(respuesta){
			$("#txt-can-cli").val(respuesta);
		}
	});
}

function cargarNuevoNumeroCliente(){
	$.ajax({
		url: "php/cargar_nuevo_num_cte.php",
		success: function(respuesta){
			$("#txt-num-cte").val(respuesta);
		}
	});
}

function cargarFechaHoy(){
	$.ajax({
		url: "../mxgoc/php/cargar_fecha_hoy.php",
		success: function(respuesta){
			$("#txt-fec-reg").val(respuesta);
			$("#txt-fec-reg").prop("max", respuesta);
		}
	});
}

function cargarListaClientes(){
	$.ajax({
		url: "php/cargar_lista_clientes.php",
		success: function(respuesta){
			$("#listNomTit").html(respuesta);
		}
	});
}

function cargarListaNumerosCliente(){
	$.ajax({
		url: "php/cargar_lista_num_cte.php",
		success: function(respuesta){
			$("#listNumCte").html(respuesta);
		}
	});
}

function cargarListaClasificaciones(){
	$.ajax({
		url: "php/cargar_lista_clasificaciones.php",
		success: function(respuesta){
			$("#listClasificaciones").html(respuesta);
		}
	});
}

function cargarListaIdentificaciones(){
	$.ajax({
		url: "php/cargar_lista_identificaciones.php",
		success: function(respuesta){
			$("#listIdentificaciones").html(respuesta);
		}
	});
}

function cargarTablaClientes(client){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_clientes.php?busqueda="+client,
		success: function(respuesta){
			$("#contenedor-clientes").html(respuesta);
			onClickCliente();
		}
	});
}

function cargarDatosCliente(idcte){
	$.ajax({
		type: "get",
		url: "php/cargar_datos_cliente.php?idcte="+idcte,
		success: function(respuesta){
			var exp = respuesta.split("/--/");
			$("#txt-fol-cte").val(exp[0]);
			$("#txt-num-cte").val(exp[1]);
			$("#txt-fec-reg").val(exp[2]);
			$("#txt-nom-tit").val(exp[3]);
			$("#txt-ide-tit").val(exp[7]);
			$("#txt-cla-ide").val(exp[8]);
			$("#txt-nom-cot").val(exp[9]);
			$("#txt-tels").val(exp[4]);
			$("#txt-doms").val(exp[5]);
			$("#txt-emails").val(exp[6]);
			$("#txt-cla-cli").val(exp[11]);
			$("#txt-ano-adi").val(exp[10]);
			$("#imgClass").attr("src", "img/"+exp[11]+".png");
			$("#txtClass").text("Cliente clasificado: "+exp[11]);

			if(exp[12]==="Alta"){
				$("#formCliente :input").css("background", "#FFFF99");
				$("#btn-reactivar").attr("disabled", "disabled");
				$("#btn-agregar").attr("disabled", "disabled");
				$("#btn-modificar").removeAttr("disabled");
				$("#btn-eliminar").removeAttr("disabled");
				$("#formCliente :input").prop("disabled", false);
			}else{
				$("#formCliente :input").css("background", "lightcoral");
				$("#btn-reactivar").removeAttr("disabled");
				$("#btn-agregar").attr("disabled", "disabled");
				$("#btn-modificar").attr("disabled", "disabled");
				$("#btn-eliminar").attr("disabled", "disabled");
				$("#formCliente :input").prop("disabled", true);
			}

			
		}
	});
}

function agregarCliente(){
	if($("#txt-num-cte").val()===""){
		alert("⚠️ Debe ingresar un número de cliente. Verifique que NO aparezca en la lista.");
		$("#txt-num-cte").focus();
		$("#btn-agregar").removeAttr("disabled");
	}else{
		var id=$('#listNumCte').find('option').filter(function(){ 
			return $.trim( $(this).val()) === $("#txt-num-cte").val();
		}).attr('id');
		if(id===undefined){
			if($("#txt-fec-reg").val()===""){
				alert("⚠️ La fecha no existe o no ha ingresado una fecha");
				$("#txt-fec-reg").focus();
				$("#btn-agregar").removeAttr("disabled");
			}else{
				if($("#txt-nom-tit").val()===""){
					alert("⚠️ Debe escribir el nombre del titular");
					$("#txt-nom-tit").focus();
					$("#btn-agregar").removeAttr("disabled");
				}else{
					id=$('#listNomTit').find('option').filter(function(){ 
						return $.trim( $(this).val()) === $("#txt-nom-tit").val();
					}).attr('id');
					var claide=$('#listNomTit').find('option').filter(function(){ 
						return $.trim( $(this).text()) === "#"+id+" IDE:"+$("#txt-cla-ide").val();
					}).attr('id');
					if(claide===undefined || (id===undefined && claide===undefined)){
						if($("#txt-ide-tit").val()===""){
							alert("⚠️ Debe seleccionar una opción de identificación de la lista");
							$("#txt-ide-tit").focus();
							$("#btn-agregar").removeAttr("disabled");
						}else{
							id=$('#listIdentificaciones').find('option').filter(function(){ 
								return $.trim( $(this).val()) === $("#txt-ide-tit").val();
							}).attr('id');	
							if(id===undefined){
								alert("⚠️ Esta opción de identificiación ("+$("#txt-ide-tit").val()+") no está en la lista");
								$("#txt-ide-tit").focus();
								$("#btn-agregar").removeAttr("disabled");
							}else{
								if($("#txt-cla-cli").val()===""){
									alert("⚠️ Debe seleccionar una opción de clasificación");
									$("#txt-cla-cli").focus();
									$("#btn-agregar").removeAttr("disabled");
								}else{
									id=$('#listClasificaciones').find('option').filter(function(){ 
										return $.trim( $(this).val()) === $("#txt-cla-cli").val();
									}).attr('id');
									if(id===undefined){
										alert("⚠️ Esta clasificación ("+$("#txt-cla-cli").val()+") no está en la lista");
										$("#txt-cla-cli").focus();
										$("#btn-agregar").removeAttr("disabled");
									}else{
										$.ajax({
											type: "post",
											url: "php/agregar_cliente.php",
											data: $("#formCliente").serialize(),
											success: function(respuesta){
												if(respuesta==="✔ Cliente agregado!"){
													limpiar();
												}
												alert(respuesta);
											}
										});
									}
								}
							}
						}
					}else{
						alert("⚠️ Este cliente ("+$("#txt-nom-tit").val()+") ya existe");
						$("#btn-agregar").removeAttr("disabled");
					}
				}
			}
		}else{
			alert("⚠️ Este número de cliente ("+$("#txt-num-cte").val()+") ya existe");
			$("#btn-agregar").removeAttr("disabled");
		}
	}
}

function modificarCliente(){
	if($("#txt-num-cte").val()===""){
		alert("⚠️ Debe ingresar un número de cliente.");
		$("#txt-num-cte").focus();
		$("#btn-modificar").removeAttr("disabled");
	}else{
		if($("#txt-fec-reg").val()===""){
			alert("⚠️ La fecha no existe o no ha ingresado una fecha");
			$("#txt-fec-reg").focus();
			$("#btn-modificar").removeAttr("disabled");
		}else{
			if($("#txt-nom-tit").val()===""){
				alert("⚠️ Debe escribir el nombre del titular");
				$("#txt-nom-tit").focus();
				$("#btn-modificar").removeAttr("disabled");
			}else{
				if($("#txt-ide-tit").val()===""){
					alert("⚠️ Debe seleccionar una opción de identificación de la lista");
					$("#txt-ide-tit").focus();
					$("#btn-modificar").removeAttr("disabled");
				}else{
					id=$('#listIdentificaciones').find('option').filter(function(){ 
						return $.trim( $(this).val()) === $("#txt-ide-tit").val();
					}).attr('id');	
					if(id===undefined){
						alert("⚠️ Esta opción de identificiación ("+$("#txt-ide-tit").val()+") no está en la lista");
						$("#txt-ide-tit").focus();
						$("#btn-modificar").removeAttr("disabled");
					}else{
						if($("#txt-cla-cli").val()===""){
							alert("⚠️ Debe seleccionar una opción de clasificación");
							$("#txt-cla-cli").focus();
							$("#btn-modificar").removeAttr("disabled");
						}else{
							id=$('#listClasificaciones').find('option').filter(function(){ 
								return $.trim( $(this).val()) === $("#txt-cla-cli").val();
							}).attr('id');
							if(id===undefined){
								alert("⚠️ Esta clasificación ("+$("#txt-cla-cli").val()+") no está en la lista");
								$("#txt-cla-cli").focus();
								$("#btn-modificar").removeAttr("disabled");
							}else{
								$.ajax({
									type: "post",
									url: "php/modificar_cliente.php",
									data: $("#formCliente").serialize(),
									success: function(respuesta){
										if(respuesta==="✔ Cliente modificado!"){
											limpiar();
										}
										alert(respuesta);
									}
								});
							}
						}
					}
				}
			}
		}
	}
}

function eliminarCliente(){
	$.ajax({
		type: "get",
		url: "php/eliminar_cliente.php?txt-fol-cte="+$("#txt-fol-cte").val(),
		success: function(respuesta){
			if(respuesta==="✔ Cliente eliminado!"){
				limpiar();
			}
			alert(respuesta);
		}
	});
}

function reactivarCliente(){
	$.ajax({
		type: "get",
		url: "php/reactivar_cliente.php?txt-fol-cte="+$("#txt-fol-cte").val(),
		success: function(respuesta){
			if(respuesta==="✔ Cliente reactivado!"){
				limpiar();
			}
			alert(respuesta);
		}
	});
}