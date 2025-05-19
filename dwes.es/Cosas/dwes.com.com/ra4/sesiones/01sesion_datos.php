<?php
  session_start();

  require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/includes/funciones.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/ra4/sesiones/01sesion_verdatos.php');

  inicio_html("Sesiones en PHP", ["./styles/general.css", "./styles/formulario.css"]);
  date_default_timezone_set("Europe/Madrid");

  if ($_SERVER['REQUEST_METHOD'] == "POST" && htmlspecialchars($_POST['operacion']) == "Anadir cosas a la cesta"){
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($email){
      $_SESSION['nombre'] = $nombre;
      $_SESSION['email'] = $email;
    }
    else {
      echo "<h3>Datos personales no validos</h3>";
      echo "<p><a href ='/dwes.com.com/ra4/sesiones/01sesion_cesta.php'>Empezar otra vez</a></p>";
      exit(1);
    }
  }
  if ( isset($_SESSION['email'])){
    ver_datos_session();
    ?>
    <form action="/dwes.com.com/ra4/sesiones/01sesion_cesta.php" method='POST'>
      <fieldset>
        <legend>Anadimos un producto a la cesta</legend>
        
        <label for="dulce">Dulce de Navidad</label>
        <input type="text" name="dulce" id="dulce">

        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad">
      </fieldset>
      <input type="submit" name='operacion' value='Mete en la cesta'>
    </form>
    <?php
  }
  else {
    echo "<h3>Datos personales no validos2</h3>";
    echo "<p><a href ='/dwes.com.com/ra4/sesiones/01sesion_incio.php'>Empezar otra vez</a></p>";
    exit(2);
  }
  fin_html();
?>