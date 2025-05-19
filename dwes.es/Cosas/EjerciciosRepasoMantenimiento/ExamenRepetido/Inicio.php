<?php
    // Inicio de la sesion
    session_start();

    // Importo los archivos
    require_once('./includes/funciones.php');

    // Inicio el html
    inicio_html('Pantalla de Inicio', ['./estilos/formulario.css', './estilos/general.css']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <form action="Autenticar.php" method="post">
                <fieldset>
                    <legend>Login</legend>
                    <label for="id">Identificador</label>
                    <input type="text" name="id" id="id" size="6">

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre">
                </fieldset>
                <input type="submit" name="operacion" value="Login">
            </form>
        <?php
        fin_html();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cookie_params = session_get_cookie_params();

        setcookie(session_name(), "", time() - 1000, $cookie_params['path'], $cookie_params['domain'], $cookie_params['secure'], $cookie_params['httponly']);

        session_unset();

        session_destroy();

        session_start();
    }
?>