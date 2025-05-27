<?php
    session_start();

    require_once('./includes/funciones.php');
    inicio_html('Pantalla Inicial', ['./estilos/formulario.css', './estilos/general.css']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <form action="PantallaAutenticar.php" method="POST">
                <fieldset>
                    <legend>Login</legend>
                    <label for="id">Identificador</label>
                    <input type="text" name="id" id="id" size="6">

                    <label for="password">Contrasena</label>
                    <input type="password" name="password" id="password">

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre">
                </fieldset>
                <input type="submit" value="Login" name="operacion">
            </form>
        <?php
        fin_html();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cookie_params = session_get_cookie_params(); // Pillo los prametros de la cookie

        // Aquí se está eliminando la cookie de sesión. session_name() obtiene el nombre de la cookie de sesión, y setcookie se usa para establecer una cookie 
        // con ese nombre, pero con un tiempo de expiración en el pasado (time() - 1000), lo que efectivamente la elimina. Los otros parámetros 
        // (path, domain, secure, httponly) se configuran usando los valores obtenidos anteriormente.
        setcookie(session_name(), "", time() - 1000, $cookie_params['path'], $cookie_params['domain'], $cookie_params['secure'], $cookie_params['httponly']);

        // Esta línea elimina todas las variables de sesión actuales. No destruye la sesión en sí, solo elimina los datos almacenados en ella.
        session_unset();

        // Aquí se destruye la sesión actual. Esto elimina todos los datos asociados con la sesión y la marca como destruida.
        session_destroy();

        // Finalmente, se inicia una nueva sesión. Esto es útil si deseas empezar una nueva sesión después de haber destruido la anterior.
        session_start();
    }
?>