$(document).ready(function(){
	cargarExistencias("", "");
	cargarTotalExistencias();

	//$('#stock-tab').DataTable();

	$("input[class=form-control]").focusout(function(){
		$("input[class=form-control]").val("");
		cargarExistencias("", "");
	});

	$("input[class=form-control]").on("input", function(){
		var filtro=$(this).prop("id");
		var busqueda=$(this).val();
		if(busqueda===""){
			filtro="";
		}
		cargarExistencias(busqueda, filtro);
	});
});

function cargarTotalExistencias(){
	$.ajax({
		url: "php/cargar_total_existencias.php",
		success: function(respuesta){
			$("#totexi").text(respuesta);
		}
	});
}

function cargarExistencias(busqueda, filtro){
	$.ajax({
		type: "get",
		url: "php/cargar_tabla_existencias.php?busqueda="+busqueda+"&filtro="+filtro,
		success: function(respuesta){
			$("#stock-rows").html(respuesta);
		}
	});
}