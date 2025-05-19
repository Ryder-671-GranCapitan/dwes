<?php

// Y ahora si, creamos nuestro modelo del main
// Espacio de nombres
namespace mvc\modelo;

use mvc\modelo\Modelo;

// Creamos la clase que implementa de Modelo
class M_Main implements Modelo{
    public function despacha(): mixed
    {
        // Vale, ahora ya es ir viendo que nos pide el ejercicio
        if (isset($_COOKIE['jwt'])){
            $this->con_usuario_autenticado();
            // Y cuando se destruya la sesión, debemos iniciarla de nuevo
            setcookie('jwt', '', time()-60);
            session_start();
        } else {
            // Y si no hay sesión, la iniciamos directamente
            session_start();
        }
        // Y como debemos de devolver algo, vamos a devolver true porque no se me ocurre algo mas que devolver
        return true;
    }

    // Vamos a crear una función para que, en caso de que haya una sesión iniciada, la destruya y se vuelva a iniciar
    private function con_usuario_autenticado(){
        // Lo primero destruir la cookie
        session_start();
        session_unset();
        session_destroy();
    }
}

// Modelo M_Main terminado 
// Vamos con la vista
?>