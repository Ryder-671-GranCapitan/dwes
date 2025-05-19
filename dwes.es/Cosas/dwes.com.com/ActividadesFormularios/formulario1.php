Crear un script PHP que presente un formulario donde se introduce un número entero
y devuelve una respuesta con el número convertido en varios sistemas: binario, octal,
hexadecimal, decimal. <br> <br>

<?php
    // Incluye un archivo de funciones generales necesarias para el sistema
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

    // Llama a una función para generar el encabezado de la página HTML, incluyendo los estilos CSS
    inicio_html("Formulario de conversion de numeros", ["/estilos/general.css"]);

    // Verifica si el formulario ha sido enviado mediante el método POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verifica si el campo 'numero' está presente en los datos enviados
        if (!isset($_POST['numero'])) {
            echo "<h3>No se han enviado los datos correctos</h3>";
        } else {
            // Captura el valor del número enviado por el formulario
            $numero = $_POST['numero'];

            // Muestra el número en diferentes sistemas numéricos
            echo "Número decimal: $numero<br>";
            echo "Número binario: " . decbin($numero) . "<br>";
            echo "Número octal: " . decoct($numero) . "<br>";
            echo "Número hexadecimal: " . strtoupper(dechex($numero)) . "<br>";
        }
    }
?>

<!-- Formulario HTML para introducir un número entero -->
<form action="<?=$_SERVER['PHP_SELF']?>" method="post"> <!-- El formulario se envía a la misma página -->
    <label for="numero">Introduce un número entero:</label>
    <input type="number" name="numero" id="numero" required>
    <input type="submit" value="Enviar">
</form>

<?php
    // Llama a una función para finalizar el HTML de la página
    fin_html();
?>