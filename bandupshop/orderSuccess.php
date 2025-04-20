<?php
    include 'config.php';

    if(!isset($_REQUEST['id'])){
        header("Location: index.php");
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
        <title>Orden recibida | BandUp</title>

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
                <svg viewBox="0 0 20 20" width="30" height="30" xmlns="http://www.w3.org/2000/svg" class="rhf-icon-user">
                    <path d="M9.773.813c4.971 0 9 3.827 9 8.55 0 4.722-4.029 8.55-9 8.55-4.97 0-9-3.828-9-8.55 0-4.723 4.03-8.55 9-8.55zm.787 11.257H8.975c-1.964.004-3.554 1.515-3.558 3.38h0v.388l-.03-.018a8.311 8.311 0 004.385 1.236 8.27 8.27 0 004.345-1.212h0v-.394c-.003-1.865-1.594-3.376-3.557-3.38h0zM9.778 1.668h-.022c-4.47 0-8.094 3.442-8.094 7.689 0 2.348 1.108 4.451 2.868 5.86.14-2.219 2.076-3.977 4.445-3.98h1.584c2.37.003 4.305 1.762 4.457 3.982 1.747-1.41 2.856-3.514 2.856-5.862 0-4.247-3.623-7.69-8.094-7.69h0zm-.005 1.71c1.989 0 3.6 1.53 3.6 3.42 0 1.889-1.611 3.42-3.6 3.42-1.988 0-3.6-1.531-3.6-3.42 0-1.89 1.612-3.42 3.6-3.42zm0 .855c-1.49.003-2.696 1.15-2.7 2.565 0 1.416 1.21 2.565 2.7 2.565 1.491 0 2.7-1.149 2.7-2.565 0-1.417-1.209-2.565-2.7-2.565h0z" fill="#282d35" fill-rule="nonzero" stroke="#282d35" stroke-width=".25"> 
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
        <a id="titulos" class="titulos-body alt">Estatus de la orden</a><br>
            <form name='pdf' method='post' action='fpdf/receiptGen.php?id=<?php echo $_GET['id']; ?>&userID=<?php echo $_GET['userID']; ?>'>
        <?php if(!empty($_GET['userID'])){
                $query = $link->query("SELECT * FROM usuarios WHERE id = ".$_GET['userID']);

                while($row = $query->fetch_assoc()) {
                    $nombre = $row['nombre'];
                    $apellido = $row['apellido'];
                    $direccion = $row['direccion'];
                    $email = $row['email'];
                    $telefono = $row['telefono'];
                ?>
                <div class="order">
        <a>Estimado <b><?php echo $nombre." ".$apellido; ?></b>, </a><br><br>
        <a>¡Gracias por comprar en <b>BandUp</b>!</a><br>
        <a>Su orden acaba de ser procesada exitosamente.</a><br><br>
        <a>En un lapso no mayor a 24 horas estará recibiendo su número de paquetería para la recepción de su(s) producto(s).</a><br><br>
        <a>El ID de su orden es el <b>#<?php echo $_GET['id']; ?></b>.</a><br><br>
        <button class="shBtn order shipBtn">Ver recibo generado</button><br><br><br><br>
        <a>"La música es curativa. Escriba eso primero."</a>
        <br><br>
        <?php
        }}?>
        </div>
    </form>
            <div class="footerLogin">
        <p> © 2022 BandUp.com | Todos los derechos reservados | <a href="/aviso-de-privacidad">Aviso de Privacidad</a></p>
        </div>
        </div>



        </div>
        <div class="img-registro res menor">
            <img class="side res" src="/img/alt/side-registro-<?php echo rand(1, 9); ?>.png" alt="Registro" />
        </div>

        <div class="noRes contenedor-registro cr-login">
            <br>
            <a id="titulos" class="titulos-body alt">Estatus de la orden</a><br>
            <form name='pdf' method='post' action='fpdf/receiptGen.php?id=<?php echo $_GET['id']; ?>&userID=<?php echo $_GET['userID']; ?>'>
        <?php if(!empty($_GET['userID'])){
                $query = $link->query("SELECT * FROM usuarios WHERE id = ".$_GET['userID']);

                while($row = $query->fetch_assoc()) {
                    $nombre = $row['nombre'];
                    $apellido = $row['apellido'];
                    $direccion = $row['direccion'];
                    $email = $row['email'];
                    $telefono = $row['telefono'];
                ?>
                <div class="order">
        <a>Estimado <b><?php echo $nombre." ".$apellido; ?></b>, </a><br><br>
        <a>¡Gracias por comprar en <b>BandUp</b>!</a><br>
        <a>Su orden acaba de ser procesada exitosamente.</a><br><br>
        <a>En un lapso no mayor a 24 horas estará recibiendo su número de paquetería para la recepción de su(s) producto(s).</a><br><br>
        <a>El ID de su orden es el <b>#<?php echo $_GET['id']; ?></b>.</a><br><br>
        <button class="successBtn shipBtn">Ver recibo generado</button><br><br><br><br>
        <a>"La música es curativa. Escriba eso primero."</a>
        <?php
        }}?>
        </div>
    </form>
        </div>

        <div class="img-registro noRes">
            <img class="side noRes" src="side-registro-<?php echo rand(1, 13); ?>.png" alt="Registro" />
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