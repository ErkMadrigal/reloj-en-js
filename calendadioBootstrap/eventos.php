<?php
include 'database.php';
$claseDataBase = new database();

    

$accion=(isset($_GET['accion']))?$_GET['accion']:'leer';

switch($accion){
        case 'agregar':
                
                    $sql = "INSERT INTO eventos(title, descripcion, color, textColor, start, end) 
                    VALUES (:title, :descripcion, :color, :textColor, :start, :end)";
                    //$sql = "INSERT INTO eventos(title, descripcion, color, textColor, start, end) 
                    //VALUES ($Titulo, $Descripcion, $Color, $ColorTex, $FechaInicio, $FechaFInal)";
                    $db = $claseDataBase->obtenerConexion();
                    $stmt = $db->prepare($sql);

                    $stmt->execute(array(
                        "title" => $_POST['title'],
                        "descripcion" =>$_POST['descripcion'],
                        "color"=>$_POST['color'],
                        "textColor"=>$_POST['textColor'],
                        "start"=>$_POST['start'],
                        "end"=>$_POST['end']
                        /*"title" => "Ejemplo",
                        "descripcion" =>"example",
                        "color"=>"#fff",
                        "textColor"=>"#000",
                        "start"=>"2018-10-22 10:30:00",
                        "end"=>"2018-10-22 10:30:00"*/
                    ));
                    echo json_encode($stmt);

        break;
        case 'modificar': 
            $sql = "UPDATE eventos SET title=:title, descripcion=:descripcion, color=:color, textColor=:textColor, start=:start, end=:end  
                    WHERE id=:id";
            $db = $claseDataBase->obtenerConexion();
            $stmt = $db->prepare($sql);

            $stmt->execute(array(
                "id"=>$_POST['id'],
                "title" => $_POST['title'],
                "descripcion" =>$_POST['descripcion'],
                "color"=>$_POST['color'],
                "textColor"=>$_POST['textColor'],
                "start"=>$_POST['start'],
                "end"=>$_POST['end']
                
            ));
            echo json_encode($stmt);

        break;
        case 'eliminar':
            $stmt = false;
            if(isset($_POST['id'])){
                $sql="DELETE FROM eventos WHERE ID=:ID";
                $db=$claseDataBase->obtenerConexion();
                $stmt = $db->prepare($sql);
                $stmt->execute(array("ID"=>$_POST['id']));
            }
            echo json_encode ($stmt);
        break;
        default:
            $sql = "SELECT * FROM eventos";

            $db = $claseDataBase->obtenerConexion();
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $eventos=$stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($eventos);
        break;
    }