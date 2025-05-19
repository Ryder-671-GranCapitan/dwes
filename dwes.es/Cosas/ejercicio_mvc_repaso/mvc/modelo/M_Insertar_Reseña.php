<?php

// Espacio de nombres
namespace mvc\modelo;

use DateTime;
use Exception;
use mvc\modelo\Modelo;
use mvc\modelo\orm\Mvc_Orm_Reseña;
use util\seguridad\Jwt;

// Creamos la clase de M_Insertar_Reseña que implementa de Modelo
class M_Insertar_Reseña implements Modelo{
    // Función que realizará la validación de los datos e insetará los datos en la BBDD
    public function despacha(): mixed
    {
        // Validamos los datos del formulario enviados
        $clasificacion = filter_input(INPUT_POST, 'clasificacion', FILTER_SANITIZE_NUMBER_INT);
        $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);
        $referencia = $_POST['referencia'];

        // Recogemos los valores del payload para pasar el nif del cliente
        $jwt = $_COOKIE['jwt'];
        $payload = JWT::verificar_token($jwt);

        // Ahora, debemos de hacer la consulta SQL, podemos usar el Mvc_Orm_Reseña y crear un nuevo método para insertar
        // un valor en la base de datos
        $mvc_orm_reseña = new Mvc_Orm_Reseña();
        if ($mvc_orm_reseña->insertaReseña($payload['nif'], $referencia, $clasificacion, $comentario)){
            $fecha = new DateTime();
            $datos =
                [
                    'nif' => $payload['nif'],
                    'referencia' => $referencia,
                    'fecha' => $fecha->format('d-m-y H:i:s'),
                    'clasificacion' => $clasificacion,
                    'comentario' => $comentario
                ];
            return $datos;
        }else {
            throw new Exception("No se ha insertado correctamente la reseña");
        }
    }
}

// Clase terminada y ahora, vamos a hacer la vista para insertar la reseña
?>