<?php
    include '../config.php';
    session_start();

    $su = ['1'];
    if (!array_key_exists('su', $_SESSION) || !in_array($_SESSION['su'], $su)) {
        header("location: ../404.html");
        die;
    }
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: ../login.php");
        $str_bienvenida = "Iniciar sesión";
        $str_link = "login";
        exit;
    } else {
        $str_bienvenida = $_SESSION["nombre"];
        $str_link = "my-account";
    }

    $nombre = $artista = $tipo = $precioV = $precioD = $existencias = $imagen = $tracklist = $imagen_bin = $descripcion = "";
    $imagen = NULL;
    $nombre_err = $artista_err = $tipo_err = $precioV_err = $precioD_err = $img_err = $descripcion_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = trim($_POST["nombre"]);
        $artista = trim($_POST["artista"]);
        $tipo = trim($_POST["tipo"]);
        $precioV = trim($_POST["precioV"]);
        $precioD = trim($_POST["precioD"]);
        $existencias = trim($_POST["existencias"]);
        $tracklist = trim($_POST["tracklist"]);
        $imagen = $_FILES['imagen']['tmp_name'];
        $imagenE = file_get_contents($imagen);
        $descripcion = trim($_POST["descripcion"]);

        if(empty($nombre_err) && empty($artista_err) && empty($tipo_err) && empty($precioV_err) && empty($img_err) && empty($descripcion_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO productos (nombre, artista, tipo, precioV, precioD, existencias, creado, modificado, img, descripcion, tracklist) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssssssss", $param_nombre, $param_artista, $param_tipo, $param_precioV, $param_precioD, $param_existencias, $param_creado, $param_modificado, $param_imagen, $param_descripcion, $param_tracklist);
                
                // Set parameters
                $param_nombre = $nombre;
                $param_artista = $artista;
                $param_tipo = $tipo;
                $param_precioV = $precioV;
                $param_precioD = $precioD;
                $param_existencias = $existencias;
                $param_creado = date("Y-m-d H:i:s");
                $param_modificado = date("Y-m-d H:i:s");
                $param_imagen = $imagenE;
                $param_descripcion = $descripcion;
                $param_tracklist = $tracklist;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    echo "Producto insertado correctamente.";
                    header("location: /bandupshop/admin/product-insert.php");
                } else{
                    echo "Algo salió mal. Por favor, inténtalo de nuevo.";
                }
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang='es'>
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Insertar producto | BandUp</title>

        <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link
            href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Montserrat:wght@700&display=swap"
            rel="stylesheet">
        <link href="../css/normalize.css" rel="stylesheet">
        <link href="../css/styles.css" as="style" rel="preload">
        <link href="../css/styles.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/c80fbc750b.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="logo-alt">
            <a href="https://bandup.monkeydevs.mx">
                <img src="/bandupshop/img/BandUp.svg" width="100">
            </a>
            <nav class="nav-alt">
                <ul class="menu-alt" style="padding-left: 20px;">
                    <li><a href="https://bandup.monkeydevs.mx/">INICIO</a></li>
                    <li><a href="/bandupshop/admin/product-edit.php">EDITAR PRODUCTOS</a></li>

                </ul>
            </nav>
        </div>

        <div class="contenedor-insertar texto-suelto">
        <a class="titulos-body alt">Insertar producto</a>
            <form class="formulario" enctype="multipart/form-data" name="signup-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-contenedorReg">
                    <input name="nombre" value="<?php echo $nombre; ?>" type="text" placeholder="Nombre">
                    <input name="artista" value="<?php echo $artista; ?>" type="text" placeholder="Artista"/>
                </div>
                <label for="input-contenedorReg">Tipo:</label>
                <div class="input-contenedorReg">
                    <select name="tipo">
                                        <option value="CD">CD</option>
                                        <option value="LP">LP</option>
                                        <option value="Cassette">Cassette</option>
                    </select>
                </div>
                <div class="input-contenedorReg">
                    <input name="precioV" value="<?php echo $precioV; ?>" type="text" placeholder="Precio de venta"/>
                </div>
                <div class="input-contenedorReg">
                    <input name="precioD" type="text" placeholder="Precio con descuento" value="<?php echo $precioD; ?>"/>
                    <p>Imagen:  
                    <input name="imagen" type="file" placeholder="Imagen" value="<?php echo $imagen; ?>" /><br></p>
                    <textarea name="descripcion" value="<?php echo $descripcion; ?>" type="text" placeholder="Descripción" rows="10" cols="60"></textarea><br><br>
                    <textarea name="tracklist" value="<?php echo $tracklist; ?>" type="text" placeholder="Tracklist" rows="10" cols="60"></textarea>
                    <input name="existencias" type="number" placeholder="Existencias" value="<?php echo $existencias; ?>"/>
        </div>
                <br>
                
                    <div class="ins-center">
                    <button type="submit" class="registro" name="subir">Insertar</button>
                </div>
                <br>
            </form>
        </div>
    </body>
</html>