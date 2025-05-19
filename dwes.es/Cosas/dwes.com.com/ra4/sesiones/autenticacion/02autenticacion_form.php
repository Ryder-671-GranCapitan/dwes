<?php

  /*
  
    Se envia un formulario http con POST con el usuario y la contrasena.

    Se verifica el usuario y su contrasena.

    Para el cifrado de la contrasena usamos password_hash() y password_verify().

    Por defecto PASSWORD_DEFAULT utiliza el algoritmo BCRYPT con coste de 10

  */

  // require_once();

  session_start();
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

    $clave = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (autenticacion_usuario($login, $clave)){
      header('Location: /dwes.com.com/ra4/sesiones/autenticacion/02bienvenido.php');
      $_SESSION['usuario'] = $login;
      $_SESSION['nombre'] = $usuarios[$login]['nombre'];
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