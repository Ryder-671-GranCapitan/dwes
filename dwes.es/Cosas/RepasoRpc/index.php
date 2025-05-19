<?php
    // Ejemplo sencillito con JSON RPC

    // Primero Autocarga

    // Segundo modelo

    // Tercero controlador

    use RepasoRpc\controlador\JSONControlador;
    use RepasoRpc\util\Autocarga;

    require_once("./util/Autocarga.php");

    Autocarga::gestiona_autocarga();

    $json_controlador = new JSONControlador();
    $json_controlador -> gestionarPeticion();
?>