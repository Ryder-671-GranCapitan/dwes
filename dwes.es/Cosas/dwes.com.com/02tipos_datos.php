<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de datos</title>
</head>
<body>
    <h1>Tipos de datos</h1>
    <h2>Tipos de datos escalables</h2>
    <ul>
        <li>Booleanos</li>
        <li>Numero entero</li>
        <li>En coma flotante</li>
        <li>Cadena de caracteres</li>
    </ul>
    <h2>Datos compuestos</h2>
    <ul>
        <li>Arrays</li>
        <li>Objetos</li>
        <li>Callable</li>
        <li>Iterable</li>
    </ul>
    <h2>Tipos especiales</h2>
    <ul>
        <li>Resource</li>
        <li>NULL</li>
    </ul>
</body>

<h2>BOOLEAN</h2>
<p>Inicialmente las constantes true o false. Sin embargo, otros tipos de datos tienen conversión implicita al tipo booleano</p>
<ul>
    <li>Numero entero 0 y el -0, cualquier otra cosa true</li>
    <li>Numerco en coma flotante: 0.0 y -0.0 es false, otro valor es true</li>
    <li>Un array con 0 elementos es FALSE, con elementos es TRUE</li>
    <li>El tipo especial NULL es false, otro distinto de NULL es true</li>
    <li>Una variable no definida es false</li>
</ul>
<?php
    $valor_boolean = true;
    $edad = 20;
    $mayor_edad = $edad > 18;
    
    echo "Mayor de edad es booleano: " . is_bool($mayor_edad);

    $dinero = 10;
    if ($dinero) echo "<br>Soy rico<br>";
    else echo "<br>Estoy arruinado<br>";

    $mi_nombre = "Alfonso";
    if ($mi_nombre) echo "<br>Me llamo $mi_nombre<br>";
    else echo"<br>No tengo nombre<br>";
?>

<h2>Enteros</h2>
<p>Números enteros en PHP son de 32 bits (dependede la plataforma). Pueden expresarse en diferentes notaciones</p>
<?php
    $numero_entero = 16;
    echo "El numero entero es $numero_entero<br>";

    $numero_negativo = -16;
    echo "El numero entero negativo es $numero_negativo<br>";

    // si quiero mostrar un numero en formato octal
    $numero_octal = 0123;   // CON 0 DELANTE
    echo "El numero 0123 en octal es en decimal: $numero_octal<br>";
    
    // pUEDO MOSTRAR UN NUMERO ENTERO EN octal
    echo "el numero $numero_octal es en octal " .decoct($numero_octal) . "<br>";

    //Numero entero en hexadecimal
    $numero_hex = 0x8AE;
    echo "El numero 0x8AE en hexadecimal es en decimal: $numero_hex <br>";

    // mostrar un numero expresado en hexadecimal
    echo "El numero $numero_hex en hexadecimal es " . dechex($numero_hex) . "<br>";

    //Un numero entero en binario
    $numero_binario = 0b1101010;
    echo "El numero 1101010 es en decimal: $numero_binario<br>";

    //mostrar un numero expresado en binario
    echo "El numero $numero binario es " .decbin($numero_binario) . "<br>"
?>

<h2>Numeros en punto flotante</h2>
<p>El separador decimal es el punto . y se pueden expresar numeros muy grandes y muy pequeños mediante la notación cientifica con base 0</p>
<?php
    $pi = 3.14159;
    echo "El numero PI es = $pi<br>";
    echo "El PI con 3 decimales es " . round($pi, 3) . "<br>";

    $inf_int = 7.9e13;
    echo "Informacion que circula en Internet en un dia $inf_int<br>";

    $tam_virus = 0.2e-9;
    echo "Un virus tiene un tamaño de $tam_virus<br>"
?>
<h2>Cadenas de caracteres</h2>
<p>Un string o cadena es una serie de caracteres donde cada caracter equivale a un byte. Esto significa que PHP solo admite 256 caracteres y por ello no ofrece soporte nativo a utf-8. Un literal de tipo string se expresa de 4 formas:</p>
<ul>
    <li>Comillas simples</li>
    <li>Comillas dobles</li>
    <li>Heredoc</li>
    <li>Nowdoc</li>
</ul>

