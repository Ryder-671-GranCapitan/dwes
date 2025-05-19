<?php

// Se muestran todos los datos: carrito con total del importe en
// formato tabla, usuario autenticado y datos del pago. Desde aquí se puede ir a la
// pantalla del carrito en la que se destruye la sesión actual y se comienza de nuevo

session_start(); // Asegúrate de iniciar la sesión

ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/articulos_carrito.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/jwt_include.php");

inicio_html('Resumen de Compra', ["/EjerciciosRepasoMantenimiento/styles/styles.css", "/EjerciciosRepasoMantenimiento/styles/formulario.css", "/EjerciciosRepasoMantenimiento/styles/tablas.css"]);

$payload = verificar_token($_COOKIE['token']);
$precio_total = 0;

echo "<h2>Resumen de Compra</h2>";
echo "<h3>Usuario: {$payload['correo']}</h3>";

echo "<table>
    <thead>
        <tr>
            <td>Artículos</td>
            <td>Cantidad</td>
            <td>Precio</td>
        </tr>
    </thead>
    <tbody>";

if (isset($_SESSION['articulos']) && is_array($_SESSION['articulos'])) {
    foreach ($_SESSION['articulos'] as $articulo_comprado) {
        echo "<tr>";
        $nombre_articulo = $articulos[$articulo_comprado['articulo']]['descripcion'];
        $precio_articulo = $articulos[$articulo_comprado['articulo']]['precio'];

        echo "<td>$nombre_articulo</td>";
        echo "<td>{$articulo_comprado['cantidad']}</td>";
        echo "<td>{$precio_articulo}$ x {$articulo_comprado['cantidad']}</td>";
        echo "</tr>";

        $precio_total += $precio_articulo * $articulo_comprado['cantidad'];
    }
} else {
    echo "<tr><td colspan='3'>No hay artículos en el carrito.</td></tr>";
}

echo "<tr>
    <td>Precio final</td>
    <td></td>
    <td>$precio_total</td>
</tr>
</tbody>
</table>";

echo "<h3>Datos del Pago</h3>";
echo "<p>Número de la tarjeta: {$_POST['num_tarjeta']}</p>";
echo "<p>Nombre del titular: {$_POST['titular']}</p>";
echo "<p>CVV: {$_POST['cvv']}</p>";

echo '<p><a href="/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/carrito.php">Volver al carrito</a></p>';
$datos_ob = ob_get_contents();
ob_flush();
fin_html();
?>