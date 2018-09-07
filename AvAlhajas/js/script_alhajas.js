$(document).ready(function(){
				var img="";
				
				// Carga valores de la B.D. en txt-metal
				$.ajax({
					url: "php/get_metales.php",
					success: function(respuesta){
						if(parseInt(respuesta) === 0){
							swal({
								title: "DBERROR",
								text: "Contacte al Administrador de T.I.",
								type: "error",
								showCancelButton: false,
								closeOnConfirm: true,
								showLoaderOnConfirm: false,
							});							
						}else{
							if(parseInt(respuesta) === 1){
								swal({
									title: "MYSQLIERROR",
									text: "Contacte al Administrador de T.I.",
									type: "error",
									showCancelButton: false,
									closeOnConfirm: true,
									showLoaderOnConfirm: false,
								});
							}else{
								$("#contenedor-data-list-metal").html(respuesta);
							}
						}
					},
					error: function(errorThrown){
						alert("AJAXERROR: "+errorThrown+". Contacte al Administrador de T.I.")
					}
				});
				
				// Calcular y mostrar el avaluo en #contenedor_avaluo
				$("#btn-ava-joy").click(function(){
					var metal=$("#txt-metal").val();
					var grspzanue=$("#txt-grs-pza-nue").val();
					var grspzasemi=$("#txt-grs-pza-semi").val();
					var grsretac=$("#txt-grs-retac").val();

					if(metal==="" || grspzanue==="" && grspzasemi==="" && grsretac===""){
						swal({
							title: "Campos Vacíos!",
							text: "Debe seleccionar el metal e ingresar los gramos en el/los campo(s) correspondiente(s).",
							type: "warning",
							showCancelButton: false,
							closeOnConfirm: true,
							showLoaderOnConfirm: false,
						});
					}else{
						if(grspzanue === ""){ grspzanue=0; }
						if(grspzasemi === ""){ grspzasemi=0; }
						if(grsretac === ""){ grsretac=0; }
						
							var idmetal=$('#dat-list-metal').find('option').filter(function(){ 
									return $.trim( $(this).val()) === metal; 
								}).attr('id');

							if(isNaN(idmetal)){
								swal({
									title: "Metal Invalido!",
									text: "Seleccione un Metal en el campo correspondiente.",
									type: "warning",
									showCancelButton: false,
									closeOnConfirm: true,
									showLoaderOnConfirm: false,
								});
							}else{
								var explode=metal.split(" ");

								$.ajax({
									type: "get",
									url: "php/get_valuacion.php?id_metal="+idmetal+"&grs_pza_nueva="+grspzanue+"&grs_pza_semi="+grspzasemi+"&grs_retac="+grsretac+"&metal="+explode[0]+"&kilataje="+explode[1]+"&dmetal="+metal,
									success: function(respuesta){
										if(parseInt(respuesta) === 0){
											swal({
												title: "DBERROR",
												text: "Contacte al Administrador de T.I.",
												type: "error",
												showCancelButton: false,
												closeOnConfirm: true,
												showLoaderOnConfirm: false,
											});							
										}else{
											if(parseInt(respuesta) === 1){
												swal({
													title: "MYSQLIERROR",
													text: "Contacte al Administrador de T.I.",
													type: "error",
													showCancelButton: false,
													closeOnConfirm: true,
													showLoaderOnConfirm: false,
												});
											}else{
												$("#contenedor-respuesta").html(respuesta);

												// Mostrar ventana modal
												$("#contenedor-opacidad").fadeIn("slow");
											}
										}
									},
									error: function(errorThrown){
										alert(errorThrown);
									}
								});

							}
					}
				});

				// Limpiar la ventana modal
				$("#btn-aceptar").click(function(){
					$("#contenedor-opacidad").fadeOut("slow");
				});

				$("#txt-metal").click(function(){
					$("#txt-metal").val("");
				});

				$("#txt-est-fis").click(function(){
					$("#txt-est-fis").val("");
				});

			$("#img-nue").hover(function() {
				/* Stuff to do when the mouse enters the element */
				$("#tooltip-1").text("Prendas integras, prendas de moda.");
				$("#tooltip-1").show();
			}, function() {
				/* Stuff to do when the mouse leaves the element */
				$("#tooltip-1").hide();
				$("#tooltip-1").text("");
			});

			$("#img-semi").hover(function() {
				/* Stuff to do when the mouse enters the element */
				$("#tooltip-2").text("Prendas usadas, con leves detalles de estética.");
				$("#tooltip-2").show();
			}, function() {
				/* Stuff to do when the mouse leaves the element */
				$("#tooltip-2").hide();
				$("#tooltip-2").text("");
			});

			$("#img-retac").hover(function() {
				/* Stuff to do when the mouse enters the element */
				$("#tooltip-3").text("Prendas rotas, quebradas, incompletas, pasadas de moda.");
				$("#tooltip-3").show();
			}, function() {
				/* Stuff to do when the mouse leaves the element */
				$("#tooltip-3").hide();
				$("#tooltip-3").text("");
			});
});