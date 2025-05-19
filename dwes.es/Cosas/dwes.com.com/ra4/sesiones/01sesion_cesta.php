<?php

session_start();
date_default_timezone_set("Europe/Madrid");

require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/includes/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/ra4/sesiones/01sesion_verdatos.php');

  inicio_html("Sesiones en PHP", ["./styles/general.css", "./styles/tablas.css"]);
  

  echo "<header> Mi cesta de Navidad </header>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion'] == 'Mete en la cesta')){
    $dulce = filter_input(INPUT_POST, 'dulce', FILTER_SANITIZE_SPECIAL_CHARS);
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_FLOAT);
    $canitdad = filter_var($cantidad, FILTER_VALIDATE_FLOAT,
                Array('options' => ['min_range' => 1, 'default' => 1],
                      'flags' => FILTER_FLAG_ALLOW_FRACTION));

    $_SESSION['cesta'][] = Array($dulce, $cantidad);

    echo"<p>Estupendo!! Ya hemos anadido el producto a tu cesta</p>";
    echo"<p>Aqui tienes tu cesta</p>";

    echo "<table><thead><tr><th>Producto</th><th>Cantidad</th></tr></thead>";
    echo "<tbody>";
    foreach ($_SESSION['cesta'] as $clave){
      echo "<tr><td>{$clave[0]}</td><td>{$clave[1]}</td></tr>";
    }
    echo "</tbody> </table>";

    echo "<h3>Si lo desea puede anadir otro producto a su cesta</h3>";
    echo "<p><a href ='/dwes.com.com/ra4/sesiones/01sesion_datos.php'>Anadir producto</a></p>";

    echo "<h3>O puede finalizar su cesta</h3>";
    echo "<p><a href ='/dwes.com.com/ra4/sesiones/01sesion_fin.php'>Finalizar su cesta</a></p>";
    
  }
  ver_datos_session();
  fin_html();
?>