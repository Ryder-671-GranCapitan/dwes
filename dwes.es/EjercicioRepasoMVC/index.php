<?php
    // Lo primeroq que se debe hacer es la Autocarga 
    
    // Ya ta creá

    // Aqui y ahora van las isntanciaciones de Autocarga y Controlador.


    // Se importan los dos unicos archivo que la Autocarga no puede
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjercicioRepasoMVC/util/Autocarga.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjercicioRepasoMVC/mvc/controlador/Controlador.php");

    // LLamar a la funcioon que registre al autocarga y hace los requiere_once de las clases
    use util\Autocarga;
    Autocarga::registra_autocarga();

    // Se llama a la funcion para que compruebe que las peticiones son correctas
    use mvc\controlador\Controlador;
    $controlador = new Controlador();
    $controlador->gestiona_peticion();

    // Y ahora, nos vamos a hacer los modelos y las vistas manin.


?>