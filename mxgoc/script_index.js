/**************************************************************************************************************/
/************************************************* Start Main *************************************************/
/**************************************************************************************************************/
$(document).ready(function(){
	$("#txt-buscar").focus();
	var cap;
	limpiar();
	cargarListaNumCliente();
	$("#formEmpeño :input").attr("disabled", "disabled");
	$("#formJAlert :input").css("background", "#FFFF99");
	$("#btn-nuevo").attr("disabled", "disabled");
	$("#btn-agregar").attr("disabled", "disabled");
	
	$(".estado").on("input", function(){
		var est=$(this).val();
		var id=0;
		var msg="<center><b>🤔 No se encontraron operaciones</b></center>";
		if($("#txt-buscar").val()!=""){
			var id=$('#listaClientes').find('option').filter(function(){ 
				return $.trim( $(this).val()) === $("#txt-buscar").val();
			}).attr('id');
			msg="<center><b>😃 Selecciona una operación 🔘</b></center>"
		}
		cargarTablaEmpenos(id, est);
		$("#formEmpeño")[0].reset();
		$("#formEmpeño :input").css("background", "white");
		$("#bgJAlert").hide();
		$("#formJAlert")[0].reset();
		$("input[name=refrendo]").prop("checked", false);
		$("#contenedor-refrendos").html(msg);
		//cargarFechaHoy();
		cargarDatosCliente(id);
		$("#txt-fecha").focus();
	});

	$("#formEmpeño :input").click(function(){
		$("#bgJAlert").hide();
		$("#formJAlert")[0].reset();
		$("input[name=refrendo]").prop("checked", false);
	});

	$("#txt-num-cte").on("input", function(){
		var id=$('#listaNumCliente').find('option').filter(function(){ 
			return $.trim( $(this).val()) === $("#txt-num-cte").val();
		}).attr('id');
		cargarDatosCliente(id);
	});

	$("#txt-fecha").on("change", function(){
		cargarDescripcionFecha($("#txt-fecha").val(), "A");
	});

	$("#btn-nuevo").click(function(){
		limpiar();
		$("#txt-fecha").focus();
	});

	$("#btn-agregar").click(function(){
		$(this).prop("disabled", true);
		var band=validarCamposVacios();
		if(band===""){
			// Realizar consulta
			$.ajax({
				type: "post",
				url: "php/agregar_empeno.php",
				data: $("#formEmpeño").serialize(),
				success: function(respuesta){
					limpiar();
					alert(respuesta);
				}
			});
		}else{
			alert("Acompleta los datos necesarios:\n"+band);
		}
		$(this).prop("disabled", false);
	});

	$("#btn-modificar").click(function(){
		var band=validarCamposVacios();
		$(this).prop("disabled", true);
		if(band===""){
			$.ajax({
				type: "post",
				url: "php/modificar_empeno.php",
				data: $("#formEmpeño").serialize(),
				success: function(respuesta){
					if(respuesta==="✔ Operación modificada! Revisa y/o actualiza los datos de los cargos"){
						limpiar();
					}
					alert(respuesta);
				}
			});
		}else{
			alert("Acompleta los datos necesarios:\n"+band);
		}
		$(this).prop("disabled", false);
	});

	$("#btn-cancelar").click(function(){
		var folio=$("#txt-folio").val();
		$.ajax({
			type: "get",
			url: "php/cancelar_empeno.php?folio="+folio,
			success: function(respuesta){
				if(respuesta==="✔ Operación cancelada!"){
					limpiar();
				}
				alert(respuesta);
			}
		});
	});

	$("#btn-liquidar").click(function(){
		validarAnclaje();
	});

	$("#btn-reactivar").click(function(){
		var folio=$("#txt-folio").val();
		$.ajax({
			type: "get",
			url: "php/reactivar_empeno.php?folio="+folio,
			success: function(respuesta){
				if(respuesta==="✔ Operación reactivada!"){
					limpiar();
				}
				alert(respuesta);
			}
		});
	});

	$("#btn-reempenar").click(function(){
		cargarFechaHoy();
		setTimeout("reempenarEmpeno()", 500);
	});

	$("input[type=checkbox]").click(function(){
		if($(this).val()==="Checked"){
			$(this).val("");
		}else{
			$(this).val("Checked");
		}
	});

	$("#formJAlert :input[type=number]").on("input", function(){
		var ref=parseInt($("#txt-int-pag").val()) || 0;
		var abo=parseInt($("#txt-abo-pag").val()) || 0;
		var rec=parseInt($("#txt-rec-pag").val()) || 0;
		var salcap=parseInt($("#txt-sal-cap").val());
		var nuesalcap=salcap-abo;
		var totpag=ref+abo+rec;
		$("#txt-tot-pag").val(totpag);
		$("#txt-nue-sal-cap").val(nuesalcap);
	});

	$("input[name=estadoRefrendo]").click(function(){
		//$(this).val()==="Cargado" || 
		if($(this).val()==="Vencido"){ 
			$("#txt-fec-pag").val("");
			cargarDescripcionFecha("", "C");
		}else{
			if($("#txt-fec-pag").val()===""){
				$.ajax({
					url: "php/cargar_fecha_hoy.php",
					success: function(respuesta){
						$("#txt-fec-pag").val(respuesta);
						cargarDescripcionFecha(respuesta, "C");
					}
				});
			}
		}
	});

	$("#btn-modificar-refrendo").click(function(){
		$.ajax({
			type: "post",
			url: "php/modificar_refrendo.php",
			data: $("#formJAlert").serialize(),
			success: function(respuesta){
				alert(respuesta);
				var folemp=$("#txt-folio").val();
				cargarTablaRefrendo(folemp);
				$("#bgJAlert").hide();
				$("#formJAlert")[0].reset();
				$("input[name=refrendo]").prop("checked", false);
				$("#bgJAlert").hide();
				$("#formJAlert")[0].reset();
				$("input[name=refrendo]").prop("checked", false);
			}
		});
	});

	$("#btn-cancelar-refrendo").click(function(){
		$("#bgJAlert").hide();
		$("#formJAlert")[0].reset();
		$("input[name=refrendo]").prop("checked", false);
	});

	$("#btn-generar-refrendo").click(function(){
		var folemp=$("#txt-folio").val();
		$.ajax({
			type: "get",
			url: "php/generar_siguiente_refrendo.php?folemp="+folemp,
			success: function(respuesta){
				alert(respuesta);
				var folemp=$("#txt-folio").val();
				$("#bgJAlert").hide();
				$("#formJAlert")[0].reset();
				$("input[name=refrendo]").prop("checked", false);
				cargarTablaRefrendo(folemp);
			}
		});
	});

	$("#btn-recapitalizar").click(function(){
		recapitalizarEmpeno();
	});

	$("input[type=checkbox]").on("input", function(){
		if($(this).prop("checked")){
			$(this).val("Checked");
		}
	});
});
/**************************************************************************************************************/
/************************************************** End Main **************************************************/
/**************************************************************************************************************/

