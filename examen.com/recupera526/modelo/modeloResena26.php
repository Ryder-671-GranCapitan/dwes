<?php

namespace recupera526\modelo;

use Exception;
use PDO;
use Recupera526\entidad\Resena26;

class modeloResena26
{
    private const TABLE = 'reseña';
    private const PK = 'id_reseña';

    protected PDO $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=tiendaol;charset=utf8mb4';
        $usuario = 'usuario';
        $clave = 'usuario';
        $options = [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $this->pdo = new PDO($dsn, $usuario, $clave,$options);
    }



    public function procesaPeticion() {
            $id_reseña = $_POST['id_resena'];
            $id_reseña = filter_var($id_reseña, FILTER_SANITIZE_NUMBER_INT);
            $nif = $_POST['nif'];
            $nif = filter_var($nif, FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha = $_POST['fecha'];
            $referencia = $_POST['referencia'] ?? '';
            $referencia = filter_var($referencia, FILTER_SANITIZE_SPECIAL_CHARS);
            $clasificacion = $_POST['clasificacion'] ?? 0;
            $clasificacion = filter_var($clasificacion, FILTER_SANITIZE_NUMBER_INT);
            $comentario = $_POST['comentario'] ?? '';
            $comentario = filter_var($comentario, FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id_reseña) {
            throw new Exception("reseña invalida", 1);
        }
        $sql = 'INSERT INTO ' . self::TABLE. " VALUES(null, :nif, :referencia, :fecha, :clasificacion, :comentario) ";
        $stmt = $this->pdo->prepare($sql);
        $parametros = [
            ':nif' => $nif,
            ':referencia' => $referencia,
            ':fecha' => $fecha,
            ':clasificacion' => $clasificacion,
            ':comentario' => $comentario
        ];

        $stmt->execute($parametros);
        $datos = $stmt->fetch();

        if (!$datos) {
            throw new Exception("no se ha podido añadir la reseña", 1);
        }

        $objeto_reseña = new resena26($datos);
        return $objeto_reseña;

    }
}
?>