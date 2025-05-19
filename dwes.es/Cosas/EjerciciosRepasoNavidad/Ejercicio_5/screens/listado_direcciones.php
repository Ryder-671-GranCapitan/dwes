<?php
    // Iniciamos la sesion
    session_start();

    // Inicializamos ob
    ob_start();

    // Importamos cosas que necesitamos
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/03jwt_include.php");

    // Validamos el JWT
    if ($_COOKIE['jwt']){
        $payload = verificar_token($_COOKIE['jwt']);
        $jwt = $_COOKIE['jwt'];
        $payload = verificar_token($jwt);
    }

    // Iniciamos HTML
    inicio_html("Listado Direcciones", ['../../styles/general.css', '../../styles/formulario.css', '../../styles/tablas.css']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $payload) {
        echo "<h1>Bienvindo a la pantalla de listado de direcciones</h1>";

        try {
            // Conexion con la BBDD
            $cbd = new mysqli("mysql", "usuario", "usuario", "tiendaol", 3306);
    
            // Preparamos la consulta
            $sql = "SELECT nif, id_dir_env, direccion, cp, poblacion, provincia, pais";
            $sql .= " FROM direccion_envio";
            $sql .= " WHERE nif = ?";
    
            // Preparamos la consulta
            $stmt = $cbd->prepare($sql);
    
            // Enlazamos parametros
            $stmt->bind_param("s", $payload['nif']);
    
            // Ejecutamos la consulta
            $stmt->execute();
    
            // Obtenemos los resultados
            $resultset = $stmt->get_result();
    
            // Mostramos los resultados
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>NIF</th>";
            echo "<th>ID Direccion</th>";
            echo "<th>Direccion</th>";
            echo "<th>CP</th>";
            echo "<th>Poblacion</th>";
            echo "<th>Provincia</th>";
            echo "<th>Pais</th>";
            echo "<th>Eliminar</th>";
            echo "<th>Editar</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($fila = $resultset->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['nif'] . "</td>";
                echo "<td>" . $fila['id_dir_env'] . "</td>";
                echo "<td>" . $fila['direccion'] . "</td>";
                echo "<td>" . $fila['cp'] . "</td>";
                echo "<td>" . $fila['poblacion'] . "</td>";
                echo "<td>" . $fila['provincia'] . "</td>";
                echo "<td>" . $fila['pais'] . "</td>";
                ?>
        <td>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                <button type='submit' name='eliminar' id='eliminar' value="<?=$fila['id_dir_env']?>">Eliminar</button>
            </form>
        </td>
        <td>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                <button type='submit' name='operacion' id='operacion' value="<?=$fila['id_dir_env']?>">Editar</button>
            </form>
        </td>
        <?php
        echo "</tr>";
    }
    echo "</tbody></table>";
    }catch(Exception $e){
        echo "Mensaje: " . $e->getMessage();
    }
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <input type='submit' name='operacion' id='operacion' value='Nuevo'>
    </form>
    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && $payload){

    // Validar el dato
    $operacion = filter_input(INPUT_POST, 'operacion', FILTER_SANITIZE_SPECIAL_CHARS);
    $eliminar = filter_input(INPUT_POST, 'eliminar', FILTER_SANITIZE_NUMBER_INT);
    $editar = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);

    if ($operacion == 'Nuevo'){
        header("Location: nueva_direccion.php");
    }else if ($eliminar){
        try{

        // Creamos conexión con la base de datos
        $cbd = new mysqli("mysql", "usuario", "usuario", "tiendaol", 3306);

        // Preparamos consulta
        $sql = "DELETE FROM direccion_envio";
        $sql.= " WHERE nif = ? AND id_dir_env = ?";
        $stmt = $cbd->prepare($sql);

        // Vinculamos los parametros
        $stmt->bind_param("si", $payload['nif'], $eliminar);

        // Ejecutamos la consulta
        if ($stmt->execute() && $stmt->affected_rows == 1){
            echo "<h2>Se ha eliminado la dirección correctamente</h2>";
            echo "<a href='listado_direcciones.php'>Volver al listado</a>";
        } 
        }catch(Exception $e){
            echo "Mensaje: " . $e->getMessage();
        }

    }
}

?>