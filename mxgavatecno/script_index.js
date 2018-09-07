$(document).ready(function(){
	$("#btn-nuevo").click(function(){
		$("#puntos").html("");
		$("#descripcion").html("");
		$("#avaluo").text("$0").css("color", "white");
		$("#alert").html("");
	});

	$("#btn-calcular").click(function(){
		$("#alert").html("");
		$("#modal").html("");
		if(parseInt($("#ptos").val())===0){
			$("#alert").html('<div class="alert alert-warning"><strong><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Atención!</strong> Califica la estética</div>').addClass('show');
			$(".clasificacion").prop("style", "border-color: rgba(0, 100, 255, 1); -webkit-box-shadow: 0px 0px 25px -6px rgba(0,102,255,1); -moz-box-shadow: 0px 0px 25px -6px rgba(0,102,255,1); box-shadow: 0px 0px 25px -6px rgba(0,102,255,1);");
		}else{
			if($("#txt-precio").val()===""){
				$("#alert").html('<div class="alert alert-warning"><strong><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Atención!</strong> Escribe el precio</div>').addClass('show');
				$("#txt-precio").focus();
			}else{
				if(parseInt($("#txt-precio").val())<=0){
					$("#alert").html('<div class="alert alert-warning"><strong><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Atención!</strong> Escribe una cantidad mayor a cero</div>').addClass('show');
					$("#txt-precio").focus();
				}else{
					var desestetica=$("#desc").val();
					var desantiguedad=$("#txt-antiguedad :selected").text();
					var precio=$("#txt-precio").val();
					var modal=$("#modal").html('<div id="myModal" class="modal fade" role="dialog"><div class="modal-dialog"> <!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Confirmación de datos</h4></div><div id="datos-modal" class="modal-body"><p><strong>Estética: </strong>'+desestetica+'</p><p><strong>Antiguedad: </strong>'+desantiguedad+'</p><p><strong>Precio: </strong>$'+precio+'</p></div><div class="modal-footer"><button id="btn-modal-confirm" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button></div></div></div></div>');
					
					$("#btn-modal-confirm").click(function(){
						var estetica=$("#ptos").val();
						var antiguedad=$("#txt-antiguedad :selected").val();
						var vestetic=0;

						switch (parseInt(estetica)) { 
							case 1: 
								vestetic=0;
								break;
							case 2: 
								vestetic=.625;
								break;
							case 3: 
								vestetic=.75;
								break;		
							case 4: 
								vestetic=.875;
								break;
							case 5: 
								vestetic=1;
								break;
							default:
								alert('Califique la estética de 1 a 5 marcando el número de estrellas');
								$(".clasificacion").focus();
								break;
						}

						var avaluo=(parseFloat(precio)/3)*parseFloat(antiguedad)*parseFloat(vestetic);
						if(avaluo===0){
							avaluo="No aceptable";
							$("#avaluo").text(avaluo).css("color", "crimson");
						}else{
							if(avaluo>3500){
								avaluo=3500;
							}
							avaluo="$"+parseInt(avaluo);
							$("#avaluo").text(avaluo).css("color", "limegreen");
						}
						$(".form-control").prop("disabled", false);
						$("#alert").html('<div class="alert alert-success"><strong><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Exito!</strong> Avalúo finalizado</div>').addClass('show');
					});
				}
			}
		}
		
	});

	$(".clasificacion").hover(function(){
		$(".clasificacion").removeAttr('style');
	});

	$(".star").click(function(){
		var star=$(this).prop("for");
		star="#"+star;
		var ptos=$(star).val();
		$(star).prop("checked", true);
		var desc="";
		switch (parseInt(ptos)) { 
			case 1: 
				desc="Pésima";
				dctoEste=0;
				break;
			case 2: 
				desc="Mala";
				dctoEste=.25;
				break;
			case 3: 
				desc="Regular";
				dctoEste=.5;
				break;		
			case 4: 
				desc="Buena";
				dctoEste=.75;
				break;
			case 5: 
				desc="Excelente";
				dctoEste=1;
				break;
			default:
				alert('Califique la estética de 1 a 5 marcando el número de estrellas');
				$(".clasificacion").focus();
				break;
		}	
		$("#puntos").html(ptos);
		$("#ptos").val(ptos);
		$("#descripcion").html(desc);
		$("#desc").val(desc);
	});

	$("#txt-precio").on("input",function(){
		$("#alert").html("");
	});
});