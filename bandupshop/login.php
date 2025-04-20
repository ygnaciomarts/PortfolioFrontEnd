<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $username = $password = $nombre = $su = "";
    $username_err = $password_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Por favor, introduce un usuario.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Por favor, introduce una contraseña.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, usuario, password, nombre, su FROM usuarios WHERE usuario = ?";
            
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
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $nombre, $su);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;   
                                $_SESSION["nombre"] = $nombre;      
                                $_SESSION["su"] = $su;                        
                                
                                // Redirect user to welcome page
                                header("location: index.php");
                            } else{
                                // Display an error message if password is not valid
                                $password_err = "La contraseña ingresada es incorrecta. Por favor, vuelve a intentarlo.";
                            }
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $username_err = "No se encontró la cuenta. Por favor, vuelve a intentarlo.";
                    }
                } else{
                    echo "Algo salió mal. Por favor, vuelve a intentarlo.";
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
        <!--style>
            ::-webkit-scrollbar {
                display: none;
            }

            html,
            body {
                height: 100%;
                overflow: hidden
            }
        </style-->

        <style>
            ::-webkit-scrollbar {
                display: none;
            }
        </style>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Iniciar sesión | BandUp</title>

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
    <div class="logo-responsivoAlt">
        <div class="usuario">
            <nav>
                <label class="lupa-carrito" for="menu-toggle">
                    <div class="botonMenu resplandorBlanco">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </label>
                <input type="checkbox" id="menu-toggle" />
                    <ul id="trickMenu">
                        <li><a href="https://bandup.monkeydevs.mx">INICIO</a></li>
                        <li><a href="https://bandup.monkeydevs.mx/quienes-somos">QUIÉNES SOMOS</a></li>
                        <li><a href="#">CATÁLOGO</a></li>
                        <li><a href="https://bandup.monkeydevs.mx/contacto">CONTACTO</a></li>
                        <br>
                        <li>
                            <label class="" for="menu-toggle3">
                                <a>DEPARTAMENTOS</a>
                            <input type="checkbox" id="menu-toggle3" style="display:none;" />
                                    <ul id="trickMenu3">
                                        <li><a href="https://bandup.monkeydevs.mx">CD</a></li>
                                        <li><a href="https://bandup.monkeydevs.mx/quienes-somos">LP</a></li>
                                        <li><a href="#">Cassette</a></li>
                                        <li><a href="https://bandup.monkeydevs.mx/contacto">Boxset</a></li>
                                    </ul>
                        </li>
                        <li><a href="#top-sellers">TOP SELLERS</a></li>
                        <li><a href="#novedades">NOVEDADES</a></li>
                        <li><a href="#preventas">PREVENTAS</a></li>
                        <li><a href="#">OFERTAS</a></li>
                    </ul>
                </ul>
            </nav>
        </div>
        
        <div class="logo-principal">
            <a href="https://bandup.monkeydevs.mx">
                <img class="resplandorBlanco" src="/bandupshop/img/BandUp.svg" width="150">
            </a>
        </div>

        <div class="carrito lupa-carrito resplandorBlanco">
            <a href="/<?php echo htmlspecialchars($str_link); ?>">
                <svg viewBox="0 0 20 20" width="30" height="30" xmlns="http://www.w3.org/2000/svg" class="rhf-icon-user">
                    <path d="M9.773.813c4.971 0 9 3.827 9 8.55 0 4.722-4.029 8.55-9 8.55-4.97 0-9-3.828-9-8.55 0-4.723 4.03-8.55 9-8.55zm.787 11.257H8.975c-1.964.004-3.554 1.515-3.558 3.38h0v.388l-.03-.018a8.311 8.311 0 004.385 1.236 8.27 8.27 0 004.345-1.212h0v-.394c-.003-1.865-1.594-3.376-3.557-3.38h0zM9.778 1.668h-.022c-4.47 0-8.094 3.442-8.094 7.689 0 2.348 1.108 4.451 2.868 5.86.14-2.219 2.076-3.977 4.445-3.98h1.584c2.37.003 4.305 1.762 4.457 3.982 1.747-1.41 2.856-3.514 2.856-5.862 0-4.247-3.623-7.69-8.094-7.69h0zm-.005 1.71c1.989 0 3.6 1.53 3.6 3.42 0 1.889-1.611 3.42-3.6 3.42-1.988 0-3.6-1.531-3.6-3.42 0-1.89 1.612-3.42 3.6-3.42zm0 .855c-1.49.003-2.696 1.15-2.7 2.565 0 1.416 1.21 2.565 2.7 2.565 1.491 0 2.7-1.149 2.7-2.565 0-1.417-1.209-2.565-2.7-2.565h0z" fill="#282d35" fill-rule="nonzero" stroke="#282d35" stroke-width=".25"> 
                    </path>
                </svg>
            </a>
        </div>
    </div>

        <div id="logoAlt" class="logo-alt">
            <a href="https://bandup.monkeydevs.mx">
                <img class="resplandorBlancoA" src="/bandupshop/img/BandUp.svg" width="100">
            </a>
            <nav class="nav-alt">
                <ul class="menu-alt resplandorBlancoA" style="padding-left: 20px;">
                    <li><a href="https://bandup.monkeydevs.mx/">INICIO</a></li>
                    <li><a href="/quienessomos.html">QUIÉNES SOMOS</a></li>
                    <li><a href="#">CATÁLOGO</a></li>
                    <li><a href="/contacto.html">CONTACTO</a></li>
                </ul>
            </nav>
        </div>

        <div class="contenedor-login">
        <div class="contenedor-registro sombraOpacidad cr-login">
            <a class="titulos-body alt">Iniciar sesión</a>
            <br>
            <form class="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C12.1,13 13.66,13.23 15.11,13.69C14.5,14.07 14,14.6 13.61,15.23C12.79,15.03 11.89,14.9 11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H13.04C13.13,18.8 13.38,19.44 13.76,20H3V17C3,14.34 8.33,13 11,13M18.5,10H20L22,10V12H20V17.5A2.5,2.5 0 0,1 17.5,20A2.5,2.5 0 0,1 15,17.5A2.5,2.5 0 0,1 17.5,15C17.86,15 18.19,15.07 18.5,15.21V10Z" />
                    </svg>
                    <input class="sesion" name="username" type="text" placeholder="Nombre de usuario"
                        pattern="[A-Za-z0-9]{6,15}" value="<?php echo $username; ?>" />
                    <div class="campo-ayuda">
                        <?php echo $username_err; ?>
        </div>
                </div>
                <br>
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                    </svg>
                    <input name="password" type="password" placeholder="Contraseña" minlength="8" />
                    <br>
                    <div class="campo-ayuda">
                        <?php echo $password_err; ?>
                    </div>
                </div>
                <br><br>
                <div class="center">
                    <button type="submit" class="registro" name="enviar">Ingresar</button>
                </div>
                <div class="center">
                    <p><a class="link" href="resetPassword">Olvidé mi contraseña</a></p>
                </div>
                <br>
                <div class="center">
                    <p class="login-text">¿No tienes una cuenta en BandUp? <a class="link" href="register.php">Regístrate ahora</a>.</p>
        </div>
            </form>
            <div class="footerLogin">
        <p> © 2022 BandUp.com | Todos los derechos reservados | <a href="/aviso-de-privacidad">Aviso de Privacidad</a></p>
        </div>
        </div>



        </div>
        <div class="img-registro res menor">
            <img class="side res" src="/bandupshop/img/side-registro-<?php echo rand(1, 9); ?>.png" alt="Registro" />
        </div>

        <div class="noRes contenedor-registro cr-login">
            <a id="titulos" class="titulos-body alt">Iniciar sesión</a>
            <br>
            <form class="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C12.1,13 13.66,13.23 15.11,13.69C14.5,14.07 14,14.6 13.61,15.23C12.79,15.03 11.89,14.9 11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H13.04C13.13,18.8 13.38,19.44 13.76,20H3V17C3,14.34 8.33,13 11,13M18.5,10H20L22,10V12H20V17.5A2.5,2.5 0 0,1 17.5,20A2.5,2.5 0 0,1 15,17.5A2.5,2.5 0 0,1 17.5,15C17.86,15 18.19,15.07 18.5,15.21V10Z" />
                    </svg>
                    <input class="sesion" name="username" type="text" placeholder="Nombre de usuario"
                        pattern="[A-Za-z0-9]{6,15}" value="<?php echo $username; ?>" />
                    <div class="campo-ayuda">
                        <?php echo $username_err; ?>
        </div>
                </div>
                <br>
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                    </svg>
                    <input name="password" type="password" placeholder="Contraseña" minlength="8" />
                    <br>
                    <div class="campo-ayuda">
                        <?php echo $password_err; ?>
                    </div>
                </div>
                <br><br>
                <div class="center">
                    <button type="submit" class="registro" name="enviar">Ingresar</button>
                </div>
                <div class="center">
                    <p><a class="link" href="resetPassword">Olvidé mi contraseña</a></p>
                </div>
                <br>
                <p>¿No tienes una cuenta en BandUp? <a class="link" href="register.php">Regístrate ahora</a>.</p>
            </form>
        </div>

        <div class="img-registro noRes">
            <img class="side noRes" src="/bandupshop/img/side-registro-<?php echo rand(1, 13); ?>.png" alt="Registro" />
        </div>
    </body>
    <script lenguage="javascript">    
        var nav = document.getElementById('logoAlt');
        var titulos = document.getElementById('titulos');
        load();
    
        function load () {
            const darkmode = localStorage.getItem('dark');
    
            if(!darkmode){
                store('false');
            } else if(darkmode == 'true'){
                document.body.classList.toggle('dark');
                titulos.classList.toggle('dark');
                nav.classList.toggle('dark');
                
            }
        }
    
        function store(value) {
            localStorage.setItem('dark', value);    
        }
    </script>
</html>