/******************************* Configuraciones *********************************/
// Funciones auto ejecutables
(function(){
	// Limpiar lista clientes
	$("#listaClientes").html("");

	// Al presionar Enter - Cargar #listaClientes
	/*
	$("#txt-buscar").keyup(function(e) {
		if(e.which == 13) {
			//alert('Has presionado ENTER');
			var id=0;
		    if($("#txt-buscar").val()===""){
				$("#txt-buscar").focus();
				alert("⚠ Escribe nombre del titular o cotitular o número de cliente.");
			}else{
				var tipo="nombre";
				if($.isNumeric($("#txt-buscar").val())){
					tipo="id";
				}
				cargarListaClientes($("#txt-buscar").val(), tipo);
				filtrarListaClientes();
				$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>😃 Presiona el picker 🔻 y selecciona cliente.</b></center></td></tr>");		
			}
		}
	});
	*/

	// Al seleccionar cliente - Cargar datos del cliente
	$("#txt-buscar").on("input", function(){
		//alert('Has presionado ENTER');
		if($("#txt-buscar").val()===""){
		  	$("#listaClientes").html("");
		}else{
			var tipo="nombre";
			if($.isNumeric($("#txt-buscar").val())){
				tipo="id";
			}
			$("#txt-buscar").focus();
			buscar(tipo);
		}

		function buscar(tipo){
			cargarListaClientes($("#txt-buscar").val(), tipo);
			filtrarListaClientes();	
			$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>😃 Presiona el picker 🔻 y selecciona cliente.</b></center></td></tr>");
		}
		/*
		$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>🤔 Realice una búsqueda de cliente</b></center></td></tr>");
		if($("#txt-buscar").val()===""){
			$("#listaClientes").html("");
		}else{
			filtrarListaClientes();
			if($("#listaClientes").html()!=""){
				$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>😃 Presiona el picker 🔻 y selecciona cliente, o realice otra busqueda.</b></center></td></tr>");	
			}
		}*/
	});


	// Al limpiar el campo de búsqueda - Limpiar #listaClientes
	$("#txt-buscar").on('search', function () {
	    $("#listaClientes").html("");
	    $("#btn-nuevo").attr("disabled", "disabled");
		$("#btn-agregar").attr("disabled", "disabled");
		$("#btn-modificar").attr("disabled", "disabled");
		$("#btn-cancelar").attr("disabled", "disabled");
		$("#btn-liquidar").attr("disabled", "disabled");
		$("#btn-recapitalizar").attr("disabled", "disabled");
		$("#btn-reactivar").attr("disabled", "disabled");
		$("#btn-reempenar").attr("disabled" ,"disabled");
		$("#btn-generar-refrendo").attr("disabled" ,"disabled");
		$("#formEmpeño")[0].reset();
		//cargarFechaHoy();
		$("#formEmpeño :input").attr("disabled", "disabled");
		$("#formEmpeño :input").css("background", "white");
		$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>🤔 Realice una búsqueda de cliente</b></center></td></tr>");
		$("#contenedor-refrendos").html("<tr colspan='8'><td><center><b>🤔 No se encontraron operaciones</b></center></td></tr>");
	});

	// Activa los tooltips - Agregar la etiqueta tittle="Texto del tooltip" al elemento html
	$(document).tooltip();
})();

