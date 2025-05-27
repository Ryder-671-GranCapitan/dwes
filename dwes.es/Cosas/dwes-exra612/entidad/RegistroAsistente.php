<?php
namespace entidad;

use DateTime;
use Exception;
use ReflectionProperty;

class RegistroAsistente {
    public const FORMATO_FECHA_MYSQL = 'Y-m-d H:i:s';
    public const FORMATO_FECHA_USUARIO = 'm/d/Y H:i:s';

    private int $id;
    private string $email;
    private DateTime $fecha_inscripcion;
    private string $actividad;

    public function __construct(array $datos){
        foreach($datos as $property => $value){
            $this->__set($property, $value);
        };
    }

    public function __set($property, $value){
        if( !property_exists($this, $property) ){
            throw new Exception("No existe la propiedad $property");
        }

        if( !($this->tipoPropiedad($this, $property) == DateTime::class)){
            $this->$property = $value;
        }
        else {
            $this->$property = new DateTime($value);
        }
    }
    
    public function __get($property) {
        if( !property_exists($this, $property) ){
            throw new Exception("No existe la propiedad $property");
        }
        return $this->$property;
    }

    public function __toString(){
        $data = '';

        foreach( $this as $property => $value ){
            if( $this->tipoPropiedad($this, $property) == DateTime::class ) {
                $data .= $property . ': ' . $value->format(self::FORMATO_FECHA_MYSQL) . "<br>";
                continue;
            }
            $data .= $property . ": " . $value . "<br>";
        }

        return $data;
    }

    public function tipoPropiedad($object, $property){
        $objeto_ref = new ReflectionProperty($object, $property);
        $tipo_obj = $objeto_ref->getType();
        $nombre_tipo = $tipo_obj->getName();

        return $nombre_tipo;
    }

    public function toArray() : array{
        return get_object_vars($this);
    }
}

?>