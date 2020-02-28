<?php
    class inserciones{

        public function registrarUsuario($nombre , $apellidoPaterno , $correo , 
                                        $telefono , $estatus , $sucursal , $contrasenia , $avatar ){
            $respuesta = null;
            $sql = "INSERT INTO eventos(id, title, descripcion, color, textColor, inicio, final)
             VALUES ()";
            try {
                $claseConexion = new database();
                $db = $claseConexion->obtenerConexion();
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":Nombre", $nombre);
                $stmt->bindParam(":Apellido", $apellidoPaterno);
                $stmt->bindParam(":Correo", $correo);
                $stmt->bindParam(":Telefono", $telefono);
                $stmt->bindParam(":Estatus", $estatus);
                $stmt->bindParam(":Sucursal", $sucursal);
                $stmt->bindParam(":Contrasenia", $contrasenia);
                $stmt->bindParam(":Foto", $avatar);
                $stmt->execute();
                $respuesta['estado'] = "ok";
                $respuesta['mensaje'] = "Se creo correctamente el usuario";
            } 
            catch (PDOEXCEPTION $e) {
                $respuesta['estado'] = "error";
                $respuesta['mensaje']  = $e->getMessage();
            }
            return $respuesta;
        }
    }