
<?php 
	session_start();
	if ($_SESSION['perfil'] !=1) {
		header("location: ./");
	}

	include "../conexion.php";

	if (!empty($_POST)) {
		
		if ($_POST['idusuario'] ==1) {
			header("location: lista_usuarios.php");
			mysqli_close($conection);
			exit;
		}
		$idusuario = $_POST['idusuario'];

		//$query_delete = mysqli_query($conection,"DELETE FROM usuarios WHERE idusuario = $idusuario");
		$query_delete = mysqli_query($conection,"UPDATE usuarios SET estatus =0 WHERE idusuario = $idusuario");
		mysqli_close($conection);

		if ($query_delete) {
			header("location: lista_usuarios.php");
		}else{
		echo  "Error al eliminar datos";
		}
	

	}
	if (empty($_REQUEST['id']) || $_REQUEST['id']==1 ) 
	{
		header("location: lista_usuarios.php");
		mysqli_close($conection);
	}else{

		$idusuario = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT u.nombre, u.usuario, p.perfil FROM usuarios u INNER JOIN perfiles p on u.perfil = p.idperfil WHERE u.idusuario = $idusuario");

		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if ($result >0) {

			while ( $data = mysqli_fetch_array($query) ) {
				
				$nombre = $data['nombre'];
				$usuario = $data['usuario'];
				$perfil = $data['perfil'];
			}
		}else{
			header("location: lista_usuarios.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Proyecto Integrador</title>
</head>
<body>

	<?php include "includes/header.php" ;?>
	
	<section id="container">
		
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Usuario: <span><?php echo $usuario; ?></span></p>
			<p>Perfil: <span><?php echo $perfil; ?></span></p>

			<form method="POST" action="">
				<input type="hidden" name="idusuario" value=" <?php echo $idusuario; ?>">
				<a href="lista_usuarios.php" class="calcelar" style="width: 124px;
				 	background: #478ba2;
				 	color: #fff;
				 	display: inline-block;
				 	padding: 5px;
				 	border-radius: 5px;
				 	cursor:pointer;
				 	margin: 15px;">Cancelar</a>
				<input type="submit" value="Aceptar" class="aceptar" style="width: 124px;
				 	background: #478ba2;
				 	color: #fff;
				 	display: inline-block;
				 	padding: 5px;
				 	border-radius: 5px;
				 	cursor:pointer;
				 	margin: 15px;">

			</form>
		</div>
	</section>


	<?php include "includes/footer.php"; ?>
</body>
</html>