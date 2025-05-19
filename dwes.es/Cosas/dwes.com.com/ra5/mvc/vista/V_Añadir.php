<?php
    namespace mvc\vista;

    use mvc\vista\Vista;
    use util\seguridad\JWT;
    use Exception;

    class V_Añadir extends Vista {
        public function genera_salida(mixed $datos): void {
            // Si el cliente no ha abierto sesion, 
            // formulario de inicio de sesion

            // Si el cliente ha abuierto ssesion, sus datos
            // y el vboton de cierre de sesion

            // lista de articulos en el carrito

            // Boton de finalizar compra

            // Boton de seguir comprando

            $this->inicio_html("Añadir al carrito", ["/estilos/general.css", "/estilos/tablas.css"]);

            if (isset($_COOKIE['jwt'])) {
                $payload = JWT::verificar_token($_COOKIE['jwt']);
                if (!$payload) {
                    throw new Exception("El token no ha pasado la verificación", 4006);
                }

                $cliente = $_SESSION['cliente'];
                echo "<h3>{$cliente->nombre} {$cliente->apellidos}</h3>";

                echo <<<CIERRA_SESION
                    <form method="POST" action="/ra5/index.php">
                        <button type="submit" name="idp" id="idp" value="Cierra_sesion">Cerrar sesión</button>
                    </form>
                CIERRA_SESION;
            }

            else {
                echo <<<FORM
                    <form method="POST" action="{$_SERVER['PHP_SELF']}">
                        <!-- <input type="hidden" name="idp" id="idp" value="autenticar"> -->
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" size="30">

                        <label for="clave">Clave</label>
                        <input type="password" name="clave" id="clave" size="10">

                        <button type="submit" name="idp" id="idp1" value="autenticar">Inicia sesión</button>
                        <button type="submit" name="idp" id="idp2" value="registrar">Regístrese</button>
                    </form>
                FORM;
            }

            // EL carrito
            $carrito = $_SESSION['carrito'];
            $importe = 0;
            echo <<<TABLA
                <table>
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>Precio Neto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                TABLA;
            foreach ($carrito as $articulo) {
                echo "<tr>" . PHP_EOL;
                echo "<td>{$articulo->referencia}</td>" . PHP_EOL;
                echo "<td>{$articulo->descripcion}</td>" . PHP_EOL;
                echo "<td>{$articulo->pvp}</td>" . PHP_EOL;
                echo "<td>{$articulo->dto_venta}</td>" . PHP_EOL;
                $precio_neto = $articulo->pvp - $articulo->pvp * $articulo->dto_venta;
                $importe += $precio_neto;
                echo "<td>$precio_neto</td>" . PHP_EOL;
                echo "</tr>" . PHP_EOL;
            }

            echo <<<TABLA
                    </tbody>
                </table>
            TABLA;

            echo "<h4>Importe total: $importe</h4>";

            echo <<<FORM
                <form method="POST" action="{$_SERVER['PHP_SELF']}">
                    <button type="submit" name="idp" id="idp1" value="finalizar_compra">Finalizar compra</button>
                    <button type="submit" name="idp" id="idp2" value="seguir_comprando">Seguir comprando</button>
                </form>
            FORM;

            $this->fin_html();
        }
    }
?>