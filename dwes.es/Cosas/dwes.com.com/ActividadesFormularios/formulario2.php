<!-- Crear un script PHP para consultar los libros de una biblioteca <br>

a) El formulario de entrada de datos incluye: <br>
    | campo  | tipo de campo             | valores                                                                 | <br>
    |--------|---------------------------|-------------------------------------------------------------------------| <br>
    | isbn   | texto                     | formato ###-#-#####-###-#                                               | <br>
    | titulo | texto                     |                                                                         | <br>
    | autor  | lista de selección múltiple| Ken Follet, Max Hastings, Isaac Asimov, Carl Sagan, Steve Jacobson, George R.R. Martin | <br>
    | genero | lista de selección múltiple| Novela, Historia, Divulgación científica, biografía, fantástica         |  <br> <br>


b) La respuesta es una tabla con todos los libros que se ajusten al criterio de búsqueda. <br> <br>

c) Los libros están almacenados en un array asociativo con el isbn como clave. 
Pueden usarse los siguientes: <br> <br>
| Isbn              | Autor             | Titulo                     |Genero                   <br>
|-------------------|-------------------|----------------------------|------------------------- <br>
|123-4-56789-012-3  |Ken Follet         |Los pilares de la tierra    |Novela  histórica <br>
|987-6-54321-098-7  |Ken Follet         |La caída de los gigante     |Historia <br>
|345-1-91827-019-4  |Max Hastings       |La guerra de Churchill      |Biografía <br>
|908-2-10928-374-5  |Isaac Asimov       |Fundación                   |Fantasía <br>
|657-4-39856-543-3  |Isaac Asimov       |Yo, robot                   |Fantasía <br>
|576-4-23442-998-5  |Carl Sagan         |Cosmos                      |Divulgación científica <br>
|398-4-92438-323-2  |Carl Sagan         |La diversidad de la ciencia |Divulgación científica <br>
|984-5-39874-209-4  |Steve Jacobson     |Jobs                        |Biografía <br>
|564-7-54937-300-6  |George R.R. Martin |Juego de tronos             |Fantasía <br>
|677-2-10293-833-8  |George R.R. Martin |Sueño de primavera          |Fantasía <br> -->


