<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/examenMioRa23/include/funciones.php");

    $cursos = ['ofi' => ['descripcion' => 'Ofimática', 'precio' => 100],
                'pro' => ['descripcion' => 'Programación', 'precio' => 200],
                'rep' => ['descripcion' => 'Reparación ordenadores', 'precio' => 150]
    ];


    // Peticiones
    inicio_html("Folmulario", ["/EjerciciosRepaso/examenMioRa23/estilos/general.css", "/EjerciciosRepaso/examenMioRa23/estilos/formulario.css", "/EjerciciosRepaso/examenMioRa23/estilos/tabla.css"]);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo "<h1>Benvindo au Examen Chingón</h1>";
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Mete tu dato manito</legend>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">

                    <label for="cursos">Cursos Disponible</label>
                    <select name="cursos[]" id="cursos" multiple>
                        <?php
                            foreach ($cursos as $key => $curso) {
                                echo "<option value='$key'>{$curso['descripcion']} - {$curso['precio']}€</option>";
                            }
                        ?>
                    </select>

                    <label for="clases_presenciales">Clases</label>
                    <input type="number" id="clases_presenciales" name="clases_presenciales">

                    <label for="desempleado">¿Desempleo?</label>
                    <input type="checkbox" id="desempleado" name="desempleado">

                    <label for="archivo">Tarjeta de Desempleado</label>
                    <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
                </fieldset>
                <input type="submit" id="operacion" name="operacion" value="Enviar">
            </form>
        <?php

        fin_html();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

        global $cursos;

        // Validamos el formulario
        $array_saneamiento = [
            'email' => FILTER_SANITIZE_SPECIAL_CHARS,
            'cursos' => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                        'flags' => FILTER_REQUIRE_ARRAY],
            'clases_presenciales' => FILTER_SANITIZE_NUMBER_INT,
            'desempleado' => FILTER_VALIDATE_BOOL
        ];

        $datos_saneados = filter_input_array(INPUT_POST, $array_saneamiento);

        // Validamos los datos
        $datos_saneados['email'] = filter_var($datos_saneados['email'], FILTER_VALIDATE_EMAIL);

        $fichero = $_FILES['archivo'];
        $directorio_guardao = $_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/examenMioRa23/tarjetas";

        ?>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Cursos</th>
                        <th>Clases</th>
                        <th>Desempleo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$datos_saneados['email']?></td>
                        <?php
                            echo "<td>";

                            if (is_array($datos_saneados['cursos'])) { // Se comprueba si los cursos son un array
                                foreach ($datos_saneados['cursos'] as $curso_key) { // Se recorre el array y se sacan la descripcion y el precio
                                    echo "{$cursos[$curso_key]['descripcion']} - {$cursos[$curso_key]['precio']}€<br>";
                                }
                            }
                            echo "</td>";
                        ?>
                        <td><?=$datos_saneados['clases_presenciales']?></td>
                        <td><?=$datos_saneados['desempleado'] ? 'Desempleado' : 'Con chamba'?></td>
                    </tr>
                </tbody>
            </table>

        <?php

        if (mime_content_type($fichero['tmp_name']) == "application/pdf") {
            if (!file_exists($directorio_guardao) || !is_dir($directorio_guardao)) {
                if (!mkdir($directorio_guardao, 0755, true)) {
                    echo "La calpeta no exite manito";
                }
            }

            if (move_uploaded_file($fichero['tmp_name'], $directorio_guardao . "/{$datos_saneados['email']}.pdf")) {
                echo "Nombre Archivo Anteriol: {$fichero['name']} <br>";
                echo "Nombre Archivo Nuevol: {$datos_saneados['email']} <br>";
            }
        }

        $total = 0;

        foreach ($datos_saneados['cursos'] as $dato) {
            $total += $cursos[$dato]['precio'];
        }

        echo "El precio total de los cursos es: $total <br>"; 

        $total += 10 * $datos_saneados['clases_presenciales'];

        echo "Al tener {$datos_saneados['clases_presenciales']}, el precio asciende a $total <br>";

        if ($datos_saneados['desempleado']) {
            echo "Te vamo a descontal un 10% por no tenel chamba<br>";
            $total = $total - $total * 0.1;
            echo "El chiste se ta quedao por: $total<br>";
        }
        else {
            echo "Tu chambea mano, tu tiene plata";
        }


    }
?>