function filtrarListaClientes(){
	var est=$(".estado").val();
	var id=$('#listaClientes').find('option').filter(function(){ 
		return $.trim( $(this).val()) === $("#txt-buscar").val();
	}).attr('id');
	if(id!=undefined){
		cargarTablaEmpenos(id, est);
		cargarDatosCliente(id);	
		$("#txt-nom-cot").focus();
		$("#btn-nuevo").removeAttr("disabled");
		$("#btn-agregar").removeAttr("disabled");
		$("#btn-modificar").attr("disabled", "disabled");
		$("#btn-cancelar").attr("disabled", "disabled");
		$("#btn-liquidar").attr("disabled", "disabled");
		$("#btn-recapitalizar").attr("disabled", "disabled");
		$("#btn-reactivar").attr("disabled", "disabled");
		$("#btn-reempenar").attr("disabled" ,"disabled");
		$("#btn-generar-refrendo").attr("disabled" ,"disabled");
		$("#formEmpeño :input").removeAttr("disabled");
		$("#formEmpeño :input").css("background", "white");
		$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>😃 Realice una búsqueda de cliente</b></center></td></tr>");
		$("#contenedor-refrendos").html("<tr colspan='8'><td><center><b>😃 Selecciona una operación 🔘</b></center></td></tr>");	
	}else{
		$("#formEmpeño")[0].reset();
		//cargarFechaHoy();
		$("#btn-nuevo").attr("disabled", "disabled");
		$("#btn-agregar").attr("disabled", "disabled");
		$("#btn-modificar").attr("disabled", "disabled");
		$("#btn-cancelar").attr("disabled", "disabled");
		$("#btn-liquidar").attr("disabled", "disabled");
		$("#btn-recapitalizar").attr("disabled", "disabled");
		$("#btn-reactivar").attr("disabled", "disabled");
		$("#btn-reempenar").attr("disabled" ,"disabled");
		$("#btn-generar-refrendo").attr("disabled" ,"disabled");
		$("#formEmpeño :input").attr("disabled", "disabled");
		$("#formEmpeño :input").css("background", "white");
		$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>🤔 Realice una búsqueda de cliente</b></center></td></tr>");
		$("#contenedor-refrendos").html("<tr colspan='8'><td><center><b>🤔 No se encontraron operaciones</b></center></td></tr>");
	}
}

