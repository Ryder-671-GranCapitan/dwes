<?php
// Iniciamos la sesión para poder manejar variables de sesión
session_start();

// Inicia el almacenamiento en búfer de salida para controlar el flujo de salida del script
ob_start();

// Importamos las clases necesarias desde el espacio de nombres 'util'
use util\Html;
use util\Autocarga;

// Cargamos el archivo de la clase de autocarga para habilitar la carga automática de clases
require_once('./util/Autocarga.php');

// Registramos el sistema de autocarga
Autocarga::autoload_reg();

// Llamamos al método `inicio` de la clase `Html` para generar el encabezado del HTML
Html::inicio('Email', ['./estilos/formulario.css', './estilos/general.css']);

// Verificamos si el formulario fue enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenemos los parámetros de la cookie de sesión actual
    $parametros_cookie = session_get_cookie_params();

    // Obtenemos el nombre de la sesión
    $nombre_sesion = session_name();

    // Eliminamos la cookie de la sesión estableciendo su tiempo de expiración en el pasado
    setcookie(
        $nombre_sesion, '', time() - 1000, 
        $parametros_cookie['path'], 
        $parametros_cookie['domain'],  
        $parametros_cookie['secure'],  
        $parametros_cookie['httponly']
    );

    // Eliminamos todas las variables de sesión
    session_unset();

    // Destruimos la sesión actual
    session_destroy();

    // Reiniciamos la sesión después de destruir la anterior
    session_start();
}
?>

<!-- Formulario para ingresar el email y enviarlo a "02_registros.php" -->
<form action="02_registros.php" method="POST">
    <fieldset>
        <legend>Indicar email</legend>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </fieldset>
    <input type="submit" value="Enviar">
</form>

<?php
// Llamamos al método `fin()` de la clase `Html` para cerrar la estructura del HTML
Html::fin();

// Vaciamos el búfer de salida y enviamos el contenido al navegador
ob_flush();
?>
