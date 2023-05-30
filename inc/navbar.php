<nav class="navbar" role="navigation" aria-label="main navigation">
    <!-- Barra de navegación principal -->
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home">
        <img src="./img/logo china.png" width="65" height="28">
        </a>

        <!-- Botón de menú para dispositivos móviles -->
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <!-- Dropdown de Usuarios -->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>

                <div class="navbar-dropdown">
                    <a href="index.php?vista=user_new" class="navbar-item">Nuevo usuario</a>
                    <a href="index.php?vista=user_list" class="navbar-item">Lista de usuarios</a>
                    <a href="index.php?vista=user_search" class="navbar-item">Buscar usuarios</a>
                </div>
            </div>

            <!-- Dropdown de Categorías -->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Categorías</a>

                <div class="navbar-dropdown">
                    <a href="index.php?vista=category_new" class="navbar-item">Nueva categoria</a>
                    <a href="index.php?vista=category_list" class="navbar-item">Lista de categorias</a>
                    <a href="index.php?vista=category_search" class="navbar-item">Buscar categorias</a>
                </div>
            </div>

            <!-- Dropdown de Productos -->
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Productos</a>

                <div class="navbar-dropdown">
                    <a href="index.php?vista=product_new" class="navbar-item">Nuevo producto</a>
                    <a href="index.php?vista=product_list" class="navbar-item">Lista de productos</a>
                    <a href="index.php?vista=product_category" class="navbar-item">Productos por categoría</a>
                    <a href="index.php?vista=product_search" class="navbar-item">Buscar</a>
                </div>
            </div>
        </div>

        <!-- Elementos de la barra de navegación en el extremo derecho -->
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <!-- Enlace a la página de actualización de cuenta del usuario -->
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
                        Mi cuenta
                    </a>

                    <!-- Enlace para cerrar sesión -->
                    <a href="index.php?vista=logout" class="button is-link is-rounded">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
