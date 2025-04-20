<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $nombre = $apellido = $style_err = "";
$username_err = $password_err = $email_err = $confirm_password_err = $nombre_err = $apellido_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $style_err2 = "error";
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Por favor, ingresa un nombre de usuario.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM usuarios WHERE usuario = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este nombre de usuario ya está en uso.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Al parecer, algo salió mal.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    if(empty(trim($_POST["email"]))) {
        $email_err = "Por favor, ingresa un correo electrónico.";
    } else {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Este correo electrónico ya está registrado.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Al parecer, algo salió mal.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, ingresa una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "La contraseña debe contener por lo menos 8 carácteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirma la contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }

    // Validate password
    if(empty(trim($_POST["nombre"]))){
        $nombre_err = "Por favor, ingresa un nombre.";     
    } elseif(strlen(trim($_POST["password"])) > 18){
        $nombre_err = "El nombre no debe superar los 18 carácteres.";
    } else{
        $nombre = trim($_POST["nombre"]);
    }

    // Validate password
    if(empty(trim($_POST["apellido"]))){
        $apellido_err = "Por favor ingresa un apellido.";     
    } elseif(strlen(trim($_POST["apellido"])) > 18){
        $apellido_err = "El apellido no debe superar los 18 carácteres.";
    } else{
        $apellido = trim($_POST["apellido"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($nombre_err) && empty($apellido_err)){
        $style_err2 = "";

        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (usuario, password, nombre, apellido, email, creado, modificado) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_password, $param_nombre, $param_apellido, $param_email, $param_creado, $param_modificado);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_nombre = $nombre;
            $param_apellido = $apellido;
            $param_creado = date("Y-m-d H:i:s");
            $param_modificado = date("Y-m-d H:i:s");
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Algo salió mal. Por favor, inténtalo de nuevo.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $style_err = "msg";
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
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Regístrate | BandUp</title>

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
                <img class="resplandorBlanco" src="/img/BandUp.svg" width="150">
            </a>
        </div>

        <div class="carrito lupa-carrito resplandorBlanco">
            <a href="/<?php echo htmlspecialchars($str_link); ?>">
                <svg viewBox="0 0 20 20" width="30" height="30" xmlns="http://www.w3.org/2000/svg"
                    class="rhf-icon-user">
                    <path
                        d="M9.773.813c4.971 0 9 3.827 9 8.55 0 4.722-4.029 8.55-9 8.55-4.97 0-9-3.828-9-8.55 0-4.723 4.03-8.55 9-8.55zm.787 11.257H8.975c-1.964.004-3.554 1.515-3.558 3.38h0v.388l-.03-.018a8.311 8.311 0 004.385 1.236 8.27 8.27 0 004.345-1.212h0v-.394c-.003-1.865-1.594-3.376-3.557-3.38h0zM9.778 1.668h-.022c-4.47 0-8.094 3.442-8.094 7.689 0 2.348 1.108 4.451 2.868 5.86.14-2.219 2.076-3.977 4.445-3.98h1.584c2.37.003 4.305 1.762 4.457 3.982 1.747-1.41 2.856-3.514 2.856-5.862 0-4.247-3.623-7.69-8.094-7.69h0zm-.005 1.71c1.989 0 3.6 1.53 3.6 3.42 0 1.889-1.611 3.42-3.6 3.42-1.988 0-3.6-1.531-3.6-3.42 0-1.89 1.612-3.42 3.6-3.42zm0 .855c-1.49.003-2.696 1.15-2.7 2.565 0 1.416 1.21 2.565 2.7 2.565 1.491 0 2.7-1.149 2.7-2.565 0-1.417-1.209-2.565-2.7-2.565h0z"
                        fill="#282d35" fill-rule="nonzero" stroke="#282d35" stroke-width=".25">
                    </path>
                </svg>
            </a>
        </div>
    </div>

    <div id="logoAlt" class="logo-alt">
        <a href="https://bandup.monkeydevs.mx">
            <img class="resplandorBlancoA" src="/img/BandUp.svg" width="100">
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
            <a class="titulos-body alt">Regístrate</a>
            <form class="formulario" id="form1" name="signup-form" method="post"
                action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>">
                <div class="varios">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M14 20H4V17C4 14.3 9.3 13 12 13C13.5 13 15.9 13.4 17.7 14.3C16.9 14.6 16.3 15 15.7 15.5C14.6 15.1 13.3 14.9 12 14.9C9 14.9 5.9 16.4 5.9 17V18.1H14.2C14.1 18.5 14 19 14 19.5V20M23 19.5C23 21.4 21.4 23 19.5 23S16 21.4 16 19.5 17.6 16 19.5 16 23 17.6 23 19.5M12 6C13.1 6 14 6.9 14 8S13.1 10 12 10 10 9.1 10 8 10.9 6 12 6M12 4C9.8 4 8 5.8 8 8S9.8 12 12 12 16 10.2 16 8 14.2 4 12 4Z" />
                    </svg>
                    <input id="nombre" name="nombre" value="<?php echo $nombre; ?>" type="text" placeholder="Nombre">
                    <input name="apellido" value="<?php echo $apellido; ?>" type="text" placeholder="Apellido" />
                    <div class="campo-ayuda reg">
                        <?php echo $nombre_err; ?>
                    </div>
                </div>
                <div class="solo">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C12.1,13 13.66,13.23 15.11,13.69C14.5,14.07 14,14.6 13.61,15.23C12.79,15.03 11.89,14.9 11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H13.04C13.13,18.8 13.38,19.44 13.76,20H3V17C3,14.34 8.33,13 11,13M18.5,10H20L22,10V12H20V17.5A2.5,2.5 0 0,1 17.5,20A2.5,2.5 0 0,1 15,17.5A2.5,2.5 0 0,1 17.5,15C17.86,15 18.19,15.07 18.5,15.21V10Z" />
                    </svg>
                    <input id="username" name="username" value="<?php echo $username; ?>" type="text"
                        placeholder="Nombre de usuario" title="" />
                    <div class="campo-ayuda reg">
                        <?php echo $username_err; ?>
                    </div>
                </div>
                <div class="solo">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" />
                    </svg>
                    <input id="email" name="email" value="<?php echo $email; ?>" type="text"
                        placeholder="Correo electronico" />
                    <div class="campo-ayuda reg">
                        <?php echo $email_err; ?>
                    </div>
                </div>
                <div class="varios">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                    </svg>
                    <input id="password" name="password" type="password" placeholder="Contraseña"
                        value="<?php echo $password; ?>" minlength="8" title="At least 1 Uppercase
At least 1 Lowercase
At least 1 Number
At least 1 Symbol, symbol allowed --> !@#$%^&*_=+-
Min 8 chars and Max 12 chars" />
                    <input name="confirm_password" value="<?php echo $confirm_password; ?>" type="password"
                        placeholder="Confirmar contraseña" />
                    <div class="campo-ayuda reg">
                        <?php echo $password_err; ?>
                    </div>
                </div>
                <div class="center">
                    <input type="checkbox" class="padding" value="1" name="terminos" checked required /><label
                        class="terminos" for="terminos">He leído y acepto los <a class="link"
                            href="terminos-y-condiciones">términos y condiciones</a> y el <a class="link"
                            href="aviso-de-privacidad">aviso de privacidad</a>.</label>
                </div>
                <div class="center">
                    <button onclick="validarCorreo(document.getElementById('email').value)
                                    validarUsuario(document.getElementById('username').value)
                                    validarContra(document.getElementById('password').value)" type="submit"
                        class="registro" name="enviar">Crear una cuenta</button>
                </div>
                <br>
                <p class="login-text">¿Ya tienes una cuenta en BandUp? <a class="link" href="login.php">Inicia
                        sesión</a>.</p>
            </form>
            <div class="footerLogin">
                <p> © 2022 BandUp.com | Todos los derechos reservados | <a href="/aviso-de-privacidad">Aviso de
                        Privacidad</a></p>
            </div>
        </div>



    </div>
    <div class="img-registro res">
        <img class="side res <?php echo htmlspecialchars($style_err2); ?>"
            src="/img/side-registro-<?php echo rand(1, 9); ?>.png" alt="Registro" />
    </div>


    <div class="noRes contenedor-registro <?php echo $style_err; ?>">
        <a id="titulos" class="titulos-body alt">Regístrate</a>
        <form class="formulario" id="form1" name="signup-form" method="post"
            action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>">
            <div class="varios">
                <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M14 20H4V17C4 14.3 9.3 13 12 13C13.5 13 15.9 13.4 17.7 14.3C16.9 14.6 16.3 15 15.7 15.5C14.6 15.1 13.3 14.9 12 14.9C9 14.9 5.9 16.4 5.9 17V18.1H14.2C14.1 18.5 14 19 14 19.5V20M23 19.5C23 21.4 21.4 23 19.5 23S16 21.4 16 19.5 17.6 16 19.5 16 23 17.6 23 19.5M12 6C13.1 6 14 6.9 14 8S13.1 10 12 10 10 9.1 10 8 10.9 6 12 6M12 4C9.8 4 8 5.8 8 8S9.8 12 12 12 16 10.2 16 8 14.2 4 12 4Z" />
                </svg>
                <input id="nombre" name="nombre" value="<?php echo $nombre; ?>" type="text" placeholder="Nombre">
                <input name="apellido" value="<?php echo $apellido; ?>" type="text" placeholder="Apellido" />
                <div class="campo-ayuda reg">
                    <?php echo $nombre_err; ?>
                </div>
            </div>
            <div class="">
                <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C12.1,13 13.66,13.23 15.11,13.69C14.5,14.07 14,14.6 13.61,15.23C12.79,15.03 11.89,14.9 11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H13.04C13.13,18.8 13.38,19.44 13.76,20H3V17C3,14.34 8.33,13 11,13M18.5,10H20L22,10V12H20V17.5A2.5,2.5 0 0,1 17.5,20A2.5,2.5 0 0,1 15,17.5A2.5,2.5 0 0,1 17.5,15C17.86,15 18.19,15.07 18.5,15.21V10Z" />
                </svg>
                <input id="username" name="username" value="<?php echo $username; ?>" type="text"
                    placeholder="Nombre de usuario" title="" />
                <div class="campo-ayuda reg">
                    <?php echo $username_err; ?>
                </div>
            </div>
            <div class="">
                <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" />
                </svg>
                <input id="email" name="email" value="<?php echo $email; ?>" type="email"
                    placeholder="Correo electronico" />
                <div class="campo-ayuda reg">
                    <?php echo $email_err; ?>
                </div>
            </div>
            <div class="varios">
                <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                </svg>
                <input id="password" name="password" type="password" placeholder="Contraseña"
                    value="<?php echo $password; ?>" minlength="8" title="At least 1 Uppercase
At least 1 Lowercase
At least 1 Number
At least 1 Symbol, symbol allowed --> !@#$%^&*_=+-
Min 8 chars and Max 12 chars" />
                <input name="confirm_password" value="<?php echo $confirm_password; ?>" type="password"
                    placeholder="Confirmar contraseña" />
                <div class="campo-ayuda reg">
                    <?php echo $password_err; ?>
                </div>
            </div>
            <br>
            <div class="center">
                <input type="checkbox" class="padding" value="1" name="terminos" checked required /><label
                    class="terminos" for="terminos">He leído y acepto los <a class="link"
                        href="terminos-y-condiciones">términos y condiciones</a> y el <a class="link"
                        href="aviso-de-privacidad">aviso de privacidad</a>.</label>
            </div>
            <div class="center">
                <button onclick="validarCorreo(document.getElementById('email').value)
                                    validarUsuario(document.getElementById('username').value)
                                    validarContra(document.getElementById('password').value)" type="submit"
                    class="registro" name="enviar">Crear una cuenta</button>
            </div>
            <br>
            <p>¿Ya tienes una cuenta en BandUp? <a class="link" href="login.php">Inicia sesión</a>.</p>
        </form>
    </div>

    <div class="img-registro noRes">
        <img src="/img/side-registro-<?php echo rand(1, 13); ?>.png" alt="Registro" width="700px" />
    </div>
</body>

<script lenguage="javascript">
    function validarUsuario(username) {
        var usernameC = /^[A-Za-z][A-Za-z0-9_]{7,29}$/;
        var pasa = usernameC.test(username);
        if (pasa == true) {
            return true;
        }
        if (pasa == false) {
            alert('Usuario no valido');
            return false;
        }
    }

    function validarCorreo(correo) {
        var correoC = /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/;
        var pasa = correoC.test(correo);
        if (pasa == true) {
            return true;
        }
        else {
            return false;
        }
    }

    function validarContra(pass) {
        var passC = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,20}$/;
        var pasa = passC.test(pass);
        if (pasa == true) {
            return true;
        }
        if (pasa == false) {
            alert('Contraseña no valida');
            return false;
        }
    }
</script>
<script lenguage="javascript">
    var nav = document.getElementById('logoAlt');
    var titulos = document.getElementById('titulos');
    load();

    function load() {
        const darkmode = localStorage.getItem('dark');

        if (!darkmode) {
            store('false');
        } else if (darkmode == 'true') {
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