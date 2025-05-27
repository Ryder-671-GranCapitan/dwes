<?php

function autenticar($correo, $contraseña){
    $usuarios_conocidos = [
        'jpradillo@gmail.com'   =>  ['nombre' => 'Jorge Pradillo Hintenberger', 'contraseña' => password_hash('marta', PASSWORD_DEFAULT )],
        'kike@gmail.com'        =>  ['nombre' => 'Enrique Mariño Jiménez', 'contraseña' => password_hash('elena', PASSWORD_DEFAULT)]
    ];

    if( array_key_exists($correo, $usuarios_conocidos) ){

        return password_verify($contraseña, $usuarios_conocidos[$correo]['contraseña']);
    
    }
    else{
        return false;
    }
}

function cerrar_sesion(){
    $nombre_sesion = session_name();
    $parametros = session_get_cookie_params();

    setcookie($nombre_sesion, "", time() - 100000, $parametros['path'], $parametros['domain'], $parametros['secure'], $parametros['httponly']);
    session_unset();
    session_destroy();
}

?>
