<?php

ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/includes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/articulos_carrito.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/jwt_include.php");

inicio_html('Ejercicio 6', ["/EjerciciosRepasoMantenimiento/styles/styles.css", "/EjerciciosRepasoMantenimiento/styles/formulario.css", "/EjerciciosRepasoMantenimiento/styles/tablas.css"]);
session_start();

if( !isset($_SESSION['articulos'])){
    header('Location: /EjerciciosRepasoMantenimiento/Ejercicio6_Salva/carrito.php');
}
elseif( !verificar_token($_COOKIE['token']) || !isset($_COOKIE['token']) ){
    header('Location: /EjerciciosRepasoMantenimiento/Ejercicio6_Salva/autenticacion.php');
}

?>

<table>
    <thead>
        <tr>
            <td>Articulos</td>
            <td>Cantidad</td>
            <td>Precio</td>
        </tr>
    </thead>
    <tbody>
        <?php

$precio_total = 0;
foreach( $_SESSION['articulos'] as $articulo_comprado ){
    echo "<tr>";
    $nombre_articulo = $articulos[$articulo_comprado['articulo']]['descripcion'];
    $precio_articulo = $articulos[$articulo_comprado['articulo']]['precio'];

    echo "<td>$nombre_articulo</td>";
    echo "<td>{$articulo_comprado['cantidad']}</td>";
    echo "<td>{$precio_articulo}$ x {$articulo_comprado['cantidad']}</td>";
    echo "</tr>";

    $precio_articulo = $precio_articulo * $articulo_comprado['cantidad'];
    $precio_total += $precio_articulo;
}
echo "<tr>";
echo "<td>Precio final</td>";
echo "<td></td>";
echo "<td>$precio_total</td>";
echo "</tr>";
echo "</tbody>";
echo "</table>";

    ?>

    <form action="/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/final.php" method="post">
        <fieldset>
            <legend>Datos para la compra</legend>
            
            <label for="num_tarjeta">Número de la tarjeta bancaria</label>
            <input type="number" name="num_tarjeta" >

            <label for="titular">Nombre del titular de la tarjeta</label>
            <input type="text" name="titular">

            <label for="cvv">CVV</label>
            <input type="number" name="cvv">
        </fieldset>
        <input type="submit" value="entregar">  
    </form>

    <?php




?>

<?php

$datos_ob = ob_get_contents();
ob_flush();

fin_html();


?>