<?php
    // Espacio de nombres
    namespace RepasoRpc\util;

    use Exception;

    // Clase Autocarga
    class Autocarga {
        // Metodo que gestiona la Autocarga
        public static function gestiona_autocarga(){
            try {
                spl_autoload_register(self::class . "::autocarga");
            } catch (Exception $e) {
                return ($e->getMessage());
            }
        }

        // Metodo autocraga
        public static function autocarga($clase) {
            // Cambiar las \\ a nuestra clase por /
            $clase = str_replace("\\", "/", $clase);

            // Ahora, creamos la ruta donde tiene que buscar los elementos
            $ruta = "/";

            // Comporbamos  que esxiste el fichero
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "{$ruta}" . "{$clase}.php")) {
                require_once($_SERVER['DOCUMENT_ROOT'] . "{$ruta}" . "{$clase}.php");
            } else {
                throw new Exception("No existe el fichero " . $_SERVER['DOCUMENT_ROOT'] . "{$ruta}" . "{$clase}.php");
            }
        }
    }

?>