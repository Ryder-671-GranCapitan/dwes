<?php
    namespace pr807\enrutador;

    use Exception;
    use pr807\enrutador\Ruta;
    use pr807\modelo\Modelo07;

    class Enrutador07 {
        // Propiedad rutas de la clase enrutador
        protected array $rutas;

        public function __construct() {
            $this->iniciaRutas();
        }

        // Funcion que inicializxa el array de rutas con todas las rutas que hay disponibles
        private function iniciaRutas() {
            $this->rutas[] = new Ruta("POST", "#/forma_envio$#", Modelo07::class, "insert");
        }

        // Metodo que se encargará de manejar las peticiones
        public function despacha() {
            try {
                // Obtener el verbo de la peticion
                $verbo = $this->obtenerVerboPeticion();

                // Obtenemos el path de la peticion
                $path_peticion = $this->obtenerRuta();

                // Obtenemos la ruta
                $ruta = $this->buscarRuta($verbo, $path_peticion);

                // se  invoca el metodo del objeto almacenado en la ruta con el metodo ejecutaRuat
                $datos = $this->ejecutaRuta($ruta, $path_peticion);

                // Comprobamos si ha tenido exito
                if ($datos['exito']) {
                    header($_SERVER['SERVER_PROTOCOL'] . " " . $datos['codigo']);
                    header("Content-type: application/json");
                    echo json_encode($datos);
                } else {
                    $this->gestionaError($datos);
                }
            } catch (Exception $e) {
                $this->gestionaError($e);
            }
        }

        // Metodo que obtiene el verbo de la peticion
        private function obtenerVerboPeticion() {
            // Obtener el verbo
            $verbo = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);

            // Compurebo que el verbo es post
            if ($verbo == 'POST') {
                if (isset($_POST['_method'])) {
                    $verbo = strtoupper(filter_input(INPUT_POST, '_method', FILTER_SANITIZE_SPECIAL_CHARS));
                    if (!in_array($verbo, ['PUT', 'DELETE', 'PATCH'])) {
                        throw new Exception("Bad Request", 400);
                    }
                }
            }
            // Devuelvo el verbo
            return $verbo;
        }

        // Creo el metodo que obtiene la ruta de la peticion
        private function obtenerRuta() {
            $url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_SPECIAL_CHARS);

            $path_peticion = parse_url($url, PHP_URL_PATH);
            return $path_peticion;
        }

        // Metodo buscarRuta() (obtiene la ruta que tenga el verbo como el path pasados por parametros)
        private function buscarRuta(string $verbo, string $path_peticion) {
            foreach ($this->rutas as $ruta) {
                if ($ruta->esIgual($verbo, $path_peticion)) {
                    return $ruta;
                }
            }
            throw new Exception("Bad Request $verbo $path_peticion", 400);
        }

        // Metodo que ejecuta el metodo de la clase que se encuentra en la ruta
        private function ejecutaRuta(Ruta $ruta, string $path_peticion) {
            // obtengo el modelo de la ruta
            $modelo = $ruta->getClase();

            // Obtengo el metodo
            $metodo = $ruta->getMetodo();

            // Obtengo los parametros
            $params = $this->obtenerParametros($ruta->getPath(), $path_peticion);

            // Instancia el modelo obtenido
            $objeto = new $modelo();

            // Mediante un callback, llamo a la funcion del objeto pasandole los parametros recogidos
            $datos = call_user_func_array([$objeto, $metodo], $params);

            // Devuelvo la devolucion de la peticion
            return $datos;
        }

        // Metodso que obtiene los parametros de la ruta
        private function obtenerParametros($path_ruta, $path_peticion) {
            // Compruebo que cumpla la expresion regular de path_ruta y si lo cumple se almacena en params
            if (preg_match($path_ruta, $path_peticion, $params)) {
                array_shift($params);

                return $params;
            } else {
                return [];
            }
        }

        // Metodo qeue gestiona los errores que puedan ocurrir en la ejecucion
        private function gestionaError(mixed $error) {
            // Comprobamos que el erroor sea intancia de Exception, si es asi devolvemos el error
            if ($error instanceof Exception) {
                header($_SERVER['SERVER_PROTOCOL'] . " " . $error->getCode() . " " . $error->getMessage());
                header("Content-type: application/json");
                echo json_encode(($error));
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . " " . $error['codigo']);
                header("Content-type: application/json");
                echo json_encode(($error));
            }
        }
    } 
?>