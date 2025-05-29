<?php

namespace rera526\modelo;

use PDO;
use Exception;
use DateTime;
use rera526\entidad\Envio26;

class ModeloEnvio26
{
    private const TABLA = 'envio';
    private const PK = 'nenvio';

    private PDO $pdo;

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

        $this->pdo = new PDO($dsn, $usuario, $clave, $options);
    }

    public function procesaPeticion()
    {
        $fecha = $_POST['fecha'] ?? null;
        $fecha = filter_var($fecha, FILTER_SANITIZE_SPECIAL_CHARS);


        if (!$fecha) {
            $sql = "SELECT * FROM " . self::TABLA . " ;";

            $stmt = $this->pdo->prepare($sql);

        } else {

            $fecha_formato_sql = new DateTime($fecha);


            $sql = "SELECT * FROM " . self::TABLA . " WHERE fecha = :fecha ;";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':fecha', $fecha_formato_sql->format(Envio26::FECHA_MYSQL));
        }
            $stmt->execute();


        if ($stmt->rowCount() == 0) {
            throw new Exception("Error, no hay envios en esa fecha $fecha", 1);
        }

        $resultados = $stmt->fetchAll();
        $salida = [];

  
        for ($i=0; $i < $resultados; $i++) { 
            $envio = new Envio26($resultados[$i]);
            array_push($salida, $envio);

        }

        return $salida;
    }
}
