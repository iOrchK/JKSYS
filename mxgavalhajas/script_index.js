$(document).ready(function(){
	(function () {
		$('[data-toggle="tooltip"]').tooltip("disabled");
	})();

	$("#btn-nuevo").click(function(){
		$(".jumbotron").css("background", "url('../IMG/font-plata.jpg') no-repeat").css("background-size", "100%").css("background-position", "0px -100px");
		$("#avaluo").text("$0").css("color", "white");
		$("#alert").html("");
	});

	$("#btn-calcular").click(function(){
		$("#alert").html("");
		$("#modal").html("");
		var avaluo=0;
		var grs=$("#txt-peso").val();
		if(grs==="" || (parseFloat(grs)<=0)){
			$("#alert").html('<div class="alert alert-warning"><strong><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Atención!</strong> Ingrese una cantidad válida</div>').addClass('show');
			$("#txt-peso").val("");
			$("#txt-peso").focus();
		}else{
			var precio=$("#txt-metal :selected").val();
			var metal=$("#txt-metal :selected").text();
			var devaluo=0;
			var descripcion=$("#txt-descripcion :selected").text();
			if($("#txt-metal :selected").prop("class")==="plata"){
				devaluo=$("#txt-descripcion :selected").val();
			}else{
				devaluo=$("#txt-descripcion :selected").prop("title");
			}			
			var modal=$("#modal").html('<div id="myModal" class="modal fade" role="dialog"><div class="modal-dialog"> <!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Confirmación de datos</h4></div><div id="datos-modal" class="modal-body"><p><strong>Metal: </strong>'+metal+'</p><p><strong>Descripcion: </strong>'+descripcion+'</p><p><strong>Peso: </strong>'+grs+' grs.</p></div><div class="modal-footer"><button id="btn-modal-confirm" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button></div></div></div></div>');
			$("#btn-modal-confirm").click(function(){
				avaluo=parseFloat(grs)*parseInt(precio)*parseFloat(devaluo);
				if(avaluo===0){
					avaluo="No aceptable";
					$("#avaluo").text(avaluo).css("color", "crimson");
				}else{
					avaluo="$"+parseInt(avaluo);
					$("#avaluo").text(avaluo).css("color", "limegreen");
				}
				$(".form-control").prop("disabled", false);
				$("#alert").html('<div class="alert alert-success"><strong><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Exito!</strong> Avalúo finalizado</div>').addClass('show');
			});
		}
	});

	$("#txt-metal").on("input", function(){
		if($("#txt-metal :selected").prop("class")==="plata"){
			$(".jumbotron").css("background", "url('../IMG/font-plata.jpg') no-repeat");
		}else{
			$(".jumbotron").css("background", "url('../IMG/font-oro.jpg') no-repeat");
		}
		$(".jumbotron").css("background-size", "100%").css("background-position", "0px -100px");
	});

	$("#txt-peso").on("input",function(){
		$("#alert").html("");
	});
});