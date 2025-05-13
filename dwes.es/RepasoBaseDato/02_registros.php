<?php
// Importamos las clases necesarias de los espacios de nombres correspondientes
use entidad\RegistroAsistente;
use orm\ORMRegistro;
use util\Autocarga;
use util\Html;

// Iniciamos la sesión para gestionar variables de sesión
session_start();

// Cargamos el archivo de la clase de autocarga para habilitar la carga automática de clases
require_once('./util/Autocarga.php');
Autocarga::autoload_reg();

// Iniciamos la estructura del HTML usando la clase Html
Html::inicio("Lista actividades", ['./estilos/tablas.css', './estilos/formulario.css', './estilos/general.css']);

// Verificamos si la solicitud HTTP es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Filtramos y validamos el email enviado en el formulario
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($email) {
        // Definimos una lista de actividades disponibles con sus nombres completos
        $actividades_disponibles = [
            'gns3' => "El simulador de red GNS3",
            "ftp" => "Configuracion cortafuegos para FTP",
            "dock" => "Despliegue rapido con Docker"
        ];

        // Guardamos el email en la sesión
        $_SESSION['email'] = $email;

        // Instanciamos el ORM para manejar la base de datos
        $orm_reg = new ORMRegistro();

        // Obtenemos la lista de actividades asociadas a este email
        $registros = $orm_reg->listar($email);
        ?>
            <!-- Creamos una tabla para mostrar las actividades inscritas -->
            <table>
                <thead>
                    <tr>
                        <th>Actividad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($registros as $registro) {
                        // Verificamos si la actividad registrada está dentro de la lista disponible
                        if (isset($actividades_disponibles[$registro->actividad])) {
                            echo "<tr>";
                                echo "<td>" . $actividades_disponibles[$registro->actividad] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        <?php
    }
}
?>

<!-- Formulario para inscribirse en una actividad -->
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <fieldset>
        <legend>Actividad</legend>
        <label for="fecha_insc">Fecha de inscripción</label>
        <input type="date" name="fecha_insc" id="fecha_insc">

        <label for="actividad">Actividad</label>
        <select name="actividad" id="actividad">
            <option value="gns3">El simulador de red GNS3</option>
            <option value="ftp">Configuracion cortafuegos para FTP</option>
            <option value="dock">Despliegue rapido con Docker</option>
        </select>
    </fieldset>
    <input type="submit" value="Enviar actividad" name="operacion">
</form>

<?php
// Definimos una constante con las actividades válidas
define('ACTIVIDADES_VALIDAS', ['gns3', 'ftp', 'dock']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Filtramos los datos de fecha y actividad enviados en el formulario
    $fecha = isset($_POST['fecha_insc']) ? filter_input(INPUT_POST, 'fecha_insc', FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $actividad = isset($_POST['actividad']) ? filter_input(INPUT_POST, 'actividad', FILTER_SANITIZE_SPECIAL_CHARS) : null;

    // Verificamos si la actividad seleccionada está dentro de la lista válida
    if ($actividad && !in_array($actividad, ACTIVIDADES_VALIDAS)) {
        throw new Exception("La actividad no está disponible");            
    }

    // Si se proporcionó una fecha, la ajustamos a 15 días en el futuro
    if ($fecha) {
        $fecha = new DateTime();
        $fecha->modify('+15 days');
        $fecha = $fecha->format(RegistroAsistente::FORMATO_FECHA_MYSQL);
    }

    // Verificamos si el email está en la sesión para registrar la actividad
    if (isset($_SESSION['email'])) {
        // Creamos un objeto `RegistroAsistente` con los datos del usuario
        $registro = new RegistroAsistente([
            'email' => $_SESSION['email'],
            'actividad' => $actividad,
            'fecha_inscripcion' => $fecha
        ]);

        // Instanciamos el ORM y guardamos el nuevo registro en la base de datos
        $orm_reg = new ORMRegistro();
        $orm_reg->insertar($registro);
        
        // Confirmamos la inserción de la actividad
        if ($orm_reg) {
            echo "Actividad Insertada";
        }
    }
}
?>

<!-- Formulario para cerrar la sesión y volver al inicio -->
<form action="01_email.php" method="POST">
    <input type="submit" value="Cerrar Sesión">
</form>

<?php
// Cerramos la estructura del HTML
Html::fin();
?>
