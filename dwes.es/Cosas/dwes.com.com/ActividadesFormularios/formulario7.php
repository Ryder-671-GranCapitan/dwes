<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

$empleados = [
    '12345678k' => [
        'nombre' => 'Juan',
        'apellidos' => 'García Pérez',
        'email' => 'juanperez@gmail.com',
        'aceptacion' => true],
    '87654321m' => [ 
        'nombre' => 'María',
        'apellidos' => 'González López',
        'email' => 'maria@gmail.com',
        'aceptacion' => true],
    '11111111a' => [
        'nombre' => 'Ana',
        'apellidos' => 'Martínez Sánchez',
        'email' => 'ana@gmail.com',
        'aceptacion' => true]
    ];

// ===========================================================================================

function validarDatos() { // Sanea to del tiron. Esto es un primer filtro.
    global $empleados;
    $opcionesValidado = [
        'dni' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/[0-9]{8}[a-z]/']
        ],
        'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
        'apellidos' => FILTER_SANITIZE_SPECIAL_CHARS,
        'email' => FILTER_VALIDATE_EMAIL,
        'aceptacion' => FILTER_VALIDATE_BOOLEAN
    ];

    $datosSaneados = filter_input_array(INPUT_POST, $opcionesValidado);

    // Validar
    $dni = isset($datosSaneados['dni']) && !array_key_exists($datosSaneados['dni'], $empleados) ? $datosSaneados['dni'] : false;
    $nombre = isset($datosSaneados['nombre']) ? $datosSaneados['nombre'] : false;
    $apellidos = isset($datosSaneados['apellidos']) ? $datosSaneados['apellidos'] : false;
    $email = isset($datosSaneados['email']) ? $datosSaneados['email'] : false;
    $aceptacion = isset($datosSaneados['aceptacion']) ? true : false;

    subirPDF($_FILES['archivo']);

    if ($dni && $aceptacion) {
        return [
            'dni' => $dni,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $email,
            'aceptacion' => $aceptacion
        ];
    } else {
        echo "<p style='color:red;'>Los datos no son válidos.</p>";
        return false;
    }
}
// ===========================================================================================
function mostrarEmpleados($empleado) {
    global $empleados;

    echo "<table border='1'>";
    echo "
    <tr>
        <th>DNI</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Terminos</th>
    </tr>";

    foreach ($empleados as $dni => $value) {
        echo "<tr>";
        echo "<td>$dni</td>";
        echo "<td>{$value['nombre']}</td>";
        echo "<td>{$value['apellidos']}</td>";
        echo "<td>{$value['email']}</td>";
        echo "<td>" . ($value['aceptacion'] ? 'aceptado' : 'no aceptados') . "</td>";
        echo "</tr>";
    }
}
// ===========================================================================================
function añadirEmpleado($empleado) { // Esto al final no se usa como queriamos
    global $empleados;

    $empleados[$empleado['dni']] = $empleado;
    mostrarEmpleados($empleado);
}

function subirPDF($archivo) {
    $tiposAdmitidos = ['application/pdf'];

    if (!isset($archivo['error']) || ($archivo['error'] != UPLOAD_ERR_OK)) {
        echo "<p style='color:red;'>Error al subir el archivo.</p>";
        return false;
    }

    $archivoTmp = $archivo['tmp_name'];
    $mimeArchivo = mime_content_type($archivoTmp);

    if ($mimeArchivo && in_array($mimeArchivo, $tiposAdmitidos)) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/formulario7subida/';
        if (!is_dir($path) && !mkdir($path, 0777, true)) {
            echo "<p style='color:red;'>Error al crear el directorio de subida.</p>";
            return false;
        }
        $nombreArchivo = $_POST['dni'] . '.pdf';

        if (move_uploaded_file($archivoTmp, $path . $nombreArchivo)) {
            echo "<h2>Archivo subido correctamente.</h2>";
            return true;
        } else {
            echo "<p style='color:red;'>Error al mover el archivo.</p>";
            return false;
        }
    } else {
        echo "<p style='color:red;'>El archivo no es un PDF.</p>";
        return false;
    }
}
// ===========================================================================================

inicio_html("Ejercicio7Tuneado", ["/estilos/formulario.css", "/estilos/general.css", "/estilos/tablas.css"]);

// ========================================================================= DE AQUI PA RRIBA PHP

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
    if ($datos = validarDatos()) {
        añadirEmpleado($datos);
        
        mostrarFormulario($datos);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $datos = [];
    mostrarFormulario($datos);

}

// ========================================================================= DE AQUI PA BAJO HTML

function mostrarFormulario($datos) {

?>
<header>Solicitudes de Empleo</header>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Solicitud de Empleo</legend>

            <label for="dni">Dni:</label>
            <input type="text" name="dni" id="dni" pattern="[0-9]{8}[a-z]" value="<?=isset($datos['dni']) ? $datos['dni'] : ''?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?=isset($datos['nombre']) ? $datos['nombre'] : ''?>">

            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" value="<?=isset($datos['apellidos']) ? $datos['apellidos'] : ''?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?=isset($datos['email']) ? $datos['email'] : ''?>">

            <label for="aceptacion">Aceptar Terminos y Condiciones</label> 
            <input type="checkbox" name="aceptacion" id="aceptacion"
            <?=isset($datos['aceptacion']) && $datos['aceptacion'] == '1' ? 'checked' : ''?>>

            <label for="cv">Curriculum Vitae</label>
            <input type="file" name="archivo" id="archivo">
        </fieldset>
        <input type="submit" name="enviar" id="enviar">
    </form>

<?php
}
fin_html();
?>