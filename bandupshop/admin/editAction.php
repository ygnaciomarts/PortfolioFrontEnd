<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    //include 'product-edit.php';
    include '../config.php';

    $id = $_POST['id'];
    $nombre=$_POST['nombre'];
    $artista=$_POST['artista'];
    $tipo = $_POST['tipo'];
    $precioV = $_POST["precioV"];
    $precioD = $_POST["precioD"];
    $existencias = $_POST["existencias"];
    $descripcion = $_POST["descripcion"];
    $tracklist = $_POST['tracklist'];
    $estado = $_POST["estado"];
    //$cover = $_FILES[$_POST['cover']]['tmp_name'];
    //$imagenE = file_get_contents($cover);

    $sql = "UPDATE productos SET nombre='".$nombre."', artista='".$artista."', tipo='".$tipo."', precioV='".$precioV."', precioD='".$precioD."', existencias='".$existencias."', descripcion='".$descripcion."', tracklist='".$tracklist."', modificado='".date("Y-m-d H:i:s")."' WHERE id = ".$id;

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        //mysqli_stmt_bind_param($stmt, "sssssssssss", $param_nombre, $param_artista, $param_tipo, $param_precioV, $param_precioD, $param_existencias, $param_creado, $param_modificado, $param_imagen, $param_descripcion, $param_tracklist);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: /bandupshop/admin/product-edit.php");
            echo "Algo salió mal. Por favor, inténtalo de nuevo.";
        } else{
            echo "Algo salió mal. Por favor, inténtalo de nuevo.";
        }
        header("location: /bandupshop/admin/product-edit.php");
        echo "Actualización exitosa.";
    }
?>