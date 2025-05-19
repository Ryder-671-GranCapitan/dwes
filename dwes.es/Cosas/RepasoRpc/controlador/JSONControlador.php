<?php
    namespace RepasoRpc\controlador;

use Exception;

    class JSONControlador {
        // Propiedad privada que contiene la ruta de la carpeta modelo donde se tien que buscar 
        // los modelos que nos pasen por el cuerpo de la peticion

        private string $ruta_modelos = "RepasoRpc\\modelo\\";

        // Una vez tengamos la ruta, tenemos que hacer la primera funcion de esta clase, que se encargará de validar
        // la peticion

        // Si nos acordamos, una peticion tiene un cuerpo, pues en esta funcion tenemos que validar que venga el jsonrpc, 
        // que venga el method y que el jsonrpc sea igal a 2.0
        private function validaPeticion($peticion) {
            return (isset($peticion['jsonrpc'], $peticion['method'])) && $peticion['jsonrpc'] == '2.0';
        }

        // Ahora, debemos de realizar la siguiente funcion que lo que hará será enviar la respuesta

        // Esta funcion recibe un id, un resultado y un error
        private function enviaRespuesta($id, $resultado, $error) {
            // Como antes habremos comrobado si la peticion es valida, jsonrpc es 2.0, asi que se lo asignamos a una
            // nueva cariable $respuesta que es lo que devolvemos
            $respuesta['jsonrpc'] = '2.0';

            // Ahora comprobamos que $resultado y $error no sean nulos para asignarle su valor a $respuesta['result'] y $respuesta['error']
            if ($resultado) {
                $respuesta['result'] = $resultado;
            }

            if ($error) {
                $respuesta['error'] = $error;
            }

            $respuesta['id'] = $id;

            // Mandamos ahora la respuesta

            // Lo primero que debemos hacer es insertar la cabecera
            header("Content-Type: application/json");

            // Devolvemos el json mas bonico
            echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // Creamos la funcion que se encargará de separar el modelo del metodo que viene en nuestro cuerpo
        private function modeloMetodo($peticion) : array {
            if (!strpos($peticion['method'], ".")) {
                // Enviamos un respuesta con la funcion de antes
                $this->enviaRespuesta(null, null, ['code' => -32600, 'message' => 'Invalid method. Request Class.Method']);
            }

            // Y si no da error porque nos han enviado el metodo devolvemos un explode que es lo mismo que un array
            return explode(".", $peticion['method']);
        }

        // Y ya, para terminar, la funcion que manejará la petición
        public function gestionarPeticion() {
            // lo primero que debemos hacer en esta funcion es obtener el cuerpo desde php://input
            $cuerpo = file_get_contents("php://input");

            // Cuando tengamos el cuerpo, cogemos la peticion del cuerpo

            // Mediante json_decode creamos un array asociativo (gracias al true que pasamos como parametro), y el
            // primer parametro es el json que viene en el cuerpo
            $peticion = json_decode($cuerpo, true);

            // Ahora, debermos de comprobar que la peticion es valida 
            if (!$this->validaPeticion($peticion)) {
                $this->enviaRespuesta(null, null, ['code' => -32603, 'message' => 'Invalid Request']);
            }

            // Ahora, cogeremos el id de la peticion porque lo usaremos para mandar respuestas si no viene el id,
            // le asigno null
            $id = $peticion['id'] ?? null;

            // Ahora debemos continuar cogiendo el modelo y el objeto mediante destructuring
            [$modelo, $metodo] = $this->modeloMetodo($peticion);

            // Le concatenamos al modelo la direccion quye teniamos en nuestra clase
            $modeloObjeto = $this->ruta_modelos . $modelo;

            // Introducimos dentro de un try para poder mandar los datos con la funcion enviaPeticion()
            try {
                
                // Lo primero es comprobar que existe tanto la clase comeo el metodo y si existe, debermeos de hacer un instacncia de este objeto
                // y llamar al metodo con un callback
                if (class_exists($modeloObjeto) && method_exists($modeloObjeto, $metodo)) {
                    // Creamos el objeto
                    $objeto = new $modeloObjeto();

                    // Ahora recogemos los parametros de nuestra oeticion para pasarlo al metodo cuando lo llamemos en el callback
                    $params = $peticion['params'];

                    // Llmamos al callback
                    // A este hay que pasarle el objeto, el metodo que vamos a usar y despues como segundo parametro, los
                    // parametros recogidos del cuerpo
                    $resultado = call_user_func_array([$objeto, $metodo], $params);

                    // Y cuando lo hayamos hecho, devolvemos el resultado con el metodo enviaRespuesta()
                    $this->enviaRespuesta($id, $resultado, null);
                
                } else {
                    // Si no existe la clase o el metodo, se nos vendría aqui y deberemos de añadir otra respuesta con error
                    $this->enviaRespuesta($id, null, ['code' => -32603, 'message' => 'Invalid Request']);
                }
                
            } catch (Exception $e) {
                // Al igual que al capturar la excepcion
                $this->enviaRespuesta($id, null, ['code' => $e->getCode(), 'message' => "No existe la clave", 'data' => $e->getMessage()]);
            }
        }
    }

    // Y solo queda probal
?>