<?php 
session_start();
	if ($_SESSION['perfil'] !=1) {
		header("location: ./");
	}
include"../conexion.php";

	if (!empty($_POST)) {
		$alert='';
		if (empty($_POST['nombre']) ||empty($_POST['apellidos'])|| empty($_POST['perfil']) || empty($_POST['usuario'])) {
			
			$alert = '<p class="msg_error">Todos los campos son abligatorios.</p>';
		}else{
			
			$idusuario = $_POST['idusuario'];

			$nombre = $_POST['nombre'];
			$apellidos = $_POST['apellidos'];
			$perfil = $_POST['perfil'];
			$user = $_POST['usuario'];
			$pass = md5($_POST['pass']);

			

			$query = mysqli_query($conection, "SELECT * FROM usuarios where (usuario = '$user' and idusuario != $idusuario)  ");

			$result = mysqli_fetch_array($query);

			if ($result >0) {
				$alert = '<p class="msg_error">El usuario ya existe.</p>';

			}else{

				if (empty($_POST['pass'])) {
					$sql_update = mysqli_query($conection,"UPDATE usuarios set nombre='$nombre', apellidos='$apellidos',perfil='$perfil',usuario='$user',pass='$pass' where idusuario= $idusuario");
				}else{
					$sql_update = mysqli_query($conection,"UPDATE usuarios set nombre='$nombre', apellidos='$apellidos',perfil='$perfil',usuario='$user',pass='$pass' where idusuario= $idusuario");

				}

				
				if ($sql_update) {
					$alert = '<p class="msg_save">Usuario actualizado correctamente</p>';
				}else{
					$alert = '<p class="msg_error">Error al actulizar usuario</p>';
				}
			}
		}
		mysqli_close($conection);
	}
//Mostrar datos

	if (empty($_GET['id'])) {
		header ("location: lista_usuarios.php");
	}
	$iduser = $_GET['id'];

	$sql = mysqli_query($conection,"SELECT u.idusuario, u.nombre,u.apellidos,u.usuario, (u.perfil) as idperfil, (p.perfil) as perfil FROM usuarios u INNER JOIN perfiles p on u.perfil = p.idperfil where idusuario = $iduser");
	mysqli_close($conection);

	$result_sql = mysqli_num_rows($sql);

	if ($result_sql==0) {
		header ("location: lista_usuarios.php");
	}else{
		$option ='';
		while ($data = mysqli_fetch_array($sql)) {
			$iduser = $data['idusuario'];
			$nombre = $data['nombre'];
			$apellidos= $data['apellidos'];
			$usuario = $data['usuario'];
			$idperfil = $data['idperfil'];
			$perfil = $data['perfil'];

			if ($idperfil ==1) {
				$option ='<option value="'.$idperfil.'"select>'.$perfil.'</option>';
			}else if ($idperfil ==2) {
				$option ='<option value="'.$idperfil.'"select>'.$perfil.'</option>';
			} else if ($idperfil ==3) {
				$option ='<option value="'.$idperfil.'"select>'.$perfil.'</option>';
			} 
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Proyecto Integrador</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>

	<section id="container">
	

		<div class="form_register">
			<h1>Actualizar Usuario</h1>
			
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">

				<input type="hidden" name="idusuario" value="<?php echo $iduser; ?>">

				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">

				<label for="apellidos">Apellidos</label>
				<input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php echo $apellidos; ?>">

				<label for="perfil">Perfil</label>


				<?php 
				include"../conexion.php";
					$query_per = mysqli_query($conection,"SELECT * from perfiles ");
					mysqli_close($conection);
					$result_per = mysqli_num_rows($query_per);

					
				 ?>


				<select name="perfil" id="perfil" class="notitemOne" >

					<?php 

					echo $option;

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
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">

				<label for="pass">Contraseña</label>
				<input type="Password" name="pass" id="pass" placeholder="Contraseña">

				<input type="submit" value="Actulizar Usuario" class="btn_save">
			</form>

		</div>

		
		
	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>