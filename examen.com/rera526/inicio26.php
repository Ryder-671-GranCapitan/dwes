<?php
namespace rera526;


require_once($_SERVER['DOCUMENT_ROOT']. '/rera526/util/Html.php');


use rera526\util\Html;

Html::inicio(
    'lista envios',
    [
        '/rera526/estilos/general.css',
        '/rera526/estilos/formulario.css',
        '/rera526/estilos/tablas.css',
    ]
);
?>
<h1>introduce una fecha</h1>
<form action="index26.php" method="post">
    <fieldset>
        <legend>pedidos</legend>

        <label for="fecha">fecha</label>
        <input type="date" name="fecha" id="fecha">
    </fieldset>

    <button name="idp" id="idp" value="listarEnvios">listarEnvios</button>

</form>



<?php
Html::fin();
?>