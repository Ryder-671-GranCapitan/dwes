<?php
// Yahya Limouni | 12
namespace exra512\entidad;

use DateTime;
use Exception;
use ReflectionProperty;

class Pedido12 {
    public const FECHA_MYSQL = "Y-m-d H:i:s";
    public const FECHA_USUARIO = "d/m/Y H:i:s";

    private int $npedido;
    private string $nif;
    private DateTime $fecha;
    private ?string $observaciones;
    private ?float $total_pedido;

    public function __construct(array $data) {
        foreach($data as $property => $value){
            $this->__set($property, $value);
        }
    }

    public function __set($property, $value){
        if( !property_exists($this, $property) ){
            throw new Exception("Invalid property $property");
        }
        if( self::getPropertyTypeName($this, $property) == DateTime::class) {
            $this->$property = new DateTime($value);
        }
        else {
            $this->$property = $value;
        }
    }

    public static function getPropertyTypeName($object, $property): string{
        $reflection_instance = new ReflectionProperty($object, $property);
        return $reflection_instance->getType()->getName();
    } 

    public function __get($property): mixed {
        if( !property_exists($this, $property) ) {
            throw new Exception("Invalid property $property");
        }

        return $this->$property;
    }
}
?>