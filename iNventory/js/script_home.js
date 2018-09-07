$(document).ready(function() {
	var continv=0;
	$("#cont-settings").hide();
	_validate_caducity();
	_validate_bloq();
	_validate_user_blocked();
	_charge_list_prod();
	_charge_list_moves();
	_charge_stock();
	_charge_moves();
	_charge_date();
	_charge_resume_moves();
	//jAlert("limegreen", "Ejemplo de jAlert");

	$(".menu").click(function(){ // Al hacer click en boton de menu
		$('body,html').animate({scrollTop : 0}, 500); // Regresa la página al header
	});

	/*********************** Start Protection Navigator ***********************/
	$("body").on("contextmenu",function(){ // On click the Right Button of Mouse ...
		return false; // Hide context menu
	});

	$(document).on("cut copy paste","#txt-pass",function(e){ // lock cut copy paste
		var msg="Alerta. Alguien uso la combinación de teclas Ctrl+X, Ctrl+C o Ctrl+V. Esto es un intento de manipulación de alguna contraseña. El usuario que está utilizando el programa pretende averiguar contraseñas.";
		var asunto="JK iNventory: Alerta!";
		_send_notify(asunto, msg); // Send notify for email
		e.preventDefault();
	});

	$(document).keydown(function(e){ // On press Keys F5, F12 ...
		var code = (e.keyCode ? e.keyCode : e.which);
		var msg="";
		var asunto="";
		if(code === 116) { // if key pressed is F5 ...
			msg="Alguien presionó la combinación de teclas Fn y/o F5. Esto es un intento de manipulación de memoria caché del programa. El usuario que está usando el programa esta indagando sobre como manipularlo.";
			asunto="JK iNventory: Alerta!";
			_send_notify(asunto, msg); // Send notify for email
			e.preventDefault(); // Block combination
		}
		if(code === 123){ // if key pressed is F12 ...
			msg="Alguien presionó la combinación de teclas Fn+F12. Esto es un intento de manipulación del programa. Contacte al usuario que está usando el programa en estos momentos, puede evitar que su información sea robada, manípulada o corrupta.";
			asunto="JK iNventory: Alerta!";
			_send_notify(asunto, msg); // Send notify for email
			e.preventDefault(); // Block combination
		}
	});
	function _send_notify(asunto, msg){
		$.ajax({
			url: "php/notify_for_email.php?txt-asunto="+asunto+"&txt-msg="+msg,
			success: function(respuesta){
				console.log(respuesta);
			}
		});
	}
	/************************ End Protection Navigator ************************/

	$("#btn-close").click(function(){
		$("#alert").slideUp(500); // Ocultar alert
	});

	$("#btn-reg-pro").click(function(){ //E2
		var descri=$("#txt-desc").val();
		var marca=$("#txt-marca").val();
		var passwd=$("#txt-pass-reg-pro").val();
		if(descri==="" || marca==="" || passwd===""){
			jAlert("orange", "Se requiere una descripción del producto y una clave de usuario. Ingreselos para registrar el producto.");
			$("#txt-desc").focus();
		}else{
			$.ajax({ // A1
				url: "php/set_product.php",
				type: "post",
				data: $("#form-reg-pro").serialize(),
				success: function(respuesta){
					if(respuesta===1){
						jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
					}else{
						if(parseInt(respuesta)===2){
							jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
						}else{
							if(respuesta==="Passinv"){
								continv=continv+1;
								var adv="";
								if(continv===1){ adv="Primera advertencia. "; }
								if(continv===2){ adv="Segunda advertencia. "; }
								if(continv===3){ adv="Última advertencia. "; }
								if(continv===4){ _soft_blocked(); }							
								jAlert("crimson", adv+"Ingresó una clave de usuario inválida. Si continúa ingresando claves inválidas el programa se bloqueará. Costo de desbloqueo $750.");
							}else{
								jAlert("limegreen", respuesta+" REGISTRÓ el producto "+descri+" con éxito.");
								$("#txt-desc").val("");
								$("#txt-marca").val("");
								$(".txt-pass").val("1234567890");
								_charge_list_prod();
								_charge_list_moves();
								_charge_stock();
								_charge_moves();
								_charge_date();
								_charge_resume_moves();
							}
						}
					}
				}, error: function(errorThrown){
					jAlert("crimson", "Error: (Código: E1-A1) desconocido");
				}
			});
		}
	});

	$("#btn-cap-ent-pro").click(function() { //E3
		var produc=$("#txt-list-2-prod option:selected").text();
		var cantid=$("#txt-cant-ent-sal").val();
		var passwd=$("#txt-pass-ent-sal-pro").val();
		if(cantid==="" || passwd===""){
			jAlert("orange", "Se requiere una cantidad de productos y una clave de usuario. Ingreselos para capturar la ENTRADA del producto.");
			$("#txt-cant-ent").focus();
		}else{
			$.ajax({ // A1
				url: "php/set_entry_product.php",
				type: "post",
				data: $("#form-ent-sal").serialize(),
				success: function(respuesta){
					if(respuesta===1){
						jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
					}else{
						if(parseInt(respuesta)===2){
							jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
						}else{
							if(respuesta==="Passinv"){
								continv=continv+1;
								var adv="";
								if(continv===1){ adv="Primera advertencia. "; }
								if(continv===2){ adv="Segunda advertencia. "; }
								if(continv===3){ adv="Última advertencia. "; }
								if(continv===4){ _soft_blocked(); }							
								jAlert("crimson", adv+"Ingresó una clave de usuario inválida. Si continúa ingresando claves inválidas el programa se bloqueará. Costo de desbloqueo $750.");
							}else{
								jAlert("limegreen", respuesta+" INGRESÓ "+cantid+" unidades de "+produc+" sin problemas.");
								$("#txt-cant-ent-sal").val(1);
								$(".txt-pass").val("1234567890");
								_charge_list_prod();
								_charge_list_moves();
								_charge_stock();
								_charge_moves();
								_charge_date();
								_charge_resume_moves();
							}
						}
					}
				}, error: function(errorThrown){
					jAlert("crimson", "Error: (Código: E3-A1) desconocido");
				}
			});
		}
	});

	$("#btn-cap-sal-pro").click(function() { // E4
		var produc=$("#txt-list-2-prod option:selected").text();
		var cantid=$("#txt-cant-ent-sal").val();
		var passwd=$("#txt-pass-ent-sal-pro").val();
		if(cantid==="" || passwd===""){
			jAlert("orange", "Se requiere una cantidad de productos y una clave de usuario. Ingreselos para capturar la SALIDA del producto.");
			$("#txt-cant-sal").focus();
		}else{
			$.ajax({ // A1
				url: "php/set_retry_product.php",
				type: "post",
				data: $("#form-ent-sal").serialize(),
				success: function(respuesta){
					if(respuesta===1){
						jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
					}else{
						if(parseInt(respuesta)===2){
							jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
						}else{
							if(respuesta==="Passinv"){
								continv=continv+1;
								var adv="";
								if(continv===1){ adv="Primera advertencia. "; }
								if(continv===2){ adv="Segunda advertencia. "; }
								if(continv===3){ adv="Última advertencia. "; }
								if(continv===4){ _soft_blocked(); }							
								jAlert("crimson", adv+"Ingresó una clave de usuario inválida. Si continúa ingresando claves inválidas el programa se bloqueará. Costo de desbloqueo $750.");
							}else{
								if(respuesta==="Vacio"){
									jAlert("Orange", "El stock NO cuenta con "+produc+". Debe capturar la ENTRADA del producto.");
								}else{
									if(respuesta==="No disponible"){
										jAlert("crimson", "Se agotó el producto "+produc+" en el Stock. Solicitelo con el proveedor y al recibirlo registra la ENTRADA.");
									}else{
										var explode=respuesta.split(":");
										var usuario=explode[0];
										var disponi=explode[1];
										jAlert("limegreen", usuario+" RETIRÓ "+cantid+" unidades de "+produc+". Ahora quedan "+disponi+" disponibles.");
									}
								}
								$("#txt-cant-ent-sal").val(1);
								$(".txt-pass").val("1234567890");
								_charge_list_prod();
								_charge_list_moves();
								_charge_stock();
								_charge_moves();
								_charge_date();
								_charge_resume_moves();
							}
						}
					}
				}, error: function(errorThrown){
					jAlert("crimson", "Error: (Código: E4-A1) desconocido");
				}
			});
		}
	});

	$("#btn-eli-pro").click(function() { // E5
		var produc=$("#txt-list-1-prod option:selected").text();
		var passwd=$("#txt-pass-cap-sal-pro").val();
		if(produc===""){
			jAlert("orange", "No hay productos que eliminar.");
		}else{
			if(passwd===""){
				jAlert("orange", "Debe ingresar la clave de usuario.");
				$("#txt-pass-cap-sal-pro").focusin();
			}else{
				$.ajax({ // A1
					url: "php/delete_product.php",
					type: "post",
					data: $("#form-eli-pro").serialize(),
					success: function(respuesta){
						if(respuesta===1){
								jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
							}else{
								if(parseInt(respuesta)===2){
									jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
								}else{
									if(respuesta==="Passinv"){
										continv=continv+1;
										var adv="";
										if(continv===1){ adv="Primera advertencia. "; }
										if(continv===2){ adv="Segunda advertencia. "; }
										if(continv===3){ adv="Última advertencia. "; }
										if(continv===4){ _soft_blocked(); }							
										jAlert("crimson", adv+"Ingresó una clave de usuario inválida. Si continúa ingresando claves inválidas el programa se bloqueará. Costo de desbloqueo $750.");
									}else{
										jAlert("limegreen", respuesta+" ELIMINÓ el producto "+produc+".");
										$(".txt-pass").val("1234567890");
										_charge_list_prod();
										_charge_list_moves();
										_charge_stock();
										_charge_moves();
										_charge_date();
										_charge_resume_moves();
									}
								}
							}
					},error: function(errorThrown){
						jAlert("crimson", "Error: (Código: E5-A1) desconocido");
					}
				});
			}
		}
	});

	/*********************** Start Configuration Input Passwords *********************/
	$("input[type='password']").click(function() {
		$(this).val("");
	});

	$("input[type='password']").focusout(function(){
		setTimeout(function(){
			$("input[type='password']").val("");
		}, 1000);
	});

	$("input[type='button']").click(function(){
		setTimeout(function(){
			$("input[type='password']").val("");
		}, 1000);
	});

	/************************ End Configuration Input Passwords **********************/

	$("#txt-date").on("input", function(){
		$.ajax({
			url: "php/charge_list_moves.php",
			type: "post",
			data: $("#form-del-mov").serialize(),
			success: function(respuesta){
				if(respuesta===1){
					jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
				}else{
					if(parseInt(respuesta)===2){
						jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
					}else{
						$("#txt-list-1-mov").html(respuesta);
					}
				}
			}, error: function(errorThrown){
				jAlert("crimson", "Error: (Código: E5-A1) desconocido");
			}
		});
	});

	$("#txt-date-moves").on("input", function(){
		var date=$("#txt-date-moves").val();
		$.ajax({
			url: "php/charge_resume_moves.php?txt-date-moves="+date,
			success: function(respuesta){
				if(respuesta===1){
					jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
				}else{
					if(parseInt(respuesta)===2){
						jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
					}else{
						$("#cont-resume-moves").html(respuesta);
					}
				}
			}, error: function(errorThrown){
				jAlert("crimson", "Error: (Código: F9-A1) desconocido");
			}
		});
		$.ajax({ // A1
			url: "php/charge_moves.php?txt-date-moves="+date,
			success: function(respuesta){
				if(respuesta===1){
					jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
				}else{
					if(parseInt(respuesta)===2){
						jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
					}else{
						$("#cont-moves").html(respuesta);
					}
				}
			}, error: function(errorThrown){
				jAlert("crimson", "Error: (Código: F9-A1) desconocido");
			}
		});
	});

	$("#txt-stock-prod").on("input", function(){
		var search=$(this).val();
		$.ajax({ // A1
			url: "php/charge_stock.php?txt-stock-prod="+search,
			success: function(respuesta){
				if(respuesta===1){
					jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
				}else{
					if(parseInt(respuesta)===2){
						jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
					}else{
						$("#cont-stock").html(respuesta);
					}
				}
			}, error: function(errorThrown){
				jAlert("crimson", "Error: (Código: F9-A1) desconocido");
			}
		});
	});

	$("#btn-del-mov").click(function(){
		var moves=$("#txt-list-1-mov option:selected").text();
		var pass=$("#txt-pass-del-mov").val();
		if(moves===""){
			jAlert("orange", "No hay entradas ni salidas en el día seleccionado");
		}else{
			if(pass===""){
				jAlert("orange", "Se necesita la clave del usuario");
				var pass=$("#txt-pass-del-mov").focusin();
			}else{
				$.ajax({ // A1
					url: "php/delete_move.php",
					type: "post",
					data: $("#form-del-mov").serialize(),
					success: function(respuesta){
						if(respuesta===1){
								jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
							}else{
								if(parseInt(respuesta)===2){
									jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
								}else{
									if(respuesta==="Passinv"){
										continv=continv+1;
										var adv="";
										if(continv===1){ adv="Primera advertencia. "; }
										if(continv===2){ adv="Segunda advertencia. "; }
										if(continv===3){ adv="Última advertencia. "; }
										if(continv===4){ _soft_blocked(); }						
										jAlert("crimson", adv+"Ingresó una clave de usuario inválida. Si continúa ingresando claves inválidas el programa se bloqueará. Costo de desbloqueo $750.");
									}else{
										jAlert("limegreen", respuesta+" ELIMINÓ el movimiento "+moves+".");
										$(".txt-pass").val("1234567890");
										_charge_list_prod();
										_charge_list_moves();
										_charge_stock();
										_charge_moves();
										_charge_date();
										_charge_resume_moves();
									}
								}
							}
					},error: function(errorThrown){
						jAlert("crimson", "Error: (Código: E5-A1) desconocido");
					}
				});
			}
		}
	});

	$("#btn-config").click(function(){
		$("#alert").slideUp(); // Ocultar alert
		$("#cont-settings").slideDown(); // Mostrar panel de configuración
		$("#cont-resp-settings").hide(); // Oculta contenedor de respuesta
	});

	$("#btn-close-config").click(function(){
		$("#cont-settings").slideUp();
		$("#cont-autentication").slideDown();
		$("#cont-resp-settings").hide();
		$("#cont-resp-settings").html("");
	});

	$("#btn-val-user").click(function(){ // E20
		var passwd=$("#txt-pass-settings").val();
		if(passwd===""){
			jAlert("orange", "Se requiere una clave de usuario.");
			$("#txt-pass-settings").focus();
		}else{
			$.ajax({ // A1
				url: "php/validate_settings_access.php",
				type: "post",
				data: $("#form-settings").serialize(),
				success: function(respuesta){
					if(respuesta===1){
						jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
					}else{
						if(parseInt(respuesta)===2){
							jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
						}else{
							if(respuesta==="Passinv"){
								continv=continv+1;
								var adv="";
								if(continv===1){ adv="Primera advertencia. "; }
								if(continv===2){ adv="Segunda advertencia. "; }
								if(continv===3){ adv="Última advertencia. "; }
								if(continv===4){ _soft_blocked(); }							
								jAlert("crimson", adv+"Ingresó una clave de usuario inválida. Si continúa ingresando claves inválidas el programa se bloqueará. Costo de desbloqueo $750.");
							}else{
								$("#cont-settings").slideDown();
								$("#cont-autentication").slideUp();
								$("#cont-resp-settings").slideDown();
								$("#cont-resp-settings").html(respuesta);
								_charge_ip();
								_charge_data_admin();
								_charge_list_users();
								_set_new_user();
								var timecont=59; // contador de seguntos
								var cronometro=setInterval(function(){ // Cronometro para ocultar el panel de configuración
									$("#time-cont").text("Por seguridad este panel se cerrara en "+timecont+" segundos"); // Mensaje que muestra el tiempo restante para ocultar panel
									timecont=timecont-1; // disminuye un segundo
								},1000);
								setTimeout(function() { // programa el tiempo para ocultar el panel
							        $("#cont-settings").slideUp(); // oculta el panel
									$("#cont-autentication").slideDown(); // muestra el contenedor de autenticación
									$("#cont-resp-settings").hide(); // oculta el contenedor de configuración
									$("#cont-resp-settings").html(""); // vacía el contenedor de configuración
									clearInterval(cronometro); // reinicia el cronometro
							    },60000);
							}
						}
					}
				}, error: function(errorThrown){
					jAlert("crimson", "Error: (Código: E3-A1) desconocido");
				}
			});
		}
	});

	$("#btn-invent").click(function(){
		$("#cont-invent").slideDown();
		$("#cont-panel-invent").show();
		_validate_binnacle();
	});

	$("#btn-close-invent").click(function(){
		$("#cont-invent").slideUp(); // Ocultar alert
		$("#cont-panel-invent").slideDown();
		_validate_binnacle();
	});
});

