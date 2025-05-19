<?php

// Espacio de nombres
namespace mvc\vista;

use mvc\vista\Vista;

// Creamos la Clase V_Insertar_Reseña que extiende de Vista
class V_Insertar_Reseña extends Vista{

    // Vista que se le muestra al cliente cuando el modelo M_Insertar_Reseña le ha mandado los datos
    public function genera_salida($datos): void
    {
        $this->inicio_html("Valores de la reseña", ['./styles/general.css', './styles/tablas.css']);
        echo "<h1>Datos de la reseña insertada para el artículo {$datos['referencia']}</h1>";
        // Vamos a devolver una tabla con el valor que se ha introducido en la base de datos y un botón para que vuelva
        // a la ventana anterior
        // Como el valor lo tenemos en "$datos" vamos a recorrerlo y ver los valores que tiene
        echo "<table>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>Nif</th>";
                    echo "<th>Referencia</th>";
                    echo "<th>Fecha</th>";
                    echo "<th>Clasificación</th>";
                    echo "<th>Comentario</th>";
                echo "</tr>";
            echo "</thead><tbody>";
                echo "<tr>";
                    echo "<td>{$datos['nif']}</td>";
                    echo "<td>{$datos['referencia']}</td>";
                    echo "<td>{$datos['fecha']}</td>";
                    echo "<td>{$datos['clasificacion']}</td>";
                    echo "<td>{$datos['comentario']}</td>";
                echo "</tr>";
        echo "</tbody></table>";

        // Y le añadimos un formulario con un botón para volver hacia atrás
        ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input type="hidden" id="referencia" name="referencia" value="<?=$datos['referencia']?>">
            <button type="submit" id="idp" name="idp" value="autenticar">Volver a las reseñas</button>
        </form>
        <?
        $this->fin_html();
    }
}
// Pues ya estaría el ejercicio terminado
// Espero que sirve de ayuda chavales yo ya con esto, lo repetiré una vez mas y al examen
// Darle caña que podemos con esto y con más VAMOS A POR ELLO CHAVALES QUE QUEDA NADA <3
?>