<?php

    // spacio de nombres
    namespace mvc\modelo;
    use mvc\modelo\M_Autenticar;
    use mvc\modelo\orm\Mvc_Orm_Reseña;
    use util\seguridad\Jwt;
    use Exception;

    // Generamos la clase que implementa de modelo
    class M_Insertar_Reseña implements Modelo {
        // Funcion que realizará la validacion de los datos e insertará los datos en la BBDD
        public function despacha(): mixed { 
            // Validamos los datos obtenidos del formulario
            $clasificacion = filter_input(INPUT_POST, 'clasificacion', FILTER_SANITIZE_NUMBER_INT);
            $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);
            $referencia = $_SESSION['referencia'];

            // Recogemos los valores del payload para pasar el nif del cliente
            $jwt = $_COOKIE['jwt'];
            $payload = JWT::verificar_token($jwt);

            //Ahora debemos hacer la colsulta sql, podemos usar el Mvc_Orm_Reseña y crear un nuevo metodo para insertar
            // un valor en la base de datos
            $mvc_orm_reseña = new Mvc_Orm_Reseña();
            if ($mvc_orm_reseña->insertaReseña($payload['nif'], $referencia, $clasificacion, $comentario)) {
                return [$referencia => 
                    [
                        'nif' => $payload['nif'],
                        'referencia' => $referencia,
                        'clasificacion' => $clasificacion,
                        'comentario' => $comentario
                    ]
                ];
            } else {
                throw new Exception("No se ha insertado correctamente la reseña");
                
            }
        }
    }   

?>