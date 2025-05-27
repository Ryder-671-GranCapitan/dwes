<?php
namespace ExamenRa5Repetido1\util;

use Exception;

// 0. autocarga
class Autocarga {
    public static function registerAutoload() : void {
        if (!spl_autoload_register(self::class . "::autoload")) {
            throw new Exception("ha ocurrido un problema mientras cargaba el script");   
        }
    }

    protected static function autoload(string $class) : void {
        $clean_class = str_replace('\\', '/', $class);
        $full_path = $_SERVER['DOCUMENT_ROOT']. "/{$clean_class}.php";
        if (!file_exists($full_path)) {
            throw new Exception("fichero no encontrado '$full_path'");
            
        }
        require_once($full_path);
    }
    
}
?>