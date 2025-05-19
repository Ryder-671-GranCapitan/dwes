<?php

session_start(['gc_maxlifetime' => 60 * 60]);
// Usuarios/
$usuarios = ['manuel@loquesea.es' => ['nombre' => 'Manuel Garcia',
                                      'password' => password_hash("abc123", PASSWORD_DEFAULT)],
             'maria@loquesea.es' => ['nombre' => 'Maria Lopez',
                                     'password' => password_hash("abc1234", PASSWORD_DEFAULT)],
                                     
];


// foreach($usuarios as $usuario => $valor) {
//   echo "{$usuario[$valor]}";
//   echo "{$usuarios[$usuario]['password']}";
// }

// La funcion autentica al usuario recibe un nombre y una clave;

function autenticacion_usuario($login, $clave){
global $usuarios;
if (!array_key_exists($login, $usuarios)){
     return false;
}
else{
  // Comprobamos que la clave del usuario es correcta.
  if (password_verify($clave, $usuarios[$login]['password'])){
    return true;
  }
  else{
    return false;
  }
}
}

// Comprobamos que estamos en un POST de datos para capturar los datos de inicio de sesion.
echo "<header>Autenticacion de formulario</header>";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  // Autenticamos al usuario.

  $login = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_EMAIL);
  $login = filter_var($login, FILTER_VALIDATE_EMAIL);

  $clave = filter_input(INPUT_POST, 'passwd', FILTER_SANITIZE_SPECIAL_CHARS);

  if (autenticacion_usuario($login, $clave)){
    // Autenticacion ha tenido exito.
    // Empieza la generacion del tojen JWT.
    // Genero el array con los datos de usuario.

    $usuario =[
      'id' => $login,
      'username' => $usuarios[$login]['nombre'],
      'role' => 'admin'
    ];

    if ( file_exists('03clave.txt')){
      $fichero_clave = fopen("03clave.txt", "r");
      $clave = fgets($fichero_clave);
      fclose($fichero_clave);
    }
    else{
      $clave = "abc123";
    }

    // Include JWT_include generar token.
    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/sesiones/autenticacion/03JWT_include.php");

    $jwt = generar_token($usuario, $clave);

    echo "<p>El token generado: $jwt</p><br>";

    // El tiempo de validez del jwt es de 1 hora.
    $expire = time() + 60 * 60;

    // Se establece la cookie para enviar el jwt al cliente.
    setCookie("jwt", $jwt, $expire, "/", "dwes.es");

    echo "<p>Usuario autenticado. Vaya a la <a href='03jwt_bienvenido.php'>zona restringida</a></p>";
  }
  else {
    echo "<h3>Fallo en la autenticacion</h3>";
  }
  

}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  ?>
    <form method='POST' action="<?= $_SERVER['PHP_SELF'] ?>">
      <img src="usuario.png" alt="">
      <fieldset>
        <legend>Introduzca sus credenciales de usuario</legend>

        <label for="name">Nombre de usuario</label>
        <input type="text" name='usuario' id='usuario' required size='10'>

        <label for="password">Contrasena</label>
        <input type="password" name='passwd' id='password'>

      </fieldset>
      <input type="submit" name='operacion' id='enviarDatos' value='Enviar datos'>
    </form>


  <?php
}

?>