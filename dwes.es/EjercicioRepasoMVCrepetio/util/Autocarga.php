<?php
    // Espacio de nombres
    namespace util\seguridad;
    use Exception;

    // Instanciamos la clase Autocarga
    class Autocarga {
        // Metodo Autocarga
        public static function registra_autocarga() {
            try {
                spl_autoload_register(self::class . '::autocarga');
            } catch (Exception $e) {
                echo "El error es: {$e->getMessage()}";
            }

        }

        // Metodo genera_autocarga()
        public static function autocarga($clase) {
            // Invertimos los datos del string
            $clase_invertida = str_replace("\\", "/", $clase);

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/EjercicioRepasoMVCrepetio/" . $clase_invertida . ".php")){
                // Y si existe, hacemos el require_once de esa clase
                require_once($_SERVER['DOCUMENT_ROOT'] . "/EjercicioRepasoMVCrepetio/" . $clase_invertida . ".php");
            } else {
                throw new Exception("No se ha encontraado el documento");
            }
        }
    }
?>