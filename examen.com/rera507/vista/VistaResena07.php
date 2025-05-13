<?php
    namespace rera507\vista;

    use rera507\util\Html;
    use rera507\entidad\Resena07;

    class VistaResena07 {
        public function enviarSalida(mixed $reseña) :void {
            Html::inicio("Reseña", ['/rera507/estilos/formulario.css', '/rera507/estilos/general.css', '/rera507/estilos/tablas.css']);
            ?>
            <h1>Detalles de la reseña <?=$reseña->id_reseña?></h1>
                <table>
                    <thead>
                        <tr>
                            <th>Id_Reseña</th>
                            <th>NIF</th>
                            <th>Fecha</th>
                            <th>Clasificacion</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo "<tr>";
                                echo "<td>{$reseña->id_reseña}</td>";
                                echo "<td>{$reseña->nif}</td>";
                                echo "<td>{$reseña->fecha->format(Resena07::FECHA_USUARIO)}</td>";
                                echo "<td>{$reseña->clasificacion}</td>";
                                echo "<td>{$reseña->comentario}</td>";
                            echo"</tr>";
                        ?>
                    </tbody>
                </table>
            <?php
            Html::fin();
        }   
    }
?>