<h3>Comillas simples</h3>
<?php 
    //Una cadena encerrada entre comullas simples
    // Solo admite el caracter escape

    echo 'Esto es una cadena sencilla<br>';
    echo 'Puedo poner una cadena
    en varias lineas
    porque la sentencia
    no acaba
    hasta el punto y coma<br>';

    // No se reconcen caracteres de excape excepto ' y el \
    echo 'El mejor pub de la ciudad es O\'Donnel<br>';
    echo 'La raíz del discod duro es C:\<br>';
    

    // El saloto de linea no se expande
    echo 'Esta cadena tiene\nmas de una linea<br>'
?>
<h3>Comillas dobles</h3>
<p>Es la forma habitual de expresar cadenas de caracteres</p>
<?php
    $cadena = "Esto es una cadena con comillas dobles";
    echo "Es una cadena un objeto? " . is_object($cadena) . "<br>";
    if( is_object($cadena) ) echo "Las cadenas en PHP son objetos<br>";
    else echo "Las cadenas en PHP no son objetos<br>";

    $con_secuencias_esc = "\t\tEl simbolo \$ se emplea para las variables\n y 
    si lo quieres en una cadena hay que escaparlo con \\Es mejor usar \" para 
    delimitar las cadenas en lugar de '<br>";

    echo $con_secuencias_esc;
?>

<h3>Cadenas HEREDOC</h3>
<p>Es una cadena muy larga que le sigue <<< le sigue un identificador y justo despues un salto de línea. 
A continuación se escribe la cadena con los saltos de línea que necesitemos, podemos interpolar variables y poner caracteres de escape. 
Para finalizar hay que hacer un salto de línea y volver a poner el identificador.</p>
<?php
    $cadena_hd = <<<HD
    Esto es una cadena
    heredoc que respeta los
    saltos de línea, le puedo
    poner variables como 
    $mi_nombre y 
    además secuencias de escape. El
    identificador no necesita \$ y tampoco
    usamos ", simplemente la escribimos y 
    acabamos con un salto de línea más el identificador.<br>
    HD;
    
    echo $cadena_hd;
?>

<h3>Cadena NOWDOC</h3>
<p>La cadena NOWDOC es como Herodocc con comillas simples. No se interpolan variables
    ni se reconocen secuencias de escape más allá de \ y '. Si se respetan los
    saltos de línea.
</p>
<?php
    $cadena_nd = <<< 'ND'
    Esto es una cadena nowdoc
    y el salto de línea no lo respeta,
    no puedo meter variables
    y solo reconoce \\ y \'.<br>
    ND;

    echo $cadena_nd;
?>

<h2>Conversión de tipos de datos</h2>
<p>Hay dos tipos de conversiones: implícitas y explicitas: Las primeras ocurren cuando
    en una expresión hay operandos de diferente tipo. PHP convierte algunos de ellos para evaluar la expresión.
</p>
<?php
    $cadena = "25";
    $numero = 8;
    $booleano = True;
    $resultado = $cadena + $numero + $booleano;
    echo "El resultado es $resultado<br>";

?>

<p> ¡¡¡ IMPORTANTE !!!. Cuando se hace una conversión implicita solo afecta 
    al operando, pero no a la variable. Es decir, la conversión de $cadena a entero
    solamente para evaluar la expersión, pero $cadena sigue siendo de tipo string.
</p>

<?php
    $flotante = 3.5;
    $resultado = $cadena + $flotante + $numero + $booleano;
    echo "El resultado es $resultado<br>";

    $cadena = "25 marranos dan mucho provecho";
    $resultado = $numero + $cadena;
    echo "El resultado es es $resultado<br>";
?>

<p>
    Conversiones explícitas se conocen como casting o moldeo y se hacen
    precediendo la expresión con el tipo de datos a convertir entre paréntesis.
</p>
<?php
    //Si quiero convertir a un entero -> (int)expresión
    //Si quiero convertir a float ->    (float)expresión
    //Si quiero convertir a string ->   (string)expresión

    echo "Conversiones a entero<br>";
    $valor_booleano = True;
    $valor_convertido = (int)$valor_booleano;
    echo "El valor convertido a entero es $valor_convertido<br>";
    $valor_float = 3.1416;
    $valor_convertido = (int)$valor_float;
    echo "El valor convertido a entero es $valor_convertido<br>";
    $valor_cadena = "123";
    $valor_convertido = (int)$valor_cadena;
    echo "El valor convertido a entero es $valor_convertido<br>";
?>



</html>