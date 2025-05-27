<?php

// Espacio de nombres
namespace pr831\orm;

use DateTime;
use PDO;
use Exception;

// Creación de la clase ORMAlumno31
class ORMAlumno31{

    // Propiedades de la clase
    protected const tabla = "alumno";
    protected const pk = "nif";

    protected PDO $pdo;

    // Constructor de la clase ORMAlumno31
    public function __construct(){
        
        $dsn = "mysql:host=cpd.iesgrancapitan.org;dbname=examen;port=9992;charset=utf8mb4";
        $usuario = "examen";
        $clave = "usuario";
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];

        $this->pdo = new PDO($dsn, $usuario, $clave, $opciones);
    }

    public function insert( $datos ){

        try {
            $sql = "INSERT INTO " . self::tabla . " (nif, nombre, apellidos, fecha_nacimiento, curso, grupo) ";
            $sql.= "VALUES(";

            foreach( $datos as $propiedad => $valor){
                $sql.= ":{$propiedad}, ";
            }

            $sql = rtrim($sql, ", ");
            $sql.= ")";

            $stmt = $this->pdo->prepare($sql);

            foreach( $datos as $propiedad => $valor){
                $stmt->bindValue(":{$propiedad}", $valor);
            }

            if ($stmt->execute()){
                $respuesta['exito'] = "True";
                $respuesta['error'] = null;
                $respuesta['datos'] = $datos;
                $respuesta['codigo'] = "200 Ok";
            }
        }catch(Exception $e){
            $respuesta['exito'] = "False";
            $respuesta['error'] = [$e->getCode(), $e->getMessage()];
            $respuesta['datos'] = null;
            $respuesta['codigo'] = "400 Bad Request";
        }
         return $respuesta;
        
    }
}

?>