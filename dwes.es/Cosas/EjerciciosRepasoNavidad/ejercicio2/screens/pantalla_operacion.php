<?php
// Iniciamos la sesión
session_start();

use EjerciciosRepasoNavidad\ejercicio2\classes\Archivo\Archivo;

// Vale, ahora ya tenemos los datos en la sesión, ruta y fichero
// Vamos a generar el formulario con las distintas opciones con las que trabajar en el fichero
// y a generar una clase Fichero

// Importamos los datos necesarios
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/ejercicio2/classes/Archivo.php");

// Comprobamos nuestro tipo de petición y que los datos estén presentes en la sesión
// Iniciamos nuestro html
inicio_html("Pantalla operación", ['../styles/formulario.css', '../styles/general.css']);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['ruta'] && $_SESSION['fichero']){
    echo "<h1>Bienvenido a la pantalla operación</h1>";
    $ruta_completa = $_SESSION['ruta'] . "/" . $_SESSION['fichero'];
    echo "<h1>$ruta_completa</h1>";
    ?>
    <!-- Generamos nuestro formulario -->
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <fieldset>
            <legend>¿Qué desea hacer con el documento?</legend>
            <label for="texto_introducir">Introducir texto</label>
            <input type="text" name="texto_introducir" id="texto_introducir">
            <label for="introducir"></label>
            <button type="submit" name="operacion" value="operacion">Introducir texto</button>
            <label for="numero_lineas">Número líneas documento</label>
            <input type="number" name="numero_lineas" id="numero_lineas" placeholder="3">
            <label for="leer_documento"></label>
            <button type="submit" name="operacion" value="operacion2">Leer documento</button>
        </fieldset>
    </form>
    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Validamos los datos
    $texto = filter_input(INPUT_POST, 'texto_introducir', FILTER_SANITIZE_SPECIAL_CHARS);
    $operacion = filter_input(INPUT_POST, 'operacion', FILTER_DEFAULT);

    // Valores del archivo
    $ruta_completa = $_SESSION['ruta'] . "/" . $_SESSION['fichero'];
    $archivo = basename($ruta_completa);
    $tipo_mime = mime_content_type($ruta_completa);

    // Creamos un nuevo Archivo
    $archivo = new Archivo($archivo, $ruta_completa, $tipo_mime);

    // Almacenamos el archivo en el array de ficheros
    $_FILES['archivo'] = $archivo;

    // Si pulsa en escribir documento
    if ($archivo){
        if ($operacion == 'operacion'){
            $archivo->escribirArchivo($ruta_completa, $texto);
            $_SESSION['contenido'] = $archivo->leerLineasArchivo($ruta_completa);
            echo "<a href='pantalla_resultado_operacion.php'>Ir a pantalla resultado operacion</a>";
        } else if ($operacion == 'operacion2'){
            $_SESSION['contenido'] = $archivo->leerLineasArchivo($ruta_completa);
            echo "<a href='pantalla_resultado_operacion.php'>Ir a pantalla resultado operacion</a>";
        }
    }else {
        // Si no se crea correctamente
        echo "<h2>El archivo no se ha generado</h2>";
        echo "<a href=" . $_SERVER['PHP_SELF'] . ">Vuelve a intentarlo</a>";
    }
}

?>