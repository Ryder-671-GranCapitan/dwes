<?php


// Formas de guardar las credenciales de los usuarios.

/*
  
  Las claves siempre se guardan cifradas.

  Funcion Hash./

    Algoritmo matematico sobre un dato de entrada que puede ser cualquier cosa ( nuestra contrasena ).
    Todo el texto de entrada produce una salida con las siguientes caracteristicas.

      - Longitud fija.
      - El resltado se le llama HASH.
      - Pasar desde un dato de entrada al HASH es muy rapido pero partiendo del HASH obtener la entrada principal es IMPOSIBLE.
    
  Ahora, este sistema es vulnerable. Pero son sensibles a los ataques por fuerza bruta o a tablas RAINBOW.


*/

// Consiste en enviar las siguientes cabeceras.

/*
  header("WWW-Authentication: Basic ream ='Acceso restringido'");
  header('HTTP/1.1 401 Unauthorized');

  Cuando el navegador recibe estas cabeceras muestra un cuado de autenticacion para que el usuario introduzca usuario y clave.

  Las credenciales se envian al servidor, al mismo script, y sus valores se guardan en :

  $_SERVER['PHP_AUTH_USER']; // Guarda usuario
  $_SERVER['PHP_AUTH_PW]; // Guarda contrasena

  Se leen estos datos, se comprueba con la BD de usuarios y si no son validas se envia un 401 Unauthorized.

  Para guardar las credenciales de usuario se suele emplear una tabla de BD. En este ejemplo usamos un array bidimensional con login de usuario, como clave, y cada
  elemento es nombre y password hasheada.

  Algoritmo de hash.
  ------------------
  Los mas habituales son : SHA1, SHA2, SHA256, SHA512.

  Funciones Php para obtener hash de una cadena:
*/
$usuarios = ['manuel01' => ['nombre' => 'Manuel Garcia', 'clave'=>hash("sha512", "manuel")],
      'maria02' => ['nombre' => 'Maria Gonzalez', 'clave'=>hash("sha512", "maria")]
];

session_start();
define("Intentos_MAX", 3);


/*
foreach($usuarios as $usuario){
  echo "<p>{$usuario['nombre']} - {$usuario['clave']}<br></p>";
}
*/

$authOK = False;
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
  
  $usuario = htmlspecialchars($_SERVER['PHP_AUTH_USER']);
  $clave = htmlspecialchars($_SERVER['PHP_AUTH_PW']);

  if ( array_key_exists($usuario, $usuarios)){
  $password_haseada = hash('sha512', $clave);

    if($password_haseada == $usuarios[$usuario]['clave']){
      $authOK = True;
    }

  }

}

if (!$authOK){
  header("WWW-Authenticate: Basic realm='Zona restringida'");
  header("HTTP/1.1 401 Unauthorized");

  // llamo aqui a require_once() ???


  echo "<h3>Usted no esta autorizado. Se necesita autenticacion para acceder.</h3>";
  echo "<p><a href='{$_SERVER['PHP_SELF']}'>Volver a intentarlo</a></p>";
  exit;
}

// Aqui va el contenido que se visualiza si el contenido es correcto.
echo "<h1>Zona restringida</h1>";
echo "<h3>Bienvenido {$usuarios[$usuario]['nombre']} a la zona restringida</h3>";




?>
