<?php
// Yahya Limouni | 12

namespace exra512\controlador;

use Exception;
use exra512\vistas\VistaError12;

class Controlador12 {
    protected array $peticiones;

    public function __construct() {
        $this->peticiones = [
            "buscarPedido" => [
                'modelo' => "exra512\\modelos\\ModeloPedido12",
                'vista' => "exra512\\vistas\\VistaPedido12"
            ]
        ]; 
    }

    public function gestonarPeticion() {
        try {
            $request = isset($_POST['idp']) ? $_POST['idp'] : '';
            $request = filter_var($request, FILTER_SANITIZE_SPECIAL_CHARS);

            if( !class_exists($this->peticiones[$request]['modelo']) ) {
                throw new Exception("Unfound model");
            }

            $model_class = $this->peticiones[$request]['modelo'];

            if( !class_exists($this->peticiones[$request]['vista']) ) {
                throw new Exception("Unfound view");
            }

            $view_class = $this->peticiones[$request]['vista'];

            $model_instance = new $model_class();
            $data = $model_instance->procesarPeticion();

            $view_instance = new $view_class();
            $view_instance->enviarSalida($data);

        }catch(Exception $e) {
            $viewError_instance = new VistaError12();
            $viewError_instance->muestraError($e);
        }
    }

}
?>