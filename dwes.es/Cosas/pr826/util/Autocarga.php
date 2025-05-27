<?php

namespace pr826\util;

use Exception;

class Autocarga {
    public static function registerAutoload(): void {
        if( !spl_autoload_register(self::class . "::autoload") ) {
            throw new Exception("An issue has occured while loading the script");
        }
    }
    
    protected static function autoload(string $class) {
        // Añadir depuración
        error_log("Intentando cargar la clase: $class");
        
        $clean_class = str_replace('\\', '/', $class);
        $full_path = $_SERVER['DOCUMENT_ROOT'] . "/{$clean_class}.php";
        
        error_log("Buscando en la ruta: $full_path");
        
        if( !file_exists($full_path) ){
            // Intentar con otra ruta posible
            $alternative_path = $_SERVER['DOCUMENT_ROOT'] . "/pr826/{$clean_class}.php";
            error_log("Ruta alternativa: $alternative_path");
            
            if( !file_exists($alternative_path) ){
                throw new Exception("archivo no encontrado '$full_path' or '$alternative_path'");
            }
            
            require_once($alternative_path);
            return;
        }
        
        require_once($full_path);
    }
}
?>