function limpiar(){ // Reiniciar ajustes
	$("#bgJAlert").hide();
	$("#btn-nuevo").removeAttr("disabled");
	$("#btn-agregar").removeAttr("disabled");
	$("#btn-modificar").attr("disabled", "disabled");
	$("#btn-cancelar").attr("disabled", "disabled");
	$("#btn-liquidar").attr("disabled", "disabled");
	$("#btn-recapitalizar").attr("disabled", "disabled");
	$("#btn-reactivar").attr("disabled", "disabled");
	$("#btn-reempenar").attr("disabled" ,"disabled");
	$("#btn-generar-refrendo").attr("disabled" ,"disabled");

	$("#formEmpeño")[0].reset();
	$("#formEmpeño :input").css("background", "white");
	$("#contenedor-refrendos").html("<tr><td><center><b>🤔 No se encontraron operaciones</b></center></td></tr>");
	$("input[type=checkbox]").prop("checked", false);
	$("input[type=checkbox]").val("");

	//cargarFechaHoy();

	$(".estado[value=Todos]").prop("selected", true);
	var est=$(".estado :selected").val();
	var id=0;
	if($("#txt-buscar").val()===""){
		id=0;
	}else{
		var id=$('#listaClientes').find('option').filter(function(){ 
			return $.trim( $(this).val()) === $("#txt-buscar").val();
		}).attr('id');
	}
	cargarTablaEmpenos(id, est);
	cargarDatosCliente(id);
}

function activarCampos(){
	$("#formEmpeño :input").removeAttr("disabled");
	$("#txt-nom-tit").attr("disabled", "disabled");
	$("#txt-telefono").attr("disabled", "disabled");
	$("#txt-domicilio").attr("disabled", "disabled");
}

function validarCamposVacios(){
	var band = "";
	var i = 0;
	if ($("#txt-fecha").val()==="") { i=i+1; band=band+i+") Fecha\n"; }
	if ($("#txt-num-cte").val()==="" || $("#txt-nom-tit").val()==="") { i=i+1; band=band+i+") Cliente\n"; }
	if ($("#txt-capital").val()==="") { i=i+1; band=band+i+") Capital\n"; }
	var id=$('#listModOpe').find('option').filter(function(){ 
		return $.trim( $(this).val()) === $("#txt-tasa-int").val();
	}).attr('id');
	if(id===undefined){
		i=i+1; 
		band=band+i+") Tasa de interés (de la lista)\n";
	}
	if ($("#txt-interes").val()==="") { i=i+1; band=band+i+") Interés\n"; }
	if ($("#txt-des-gen").val()==="") { i=i+1; band=band+i+") Descripción general\n"; }
	if ($("#txt-car-pre").val()==="") { i=i+1; band=band+i+") Caracteristicas de la prenda\n"; }
	return band;
}

/*************************** Consultas BD ***************************/
function cargarFechaHoy(){ // Carga en input la fecha de hoy
	$.ajax({
		url: "php/cargar_fecha_hoy.php",
		success: function(respuesta){
			$("#txt-fecha").val(respuesta);
		}
	});
}

function cargarListaClientes(cte, tipo){
	$.ajax({
		type: "get",
		url: "php/cargar_lista_clientes.php?cte="+cte+"&tipo="+tipo,
		success: function(respuesta){
			if(respuesta==="invalid"){
				$("#listaClientes").html("");
				$("#contenedor-empenos").html("<tr colspan='8'><td><center><b>🤔 Vuelva a realizar la búsqueda.</b></center></td></tr>");
			}else{
				$("#listaClientes").html(respuesta);
			}
		}
	});
}

function cargarListaNumCliente(){
	$.ajax({
		url: "php/cargar_lista_num_cliente.php",
		success: function(respuesta){
			$("#listaNumCliente").html(respuesta);
		}
	});
}

function cargarDatosCliente(id){
	$.ajax({
		type: "get",
		url: "php/cargar_datos_cliente.php?id="+id,
		success: function(respuesta){
			var r = respuesta.split("/-/");
			$("#txt-id-cte").val(r[0]);
			$("#txt-num-cte").val(r[1]);
			$("#txt-nom-tit").val(r[2]);
			$("#txt-telefono").val(r[3]);
			$("#txt-domicilio").val(r[4]);
		}
	});
}

