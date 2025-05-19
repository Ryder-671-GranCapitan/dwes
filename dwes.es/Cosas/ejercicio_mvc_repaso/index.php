<?php

    /*
        Instanciamos nuestras clases Autocarga y Controlador van aqui, para que cuando se 
        haga cualquier petición, se controle el require_once automaticamente desde "Autocarga" y se gestione la petición con el 
        "Controlador"
    */

// Debemos de importar los dos únicos archivos que no puede importar automáticamente la Autocarga
require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicio_repaso_mvc/util/Autocarga.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicio_repaso_mvc/mvc/controlador/Controlador.php");

// Llamar a la función que registra la autocarga y hace los require_once de nuestras clases
use util\Autocarga;
Autocarga::registra_autocarga();

// Llamar a la función gestiona_peticion() para que compruebe que las peticiones son las correctas
// y se hagan las peticiones y conexiones entre modelo y vista
use mvc\controlador\Controlador;
$controlador = new Controlador();
$controlador->gestiona_peticion();

// Y ahora, nos vamos con los modelos y con las vistas. Al lío
?>