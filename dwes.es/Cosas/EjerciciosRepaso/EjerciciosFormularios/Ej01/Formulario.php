<!-- BIBLIOTECA -->

<?php
    // Importamos los archivos que nos van a hacer falta
    require_once($_SERVER['DOCUMENT_ROOT'] . '/EjerciciosRepaso/EjerciciosFormularios/includes/funciones.php');

    $fichero_subida = $_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/EjerciciosFormularios/Subida";

    // Array de libros
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

// Si la petición a la página es GET
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    inicio_html("Pantalla principal", ['./styles/general.css', './styles/formulario.css']);
    echo "<h1>Bienvenido a la librería</h1>"
    // Generación del formulario
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?=100 * 1024?>">
        <fieldset>
            <legend>Ingresa los datos de búsqueda</legend>
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo">
            <label for="autor">Autor</label>
            <select name="autor[]" id="autor" multiple>
                <?php
                $autores = [];
                foreach($libros as $libro){
                    if (!in_array($libro['autor'], $autores)){
                        echo "<option value='{$libro['autor']}'>{$libro['autor']}</option>";
                        $autores[] = $libro['autor'];
                    }
                }
                ?>
            </select>
            <label for="genero">Género</label>
            <select name='genero[]' id="genero" multiple>
            <?php
                $generos = [];
                foreach($libros as $libro){
                    if (!in_array($libro['genero'], $generos)){
                        echo "<option value='{$libro['genero']}'>{$libro['genero']}</option>";
                        $generos[] = $libro['genero'];
                    }
                }
                ?>
            </select>

            <label for="archivo">Archivo</label>
            <input type="file" name="archivo" id="archivo" accept="application/pdf">

        </fieldset>
        <input type="submit" name="operacion" id="operacion" value="Buscar">
    </form>

    <?php

    fin_html();
}

// Si la petición es POST
else if ($_SERVER['REQUEST_METHOD'] ='POST'){
    // Array de saneamiento
    $valores_saneamiento = [
        'isbn' => FILTER_SANITIZE_SPECIAL_CHARS,
        'titulo' => FILTER_SANITIZE_SPECIAL_CHARS,
        'autor' => [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'genero' => [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS, 
            'flags' => FILTER_REQUIRE_ARRAY
        ]
    ];

    // Datos saneados
    $datos_saneados = filter_input_array(INPUT_POST, $valores_saneamiento);

    // Validación de datos
    $regexp =  '/^\d{3}-\d-\d{5}-\d{3}-\d$/';
    if (!preg_match($regexp, $datos_saneados['isbn'])){
        echo "El isbn no es válido";
    }

    // Intentamos búscar en el array según nos indique el cliente
    $array_datos_busqueda = '';
    foreach($libros as $libro => $valor){

        if (!empty($datos_saneados['isbn'] && $datos_saneados['isbn'] == $libro)){
            $array_datos_busqueda .= "$libro -> Título: {$valor['titulo']}, Género: {$valor['genero']}, Autor: {$valor['autor']}<br>";
        }
        if (!empty($datos_saneados['titulo'] && $datos_saneados['titulo'] == $valor['titulo'])){
            $array_datos_busqueda .= "$libro -> Título: {$valor['titulo']}, Género: {$valor['genero']}, Autor: {$valor['autor']}<br>";
        }
        if (!empty($datos_saneados['autor'])){
            foreach($datos_saneados['autor'] as $dato){
                if (in_array($dato, $valor)){
                    $array_datos_busqueda .= "$libro -> Título: {$valor['titulo']}, Género: {$valor['genero']}, Autor: {$valor['autor']}<br>";
                }
            }
            
        }
        if (!empty($datos_saneados['genero'] && stripos(implode(',', $datos_saneados['genero']), $valor['genero']))){
            $array_datos_busqueda .= "$libro -> Título: {$valor['titulo']}, Género: {$valor['genero']}, Autor: {$valor['autor']}<br>";
        }

        }
        echo "<h1>Estos son los datos de búsqueda</h1>";
        echo "<h2>$array_datos_busqueda</h2>";

        // Subir el archivo
        if ($_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $tipo_mime_archivo = mime_content_type($_FILES['archivo']['tmp_name']);
            $tipo_mime_subido = $_FILES['archivo']['type'];
            $tipo_mime_permitido = "application/pdf";

        if ($tipo_mime_permitido == $tipo_mime_archivo && $tipo_mime_permitido == $tipo_mime_subido) {
            if (!file_exists($fichero_subida) || !is_dir($fichero_subida)) {
                if (!mkdir($fichero_subida, 0755)) {
                    echo "<h4>Error en la subida de archivo. No se pudo crear la carpeta de subida</h4>";
                }
            }

            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subida . '/' . $_FILES['archivo']['name'])) {
                echo "<h3>Subida del archivo</h3>";
                    echo "<p>Nombre del archivo subido: {$_FILES['archivo']['name']}<br>";
                    echo "<p>Tamaño: {$_FILES['archivo']['size']} bytes<br>";
                    echo "<p>Nombre temporal: {$_FILES['archivo']['tmp_name']}<br>";
            }
            else {
                    echo "<h4>Error en la subida de archivo. No se ha podido guardar el archivo</h4>";
            }
        }
        else {
        echo "<h4>Error en el archivo subido. Solo se permiten archivos PDF</h4>";
        }
    }
    else {
        echo "<h4>Error en la subida de archivo</h4>";
    }
}
?>