/*****************************************************************/
/******************* Serial Validation Functions *****************/
/*****************************************************************/
function _validate_bloq(){ // F1
	$.ajax({ // A1 - Validar si el programa está bloqueado
		url: "php/validate_bloq.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					if(respuesta==="Desactivado"){
						window.location.href="index.html";
					}else{
						if(respuesta==="Caducado"){
							window.location.href="index.html";
						}
					}
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F1-A1) desconocido");
		}
	});
}

function _validate_caducity(){ // F2
	$.ajax({ // A1
		url: "php/validate_caducity.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					if(respuesta==="Caducado"){
						window.location.href="index.html";
					}else{
						var explode=respuesta.split("-");
						if(parseInt(explode[1])===1){
							jAlert("Orange", explode[0]);
						}else{
							if(parseInt(explode[1])===2){
								jAlert("limegreen", explode[0]);
							}
						}
					}
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F2-A1) desconocido");
		}
	});
}

/*****************************************************************/
/******************* Personal Alert Functions ********************/
/*****************************************************************/

function jAlert(color, msg){
	$("#alert").hide(); // Ocultar alert
	$("#alert").css("background-color", color); // Configurar color
	$("#msg").text(msg); // Configurar mensaje
	$("#alert").slideDown(500); // Mostrar alert
}

