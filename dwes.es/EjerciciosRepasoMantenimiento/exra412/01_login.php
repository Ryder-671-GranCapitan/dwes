<?php

session_start();


if( $_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_POST['origin_form']) 
    && $_POST['origin_form'] == 'restart' ){

    $cookie_params = session_get_cookie_params();
    
    setcookie(session_name(), '', time() - 1000, $cookie_params['path'], $cookie_params['domain'], $cookie_params['secure'], $cookie_params['httponly']);

    session_unset();

    session_destroy();

    session_start();
}

require_once('./includes/funciones.php');
inicio_html('Login', ['./estilos/formulario.css', './estilos/general.css']);

?>

<form action="02_auth.php" method="POST">
    <fieldset>
        <legend>Login</legend>
        <input type="hidden" name="origin_form" value="login">

        <label for="id">Identificador</label>
        <input type="text" name="id" id="id" size="6">

        <label for="password">Contrasena</label>
        <input type="password" name="password" id="password">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">
    </fieldset>
    <input type="submit" value="Login" name="operacion">
</form>

<?php fin_html() ?>
