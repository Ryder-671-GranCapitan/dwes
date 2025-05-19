<?php

session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/includes/funciones.php');

inicio_html();

if ( isset($_SESSION['usuario'], $_SESSION['nombre'])){
  echo "<h3>Bienvenido {$_SESSION['nombre']}</h3>";
  echo "<p>Su login es {$_SESSION['login']}</p>";
  echo "<p>Si lo desea puede cerrar la sesion <a href='/dwes.com.com/ra4/sesiones/autenticacion/02cierre_session.php'>aqui</a></p>";
}
else {
  echo "<h3>Usted no se ha autenticado todavia</h3>";
  echo "<p><a href='/dwes.com.com/ra4/sesiones/autenticacion/02autenticacion_form.php'>Ir a la autenticacion</a></p>";
}
fin_html();

?>
