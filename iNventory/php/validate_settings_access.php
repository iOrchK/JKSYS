<?php
	include ("functions.php");
	$pass=$_POST["txt-pass"];
	$username="";

	$sql="SELECT name FROM user WHERE type='admin' AND pass='$pass' AND estado='Alta'";
	$mysqli=_con_db("localhost", "root", "<3JK271015", "db_inventory");
	if($resultado=_val_con($sql, $mysqli)){
		$rows=mysqli_num_rows($resultado);
		if($rows===0){
			echo "Passinv";
			$mysqli->close();
			exit;
		}else{
			if($registro=mysqli_fetch_row($resultado)){
				$username=$registro[0];
			}
			echo '<h3>Configuración</h3>
					<p><b>Bienvenido '.$username.'</b></p>
					<p id="ip"></p>
					<fieldset>
						<legend>Datos del administrador</legend>
						<form id="form-act-admin">
							<label>Nombre (max. 10 caracteres)</label>
							<input type="text" id="txt-admin-name" name="txt-admin-name" placeholder="Admin" maxlength="10"><br>
							<label>Correo Gmail (No hotmail u otros)</label>
							<input type="text" id="txt-email" name="txt-email" placeholder="ejemplo@gmail.com" maxlength="30"><br>
							<label>Clave del administrador (max. 25 caract.)</label>
							<input type="text" id="txt-admin-pass" name="txt-admin-pass" placeholder="Contraseña visible" maxlength="25"><br>
							<input type="button" id="btn-act-admin" class="float-button">
						</form>
					</fieldset>
					<fieldset>
						<legend>Registrar empleado</legend>
						<form id="form-reg-user">
							<label>Nombre (max. 10 caracteres)</label>
							<input type="text" id="txt-user-name" name="txt-user-name" placeholder="Nombre"><br>
							<label>Clave del empleado (max. 25 caract.)</label>
							<input type="text" id="txt-user-pass" name="txt-user-pass" placeholder="Password"><br>
							<input type="button" id="btn-reg-user" class="float-button">
						</form>
					</fieldset>
					<fieldset>
						<legend>Eliminar empleado</legend>
						<form id="form-del-user">							
							<label>Selecciona el empleado</label>
							<select id="txt-list-user" name="txt-list-user">
									
							</select><br>
							<input type="button" id="btn-del-user" class="float-button">
						</form>
					</fieldset>
					<p id="time-cont"></p>';
			$mysqli->close();
			exit;
		}
	}
?>