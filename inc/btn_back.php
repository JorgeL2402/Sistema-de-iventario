<p class="has-text-right pt-4 pb-4">
    <a href="#" class="button is-link is-rounded btn-back"><- Regresar atrás</a>
</p>

<script type="text/javascript">
    // Obtén el elemento del botón de regreso mediante la clase CSS ".btn-back"
    let btn_back = document.querySelector(".btn-back");

    // Agrega un event listener al botón de regreso para escuchar el evento 'click'
    btn_back.addEventListener('click', function(e){
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace
        window.history.back(); // Navega hacia atrás en la historia del navegador
    });
</script>
