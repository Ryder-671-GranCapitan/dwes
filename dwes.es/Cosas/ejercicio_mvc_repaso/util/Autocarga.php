<?php

// Vale, para comenzar con la autocarga, lo primero que tenemos que hacer es crear su espacio de nombres
namespace util;

use Exception;

// Okay, ahora. La clase Autocarga tiene dos métodos

// registra_autocarga() que se va a encargar de llamar al método autocarga() que es el otro método que también tiene esta clase

// Ahora ya, instanciamos su clase
class Autocarga{
    
    // Comenzamos por el registra_autocarga()
    public static function registra_autocarga(){
        try{
        // Llamamos al método spl_autoload_register() que se encargará de que la propia clase llame al método autocarga()
        // pero todo esto, dentro de un try catch para el manejo de los errores que pueda haber
        spl_autoload_register(self::class . '::autocarga');
        }catch(Exception $e){
            // Y aquí manejamos la excepción
            echo "El error es: " . $e->getMessage();
        }
    }

    // Y ahora, el método que nos falta
    // Este método es más complejo, pero se saca igual. Se va a encargar de devolver el require_once de la clase
    public static function autocarga($clase){

        // Vale, el método autocarga recibe una clase si no me equivoco, voy a mirar el ejemplo un seg. Efectivamente
        // El siguiente paso en el método, es instanciar una variable que va a identificar el directorio donde tiene que 
        // buscar la clase el método
        $direcotorio_de_busqueda = "/ejercicio_repaso_mvc";

        // Una vez lo tengamos, nosotros las clases o los "espacio de nombres de las clases" los tenemos de la siguiente manera:
        // mvc\\modelo\\M_Main
        // Pero no lo queremos así para realizar la búsqueda porque nos cascaría un error. Lo queremos de la siguiente manera:
        // mvc/modelo/M_Main
        // Entonces haremos uso del método str_replace() para reemplazar en el string que recibimos, la "$clase", los valores que
        // no queremos por los que queremos
        $clase = str_replace("\\", "/", $clase);

        // Una vez lo tengamos, tenemos que comprobar que exista, entonces vamos a hacer lo siguiente con un if
        // Buscamos un fichero que exista y se llame, por ejemplo, "mvc/modelo/M_Main.php" que eso está dentro de la variable "$clase"
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $direcotorio_de_busqueda . "/" . "$clase" . ".php")){
            // Y si existe, hacemos el require_once de esa clase
            require_once($_SERVER['DOCUMENT_ROOT'] . $direcotorio_de_busqueda . "/" . "$clase" . ".php");
        } else {
            // Que no existe, pues devolvemos una excepción
            throw new Exception("No existe el directorio ");
        }
    }

    // Bueno esta clase ya la tenemos finiquitada, asi que ahora, el siguiente paso es generar el Controlador.

    // ¿Para que sirve la clase Autocarga?
    // -----------------------------------
    // Básicamente lo que hace es devolver un require_once por cada clase que usemos en nuestra aplicación, así nos ahorramos
    // escribirlo 850 veces a lo largo de la aplicación
}


?>