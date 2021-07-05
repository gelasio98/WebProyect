<?php
	session_start();
	if ($_SESSION['perfil'] !=1) {
		header("location: ./");
	}

	include "../conexion.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php" ?>
	<title>Lista de Usuarios</title>
</head>
<body>
	
	<?php include "includes/header.php" ?>

	<section id="container">

		<?php 

			$busqueda = strtolower( $_REQUEST['busqueda']);
			if (empty($busqueda)) {
				header("location: lista_usuarios.php");
				mysqli_close($conection);
			}

		 ?>

		<h1>Lista de Usuarios</h1>
		<a href="registro_usuario.php" class="btn_new">Crear usuario</a>

			<form action="buscar_usuario.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
				<input type="submit" value="Buscar" class="btn_search">
			</form>
			<table>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Apellidos</th>
					<th>Perfil</th>
					<th>Usuario</th>
					<th>Acciones</th>
				</tr>

				<?php

                 $perfil ='';
                 if ($busqueda =='Administrador') {
                 	$perfil= " OR perfil LIKE '%1%' ";
                 } elseif ($busqueda=='Profesor') {
                 	$perfil= " OR perfil LIKE '%2%' ";
                 }elseif ($busqueda=='Padre/Tutor') {
                 	$perfil= " OR perfil LIKE '%3%' ";
                 }


					$sql_register = mysqli_query($conection,"SELECT COUNT(*) as total_registros FROM `usuarios` 
															WHERE (idusuario LIKE '%$busqueda%' or 
															nombre LIKE '%$busqueda%'OR 
															apellidos LIKE '%$busqueda%'  
															$perfil or 
															usuario LIKE '%$busqueda%')
														    AND estatus =1");
					$result_register = mysqli_fetch_array($sql_register);
					$total_registro = $result_register['total_registros'];

					$por_pagina =10;

					if (empty($_GET['pagina'])) {
						$pagina = 1;
					}else{
						$pagina = $_GET['pagina'];
					}

					$desde = ($pagina-1) * $por_pagina;
					$total_paginas = ceil($total_registro / $por_pagina);


					$query = mysqli_query($conection, "SELECT u.idusuario, u.nombre,u.apellidos,p.perfil,u.usuario FROM usuarios as u INNER JOIN perfiles as p on p.idperfil = u.perfil 
						WHERE
							 								(u.idusuario LIKE '%$busqueda%' or 
															u.nombre LIKE '%$busqueda%'OR 
															u.apellidos LIKE '%$busqueda%'or  
															p.perfil Like '%$busqueda%'or  
															u.usuario LIKE '%$busqueda%') AND

						 estatus =1 order by u.idusuario asc limit $desde,$por_pagina ");

					mysqli_close($conection);

					$result = mysqli_num_rows($query);

					if($result >0){

						while($data = mysqli_fetch_array($query)){

				?>
					<tr>
						<td><?php echo $data['idusuario'] ?></td>
						<td><?php echo $data['nombre'] ?></td>
						<td><?php echo $data['apellidos'] ?></td>
						<td><?php echo $data['perfil'] ?></td>
						<td><?php echo $data['usuario'] ?></td>
						<td>
							<a class="link_edit" href="editar_usuario.php?id=<?php echo $data['idusuario'] ?>">Editar</a>

							<?php if ($data['idusuario'] != 1) {
								# code...
							?>


							 
							|
							<a class="link_delete" href="eliminar_usuario_confirmar.php?id=<?php echo $data['idusuario'] ?>">Eliminar</a>
						<?php } ?>
						</td>

					</tr>

				<?php
						}

					}

				?>


				
				
			</table>

			<?php 

if ($total_registro !=0) {
				

			 ?>

			<div class="paginador">
				<ul>


					<?php 

					if ($pagina !=1) {
							

					 ?>

					<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
					<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>

				<?php 
					}
					for ($i=1; $i <=$total_paginas ; $i++) { 
						
						if ($i==$pagina) {
							echo '<li class="pageSelect">'.$i.'</li>';
						}else{
							echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
						}
						
					}
					if ($pagina !=$total_paginas) {
					

				 ?>
					
					<li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
					<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
					<?php 
				}
					 ?>
				</ul>
			</div>
<?php 
}
 ?>
		
	</section>

	<?php include "includes/footer.php" ?>

</body>
</html>