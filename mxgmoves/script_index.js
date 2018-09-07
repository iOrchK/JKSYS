/**************************************************************************************************************/
/************************************************* Start Main *************************************************/
/**************************************************************************************************************/
$(document).ready(function(){
	readyToolTip();
	cargarMesAno();

	// Mostrar tabla ingresos al cargar
	$("#tabIngMens").slideDown(400);

	// marcar active al cargar
	$("#btn-ingresos").addClass("active").siblings().removeClass("active");

	$("#txt-mes-ano").on("change",function(){
		var mesano=$("#txt-mes-ano").val();
		cargarIngresoMensual(mesano);
		cargarRecapitalizacion(mesano);
		cargarCapitalCirculanteMensual(mesano);
		cargarTablaIngresos(mesano);
		cargarTablaCapitalCirculante(mesano);
		cargarTablaRecapitalizacion(mesano);
	});

	// al hacer click en boton, marcar como active
	$(".btn-group > .btn").click(function(){
	    $(this).addClass("active").siblings().removeClass("active");
	});

	// al hacer clic en boton ingresos, mostrar su tabla
	$("#btn-ingresos").click(function(){
		$("#tabIngMens").slideDown(400);
		$("#tabRecap").hide();
		$("#tabCapCirc").hide();
	});

	// al hacer clic en boton recapitalizaciones, mostrar su tabla
	$("#btn-recapita").click(function(){
		$("#tabIngMens").hide();
		$("#tabRecap").slideDown(400);
		$("#tabCapCirc").hide();
	});

	// al hacer clic en boton egresos, mostrar su tabla
	$("#btn-egresos").click(function(){
		$("#tabIngMens").hide();
		$("#tabRecap").hide();
		$("#tabCapCirc").slideDown(400);
	});
});
/**************************************************************************************************************/
/************************************************** End Main **************************************************/
/**************************************************************************************************************/

function readyToolTip(){
	// Agregar la etiqueta tittle="Texto del tooltip" al elemento html
	$(function(){
		$( document ).tooltip();
	});
}

function cargarMesAno(){
	$.ajax({
		url: "php/cargar_mes_ano.php",
		success: function(respuesta){
			$("#txt-mes-ano").val(respuesta);
			cargarIngresoMensual(respuesta);
			cargarRecapitalizacion(respuesta);
			cargarCapitalCirculanteMensual(respuesta);
			cargarTablaIngresos(respuesta);
			cargarTablaCapitalCirculante(respuesta);
			cargarTablaRecapitalizacion(respuesta);
		}
	});
}

function cargarObservacionesOperacion(folemp){
	$.ajax({
		type: "get",
		url: "php/cargar_observaciones.php?folemp="+folemp,
		success: function(respuesta){
			$("#txt-temp-obs").val(respuesta);
		}
	});
}

function modificarObservacionesOperacion(folemp){
	var obs=$("#txt-temp-obs").val();
	var r=prompt("Modifica las observaciones, luego presiona ACEPTAR", obs);
	if(r!=null){ 
		$.ajax({
			type: "get",
			url: "php/agregar_observaciones.php?folemp="+folemp+"&obs="+r,
			success: function(respuesta){
				alert(respuesta);
				$("input[name=movimiento]").prop("checked", false);
				cargarTablaCapitalCirculante($("#txt-mes-ano").val());
			}
		});
	}else{
		$("input[name=movimiento]").prop("checked", false);
	}
}

function cargarObservacionesRefrendo(folref){
	$.ajax({
		type: "get",
		url: "php/cargar_observaciones_refrendo.php?folref="+folref,
		success: function(respuesta){
			$("#txt-temp-obs").val(respuesta);
		}
	});
}

function modificarObservacionesRefrendo(folref){
	var obs=$("#txt-temp-obs").val();
	var r=prompt("Modifica las observaciones, luego presiona ACEPTAR", obs);
	if(r!=null){ 
		$.ajax({
			type: "get",
			url: "php/agregar_observaciones_refrendo.php?folref="+folref+"&obs="+r,
			success: function(respuesta){
				alert(respuesta);
				cargarTablaIngresos($("#txt-mes-ano").val());
				cargarTablaRecapitalizacion($("#txt-mes-ano").val());
			}
		});
	}
	$("input[name=ingreso]").prop("checked", false);
	$("input[name=recap]").prop("checked", false);
}

function cargarCapitalCirculanteMensual(mesano){
	$.ajax({
		type: "get",
		url: "php/cargar_capital_circulante_mensual.php?mesano="+mesano,
		success: function(respuesta){
			$("#txt-cap-cir").val(respuesta);
		}
	})
}

function cargarIngresoMensual(mesano){
	$.ajax({
		type: "get",
		url: "php/cargar_ingreso_mensual.php?mesano="+mesano,
		success: function(respuesta){
			$("#txt-ing-mens").val(respuesta);
		}
	});
}

function cargarRecapitalizacion(mesano){
	$.ajax({
		type: "get",
		url: "php/cargar_recapitalizacion.php?mesano="+mesano,
		success: function(respuesta){
			$("#txt-rec-mens").val(respuesta);
		}
	});
}

/*
function cargarCapitalInvertido(){
	var ex=$("#txt-cap-cir").val();
	var ex1=ex.split("$");
	ex=$("#txt-rec-mens").val();
	var ex2=ex.split("$");
	var capinv=parseInt(ex1[1])-parseInt(ex2[1]);
	capinv="$"+capinv;
	$("#txt-cap-inv").val(capinv);
}
*/

function cargarTablaIngresos(mesano){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_ingresos.php?mesano="+mesano,
		success: function(respuesta){
			$("#contenedor-ingresos").html(respuesta);

			$("input[name=ingreso]").click(function(){
				var folref=$(this).val();
				cargarObservacionesRefrendo(folref);
				setTimeout("modificarObservacionesRefrendo("+folref+")", 250);
			});
		}
	});
}

function cargarTablaRecapitalizacion(mesano){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_recapitalizacion.php?mesano="+mesano,
		success: function(respuesta){
			$("#contenedor-recap").html(respuesta);

			// Las observaciones de refrendo y abono a capital son las mismas
			$("input[name=recap]").click(function(){
				var folref=$(this).val();
				cargarObservacionesRefrendo(folref);
				setTimeout("modificarObservacionesRefrendo("+folref+")", 250);
			});
		}
	});
}

function cargarTablaCapitalCirculante(mesano){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_capital_circulante.php?mesano="+mesano,
		success: function(respuesta){
			$("#contenedor-movimientos").html(respuesta);

			$("input[name=movimiento]").click(function(){
				var folemp=$(this).val();
				cargarObservacionesOperacion(folemp);
				setTimeout("modificarObservacionesOperacion("+folemp+")", 250);
			});
		}
	});
}