<?php

namespace pr826\Modelo;

use pr826\orm\ORMActividad26;

class Modelo26 {
    public function insert() {
        $datos = $this->validarDatos();

        if (isset($datos['errores'])) {
            return $datos; // Devuelve errores si los hay
        }

        $ormActividad = new ORMActividad26();
        return $ormActividad->insert($datos);
    }

    private function validarDatos() {

        // 1. Obtengo los datos de la petición en un array asociativo
        $datos_peticion = json_decode(file_get_contents("php://input"), true);
    
        // 2. Saneo los datos
        $array_saneamiento = [
            "nombre" => FILTER_SANITIZE_SPECIAL_CHARS,
            "descripcion" => FILTER_SANITIZE_SPECIAL_CHARS,
            "nivel" => FILTER_SANITIZE_SPECIAL_CHARS,
            "cuota_mes" => FILTER_SANITIZE_NUMBER_INT
        ];
    
        $datos_saneados = filter_var_array($datos_peticion, $array_saneamiento);
    
        // 3. Valido los datos
        $array_validacion = [
            "nombre" => FILTER_DEFAULT,
            "descripcion" => FILTER_DEFAULT,
            "nivel" => [
                'filter' => FILTER_CALLBACK,
                'options' => function($valor) {
                    $valor = strtoupper(trim($valor));
                    $niveles_validos = ['S', 'M', 'E', 'Q', 'I'];
                    return in_array($valor, $niveles_validos) ? $valor : null;
                },
                'flags' => FILTER_NULL_ON_FAILURE
            ],
            "cuota_mes" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 0, 'default' => 15],
                'flags' => FILTER_NULL_ON_FAILURE
            ]
        ];
    
        $datos_validados = filter_var_array($datos_saneados, $array_validacion);
    
        // 4. Aplicar valor por defecto si cuota es null
        if (is_null($datos_validados['cuota_mes'])) {
            $datos_validados['cuota_mes'] = 15;
        }
    
        // 5. Comprobar si falta algo obligatorio
        $errores = [];
        if (empty($datos_validados['nombre'])) {
            $errores[] = "El nombre es obligatorio.";
        }
    
        if (empty($datos_validados['descripcion'])) {
            $errores[] = "La descripción es obligatoria.";
        }
    
        if (empty($datos_validados['nivel'])) {
            $errores[] = "El nivel debe ser uno de los siguientes: S, M, E, Q, I.";
        }
    
        // 6. Devuelvo errores o datos válidos
        if (!empty($errores)) {
            return ['errores' => $errores];
        }
    
        return $datos_validados;
    }
    
}
