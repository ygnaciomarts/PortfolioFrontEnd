<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme la contraseña.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Algo salió mal, por favor vuelva a intentarlo.";
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
        <style>
            ::-webkit-scrollbar {
                display: none;
            }

            html,
            body {
                height: 100%;
                overflow: hidden
            }
        </style>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Restaura tu contraseña | BandUp</title>

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
                <img src="/img/BandUp.svg" width="100">
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
            <a class="titulos-body alt">Restaura tu contraseña</a>
            <br>
            <form class="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C12.1,13 13.66,13.23 15.11,13.69C14.5,14.07 14,14.6 13.61,15.23C12.79,15.03 11.89,14.9 11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H13.04C13.13,18.8 13.38,19.44 13.76,20H3V17C3,14.34 8.33,13 11,13M18.5,10H20L22,10V12H20V17.5A2.5,2.5 0 0,1 17.5,20A2.5,2.5 0 0,1 15,17.5A2.5,2.5 0 0,1 17.5,15C17.86,15 18.19,15.07 18.5,15.21V10Z" />
                    </svg>
                    <input class="sesion" name="new_password" type="password" placeholder="Nueva contraseña" pattern="[A-Za-z0-9]{6,15}" />
                    <span class="help-block">
                        <?php echo $new_password_err; ?>
                    </span>
                </div>
                <br>
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                    </svg>
                    <input name="confirm_password" type="password" placeholder="Confirmar contraseña" minlength="8" />
                    <br>
                    <span class="help-block">
                        <?php echo $confirm_password_err; ?>
                    </span>
                </div>
                <br><br>
                <div class="center">
                    <button type="submit" class="registro" name="enviar">Cambiar</button>
                </div>
                <div class="center">
                    <p><a class="link" href="/my-account">Cancelar</a></p>
                    
                </div>
                <br>
            </form>
        </div>

        <div class="img-registro">
            <img src="side-registro-<?php echo rand(1, 12); ?>.png" alt="Registro" width="700px" />
        </div>
    </body>
</html>