function cargarDatosEmpeno(id){
	$.ajax({
		type: "get",
		url: "php/cargar_datos_empeno.php?id="+id,
		success: function(respuesta){
			var r = respuesta.split("/-/");
			$("#txt-folio").val(r[0]);
			$("#txt-fecha").val(r[1]);
			$("#txt-nom-cot").val(r[2]);
			$("#txt-capital").val(r[3]);
			$("#txt-tasa-int").val(r[4]);
			$("#txt-interes").val(r[5]);
			$("#txt-des-gen").val(r[6]);
			$("#txt-car-pre").val(r[7]);
			$("#txt-anclaje").val(r[8]);
			$("#txt-ent-inm").val(r[9]);
			$("#txt-validado").val(r[10]);
			
			if(r[8]==="Checked"){ $("#txt-anclaje").prop("checked", true); }else{ $("#txt-anclaje").prop("checked", false); }
			if(r[9]==="Checked"){ $("#txt-ent-inm").prop("checked", true); }else{ $("#txt-ent-inm").prop("checked", false); }
			if(r[10]==="Checked"){ $("#txt-validado").prop("checked", true); }else{ $("#txt-validado").prop("checked", false); }
			
			var color="";
			if(r[11]==="Vigente"){ 
				color="#FFFF99"; 
				$("#btn-agregar").attr("disabled", "disabled");
				$("#btn-modificar").removeAttr("disabled");
				$("#btn-cancelar").removeAttr("disabled");
				$("#btn-liquidar").removeAttr("disabled");
				$("#btn-recapitalizar").removeAttr("disabled");
				$("#btn-reactivar").attr("disabled", "disabled");
				$("#btn-reempenar").attr("disabled", "disabled");
				$("#btn-generar-refrendo").removeAttr("disabled");
				$("#btn-modificar-refrendo").removeAttr("disabled");

				$("#formEmpeño :input").removeAttr("disabled");
				$("#formJAlert :input").removeAttr("disabled");
			}
			if(r[11]==="Cancelado"){ 
				color="plum"; 
				$("#btn-agregar").attr("disabled", "disabled");
				$("#btn-modificar").attr("disabled", "disabled");
				$("#btn-cancelar").attr("disabled", "disabled");
				$("#btn-liquidar").attr("disabled", "disabled");
				$("#btn-recapitalizar").attr("disabled", "disabled");
				$("#btn-reactivar").removeAttr("disabled");
				$("#btn-reempenar").attr("disabled", "disabled");
				$("#btn-generar-refrendo").attr("disabled", "disabled");
				$("#btn-modificar-refrendo").attr("disabled", "disabled");

				$("#formEmpeño :input").attr("disabled", "disabled");
			}
			if(r[11]==="Liquidado"){ 
				color="lightcoral";
				$("#btn-agregar").attr("disabled", "disabled");
				$("#btn-modificar").attr("disabled", "disabled");
				$("#btn-cancelar").attr("disabled", "disabled");
				$("#btn-liquidar").attr("disabled", "disabled");
				$("#btn-recapitalizar").attr("disabled", "disabled");
				$("#btn-reactivar").removeAttr("disabled");
				$("#btn-reempenar").removeAttr("disabled");
				$("#btn-generar-refrendo").attr("disabled", "disabled");
				$("#btn-modificar-refrendo").attr("disabled", "disabled");

				$("#formEmpeño :input").attr("disabled", "disabled");
			}
			$("#txt-obs-ope").val(r[12]);

			$("#formEmpeño :input").css("background", color);

			cargarDescripcionFecha($("#txt-fecha").val(), "A");
		}
	});
}

