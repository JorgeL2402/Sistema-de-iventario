<!-- El siguiente código muestra un formulario de inicio de sesión con una lógica de inicio de sesión -->

<!-- Contenedor principal con clases de diseño -->
<div class="main-container">

	<!-- Formulario de inicio de sesión -->
	<form class="box login" action="" method="POST" autocomplete="off">
		<!-- Título del formulario -->
		<h5 class="title is-5 has-text-centered is-uppercase">Sistema de inventario</h5>

		<!-- Campo de entrada para el usuario -->
		<div class="field">
			<label class="label">Usuario</label>
			<div class="control">
			    <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
			</div>
		</div>

		<!-- Campo de entrada para la clave -->
		<div class="field">
		  	<label class="label">Clave</label>
		  	<div class="control">
		    	<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
		  	</div>
		</div>

		<!-- Botón de inicio de sesión -->
		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded">Iniciar sesión</button>
		</p>

		<?php
			// Verificar si se enviaron los datos de inicio de sesión
			if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
				// Incluir archivos necesarios
				require_once "./php/main.php";
				require_once "./php/iniciar_sesion.php";
			}
		?>
	</form>
</div>
