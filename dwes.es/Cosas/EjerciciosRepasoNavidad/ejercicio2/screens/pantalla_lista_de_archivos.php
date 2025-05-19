<?php

// Hacemos uso de sesiones, asi que incializamos las sesiones
session_start();

// Traemos los directorios que nos hacen falta
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");

// Ahora, comprobamos que todo venga bien y la petición sea correcta no sin antes, inicializar html
inicio_html("Pantalla lista de archivos", ["../styles/formularios.css", "../styles/general.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['ruta']){
    ?>
        <h1>Bienvenido a pantalla lista de archivos</h1>

        <!-- Ahora, debemos de generar el formulario que recoge los datos de nuestro directorio
            teniendo en cuenta que debemos filtrar por tipo, solamente podemos tener tipo txt y
            csv -->
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>
                    Selecciona el fichero que necesitas
                </legend>
                <select name="fichero" id="fichero">
                <?php
                // Aqui, vamos a recorrer la ruta que ya tenemos y vamos a devolver los archivos
                // Así que voy a buscar como se hacía en la documentación.
                // Documentación usada: https://www.php.net/manual/es/function.scandir.php
                // Ahi tenemos como buscar los documentos dentro de un fichero.
                foreach(array_diff(scandir($_SESSION['ruta']), array('..', '.')) as $datos){
                    $extension = pathinfo($datos, PATHINFO_EXTENSION);
                    if ($extension == 'txt' || $extension == 'csv'){
                        echo "<option value='{$datos}'>" . $datos . '</option>';
                    }
                }
                ?>
                </select>
            </fieldset>
            <input type="submit" name="operacion" id="operacion">
        </form>
    <?php
}
// Comprobamos el posteo de datos y almacenamos los datos dentro de nuestro array de sesiones
else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Validamos el fichero recibido.
    $fichero = filter_input(INPUT_POST, 'fichero', FILTER_SANITIZE_SPECIAL_CHARS);

    // Ahora, almacenamos dentro de nuestra sesión el fichero
    $_SESSION['fichero'] = $fichero;

    // Fichero recibido y almacenado con exito, ahora debemos navegar a la ventana pantalla operación
    if ($fichero){
        echo "<h2>Fichero recibido con éxito</h2>";
        echo "<a href='pantalla_operacion.php'>Navega a la pantalla de operaciones</a>";
    } else {
        echo "<h2>No se ha recibido ningún fichero</h2>";
        echo "<a href=" . $SERVER['PHP_SELF'] .">Vuelve a intentarlo</a>";
    }
}
?>