<?php
    namespace ExRA5\vista;

    use ExRA5\util\Html;
    use ExRA5\entidad\Pedido07;

    class VistaPedido12 {
        public function enviarSalida(mixed $pedido) : void {
            Html::inicio("Pedido", ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);
            ?>
                <h1>Detalles del pedido <?=$pedido->npedido?></h1>
                <table>
                    <thead>
                        <tr>
                            <th>NPedido</th>
                            <th>NIF</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                            <th>Total Pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo "<tr>";
                                echo "<td>{$pedido->npedido}</td>";
                                echo "<td>{$pedido->nif}</td>";
                                echo "<td>{$pedido->fecha->format(Pedido07::FECHA_USUARIO)}</td>";
                                echo "<td>{$pedido->observaciones}</td>";
                                echo "<td>{$pedido->total_pedido}</td>";
                            echo"</tr>";
                        ?>
                    </tbody>
                </table>
            <?php
            Html::fin();
        }
    }
?>