<?php

namespace pr826\enrutador;

use Exception;
use pr826\enrutador\Ruta;
use pr826\modelo\Modelo26;

class Enrutador {

    // Propiedad rutas de la clase Enrutador
    protected array $rutas;

    // Constructor de la clase donde inicializamos las rutas que se pueden hacer
    public function __construct(){
        $this->iniciarRutas();
    }

    // Función que inicializa el array de rutas con toda las rutas que hay disponibles
    private function iniciarRutas() {
        $this->rutas[] = new Ruta("POST", "#/actividad$#", Modelo26::class, "insert");
 

    }

    // Método que se encargará de manejar la petición
    public function despacha() {
        try{

            // Obtener el verbo de la petición usando el método obtenerVerboPeticion()
            $verbo = $this->obtenerVerboPeticion();

            // Obtenemos el path de la petición mediante el método obtenerPath()
            $path_peticion = $this->obtenerPath();

            // Obtenemos la ruta del array de rutas mediante el método obtenerRuta()
            // Y pasandole el verbo y el path_peticion anteriormente recogidos
            $ruta = $this->obtenerRuta($verbo, $path_peticion);

            // Ahora, invocamos el método del objeto almacenado en la ruta con el método ejecutaRuta()
            $datos = $this->ejecutaRuta($ruta, $path_peticion);

            // Comprobamos que haya sido exitosa la ejecución
            if ($datos['exito']) {
                header( $_SERVER['SERVER_PROTOCOL'] . " " . $datos['codigo']);
                header('Content-type: application/json');
                echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else {

                // Si no ha sido éxito, manejamos el error con el método gestionaError()
                $this->gestionaError($datos);
            }
        }catch( Exception $e){
            $this->gestionaError($e);
        }
    }

    // Método que obtiene el verbo de la peticion
    private function obtenerVerboPeticion() {

        // Obtengo el verbo
        $verbo = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);

        // Compruebo si el verbo es POST
        if ($verbo == 'POST'){
            if (isset($_POST['_method'])){

                // Recojo el verbo del array $_POST['_method']
                $verbo = strtoupper(filter_input(INPUT_POST, '_method', FILTER_SANITIZE_SPECIAL_CHARS));

                // Y compruebo si el método recogido no es ninguno de los que se encuentra en el array, devuelvo una excepción
                if (!in_array($verbo, ['PUT', 'DELETE', 'PATCH'])){
                    throw new Exception("Bad Request", 400);
                }
            }
        }

        // Devuelvo el verbo
        return $verbo;
    }

    // Método que obtiene la ruta de la peticion
    private function obtenerPath() {

        // Obtengo la ruta de la URI mandada
        $url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_SPECIAL_CHARS);

        // Parseo la petición obtenida
        $path_peticion = parse_url($url, PHP_URL_PATH);

        // Devuelvo la petición parseada
        return $path_peticion;
    }

    // Método que obtiene la ruta que tenga tanto el verbo como el path pasados por parámetro
    private function obtenerRuta(string $verbo, string $path_peticion) {
        foreach( $this->rutas as $ruta ){

            // Compruebo el verbo y la petición de cada ruta
            if ( $ruta->esIgual($verbo, $path_peticion)){
                return $ruta;
            }
        }

        // Si no ha encontrado ninguna, devuelvo un Bad Request con código 400
        throw new Exception("Bad Request $verbo $path_peticion", 400);
    }

    // Método que ejecuta el método de la clase que se encuentra en la ruta
    private function ejecutaRuta(Ruta $ruta, string $path_peticion){

        // Obtengo el modelo de la ruta
        $modelo = $ruta->getClase();

        // Obtengo el método
        $metodo = $ruta->getMetodo();

        // Obtengo los parametros
        $parametros = $this->obtenerParametros($ruta->getPath(), $path_peticion);

        // Instancio el modelo obtenido
        $objeto = new $modelo();

        // Mediante un callback, llamo a la funcion del objeto pasandole los parametros anteriormente recogidos
        $datos = call_user_func_array([$objeto, $metodo], $parametros);

        // Retorno la devolución de la petición
        return $datos;
    }

    // Método que obtiene los parametros de la ruta
    private function obtenerParametros($path_ruta, $path_peticion){

        // Compruebo que cumpla la expresión regular de el path_ruta, y si lo cumple, se almacena en $parametros
        if (preg_match($path_ruta, $path_peticion, $parametros)){

            // Quitamos la primera línea del array porque contiene la ruta
            array_shift($parametros);

            // Devolvemos los parametros
            return $parametros;
        }else {
            // Si no coincide, devolvemos un array vacío
            return [];
        }
    }

    // Método que gestiona los errores que puedan ocurrir en la ejecución
    private function gestionaError(mixed $error){
        
        // Comprobamos si el error es instancia de Exception, y si es así, devolvemos el error
        if ( $error instanceof Exception){
            header($_SERVER['SERVER_PROTOCOL'] . " " . $error->getCode() . " " . $error->getMessage());
            header("Content-type: application/json");
            echo json_encode($error);
        } else {
            // Y si no es de instancia Exception, será el array de datos que devolvemos en la ejecución
            header($_SERVER['SERVER_PROTOCOL'] . " " . $error['codigo']);
            header("Content-type: application/json");
            echo json_encode($error);
        }
    }
}

?>