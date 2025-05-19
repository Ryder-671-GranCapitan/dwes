<?php

// 4.2 hacer vista del resultado

namespace ExamenRa5Repetido1\vista;

use ExamenRa5Repetido1\util\Html;
use ExamenRa5Repetido1\entidad\Pedido26;

// clase para generar el resultado de la consulta select 
class vistaPedido26
{
    public function enviarSalida(mixed $pedido): void
    {
        Html::inicio('pedido', ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);
?>
        <h1>Detalles del pedido <?= $pedido->npedido ?></h1>
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
                <tr>
                    <td><?= $pedido->npedido ?></td>
                    <td><?= $pedido->nif ?></td>
                    <td><?= $pedido->fecha->format(Pedido26::FECHA_USUARIO) ?></td>
                    <td><?= $pedido->observaciones ? $pedido->observaciones : '' ?></td>
                    <td><?= $pedido->total_pedido ? $pedido->total_pedido : '' ?></td>
                </tr>
            </tbody>

        </table>


<?php
        Html::fin();
    }
}


?>