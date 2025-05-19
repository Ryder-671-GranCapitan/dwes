<?php
    // Inicio sesion
    session_start();

    // Inicio ob
    ob_start();

    // Importo los archivos
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");

    // Inicio el html
    inicio_html("Pagina 3", ['../styles/styles.css']);

    echo "<h3>Imagenes seleccionadas</h3>";

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['imagenes_seleccionadas']) {
        foreach ($_SESSION['imagenes_seleccionadas'] as $valor) {
            $ruta = $_SESSION['ruta_mandada'] . "/$valor";
            echo "<img src='$ruta'><br>";
        }
        echo "<a href=/EjerciciosMantenimientoEstado/Ejercicio2/02pantalla_inicial.php>Volver al inicio</a>";
    }

    $datos_ob = ob_get_contents();
    ob_flush();

    fin_html();
?>