<?php
    // Incluye el archivo de funciones solo una vez para evitar duplicados.
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

    // Definición de array de libros, donde cada libro está representado por su ISBN como clave.
    // Cada libro tiene como propiedades 'autor', 'titulo' y 'genero'.
    $libros = [
        "123-4-56789-012-3" => ["autor" => "Ken Follet", "titulo" => "Los pilares de la tierra", "genero" => "Novela histórica"],
        "987-6-54321-098-7" => ["autor" => "Ken Follet", "titulo" => "La caída de los gigante", "genero" => "Historia"],
        "345-1-91827-019-4" => ["autor" => "Max Hastings", "titulo" => "La guerra de Churchill", "genero" => "Biografía"],
        "908-2-10928-374-5" => ["autor" => "Isaac Asimov", "titulo" => "Fundación", "genero" => "Fantasía"],
        "657-4-39856-543-3" => ["autor" => "Isaac Asimov", "titulo" => "Yo, robot", "genero" => "Fantasía"],
        "576-4-23442-998-5" => ["autor" => "Carl Sagan", "titulo" => "Cosmos", "genero" => "Divulgación científica"],
        "398-4-92438-323-2" => ["autor" => "Carl Sagan", "titulo" => "La diversidad de la ciencia", "genero" => "Divulgación científica"],
        "984-5-39874-209-4" => ["autor" => "Steve Jacobson", "titulo" => "Jobs", "genero" => "Biografía"],
        "564-7-54937-300-6" => ["autor" => "George R.R. Martin", "titulo" => "Juego de tronos", "genero" => "Fantasía"],
        "677-2-10293-833-8" => ["autor" => "George R.R. Martin", "titulo" => "Sueño de primavera", "genero" => "Fantasía"]
    ];

    // Llama a una función para iniciar el HTML con el título y estilos CSS especificados.
    inicio_html("Consulta de libros", ["/dwes.com.com/styles/formulario.css", "/dwes.com.com/styles/tablas.css", "/dwes.com.com/styles/general.css"]);

    // Si el formulario fue enviado con el método POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si existe el parámetro 'operacion' en los datos recibidos del formulario.
        if (!isset($_POST['operacion'])) {
            echo "<h3>No se han enviado los datos correctos</h3>";
            fin_html(); // Cierra el HTML si no se enviaron los datos correctos.
        }

        // Función para mostrar todos los libros en una tabla HTML.
        function mostrarLibros($libros) {
            echo "<table border='1'>";
            echo "<tr>
                    <th>ISBN</th>
                    <th>AUTOR</th>
                    <th>TITULO</th>
                    <th>GENERO</th>
                </tr>";
            // Recorre cada libro y muestra sus datos en una fila de la tabla.
            foreach ($libros as $isbn => $libro) {
                // Crea una fila en la tabla para cada libro
            echo "<tr>";
            // Muestra el ISBN del libro
            echo "<td>$isbn</td>";
            // Muestra el autor del libro, o un guion si no está definido
            echo "<td>" . (isset($libro['autor']) ? $libro['autor'] : "-") . "</td>";
            // Muestra el título del libro, o un guion si no está definido
            echo "<td>" . (isset($libro['titulo']) ? $libro['titulo'] : "-") . "</td>";
            // Muestra el género del libro, o un guion si no está definido
            echo "<td>" . (isset($libro['genero']) ? $libro['genero'] : "-") . "</td>";
            // Cierra la fila de la tabla
            echo "</tr>";
            }
            // Cierra la tabla HTML
            echo "</table>";
        }

        // Función para filtrar los libros según los criterios de búsqueda recibidos del formulario.
        function filtradoLibros ($libros, $criterios) {
            $librosFiltrados = []; // Inicializa un array para almacenar los libros que cumplen con el criterio.
            // Variables que almacenan los criterios de búsqueda: ISBN, autor, título y género.
            $isbnFiltrado = $criterios['isbn'];
            $autorFiltrado = $criterios['autor'];
            $tituloFiltrado = $criterios['titulo'];
            $generoFiltrado = $criterios['genero'];

            // Recorre cada libro y aplica los criterios de filtrado.
            foreach ($libros as $isbn => $libro) {
                // Filtra por ISBN exacto si el campo no está vacío.
                if (!empty($isbnFiltrado) && $isbn == $isbnFiltrado) { 
                    $librosFiltrados[$isbn] = $libro;
                }
                // Filtra por autor si está en la lista seleccionada.
                if (!empty($autorFiltrado) && in_array($libro['autor'], $autorFiltrado)) {
                    $librosFiltrados[$isbn] = $libro;
                }
                // Filtra por título si contiene el texto buscado.
                if (!empty($tituloFiltrado) && stripos($libro['titulo'], $tituloFiltrado) !== false) {
                    $librosFiltrados[$isbn] = $libro;
                }
                // Filtra por género si está en la lista seleccionada.
                if (!empty($generoFiltrado) && in_array($libro['genero'], $generoFiltrado)) {
                    $librosFiltrados[$isbn] = $libro;
                }
            }
            mostrarLibros($librosFiltrados); // Muestra la tabla con los libros filtrados.
        }

        // Si la solicitud POST incluye 'operacion', procesa los criterios de búsqueda.
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
            // Recoge los criterios del formulario o asigna un array vacío si no se seleccionaron.
            $criterios = [
                'isbn' => $_POST['isbn'] ?? [],
                'autor' => $_POST['autor'] ?? [],
                'titulo' => $_POST['titulo'] ?? [],
                'genero' => $_POST['genero'] ?? []
            ];

            // Si no se seleccionaron criterios, muestra todos los libros; de lo contrario, aplica el filtro.
            if (empty($criterios['isbn']) && empty($criterios['autor']) && empty($criterios['titulo']) && empty($criterios['genero'])) {
                mostrarLibros($libros);
            } else {
                filtradoLibros($libros, $criterios);
            }
        }

    // Si la solicitud no es POST, muestra el formulario de búsqueda.
    } else { ?>
        <h1>Biblioteca</h1>

        <!-- Formulario HTML para ingresar los criterios de búsqueda -->
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>Datos de Libros</legend>

                <!-- Campo para el ISBN con formato validado -->
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" size="17" pattern="\d{3}-\d-\d{5}-\d{3}-\d">

                <!-- Campo de texto para el título -->
                <label for="titulo">Titulo</label>
                <input type="text" name="titulo" id="titulo">

                <!-- Lista de selección múltiple para el autor -->
                <label for="autor">Autor</label>
                <select name="autor[]" id="autor" multiple>
                <?php
                $autoresUnicos = []; // Evita duplicados en la lista de autores.
                foreach ($libros as $isbn => $libro) {
                    // Agrega el autor a la lista solo si aún no está incluido.
                    if (!in_array($libro['autor'], $autoresUnicos)) {
                        $autoresUnicos[] = $libro['autor'];
                        echo "<option value='" . $libro['autor'] . "'>" . $libro['autor'] . "</option>";
                    }
                }
                ?>
                </select>

                <!-- Lista de selección múltiple para el género -->
                <label for="genero">Genero</label>
                <select name="genero[]" id="genero" multiple>
                <?php
                $generosUnicos = []; // Evita duplicados en la lista de géneros.
                foreach ($libros as $isbn => $libro) {
                    // Agrega el género a la lista solo si aún no está incluido.
                    if (!in_array($libro['genero'], $generosUnicos)) {
                        $generosUnicos[] = $libro['genero'];
                        echo "<option value='" . $libro['genero'] . "'>" . $libro['genero'] . "</option>";
                    }
                }
                ?>
                </select>
            </fieldset>

            <!-- Botón de envío para enviar la operación -->
            <input type="submit" name="operacion" value="enviar">
        </form>
<?php
    fin_html(); // Cierra el HTML si la página
}
?>