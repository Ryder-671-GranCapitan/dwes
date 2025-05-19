<?php
    // Iniciamos ob
    ob_start();

    // Importamos cosas que necesitamos
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/03jwt_include.php");

    // Iniciamos HTML
    inicio_html("Inicio Sesion", ['../../styles/general.css', '../../styles/formulario.css']);

    // Controlamos la peticion que haga el usuario
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo "<h1>Inicio de sesion</h1>";
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                <fieldset>
                    <legend>Introsuce los daros de inicio de sesion</legend>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>

                    <label for="clave">Contraseña</label>
                    <input type="password" name="clave" id="clave" required>
                </fieldset>
                <input type="submit" name="operacion" id="operacion" value="Iniciar Sesion">
            </form>
        <?php
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Saneamos los datos
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $clave = $_POST['clave'];

        // Validamos los datos necesarios
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        // Creamos la conexion con PDO
        $dsn = "mysql:host=mysql;dbname=tiendaol;charset=utf8";
        $usuario = "usuario";
        $clave = "usuario";
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $pdo = new PDO($dsn, $usuario, $clave, $opciones);

            // Preparamos la consulta
            $sql = "SELECT nif, nombre, apellidos, clave, iban, telefono, email, ventas FROM cliente WHERE email = :email";

            // Preparamos la consulta
            $stmt = $pdo->prepare($sql);

            // Enlazamos parametros
            $stmt->bindValue(':email', $email);

            // Ejecutamos la consulta
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $usuario = $stmt->fetch();
                    if (password_verify($clave, $usuario['clave'])) {
                        $payload = [
                            "nif" => $usuario['nif'],
                            "email" => $usuario['email'],
                            "nombre" => $usuario['nombre'] . " " . $usuario['apellidos']
                        ];
                        $jwt = generar_token($payload);
                        setcookie("jwt", $jwt, time() + 30 * 60);

                        header("Location: pantalla_articulo.php");
                    }
                }
            }

        } catch (PDOException $pdoe) {
            echo "Error: " . $pdoe->getMessage();
        }


    }

    ob_flush();
?>