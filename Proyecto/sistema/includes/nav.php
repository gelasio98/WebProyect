<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
				
		<?php 
		if ($_SESSION['perfil'] ==1) {
	
		 ?>

				<li class="principal">
					<a href="#">Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php">Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
					</ul>
				</li>
		<?php 
		}
		 ?>
				<li class="principal">
					<a href="#">Alumnos</a>
					<ul>
						<li><a href="#">Nuevo Alumno</a></li>
						<li><a href="#">Lista de Alumnos</a></li>
					</ul>
				</li>
				

				
			</ul>
		</nav>