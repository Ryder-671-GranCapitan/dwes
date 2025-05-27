<?php
    namespace rera707\entidad;

    use JsonSerializable;
    use DateTime;
    use Exception;
    use ReflectionProperty;

    class Resena07 implements JsonSerializable {
        private const FORMATO_FECHA_JSON = "d/m/Y - H:i:s";
        private int $id_reseña;
        private ?string $nif;
        private ?string $referencia;
        private DateTime $fecha;
        private int $clasificacion;
        private ?string $comentario;

        public function __construct(array $datos) {
            foreach ($datos as $propiedad => $valor) {
                if (!property_exists($this, $propiedad)) {
                    throw new Exception("La propiedad $propiedad no existe");
                } else {
                    $propiedadReflection = new ReflectionProperty($this, $propiedad);
                    if ($propiedadReflection->getType()->getName() == DateTime::class) {
                        $this->$propiedad = $valor ? new DateTime($valor) : null;
                    } else {
                        $this->$propiedad = $valor;
                    }
                }
            }
        }

        public function jsonSerialize(): mixed {
            $objetoJson = [];
            foreach ($this as $propiedad => $valor) {
                if ($propiedad == "fecha" && $valor instanceof DateTime) {
                    $objetoJson[$propiedad] = $valor->format(self::FORMATO_FECHA_JSON);
                } else {
                    $objetoJson[$propiedad] = $valor;
                }
            }
            return $objetoJson;
        }
    }
?>