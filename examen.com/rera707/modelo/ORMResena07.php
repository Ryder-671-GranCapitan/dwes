<?php
    namespace rera707\modelo;
    use PDO;

    class ORMResena07 {
        private static $TABLA = "reseña";
        private static $PK = "id_reseña";

        private PDO $pdo;

        public function __construct() {
            $dsn = "mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=tiendaol;charset=utf8mb4";
            $usuario = "usuario";
            $contrasena = "usuario";
            $opciones = [
                PDO::ATTR_CASE                 => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES     => false,
                PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
            ];
            $this->pdo = new PDO($dsn, $usuario, $contrasena, $opciones);
        }

        public function getResenas(array $referencia): array {
            $sql = "SELECT * FROM " . self::$TABLA . " WHERE referencia = :referencia";
            $sentencia = $this->pdo->prepare($sql);
            $sentencia->execute($referencia);
            $resenas = $sentencia->fetchAll();
            return $resenas;
        }
    }
?>