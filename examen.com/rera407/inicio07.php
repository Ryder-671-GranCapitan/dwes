<?php
    session_start();

    require_once('./dbase.php');
    require_once('./includes/funciones.php');
    require_once('./includes/jwt_include.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        header('Location: index07.php');
    }

    function autenticar($dni, $password) {
        global $usuarios_posibles;

        if (!array_key_exists($dni, $usuarios_posibles)) {
            return false;
        }
        
        return password_verify($password, $usuarios_posibles[$dni]['clave']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['dni'], $_POST['password'])) {
            echo "El usuario o la contraseña son incorrectos";
            header('Location: index07.php');
        }

        $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];
        $nombre = isset($usuarios_posibles[$dni]) ? $usuarios_posibles[$dni]['nombre'] : null;

        if (!$dni || !$password || !$nombre || !autenticar($dni, $password)) {
            header('Location: index07.php');
        }

        $usuario = [
            'dni' => $dni,
            'nombre' => $nombre
        ];

        // Genera un token JWT para el usuario
        $jwt = generar_token($usuario);

        // Establece una cookie con el token JWT que expira en 2 horas
        setcookie('jwt', $jwt, time() + 2 * 60 * 60, '/');

        $_SESSION['hora_inicio'] = gmdate("M d Y H:i:s", time());
    }

    inicio_html("Pantalla Verificacion", ['./estilos/general.css', './estilos/formulario.css']);
    echo "<h1> DNI: " . $usuario['dni'] . "</h1> <br>";
    echo "<h1> Nombre: " . $usuario['nombre'] . "</h1> <br>";
    echo "<h1> Fecha de inicio: " . $_SESSION['hora_inicio'] . "</h1> <br>";

    echo "<a href='./lista07.php'>Ir a los cursos</a>";


?>