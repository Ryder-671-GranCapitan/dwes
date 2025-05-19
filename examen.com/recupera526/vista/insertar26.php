<?php

namespace recupera526\vista;

require_once($_SERVER['DOCUMENT_ROOT'] . '/recupera526/util/Html.php');

use recupera526\util\Html;

Html::inicio('añadir reseña', ['/recupera526/estilos/formulario.css', '/recupera526/estilos/general.css', '/recupera526/estilos/tablas.css'])

?>

<form action="index26.php" method="post">

</form>
<fieldset>
    <legend>Introduce la reseña</legend>
    <label for="nif">Nif</label>
    <input type="text" name="nif" id="nif" required>

    <label for="referencia">Referencia</label>
    <input type="text" name="referencia" id="referencia" required>

    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" id="fecha" required>

    <label for="clasificacion">Clasificacion</label>
    <input type="number" name="clasificacion" id="clasiicacion">

    <label for="comentario">Comentario</label>
    <input type="text" name="comentario" id="comentario">
</fieldset>

<button name="idp" id="idp" value="insertarResena"> insertar </button>

<?php
Html::fin();
?>