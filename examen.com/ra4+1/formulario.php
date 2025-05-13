<?php
    namespace ExamenRa5Repetido;

    require_once($_SERVER['DOCUMENT_ROOT'] . '/ExamenRa5Repetido/util/Html.php');

    use ExamenRa5Repetido\util\Html;

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