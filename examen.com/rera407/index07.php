<?php
    // JAIME GRUESO MARTIN

    // Inicio la sesion
    session_start();

    // Importo los archivos necesarios
    require_once('./includes/funciones.php');

    inicio_html("Pagina Principal", ['./estilos/general.css', './estilos/formulario.css']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <form action="inicio07.php" method="POST">
                <fieldset>
                    <legend>Introduce tus credenciales</legend>

                    <label for="dni">Documento Nacional de Identidad</label>
                    <input type="text" id="dni" name="dni">

                    <label for="password">Clave</label>
                    <input type="password" name="password" id="password">
                </fieldset>
                <input type="submit" name="operacion" id="operacion" value="Login">
            </form>
        <?php
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cookie_params = session_get_cookie_params();

        setcookie(session_name(), '', time() - 1000, $cookie_params['path'], $cookie_params['domain'], $cookie_params['secure'], $cookie_params['httponly']);

        session_unset();

        session_destroy();

        session_start();
    }
?>