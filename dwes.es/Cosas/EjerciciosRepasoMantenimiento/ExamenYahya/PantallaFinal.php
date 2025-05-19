<?php
    session_start(); // Inicia la sesión

    require_once('./includes/funciones.php'); // Incluye el archivo de funciones
    require_once('./includes/jwt_include.php'); // Incluye el archivo para manejo de JWT
    require_once('./db.php'); // Incluye el archivo de conexión a la base de datos

    global $espectaculos; // Declara la variable global $espectaculos
    
    // Verifica si la cookie 'jwt' está establecida, si no, redirige a la pantalla inicial
    if( !isset($_COOKIE['jwt']) ){
        header('Location: PantallaInicial.php');
        exit(1);
    }
    
    $payload = verificar_token($_COOKIE['jwt']); // Verifica el token y obtiene el payload
    
    // Si el token no es válido, redirige a la pantalla inicial
    if( !$payload ){
        header('Location: PantallaInicial.php');
        exit(1);
    }
    
    // Si no se ha establecido la hora de inicio o las entradas en la sesión, redirige a la pantalla inicial
    if( !isset($_SESSION['hora_inicio'], $_SESSION['entradas']) ){
        header('Location: PantallaInicial.php');
        exit(1);
    }
    
    // Si no hay entradas en la sesión, redirige a la pantalla del carrito
    if( empty($_SESSION['entradas']) ){
        header('Location: PantallaCarrito.php');
        exit(1);
    }

    // Inicia el HTML con el título 'Carrito' y los estilos especificados
    inicio_html('Carrito', ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);

    // Si el método de la solicitud es GET, muestra la información del usuario y las entradas
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo "<h2>Identificador     :" . $payload['id'] . "</h2> <br>";
        echo "<h2>Nombre            :" . $payload['nombre'] . "</h2> <br>";
        echo "<h2>Fecha de comienzo :" . $_SESSION['hora_inicio'] . "</h2> <br>";

        ?>
            <table>
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Fila</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $precio_total = 0; // Inicializa el precio total

                        // Recorre las entradas en la sesión y muestra cada una en una fila de la tabla
                        foreach($_SESSION['entradas'] as $key => $valor): 
                            $titulo = $espectaculos[$key]['titulo']; // Obtiene el título del espectáculo
                            $fila = $valor; // Obtiene la fila
                            // Calcula el precio según la fila
                            $precio = ($fila >= 1 && $fila <= 10) ? $espectaculos[$key]['fila1_10'] : $espectaculos[$key]['fila11_20'];
                            $precio_total += $precio; // Suma el precio al total
                        ?>
                        <tr>
                            <td><?=$titulo?></td>
                            <td><?=$fila?></td>
                            <td><?=$precio?>€</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">IMPORTE TOTAL</th>
                            <th><?=$precio_total?>€</th>
                        </tr>
                    </tfoot>
                </table>
            <form action="PantallaInicial.php">
                <input type="submit" value="Volver a empezar">
            </form>
            <a href="./PantallaCarrito.php">Añadir mas Entradas</a>
        <?php
    }
    fin_html(); // Finaliza el HTML

?>