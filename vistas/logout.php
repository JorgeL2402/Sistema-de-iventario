<?php
	// Destruir la sesión actual
	session_destroy();
	
	// Verificar si los encabezados ya se han enviado
	if(headers_sent()){
		// Si los encabezados ya se han enviado, redireccionar mediante JavaScript
		echo "<script> window.location.href='index.php?vista=login'; </script>";
	}else{
		// Si los encabezados no se han enviado, redireccionar mediante encabezado de ubicación
		header("Location: index.php?vista=login");
	}
?>
