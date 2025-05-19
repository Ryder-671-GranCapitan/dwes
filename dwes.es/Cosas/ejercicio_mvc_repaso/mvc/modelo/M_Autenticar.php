<?php

// Creamos el espacio de nombre
namespace mvc\modelo;

use Exception;
use mvc\modelo\Modelo;
use mvc\modelo\orm\Mvc_Orm_Autenticar;
use util\seguridad\Jwt;

// Creamos la clase
class M_Autenticar implements Modelo{
    public function despacha(): mixed
    {
        // ¿Qué hace este método?
        // Vamos a autenticar al usuario en la base de datos

        // Tenemos que validar los datos que vienen desde el formulario, es decir, el email y la clave
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        

        // Y una vez los tengamos validados, realizaremos la validación con la base de datos
        if (!isset($_COOKIE['jwt'])){
            // Aquí, debemos de tener conexión a la base de datos y ¿quién tiene la conexión de la bbdd? 
            // En nuestro orm del cliente
            // Lo siguiente que debemos de hacer es generar la clase Mvc_Orm_Autenticar que será la que se encargué de 
            // darnos los datos del cliente
            // E instanciamos la clase Mvc_Orm_Autenticar
            $orm_autenticar = new Mvc_Orm_Autenticar();
            $cliente = $orm_autenticar->recogeUsuarioEmail($email);
            $clave = $_POST['clave'];

            $articulos = [];
            // Ahora, ya tendremos el cliente de la base de datos con todos sus datos
            // Ahora, ya podremos autenticarlo
            if (password_verify($clave, $cliente['clave'])){
                // Generamos el payload
                $payload = [
                    'nif' => $cliente['nif'],
                    'email' => $cliente['email'],
                    'nombre' => $cliente['nombre'],
                    'apellidos' => $cliente['apellidos']
                ];

                $jwt = JWT::generar_token($payload);

                // Generamos la cookie
                setcookie('jwt', $jwt ,time() + 1024 * 60, "/");

                // Almacenamos en la sesion los datos del cliente
                $_SESSION['cliente'] = $cliente['nombre'] . " " . $cliente['apellidos'];

                // Datos a devolver
                // $articulos = $orm_autenticar->recogerDatosArticulos();
                $articulos = $orm_autenticar->get_envios($cliente['nif']);

                $_SESSION['articulos'] = $articulos;
            }else {
                throw new Exception("La clave no es correcta");
            }
        }
        return $_SESSION['articulos'];
    }
}



?>