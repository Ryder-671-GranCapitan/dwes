<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/examen00/include/funciones.php");

define("PRECIO_CLASE_PRESENCIAL", 10);
define("DESCUENTO_DESEMPLEO", 0.1);
define("CARPETA_SUBIDA", $_SERVER['DOCUMENT_ROOT'] . "/examen00/tarjetas");

$cursos = [ 'ofi'   => ['descripcion' => 'Ofimática', 'precio' => 100],
            'pro'   => ['descripcion' => 'Programación', 'precio' => 200],
            'rep'   => ['descripcion' => 'Reparación ordenadores', 'precio' => 150]
];

function SaneaYValidaDatos() {
    global $cursos;

    // Recogemos los datos del formulario
    $saneamiento_datos = ['email'       => FILTER_SANITIZE_EMAIL,
                          'cursos'      => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                                            'flags' => FILTER_REQUIRE_ARRAY],
                          'clases'      => FILTER_SANITIZE_NUMBER_INT,
                          'desempleo'   => FILTER_DEFAULT        // El checkbox solo se valida
        ];

    $datos_saneados = filter_input_array(INPUT_POST, $saneamiento_datos, false);

    // La validación la hacemos en cada campo al tener que usar lógica de aplicación
    // en algunos de ellos
    $datos_validados['email'] = filter_var($datos_saneados['email'], FILTER_VALIDATE_EMAIL);
    
    $cursos_ok = True;
    foreach( $datos_saneados['cursos'] as $curso_recibido ) {
        if( !array_key_exists($curso_recibido, $cursos) ) {
            $cursos_ok = False;
            break;
        }
    }
    if( $cursos_ok ) $datos_validados['cursos'] = $datos_saneados['cursos'];
    else $datos_validados['cursos'] = False;
    
    $datos_validados['clases'] = filter_var($datos_saneados['clases'], FILTER_VALIDATE_INT,
                                           ['min_range' => 5, 'max_range' => 10]);

    
    $datos_validados['desempleo'] = filter_var($datos_saneados['desempleo'], FILTER_VALIDATE_BOOL);

    return $datos_validados;
}

function PresentaDatosEnviados($datos_validados) {
    global $cursos;

    echo "<table><thead><tr><th>Email</th><th>Cursos solicitados</th><th>Clases presenciales</th><th>Desempleo</th>";
    echo "<tbody><tr>";
    echo "<td>" . ($datos_validados['email'] ? $datos_validados['email'] : "El email no es válido") . "</td>";
    echo "<td>";
    if( is_array($datos_validados['cursos']) ){
        foreach( $datos_validados['cursos'] as $curso ) {
            echo "{$cursos[$curso]['descripcion']} - {$cursos[$curso]['precio']}€<br>";
        }
    }
    echo "</td>";
    echo "<td>" . ($datos_validados['clases'] ? $datos_validados['clases'] : "El número de clases no es válido") . "</td>";
    echo "<td>" . ($datos_validados['desempleo'] ? "Desempleado" : "NO es desempleado") . "</td>";
    echo "</tr></tbody></table>";

    if( !$datos_validados['email'] || !$datos_validados['cursos'] || !$datos_validados['clases']) {
        return False;
    }
    return True;
}

function PresentarPresupuesto($datos_validados) {
    global $cursos;

    echo "<h3>Presupuesto de formación online</h3>";
    $total = 0;

    echo "<h4>Cursos elegidos</h4>";
    echo "<p>";
    $importe_cursos = 0;
    foreach($datos_validados['cursos'] as $curso) {
        echo "{$cursos[$curso]['descripcion']} - {$cursos[$curso]['precio']}€<br>";
        $importe_cursos += $cursos[$curso]['precio'];
    }
    echo "</p>";
    echo "<p>Importe total de los cursos: $importe_cursos €</p>";
    $total += $importe_cursos;

    $importe_clases = PRECIO_CLASE_PRESENCIAL * $datos_validados['clases'];

    echo "<h4>Incremento por las clases presenciales</h4>";
    echo "<p>Son {$datos_validados['clases']} presenciales. El incremento por las clases presenciales es $importe_clases €</p>";
    $total += $importe_clases;

    echo "<h4>Descuento por situación de desempleo</h4>";
    if( $datos_validados['desempleo'] ) {
        echo "<p>Al estar en situación de desempleo tiene un descuento del " . (DESCUENTO_DESEMPLEO * 100) . "%</p>";
        $descuento = $total * DESCUENTO_DESEMPLEO;
        echo "<p>El importe del descuento es $descuento €</p>";
        $total -= $descuento;

    }
    else {
        echo "<p>Al estar empleado no hay descuento por situación de desempleo</p>";
    }

    echo "<h4>Total presupuesto: $total €</h4>";
}

