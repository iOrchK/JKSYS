$(document).ready(function(){
	cargarFechaHoy();
	cargarFolio();
	cargarCategorias();

	onClickNuevo();
	onClickAgregar();
	onClickModificar();
	onClickCancelar();
	onClickReactivar();
	onClickRegistrarCategoria();
	onClickCategorias();
	onInputFecha();
	onInputFechaEgreso();
	onInputCategorias();
	onFocusOutMonto();
});

function limpiar(){
	$("#formEgreso")[0].reset();
	$("#btn-agregar").removeAttr("disabled");
	$("#btn-modificar").attr("disabled", "disabled");
	$("#btn-cancelar").attr("disabled", "disabled");
	$("#btn-reactivar").attr("disabled", "disabled");
	$("#btn-reg-cat").attr("disabled", "disabled");
	$("#txt-fec-egr").attr("readonly", "readonly");
	$("#txt-fec-egr").attr("style", "filter:brightness(0.8)");
	$("input[name=egreso]").prop("checked", false);
	$("#formEgreso :input").css("background", "white");
	$("#formEgreso :input").removeAttr("disabled");
	cargarFolio();
	cargarFechaHoy();
}

function onClickNuevo(){
	$("#btn-nuevo").click(function(){
		limpiar();
	});
}

function onClickAgregar(){
	$("#btn-agregar").click(function(){
		if($("#txt-categoria").val()===""){ 
			alert("⚠️ Selecciona una categoría."); 
			$("#txt-categoria").focus(); 
		}else{
			var id=$('#listCategoria').find('option').filter(function(){ 
				return $.trim( $(this).val()) === $("#txt-categoria").val();
			}).attr('id');
			if(id===undefined){
				alert("⚠️ Esta categoría no existe. Si está seguro de que NO está registrada, presione en el botón Registrar Categoría.");
				$("#txt-categoria").focus();
			}else{
				if($("#txt-monto").val()==="" || parseInt($("#txt-monto").val())===0){
					alert("⚠️ El monto ingresado es inválido. Debe ser mayor a 0.");
					$("#txt-monto").focus();
				}else{
					if($("#txt-descripcion").val()===""){
						alert("⚠️ Debe ingresar una descripción.");
						$("#txt-descripcion").focus();
					}else{
						agregarEgreso();
						limpiar();
					}
				}
			}
		}
	});
}

function onClickModificar(){
	$("#btn-modificar").click(function(){
		if($("#txt-categoria").val()===""){ 
			alert("⚠️ Selecciona una categoría."); 
			$("#txt-categoria").focus(); 
		}else{
			var id=$('#listCategoria').find('option').filter(function(){ 
				return $.trim( $(this).val()) === $("#txt-categoria").val();
			}).attr('id');
			if(id===undefined){
				alert("⚠️ Esta categoría no existe. Si está seguro de que NO está registrada, presione en el botón Registrar Categoría.");
				$("#txt-categoria").focus();
			}else{
				if($("#txt-monto").val()==="" || parseInt($("#txt-monto").val())===0){
					alert("⚠️ El monto ingresado es inválido. Debe ser mayor a 0.");
					$("#txt-monto").focus();
				}else{
					if($("#txt-descripcion").val()===""){
						alert("⚠️ Debe ingresar una descripción.");
						$("#txt-descripcion").focus();
					}else{
						modificarEgreso();
					}
				}
			}
		}
	});
}

function onInputFecha(){
	$("#txt-fecha").on("input", function(){
		var f=$(this).val();
		$("#txt-fec-egr").val(f);
		cargarFechaConvertida(f);
		cargarTablaEgresos(f);
	});
}

function onInputFechaEgreso(){
	$("#txt-fec-egr").on("input", function(){
		var f=$(this).val();
		cargarFechaConvertida(f);
	});
}

function onClickCategorias(){
	$("#txt-categoria").click(function(){
		$(this).val("");
	});
}

function onInputCategorias(){
	$("#txt-categoria").on("input", function(){
		var id=$('#listCategoria').find('option').filter(function(){ 
			return $.trim( $(this).val()) === $("#txt-categoria").val();
		}).attr('id');
		if(id!=undefined){
			$("#btn-reg-cat").prop("disabled", true);
			$("#txt-cat").val(id);	
		}else{
			$("#btn-reg-cat").prop("disabled", false);
			$("#txt-cat").val("");
		}
	});
}

function onFocusOutMonto(){
	$("#txt-monto").focusout(function(){
		if($(this).val()===""){
			$(this).val("0");
		}
	});
}

function onClickCancelar(){
	$("#btn-cancelar").click(function(){
		cancelarEgreso();
	});
}

function onClickReactivar(){
	$("#btn-reactivar").click(function(){
		reactivarEgreso();
	});
}

function onClickRegistrarCategoria(){
	$("#btn-reg-cat").click(function(){
		if($("#txt-categoria").val()===""){
			alert("⚠️ La sección categoría esta vacía");
			$("#txt-categoria").focus();
		}else{
			var id=$('#listCategoria').find('option').filter(function(){ 
				return $.trim( $(this).val()) === $("#txt-categoria").val();
			}).attr('id');
			if(id===undefined){
				registrarCategoria();
			}else{
				alert("⚠️ Esta categoría ya existe!");	
			}
		}
	});
}

