<?php

// Espacio de nombres
namespace mvc\vista;

use mvc\vista\Vista;

// Creación de la clase
class V_Reseña extends Vista{
    // Debemos de generar la salida para el usuario en el que muestre todas las reseñas que tiene un artículo
    public function genera_salida($datos): void
    {
        $this->inicio_html("Reseñas del artículo", ['./styles/general.css', './styles/tablas.css', './styles/formulario.css']);
        echo "<h1>Reseñas del producto con referencia {$_SESSION['referencia']}</h1>";

        // Y aquí, devolveremos un formulario con un botón que ponga, añadir nueva reseña
        // Aquí, según el ejercicio, debemos de generar un formulario para insertar una nueva reseña del artículo
        if (is_array($datos)){
            ?>
        <br>
        <form action="<?=$_SERVER['PHP_SELF']?>" method='POST'>
            <fieldset>
                <legend>Inserta una nueva reseña</legend>
                <input type="hidden" name="referencia" id="referencia" value="<?=$_SESSION['referencia']?>">
                <label for="clasificación">Clasificación</label>
                <input type="number" id="clasificacion" name="clasificacion" required>
                <label for="comentario">Comentario</label>
                <input type="text" id="comentario" name="comentario">
            </fieldset>
            <button type="submit" id="idp" name="idp" value="insertar_reseña">Insertar nueva reseña</button>
        </form>
        <br>
        <?php
        // Y aquí mostraremos en formato de tabla las reseñas que tiene el producto
        echo "<table>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>Id_reseña</th>";
                    echo "<th>Nif</th>";
                    echo "<th>Referencia</th>";
                    echo "<th>Fecha</th>";
                    echo "<th>Clasificación</th>";
                    echo "<th>Comentario</th>";
                echo "</tr>";
            echo "</thead><tbody>";
            foreach($datos as $articulo){
                echo "<tr>";
                    echo "<td>{$articulo['id_reseña']}</td>";
                    echo "<td>{$articulo['nif']}</td>";
                    echo "<td>{$articulo['referencia']}</td>";
                    echo "<td>{$articulo['fecha']}</td>";
                    echo "<td>{$articulo['clasificacion']}</td>";
                    echo "<td>{$articulo['comentario']}</td>";
                echo "</tr>";
            }
        echo "</tbody></table>";
        $this->fin_html();
        }else {
            echo "<h2>$datos</h2>";
            ?>
            <br>
            <form action="<?=$_SERVER['PHP_SELF']?>" method='POST'>
                <fieldset>
                    <legend>Inserta una nueva reseña</legend>
                    <input type="hidden" name="referencia" id="referencia" value="<?=$_SESSION['referencia']?>">
                    <label for="clasificación">Clasificación</label>
                    <input type="number" id="clasificacion" name="clasificacion" required>
                    <label for="comentario">Comentario</label>
                    <input type="text" id="comentario" name="comentario">
                </fieldset>
                <button type="submit" id="idp" name="idp" value="insertar_reseña">Insertar nueva reseña</button>
            </form>
            <br>
            <?php
        }
    }

    // Terminada la vista, debemos de generar el modelo de Insertar_Reseña y la vista de esta
    // Al lío
}

?>