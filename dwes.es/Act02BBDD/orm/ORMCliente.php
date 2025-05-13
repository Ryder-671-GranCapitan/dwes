<?php
    namespace orm;

    use PDO;

    class ORMCliente {
        public const TABLE = 'cliente';
        public const TABLE_DIR = 'direccion_envio';
        public const PK = 'nif';

        protected PDO $pdo;

        public function __construct() {
            $dsn = 'mysql:host=mysql;dbname=tiendaol;charset=utf8mb4';
            $usuario = 'usuario';
            $clave = 'usuario';

            $opciones = [
                PDO::ATTR_CASE                 => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES     => false,
                PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
            ];

            $this->pdo = new PDO($dsn, $usuario, $clave, $opciones);
        }

        public function autenticar_cliente(string $email, string $clave) {
            $sql = 'SELECT nif, nombre, apellidos, clave, ventas ';
            $sql .= 'FROM ' . self::TABLE . ' ';
            $sql .= 'WHERE email = :email';
            
            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':email' => $email
            ];

            if ($stmt->execute($params)) {
                $fila = $stmt->fetch();

                if ($fila) {
                    return password_verify($clave, $fila['clave']) ? $fila : false;
                }
                return false;
            }
        }

        public function getDirecciones(string $nif) : ?array {
            $sql = "SELECT nif, id_dir_env, direccion, cp, poblacion, provincia, pais ";
            $sql .= "FROM direccion_envio ";
            $sql .= "WHERE " . self::PK . "=:nif";

            $stmt = $this->pdo->prepare($sql);

            $params = [':nif' => $nif];

            if ($stmt->execute($params)) {
                $direcciones_envio = [];

                while ($fila = $stmt->fetch()) {
                    $direcciones_envio[] = $fila;
                }

                return $direcciones_envio;
            }
        }

        public function insertarDir(array $array): bool {
            $columnas = array_keys($array);
            $id_dir_env = $this->getNewId($array['nif']);
            $values = array_values($array);

            $parms = array_map(fn($columna) => ":$columna", $columnas);

            $sql =  "INSERT INTO " . self::TABLE_DIR . " (" . "id_dir_env, " . implode(',', $columnas) . ") ";
            $sql .= "VALUES (" . ":id_dir_env" . ", " . implode(', ', $parms) . ")";

            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':id_dir_env'   => $id_dir_env,
                ':nif'          => $array['nif'],
                ':direccion'    => $array['direccion'],
                ':cp'           => $array['cp'],
                ':poblacion'    => $array['poblacion'],
                ':provincia'    => $array['provincia'],
                ':pais'         => $array['pais']
            ];

            return ($stmt->execute($params) && $stmt->rowCount() == 1);
        }

        public function getNewId(string $nif): int {
            $direcciones_envio = $this->getDirecciones($nif);

            $lastDirEnv = intval(end($direcciones_envio)['id_dir_env']);

            return $lastDirEnv + 1;
        }
    }

?>