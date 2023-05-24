<?php
    include("conexion.php");
    $objeto = new Conexion();
    $con = $objeto->Conectar();

    $_POST = json_decode(file_get_contents("php://input"),true);

    $opcion = (isset($_GET['opcion']))? $_GET['opcion']:'';

    $id = (isset($_POST['id']))? $_POST['id']:'';
    $nombre = (isset($_POST['nombre']))? $_POST['nombre']:'';

    $data = '';

    switch($opcion){
        case 1:
            if(empty($nombre))break;
            $sql = "INSERT INTO columna (nombre) VALUES('{$nombre}')";
            $res = $con->prepare($sql);
            $res->execute();
            $id = $con->lastInsertId();
            $data = ['id'=>$id,'nombre'=>$nombre];
            break;
        case 2:
            if(empty($nombre))break;
            $sql = "UPDATE columna SET nombre='{$nombre}' WHERE id='{$id}'";
            $res = $con->prepare($sql);
            $res->execute();
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 3:
            $sql = "DELETE FROM columna WHERE id='{$id}'";
            $res = $con->prepare($sql);
            $res->execute();
            break;
        case 4:
            $sql = "SELECT id,nombre FROM columna";
            $res = $con->prepare($sql);
            $res->execute();
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
    print json_encode($data,JSON_UNESCAPED_UNICODE);
    $con = NULL;
?>