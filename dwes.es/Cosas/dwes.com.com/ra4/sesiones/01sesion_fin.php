<?php

session_start();

if ( !isset($_SESSION['nombre']) && !isset($_SESSION['email'])){
  header("Location: /ra4/sesiones/01sesion_incio.php");
}

if ( !isset($_SESSION['cesta'])){
  $_SESSION['cesta'];
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/includes/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/ra4/sesiones/01sesion_verdatos.php');

$KOSTE_KG = 10;

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  inicio_html("Finalizar Sesion", ["./styles/general.css", "./styles/tablas.css"]);
  ver_datos_session();
  echo "<header>Mi cesta de Navidad</header>";
  echo "<table><tr><th>Producto</th><th>Cesta</th></tr>";
  echo "<tbody>";
  foreach($_SESSION['cesta'] as $producto){
    echo "<tr><td>{$producto[0]}</td><td>{$producto[1]}</td></tr>";
    $coste[] = $producto[1];
  }
  echo "</tbody></table>";
  echo "El total de toda la cesta es " . number_format(array_sum($coste) * $KOSTE_KG) . "$";

  // Eliminamos nuestra sesion.
  echo "<p><a href='/dwes.com.com/ra4/sesiones/01sesion_cesta.php?operacion=cerrar'>Cerrar la sesion y empezar otra vez</a></p>";


}


?>