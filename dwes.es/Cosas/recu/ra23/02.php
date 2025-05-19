<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/recu/includes/funciones.php");

$autores_lista = [
    "Ken Follet",
    "Max Hastings",
    "Isaac Asimov",
    "Carl Sagan",
    "Steve Jacobson",
    "George R.R. Martin"
];

$generos_lista = [
    "Novela histórica",
    "Divulgación científica",
    "Biografía",
    "Fantasía"
];

$libros = [
    [
        "isbn" => "123-4-56789-012-3",
        "autor" => "Ken Follet",
        "titulo" => "Los pilares de la tierra",
        "genero" => "Novela histórica"
    ],
    [
        "isbn" => "987-6-54321-098-7",
        "autor" => "Ken Follet",
        "titulo" => "La caída de los gigantes",
        "genero" => "Novela histórica"
    ],
    [
        "isbn" => "345-1-91827-019-4",
        "autor" => "Max Hastings",
        "titulo" => "La guerra de Churchill",
        "genero" => "Biografía"
    ],
    [
        "isbn" => "908-2-10928-374-5",
        "autor" => "Isaac Asimov",
        "titulo" => "Fundación",
        "genero" => "Fantasía"
    ],
    [
        "isbn" => "657-4-39856-543-3",
        "autor" => "Isaac Asimov",
        "titulo" => "Yo, robot",
        "genero" => "Fantasía"
    ],
    [
        "isbn" => "576-4-23442-998-5",
        "autor" => "Carl Sagan",
        "titulo" => "Cosmos",
        "genero" => "Divulgación científica"
    ],
    [
        "isbn" => "398-4-92438-323-2",
        "autor" => "Carl Sagan",
        "titulo" => "La diversidad de la ciencia",
        "genero" => "Divulgación científica"
    ],
    [
        "isbn" => "984-5-39874-209-4",
        "autor" => "Steve Jacobson",
        "titulo" => "Jobs",
        "genero" => "Biografía"
    ],
    [
        "isbn" => "564-7-54937-300-6",
        "autor" => "George R.R. Martin",
        "titulo" => "Juego de tronos",
        "genero" => "Fantasía"
    ],
    [
        "isbn" => "677-2-10293-833-8",
        "autor" => "George R.R. Martin",
        "titulo" => "Sueño de primavera",
        "genero" => "Fantasía"
    ]
];

inicio_html("ej2, formularios", ['/recu/styles/formulario.css', '/recu/styles/general.css', '/recu/styles/tablas.css']);

?>

<!-- formulario de búsqueda -->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <input type="hidden" name="localizador" value="ej02">
    <fieldset>
        <legend>Libros Biblioteca</legend>

        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" id="isbn">

        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo">

        <label for="autores">Autor</label>
        <select name="autores[]" id="autores" multiple>
            <?php foreach ($autores_lista as $autor) : ?>
                <option value="<?= $autor ?>"><?= $autor ?></option>
            <?php endforeach; ?>
        </select>

        <label for="generos">Género</label>
        <select name="generos[]" id="generos" multiple>
            <?php foreach ($generos_lista as $genero) : ?>
                <option value="<?= $genero ?>"><?= $genero ?></option>
            <?php endforeach; ?>
        </select>
    </fieldset>

    <button type="submit">Buscar</button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['localizador'] == 'ej02') {

    // Sanear
    $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_SPECIAL_CHARS);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);

    $autores = filter_input(INPUT_POST, 'autores', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $generos = filter_input(INPUT_POST, 'generos', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // Validar ISBN con una expresión regular
    $isbn = $isbn ? filter_var($isbn, FILTER_VALIDATE_REGEXP, [
        "options" => [
            "regexp" => "/^\d{3}-\d-\d{5}-\d{3}-\d$/"
        ]
    ]) : false;

    $titulo = $titulo ? : false;

    // Validar que los autores y géneros seleccionados estén en la lista predefinida
    $autores = $autores ? array_intersect($autores, $autores_lista) : false;
    $generos = $generos ? array_intersect($generos, $generos_lista) : false;
}

fin_html();
?>