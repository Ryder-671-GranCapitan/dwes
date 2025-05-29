<?php

namespace rera526\vista;


use rera526\entidad\Envio26;
use rera526\util\Html;

class VistaEnvio26
{
    public function enviarSalida(array $data)
    {
        Html::inicio(
            'lista envios',
            [
                '/rera526/estilos/general.css',
                '/rera526/estilos/formulario.css',
                '/rera526/estilos/tablas.css',
            ]
        );
?>
        <h1>Listado de envios</h1>
        <table>
            <thead>
                <th>
                <td>nenvio</td>
                <td>nif</td>
                <td>id_dir_env</td>
                <td>fecha</td>
                <td>observaciones</td>
                <td>forma_envio</td>
                <td>nfactura</td>
                </th>
            </thead>
            <tbody>
                <?php foreach ($data as $envio) : ?>
                    <tr>
                        <th><?= $envio->nenvio ?></th>
                        <th><?= $envio->nif ?></th>
                        <th><?= $envio->id_dir_env ?></th>
                        <td><?= $envio->fecha->format(Envio26::FECHA_USUARIO) ?></td>
                        <th><?= $envio->observaciones ?></th>
                        <th><?= $envio->forma_envio ?></th>
                        <th><?= $envio->nfactura ?></th>

                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
<?php

        Html::fin();
    }
}


?>