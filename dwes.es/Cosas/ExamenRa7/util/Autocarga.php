<?php

namespace ExamenRa7\util;

use Exception;

class Autocarga {
    private const DS = DIRECTORY_SEPARATOR;
    
    public static function registraClase($clase) {
        // CAMBIAMOS LAS BARRAS
        $clase = str_replace("\\", "/", $clase);

        // CREAMOS LA RUTA COMPLETA DEL ARCHIVO DE CLASE
        $archivoClase = $_SERVER['DOCUMENT_ROOT'] . self::DS . $clase . ".php"; 
    
        // COMPROBAMOS QUE EXISTE Y LO INCLUIMOS
        if (file_exists($archivoClase)) {
            require_once($archivoClase);
        } else {
            throw new Exception("La clase $clase no existe");
        }
    }

    public static function autocarga() {
        spl_autoload_register([self::class, "registraClase"]);
    }
}