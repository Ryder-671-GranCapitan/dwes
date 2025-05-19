<?php
// Espacio de nombres para organizar la clase dentro del namespace 'util'
namespace util;

// Importación de la clase Exception para manejar errores
use Exception;

/**
 * Clase Autocarga
 * Implementa la autocarga de clases de manera dinámica.
 */
class Autocarga {
    // Define el directorio base donde se buscarán los archivos de clases
    private const DIRECTORIO = "/Act02BBDD";

    /**
     * Método estático para registrar la función de autoload
     */
    public static function autoload_reg() {
        try {
            // Registra la función de autocarga usando spl_autoload_register
            spl_autoload_register( Autocarga::class . '::autoload');
        } catch (Exception $e) {
            // Captura excepciones y muestra el error, luego termina la ejecución
            echo $e;
            exit(0);
        }
    }

    /*
     * Método protegido que implementa la lógica de autocarga de clases.
     * Se ejecuta automáticamente cuando se intenta usar una clase no cargada.
     *
     * @param string $class - Nombre de la clase a cargar.
     * @throws Exception - Lanza una excepción si el archivo de la clase no existe.
     */
    protected static function autoload(string $class) {
        // Reemplaza las barras invertidas '\' con barras normales '/' en el nombre de la clase
        $class = str_replace('\\', '/', $class);
        
        // Construye la ruta completa del archivo basado en el directorio raíz del servidor
        $ruta = $_SERVER['DOCUMENT_ROOT'] . Autocarga::DIRECTORIO;

        // Verifica si el archivo de la clase existe en la ruta construida
        if (file_exists($ruta . "/$class.php")) {
            // Si el archivo existe, lo carga
            require_once($ruta . "/$class.php");
        } else {
            // Si el archivo no existe, lanza una excepción
            throw new Exception("No existe el archivo $class.php");
        }
    }
}
?>
