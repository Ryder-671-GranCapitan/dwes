<?php
session_start();

require_once('./includes/funciones.php');
require_once('./includes/jwt_include.php');
require_once('./db.php');

if( !isset($_COOKIE['jwt']) ){
    header('Location: 01_login.php');
    exit(1);
}

$payload = verificar_token($_COOKIE['jwt']);

if( !$payload ){
    header('Location: 01_login.php');
    exit(1);
}

if( !isset($_SESSION['initial'], $_SESSION['entradas']) ){
    header('Location: 01_login.php');
    exit(1);
}

if( empty($_SESSION['entradas']) ){
    header('Location: 03_carrito.php');
    exit(1);
}

inicio_html('Carrito', ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);

echo "<h2>Identificador     :" . $payload['id'] . "</h2> <br>";
echo "<h2>Nombre            :" . $payload['nombre'] . "</h2> <br>";
echo "<h2>Fecha de comienzo :" . $_SESSION['initial'] . "</h2> <br>";
?>

    <table>
        <thead>
            <tr>
                <th>Titulo del espectaculo</th>
                <th>Fila</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $precio_total = 0;

            foreach($_SESSION['entradas'] as $key => $valor): 
                $titulo = $espectaculos[$key]['titulo'];        
                $fila = $valor;
                $precio = ($fila >= 1 && $fila <= 10) ? $espectaculos[$key]['fila1_10'] : $espectaculos[$key]['fila11_20'];
                $precio_total += $precio;
            ?>
            <tr>
                <td><?=$titulo?></td>
                <td><?=$fila?></td>
                <td><?=$precio?>€</td>
            </tr>
            <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">IMPORTE TOTAL</th>
                <th><?=$precio_total?>€</th>
            </tr>
        </tfoot>
    </table>
    <form action="01_login.php">
        <input type="hidden" name="origin_form" value="restart">
        <input type="submit" value="Empezar de nuevo">
    </form>
    <a href="./03_carrito.php">Anadir mas entradas</a>