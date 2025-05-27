<?php 
namespace ExamenRa5Repetido1\entidad;

use DateTime;
use Exception;
use ReflectionProperty;

class Pedido26 {
    // clase generica, es posible usarla para todo cambiado las Atributos  privadas

    // 3. crear clase, Atributos  privadas 
    
    // formato para usar los formatos correctos de Date
    public const FECHA_MYSQL = "Y-m-d H:i:s";
    public const FECHA_USUARIO = "d/m/Y H:i:s";

    // Atributos  
    private int $npedido;
    private string $nif;
    private DateTime $fecha;
    private ?string $observaciones; // ?sting indica que es opcional
    private ?string $total_pedido; // es una cadena o null (vacío)


    public function __construct(array $datos) {
        foreach ($datos as $propiedad => $valor) {
            $this->__set($propiedad, $valor);
        }
    }

    // funcion para objeter el tipo de dato de la propiedad
    public function getProperty($objeto, $propiedad) : string {
        $instancia_refection = new ReflectionProperty($objeto, $propiedad);
        return $instancia_refection->gettype()->getName();
    }

    public function __set($propiedad, $valor){
        if (!property_exists($this, $propiedad)) {
            throw new Exception("propiedad invalida", 3);
        }

        // si la propiedad es de tipo fecha, lo guarda como un tipo fecha
        if (self::getProperty($this,$propiedad) == DateTime::class) {
            $this->$propiedad = new DateTime($valor);
        }else {
            $this->$propiedad = $valor;
        }
    }

    public function __get($propiedad): mixed {
        if (!property_exists($this, $propiedad)) {
            throw new Exception("propiedad invalida", 3);
        }
        return $this->$propiedad;
    }



}


?>