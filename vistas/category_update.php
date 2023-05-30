<!-- El siguiente código muestra un formulario para actualizar una categoría -->

<!-- Contenedor principal con clases de diseño -->
<div class="container is-fluid mb-6 has-text-centered">
    <!-- Título de la página -->
    <h1 class="title">Categorías</h1>
    <!-- Subtítulo de la página -->
    <h2 class="subtitle">Actualizar categoría</h2>
</div>

<!-- Contenedor secundario con clases de diseño -->
<div class="container pb-6 pt-6">
	<?php
		// Incluye el archivo btn_back.php
		include "./inc/btn_back.php";

		// Incluye el archivo main.php
		require_once "./php/main.php";

		// Obtiene el ID de la categoría a actualizar de la URL
		$id = (isset($_GET['category_id_up'])) ? $_GET['category_id_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando categoria ==*/
    	$check_categoria=conexion();
    	$check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$id'");

        // Verifica si la categoría existe en la base de datos
        if($check_categoria->rowCount()>0){
        	$datos=$check_categoria->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/categoria_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

		<!-- Campo oculto para almacenar el ID de la categoría -->
		<input type="hidden" name="categoria_id" value="<?php echo $datos['categoria_id']; ?>" required>

		<!-- Columnas para organizar los campos del formulario -->
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['categoria_nombre']; ?>">
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Ubicación</label>
				  	<input class="input" type="text" name="categoria_ubicacion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" value="<?php echo $datos['categoria_ubicacion']; ?>">
				</div>
		  	</div>
		</div>
		<!-- Botón para actualizar la categoría -->
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			// Incluye el archivo error_alert.php en caso de que la categoría no exista
			include "./inc/error_alert.php";
		}
		$check_categoria=null;
	?>
</div>
