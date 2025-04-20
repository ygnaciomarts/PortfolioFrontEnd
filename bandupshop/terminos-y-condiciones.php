<?php
    // Initialize the session
    session_start();
    
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php");
        exit;
    }
    
    // Include config file
    require_once "config.php";
    
    // Define variables and initialize with empty values
    $username = $password = $nombre = "";
    $username_err = $password_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Por favor ingrese su usuario.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Por favor ingrese su contraseña.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, usuario, password, nombre FROM usuarios WHERE usuario = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = $username;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $nombre);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;   
                                $_SESSION["nombre"] = $nombre;                            
                                
                                // Redirect user to welcome page
                                header("location: index.php");
                            } else{
                                // Display an error message if password is not valid
                                $password_err = "La contraseña que has ingresado no es válida.";
                            }
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                    }
                } else{
                    echo "Algo salió mal, por favor vuelve a intentarlo.";
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
        <title>Términos y condiciones | BandUp</title>

        <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link
            href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Montserrat:wght@700&display=swap"
            rel="stylesheet">
        <link href="css/normalize.css" rel="stylesheet">
        <link href="css/styles.css" as="style" rel="preload">
        <link href="css/styles.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/c80fbc750b.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="logo-alt">
            <a href="https://bandup.monkeydevs.mx">
                <img src="/bandup/img/BandUp.svg" width="100">
            </a>
            <nav class="nav-alt">
                <ul class="menu-alt" style="padding-left: 20px;">
                    <li><a href="https://bandup.monkeydevs.mx/">INICIO</a></li>
                    <li><a href="/quienessomos.html">QUIÉNES SOMOS</a></li>
                    <li><a href="#">CATÁLOGO</a></li>
                    <li><a href="/contacto.html">CONTACTO</a></li>
                </ul>
            </nav>
        </div>

        <div class="contenedor-registro cr-login">
            <a class="titulos-body alt">Términos y condiciones</a>
            <p>
            El uso de nuestros servicios, así como la compra de nuestros productos, implicará que usted ha leído y aceptado los Términos y Condiciones de Uso en el presente documento.

La realización de la compra de productos a través de BandUp está sujeta a la comprobación de los datos personales y de la tarjeta proporcionados por el Cliente y a la autorización por parte del banco emisor de la tarjeta de crédito o débito cuyos datos ha proporcionado el Cliente para el pago de los productos solicitados o por parte del banco aceptante. Si los datos personales o de la tarjeta de crédito proporcionados por el Cliente no coinciden con los datos a disposición del banco emisor de la tarjeta de crédito o débito o, aun coincidiendo los datos en cuestión, el banco emisor o el banco aceptante no autorizan el cargo solicitado por el Cliente, la compra no será procesada ni finalizada y los productos serán ofrecidos para venta al público sin responsabilidad alguna para BandUp. Todos los productos y todos los derechos sobre los mismos quedan expresamente reservados exclusivamente a la empresa o a sus legítimos titulares.

El envío tarda 15 días hábiles a partir de la confirmación de tu compra.

 
POLÍTICA DE GARANTÍA
Nuestra política tiene una duración de 30 días hábiles a partir de la entrega de tu producto.
Todos los productos son enviados de base a la orden que emite el Cliente; por lo que si se llegará a presentar algún tipo de queja o cambio puedes hacerlo a través del correo electrónico soporte@bandup.mx para poder brindar una pronta solución a tu inconveniente.
En tales casos, la garantía solo cubrirá fallas de fábrica en caso de algún error con respecto a la orden emitida, la cual solo será valida cuando el producto se haya usado correctamente o. La garantía no cubre daños ocasionados por uso indebido. No se realizan devoluciones, ni reembolsos.
BandUp podrá realizar cualquier cambio en los Términos y Condiciones sin previo aviso.
Si tiene alguna duda o pregunta respecto a los Términos Y Condiciones por favor contáctenos en la siguiente dirección: soporte@bandup.mx
            </p>
        </div>

        <div class="img-registro">
            <img src="side-registro-<?php echo rand(1, 12); ?>.png" alt="Registro" width="700px" />
        </div>
    </body>
</html>