<?php
    // Inicio sesion
    session_start();

    // Inicio ob
    ob_start();

    // Importo los archivos
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");

    // Inicio el html
    inicio_html("Pagina 1", ['../styles/styles.css']);

    // Gestiono las peticiones, primero el get que muestra el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <!-- Se manda a él mismo para que, cuando hagamos una petición post, haga la comprobación
            del post que realiza desde la misma página -->
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <fieldset>
                    <legend>Introduce la ruta de los archivos</legend>

                    <label for="ruta">Ruta del archivo</label>
                    <input type="text" id="ruta" name="ruta">
                </fieldset>
                <input type="submit" name="operacion" id="operacion">
            </form>
        <?php
    }
    // Ahora, comprobamos que se ha hecho un post a la misma página, para que realice lo que queramos
    // en este apartado.

    elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ruta = filter_input(INPUT_POST, 'ruta', FILTER_SANITIZE_SPECIAL_CHARS);
        define("RUTA_IMAGENES", $ruta);

        // Si es un directorio, alamaceno en sesiones el contenido y la ruta

        if (!is_readable($ruta)) {
            echo "<h3>No se tienen permisos para leer el archivo</h3>";
        }

        $_SESSION['archivos_directorio'] = scandir($ruta);
        $_SESSION['ruta_mandada'] = RUTA_IMAGENES;

        header("Location: /EjerciciosRepasoMantenimiento/Ejercicio2/02pantalla_imagenes.php");
    } else {
        echo "Esto no fufa manin";
    }

    $datos_ob = ob_get_contents();

    ob_flush();

    fin_html();
?>