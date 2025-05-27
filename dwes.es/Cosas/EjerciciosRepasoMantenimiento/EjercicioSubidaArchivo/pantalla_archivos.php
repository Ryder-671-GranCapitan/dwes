<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['lista_archivos']) {
        echo "Aló, que anda hasiendo uste?";
        ?>
            <form action="/EjerciciosRepasoMantenimiento/EjercicioSubidaArchivo/pantalla_datos.php" method="POST">
                <legend>Selecciona el directorio</legend>
                <select name="seleccion_archivo" id="seleccion_archivo">
                    <?php
                        foreach ($_SESSION['lista_archivos'] as $archivo) {
                            echo "<option>{$archivo}</option>";
                        }
                    ?>
                </select>
                <input type="submit" name="mandar_archivo" value="Mandar">
            </form>
        <?php
    } else {
        echo "No existe ningun archivo declarado en el array del servidor de archivos.";
    }
?>