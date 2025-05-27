<?php
    // JAIME GRUESO MARTIN

    namespace rera507\util;

    use Exception;

    class Autocarga {
        public static function registerAutoload(): void {
            if( !spl_autoload_register(self::class . "::autoload") ) {
                throw new Exception("Ha ocurrido un error");
            }
        }
        
        protected static function autoload(string $class) {
            $clean_class = str_replace('\\', '/', $class);
            $full_path = $_SERVER['DOCUMENT_ROOT'] . "/{$clean_class}.php";

            if( !file_exists($full_path) ){
                throw new Exception("No se ha encontrado '$full_path'");
            }
            require_once($full_path);
        }
    }
?>