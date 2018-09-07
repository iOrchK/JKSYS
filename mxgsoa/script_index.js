(function(){
	$("#listaClientes").html("");

	// Click en botón buscar - cargar lista de clientes
	$("#btn-search").click(function(){
		$("#txt-buscar").focus();
		cargarListaClientes($("#txt-buscar").val());
		filtrarListaClientes();
	});

	// Al agregar datos al campo buscar - 
	$("#txt-buscar").on("input", function(){
		$("#contenedor").html("<p><center><b>🤔 Realice una búsqueda de cliente</b></center></p>");
		if($("#txt-buscar").val()===""){
			$("#txt-buscar").focus();
			$("#listaClientes").html("");
		}else{
			if($("#listaClientes").html()!=""){
				$("#txt-buscar").focus();
				$("#contenedor").html("<p><center><b>😃 Presiona el picker 🔻 y selecciona cliente, o realice otra busqueda.</b></center></p>");
				filtrarListaClientes();
			}
		}
	});

	$("#txt-buscar").on('search', function(){
		$("#txt-buscar").focus();
	    $("#listaClientes").html("");
	});

	// Activar tooltips - Agregar la etiqueta tittle="Texto del tooltip" al elemento html
	$( document ).tooltip();
})();

var id
function filtrarListaClientes(){
	id=$('#listaClientes').find('option').filter(function(){ 
		return $.trim( $(this).val()) === $("#txt-buscar").val();
	}).attr('id');
	if(id!=undefined){
		cargarEstadoCuenta(id);
	}
}

function onClickRecargos(){
	$("#txt-recargos").click(function(){
		$("#txt-recargos").val("");
	});
}

function onInputRecargos(){
	$("#txt-recargos").on("input", function(){
		var rec=$("#txt-recargos").val();
		var sub=$("#txt-sub-tot").val();
		if(isNaN(rec) || rec===""){
			rec=0;
		}
		var gtot=parseInt(rec)+parseInt(sub);
		gtot="$"+gtot;
		$("#txt-gra-tot").val(gtot);

		crearCanvas();
	});
}

function cargarListaClientes(cte){
	$.ajax({
		type: "get",
		url: "../mxgoc/php/cargar_lista_clientes.php?cte="+cte,
		success: function(respuesta){
			if(respuesta==="invalid"){
				$("#txt-buscar").focus();
				$("#contenedor").html("<p><center><b>🤔 Vuelva a realizar la búsqueda.</b></center></p>");
			}else{
				$("#txt-buscar").focus();
				$("#listaClientes").html(respuesta);
				$("#contenedor").html("<p><center><b>😃 Presiona el picker 🔻 y selecciona cliente.</b></center></p>");
			}
		}
	});
}

var getCanvas;
function cargarEstadoCuenta(idcte){
	$.ajax({
		type: "get",
		url: "php/cargar_estado_cuenta.php?idcte="+idcte,
		success: function(respuesta){
			$("#contenedor").html(respuesta);
			onClickRecargos();
			onInputRecargos();
			crearCanvas();
			$("#btn-dwld").click(function(){
				var imgageData = getCanvas.toDataURL("image/png");
				var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    			$("#btn-dwld").attr("download", "edocta.png").attr("href", newData);
			});
		}
	});
}

function crearCanvas(){
	$("#cont-canvas").html("");
	html2canvas(document.querySelector("#downloadable")).then(canvas => {
	    $("#cont-canvas").append(canvas);
	    getCanvas = canvas;
	});
}