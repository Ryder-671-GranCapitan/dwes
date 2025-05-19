<?php
session_start();

require_once('./includes/funciones.php');
require_once('./includes/jwt_include.php');
require_once('./db.php');

if( !isset($_COOKIE['jwt'])){
    header('Location: 01_login.php');
    exit(1);
}

$jwt = $_COOKIE['jwt'];
$payload = verificar_token($jwt);

if( !$payload ){
    header('Location: 01_login.php');
    exit(1);
}

if( !isset($_SESSION['initial']) ){
    header('Location: 01_login.php');
    exit(1);
}

if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    if( isset($_POST['espectaculo']) && isset($_POST['fila']) ){

        $espectaculo = filter_input(INPUT_POST, 'espectaculo', FILTER_SANITIZE_SPECIAL_CHARS); 
        $fila = filter_input(INPUT_POST, 'fila', FILTER_SANITIZE_NUMBER_INT);
        $fila = filter_var($fila, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 20]]);

        if( !$espectaculo || !$fila || !array_key_exists($espectaculo, $espectaculos)){
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit(1);
        }

        if( !isset($_SESSION['entradas']) ){
            $_SESSION['entradas'] = [];
        }

        // Si ya existe una entrada a este espec se elimina para reemplazar la fila con el nuevo valor
        if( array_key_exists($espectaculo, $_SESSION['entradas']) ){
            unset($_SESSION['entradas'][$espectaculo]);
        }
        
        // Establecer la clave del espec y fila
        $_SESSION['entradas'][$espectaculo] = $fila;
    }
}

inicio_html('Carrito', ['./estilos/formulario.css', './estilos/general.css']);

echo "<h2>Identificador     :" . $payload['id'] . "</h2> <br>";
echo "<h2>Nombre            :" . $payload['nombre'] . "</h2> <br>";
echo "<h2>Fecha de comienzo :" . $_SESSION['initial'] . "</h2> <br>";
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <fieldset>
        <legend>Entrada</legend>

        <label for="espectaculo">Espectaculo</label>
        <select name="espectaculo" id="espectaculo">
            <?php foreach($espectaculos as $key => $valor):?>
                <option value="<?=$key?>"><?=$valor['titulo']?></option>
            <?php endforeach;?>
        </select>

        <label for="fila">Fila</label>
        <input type="number" name="fila" id="fila" min=1 max=20>
    </fieldset>
    <input type="submit" value="Anadir entrada">
    <br>
    <a href="./04_presentation.php">Ver entradas</a>
</form>

