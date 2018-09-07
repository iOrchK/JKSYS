$(document).ready(function(){
	_validate_soft_activated();
	cont=0;

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
				alert(respuesta);
			}
		});
	}
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

	$("#btn-unlock").click(function(){
		var pass=$("#txt-pass").val();
		if(pass===""){
			$("#msg").html("Es necesario escribir el código válido.");
		}else{
			$.ajax({
				url: "php/validate_user_blocked.php",
				type: "post",
				data: $("#form-unlock").serialize(),
				success: function(respuesta){
					if(respuesta==="Passinv"){
						var msg="Evite el bloqueo total del programa y pagar un costo total de $1750 por ingresar códigos de liberación inválidos. <br>Contacte al desarrollador";
						cont=cont+1;
						if(cont===1){ $("#msg").html("1ra advertencia: "+msg); }
						if(cont===2){ $("#msg").html("2da advertencia: "+msg); }
						if(cont===3){ $("#msg").html("Última advertencia: "+msg); }
						if(cont===4){ 
							$("#txt-pass").prop("disabled", true);
							$("#btn-unlock").prop("disabled", true);
							msg="Programa completamente bloqueado por ingresar códigos de liberación inválidos. Tras notificarle 3 veces, reincidió. Costo por desbloqueo más penalización $1750. Contacte al desarrollador.";
							$("#msg").html(msg);
						}
					}else{
						if(respuesta==="Activado"){
							$("#msg").text("Acceso permitido");
							$("#color").attr("color", "green");
							$("#txt-pass").prop("disabled", true);
							$("#btn-unlock").prop("disabled", true);
							window.location.href="home.html";
						}
					}
				}
			});
		}
	});
});

function _validate_soft_activated(){ //F5
	$.ajax({ // A1
		url: "php/validate_user_blocked.php",
		success: function(respuesta){
			if(respuesta===1){
				jAlert("crimson", "Error! (código: DB) contacte al desarrollador.");
			}else{
				if(parseInt(respuesta)===2){
					jAlert("crimson", "Error! (código: MYSQLI) contacte al desarrollador.");
				}else{
					if(respuesta==="Activado"){
						window.location.href="home.html";
					}
				}
			}
		}
	});
}