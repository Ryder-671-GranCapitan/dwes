<?php

namespace Pr826\orm;

use Exception;
use PDO;

class ORMActividad26
{
    protected const tabla = 'actividad';
    protected const pk = 'nombre';

    protected PDO $pdo;

    public function __construct()
    {
        $dns = "mysql:host=cpd.iesgrancapitan.org;dbname=gimnasio;port=9992;charset=utf8mb4";
        $user = 'usuario';
        $pass = 'usuario';

        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];

        $this->pdo = new PDO($dns, $user, $pass, $opciones);
    }

    public function insert(array $datos)
    {
        try {
            // construcción de la consulta
            $sql = "INSERT INTO " . self::tabla . " (nombre, descripcion, nivel, cuota_mes) ";
            $sql .= "VALUES(";

            foreach ($datos as $propiedad => $valor) {
                $sql .= ":{$propiedad}, ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= ")";

            // preparar la consulta
            $stmt = $this->pdo->prepare($sql);

            // asociar los datos introducidos a consulta SQL
            foreach ($datos as $propiedad => $valor) {
                $stmt->bindValue(":{$propiedad}", $valor);
            }

            // ejecutar la consulta y guardar los resultados 
            if ($stmt->execute()) {
                $respuesta['exito'] = "True";
                $respuesta['error'] = null;
                $respuesta['datos'] = $datos;
                $respuesta['codigo'] = "200 Ok";
            }
        } catch (Exception $err) {
            $respuesta['exito'] = "False";
            $respuesta['error'] = [$err->getCode(), $err->getMessage()];
            $respuesta['datos'] = null;
            $respuesta['codigo'] = "400 Bad Request";
        }

        return $respuesta;
    }
}
