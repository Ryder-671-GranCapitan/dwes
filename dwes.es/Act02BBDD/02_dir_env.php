<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . '/Act02BBDD/util/Autocarga.php');

    use orm\ORMCliente;
    use util\Autocarga;
    use util\Html;

    Autocarga::autoload_reg();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $ORMCliente = new ORMCliente();

        $nif = $_SESSION['cliente']['nif'];

        $direcciones = $ORMCliente->getDirecciones($nif);

        Html::inicio("Direcciones Envio", ['./estilos/general.css', './estilos/tablas.css']);
        
        ?> 
        <h1>Direcciones de Envio</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Direccion</th>
                        <th>CP</th>
                        <th>Poblacion</th>
                        <th>Provincia</th>
                        <th>Pais</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                        foreach ($direcciones as $direccion) {
                            $_SESSION['direcciones'][$direccion['nif']][$direccion['id_dir_env']] = $direccion;
                            echo "<tr>";
                                echo "<td>{$direccion['id_dir_env']}</td>";
                                echo "<td>{$direccion['direccion']}</td>";
                                echo "<td>{$direccion['cp']}</td>";
                                echo "<td>{$direccion['poblacion']}</td>";
                                echo "<td>{$direccion['provincia']}</td>";
                                echo "<td>{$direccion['pais']}</td>";
                                echo "<td><form action='{$_SERVER['PHP_SELF']}' method='post'><button name='operacion' value='eliminar'>Eliminar</button></form>
                                        <form action='03_final.php' method='post'><input type='hidden' name='operacion' value='modificar'><button name='direccion' value='{$direccion['id_dir_env']}'>Modificar</button></form></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            <form action="03_final.php" method="post">
                <button name="operacion" value="añadir">Añadir Direccion Envio</button>
            </form>

            <form action="01_auth.php" method="post">
                <button name="operacion" value="cerrar_sesion">Back to Inisio</button>
            </form>
        <?php

        
    }
Html::fin();
?>