<div class="container pb-6 pt-6 has-text-right mt-4">
    <?php
        // Incluir el archivo main.php que contiene la configuración y funciones principales
        require_once "./php/main.php";

        // Eliminar producto
        if (isset($_GET['product_id_del'])) {
            require_once "./php/producto_eliminar.php";
        }

        if (!isset($_GET['page'])) {
            $pagina = 1;
        } else {
            $pagina = (int)$_GET['page'];
            if ($pagina <= 1) {
                $pagina = 1;
            }
        }

        $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

        $pagina = limpiar_cadena($pagina);
        $url = "index.php?vista=product_list&page=";

        // Agregar el enlace para generar el PDF con estilo profesional
        echo '<div style="margin-bottom: 20px;"><a href="pdf.php" target="_blank" style="padding: 10px 20px; background-color: #A0D8B3; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none;">Generar Reporte</a></div>';

        $registros = 15;
        $busqueda = "";

        // Paginador producto
        require_once "./php/producto_lista.php";
    ?>
</div>
