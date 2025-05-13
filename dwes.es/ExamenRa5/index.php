<?php
    namespace ExamenRa5;

    require_once($_SERVER['DOCUMENT_ROOT'] . '/ExamenRa5/util/Autocarga.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/ExamenRa5/controlador/Controlador07.php');

    use ExamenRa5\util\Autocarga;
    use ExamenRa5\controlador\Controlador07;

    Autocarga::registerAutoload();

    $controlador = new Controlador07;
    $controlador->gestionarPeticion();
?>