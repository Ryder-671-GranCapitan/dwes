<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/recu/includes/funciones.php');

inicio_html('repetición recuperación ra2-3', ['/recu/styles/formulario.css', '/recu/styles/general.css', '/recu/styles/tablas.css']);

$TAMANIO_MAXIMO_KB = 200;
$TIPOS_MIME_VALIDOS = ['text/csv', 'application/csv', 'application/vnd.ms-excel'];

$tipos_vehiculo = [
    'T' => 'Turismo',
    'F' => 'Furgoneta'
];

$marcas_vehiculo = [
    'f' => 'Fiat',
    'o' => 'Opel',
    'm' => 'Mercedes'
];

echo '<header>REPETICIÓN DEL EXAMEN DE RECUPERACIÓN</header>';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $TAMANIO_MAXIMO_KB * 1024 ?>">
        <fieldset>
            <legend>datos de vehículo</legend>

            <label for="email">email</label>
            <input type="email" name="email" id="email" size="30">

            <label for="tipo">tipo vehículo</label>
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

            <label for="vd">archivo de busqueda</label>
            <input type="file" name="vd" id="vd" accept="text/csv">

        </fieldset>
        <button type="submit">enviar</button>


    </form>

<?php
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
?>
    <a href="<?= $_SERVER['PHP_SELF'] ?>"> volver a empezar</a>
    <?php
    // comprobar subida 
    $tmp_name_fichero = $_FILES['vd']['tmp_name']; //nombre temporal + su ruta
    $_FILES['vd']['name']; // nombre original sin ruta
    $tamanio_fichero = $_FILES['vd']['size']; // tamaño
    $mime_fichero = $_FILES['vd']['type']; // tipo MIME
    $errores_fichero = $_FILES['vd']['error'];

    if ($errores_fichero === UPLOAD_ERR_FORM_SIZE) {
        echo "<h3>error, ha superado el tamaño maximo {$TAMANIO_MAXIMO_KB} KB</h3>";
        exit();
    }

    if (
        !in_array($mime_fichero, $TIPOS_MIME_VALIDOS) ||
        !in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS) ||
        !in_array(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmp_name_fichero), $TIPOS_MIME_VALIDOS)
    ) {
        echo '<h3>Error el archivo no es del tipo correcto</h3>';
        exit(2);
    }

    // abrir el archivo y comprobar los datos con lso del archivo
    $fichero = fopen($tmp_name_fichero, 'r');
    $linea = fgetcsv($fichero);
    

    if ($errores_fichero === UPLOAD_ERR_OK) {
        // Sanear
        $filtro_sanear = [
            'email' => FILTER_SANITIZE_EMAIL,
            'tipo' => FILTER_SANITIZE_SPECIAL_CHARS,
            'marca' => FILTER_SANITIZE_SPECIAL_CHARS,
            'antiguedad' => FILTER_SANITIZE_NUMBER_INT,
            'itv' => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $datos_saneados = filter_input_array(INPUT_POST, $filtro_sanear,);

        // Validar
        $filtro_validar = [
            'email' => FILTER_VALIDATE_EMAIL,
            'tipo' => FILTER_DEFAULT,
            'marca' => FILTER_DEFAULT,
            'antiguedad' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'default' => 1,
                    'min_range' => 1,
                    'max_range' => 5,
                ]
            ],
            'itv' => FILTER_VALIDATE_BOOLEAN
        ];

        $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

        // validar con logica de negocio
        if (!array_key_exists($datos_validados['tipo'], $tipos_vehiculo)) {
            $datos_validados['tipo'] = false;
        }
        if (!array_key_exists($datos_validados['marca'], $marcas_vehiculo)) {
            $datos_validados['marca'] = false;
        }

        //si falta algo, termina
        $array_filtrado = array_filter($datos_validados);

        if (
            count($array_filtrado) < 4 ||
            count($array_filtrado) == 4 && $datos_validados['itv']
        ) {
            echo "<h3>Error datos no validos</h3>";
            exit(3);
        }


        // abrir el archivo y comprobar los datos con lso del archivo
        $fichero = fopen($tmp_name_fichero, 'r');
        $linea = fgetcsv($fichero);


    ?>
        <table>
            <thead>
                <tr>
                    <th><?= $linea[0] ?></th>
                    <th><?= $linea[1] ?></th>
                    <th><?= $linea[2] ?></th>
                    <th><?= $linea[3] ?></th>
                </tr>
            </thead>
            <tbody>

                <?PHP
                while ($linea = fgetcsv($fichero)) {
                    if (
                        $linea[0] == $tipos_vehiculo[$datos_validados['tipo']] &&
                        $linea[1] == $marcas_vehiculo[$datos_validados['marca']] &&
                        $linea[2] == $datos_validados['antiguedad'] &&
                        $linea[3] == ($datos_validados['itv'] ? 'Si' : 'No')
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

                    ?>
            </tbody>
        </table>
<?php

                }
            }
        }
        fin_html();
?>