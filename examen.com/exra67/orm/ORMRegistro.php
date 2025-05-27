<?php

use entidad\RegistroAsistente\RegistroAsistente;

    class ORMRegistro {
        // Contantes de la clase
        const TABLA = "registro_asistente";
        const PK = "pk_registro";

        // Propiedades de la clase
        private $pdo;

        // Constructor
        public function __construct() {
            $this->pdo = new PDO("mysql:host=192.168.12.71;dbname=examen", "examen", "usuario");
        }

        // Metodo Insertar
        public function insertar(RegistroAsistente $registro): bool {
            $sql = "INSERT INTO " . self::TABLA . " VALUES (id, email, fecha_inscripcion, actividad)";
            $sentencia = $this->pdo->prepare($sql);
            $sentencia->bindParam(":email", $registro->getEmail());
            $sentencia->bindParam(":fecha_inscripcion", $registro->getFechaInscripcion());
            $sentencia->bindParam(":actividad", $registro->getActividad());
            return $sentencia->execute();
        }

        // Metodo Listar
        public function listar(string $email): array {
            $sql = "SELECT * FROM " . self::TABLA . " WHERE email = :email";
            $sentencia = $this->pdo->prepare($sql);
            $sentencia->bindParam(":email", $email);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            $registros = [];
            foreach($resultado as $fila) {
                $registro = new RegistroAsistente($fila["id"], $fila["email"], $fila["fecha_inscripcion"], $fila["actividad"]);
                $registros[] = $registro;
            }
            return $registros;
        }
    }
?>