<?php
// Nombre: JAIME GRUESO MARTIN
    session_start();
    
    use orm\ORMAlumno;
    use entidad\FilaAlumno;
    use util\Autocarga;
    use util\Html;

    require_once('./util/Autocarga.php');

    Autocarga::autoload_alu();


    if( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion'] == 'Mandar DNI' ){
    
        $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_EMAIL);
        $dni = $_POST['dni'];
    
        if( $dni ){
            $cursos_disponibles = [
                "daw1" => "1º CFGS DAW",
                "daw2" => "2º CFGS DAW",
                "daw3" => "1º CFGS DAM",
                "daw4" => "2º CFGS DAM"
            ];

            $grupos = [
                "A" => "Mañana",
                "B" => "Tarde"
            ];
    
            $_SESSION['dni'] = $dni;
            
            $orm_alu = new ORMAlumno();

            $alumno = $orm_alu->buscar($dni);

            if (!$alumno) {
                echo "No se encontró ningún alumno con el DNI $dni. <a href='index07.php'>Volver</a>";
                exit;
            }

            Html::inicio('Modificar Alumno', ['./estilos/formulario.css', './estilos/general.css']);
            ?>
                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <fieldset>
                        <legend>Datos del Alumno</legend>
                        <label for="dni">DNI</label>
                        <input type="text" name="dni" id="dni" value="<?=$alumno->dni?>">

                        <label for="curso">Curso</label>
                        <select name="curso" id="curso">
                            <?php
                                foreach($cursos_disponibles as $curso => $descripcion){
                                    $selected = ($curso == $alumno->curso) ? 'selected' : '';
                                    echo "<option value='$curso' $selected>$descripcion</option>";
                                }
                            ?>
                        </select>

                        <label for="grupo">Grupo</label>
                        <select name="grupo" id="grupo">
                            <?php
                                foreach($grupos as $grupo => $descripcion){
                                    $selected = ($grupo == $alumno->grupo) ? 'selected' : '';
                                    echo "<option value='$grupo' $selected>$descripcion</option>";
                                }
                            ?>
                        </select>

                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?=$alumno->fecha_nacimiento->format(FilaAlumno::FECHA_MYSQL)?>">
                    </fieldset>
                    <input type="submit" name="operacion" value="Actualizar">
                </form>
            <?php
        }
    }

    if( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion'] == 'Actualizar' ){

        $cursos_disponibles = [
            "daw1" => "1º CFGS DAW",
            "daw2" => "2º CFGS DAW",
            "daw3" => "1º CFGS DAM",
            "daw4" => "2º CFGS DAM"
        ];

        $grupos = [
            "A" => "Mañana",
            "B" => "Tarde"
        ];

        $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
        $curso = filter_input(INPUT_POST, 'curso', FILTER_SANITIZE_SPECIAL_CHARS);
        $grupo = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_SPECIAL_CHARS); 
        $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_SPECIAL_CHARS);

        if(!$dni || !$curso || !$grupo || !$fecha_nacimiento) {
            echo "Error: Todos los campos son obligatorios";
            exit;
        }

        if(!array_key_exists($curso, $cursos_disponibles) || !array_key_exists($grupo, $grupos)) {
            echo "Error: Curso o grupo no válidos";
            exit; 
        }

        try {
            $alumno = new FilaAlumno([
                'dni' => $dni,
                'curso' => $curso, 
                'grupo' => $grupo,
                'fecha_nacimiento' => $fecha_nacimiento
            ]);

            $orm_alu = new ORMAlumno();

            if($orm_alu->actualizar($alumno)){
                echo "Alumno actualizado correctamente. <a href='index07.php'>Volver</a>";
            } else {
                echo "Error al actualizar el alumno. <a href='index07.php'>Volver</a>";
            }
        } catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
    <form action="index07.php" method="post">
        <input type="submit" name="operacion1" value="Cerrar Sesion">
    </form>












