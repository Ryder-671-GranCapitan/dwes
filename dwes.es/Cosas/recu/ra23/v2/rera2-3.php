<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/recu/includes/funciones.php');

inicio_html('recuperacion', ['/recu/styles/formulario.css', '/recu/styles/general.css', '/recu/styles/tablas.css']);
$TIPOS_MIME_VALIDOS = ['text/csv'];
$TAMANIO_MAXIMO_KB = 200;
$tipos_vehiculo = [
    'T' => 'Turismo',
    'F' => 'Furgoneta',
];

$marcas_vehiculo = [
    'f' => 'Fiat',
    'o' => 'Opel',
    'm' => 'Mercedes'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $mime_fichero = $_FILES['fichero']['type'];
    $kb_fichero = $_FILES['fichero']['size'];
    $name_fichero = $_FILES['fichero']['name'];
    $tmp_name_fichero = $_FILES['fichero']['tmp_name'];
    $errores_fichero = $_FILES['fichero']['error'];

    if (!in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS)) exit(1);
    if ($kb_fichero > $TAMANIO_MAXIMO_KB * 1024) exit(2);

    if ($errores_fichero == UPLOAD_ERR_OK) {

        $filtro_sanear = [
            'email' => FILTER_SANITIZE_EMAIL,
            'tipo' => FILTER_SANITIZE_SPECIAL_CHARS,
            'marca' => FILTER_SANITIZE_SPECIAL_CHARS,
            'antiguedad' => FILTER_SANITIZE_NUMBER_INT,
            'itv' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $datos_saneados = filter_input_array(INPUT_POST, $filtro_sanear);

        $filtro_validar = [
            'email' => FILTER_VALIDATE_EMAIL,
            'tipo' => FILTER_SANITIZE_SPECIAL_CHARS,
            'marca' => FILTER_SANITIZE_SPECIAL_CHARS,
            'antiguedad' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 5,
                    'max_range' => 1
                ]
            ],
        ];

        $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

        if (!array_key_exists($datos_validados['tipo'], $tipos_vehiculo)) $datos_validados['tipo'] = false;
        if (!array_key_exists($datos_validados['marca'], $tipos_vehiculo)) $datos_validados['marca'] = false;

        $array_filtrado = array_filter($datos_validados);

        if (count($array_filtrado) < 4 || count($array_filtrado) == 4 && $datos_validados['itv']) exit(3);

        $fichero = fopen($tmp_name_fichero, 'r');
        $linea = fgetcsv($fichero);

?>
        <table>
            <thead>
                <th><?= $linea[0] ?></th>
                <th><?= $linea[1] ?></th>
                <th><?= $linea[2] ?></th>
                <th><?= $linea[3] ?></th>
            </thead>

            <tbody>
                <?php
                while ($linea = fgetcsv($fichero)) {
                    if (
                        $linea[0] == $tipos_vehiculo['tipo'] &&
                        $linea[1] == $tipos_vehiculo['marca'] &&
                        $linea[2] == $tipos_vehiculo['antiguedad'] &&
                        $linea[3] == ($tipos_vehiculo['tipo'] ? 'Si' : 'No')
                    ) {
                ?>
                        <tr>
                            <td><?= $linea[0] ?></td>
                            <td><?= $linea[1] ?></td>
                            <td><?= $linea[2] ?></td>
                            <td><?= $linea[3] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    <?php


    } else exit(3);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $TAMANIO_MAXIMO_KB * 1024 ?>">
        <fieldset>
            <legend>Buscar vehiculo</legend>

            <label for="email">email</label>
            <input type="email" name="email" id="email">

            <label for="tipo">tipo vehiculo</label>
            <div>
                <?php foreach ($tipos_vehiculo as $key => $value) : ?>
                    <input type="radio" name="tipo" id="tipo" value="<?= $key ?>"> <?= $value ?>
                <?php endforeach; ?>
            </div>

            <label for="marca">marca</label>
            <select name="marca" id="marca">
                <?php foreach ($marcas_vehiculo as $key => $value) : ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>

            <label for="antiguedad">antiguedad</label>
            <input type="text" name="antiguedad" id="antiguedad">

            <label for="itv">itv</label>
            <input type="checkbox" name="itv" id="itv">

            <label for="fichero">fichero</label>
            <input type="file" name="fichero" id="fichero">

        </fieldset>

        <button type="submit">enviar</button>
    </form>
<?php
}


fin_html();
?>