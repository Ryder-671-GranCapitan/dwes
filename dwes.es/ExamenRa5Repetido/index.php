<?php
    namespace ExamenRa5Repetido;

    require_once($_SERVER['DOCUMENT_ROOT'] . '/ExamenRa5Repetido/util/Autocarga.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/ExamenRa5Repetido/controlador/Controlador07.php');

    use ExamenRa5Repetido\util\Autocarga;
    use ExamenRa5Repetido\controlador\Controlador07;

    Autocarga::registerAutoload();

    $controlador = new Controlador07;
    $controlador->gestionarPeticion();
?>