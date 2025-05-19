<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elementos del lenguaje</title>
</head>
<body>
    <h1>Elementos del lenguaje en PHP</h1>
<?php

?>

<hr>
    <h2>Entrada y salida</h2>
    <p>La entrada de datos es mediante un formulario HTML o con un enlace. La salida de datos se produce con la función echo y su forma abreviada y la funcion print.
        Además para la salida de datos con formato usamos printf
    </p>
    <h3>Función echo</h3>
    <?php 
        echo "<p>La función echo emite el resultado de una expresión a la salida. Se puede usar como función o como construcción del lenguaje (sin parentesis)</p>";
        echo "<p>Esto es un parrafo HTML enviado por echo</p>";
        
        $nombre = "Alfonso";
        echo "Hola ", $nombre, " que tal?<br>";
        // echo("Hola", $nombre, "que tal?"); MÁS DE UN ARGUMENTO NANAI
        echo ("Hola Alfonso, que tal <br>");

        // Quiero un salto de linea al final de la liunea
        echo "Hola, esta linea acaba en un salto\n";
        echo "Supuestamente esta linea es la siguiente a la anterior\n y esta va después";
    
        $nombre = "Adrian";
        $apellidos = "Ramirez Velasco";

        echo "<br>Mi nombre es $nombre $apellidos";
        echo "<br>Mi nombre es ". $nombre. " y mis apellidos ". $apellidos. "<br>";
        echo "<br>Mi nombre es ", $nombre, " y mis apellidos ", $apellidos, "<br>";
        echo "<br>Uno más dos son ", 1 + 2 , " y tiene que haber salido 3<br>";
        echo "<br>Uno más dos son ". 1 + 2 . " y tiene que haber salido 3<br>";
        echo "<h4>Forma abreviada de echo</h4>";
        echo "<p>Cuando hay que enviar a la salida el resultado de una expresion pequeña disponemos de la forma abreviada de echo que permite intercalar el codigo HTML con menos esfuerzo</p>";
        $portatil = true;
    ?>

<!-- LA FORMA ABREVIADA DE ECHO VA DENTRO DEL HTML-->
     <!-- &lt;?=expresion&gt; equivale a &lt?php echo expreion ?&gt; -->
    <p>Mi nombre es <?= $nombre , " " , $apellidos?> y estoy programando en php</p>
    <!-- uso my habitual. valores por defecto en controles de formulario -->
     <input type="text" name="nombre" size="15" value='<?=$nombre?>'><br>
     <input type="checkbox" name="portatil" <?= $portatil ? 'checked' : ''?> >Tienes portatil?<br>
     <!-- CONSEJO: LAS CADENAS EN PHP CON " Y EN HTML CON '-->
      <?php 
        echo "<input type='text' name='apellidos' size='50'>";
      ?>
    <h3>Función print</h3>
    <?php 
        print "<p>Esto es una cadena\nque tiene mas de una linea y se envian a la salida</p>";
        print "<p>Mi nombre es $nombre $apellidos<br></p>";
    ?>
    <h3>Función printf</h3>
    <?php 
        $pi = 3.14159;
        $radio = 3;
        $circuferencia = (2 * $pi) * $radio;
        printf("<br>LA cirsscuferencia de radio %d es %5.2f", $radio, $circuferencia);
    ?>
</body>
</html>