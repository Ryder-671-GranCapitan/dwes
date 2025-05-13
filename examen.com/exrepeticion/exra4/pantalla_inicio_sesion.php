<?php
    // Iniciamos sesion
    session_start();

    // Inicializamos ob
    ob_start();

    // Importamos cosas que necesitamos
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/03jwt_include.php");

    // Iniciamos HTMl
    inicio_html("Pantalla Inicio de Sesion", ['../../styles/general.css',  '../../styles/formulario.css']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo "<h1>Inicio Sesion</h1>";
        ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>Inicia Sesion:</legend>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" required>
            </fieldset>
            <input type="submit" name="operacion" id="operacion" value="Iniciar Sesion">
        </form>
        <?php
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanear y validar Datos
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $clave = $_POST['clave'];

        // Conexion con la BBDD
        try {
            // Inciciamos la conexion
            $bbdd_nombre = "mysql";
            $bbdd_usuario = "usuario";
            $bbdd_clave = "usuario";
            $bbdd_schema = "tiendaol";
            $bbdd_perto = 3306;

            $cbd = new mysqli($bbdd_nombre, $bbdd_usuario, $bbdd_clave, $bbdd_schema, $bbdd_perto);

            // Preparamos la consulta
            $sql = "SELECT nif, nombre, apellidos, clave, iban, telefono, email, ventas";
            $sql .= " FROM cliente";
            $sql .= " WHERE email = ?";
            $stmt = $cbd->prepare($sql);
            
            // Enlazamos parametros
            $stmt->bind_param("s", $email);

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados
            $resultset = $stmt->get_result();

            if ($resultset->num_rows == 1) {
                // Se almacena el resultado en el array $cliente
                $cliente = $resultset->fetch_assoc();
                if (password_verify($clave, $cliente['clave'])) {
                    // Creamos el payload
                    $payload = [
                        "nif" => $cliente['nif'],
                        "nombre" => $cliente['nombre'],
                        "apellidos" => $cliente['apellidos'],
                        "iban" => $cliente['iban'],
                        "telefono" => $cliente['telefono'],
                        "email" => $cliente['email'],
                        "ventas" => $cliente['ventas']
                    ];

                    // Creamos el token
                    $jwt = generar_token($payload);
                    setcookie("jwt", $jwt, time() + 30 * 60);

                    // Redirigimos a la siguiente pantalla
                    header("Location: listado_direcciones.php");
                } else {
                    echo "<h1>Contraseña incorrecta</h1>";
                    echo "<a href='pantalla_inicio_sesion.php'>Volver a intentarlo</a>";
                }
            }
        } catch (Exception $e) {
            echo "Mensaje de error: " . $e->getMessage();
        }
    }

    ob_flush();

?>