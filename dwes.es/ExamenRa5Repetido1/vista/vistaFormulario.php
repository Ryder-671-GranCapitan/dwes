<?php

// 4. hacer las vistas
// 4.1 hacer vista del formulario
namespace ExamenRa5Repetido1\vista;

require_once($_SERVER['DOCUMENT_ROOT'] . '/ExamenRa5Repetido1/util/Html.php');

use ExamenRa5Repetido1\util\Html;


Html::inicio('formulario', ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);

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

Html::fin()
?>