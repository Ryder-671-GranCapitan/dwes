<?php
    namespace orm\modelo\orm;

    use orm\modelo\orm\ORMDireccion_Envio;
    use orm\modelo\orm\DireccionEnvio;

    class Mvc_Orm_Direccion_Envio extends ORMDireccion_Envio {
        public function getDireccionesCliente($nif) {
            $sql = "SELECT nif, id_dir_env, direccion, cp, poblacion, provincia, pais FROM {$this->tabla} WHERE nif = :nif";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nif', $nif);

            if ($stmt->execute()) {
                while ($fila = $stmt->fetch()) {
                    $de = new DireccionEnvio($fila);
                    $direcciones_envio[] = $de;
                }
                return $direcciones_envio;
            }

            return [];
        }
    
    }
?>