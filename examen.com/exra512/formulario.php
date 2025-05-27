<?php
// Yahya Limouni | 12

namespace exra512;

require_once($_SERVER['DOCUMENT_ROOT'] . "/exra512/util/Html.php");

use exra512\util\Html;

Html::inicio("Busar Pedido", ['/exra512/estilos/formulario.css', '/exra512/estilos/tablas.css', '/exra512/estilos/general.css'])

?>
<h1>Buscar Pedido</h1>
<form action="index.php" method="POST">
    <fieldset>
        <label for="npedido">Numero de pedido</label>
        <input type="number" name="npedido" id="npedido">
    </fieldset>
    <button name="idp" id="idp" value="buscarPedido">Buscar</button>
</form>

<?php

Html::fin();
?>