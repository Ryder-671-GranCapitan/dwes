<?php

/*
=================================== 
    REALIZADO POR DANIEL BUENO VÁZQUEZ
===================================
*/

namespace exra701\entidad;

use JsonSerializable;
use DateTime;
use Exception;
use ReflectionProperty;

class Alumno01 implements JsonSerializable {
    /*
    =================================== 
        PROPIEDADES DE CLASE
    ===================================
    */
    public static string $FORMATO_FECHA_JSON = "d/m/Y - H:i:s";

    /*
    =================================== 
        PROPIEDADES DE OBJETO
    ===================================
    */
    private string $nif;
    private string $nombre;
    private string $apellidos;
    private DateTime $fecha_nacimiento;
    private string $curso;
    private string $grupo;

    /*
    =================================== 
        CONSTRUCTOR
    ===================================
    */
    public function __construct(array $datos) {
        foreach ($datos as $propiedad => $valor) {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("La propiedad $propiedad no existe");
            } else {
                $propiedadReflexion = new ReflectionProperty($this, $propiedad);
                if ($propiedadReflexion->getType()->getName() == DateTime::class) {
                    $this->$propiedad = new DateTime($valor);
                } else {
                    $this->$propiedad = $valor;
                }
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        $objetoJson = [];
        foreach ($this as $propiedad => $valor) {
            if ($propiedad == "fecha_nacimiento" && $valor instanceof DateTime) {
                $objetoJson[$propiedad] = $valor->format(self::class);
            } else {
                $objetoJson[$propiedad] = $valor;
            }
        }
        return $objetoJson;
    }
}