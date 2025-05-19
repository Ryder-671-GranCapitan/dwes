<?php
    namespace ExamenRep2\enrutador;
    
    use Exception;
    use ExamenRep2\modelo\RESTAlumno07;
    
    class Enrutador07 {
        private array $ruta;
    
        public function __construct() {
            $this->ruta = [
                'path' => '#^/registro_asistente$#',
                'verbo' => "GET",
                'modelo' => RESTAlumno07::class,
                'metodo' => "getAlumnos"
            ];
        }
    
        public function manejarPeticion() {
            $verbo = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
            $url = filter_input(INPUT_SERVER, "REQUEST_URI", FILTER_SANITIZE_SPECIAL_CHARS);
            $urlLimpia = parse_url($url);
    
            if ($verbo == $this->ruta['verbo']) {
                if (preg_match($this->ruta['path'], $urlLimpia['path'])) {
                    header("Content-Type: application/json");
    
                    try {
                        $clase = $this->ruta['modelo'];
                        $metodo = $this->ruta['metodo'];
    
                        $orm = new $clase();
                        $registrosDevueltos = $orm->$metodo();
    
                        // Se envia la respuesta con la peticion valida
                        $respuesta['error'] = false;
                        $respuesta['datos'] = $registrosDevueltos;
    
                        echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        exit();
                    } catch (Exception $e) {
                        $respuesta['error'] = true;
                        $respuesta['datos'] = [
                            "code" => $e->getCode(),
                            "message" => $e->getMessage(),
                        ];
    
                        echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        exit();
                    }
                }
            }
        }
    }
?>
