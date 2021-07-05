<?php 
	session_start();
	if ($_SESSION['perfil'] !=1) {
		header("location: ./");
	}

include"../conexion.php";
	if (!empty($_POST)) {
		$alert='';
		if (empty($_POST['nombre']) ||empty($_POST['apellidos'])|| empty($_POST['perfil']) || empty($_POST['usuario']) || empty($_POST['pass'])) {
			
			$alert = '<p class="msg_error">Todos los campos son abligatorios.</p>';
		}else{
			

			$nombre = $_POST['nombre'];
			$apellidos = $_POST['apellidos'];
			$perfil = $_POST['perfil'];
			$user = $_POST['usuario'];
			$pass = md5($_POST['pass']);

			

			$query = mysqli_query($conection, "SELECT * FROM usuarios where usuario= '$user' ");
			mysqli_close($conection);
			$result = mysqli_fetch_array($query);

			if ($result >0) {
				$alert = '<p class="msg_error">El usuario ya existe.</p>';

			}else{
				$query_insert = mysqli_query($conection,"INSERT INTO usuarios (nombre,apellidos,perfil,usuario,pass) 
																	VALUES ('$nombre','$apellidos','$perfil','$user','$pass')");
				if ($query_insert) {
					$alert = '<p class="msg_save">Usuario creado correctamente</p>';
				}else{
					$alert = '<p class="msg_error">Error al crear usuario</p>';
				}
			}
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Registro de Alumno</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>

	<section id="container">
	
    
		<div class="form_register">
			<h1>Registrar Usuario</h1>
			
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre">

				<label for="apellidos">Apellidos</label>
				<input type="text" name="apellidos" id="apellidos" placeholder="Apellidos">

				<label for="perfil">Perfil</label>


				<?php 

					$query_per = mysqli_query($conection,"SELECT * from perfiles ");
					    mysqli_close($conection);
					$result_per = mysqli_num_rows($query_per);

					
				 ?>


				<select name="perfil" id="perfil" >

					<?php 

					if ($result_per >0) {
						while ($per = mysqli_fetch_array($query_per)) {
					
					?>		
						<option value="<?php echo $per["idperfil"]; ?>"><?php echo $per["perfil"]; ?></option>
					<?php
						}
					}

					 ?>

				</select>

				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario">

				<label for="pass">Contraseña</label>
				<input type="Password" name="pass" id="pass" placeholder="Contraseña">

				<input type="submit" value="Crear Usuario" class="btn_save">
			</form>
       
		</div>

		
		
	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>