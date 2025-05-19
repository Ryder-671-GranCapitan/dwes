<?php
    namespace ExRA5;

    require_once($_SERVER['DOCUMENT_ROOT'] . '/ExRA5/util/Html.php');

    use ExRA5\util\Html;

    Html::inicio("Pedido", ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);
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