(function(){
	// Cargar dia actual
	cargarDia();

	// Click en dia - Cargar datos
	$("input[name=dia]").click(function(){
		var dia=$(this).val();
		var hoy=$("#txt-hoy").val();
		var iddia="#dia"+$(this).val();
		$(".diaNum").attr("color", "white");
		$(iddia).attr("color", "crimson");
		if(parseInt(dia)===parseInt(hoy)){
			$("#h3Title").text("Historial de intereses y/o abonos cargados de HOY");	
		}else{
			$("#h3Title").text("Historial de intereses y/o abonos cargados del día "+parseInt(dia));
		}
		cargarCalendario(dia);
	});

	// Ocultar operaciones Liquidadas y canceladas
	$("#ocultar-cancelados").click(function(){
		if($("#ocultar-cancelados").prop("checked")){
			$(".row-hidden-c").hide();
		}else{
			$(".row-hidden-c").show();
		}
	});

	$("#ocultar-liquidados").click(function(){
		if($("#ocultar-liquidados").prop("checked")){
			$(".row-hidden-l").hide();
		}else{
			$(".row-hidden-l").show();
		}
	});

	// Agregar la etiqueta tittle="Texto del tooltip" al elemento html
	$( document ).tooltip();
})();

function cargarCalendario(dia){
	$.ajax({
		type: "get",
		url: "php/cargar_calendario.php?dia="+dia,
		success: function(respuesta){
			$("#contenedor-calendario").html(respuesta);
			//$("#contenedor-calendario").scrollLeft(1000);
			cargarPendientes();
		}
	});
}

function cargarPendientes(){
	var init=$("#mmyyyy th:nth-child(3)").attr("id");
	var limit=$("#mmyyyy th:last-child").attr("id");
	
	$.ajax({
		type: "get",
		url: "php/cargar_pendientes.php?init="+init+"&limit="+limit,
		success: function(respuesta){
			//alert(respuesta);
			$("#contenido").html(respuesta);
			$("#ocultar-cancelados").prop("checked", true);
			$(".row-hidden-c").hide();
			$("#ocultar-liquidados").prop("checked", true);
			$(".row-hidden-l").hide();
		}
	});
}

function cargarDia(){
	$.ajax({
		url: "php/cargar_dia.php",
		success: function(respuesta){
			$(".diaNum").attr("color", "white");
			$("#dia"+respuesta).attr("color", "crimson");
			$("input[name=dia][value='"+respuesta+"']").prop("checked", true);
			$("#txt-hoy").val(respuesta);

			cargarCalendario($("#txt-hoy").val());
		}
	});
}