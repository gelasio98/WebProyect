
<?php 

	$alert ='';
session_start();
if (!empty($_SESSION['active'])) {
	header('location: sistema/');
}else{


	if (!empty($_POST)) {

		if (empty($_POST['usuario']) || empty($_POST['pass'])) {
			$alert = 'Ingrese su usuario y contraseña';
		}else{
			require "conexion.php";

			$user = mysqli_real_escape_string($conection, $_POST['usuario']);
			$pass = md5( mysqli_real_escape_string($conection, $_POST['pass']));

			$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuario = '$user' and pass= '$pass'");

			mysqli_close($conection);
			
			$result = mysqli_num_rows($query);

			if ($result >0) {
				$data = mysqli_fetch_array($query);
				
				$_SESSION['active'] = true;
				$_SESSION['iduser'] = $data['idusuario'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['apellidos'] = $data['apellidos'];
				$_SESSION['perfil'] = $data['perfil'];
				$_SESSION['usuario'] = $data['usuario'];
				$_SESSION['pass'] = $data['pass'];

				header('location: sistema/');

			}else{
				$alert = 'Usuario o contraseña incorrectos';
				session_destroy();
				
			}
		}
	}
}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login | Sistema </title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	 <section id="container">

		 <form action=" " method="post">
		 	
		 	<h3>Iniciar Sesión</h3>
		 	<img src="img/logo.png">

		 	<input type="text" name="usuario" placeholder="Usuario">
		 	<input type="password" name="pass" placeholder="Contraseña" >
		 	<div class="alert"> <?php echo isset($alert)? $alert: '';?> </div> 
		 	<input type="submit" value =" INGRESAR">

		 </form>
	 </section>
</body>
</html>