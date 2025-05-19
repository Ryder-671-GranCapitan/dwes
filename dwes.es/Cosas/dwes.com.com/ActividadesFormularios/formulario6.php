Crear un script PHP con un sticky form en el que se registran propuestas de los
donantes de una ONG a actuaciones en proyectos de ayuda al desarrollo en un país
del tercer mundo.
a) En cada petición hay que presentar los datos enviados en formato de tabla y
volver a generar el formulario con los datos de la petición anterior.
b) La página es autogenerada.
c) Los campos del formulario son:

| Campo             | Tipo de campo             | Valores                    <br>
|-------------------|-------------------        |----------------------------<br>
|Email              |Email                      |<br>
|Autorizo registro  |Checkbox                   |<br>
|Cantidad           |number                     |<br>
|Proyecto           |Lista de seleccion unica   |Agua potable, escuela primaria, placas solares, centro medico<br>
|Propuesta          |Area de texto              |<br>

<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

    inicio_html("Formulario 6", ["/estilos/general.css", "/estilos/tablas.css", "/estilos/formulario.css"]);

    $email = $autorizo = $cantidad = $proyecto = $propuesta = "";
    $errores = [];
    $proyectos = ["Agua potable", "Escuela primaria", "Placas solares", "Centro médico"];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $autorizo = isset($_POST["autorizo"]) ? "checked" : "";
        $cantidad = $_POST["cantidad"];
        $proyecto = $_POST["proyecto"];
        $propuesta = $_POST["propuesta"];
        
        if (empty($email)) {
            $errores[] = "El email es obligatorio";
        }
        
        if (empty($cantidad)) {
            $errores[] = "La cantidad es obligatoria";
        }
        
        if (empty($proyecto)) {
            $errores[] = "El proyecto es obligatorio";
        }
        
        if (empty($propuesta)) {
            $errores[] = "La propuesta es obligatoria";
        }
    }

    echo "<table border='1'>";
    echo "<tr><th>Email</th><th>Autorizo registro</th><th>Cantidad</th><th>Proyecto</th><th>Propuesta</th></tr>";
    echo "<tr><td>$email</td><td>$autorizo</td><td>$cantidad</td><td>$proyecto</td><td>$propuesta</td></tr>";
    echo "</table>";

    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
    echo "<label for='email'>Email:</label>";
    echo "<input type='email' name='email' value='$email'><br>";
    echo "<label for='autorizo'>Autorizo registro:</label>";
    echo "<input type='checkbox' name='autorizo' $autorizo><br>";
    echo "<label for='cantidad'>Cantidad:</label>";
    echo "<input type='number' name='cantidad' value='$cantidad'><br>";
    echo "<label for='proyecto'>Proyecto:</label>";
    echo "<select name='proyecto'>";
    foreach ($proyectos as $p) {
        echo "<option value='$p' " . ($proyecto == $p ? "selected" : "") . ">$p</option>";
    }
    echo "</select><br>";
    echo "<label for='propuesta'>Propuesta:</label>";
    echo "<textarea name='propuesta'>$propuesta</textarea><br>";
    echo "<input type='submit' value='Enviar'>";
    echo "</form>";

    if (!empty($errores)) {
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }

?>