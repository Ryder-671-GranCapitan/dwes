<?php
    // JAIME GRUESO MARTIN
    namespace rera507;

    require_once($_SERVER['DOCUMENT_ROOT'] . '/rera507/util/Html.php');

    use rera507\util\Html;

    Html::inicio("Reseña", ['/rera507/estilos/formulario.css', '/rera507/estilos/general.css', '/rera507/estilos/tablas.css']);
    ?>
        <form action="index07.php" method="POST">
            <fieldset>
                <legend>Introduce la reseña</legend>
                <label for="nif">Nif</label>
                <input type="text" name="nif" id="nif">

                <label for="referencia">Referencia</label>
                <input type="text" name="referencia" id="referencia">

                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha">

                <label for="clasificacion">Clasificacion</label>
                <input type="number" name="clasificacion" id="clasiicacion">

                <label for="comentario">Comentario</label>
                <input type="text" name="comentario" id="comentario">
            </fieldset>
            <button name="idp" id="idp" value="insertarResena">Insertar</button>
        </form>
    <?php
    Html::fin();
?>