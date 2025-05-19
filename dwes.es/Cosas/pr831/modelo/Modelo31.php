<?php

// Espacio de nombres
namespace pr831\modelo;

use pr831\orm\ORMAlumno31;

// Creación de la clase
class Modelo31 {

    // Función insert
    public function insert(){

        // Valido los datos
        $datos = $this->validarDatos();

        // Creo una instancia de ORMAlumno para llamar al método insert y almaceno la respuesta
        $ormAlumno = new ORMAlumno31();
        $datos_devolucion = $ormAlumno->insert($datos);

        // Devuelvo la respuesta del insert
        return $datos_devolucion;
    }

    private function validarDatos(){

        // Obtengo los datos de la peticion en un array asociativo
        $datos_peticion = json_decode(file_get_contents("php://input"), true);

        // Saneo los datos
        $array_saneamiento = [
            "nif" => FILTER_SANITIZE_SPECIAL_CHARS,
            "nombre" => FILTER_SANITIZE_SPECIAL_CHARS,
            "apellidos" => FILTER_SANITIZE_SPECIAL_CHARS,
            "fecha_nacimiento" => FILTER_SANITIZE_SPECIAL_CHARS,
            "curso" => FILTER_SANITIZE_SPECIAL_CHARS,
            "grupo" => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $datos_saneados = filter_var_array($datos_peticion, $array_saneamiento);

        // Valido los datos
        $array_validacion = [
            "nif" => FILTER_DEFAULT,
            "nombre" => FILTER_DEFAULT,
            "apellidos" => FILTER_DEFAULT,
            "fecha_nacimiento" => ['filter' => FILTER_DEFAULT,
                        'flags' => FILTER_NULL_ON_FAILURE],
            "curso" => [ 'filter' => FILTER_DEFAULT,
                         'flags' => FILTER_NULL_ON_FAILURE],
            "grupo" => [ 'filter' => FILTER_DEFAULT,
                         'flags' => FILTER_NULL_ON_FAILURE]
        ];

        $datos_validados = filter_var_array($datos_saneados, $array_validacion);

        return $datos_validados;
    }

}

?>