function onClickEgreso(){
	$("input[name=egreso]").click(function(){
		$("#btn-agregar").attr("disabled", "disabled");
		$("#btn-modificar").removeAttr("disabled");
		$("#btn-cancelar").removeAttr("disabled");
		cargarDatosEgreso($(this).val());
	});
}

function cargarFechaHoy(){
	$.ajax({
		url: "php/cargar_fecha_hoy.php",
		success: function(respuesta){
			$("#txt-fecha").val(respuesta);
			$("#txt-fec-egr").val(respuesta);
			cargarTotalEgresoDia(respuesta);
			cargarFechaConvertida(respuesta);
			cargarTablaEgresos(respuesta);
		}
	});
}

function cargarFolio(){
	$.ajax({
		url: "php/cargar_folio.php",
		success: function(respuesta){
			$("#txt-folio").val(respuesta);
		}
	});
}

function cargarFechaConvertida(fecha){
	$.ajax({
		type: "get",
		url: "php/cargar_fecha_convertida.php?fecha="+fecha,
		success: function(respuesta){
			$("#txt-fec-con").val(respuesta);
		}
	});
}

function cargarCategorias(){
	$.ajax({
		url: "php/cargar_categorias.php",
		success: function(respuesta){
			$("#listCategoria").html(respuesta);
		}
	});
}

function registrarCategoria(){
	$.ajax({
		type: "get",
		url: "php/registrar_categoria.php?cat="+$("#txt-categoria").val(),
		success: function(respuesta){
			alert(respuesta);
			cargarCategorias();
		}
	});
}

function agregarEgreso(){
	$.ajax({
		type: "post",
		url: "php/agregar_egreso.php",
		data: $("#formEgreso").serialize(),
		success: function(respuesta){
			if(respuesta==="✔ Egreso registrado!"){
				limpiar();
			}
			alert(respuesta);
		}
	});
}

function cargarTablaEgresos(fecha){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_egresos.php?fec="+fecha,
		success: function(respuesta){
			$("#contenedor-egresos").html(respuesta);
			onClickEgreso();
		}
	})
}

function cargarDatosEgreso(egreso){
	$.ajax({
		type: "get",
		url: "php/cargar_datos_egreso.php?egreso="+egreso,
		success: function(respuesta){
			var exp=respuesta.split("/--/");
			var color="white";
			$("#txt-folio").val(exp[0]);
			$("#txt-fec-egr").val(exp[1]);
			$("#txt-categoria").val(exp[2]);
			$("#txt-cat").val(exp[6]);
			$("#txt-descripcion").val(exp[3]);
			$("#txt-monto").val(exp[4]);
			if(exp[5]==="Cargado"){
				$("#txt-fec-egr").removeAttr("readonly");
				$("#txt-fec-egr").removeAttr("style");
				$("input[name=estado][value=Cargado]").prop("checked", true);
			}
			if(exp[5]==="Vencido"){ 
				color="#FFFF99";
				$("#txt-fec-egr").removeAttr("readonly");
				$("#txt-fec-egr").removeAttr("style");
				$("input[name=estado][value=Vencido]").prop("checked", true); 
			}
			if(exp[5]==="Pagado"){ 
				color="lightcoral";
				$("#txt-fec-egr").removeAttr("readonly");
				$("#txt-fec-egr").removeAttr("style");
				$("input[name=estado][value=Pagado]").prop("checked", true); 
			}
			if(exp[5]==="Cancelado"){ 
				color="plum";
				$("#btn-modificar").attr("disabled", "disabled");
				$("#btn-cancelar").attr("disabled", "disabled");
				$("#btn-reactivar").removeAttr("disabled");
				$("input[name=estado]").prop("checked", false); 
				$("#formEgreso :input").css("background", color);
				$("#formEgreso :input").attr("disabled", "disabled");
			}
			$("#formEgreso :input").css("background", color);
		}
	});
}

function cargarTotalEgresoDia(fecha){
	$.ajax({
		type: "get",
		url: "php/cargar_totales_egresos.php?fecha="+fecha,
		success: function(respuesta){
			var exp=respuesta.split("/--/");
			$("#txt-tot-egr-dia").val(exp[0]);
			$("#txt-tot-egr-mes").val(exp[1]);
			$("#txt-tot-egr-ano").val(exp[2]);
		}
	});
}

function modificarEgreso(){
	$.ajax({
		type: "post",
		url: "php/modificar_egreso.php",
		data: $("#formEgreso").serialize(),
		success: function(respuesta){
			if(respuesta==="✔ Egreso modificado!"){
				limpiar();
			}
			alert(respuesta);
		}
	});
}

function cancelarEgreso(){
	$.ajax({
		type: "get",
		url: "php/cancelar_egreso.php?folio="+$("#txt-folio").val(),
		success: function(respuesta){
			if(respuesta==="✔ Egreso cancelado!"){
				limpiar();
			}
			alert(respuesta);
		}
	});
}

function reactivarEgreso(){
	$.ajax({
		type: "get",
		url: "php/reactivar_egreso.php?folio="+$("#txt-folio").val(),
		success: function(respuesta){
			if(respuesta==="✔ Egreso reactivado!"){
				limpiar();
			}
			alert(respuesta);
		}
	});
}