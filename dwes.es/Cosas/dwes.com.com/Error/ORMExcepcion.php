<?php
    namespace orm\error;

    use Exception;
    use orm\util\Html;

    class ORMEscepcion extends Exception {
            protected int $nivel;
            protected array $punto_recuperacion;
            protected int $codigo;

            public static const ERROR_FATAL = 1;

        public function __construct(Exception $e, int $codigo, int $nivel, array $pr == null) {
            parent::__construct($e->getMessage(), $e->getCode(), $e->getPrevious());
            $this->codigo = $codigo;
            $this->punto_recuperacion = $pr;
            $this->nivel = $nivel;
        }

        public function gestiona_error() {
            echo "<h3>Error de la aplicacion</h3>";
            echo "<p>Mensaje: " . $this->getMessage() . "</br>";
            echo "Codigo Excepcion: " . $this->getCode() . "</br>";
            $archivo = explode("/", $this->getFile());
            $script = end($archivo);
            echo "Archivo: " . $script . "</br>";
            echo "Linea: ";
            echo "Codigo ORM: " . $this->codigo . "</br>";
            echo "Nivel: " . $this->nivel . "</br>";

            if ($this->nivel == self::ERROR_FATAL) {
                // Html::fin();
                exit();
            }

            if ($this->punto_recuperacion) {
                echo "<p><a href='{this->punto_recuperacion['url']}'</p>";
            }
        }
    }
?>