function SubidaArchivo($nombre_archivo) {

    if( $_FILES['tarjeta']['error'] == UPLOAD_ERR_OK ) {

        // Hay subida de archivo. Verificamos el tipo
        $tipo_mime_detectado = mime_content_type($_FILES['tarjeta']['tmp_name']);
        $tipo_mime_subido = $_FILES['tarjeta']['type'];
        $tipo_permitido = "application/pdf";

        if( $tipo_permitido == $tipo_mime_detectado && $tipo_permitido == $tipo_mime_subido ) {
            // Es un PDF. Guardamos el archivo
            if( !file_exists(CARPETA_SUBIDA) || !is_dir(CARPETA_SUBIDA) ) {
                if( !mkdir(CARPETA_SUBIDA, 0755) ) {
                    echo "<h4>Error en la subida de archivo. No se ha podido crear la carpeta de subida</h4>";   
                }              
            }

            // Guardamos el archivo 
            if( move_uploaded_file($_FILES['tarjeta']['tmp_name'], CARPETA_SUBIDA . "/$nombre_archivo.pdf" ) ) {
                echo "<h3>Subida del archivo</h3>";
                echo "<p>Nombre del archivo subido: {$_FILES['tarjeta']['name']}<br>";
                echo "<p>Tamaño: {$_FILES['tarjeta']['size']} bytes<br>";
                echo "<p>Nombre guardado: $nombre_archivo.pdf<br>";
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
inicio_html("Examen RA2-3", ["/examen00/estilos/general.css", "/examen00/estilos/formulario.css", "/examen00/estilos/tabla.css"]);
echo "<header>Examen RA2-3</header>";

// Si hay petición se procesa el formulario
if( $_SERVER['REQUEST_METHOD'] == "POST") {

    // Saneamos y validamos los datos del formulario
    $datos_validados = SaneaYValidaDatos();
   
    // Presentamos los datos. Si alguno no se ha validado no se puede continuar.
    if( !PresentaDatosEnviados($datos_validados) ) {
        echo "<h3>Algunos de los datos enviados no es válido. Revise la lista</h3>";
        echo "<p><a href='{$_SERVER['PHP_SELF']}'>Vuelva a intentar introducir los datos</a></p>";
        fin_html();
        exit(1);
    }

    // Los datos están validados. Calculamos el presupuesto
    PresentarPresupuesto($datos_validados);

    // Si está en desempleo se verifica la subida del archivo. 
    if( $datos_validados['desempleo']) {
        SubidaArchivo($datos_validados['email']);
    }
    else {
        echo "<h4>Al no estar en situación de desempleo no se necesita Tarjeta de Demanda de Empleo</h4>";
    }
}
elseif( $_SERVER['REQUEST_METHOD'] == "GET")  {
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
    <!-- Límite de tamaño de archivo en el formulario para PHP -->
    <input type="hidden" name="MAX_FILE_SIZE" value="<?=100 * 1024?>">
    <fieldset>
        <legend>Academia Online - Cursos de formación</legend>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required size="20">

        <label for="cursos[]">Cursos</label>
        <select name="cursos[]" id="cursos[]" size="3" multiple>
<?php
        foreach( $cursos as $codigo => $curso ) {
            echo "<option value='$codigo'>{$curso['descripcion']} ({$curso['precio']}€)</option>";
        }
?>
        </select>

        <label for="clases">Clases presenciales</label>
        <input type="text" name="clases" id="clases" required size="5">

        <label for="desempleo">Desempleado</label>
        <input type="checkbox" name="desempleo" id="desempleo">

        <label for="tarjeta">Tarjeta demanda empleo</label>
        <input type="file" name="tarjeta" id="tarjeta" accept="application/pdf">

    </fieldset>
    <input type="submit" name="operacion" id="operacion" value="Solicitar presupuesto">

</form>

<?php
}
fin_html();

?>