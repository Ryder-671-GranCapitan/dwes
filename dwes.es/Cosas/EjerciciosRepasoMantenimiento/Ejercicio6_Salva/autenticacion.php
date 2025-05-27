<?php


ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/includes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/Ejercicio6_Salva/articulos_carrito.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/jwt_include.php");


inicio_html('Ejercicio 6', ["/EjerciciosRepasoMantenimiento/styles/styles.css", "/EjerciciosRepasoMantenimiento/styles/formulario.css", "/EjerciciosRepasoMantenimiento/styles/tablas.css"]);
session_start();

if( $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_COOKIE['token']) ){
    $correo_saneado = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $correo = filter_var($correo_saneado, FILTER_VALIDATE_EMAIL);
    $contraseña = $_POST['contraseña'];

    if( autenticar($correo, $contraseña) ){
        $datos_usuario = ['correo'  => $correo];
        $jwt = generar_token($datos_usuario);
        setcookie('token', $jwt, time() + 30 * 60);
    }

    header('Location: /EjerciciosRepasoMantenimiento/Ejercicio6_Salva/carrito.php');
}
else{?>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
            <legend>Autenticación</legend>

            <label for="correo">Correo</label>
            <input type="email" name="correo">

            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña">
        </fieldset>
        <input type="submit" name="autenticar">
    </form>

<?php
}

$datos_ob = ob_get_contents();
ob_flush();

fin_html();


?>