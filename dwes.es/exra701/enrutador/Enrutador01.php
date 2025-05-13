<?php

/*
=================================== 
    REALIZADO POR DANIEL BUENO VÁZQUEZ
===================================
*/

namespace exra701\enrutador;

use Exception;
use exra701\modelo\RESTAlumno;

class Enrutador01
{
    private array $ruta;

    public function __construct()
    {
        $this->ruta = [
            "path" => "#^/alumnos#",
            "verbo" => "GET",
            "modelo" => RESTAlumno::class,
            "metodo" => "getAlumnos"
        ];
    }

    public function manejarPeticion()
    {
        // OBTENEMOS EL VERBO Y LA URL LIMPIA (/articulos?.....)
        $verbo = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
        $url = filter_input(INPUT_SERVER, "REQUEST_URI", FILTER_SANITIZE_SPECIAL_CHARS);
        $urlLimpia = parse_url($url);

        // COMPROBAMOS QUE EXISTA EL VERBO EN EL ARRAY Y QUE LA URL LIMPIA PASE LA REGEX DEL ARRAY
        if ($verbo == $this->ruta['verbo']) {
            if (preg_match($this->ruta['path'], $urlLimpia['path'])) {

                // CABECERA PERA JSON
                header("Content-Type: application/json");

                try {
                    // CLASE Y MÉTODO AL QUE SE VA A INVOCAR
                    $clase = $this->ruta['modelo'];
                    $metodo = $this->ruta['metodo'];

                    $ormAlumno = new $clase();
                    $registrosDevueltos = $ormAlumno->$metodo();

                    // ENVÍO DE RESPUESTA CON PETICIÓN VÁLIDA
                    $respuesta['error'] = false;
                    $respuesta['datos'] = $registrosDevueltos;

                    echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    exit();
                } catch (Exception $e) {

                    // ENVÍO DE RESPUESTA CON PETICIÓN FALLIDA
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
