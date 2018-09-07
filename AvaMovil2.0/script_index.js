$(document).ready(function(){
	readyToolTip();
	onClickLogo();
	_on_click_search();
	_on_click_modo_valuador();
});

function readyToolTip(){
	// Agregar la etiqueta tittle="Texto del tooltip" al elemento html
	$(function(){
		$( document ).tooltip();
	});
}

function onClickLogo(){
	$("#return-home").click(function(e) {
		console.log("Regresar al home");
	  	e.preventDefault();
	  	window.location = '../index.html';
	});
}

function _on_click_search(){
	$("#btn-search").click(function(){
		$("#valuador").hide();
		$("#modo-valuador").prop("checked", false);
		if($("#txt-search").val()===""){
			alert("Debe ingresar la marca");
			$("#txt-search").focus();
		}else{
			$("#cont-pag").html("<center><img src='../IMG/load.gif' width='20' height='20' style='background:none'><b> Cargando resultados</b></center>");
			$(".results").remove();
			_cargar_num_pag();
		}
	});
}

function _on_click_modo_valuador(){
	$("#modo-valuador").click(function(){
		if($(this).prop("checked")===true){
			$(".precio").hide();
		}else{
			$(".precio").show();
		}
	});
}

function _cargar_num_pag(){
	$.ajax({
		url: "php/cargar_num_pag.php",
		success: function(respuesta){
			pag=respuesta;
			var search=$("#txt-search").val();
			_cargar_resultados(parseInt(pag), search);
		}
	});
}

function _cargar_resultados(pag, search){
	for (var i = 1; i<=pag; i++) {
		$.ajax({
			type: "get",
			url: "php/cargar_result.php?numpag="+i+"&search="+search,
			success: function(respuesta){
				$("#cont-pag").after(respuesta);
			}
		});	
	}
	$("#cont-pag").html("<div class='results'><center><b>La busqueda ha finalizado. "+pag+" paginas revisadas. Presentando resultados...</b></center></div>");
	switchOn(pag);
}

function _cargar_caracteristicas($carac){
	$.ajax({ 
		type: 'get',
		url: 'php/cargar_características?link='+$carac,
		success: function(respuesta){ 
			alert(respuesta); 
		} 
	})
}

function switchOn(pag){
	var time=parseInt(pag)*500;
	//alert(time);
	setTimeout(function(){
		$("#valuador").show();
		$("#cont-pag").html("<div class='results'><center><font color='green'><b>Listo!</b></font></center></div>");
	}, time);
}