/*****************************************************************/
/******************* Set Products Functions **********************/
/*****************************************************************/

function _soft_blocked(){ //F5
	$.ajax({ // A1
		url: "php/set_blocked.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					if(respuesta==="Blocked"){
						window.location.href="soft_block.html";
					}
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F5-1) desconocido");
		}
	});
}

/*****************************************************************/
/***************** Validate User Block Functions *****************/
/*****************************************************************/

function _validate_user_blocked(){ //F6
	$.ajax({ // A1
		url: "php/validate_user_blocked.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					if(respuesta==="Bloqueado"){
						window.location.href="soft_block.html";
					}
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F6-A1) desconocido");
		}
	});
}

/*****************************************************************/
/******************** Charge Objects On Ready ********************/
/*****************************************************************/
function _charge_list_prod(){ // F7
	$.ajax({ //A1
		url: "php/charge_list_prod.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					$("#txt-list-1-prod").html(respuesta);
					$("#txt-list-2-prod").html(respuesta);
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F7-A1) desconocido");
		}
	});
}

function _charge_stock(){ // F8
	$.ajax({ // A1
		url: "php/charge_stock.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					$("#cont-stock").html(respuesta);
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F8-A1) desconocido");
		}
	});
}

function _charge_moves(){ // F9
	$.ajax({ // A1
		url: "php/charge_moves.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					$("#cont-moves").html(respuesta);
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F9-A1) desconocido");
		}
	});
}

