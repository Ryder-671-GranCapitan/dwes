<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjercicioRepasoMVCrepetio/util/Autocarga.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjercicioRepasoMVCrepetio/mvc/Controlador/Controlador.php");
    // Instanciamos la autocarga, que generará una autocarga mediante el metodo genera_autocarga();
    use util\seguridad\Autocarga;
    use mvc\Controlador\Controlador;

    Autocarga::registra_autocarga();

    // Despues instanciaremos el controlador que se encargará de controlar las distsintas peticiones
    $controlador = new Controlador();
    $controlador->gestiona_peticion();
?>