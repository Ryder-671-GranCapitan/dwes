<?php

/*
=================================== 
    REALIZADO POR DANIEL BUENO VÁZQUEZ
===================================
*/

namespace exra701\modelo;

use PDO;
use PDOException;
use exra701\entidad\Alumno01;

class RESTAlumno
{
    /*
    =================================== 
        PROPIEDADES DE CLASE
    ===================================
    */
    protected static $TABLA = "alumno";
    protected static $PK = "nif";

    /*
    =================================== 
        PROPIEDADES DE OBJETO
    ===================================
    */
    private PDO $pdo;

    /*
    =================================== 
        CONSTRUCTOR
    ===================================
    */
    public function __construct()
    {
        $dsn = "mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=examen;charset=utf8mb4";
        $user = "examen";
        $password = "usuario";
        $options = [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $pdoe) {
            throw $pdoe;
        }
    }

    /*
    =================================== 
        OBTENER ALUMNOS POR APELLIDOS
    ===================================
    */
    public function getAlumnos(): mixed
    {
        // OBTENEMOS EL PARÁMETRO DE CONSULTA PARA FILTRAR
        $parametroConsulta = filter_input(INPUT_GET, "apellidos", FILTER_SANITIZE_SPECIAL_CHARS);

        try {

            // CONSULTA Y STATEMENT
            $sql = "SELECT * FROM " . self::$TABLA . " ";
            $sql .= "WHERE apellidos LIKE :apellidos";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":apellidos", "%$parametroConsulta%");

            // SI SE EJECUTA CORRECTAMENTE SE OBTIENE UN ARRAY DE OBJETOS ARTICULOS
            if ($stmt->execute()) {

                $registrosDevueltos = [];
                while ($fila = $stmt->fetch()) {
                    $registrosDevueltos[] = new Alumno01($fila);
                }
                return $registrosDevueltos;
            } else {
                return null;
            }
        } catch (PDOException $pdoe) {
            throw $pdoe;
        }
    }
}
