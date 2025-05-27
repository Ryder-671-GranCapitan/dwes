<?php
    namespace ExamenRa7\entidad;

    use JsonSerializable;
    use DateTime;
    use Exception;
    use ReflectionProperty;

    class Cliente07 implements JsonSerializable { 
        public static string $FORMATO_FECHA_JSON = "d/m/Y - H:i:s";

        // PROPIEDADES DEL OBJETO
        private string $nif;
        private string $nombre;
        private string $apellidos;
        private string $clave;
        private string $iban;
        private string $telefono;
        private string $email;
        private float $ventas;

        // CONSTRUCTOR
        public function __construct(array $datos) {
            foreach ($datos as $propiedad => $valor) {
                if (!property_exists($this, $propiedad)) {
                    throw new Exception("La propiedad $propiedad no existe");
                } else {
                    $propiedadReflection = new ReflectionProperty($this, $propiedad);
                    if ($propiedadReflection->getType()->getName() == DateTime::class) {
                        $this->$propiedad = new DateTime($valor);
                    } else {
                        $this->$propiedad = $valor;
                    }
                }
            }
        }

        public function jsonSerialize(): mixed {
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
?>