<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h2>Array</h2>
  <p>Un array es un conjunto de elementos que se referencian con el mismo nombre. A
    cada variable del array se le conoce como componente o elemento del array.
    Cada componente tiene asociado una clave que se emplea para acceder a ese 
    elemento o ese componente. </p>
  <p> En php los array son muy flexibles. Hay dos tipos, escalares y asociativos.
    Para acceder a un elemento se usa su clave con el operador []. Si la clave es
    un número entero mayor o igual que 0 es un array escalar. Si la clave es una 
    cadena de caracteres es un array asociativo.</p>
  <?php
    $notas = Array(4, 9, 7.5, 6, 2.5);
    $numeros = [8, 4, 2, 9, 5.5];

    echo "La primera nota es $notas[0]<br>";
    echo "La tercea nota es $notas[2]<br>";

    $notas = Array( 2 => 8.5, 4 => 4.75, 8 => 3.5);

    unset($notas[4]);
    
    $notas[5] = rand(1, 10);
    echo "$notas[5]";

    
  ?>

  <h2>Array asociativo</h2>
  <p>Un array asociativo tiene una cadena de caracteres como clave</p>
  <?php
    $coche['1234BBC'] = "Seat León";
    $coche['4321CCB'] = "Ford Focus";

    echo "Mi coche es de la marca {$coche['1234BBC']}";

  ?>
  <h2>Array mixto</h2>
  <p>Cuando las claves son índices numéricos o cadenas indistintamente</p>
  <?php
    $alumno['nombre'] = "Juan Gómez";
    $alumno[0] = 4;
    $alumno[1] = 6;
    $alumno[2] = 5;
    $alumno['media'] = 5;

    echo "El alumno {$alumno['nombre']} y tiene de notas $alumno[0], $alumno[1] y allumno[2].<br>";
  ?>

  <h2>Arrays bidimensionales</h2>
  <p>Arrays con dos dimensiones y por tanto para acceder a un elemento hacen fala dos claves</p>

  <?php
    $notas = Array(
      Array(3.5, 6, 8, 9.5, 3),
      Array(2, 5.5, 6, 2, 10),
      Array(4.5, 3, 2.5, 7, 8),
      Array(7, 1, 0, 1.5, 3.5)
    );

    echo "El elemento en la fila 2 columna 3 es {$notas[1][2]}<br>";

    $notas[][] = 9;

    echo "El elemento en la fila 4 columna 0 es {$notas[4][0]}<br>";

    $notas[3][] = 7.5;

    echo "El elemento en la fila 3 cuarta es {$notas[3][5]}<br>";

    // Array asociativo bidimensional.
    $coches = [
      '1234bbc' => ['marca' => 'Seat', 'modelo' => 'Ibiza', 'motor' => 'Diesel', 'pvp' => 10000],
      '4321ccb' => ['marca' => 'Ford', 'modelo' => 'Focus', 'motor' => 'Gasolina', 'pvp' => 21000]
    ];

    echo "El primer coche es {$coches['1234bbc']['marca']} modelo {$coches['1234bbc']['modelo']}<br>";


    // Crea un array de un equipo de fútbol donde cada fila son las posiciones donde juegan los 
    // jugadores con el conjunto de jugadores identificados por su dorsal.
    $equipo = [
      'Porteros' => [
        'P1' => ['nombre' => 'Ter Stegen', 'dorsal' => 1],
        'P2' => ['nombre' => 'Iñaki Penya', 'dorsal' => 13],
      ],
      'Defensas' => [
        'D1' => ['nombre' => 'Cubarsí', 'dorsal' => 2],
        'D2' => ['nombre' => 'Balde', 'dorsal' => 3],
        'D3' => ['nombre' => 'Araujo', 'dorsal' => 4],
        'D4' => ['nombre' => 'Iñigo Martínez', 'dorsal' => 5],
        'D5' => ['nombre' => 'Crhistensen', 'dorsal' => 15],
        'D6' => ['nombre' => 'Jules Kounde', 'dorsal' => 23],
        'D2' => ['nombre' => 'Eric García', 'dorsal' => 24],
      ]
    ];

    foreach ($equipo as $jugadores => $valor){
      echo "<h2> $jugadores </h2>";
      foreach ($valor as $posicion => $jugador){
        foreach ($jugador as $futbolista => $player){
          echo "El $futbolista: $player<br>";
        }
      }
    }
    

    /*
    for ($i < 0; $i < count(equipo); $i++){

    }
    */


  ?>
</body>
</html>