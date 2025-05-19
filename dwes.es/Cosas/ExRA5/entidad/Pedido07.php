<?php
    namespace ExRA5\entidad;

    use DateTime;
    use Exception;
    use ReflectionProperty;

    class Pedido07 {
        public const FECHA_MYSQL = "Y-m-d H:i:s";
        public const FECHA_USUARIO = "d/m/Y H:i:s";

        private int $npedido;
        private string $nif;
        private DateTime $fecha;
        private ?string $observaciones;
        private ?float $total_pedido;

        public function __construct(array $datos) {
            foreach ($datos as $propiedad => $valor) {
                $this->__set($propiedad, $valor);
            }
        }

        public function __set($propiedad, $valor) {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("Propiedad invalida $propiedad");
            }

            if (self::getPropertyTypeName($this, $propiedad) == DateTime::class) {
                $this->$propiedad = new DateTime($valor);
            } else {
                $this->$propiedad = $valor;
            }
        }

        public static function getPropertyTypeName($objeto, $propiedad) : string {
            $reflection_instance = new ReflectionProperty($objeto, $propiedad);
            return $reflection_instance->getType()->getName();
        }

        public function __get($propiedad): mixed {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("Propiedad invalida $propiedad");
            }
            return $this->$propiedad;
        }
    }
?>