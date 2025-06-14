<?php

namespace rera526\entidad;

use Exception;
use DateTime;
use ReflectionProperty;

class Envio26
{
    private int $nenvio;
    private string $nif;
    private int $id_dir_env;
    private DateTime $fecha;
    private ?string $observaciones;
    private ?string $forma_envio;
    private int $nfactura;

    public const FECHA_MYSQL = "Y-m-d H:i:s";
    public const FECHA_USUARIO = "d/m/Y H:i:s";

    public function __construct(array $datos)
    {
        foreach ($datos as $propiedad => $valor) {
            $this->__set($propiedad, $valor);
        }
    }

    public function __set($propiedad, $valor)
    {
        if (!property_exists($this, $propiedad)) {
            throw new Exception("Propiedad Invalida $propiedad");
        }

        if (self::getProperty($this, $propiedad) == DateTime::class) {
            $this->$propiedad = new DateTime($valor);
        } else {
            $this->$propiedad = $valor;
        }
    }
    public function __get($propiedad): mixed
    {
        if (!property_exists($this, $propiedad)) {
            throw new Exception("Propiedad Invalida");
        }
        return $this->$propiedad;
    }
    public static function getProperty($objeto, $propiedad): string
    {
        $instancia_reflection = new ReflectionProperty($objeto, $propiedad);
        return $instancia_reflection->getType()->getName();
    }
}
?>