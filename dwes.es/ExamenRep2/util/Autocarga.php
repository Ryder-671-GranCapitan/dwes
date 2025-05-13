<?php

namespace ExamenRep2\util;

use Exception;

class Autocarga
{
    private const DS = DIRECTORY_SEPARATOR;
    public static function registraClase($clase)
    {
        $clase = str_replace('\\', '/', $clase);
        $archivoClase = $_SERVER['DOCUMENT_ROOT'] . self::DS . $clase . '.php';
        if (file_exists($archivoClase)) {
            require_once($archivoClase);
        } else {
            throw new Exception('La clase clase no existe');
        }
    }
    public static function autocarga()
    {
        spl_autoload_register([self::class, 'registraClase']);
    }
}
