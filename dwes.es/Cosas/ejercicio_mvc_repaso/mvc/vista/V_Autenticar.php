<?php

// Espacio de nombres
namespace mvc\vista;

use mvc\vista\Vista;

// Creamos la clase
class V_Autenticar extends Vista{
    public function genera_salida($datos): void
    {
        if ($datos){
            $this->inicio_html("Bienvenido", ['./styles/general.css', './styles/tablas.css']);
            echo "<h1>Bienvenido {$_SESSION['cliente']}</h1>";

            // Devolvemos la tabla con los datos obtenidos de la función de la consulta
            echo "<table>";
            echo "<thead>";
                echo "<tr>";
                    echo "<td>Referencia</td>";
                    echo "<td>Descripcion</td>";
                    echo "<td>Pvp</td>";
                    echo "<td>Dto Venta</td>";
                    echo "<td>Categoría</td>";
                    echo "<td>Tipo iva</td>";
                    echo "<td>Añadir reseña</td>";
                echo "</tr>";
            echo "</thead><tbody>";
            foreach($datos as $articulo){
                echo "<tr>";
                    echo "<td>{$articulo['referencia']}</td>";
                    echo "<td>{$articulo['descripcion']}</td>";
                    echo "<td>{$articulo['pvp']}</td>";
                    echo "<td>{$articulo['dto_venta']}</td>";
                    echo "<td>{$articulo['categoria']}</td>";
                    echo "<td>{$articulo['tipo_iva']}</td>";
                    // Aquí estamos devolviendo un formulario para que cuando se pulse el botón de la reseña para lanzar la petición
                    // reseña, se mande la referencia de ese articulo mediante la referencia que esta 
                    // hidden

                    // En este formulario hay algún error Voy a mirar el ejemplo de rafa que creaba un formulario de la misma manera

                    echo "<td>
                        <form action='/ejercicio_repaso_mvc/index.php' method='POST'>
                            <input type='hidden' id='referencia' name='referencia' value='{$articulo['referencia']}'>
                            <button type='submit' id='idp' name='idp' value='reseña'>Insertar reseña</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            // Si os parece, dejo esta parte y despues hago la siguiente, tengo la cabeza un poco saturada...
            // Voy a reposar un rato y desconectar y despues vuelvo a seguir.

            // <3

        }else {
            echo "<h1>Datos no encontrados</h1>";
        }
    }
}

?>