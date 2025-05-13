<?php
    namespace ExamenRa5Repetido\controlador;

    use Exception;
    use ExamenRa5Repetido\vista\VistaError07;

    class Controlador07 {
        // Creo el array de peticiones
        protected array $peticiones;

        // Meto dentro del array de peticiones la/las peticiones
        public function __construct() {
            $this->peticiones = [
                'buscarPedido' => [
                    'modelo' => 'ExamenRa5Repetido\\modelo\\ModeloPedido07',
                    'vista' => 'ExamenRa5Repetido\\vista\\VistaPedido07'
                ]
            ];
        }

        public function gestionarPeticion() {
            try {
                // Esto viene del formulario
                $request = isset($_POST['idp']) ? $_POST['idp'] : '';
                $request = filter_var($request, FILTER_SANITIZE_SPECIAL_CHARS);

                if (!class_exists($this->peticiones[$request]['modelo'])) {
                    throw new Exception("El modelo no es encontrado");
                }

                // Estoy pillando el modelo de la peticion
                $modelo_class = $this->peticiones[$request]['modelo'];

                if (!class_exists($this->peticiones[$request]['vista'])) {
                    throw new Exception("La vista no es encontrada");
                }

                // Estoy pillando la vista
                $vista_class = $this->peticiones[$request]['vista'];

                $instancia_modelo = new $modelo_class();
                $data = $instancia_modelo->procesaPeticion();

                $instancia_vista = new $vista_class();
                $instancia_vista->enviarSalida($data);
            } catch (Exception $e) {
                $instancia_error = new VistaError07();
                $instancia_error->muestraError($e);
            }
        }
    }
?>