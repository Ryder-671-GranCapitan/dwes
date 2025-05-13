<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/examenMioRa23/include/funciones.php");

    define("PRECIO_CLASE_PRESENCIAL", 10);
    define("DESCUENTO_DESEMPLEO", 0.1);
    define("CARPETA_SUBIDA", $_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/examenMioRa23/tarjetas");

    $cursos = ['ofi' => ['descripcion' => 'Ofimática', 'precio' => 100],
                'pro' => ['descripcion' => 'Programación', 'precio' => 200],
                'rep' => ['descripcion' => 'Reparación ordenadores', 'precio' => 150]
    ];

    function SaneaYValidaDatos() {
        global $cursos; // Como tenemos que acceder al array para poder sanearlo, se hace global.

        // Recogemos los datos del formulario y se SANEAN
        $saneamiento_datos = [
            'email'     => FILTER_SANITIZE_EMAIL,
            'cursos'    => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                            'flags' => FILTER_REQUIRE_ARRAY],
            'clases'    => FILTER_SANITIZE_NUMBER_INT,
        ];

        $datos_saneados = filter_input_array(INPUT_POST, $saneamiento_datos, false);

        // La validacion se hará de uno en uno porque hay que usar lógica de aplicacion en cada uno de ellos. VALIDACION

        // VALIDACION DE EMAIL
        $datos_validados['email'] = filter_var($datos_saneados['email'] , FILTER_VALIDATE_EMAIL);

        // VALIDACION DE CURSOS
        $cursos_ok = true; // Bandera para saber si existen los cursos

        foreach ($datos_saneados['cursos'] as $curso_recibido) {
            if (!array_key_exists($curso_recibido, $cursos)) { // Si el curso recibido no esta en el array de cursos
                $cursos_ok = false; // Cambiamos la bandera
                break; // Salimos del bucle
            }
        }

        if ($cursos_ok) $datos_validados['cursos'] = $datos_saneados['cursos']; // Si la bandera sigue en true, los cursos son validos
        else $datos_validados['cursos'] = false; // Si no, los cursos no son validos

        // VALIDACION DE CLASES
        $datos_validados['clases'] = filter_var($datos_saneados['clases'], FILTER_VALIDATE_INT, ['min_range' => 5, 'max_range' => 10]);

        // VALIDACION DE DESEMPLEO
        if (!isset($_POST['desempleo'])) { // Si no está establcido, se pone a falso
            $datos_validados['desempleo'] = False;
        }
        else {
            $desempleo = filter_input(INPUT_POST, 'desempleo', FILTER_DEFAULT); // En caso contratio se crea
            $datos_validados['desempleo'] = filter_var($desempleo, FILTER_VALIDATE_BOOL);
        }
        
        return $datos_validados;
    }

    function PresentarDatos($datos_validados) {
        global $cursos;

        echo "<table><thead><tr><th>Email</th><th>Cursos Solicitados</th><th>Clases</th><th>Desempleo</th>";
        echo "<tbody><tr>";

        echo "<td>". ($datos_validados['email'] ? $datos_validados['email'] : "El email no es valido socio") . "</td>";

        echo "<td>";
        if (is_array($datos_validados['cursos'])) { // Se comprueba si los cursos son un array
            foreach ($datos_validados['cursos'] as $curso) { // Se recorre el array y se sacan la descripcion y el precio
                echo "{$cursos[$curso]['descripcion']} - {$cursos[$curso]['precio']}€<br>";
            }
        }
        echo "</td>";

        echo "<td>". ($datos_validados['clases'] ? $datos_validados['clases'] : "El numeor de clases no es valido manin") . "</td>";

        echo "<td>". ($datos_validados['desempleo'] ? "Desempleado" : "No desempleado") . "</td>";

        echo "</tr></tbody></table>";

        if (!$datos_validados['email'] || !$datos_validados['cursos'] || !$datos_validados['clases']) {
            return False;        
        }

        return True;
    }

    function PresentarPresupuesto($datos_validados) {
        global $cursos;

        echo "<h3>Preupuesto de tus Clases Online</h3>";
        $total = 0; // Iniciamos el total a 0 porque aun no le hemos sumado nada, pero se declara para poder luego utilizarla

        echo "<h4>Cursos Elegidos</h4>";
        echo "<p>";
        $importe_cursos = 0; //Aqui se contablizarán los cursos elegidos

        foreach ($datos_validados['cursos'] as $curso) { // Recorro el array
            echo "{$cursos[$curso]['descripcion']} - {$cursos[$curso]['precio']}€<br>"; // Pillo del array de cursos, la descripcion y el presio
            $importe_cursos += $cursos[$curso]['precio']; // Por cada curso, se le suma al importe de los cursos
        }

        $importe_cursos += PRECIO_CLASE_PRESENCIAL * $datos_validados['clases']; // Ojo. Si son clases presenciales hay que sumarle un extra

        echo "<h4>Incremento por clases presenciales</h4>";
        echo "<p>Son {$datos_validados['clases']} presenciales. El incremento por clases presenciales es $importe_cursos €</p>";
        $total += $importe_cursos;

        echo "<h4>Descuento por las clases presenciales</h4>";
        if ($datos_validados['desempleo']) {
            echo "<p>Al estar en situacion de desempleo tiene el descuento del " . (DESCUENTO_DESEMPLEO * 100) .  "%</p>";
            $descuento  = $total * DESCUENTO_DESEMPLEO;
            echo "<p>El importe del descuento es $descuento €</p>";
            $total -= $descuento;
        }
        else {
            echo "<p>Al tener chamba no tenes derecho a descuento pibe</p>";
        }

        echo "<h4>Total presupuesto: $total €</h4>";
    }

    function SubidaArchivo($nombre_archivo) {
        if ($_FILES['tarjeta']['error'] == UPLOAD_ERR_OK) {
            
            // Esto verifica que hay subida. Vamos a ver el tipo del archivo
            $tipo_mime_detectado = mime_content_type($_FILES['tarjeta']['tmp_name']);
            $tipo_mime_subido = $_FILES['tarjeta']['type'];
            $tipo_permitido = "application/pdf";

            if ($tipo_permitido == $tipo_mime_detectado && $tipo_permitido == $tipo_mime_subido) {
                if (!file_exists(CARPETA_SUBIDA) || !is_dir(CARPETA_SUBIDA)) {
                    if (!mkdir(CARPETA_SUBIDA, 0755)) {
                        echo "<h4>Error en la subida de archivo. No se pudo crear la carpeta de subida</h4>";
                    }
                }

                if (move_uploaded_file($_FILES['tarjeta']['tmp_name'], CARPETA_SUBIDA . "/$nombre_archivo.pdf")) {
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // SANEAMOS Y VALIDAMOS LOS DATOS DEL FORMULARIO
        $datos_validados = SaneaYValidaDatos();
        
        // PRESENTA LOS DATOS ENVIADOS XD
        if (!PresentarDatos($datos_validados)) {
            echo "<h3>Algunos de los datos no son validos. Reviselo</h3>";
            echo "<p><a href='{$_SERVER['PHP_SELF']}'>Vuleva a Intentarlo</a></p>";
            fin_html();
            exit(1);
        }

        // Los datos estan ya subidos, vamo a calcular el presupuesto
        PresentarPresupuesto($datos_validados);

        // Si está en desempleo se verifica la subida del archivo. 
        if( $datos_validados['desempleo']) {
            SubidaArchivo($datos_validados['email']);
        }
        else {
            echo "<h4>Al no estar en situación de desempleo no se necesita Tarjeta de Demanda de Empleo</h4>";
        }
    }

    // Iniciamos el HTML
    inicio_html("Examen RA2-3", ["/EjerciciosRepaso/examenMioRa23/estilos/general.css", "/EjerciciosRepaso/examenMioRa23/estilos/formulario.css", "/EjerciciosRepaso/examenMioRa23/estilos/tabla.css"]);
    echo "<header>Examensito Repetido</header>";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <!-- Se pone el limite del tamaño del archivo aqui en el formulario -->
                <input type="hidden" name="MAX_FILE_SIZE" value="<?=100 * 1024?>">

                <fieldset>
                    <legend>Academia Online - Cursos de Formacion</legend>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required size="20">

                    <label for="cursos[]">Cursos</label>  <!-- El corchete se pone por que aqui va a haber un array, que tenemos definido arriba-->
                    <select name="cursos[]" id="cursos[]" size="3" multiple>
                        <?php
                            foreach ($cursos as $codigo => $curso) {
                                echo "<option value='$codigo'>{$curso['descripcion']} ({$curso['precio']}€)</option>";
                            }
                        ?>
                    </select>

                    <label for="clases">Clases Presenciales</label>
                    <input type="text" name="clases" id="clases" required size="5">
                    
                    <label for="desempleo">Desempleado</label>
                    <input type="checkbox" name="desempleo" id="desempleo">

                    <label for="tarjeta">Tarjeta Demanda Empleo</label>
                    <input type="file" name="tarjeta" id="tarjeta" accept="application/pdf">
                </fieldset>
                <input type="submit" name="operacion" id="operacion" value="Solicitar Presupuesto">
            </form>
        <?php
    }
    fin_html();
?>