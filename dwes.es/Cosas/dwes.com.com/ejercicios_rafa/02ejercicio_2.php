<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 3</title>
</head>
<body>
  <?php
    /*
      Escribir un script PHP que genera una matriz de 15 filas y 10 columnas de números
      enteros aleatorios y visualizar al final la suma de los elementos de cada fila.
    */
    echo "<h1>Ejercicio 3</h1>";
    $array = [];
    
    // Creamos la matriz con 15 columnas y 10 filas con números enteros aleatorios.
    for($i = 0; $i < 15; $i++){
      for($j = 0; $j < 10; $j++){
        $numRand = rand(1,10);
        $array[$i][$j] = $numRand;
      }
    }
    
    // Mostramos los valores de las columnas y la suma de sus filas.
    echo '<h2>Columnas y filas</h2><br>';
    // Sumamos los valores de cada columna y fila y los mostramos por pantalla.
    for($i = 0; $i < 15; $i++){
      $suma = 0;
      for($j = 0; $j < 10; $j++){
        $suma += $array[$i][$j];
        echo "columna: $i valor fila: {$array[$i][$j]} <br> suma de sus filas en total ===============> $suma<br>";
      }
      echo "<br>";
    }

  ?>
</body>
</html>