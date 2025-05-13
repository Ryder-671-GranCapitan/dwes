<?php
// Nombre: JAIME GRUESO MARTIN
namespace util;
use Exception;

class Autocarga
{
    private const DIRECTORIO = '/rera607';
    public static function autoload_alu()
    {
        try {
            spl_autoload_register(Autocarga::class . '::autoload');
        } catch (Exception $e) {
            echo $e;
            exit(0);
        }
    }
    protected static function autoload(string $class)
    {
        $class = str_replace('\\', '/', $class);


        $ruta = $_SERVER['DOCUMENT_ROOT'] . Autocarga::DIRECTORIO;
        if (file_exists($ruta . "/$class.php")) {
            require_once($ruta . "/$class.php");
        } else {
            throw new Exception("No existe el archivo $class.php");
        }
    }
}
?>
