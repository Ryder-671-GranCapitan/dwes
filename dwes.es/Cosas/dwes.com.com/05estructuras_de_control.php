<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estructuras de control</title>
</head>
<body>
  <h1>Estructuras de control</h1>

  <h2>Sentencias</h2>
  <p>Las sentencias simples acaban en ;, pudiendo haber más de una en la misma línea</p>

  <?php
    $numero3 = 3;
    echo "El número es $numero<br>";
    $numero += 3;
    print "Ahora es $numero<br>";
  ?>

  <p>Un bloque de sentencias es un conjunto de sentencias encerrados entre llaves. 
    No suelen ir solas, sino formar parte de una estructura de control. 
    Además, se pueden anidar.
  </p>

  <?php
    $numero = 5;
    echo "El número es $numero<br>";
    $numero -= 2;
    echo"Ahora es $numero<br>";
    {
      $numero = 8;
      $numero += 2;
      echo "El resultado es $numero";
    }
    echo "El número es $numero<br>";
  ?>

  
</body>
</html>