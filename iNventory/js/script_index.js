$(document).ready(function() {
	var cont=0;
	_validate_bloq();

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
	/************************ End Protection Navigator ************************/

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

	$("#btn-activate").click(function() {
		var pass=$("#txt-pass").val();
		if(pass===""){
			$("#msg").html("Es necesario escribir el código válido.");
		}else{
			$.ajax({
				url: "php/validate_serial.php",
				type: "post",
				data: $("#form-session").serialize(),
				success: function(respuesta){
					if(parseInt(respuesta)===1){ 
						$("#msg").text("Error! (código: DB) contacte al desarrollador.");
					}else{
						if(parseInt(respuesta)===2){
							$("#msg").text("Error! (código: MYSQLI) contacte al desarrollador.");
						}else{
							if(respuesta==="Invalido"){
								var msg="Evite el bloqueo total del programa y pagar un costo total de $2500 por ingresar claves de renovación inválidas. Contacte al desarrollador.";
								cont=cont+1;
								if(cont===1){ $("#msg").text("1ra advertencia: "+msg); }
								if(cont===2){ $("#msg").text("2da advertencia: "+msg); }
								if(cont===3){ $("#msg").text("Última advertencia: "+msg); }
								if(cont===4){ _bloq_soft(); }
							}else{
								if(respuesta==="Vigente"){
									$("#msg").text("Renovación exitosa");
									$("#color").attr("color", "green");
									$("#txt-pass").prop("disabled", true);
									$("#btn-continuar").prop("disabled", true);
									window.location.href="home.html";
								}
							}
						}
					}
					
				}, error: function(errorThrown){

				}
			});
		}
	});
});

function _validate_bloq(){ // F1
	$.ajax({ // A1 - Validar si el programa está bloqueado
		url: "php/validate_bloq.php",
		success: function(respuesta){
			if(respuesta===1){
				$("#msg").text("Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					$("#msg").text("Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					if(respuesta==="Desactivado"){
						$("#txt-pass").prop("disabled", true);
						$("#btn-activate").prop("disabled", true);
						$("#msg").text("Ha bloqueado el programa por ingresar claves inválidas. Costo por reactivación incluida la penalización por reincidencia de códigos inválidos tras notificar 3 veces al usuario $2500. Contacte al desarrollador.");
					}else{
						if(respuesta==="Caducado"){
							$("#msg").text("El programa caducó. Contacte al desarrollador.");
						}else{
							if(respuesta==="Activado"){
								window.location.href="home.html";
							}
						}
					}
				}
			}
		}, error: function(errorThrown){
			alert("Error: (Código: F1-A1) desconocido");
		}
	});
}

function _bloq_soft(){ // F2
	$.ajax({ // A1
		url: "php/bloq_soft.php",
		success: function(respuesta){
			$("#txt-pass").prop("disabled", true);
			$("#btn-continuar").prop("disabled", true);
			msg="Programa totalmente desactivado debido a que el usuario introdujo 3 claves de activación invalidas. Tras notificarle 3 veces sobre el bloqueo, reincidió. Contacte al desarrollador para la reactivación del programa por un costo de $2500 incluido la renovación y la penalización.";
			$("#msg").text(msg);
		}, error: function(errorThrown){
			alert("Error: (Código: F2-A1) desconocido");
		}
	});
}