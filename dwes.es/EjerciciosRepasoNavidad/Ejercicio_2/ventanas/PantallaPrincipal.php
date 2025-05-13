<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . '/EjerciciosRepasoNavidad/includes/funciones.php');

    inicio_html("Pantalla Principal", ["../styles/formulario.css", "../styles/general.css"]);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        session_unset();
        session_destroy();
        ?>
            <h1>SELECCIONA EL DIRECTORIO QUE QUIERES ABRIR</h1>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                <fieldset>
                    <legend>Selecciona uno de los directorios bro</legend>
                    <select name="directorio" id="directorio">
                        <?php
                            /*
                                Haciendo uso de glob() obtenemos las rutas dentro del directorio padre
                                Pero, ¿cómo funciona glob()?
                                ----------------------------
                                El método glob() necesita dos parámetros
                                {
                                    string $direccion_o_ruta,
                                    int $bandera
                                }
                                Y devuelve un array con los directorios. Un array de string con las rutas.

                                Las banderas de las que puede hacer uso son varias, (se encuentran en la documentación,
                                aquí os las dejo: https://www.php.net/manual/es/function.glob.php) pero de la que hago 
                                uso es de GLOB_ONLYDIR

                                ¿Qué hace GLOB_ONLYDIR?
                                -----------------------
                                Devuelve sólo las entradas de directorio que conciden con la $direccion_o_ruta
                                Es decir, devuelve un entero. Es como si contase cuantos directorios hay dentro
                                de $direccion_o_ruta y los devuelve.
                            */

                            foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/EjerciciosRepasoNavidad/*', GLOB_ONLYDIR) as $ruta) {
                                echo "<option value='{$ruta}'>" . basename($ruta) . "</option>";
                            }
                        ?>
                    </select>
                </fieldset>
                <input type="submit" name="operacion" id="operacion">
            </form>
        <?php
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ruta = filter_input(INPUT_POST, 'directorio', FILTER_SANITIZE_SPECIAL_CHARS);

        $_SESSION['ruta'] = $ruta;

        if ($ruta) {
            echo "<h1>Has seleccionado el directorio: " . basename($ruta) . "</h1>";
            echo "<a href='ListadoDirectorio.php'>Listado de directorio</a>";
        } else {
            echo "<h1>Debes seleccionar un directorio</h1>";
            echo "<a href='{$_SERVER['PHP_SELF']}'>Volver a intentar</a>";
        }
    }

    fin_html();
?>