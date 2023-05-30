<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Obtén todos los elementos con clase "navbar-burger"
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Verifica si existen elementos "navbar-burger"
        if ($navbarBurgers.length > 0) {

            // Agrega un evento de clic a cada uno de ellos
            $navbarBurgers.forEach( el => {
                el.addEventListener('click', () => {

                // Obtiene el destino del atributo "data-target"
                const target = el.dataset.target;
                const $target = document.getElementById(target);

                // Alterna la clase "is-active" tanto en "navbar-burger" como en "navbar-menu"
                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

                });
            });
        }
    });
</script>
<script src="./js/ajax.js"></script>
