<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Recupera07/includes/funciones.php");

$tipos_disponibles = [
    'tur' => ['nombre' => 'Turismo'],
    'fur' => ['nombre' => 'Furgoneta']
];

$marcas_disponibles = [
    'fi' => ['nombre' => 'Fiat'],
    'op' => ['nombre' => 'Opel'],
    'me' => ['nombre' => 'Mercedes']
];

// Controlamos las peticiones
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    inicio_html("Examen Recuperación RA2-3", ["/Recupera07/estilos/general.css", "/Recupera07/estilos/formulario.css", "/Recupera07/estilos/tablas.css"]);
    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?=1024 * 200?>">
            <fieldset>
                <legend>Busqueda de Vehiculos</legend>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="tipo">Tipo</label>
                    <div>
                        <?php
                            foreach ($tipos_disponibles as $tipo => $valor) {
                                echo "<input type='radio' name='tipo' id='tipo' value='$tipo'>{$valor['nombre']}";
                            }
                        ?>
                    </div>
                
                <label for="marca">Marca</label>
                <select name="marca" id="marca">
                    <?php
                        foreach ($marcas_disponibles as $marca => $valor) {
                            echo "<option name='marca' id='marca' value='$marca'>{$valor['nombre']}</option>";
                        }
                    ?>
                </select>

                <label for="antiguedad">Antigüedad</label>
                <input type="number" id="antiguedad" name="antiguedad" min="1" max="5">

                <label for="itv">ITV</label>
                <input type="checkbox" name="itv" id="itv">

                <label for="archivo">Archivo</label>
                <input type="file" name="archivo" id="archivo" accept="application/csv">
            </fieldset>
            <input type="submit" name="operacion" id="operacion" value="Enviar">
        </form>
    <?php
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    inicio_html("Examen Recuperación RA2-3", ["/Recupera07/estilos/general.css", "/Recupera07/estilos/formulario.css", "/Recupera07/estilos/tablas.css"]);
    // Vamos a crear el array de saneamiento
    $datos_filtrados = [
        'email' => FILTER_SANITIZE_EMAIL,
        'tipo' => FILTER_SANITIZE_SPECIAL_CHARS,
        'marca' => FILTER_SANITIZE_SPECIAL_CHARS,
        'antiguedad' => FILTER_SANITIZE_NUMBER_INT,
        'itv' => FILTER_VALIDATE_BOOLEAN
    ];

    $datos_validados = filter_input_array(INPUT_POST, $datos_filtrados);

    // Validamos los datos
    if (!$datos_validados['email'] || !filter_var($datos_validados['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Email no válido.";
        exit;
    }

    if (!in_array($datos_validados['tipo'], array_keys($tipos_disponibles))) {
        echo "Tipo no válido.";
        exit;
    }

    if (!in_array($datos_validados['marca'], array_keys($marcas_disponibles))) {
        echo "Marca no válida.";
        exit;
    }

    if ($datos_validados['antiguedad'] < 1 || $datos_validados['antiguedad'] > 5) {
        echo "Antigüedad no válida.";
        exit;
    }

    if (!is_bool($datos_validados['itv'])) {
        echo "ITV no válida.";
        exit;
    }

    echo "<p>Email: {$datos_validados['email']}</p>";
    echo "<p>Tipo: {$tipos_disponibles[$datos_validados['tipo']]['nombre']}</p>";
    echo "<p>Marca: {$marcas_disponibles[$datos_validados['marca']]['nombre']}</p>";
    echo "<p>Antigüedad: {$datos_validados['antiguedad']}</p>";
    echo "<p>ITV: " . ($datos_validados['itv'] ? 'Si' : 'No') . "</p>";

    // Subida de archivos
    $ruta_archivo = $_SERVER['DOCUMENT_ROOT'] . "/Recupera07/archivos/vehiculos.csv";
    $tipo_permitido = "text/csv";

    if ($_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        echo "Arvhivo subido con exito<br>";
        if (mime_content_type($_FILES['archivo']['tmp_name']) == $tipo_permitido) {
            echo "El tipo es el permitido";
        }
        $fila = 1;
        if (($gestor = fopen("$ruta_archivo", "r")) !== FALSE) {
            echo "<table><thead><tr><th>Tipo</th><th>Marca</th><th>Antigüedad</th><th>ITV</th></tr></thead><tbody>";
            fgetcsv($gestor, 1000, ",");
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            echo "<tr>";
            foreach ($datos as $campo) {
                echo "<td>" . $campo . "</td>";
            }
            echo "</tr>";
            $fila++;
            }
            echo "</tbody></table>";
            fclose($gestor);
        }
        else {
            echo "Error. El tipo mime no es el esperado";
        }   
    }
    else {
        echo "Error en la subida de archivo";
    }

}

?>