function _charge_list_moves(){ // F10
	$.ajax({ // A1
		url: "php/charge_list_moves.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					$("#txt-list-1-mov").html(respuesta);
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F10-A1) desconocido");
		}
	});
}

function _charge_date(){ // F11
	$.ajax({ // A1
		url: "php/charge_date.php",
		success: function(respuesta){
			$("#txt-date").val(respuesta);
			$("#txt-date").attr("max", respuesta);
			$("#txt-date").attr("min", "2017-09-19");
			$("#txt-date-moves").val(respuesta);
			$("#txt-date-moves").attr("max", respuesta);
			$("#txt-date-moves").attr("min", "2017-09-19");
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F11-A1) desconocido");
		}
	});
}

function _charge_resume_moves(){ // F12
	$.ajax({ // A1
		url: "php/charge_resume_moves.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					$("#cont-resume-moves").html(respuesta);
				}
			}
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F12-A1) desconocido");
		}
	});
}

/****************************************************************************/
/************************** Configuration Functions *************************/
/****************************************************************************/
function _charge_ip(){
	$.ajax({
		url: "php/get_ip.php",
		success: function(respuesta){
			$("#ip").text(respuesta);
		}, error: function(errorThrown){
			jAlert("crimson", "Error: (Código: F9-A1) desconocido");
		}
	});
}

