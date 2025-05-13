<?php
    session_start();

    require_once('./includes/funciones.php');
    require_once('./includes/jwt_include.php');
    require_once('./db.php');

    if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
        header("Location: 01_login.php");
        exit(1);
    }

    function autenticar($id, $password, $nombre){
        global $usuarios;

        if( !array_key_exists($id, $usuarios) ){
            return false;
        }  

        return password_verify($password, $usuarios[$id]['clave']);
    }

    if( $_SERVER['REQUEST_METHOD'] == 'POST' 
        && isset($_POST['origin_form']) 
        && $_POST['origin_form'] == 'login' ){

        if( !isset($_POST['id'], $_POST['password'], $_POST['nombre']) ){
            header('Location: 01_login.php');
            exit(1);
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];
        $nombre = filter_input(INPUT_POST,'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

        if( !$id || !$password || !$nombre || !autenticar($id, $password, $nombre)){ 
            header('Location: 01_login.php');
            exit(1);
        }

        $usuario = [
            'id' => $id,
            'nombre' => $nombre 
        ];

        $jwt = generar_token($usuario);

        setcookie('jwt', $jwt, time() + 2 * 60 * 60,'/');

        $_SESSION['initial'] = gmdate('M d Y H:i:s', time());

        header('Location: 03_carrito.php');
    }
?>