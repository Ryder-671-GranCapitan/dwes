<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . '/Act02BBDD/util/Autocarga.php');

    use orm\ORMCliente;
    use util\Autocarga;
    use util\Html;

    Autocarga::autoload_reg();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['operacion'])) {
            if ($_POST['operacion'] == 'modificar') {
                $id_dir = $_POST['direccion'];

                $nif = $_SESSION['cliente']['nif'];
                $direccion_cliente = $_SESSION['direcciones'][$nif][$id_dir];
            }
            Html::inicio("Modificar", ['./estilos/general.css', './estilos/formulario.css']);
            ?>
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                    <fieldset>
                        <label for="direccion">Direccion</label>
                        <input type="text" name="direccion" value="<?=isset($direccion_cliente['direccion']) ? $direccion_cliente['direccion'] : '' ?>">

                        <label for="cp">CP</label>
                        <input type="number" name="cp" value="<?=isset($direccion_cliente['cp']) ? $direccion_cliente['cp'] : '' ?>">

                        <label for="poblacion">Poblacion</label>
                        <input type="text" name="poblacion" value="<?=isset($direccion_cliente['poblacion']) ? $direccion_cliente['poblacion'] : '' ?>">

                        <label for="provincia">Provincia</label>
                        <input type="text" name="provincia" value="<?=isset($direccion_cliente['provincia']) ? $direccion_cliente['provincia'] : '' ?>">

                        <label for="pais">Pais</label>
                        <input type="text" name="pais" value="<?=isset($direccion_cliente['pais']) ? $direccion_cliente['pais'] : '' ?>">
                    </fieldset>
                    <input type="submit" name="operacion1" value="Insertar">
                    <input type="submit" name="operacion1" value="Modificar">
                </form>

            <?php
        }

        if (isset($_POST['operacion1']) && $_POST['operacion1'] == 'Insertar') {
            $direccion = $_POST['direccion'];
            $cp = $_POST['cp'];
            $poblacion = $_POST['poblacion'];
            $provincia = $_POST['provincia'];
            $pais = $_POST['pais'];

            $ORMcliente = new ORMCliente();

            $direcciones = [
                'nif' => $_SESSION['cliente']['nif'],
                'direccion' => $direccion,
                'cp' => $cp,
                'poblacion' => $poblacion,
                'provincia' => $provincia,
                'pais' => $pais
            ];

            if($ORMcliente->insertarDir($direcciones)){
                echo "<h2>Direccion insertada correctamente</h2>";
            }
            else {
                echo "<h2>Error al insertar la direccion</h2>";
            }
        }
    }
Html::fin();
?>
