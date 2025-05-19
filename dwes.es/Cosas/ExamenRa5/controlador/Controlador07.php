<?php
    namespace ExamenRa5\controlador;

    use Exception;
    use ExamenRa5\vista\VistaError07;

    class Controlador07 {
        protected array $peticiones;

        public function __construct() {
            $this->peticiones = [
                'buscarPedido' => [
                    'modelo' => "ExamenRa5\\modelo\\ModeloPedido07",
                    'vista' => "ExamenRa5\\vista\\VistaPedido07"
                ]
            ];
        }

        public function gestionarPeticion() {
            try {
                $request = isset($_POST['idp']) ? $_POST['idp'] : '';
                $request = filter_var($request, FILTER_SANITIZE_SPECIAL_CHARS);

                if (!class_exists($this->peticiones[$request]['modelo'])) {
                    throw new Exception("Modelo no encontrado");
                }

                $modelo_class = $this->peticiones[$request]['modelo'];

                if (!class_exists($this->peticiones[$request]['vista'])) {
                    throw new Exception("Vista no encontrada");
                }

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