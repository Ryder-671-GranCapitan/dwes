<?php

    // Espacio de Nombres
    namespace mvc\vista;

    use mvc\vista\Vista;

    // Creacion de la Clase
    class V_Reseña extends Vista {
        // Debemso de generar la salida para el usuario en ql euq emuestre rodas las reselñas que tiene un articulo
        public function genera_salida($datos): void {
            $this->inicio_html("Reseñas del articulo", ['./styles/general.css', './styles/tablas.css']);
            echo "<h1>Reseñas del producto con referencia {$_SESSION['referencia']}</h1>";
            // Y aqui mostramos la tabla de las reseñas de los productos
            ?>
            <!-- Y aqui, devolvemos un formulario con un boton que ponga, añadir nueva reseña -->
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <fieldset>
                    <legend>Inserta una nueva reseña</legend>
                    <label for="clasificacion">Clasificacion</label>
                    <input type="number" id="clasificacion" name="clasificacion" required>

                    <label for="comentario">Comentario</label>
                    <input type="text" name="comentario" id="comentario" required>
                </fieldset>
                    <button type="submit" id="idp" name="idp" value="insertar_reseña">Insertar una nueva reseña</button>
            </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID_Reseña</th>
                            <th>Nif</th>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th>Clasificacion</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($datos as $articulo) {
                                echo "<tr>";
                                    echo "<td>{$articulo['id_reseña']}</td>";
                                    echo "<td>{$articulo['nif']}</td>";
                                    echo "<td>{$articulo['referencia']}</td>";
                                    echo "<td>{$articulo['fecha']}</td>";
                                    echo "<td>{$articulo['clasificacion']}</td>";
                                    echo "<td>{$articulo['comentario']}</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php
            $this->fin_html();
        } 
    }
    // Con esto hemos terminado la vista, ahora toca hacer el modelo de INSERTAR_RESEÑA y su vista
?>