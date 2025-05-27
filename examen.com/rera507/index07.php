<?php
    // JAIME GRUESO MARTIN
    namespace rera507;
    
    require_once($_SERVER['DOCUMENT_ROOT'] . '/rera507/util/Autocarga.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/rera507/controlador/Controlador07.php');

    use rera507\util\Autocarga;
    use rera507\controlador\Controlador07;

    Autocarga::registerAutoload();

    $controlador = new Controlador07;
    $controlador->gestionarPeticion();
?>