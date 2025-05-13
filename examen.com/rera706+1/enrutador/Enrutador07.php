<?php
    namespace rera707\enrutador;

    use Exception;
    use rera707\modelo\RESTAlumno07;

    class Enrutador07 {
        private array $ruta;

        public function __construct() {
            $this->ruta = [
                "path" => "#^/alumnos$#",
                "verbo" => "GET",
                "modelo" => RESTAlumno07::class,
                "metodo" => "getAlumnos"
            ];
        }

        public function manejarPeticion() {
            // OBTENEMOS EL VERBO Y LA URL LIMPIA(/ARTICULOS?...)
            $verbo = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
            $url = filter_input(INPUT_SERVER, "REQUEST_URI", FILTER_SANITIZE_SPECIAL_CHARS);
            $urlLimpia = parse_url($url);
            
            // COMPROBAMOS QUE EL VERBO EXISTE EN EL ARRAY Y QUE LA URL CUMPLA EL REGEX DEL ARRAY
            if ($verbo == $this->ruta['verbo']) {
                if (preg_match($this->ruta['path'], $urlLimpia['path'])) {
                    header("Content-Type: application/json");

                    try {
                        // CLASE Y METODO QUE SE VA A INVOCAR
                        $clase = $this->ruta['modelo'];
                        $metodo = $this->ruta['metodo'];

                        $ormAlumno = new $clase();
                        $registrosDevueltos = $ormAlumno->$metodo();

                        // ENVIO LA RESPUESTA CON PETICION VALIDA
                        $respuesta['error'] = false;
                        $respuesta['datos'] = $registrosDevueltos;

                        echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        exit();
                    } catch (Exception $e) {
                        // ENVIO DE LA RESPUESTA CON LA PETICION FALLIDA
                        $respuesta['error'] = true;
                        $respuesta['datos'] = [
                            "code" => $e->getCode(),
                            "message" => $e->getMessage()
                        ];

                        echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        exit();
                    }
                }
            }
        }
    }
?>