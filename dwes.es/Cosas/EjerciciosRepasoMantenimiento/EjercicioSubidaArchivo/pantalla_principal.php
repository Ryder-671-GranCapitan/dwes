<?php
    // Inicio de sesión
    session_start();  

    // Iniciamos OB
    ob_start();

    // Importamos los includes
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");

    // Ahora si, iniciamos el html
    inicio_html("Ejercicio Por La Cara", ['../styles/styles.css']);

    // Manaejamos las peticiones, primero la get, donde mostramos el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <fieldset>
                    <legend>Selecciona el directorio desde el cual quieres subir el archivo</legend>
                    <label for="directorio">Directorio</label>
                    <input type="text" id="directorio" name="directorio">
                </fieldset>
                <input type="submit" id="operacion" name="operacion" value="Enviar">
            </form>
        <?php
    }

    elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Se comprueba los archivos
        if (isset($_POST['directorio'])) {
            $directorio = filter_input(INPUT_POST, 'directorio', FILTER_SANITIZE_SPECIAL_CHARS);

            // Se crea el directorio 
            define("DIRECTORIO_ARCHIVOS", $_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/$directorio");

            $_SESSION['lista_archivos'] = scandir(DIRECTORIO_ARCHIVOS);
            $_SESSION['route'] = DIRECTORIO_ARCHIVOS;

            // Se redirige a la siguiente pagina
            header("Location: /EjerciciosRepasoMantenimiento/EjercicioSubidaArchivo/pantalla_archivos.php");
        }
    }

    $output = ob_get_contents();

    ob_end_clean();

    echo $output;

    fin_html();

?>