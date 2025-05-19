<?php
// Iniciamos la sesión
session_start();

// Recogemos los archivos necesarios
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");

// Iniciamos html
inicio_html("Pantalla resultado", ['../styles/formulario.css', '../styles/general.css']);
echo "<h1>Bienvenido a la pantalla resultado operación</h1>";
// Comprobamos la llamada
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['contenido']){
        echo "<h2>Este es el contenido que se ha obtenido tras la operacion que has realizado:</h2>";
        echo "<h2>{$_SESSION['contenido']}</h2>";
        echo "<a href='pantalla_principal.php'>Volver a empezar</a><br>";
        echo "<a href='pantalla_lista_de_archivos.php'>Volver a seleccionar archivo</a><br>";
        echo "<a href='pantalla_operacion.php'>Volver a seleccionar opción</a><br>";
}

?>