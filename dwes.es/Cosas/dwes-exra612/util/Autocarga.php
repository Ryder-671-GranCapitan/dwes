<?php
    namespace util;

    use Exception;

    class Autocarga {
        private const DIRECTORIO = "/dwes-exra612";

        public static function autoload_reg(){
            try {
                spl_autoload_register( Autocarga::class . "::autoload");
            }
            catch( Exception $e ) {
                echo $e;
                exit(0);
            }
        }

        protected static function autoload(string $class){

            $class = str_replace("\\", "/", $class ); // exra612\util\Html; => exra612/util/Html.php
            $ruta = $_SERVER['DOCUMENT_ROOT'] . Autocarga::DIRECTORIO;
            if( file_exists($ruta . "/$class.php") ) {
                require_once($ruta . "/$class.php"); // /var/www/examen.con/exra612/util/Html.php
            }
            else {
                throw new Exception("No existe el archivo $class.php");
            }
        }
    }
?>