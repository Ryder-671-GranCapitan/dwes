<?php
session_start();
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicio1_mantenimiento_estado/includes/functions.php");
inicio_html("Imagenes seleccionadas", ['../styles/styles.css']);

echo "<h3>Imagenes seleccionadas</h3>";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SESSION['imagenes_seleccionadas'])) {
    foreach ($_SESSION['imagenes_seleccionadas'] as $value) {
        // Construir la ruta completa
        $ruta = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['ruta_mandada'] . "/$value";
        
        // Verificar si el archivo existe
        if (file_exists($ruta)) {
            // Crear una ruta relativa para la etiqueta <img>
            $ruta_relativa = $_SESSION['ruta_mandada'] . "/$value";
            echo "<img src='$ruta_relativa' alt='Imagen seleccionada' style='max-width: 300px; height: auto;'><br>";
        } else {
            echo "Imagen no encontrada: $value<br>";
        }
    }
    echo "<a href='/ejercicio1_mantenimiento_estado/ejercicio2/02pantalla_inicial.php'>Volver al inicio</a>";
} else {
    echo "No se seleccionaron imágenes o hubo un problema al procesar la solicitud.<br>";
    echo "<a href='/ejercicio1_mantenimiento_estado/ejercicio2/02pantalla_inicial.php'>Volver al inicio</a>";
}

$header_ob = ob_get_contents();
ob_flush();
fin_html();
?>
