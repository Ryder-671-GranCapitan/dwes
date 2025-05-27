<?php
    namespace pr807\orm;

    use PDO;
    use Exception;

    // Creación de la clase ORMFEnvio07

    class ORMForma_envio07 {
        // Propiedades de la clase
        protected const tabla = "forma_envio";
        protected const pk = "id_fe";

        protected PDO $pdo;

        // Constructor de la clase ORMForma_envio07
        public function __construct() {
            $dsn = "mysql:host=cpd.iesgrancapitan.org;dbname=jgrueso;port=9992;charset=utf8mb4";
            $usuario = "jgrueso";
            $clave = "usuario";
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => FALSE
            ];

            $this->pdo = new PDO($dsn, $usuario, $clave, $opciones);
        }

        public function insert($datos) {
            try {
                $sql = "INSERT INTO " . self::tabla . " (id_fe, descripcion, telefono, contacto, email, coste) ";
                $sql.= "VALUES(";

                foreach($datos as $propiedad => $valor) {
                    $sql.= ":{$propiedad}, ";
                }

                $sql = rtrim($sql, ", ");
                $sql.= ")";

                $stmt = $this->pdo->prepare($sql);

                foreach($datos as $propiedad => $valor) {
                    $stmt->bindValue(":{$propiedad}", $valor);
                }

                if ($stmt->execute()) {
                    $respuesta['exito'] = "True";
                    $respuesta['error'] = null;
                    $respuesta['datos'] = $datos;
                    $respuesta['codigo'] = "200 Ok";
                }
            } catch(Exception $e) {
                $respuesta['exito'] = "False";
                $respuesta['error'] = $e->getMessage();
                $respuesta['datos'] = null;
                $respuesta['codigo'] = "400 Bad Request";
            }

            return $respuesta;
        }
    }
?>