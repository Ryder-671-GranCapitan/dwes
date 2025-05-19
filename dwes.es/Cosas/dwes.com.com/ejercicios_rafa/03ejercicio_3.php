<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 4</title>
</head>
<body>
  <?php
  /*
    Escribir un script PHP que genera una matriz simétrica de 10 filas por 10 columnas y
    las visualice por pantalla. Una matriz es simétrica si el valor del elemento [i][j] es
    igual al elemento [j][i].
  */

  // Creamos la variable matriz que albergará un array.
  $matriz = [];

  // Generamos nuestra matriz.
  for($i = 0; $i < 10; $i++){
    for($j = 0; $j < 10; $j++){
      $valor = rand(1,20);
      $matriz[$i][$j] = $valor;
      $matriz[$j][$i] = $valor;
    }
  }

  // Visualizamos la matriz
  for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < 10; $j++) {
      echo "| " . $matriz[$i][$j]  . "\t";
    }
    echo "<br>";
  }

  




  ?>
</body>
</html>