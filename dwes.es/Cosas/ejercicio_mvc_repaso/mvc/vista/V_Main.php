<?php

// Y creamos la vista del main
namespace mvc\vista;

use mvc\vista\Vista;

// Creamos la clase V_Main
class V_Main extends Vista{
    public function genera_salida($datos): void
    {
        $this->inicio_html("Pagina inicio sesión", ['./styles/general.css', './styles/formulario.css']);
        // ¿Y qué debemos mostrarle al usuario? Pues lo que nos diga el ejercicio
        // Pues mostramos el formulario autenticar que hará una petición a autenticar
        echo "<h1>Inicia sesión</h1>"
        ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>Introduce los datos de inicio de sesión</legend>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="clave">Clave</label>
                <input type="password" id="clave" name="clave" required>
            </fieldset>
            <button type="submit" name="idp" id="idp" value="autenticar">Logueate</button>
        </form>
        <?php
        $this->fin_html();
    }
}
// Terminada la vista V_Main
// Vamos a probarlo

// Bueno, ya una vez lo tengamos terminado y funcionando, tenemos que hacer el modelo de autenticar que será
// a lo que llame la petición del botón

// Vamos al lío
?>