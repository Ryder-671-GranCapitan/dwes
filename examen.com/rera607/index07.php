<?php
// Nombre: JAIME GRUESO MARTIN
    use util\Autocarga;
    use util\Html;

    session_start();
    ob_start();

    require_once('./util/Autocarga.php');

    Autocarga::autoload_alu();

    Html::inicio('DNi', ['./estilos/formulario.css', './estilos/general.css']);

    if( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion1'] == 'Cerrar Sesion' ){
        $cookieparams = session_get_cookie_params();
        $nombre_sesion = session_name();

        setcookie($nombre_sesion, '', time()-1000, $cookieparams['path'], $cookieparams['domain'], $cookieparams['secure'], $cookieparams['httponly']);

        session_unset();

        session_destroy();

        session_start();
    }
?>
    <form action="modificar07.php" method="post">
        <fieldset>
            <legend>Introduzca su DNI</legend>
            <label for="dni">DNI</label>
            <input type="text" name="dni" id="dni">
        </fieldset>
        <input type="submit" name="operacion" value="Mandar DNI">
    </form>
<?php
ob_flush();
?>