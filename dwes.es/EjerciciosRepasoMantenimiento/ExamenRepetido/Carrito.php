<?php
    // Inicio Sesion
    session_start();

    // Importo los archivos necesarios
    require_once('./includes/funciones.php');
    require_once('./includes/jwt_include.php');
    require_once('./db.php');

    // Verifico si la cookie esta estabelcida, si no lo mando al inicio
    if (!isset($_COOKIE['jwt'])) {
        header('Location: Inicio.php');
    }

    // Pillo el jwt de la cookie
    $jwt = $_COOKIE['jwt'];
    $payload = verificar_token($jwt);

    // Si el token no se verifica, al principio

    if (!$payload) {
        header('Location: Inicio.php');
        exit(1);
    }

    // Si no ha pillado bien la hora, tmb se le manda al principio
    if (!isset($_COOKIE['hora_comienzo'])) {
        header('Location: Inicio.php');
        exit(1);
    }

    // Ahora si, puedo iniciar el html
    inicio_html('Pagina Carrito', ['./estilos/general.css', './estilos/formulario.css']);

    // Muestro la informacion del usuario y la hora
    echo "<h2>Id: " . $payload['id'] . "</h2> <br>";
    echo "<h2>Nombre: " . $payload['nombre'] . "</h2> <br>";
    echo "<h2>Id: " . $_SESSION['hora_inicio'] . "</h2> <br>";

    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <fieldset>
                <legend>Entradas</legend>

                <label for="espectaculo">Espectaculo</label>
                <select name="espectaculo" id="espectaculo">
                    <?php foreach($espectaculos as $key => $valor):?>
                        <option value="<?=$key?>"><?=$valor['titulo']?></option>
                    <?php endforeach;?>
                </select>

                <label for="fila">Fila</label>
                <input type="number" name="fila" id="fila" min=1 max=20>
            </fieldset>
            <input type="submit" value="Añadir Entrada">
            <br>
            <br>
            <a href="./PantallaFinal.php">Ver Entradas</a>
        </form>
    <?php



?>