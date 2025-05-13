<?php

/*
=================================== 
    REALIZADO POR DANIEL BUENO VÁZQUEZ
===================================
*/

/*
=================================== 
    AUTOCARGA DE CLASES
===================================
*/
require_once(__DIR__ . "/util/Autocarga.php");

use exra701\enrutador\Enrutador01;
use exra701\util\Autocarga;

Autocarga::autocarga();

/*
=================================== 
    INSTANCIAR Y CARGAR EL MÉTODO PARA PETICIONES
===================================
*/
$enrutador = new Enrutador01();
$enrutador->manejarPeticion();