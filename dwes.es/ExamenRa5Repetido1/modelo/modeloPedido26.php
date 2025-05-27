<?php
namespace ExamenRa5Repetido1\modelo;

use Exception;
use ExamenRa5Repetido1\entidad\Pedido26;
use PDO;


class ModeloPedido26 {
    protected const TABLE = 'pedido';
    protected const PK = 'npedido';

    protected PDO $pdo;

    public function __construct() {
        // 0. Preparar el constructor
        // el constructor es siempre el mismo
        $dns = 'mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=tiendaol;charset=utf8mb4';

        $usuario = 'usuario';
        $clave = 'usuario';
        $options = [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $this->pdo = new PDO($dns,$usuario,$clave,$options);
    }

    public function procesaPeticion() : Pedido26 {
        // 1. saneamiento y validacion de datos
        // nota: rafa no lo pide, porque alarga mucho, solo las PK
        $npedido = $_POST['npedido'];
        $npedido = filter_var($npedido, FILTER_SANITIZE_NUMBER_INT);

        if (!$npedido) {
            throw new Exception("pedido invalido", 1);            
        }

        // 2. preparar la consulta SQL
        // nota. es una consulta select, por lo que solo necesita el PK
        $sql = "SELECT npedido, nif, fecha, observaciones, total_pedido ";
        $sql .= "FROM " . self::TABLE . " ";
        $sql .= "WHERE " . self::PK . " = :pk ";

        $stmt = $this->pdo->prepare($sql);

        //pasar los parametros
        $params = [
            ':pk' => $npedido
        ];


        $stmt->execute($params);
        $data = $stmt->fetch();

        if (!$data) {
            throw new Exception("no se encontro el pedido con numero $npedido", 2);
        }

        // creo la clase pedido con los datos 
        $objeto_pedido = new Pedido26($data);
        return $objeto_pedido;
    }

}

?>