<?php
// Realizado en el servidor de dwes.com
require_once($_SERVER['DOCUMENT_ROOT']. "/includes/funciones.php");

// Array con los posibles origines de la información disponibles
$origen = [ 'af'    =>  "Afganistán",
            'cn'    =>  "Corea del Norte",
            'ch'    =>  "China",
            'li'    =>  "Libia"

];

inicio_html("Repesca RA2-3", ["/estilos/general.css", "/estilos/formulario.css", "/estilos/tablas.css"]);

// Presento el formulario
if($_SERVER['REQUEST_METHOD'] == "GET") {

?>

<form method="POST" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" size="<?=1024*10?>">
    <fieldset>
        <legend>Ficha de espías</legend>

        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" required>

        <label for="clave">Nombre en clave:</label>
        <input type="text" name="clave" id="clave" required>

        <label for="origen">Origen de la información:</label>
        <select name="origen[]" id="origen">
<?php
foreach ($origen as $clave => $valor) {
    echo "<option value='$clave'>$valor</option>";
}
?>

</select>

        <label for="destruir">Destruir después de leer:</label>
        <input type="checkbox" name="destruir" id="destruir" value="True">

        <label for="fichero">Información:</label>
        <input type="file" name="fichero" id="fichero" accept="text/plain">
    </fieldset>
    <input type="submit" name="operacion" value="Enviar">
</form>

<?php
}

// Saneamiento y validación
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $filtro_saneamiento = [ 'codigo'    =>  FILTER_SANITIZE_NUMBER_INT,
                            'clave'     =>  FILTER_SANITIZE_SPECIAL_CHARS,
                            'origen'    =>  [   'filter'   =>   FILTER_DEFAULT,
                                                'flags'    =>   FILTER_REQUIRE_ARRAY],
                            'destruir'  =>  FILTER_DEFAULT
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtro_saneamiento);

    $filtro_validación = [  'codigo'    =>  FILTER_VALIDATE_INT,
                            'clave'     =>  FILTER_DEFAULT,
                            'origen'    =>  [   'filter'   =>   FILTER_DEFAULT,
                                                'flags'    =>   FILTER_REQUIRE_ARRAY],
                            'destruir'  =>  FILTER_VALIDATE_BOOL
];

    $datos_validados = filter_var_array($datos_saneados, $filtro_validación);
    
    // Comprobaciones del fichero
    $tipos_mime_validos = [ 'text/plain' ];

    $mime_fichero = $_FILES['fichero']['type'];
    $kb_fichero = $_FILES['fichero']['size'];
    $name_fichero = $_FILES['fichero']['name'];
    $tmp_name_fichero = $_FILES['fichero']['tmp_name'];
    $errores_fichero = $_FILES['fichero']['error'];

    // Error si los datos son erróneos
    
    if ($datos_validados['codigo'] == false) { /*  or $datos_validados['clave'] == "" or (!in_array($datos_validados['origen'], $origen)))*/
        echo '<h3>Error en los datos</h3>';
        exit(0);
    }

    // Error si el tipo mime no es el adecuado
    if (!in_array(mime_content_type($tmp_name_fichero), $tipos_mime_validos)) {
        echo '<h3>Error, el archivo no es del tipo correcto</h3>';
        exit(1);
    }

    // Error si supera el tamaño adecuado
    elseif ($errores_fichero == UPLOAD_ERR_FORM_SIZE) {
        echo '<h3>Error, el archivo supera el tamaño permitido</h3>';
        exit(2);

    }
    
    elseif ($errores_fichero == UPLOAD_ERR_PARTIAL) {
        echo '<h3>Error, el archivo no se ha subido correctamente</h3>';
        exit(3);
    }

    elseif ($errores_fichero == UPLOAD_ERR_NO_FILE) {
        echo '<h3>Error, no se ha subido ningún archivo</h3>';
        exit(4);
    }
    
    else {
        // La primera linea del archivo no corresponde con el codigo
        $fichero = fopen($tmp_name_fichero, 'r');
        $linea = fgets($fichero);
        fclose($fichero);
        $codigo_fichero = trim($linea);
        
        if ($codigo_fichero != $datos_validados['codigo']) {
            echo '<h2>Archivo no verificado</h2>';
            echo '<h3>El código del archivo no coincide con el del formulario</h3>';
            exit(5);

            // Esta era otra forma de hacerlo que descarté
            /*if(file($fichero[0]) != $datos_validados['codigo']) {
            echo '<h3>Error el código del archivo no coincide con el del formulario</h3>';
            exit(5);
            }*/
        }

        // La última linea del archivo no corresponde con el nombre en clave
        // NOTA: ESTO SOLO FUNCIONA SI SE ELIMINA LA ÚLTIMA LINEA EN BLANCO DE LOS ARCHIVOS DE ESPIAS,
        // YA QUE LA FUNCIÓN FEOF SOLO LEE LA ÚLTIMA LÍNEA

        $fichero = fopen($tmp_name_fichero, 'r');
        $linea = '';
        while (!feof($fichero)) {
            $linea = fgets($fichero);
        }
        fclose($fichero);
        $clave_fichero = trim($linea);
        if ($clave_fichero != $datos_validados['clave']) {
            echo '<h2>Archivo no verificado</h2>';
            echo '<h3>El nombre en clave del archivo no coincide con el del formulario</h3>';
            exit(6);
        }

        if ($codigo_fichero == $datos_validados['codigo'] && $clave_fichero == $datos_validados['clave']) {
            echo '<h2>Información confirmada</h2>';
            echo '<h3>El código y el nombre en clave del archivo coinciden con los del formulario</h3>';
            if ($datos_validados['destruir'] == false) {
                // Si no se ha marcado la opción de destruir el archivo, lo guardo en el directorio top_secret
                $directorio_subida = $_SERVER['DOCUMENT_ROOT'] . '/top_secret';
                if (!is_dir($directorio_subida)) {
                    mkdir($directorio_subida, 0755, true);
                }
                $destino = $directorio_subida . '/' . $name_fichero;
                    if (!move_uploaded_file($name_fichero, $destino)) {
                        echo '<h3>Error no se ha podido mover el archivo</h3>'; /* Esto va a salir siempre porque no consigo
                                                                                que el archivo se guarde en el directorio*/
                        exit(7);
                    }
            }

        }
        }

    

    
}

fin_html();
?>