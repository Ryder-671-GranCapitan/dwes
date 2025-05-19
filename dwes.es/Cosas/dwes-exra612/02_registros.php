<?php

use entidad\RegistroAsistente;
use orm\ORMRegistro;
use util\Autocarga;
use util\Html;

session_start();

require_once('./util/Autocarga.php');

Autocarga::autoload_reg();

Html::inicio("Listar actividades", ['./estilos/tablas.css', './estilos/formulario.css']);

if( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion'] == 'Enviar' ){
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if( $email ){
        $actividades = [
            "gns3" => "El simulador de red GNS3",
            "ftp" => "Configuracion cortafuegos para FTP",
            "dock" => "Despliegue rapido con Docker"
        ];

        $_SESSION['email'] = $email;
        $orm_reg = new ORMRegistro();

        $registros = $orm_reg->listar($email);
        ?>
        <table>
            <thead>
                <tr><th>Actividad</th></tr>
            </thead>
            <tbody>
                <?php
                foreach($registros as $registro) {
                    if( isset($actividades[$registro->actividad]) ){
                        echo "<tr>";
                            echo "<td>" . $actividades[$registro->actividad] . "</td>";
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
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <fieldset>
            <legend>Actividad</legend>
            <label for="fecha_insc">Fecha de inscipcion</label>
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

define('ACTIVIDADES_VALIDAS', ['gns3', 'ftp', 'dock']);

if( $_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion'] == 'Enviar actividad') ){

    $fecha = isset($_POST['fecha_insc']) ? filter_input(INPUT_POST, 'fecha_insc', FILTER_SANITIZE_SPECIAL_CHARS) : null;

    if( !in_array($actividad, ACTIVIDADES_VALIDAS) ){
        throw new Exception('Actvidad invalida');
    }

    if( $fecha ){
        $fecha = new DateTime();
        $fecha->modify('+15 days');
        $fecha = $fecha->format(RegistroAsistente::FORMATO_FECHA_MYSQL);
    }

    if( isset($_SESSION['email']) ){
        $registro = new RegistroAsistente(['email' => $_SESSION['email'], 'actividad' => $actividad, 'fecha_inscripcion' => $fecha]);
        $orm_reg = new ORMRegistro();
        $orm_reg->insertar($registro);
        if( $orm_reg ) {
            echo "Actividad insertada";
        }
    }
    ?>
    <?php
}
?>
<form action="01_email.php" method="POST">
    <input type="hidden" name="operacion" value="cerrar_sesion">
    <input type="submit" value="Cerrar Sesion">
</form>
<?php
Html::fin();
?>