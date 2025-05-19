<?php

  function ver_datos_session(){
    echo "<p>";
    echo "Id de sesion: " . session_id() . "<br>";
    if (isset($_SESSION['instante'])){
      echo "Momento de creacion " .date("D, d, F Y G:i:s", $_SESSION['instante']) ."<br>";
    } else {
      echo "Momento de creacion no aparece";
    }
    echo "Nombre :" . (isset($_SESSION['nombre']) ? $_SESSION['nombre'] . "<br>" : "El nombre no se ha definido aun<br>");
    echo "Email :" . (isset($_SESSION['email']) ? $_SESSION['email'] . "<br>" : "El email no se ha definido aun<br>") ;
    echo "Productos en la cesta: " . (isset($_SESSION['cesta']) ? count($_SESSION['cesta']) . "<br>" : "0<br>");
    echo "</p>";
  }

  // function cerrar_sesion(){
  //   // 1 Destruir el id de sesion.
  //   $parametros_cookie = session_get_cookie_params(); 
  //   $nombre_sesion = session_name();
  //   setcookie($nombre_sesion, '', time() - 42000,
  //   $parametros_cookie['path'],
  //   $parametros_cookie['domain'],
  //   $parametros_cookie['path'],
  //   $parametros_cookie['httponly']
  //   );

  //   // 2 Destruir las variables de la sesion.
  //   session_destroy(); // Borra el array session.

  //   // 3 Destruir los datos de la sesion.
  //   session_unset();
  // }

?>