function cargarTablaRefrendo(folio){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_refrendos.php?folio="+folio,
		success: function(respuesta){
			$("#contenedor-refrendos").html(respuesta);

			$("input[name=refrendo]").click(function(){
				$("#bgJAlert").show();
				var folref=$(this).val();
				var folempref=$(this).attr("class", "class");
				$("#txt-fol-pag").val(folref);
				$.ajax({
					type: "get",
					url: "php/cargar_datos_refrendo.php?folref="+folref+"&folemp="+$("#txt-folio").val(),
					success: function(respuesta){
						var r = respuesta.split("/-/");
						var totpag=parseInt(r[2])+parseInt(r[3])+parseInt(r[4]);
						var nsc=r[6]-r[3];
						$("#txt-fec-ref").val(r[0]);
						cargarDescripcionFecha(r[0], "B");
						$("#txt-fec-pag").val(r[1]);
						cargarDescripcionFecha(r[1], "C");
						$("#txt-int-pag").val(r[2]);
						$("#txt-abo-pag").val(r[3]);
						$("#txt-rec-pag").val(r[4]);
						$("#txt-tot-pag").val(totpag);
						$("#txt-sal-cap").val(r[6]);
						$("#txt-nue-sal-cap").val(nsc);
						/*
						if(r[5]==="Cargado"){ 
							$("input[name=estadoRefrendo][value=Cargado]").prop("checked", true); 
							$("#txt-fec-pag").val("");
							cargarDescripcionFecha("", "C");
						}*/
						if(r[5]==="Vencido"){ 
							$("input[name=estadoRefrendo][value=Vencido]").prop("checked", true);
							$("#txt-fec-pag").val("");
							cargarDescripcionFecha("", "C");
						}
						if(r[5]==="Pagado"){ 
							$("input[name=estadoRefrendo][value=Pagado]").prop("checked", true);
							if($("#txt-fec-pag").val()===""){
								$.ajax({
									url: "php/cargar_fecha_hoy.php",
									success: function(respuesta){
										$("#txt-fec-pag").val(respuesta);
										cargarDescripcionFecha(respuesta, "C");
									}
								});
							}							
						}
						$("#txt-obs-ref").val(r[7]);
						$("#txt-fec-ref").on("change", function(){
							cargarDescripcionFecha($("#txt-fec-ref").val(), "B");
						});

						$("#txt-fec-pag").on("change", function(){
							cargarDescripcionFecha($("#txt-fec-pag").val(), "C");
						});				
					}
				});
			});
		}
	});
}

function cargarTablaEmpenos(id, est){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_empenos.php?id="+id+"&est="+est,
		success: function(respuesta){
			$("#contenedor-empenos").html(respuesta);

			$("input[name=empeno]").click(function(){
				activarCampos();
				$("#btn-generar-refrendo").removeAttr("disabled");
				$("#btn-recapitalizar").removeAttr("disabled");
				var cliente=$(this).attr("class");
				var empeno=$(this).val();
				cargarDatosCliente(cliente);
				cargarDatosEmpeno(empeno);
				cargarTablaRefrendo(empeno);
				$("#bgJAlert").hide();
				$("#formJAlert")[0].reset();
				$("input[name=refrendo]").prop("checked", false);
			});
		}
	});
}

function reempenarEmpeno(){
	$("#formEmpeño :input").prop("disabled", false);
	$.ajax({
		type: "post",
		url: "php/reempenar_empeno.php",
		data: $("#formEmpeño").serialize(),
		success: function(respuesta){
			limpiar();
			alert(respuesta);
		}
	});
}

function validarAnclaje(){
	var idcte=$("#txt-id-cte").val();
	var folio=$("#txt-folio").val();
	$.ajax({
		type: "get",
		url: "php/validar_anclaje.php?idcte="+idcte+"&folio="+folio,
		success: function(respuesta){
			if(respuesta===""){
				liquidarEmpeno();
			}else{
				r = confirm("Los siguientes empeños vigentes tienen ANCLAJE activado:\n"+respuesta+"Si esta CONCIENTE de esto y desea OMITIR el anclaje presione en aceptar");
				if(r==true){
					liquidarEmpeno();
				}
			}		
		}
	});
}

function liquidarEmpeno(){
	var folio=$("#txt-folio").val();
	$.ajax({
		type: "get",
		url: "php/liquidar_empeno.php?folio="+folio,
		success: function(respuesta){
			limpiar();
			alert(respuesta);
		}
	});
}

function recapitalizarEmpeno(){
	$.ajax({
		type: "post",
		url: "php/recapitalizar_empeno.php",
		data: $("#formEmpeño").serialize(),
		success: function(respuesta){
			limpiar();
			alert(respuesta);
		}
	});
}

function cargarDescripcionFecha(fecha, letra){
	$.ajax({
		type: "get",
		url: "php/cargar_descripcion_fecha.php?fecha="+fecha,
		success: function(respuesta){
			if(letra==="A"){
				$("#txt-des-fec").val(respuesta);
			}
			if(letra==="B"){
				$("#txt-des-fec-ven").val(respuesta);
			}
			if(letra==="C"){
				if(respuesta==="0//-2000"){
					$("#txt-fec-pag").val("");
					$("#txt-des-fec-pag").val("");
				}else{
					$("#txt-des-fec-pag").val(respuesta);
				}
			}
		}
	});
}