<?php
    namespace ExRA5;

    require_once($_SERVER['DOCUMENT_ROOT'] . "/ExRA5/util/Autocarga.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/ExRA5/controlador/Controlador07.php");

    use ExRA5\controlador\Controlador07;
    use ExRA5\util\Autocarga;

    Autocarga::autoload_reg();

    $controlador = new Controlador07;
    $controlador->gestionarPeticion();
?>