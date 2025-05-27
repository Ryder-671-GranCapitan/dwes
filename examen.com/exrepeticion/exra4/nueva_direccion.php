<?php
    // Iniciamos sesion
    session_start();

    // Iniciamos ob
    ob_start();

    // Recogemos los datos que nos hagan falta
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/03jwt_include.php");

    // Validacion del JWT
    if ($_COOKIE['jwt']) {
        $jwt = $_COOKIE['jwt'];
        $payload = verificar_token($jwt);
    }

    // Iniciamos el HTML
    inicio_html("Añadir nueva direccion de envio", ['../../styles/general.css', '../../styles/formulario.css']);

    // Comprobacion de la peticion
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $payload) {
        echo "<h1>Añadir Nueva Direccion</h1>";
        ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>Intoduce los datos para ingresar una nueva direccion</legend>
                <input type="text" name="nif" id="nif" value="<?=$payload['nif']?>" hidden>

                <label for="id_dir_env">ID Direccion</label>
                <input type="number" name="id_dir_env" id="id_dir_env">

                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" id="direccion">

                <label for="cp">CP</label>
                <input type="text" name="cp" id="cp">

                <label for="poblacion">Poblacion</label>
                <input type="text" name="poblacion" id="poblacion">

                <label for="provincia">Provincia</label>
                <input type="text" name="provincia" id="provincia">

                <label for="pais">Pais</label>
                <input type="text" name="pais" id="pais">
            </fieldset>
            <input type="submit" name="operacion" id="operacion">
        </form>
        <?php
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $payload) {
        // Array de saneamiento de los datos
        $array_saneamiento = [
            'nif' => FILTER_SANITIZE_SPECIAL_CHARS,
            'id_dir_env' => FILTER_SANITIZE_NUMBER_INT,
            'direccion' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cp' => FILTER_SANITIZE_SPECIAL_CHARS,
            'poblacion' => FILTER_SANITIZE_SPECIAL_CHARS,
            'provincia' => FILTER_SANITIZE_SPECIAL_CHARS,
            'pais' => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        // Saneamos los datos
        $datos_saneados = filter_input_array(INPUT_POST, $array_saneamiento);

        // Validacion de los datos necesarios
        $datos_saneados['id_dir_env'] = filter_var($datos_saneados['id_dir_env'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

        // Conexion a la base de datos
        try {
            // Creamos la conexion
            $cbd = new mysqli("mysql", "usuario", "usuario", "tiendaol", 3306);

            // Genero la consulta sql
            $sql = "INSERT INTO direccion_envio";
            $sql .= " VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $cbd->prepare($sql);

            // ALmacenamos los valores dentro de un array
            $datos = array_values($datos_saneados);

            // Vinculamos los datos
            $stmt->bind_param('sisssss', ...$datos);

            // Ejecutamos la consulta
            if ($stmt->execute() && $stmt->num_rows() == 1) {
                echo "<h2>Se ha introducido correctamente la direccion</h2>";
                echo "<a href='pantalla_listado_direcciones.php'>Volver al listado</a>";
            }


        } catch (Exception $e) {
            echo "Mensaje Error: " . $e->getMessage();
        }
    }

    // finalizamos ob
    ob_flush();
?>