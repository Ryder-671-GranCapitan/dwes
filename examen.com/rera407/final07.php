<?php
    session_start(); // Inicia la sesión

    require_once('./includes/funciones.php'); // Incluye el archivo de funciones
    require_once('./includes/jwt_include.php'); // Incluye el archivo para manejo de JWT
    require_once('./dbase.php'); // Incluye el archivo de conexión a la base de datos

    // Verifica si la cookie 'jwt' está establecida, si no, redirige a la pantalla inicial
    if (!isset($_COOKIE['jwt'])) {
        header('Location: index07.php');
    }

    $jwt = $_COOKIE['jwt']; // Obtiene el JWT de la cookie
    $payload = verificar_token($jwt); // Verifica el token y obtiene el payload

    // Si el token no es válido, redirige a la pantalla inicial
    if( !$payload ){
        header('Location: index07.php');
        exit(1);
    }
    
    inicio_html("Pantalla Final", ['./estilos/general.css', './estilos/formulario.css', './estilos/tablas.css']);
    echo "<h1> DNI: " . $payload['dni'] . "</h1> <br>";
    echo "<h1> Nombre: " . $payload['nombre'] . "</h1> <br>";
    echo "<h1> Fecha de inicio: " . $_SESSION['hora_inicio'] . "</h1> <br>";
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Precio/Hora</th>
                        <th>Horas</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $importe_total = 0;

                        foreach ($_SESSION['curso'] as $key => $valor):
                            $curso = $cursos[$key]['descripcion'];
                            $precio_hora = $cursos[$key]['precio'];
                            $horas = $valor;
                            $importe = $horas * $precio_hora;
                            $importe_total += $importe;
                        ?>
                        <tr>
                            <td><?=$curso?></td>
                            <td><?=$precio_hora?></td>
                            <td><?=$horas?></td>
                            <td><?=$importe?></td>
                        </tr>
                        
                        <?php
                        endforeach;
                    ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?=$importe_total?></td>
                    </tr>

                </tbody>
            </table>
        <?php
    }

    echo "<a href='inicio07.php'>Volver a inicio</a> <br>";

    echo "<a href='lista07.php'>Añadir Mas Cursos</a>";



    

?>