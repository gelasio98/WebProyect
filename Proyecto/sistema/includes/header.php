<?php 

	if (empty($_SESSION['active'])) {
	header('location: ../');
}

 ?>


<header>
		<div class="header">
			
			<h1>Monitoreo de Asistencias ITSAO</h1>
			<div class="optionsBar">
				<p>Acatlan de Osorio, <?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['nombre'].' '.$_SESSION['apellidos'].' - '.$_SESSION['perfil']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include "nav.php" ?>
	</header>