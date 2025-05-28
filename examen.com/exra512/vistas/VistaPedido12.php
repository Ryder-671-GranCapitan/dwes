<?php
// Yahya Limouni | 12

namespace exra512\vistas;

use exra512\util\Html;
use exra512\entidad\Pedido12;

class VistaPedido12 {
    public function enviarSalida(mixed $pedido): void {
        Html::inicio("Pedido", ['/exra512/estilos/formulario.css', '/exra512/estilos/tablas.css', '/exra512/estilos/general.css']);

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
                        echo "<td>{$pedido->fecha->format(Pedido12::FECHA_USUARIO)}</td>";
                        echo "<td>{$pedido->observaciones}</td>";
                        echo "<td>{$pedido->total_pedido}</td>";
                    echo "</tr>";
                ?>
            </tbody>
        </table>
        <?php

        Html::fin();
    }
} 

?>