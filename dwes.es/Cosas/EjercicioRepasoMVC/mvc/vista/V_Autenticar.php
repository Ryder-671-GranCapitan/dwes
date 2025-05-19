<?php

// Espacio de nombres
namespace mvc\vista;

use mvc\vista\Vista;

// Creamos la clase
class V_Autenticar extends Vista{
    public function genera_salida($datos): void
    {
        if ($datos){
            $this->inicio_html("Bienvenido {$_SESSION['cliente']}", ['./styles/general.css', './styles/tablas.css']);
            echo "<h1>Bienvenido {$_SESSION['cliente']}</h1>";

            // Devolvemos la tabla de satos obtenidos de la funcion de la consulta
            ?>
                <table>
                    <thead>
                        <tr>
                            <td>Referencia</td>
                            <td>Descripcion</td>
                            <td>PVP</td>
                            <td>Dto_Venta</td>
                            <td>Categoria</td>
                            <td>Tipo_Iva</td>
                            <td>Añadir Reseña</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($datos as $articulo) {
                                echo "<tr>";
                                    echo "<td>{$articulo['referencia']}</td>";
                                    echo "<td>{$articulo['descripcion']}</td>";
                                    echo "<td>{$articulo['pvp']}</td>";
                                    echo "<td>{$articulo['dto_venta']}</td>";
                                    echo "<td>{$articulo['categoria']}</td>";
                                    echo "<td>{$articulo['tipo_iva']}</td>";
                                    // Aqui estamos devolviendo un formulario para que cuando se pulse el botón de la reseña para añadir
                                    // reseña, se mande la referencia de ese articulo mediante la referencia que esta hidden
                                    ?>
                                        <td><form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                            <input type="hidden" id="referencia" name="referencia" value="<?=$articulo['referencia']?>">
                                            <button type="submit" id="idp" name="idp" value="reseña">Insertar Reseña</button>
                                        </form></td>
                                    <?php
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php

        } else {
            echo "Datos no encontrados";
        }
    }
} 
?>