function _charge_data_admin(){
	$.ajax({
		url: "php/charge_data_admin.php",
		success: function(respuesta){
			var exp=respuesta.split(":");
			$("#txt-admin-name").val(exp[0]);
			$("#txt-admin-pass").val(exp[1]);
			$("#txt-email").val(exp[2]);
			$("#btn-act-admin").click(function(){
				var adminname=$("#txt-admin-name").val();
				var adminemai=$("#txt-email").val();
				var adminpass=$("#txt-admin-pass").val();
				if(adminname==="" || adminemai==="" || adminpass===""){
					jAlert("orange", "Se requiere un nombre y clave de administrador.");
					$("#txt-admin-name").focus();
				}else{
					$.ajax({
						url: "php/charge_data_admin.php",
						type: "post",
						data: $("#form-act-admin").serialize(),
						success: function(respuesta){
							if(respuesta===1){
								jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
							}else{
								if(parseInt(respuesta)===2){
									jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
								}else{
									jAlert("limegreen", respuesta);
								}
							}
						}, error: function(errorThrwon){
							jAlert("crimson", "Error: (Código: E20-A1) desconocido");
						}
					});
				}
			});
		}
	});
}

function _charge_list_users(){
	$.ajax({
		url: "php/charge_list_user.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					$("#txt-list-user").html(respuesta);
					$("#btn-del-user").click(function(){
						var user=$("#txt-list-user option:selected").text();
						if(user===""){
							jAlert("orange", "No hay empleados que eliminar.");
						}else{
							$.ajax({
								url: "php/charge_list_user.php",
								type: "post",
								data: $("#form-del-user").serialize(),
								success: function(respuesta){
									if(respuesta===1){
										jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
									}else{
										if(parseInt(respuesta)===2){
											jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
										}else{
											jAlert("limegreen", respuesta);
											_charge_list_users();

										}
									}
								}
							});
						}
					});
				}
			}
		}
	});
}

