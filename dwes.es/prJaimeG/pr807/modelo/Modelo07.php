<?php
    namespace pr807\modelo;

    use pr807\orm\ORMForma_envio07;

    class Modelo07 {
        public function insert() {
            $datos = $this->validarDatos();

            // Se crea una instancia de ORMAlumno para llamar al metodo insert y almaceno la respuesta
            $ormFEnvio = new ORMForma_envio07();
            $datos_recogidos = $ormFEnvio->insert($datos);

            // Respueta del insert
            return $datos_recogidos;
        }

        private function validarDatos() {
            $datos_peticion = json_decode(file_get_contents("php://input"), true);

            $array_sanear = [
                "id_fe" => FILTER_SANITIZE_SPECIAL_CHARS,
                "descripcion" => FILTER_SANITIZE_SPECIAL_CHARS,
                "telefono" => FILTER_SANITIZE_SPECIAL_CHARS,
                "contacto" => FILTER_SANITIZE_SPECIAL_CHARS,
                "email" => FILTER_SANITIZE_EMAIL,
                "coste" => FILTER_SANITIZE_NUMBER_FLOAT
            ];

            $datos_saneados = filter_var_array($datos_peticion, $array_sanear);

            $validaciones = [
                "id_fe" => FILTER_DEFAULT,
                "descripcion" => FILTER_DEFAULT,
                "telefono" => FILTER_DEFAULT,
                "contacto" => FILTER_DEFAULT,
                "email" => FILTER_VALIDATE_EMAIL,
                "coste" => FILTER_VALIDATE_FLOAT
            ];

            $datos_validados = filter_var_array($datos_saneados, $validaciones);

            return $datos_validados;
        }
    }
?>