<?php
    namespace rera707\controlador;

    use Exception;

    class Controlador07 {
        
        private array $peticion;

        // METODOS

        public function validarPeticion(): void {
            if (!isset($this->peticion["jsonrpc"]) || $this->peticion["jsonrpc"] != "2.0") {
                throw new Exception("El campo jsonrpc es obligatorio y debe tener el valor 2.0");
            }
            if (!isset($this->peticion["method"])) {
                throw new Exception("El campo method es obligatorio");
            }
            if (!isset($this->peticion["params"])) {
                throw new Exception("El campo params es obligatorio");
            }
            if (!is_array($this->peticion["params"])) {
                throw new Exception("El campo params debe ser un array");
            }
        }

        public function obtenerDatosPeticion(): void {
            $datosPeticion = file_get_contents("php://input");
            $this->peticion = json_decode($datosPeticion, true);
        }

        
        public function identificarClaseMetodo(): array {
            $claseMetodo = explode(".", $this->peticion["method"]);
            if (count($claseMetodo) != 2) {
                throw new Exception("El campo method debe tener el formato Clase.metodo");
            }
            $clase = "rera707\modelo\\" . ucfirst($claseMetodo[0]) . "07";
            if (!class_exists($clase)) {
                throw new Exception("La clase $clase no existe");
            }
            $metodo = $claseMetodo[1];
            if (!method_exists($clase, $metodo)) {
                throw new Exception("El metodo $metodo no existe en la clase $clase");
            }
            return [$clase, $metodo];
        }

        public function invocarMetodo(array $claseMetodo): array {
            $clase = new $claseMetodo[0]();
            $metodo = $claseMetodo[1];
            return $clase->$metodo($this->peticion["params"]);
        }

        public function enviarRespuesta(array $respuesta): void {
            header("Content-Type: application/json");
            echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit();
        }

        public function manejarPeticion(): void {
            try {
                $this->obtenerDatosPeticion();
                $this->validarPeticion();
                $claseMetodo = $this->identificarClaseMetodo();
                $respuesta = $this->invocarMetodo($claseMetodo);
                $this->enviarRespuesta($respuesta);
            } catch (Exception $e) {
                $respuesta = [
                    "jsonrpc" => "2.0",
                    "error" => [
                        "code" => $e->getCode(),
                        "message" => $e->getMessage()
                    ],
                    "id" => $this->peticion["id"]
                ];
                $this->enviarRespuesta($respuesta);
            }
        }
    }
?>