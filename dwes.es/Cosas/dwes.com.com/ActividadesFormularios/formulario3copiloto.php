3. Crear un script PHP para gestionar pizzas pedidas por Internet:
a) Todas las pizzas tienen tomate frito y queso como ingredientes básicos, con un
precio inicial de 5 €. <br>

b) Hay pizzas vegetarianas y no vegetarianas. La vegetariana tiene un incremento de
3 €. Las no vegetarianas tienen un incremento de 2 €. <br>

c) El usuario puede añadir todos los ingredientes que quiera dentro de cada clase
de pizza. <br>

d) Crear un formulario para recoger pedidos de pizzas y generar una respuesta con
todos los detalles de la pizza elegida, su coste desglosado y el coste total. <br>

e) Los campos del formulario son: <br>

| Campo     | Tipo de campo | Valores | <br>
|-----------|---------------|---------| <br>
| nombre    | Texto         |         | <br>
| direccion | Texto         |         | <br>
| telefono  | Texto         |         | <br>
| tipo      | Grupo Botones | Vegetariana-No vegetariana | <br>
| ingredientes Veg | Lista de selección múltiple | Pepino - 1 € Calabacín - 1.5 € Pimiento verde - 1.25 €Pimiento rojo - 1.75 €Tomate - 1.5 €Aceitunas - 3 €Cebolla - 1 €|<br> <br>
| ingredientes No Veg | Lista de selección múltiple | Atún - 2 € Carne picada - 2.5 € Peperoni - 1.75 € Morcilla - 2.25 € Anchoas - 1.5 € Salmón - 3 € Gambas - 4 € Langostinos - 4 € Mejillones - 2 €| <br><br>
| Extra Queso | Casilla de verificación | <br>
| Bordes rellenos | Casilla de verificación | <br>
| Nº Pizzas | Numero | Entre 1 - 5| <br> <br> <br>


<?php
// Incluye las funciones generales necesarias para el sistema
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

// Listas de ingredientes y precios por tipo de pizza
$ingredientesVeg = [
    "Pepino" => 1,
    "Calabacín" => 1.5,
    "Pimiento verde" => 1.25,
    "Pimiento rojo" => 1.75,
    "Tomate" => 1.5,
    "Aceitunas" => 3,
    "Cebolla" => 1
];

$ingredientesNoVeg = [
    "Atún" => 2,
    "Carne picada" => 2.5,
    "Peperoni" => 1.75,
    "Morcilla" => 2.25,
    "Anchoas" => 1.5,
    "Salmón" => 3,
    "Gambas" => 4,
    "Langostinos" => 4,
    "Mejillones" => 2
];

// Genera el encabezado de la página HTML
inicio_html("Gestión de pedidos de pizzas", ["/estilos/formulario.css", "/estilos/general.css"]);

// Procesa el formulario si ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operacion']) && $_POST['operacion'] == "mostrarPedido") { // Si se ha enviado el formulario
    mostrarPedido($ingredientesVeg, $ingredientesNoVeg); // Muestra el resumen del pedido y el coste total del mismo
} else {
    // Aquí se muestra el formulario directamente
?>

<!-- Formulario HTML para el pedido de pizza -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required><br>

    <label for="direccion">Dirección:</label>
    <input type="text" name="direccion" id="direccion" required><br>

    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" id="telefono" required><br>

    <label for="tipo">Tipo de pizza:</label>
    <input type="radio" name="tipo" value="Vegetariana" required>Vegetariana
    <input type="radio" name="tipo" value="No vegetariana" required>No vegetariana<br>

    <label for="ingredientesVeg">Ingredientes vegetarianos:</label>
    <select name="ingredientesVeg[]" id="ingredientesVeg" multiple>
        <?php foreach ($ingredientesVeg as $ingrediente => $precio): ?>
            <option value="<?php echo $ingrediente; ?>"><?php echo "$ingrediente - $precio €"; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="ingredientesNoVeg">Ingredientes no vegetarianos:</label>
    <select name="ingredientesNoVeg[]" id="ingredientesNoVeg" multiple>
        <?php foreach ($ingredientesNoVeg as $ingrediente => $precio): ?>
            <option value="<?php echo $ingrediente; ?>"><?php echo "$ingrediente - $precio €"; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="extraQueso">Extra de queso:</label>
    <input type="checkbox" name="extraQueso" id="extraQueso"><br>

    <label for="bordesRellenos">Bordes rellenos:</label>
    <input type="checkbox" name="bordesRellenos" id="bordesRellenos"><br>

    <label for="n_pizzas">Número de pizzas:</label>
    <input type="number" name="n_pizzas" id="n_pizzas" min="1" max="5" required><br>

    <input type="hidden" name="operacion" value="mostrarPedido">
    <input type="submit" value="Enviar">
</form>

<?php
}

// Función para mostrar el resumen del pedido y calcular el coste total
function mostrarPedido($ingredientesVeg, $ingredientesNoVeg) {
    $costeBase = 5; // Precio base de la pizza
    $costeTotal = $costeBase;
    
    // Incremento por tipo de pizza
    $tipoPizza = $_POST['tipo'];
    if ($tipoPizza == "Vegetariana") {
        $costeTotal += 3;
    } elseif ($tipoPizza == "No vegetariana") {
        $costeTotal += 2;
    }

    // Coste extra por ingredientes adicionales
    if ($tipoPizza == "Vegetariana" && isset($_POST['ingredientesVeg'])) {
        foreach ($_POST['ingredientesVeg'] as $ingrediente) {
            $costeTotal += $ingredientesVeg[$ingrediente];
        }
    } elseif ($tipoPizza == "No vegetariana" && isset($_POST['ingredientesNoVeg'])) {
        foreach ($_POST['ingredientesNoVeg'] as $ingrediente) {
            $costeTotal += $ingredientesNoVeg[$ingrediente];
        }
    }

    // Los extras de queso y bordes rellenos no tienen coste adicional
    if (isset($_POST['extraQueso'])) {
        $costeTotal += 0;
    }
    if (isset($_POST['bordesRellenos'])) {
        $costeTotal += 0;
    }

    // Coste total según el número de pizzas
    $numPizzas = $_POST['n_pizzas'];
    $costeTotal *= $numPizzas;

    // Muestra el resumen del pedido
    echo "<h3>Resumen del pedido</h3>";
    echo "<p>Nombre: " . htmlspecialchars($_POST['nombre']) . "</p>";
    echo "<p>Dirección: " . htmlspecialchars($_POST['direccion']) . "</p>";
    echo "<p>Teléfono: " . htmlspecialchars($_POST['telefono']) . "</p>";
    echo "<p>Tipo de pizza: " . $tipoPizza . "</p>";

    // Lista de ingredientes seleccionados
    echo "<p>Ingredientes: ";
    if ($tipoPizza == "Vegetariana" && isset($_POST['ingredientesVeg'])) {
        echo implode(", ", $_POST['ingredientesVeg']);
    } elseif ($tipoPizza == "No vegetariana" && isset($_POST['ingredientesNoVeg'])) {
        echo implode(", ", $_POST['ingredientesNoVeg']);
    }
    echo "</p>";

    echo "<p>Extra de queso: " . (isset($_POST['extraQueso']) ? "Sí" : "No") . "</p>";
    echo "<p>Bordes rellenos: " . (isset($_POST['bordesRellenos']) ? "Sí" : "No") . "</p>";
    echo "<p>Número de pizzas: " . $numPizzas . "</p>";
    echo "<p>Coste total: " . $costeTotal . " €</p>";
}

fin_html();
?>