function _set_new_user(){
	$("#btn-reg-user").click(function() {
		var username=$("#txt-user-name").val();
		var userpass=$("#txt-user-pass").val();
		if(username==="" || userpass===""){
			jAlert("orange", "Se requiere un nombre y clave de usuario.");
			$("#txt-user-name").focus();
		}else{
			$.ajax({
				url: "php/set_new_user.php",
				type: "post",
				data: $("#form-reg-user").serialize(),
				success: function(respuesta){
					if(respuesta===1){
						jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
					}else{
						if(parseInt(respuesta)===2){
							jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
						}else{
							jAlert("limegreen", respuesta);
							_charge_list_users();
							$("#txt-user-name").val("");
							$("#txt-user-pass").val("");
						}
					}
				}
			});
		}
	});
}

/****************************************************************************/
/************************** Inventory Functions *************************/
/****************************************************************************/

function _set_new_binnacle(){
	$.ajax({
		url: "php/set_new_binnacle.php",
		success: function(respuesta){
			
		}
	});
}

function _validate_binnacle(){
	$.ajax({
		url: "php/validate_binnacle.php",
		success: function(respuesta){
			$("#cont-resp-invent").html(respuesta);
			$(".trBit").on('click', function(){
				var pass=$("#txt-pass-invent").val();
				var id=$(this).attr("id");
				if(pass===""){
					jAlert("Orange", "Debe ingresar la clave de usuario para continuar.");
				}else{
					$("#cont-panel-invent").slideUp();
					$("#cont-resp-invent").html("<p>"+pass+" "+id+"</p>");
				}
			});
		}
	});
}