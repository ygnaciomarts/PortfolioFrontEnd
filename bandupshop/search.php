<?php
    //session_start();

    include 'config.php';
    include 'cart.php';
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $str_bienvenida = "Iniciar sesión";
        $str_link = "login";
    } else {
        $str_bienvenida = $_SESSION["nombre"];
        $str_link = "my-account";
    }

    $nombre = $artista = $descStyle = $descStyleD = "";

    if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
        if($_REQUEST['action'] == 'ver' && !empty($_REQUEST['id'])){
            $id = $_REQUEST['id'];

            $query = $link->query("SELECT * FROM productos WHERE id = ".$id);
            $row = $query->fetch_assoc();

            if($row === null) {
                header("Location: 404.html");
            }
            
            $nombre = $row['nombre'];
            $artista = $row['artista'];
            $cover = base64_encode($row['img']);
            $precioV = $row['precioV'];
            $precioD = $row['precioD'];
            $descuento = "0.00";

            if($precioD === $descuento) {
                $precio = $row['precioV'];
                $descStyle = "rebaja";
            } else {
                $precio = $row['precioD'];
                $descStyleD = "precioD";
            }

            $descripcion = $row['descripcion'];
            $tracklist = $row['tracklist'];
        } else {
            header("Location: 404.html");
        }
    } else {
        header("Location: 404.html");
    }

?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title><?php echo str_replace("`", "'", $nombre) ?> por <?php echo $artista ?> | BandUp</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Montserrat:wght@700&display=swap"
        rel="stylesheet">
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/styles.css" as="style" rel="preload">
    <link href="css/styles.css" rel="stylesheet">

</head>

<body>
    <div class="slider-superior">
        <div class="slider-superior-movimiento">
            <div class="ofertas">
                <a href="#">ENVÍO GRATIS EN ÓRDENES CON VALOR IGUAL O MAYOR A $799</a>
            </div>
            <div class="ofertas">
                <a href="#">20% DE DESCUENTO EN TODA LA COLECCIÓN "CAMBIOS DE LUNA"</a>
            </div>
            <div class="ofertas">
                <a href="#">SUSCRÍBETE AL NEWSLETTER Y LLÉVATE UN 10% DE DESCUENTO</a>
            </div>
            <div class="ofertas">
                <a href="#">POR TIEMPO LIMITADO: ARTÍCULOS DE PREVENTA EN OFERTA</a>
            </div>
        </div>
    </div>

    <div class="logo-responsivo">
        <!--div class="usuario">
            <svg viewBox="0 0 20 20" width="30" height="30" xmlns="http://www.w3.org/2000/svg" class="rhf-icon-user">
                <a href="/login.html">
                    <path d="M9.773.813c4.971 0 9 3.827 9 8.55 0 4.722-4.029 8.55-9 8.55-4.97 0-9-3.828-9-8.55 0-4.723 4.03-8.55 9-8.55zm.787 11.257H8.975c-1.964.004-3.554 1.515-3.558 3.38h0v.388l-.03-.018a8.311 8.311 0 004.385 1.236 8.27 8.27 0 004.345-1.212h0v-.394c-.003-1.865-1.594-3.376-3.557-3.38h0zM9.778 1.668h-.022c-4.47 0-8.094 3.442-8.094 7.689 0 2.348 1.108 4.451 2.868 5.86.14-2.219 2.076-3.977 4.445-3.98h1.584c2.37.003 4.305 1.762 4.457 3.982 1.747-1.41 2.856-3.514 2.856-5.862 0-4.247-3.623-7.69-8.094-7.69h0zm-.005 1.71c1.989 0 3.6 1.53 3.6 3.42 0 1.889-1.611 3.42-3.6 3.42-1.988 0-3.6-1.531-3.6-3.42 0-1.89 1.612-3.42 3.6-3.42zm0 .855c-1.49.003-2.696 1.15-2.7 2.565 0 1.416 1.21 2.565 2.7 2.565 1.491 0 2.7-1.149 2.7-2.565 0-1.417-1.209-2.565-2.7-2.565h0z" fill="#282d35" fill-rule="nonzero" stroke="#282d35" stroke-width=".25"> 
                    </path>
                </a>
            </svg>
        </div-->
        <div class="usuario">
        <nav>
            <label class="lupa-carrito" for="menu-toggle">
                <div class="botonMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </label>
            <input type="checkbox" id="menu-toggle" />
                <ul id="trickMenu">
                    <li><a href="https://bandup.monkeydevs.mx">INICIO</a></li>
                    <li><a href="/quienes-somos">QUIÉNES SOMOS</a></li>
                    <li><a href="#">CATÁLOGO</a></li>
                    <li><a href="/contacto">CONTACTO</a></li>
                    <br>
                    <li><a href="#">DEPARTAMENTOS</a></li>
                    <li><a href="#">TOP SELLERS</a></li>
                    <li><a href="#">NOVEDADES</a></li>
                    <li><a href="#">PREVENTAS</a></li>
                    <li><a href="#">OFERTAS</a></li>
                </ul>
            </ul>
        </nav>
        <a href="/login.php">
            <svg viewBox="0 0 20 20" width="30" height="30" xmlns="http://www.w3.org/2000/svg" class="rhf-icon-user">
                <path d="M9.773.813c4.971 0 9 3.827 9 8.55 0 4.722-4.029 8.55-9 8.55-4.97 0-9-3.828-9-8.55 0-4.723 4.03-8.55 9-8.55zm.787 11.257H8.975c-1.964.004-3.554 1.515-3.558 3.38h0v.388l-.03-.018a8.311 8.311 0 004.385 1.236 8.27 8.27 0 004.345-1.212h0v-.394c-.003-1.865-1.594-3.376-3.557-3.38h0zM9.778 1.668h-.022c-4.47 0-8.094 3.442-8.094 7.689 0 2.348 1.108 4.451 2.868 5.86.14-2.219 2.076-3.977 4.445-3.98h1.584c2.37.003 4.305 1.762 4.457 3.982 1.747-1.41 2.856-3.514 2.856-5.862 0-4.247-3.623-7.69-8.094-7.69h0zm-.005 1.71c1.989 0 3.6 1.53 3.6 3.42 0 1.889-1.611 3.42-3.6 3.42-1.988 0-3.6-1.531-3.6-3.42 0-1.89 1.612-3.42 3.6-3.42zm0 .855c-1.49.003-2.696 1.15-2.7 2.565 0 1.416 1.21 2.565 2.7 2.565 1.491 0 2.7-1.149 2.7-2.565 0-1.417-1.209-2.565-2.7-2.565h0z" fill="#282d35" fill-rule="nonzero" stroke="#282d35" stroke-width=".25"> 
                </path>
            </svg>
        </a></div>
        
        <div class="logo-principal">
            <a href="https://bandup.monkeydevs.mx">
                <img src="/img/BandUp.svg" width="160">
            </a>
        </div>
        <div class="carrito lupa-carrito">
        <a href="/busqueda.php">
        <svg width="50" height="43" viewBox="-10 -9 44 38" preserveAspectRatio="none"
                        xmlns="http://www.w3.org/2000/svg" alt="search" class="brand">
                        <path
                            d="M7.886 13.54c3.266 0 5.914-2.54 5.914-5.672 0-3.134-2.648-5.673-5.914-5.673-3.266 0-5.914 2.54-5.914 5.673.007 3.13 2.65 5.665 5.913 5.672h.001zM0 7.867v-.011C0 3.679 3.53.29 7.886.29c4.355 0 7.885 3.388 7.885 7.565a7.34 7.34 0 01-1.668 4.654l6.584 6.287a.923.923 0 01.313.692c0 .522-.441.945-.986.945-.283 0-.54-.115-.72-.3l-6.572-6.305a8.047 8.047 0 01-4.836 1.59C3.535 15.42.007 12.04 0 7.868v-.001z"
                            fill="#282d35" fill-rule="evenodd">
                        </path>
        </svg>
</a>
            <a href="viewCart.php">
                <span>
                    <?php 
                        $cart = new Cart;
                        echo $cart->total_items() 
                    ?>
                </span>
                <svg class="carrito" width="27" height="32" xmlns="http://www.w3.org/2000/svg" alt="cart" class="brand">
                    <path d="M23.097 18.988l-.165.783H7.77L5.75 8.862H25.25l-2.154 10.126zm-14.89 7.955c.934 0 1.692.713 1.692 1.591s-.758 1.59-1.693 1.59c-.933 0-1.691-.712-1.691-1.59 0-.878.758-1.591 1.691-1.591zm13.014 0c.934 0 1.691.713 1.691 1.591s-.757 1.59-1.691 1.59-1.692-.712-1.692-1.59c0-.872.746-1.58 1.672-1.591h.02zm5.802-19.454H5.5L4.241.689a.714.714 0 00-.713-.564H.471v1.363h2.447l4.476 24.21c-1.338.358-2.303 1.496-2.303 2.847 0 1.631 1.407 2.955 3.142 2.955 1.736 0 3.142-1.324 3.142-2.954 0-.595-.187-1.15-.508-1.613l7.695.01c-.308.449-.49.996-.49 1.583 0 1.627 1.401 2.946 3.132 2.946 1.73 0 3.133-1.32 3.133-2.946 0-1.627-1.403-2.945-3.133-2.945H8.844l-.822-4.446H24.15l.397-1.918.356-1.727.234-1 1.886-9.001z" fill="#282d35" fill-rule="evenodd">
                    </path>
                </svg>
            </a>
        </div>
    </div>

    <nav class="nav">
        <ul class="menu">
            <li><a href="https://bandup.monkeydevs.mx/">INICIO</a></li>
            <li><a href="/quienes-somos">QUIÉNES SOMOS</a></li>
            <li><a href="#">CATÁLOGO</a></li>
            <li><a href="/contacto">CONTACTO</a></li>
        </ul>
    </nav>
    <nav class="nav-reg">
        <ul class="menu">
            <li class="mayus"><a href="/bandup/<?php echo htmlspecialchars($str_link); ?>" style="text-transform: uppercase;">
                <svg class="usuario-reg" viewBox="0 0 20 20" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.773.813c4.971 0 9 3.827 9 8.55 0 4.722-4.029 8.55-9 8.55-4.97 0-9-3.828-9-8.55 0-4.723 4.03-8.55 9-8.55zm.787 11.257H8.975c-1.964.004-3.554 1.515-3.558 3.38h0v.388l-.03-.018a8.311 8.311 0 004.385 1.236 8.27 8.27 0 004.345-1.212h0v-.394c-.003-1.865-1.594-3.376-3.557-3.38h0zM9.778 1.668h-.022c-4.47 0-8.094 3.442-8.094 7.689 0 2.348 1.108 4.451 2.868 5.86.14-2.219 2.076-3.977 4.445-3.98h1.584c2.37.003 4.305 1.762 4.457 3.982 1.747-1.41 2.856-3.514 2.856-5.862 0-4.247-3.623-7.69-8.094-7.69h0zm-.005 1.71c1.989 0 3.6 1.53 3.6 3.42 0 1.889-1.611 3.42-3.6 3.42-1.988 0-3.6-1.531-3.6-3.42 0-1.89 1.612-3.42 3.6-3.42zm0 .855c-1.49.003-2.696 1.15-2.7 2.565 0 1.416 1.21 2.565 2.7 2.565 1.491 0 2.7-1.149 2.7-2.565 0-1.417-1.209-2.565-2.7-2.565h0z" fill="#282d35" fill-rule="nonzero" stroke="#282d35" stroke-width=".25"> 
                </path>
                </svg>
                <?php echo htmlspecialchars($str_bienvenida); ?></a></li>
            <li><a href="/wishlist.html">
            <svg class="wishlist-reg" viewBox="0 -2.5 20 20" width="20" height="20" xmlns="http://www.w3.org/2000/svg"><path d="M11 .143A4.654 4.654 0 007.85 1.618l-.135.153-.134-.153A4.647 4.647 0 004.214.138C1.863.138.04 1.889.04 4.188c0 .737.192 1.447.568 2.161.464.882 1.183 1.75 2.348 2.902l.257.25c.45.437 3.159 2.948 4.032 3.796l.47.456.703-.68c1.045-.998 3.384-3.169 3.8-3.571 1.318-1.278 2.108-2.208 2.605-3.153.376-.714.567-1.424.567-2.161 0-2.299-1.823-4.05-4.175-4.05l-.213.005zm.214 1.345c1.618 0 2.825 1.16 2.825 2.7 0 .507-.134 1.004-.412 1.533-.386.734-1.033 1.514-2.112 2.579l-.377.365-3.424 3.212-3.562-3.344C2.928 7.346 2.216 6.507 1.802 5.72c-.278-.529-.413-1.026-.413-1.533 0-1.54 1.208-2.7 2.825-2.7 1.242 0 2.455.782 2.874 1.826l.626 1.562.627-1.562c.419-1.044 1.63-1.826 2.873-1.826z" fill="#282d35" fill-rule="nonzero">
            </path></svg>
            WISHLIST</a></li>
        </ul>
    </nav>

    <div class="logo">
        <a href="https://bandup.monkeydevs.mx">
            <img src="/img/BandUp.svg" width="160">
        </a>
        <div class="search-wrapper">
            <form action="" method="post" target="_blank">
                <input class="search" name="busquedamusica" placeholder="Busca por título, artista o ISRC" />
                <button>
                    <svg width="50" height="43" viewBox="-10 -5 44 38" preserveAspectRatio="none"
                        xmlns="http://www.w3.org/2000/svg" alt="search" class="brand">
                        <path
                            d="M7.886 13.54c3.266 0 5.914-2.54 5.914-5.672 0-3.134-2.648-5.673-5.914-5.673-3.266 0-5.914 2.54-5.914 5.673.007 3.13 2.65 5.665 5.913 5.672h.001zM0 7.867v-.011C0 3.679 3.53.29 7.886.29c4.355 0 7.885 3.388 7.885 7.565a7.34 7.34 0 01-1.668 4.654l6.584 6.287a.923.923 0 01.313.692c0 .522-.441.945-.986.945-.283 0-.54-.115-.72-.3l-6.572-6.305a8.047 8.047 0 01-4.836 1.59C3.535 15.42.007 12.04 0 7.868v-.001z"
                            fill="#ffffff" fill-rule="evenodd">
                        </path>
                    </svg>
                </button>
            </form>
        </div>
        <div class="carrito">
            <a href="viewCart.php">
                <span>
                    <?php 
                        $cart = new Cart;
                        echo $cart->total_items() 
                    ?>
                </span>
                <svg class="carrito" width="27" height="32" xmlns="http://www.w3.org/2000/svg" alt="cart" class="brand">
                    <path d="M23.097 18.988l-.165.783H7.77L5.75 8.862H25.25l-2.154 10.126zm-14.89 7.955c.934 0 1.692.713 1.692 1.591s-.758 1.59-1.693 1.59c-.933 0-1.691-.712-1.691-1.59 0-.878.758-1.591 1.691-1.591zm13.014 0c.934 0 1.691.713 1.691 1.591s-.757 1.59-1.691 1.59-1.692-.712-1.692-1.59c0-.872.746-1.58 1.672-1.591h.02zm5.802-19.454H5.5L4.241.689a.714.714 0 00-.713-.564H.471v1.363h2.447l4.476 24.21c-1.338.358-2.303 1.496-2.303 2.847 0 1.631 1.407 2.955 3.142 2.955 1.736 0 3.142-1.324 3.142-2.954 0-.595-.187-1.15-.508-1.613l7.695.01c-.308.449-.49.996-.49 1.583 0 1.627 1.401 2.946 3.132 2.946 1.73 0 3.133-1.32 3.133-2.946 0-1.627-1.403-2.945-3.133-2.945H8.844l-.822-4.446H24.15l.397-1.918.356-1.727.234-1 1.886-9.001z" fill="#282d35" fill-rule="evenodd">
                    </path>
                </svg>
            </a>
        </div>
    </div>

    <nav class="nav-inf">
        <ul class="menu">
            <li><a href="#">DEPARTAMENTOS</a></li>
            <li><a href="#">TOP SELLERS</a></li>
            <li><a href="#">NOVEDADES</a></li>
            <li><a href="#">PREVENTAS</a></li>
            <li><a href="#">OFERTAS</a></li>
        </ul>
    </nav>

    <br>

    <main class="contenedor-producto sombra">
                <?php
                $query = $link->query("SELECT * FROM productos WHERE id = $id");
                if($query->num_rows > 0){ 
                    while($row = $query->fetch_assoc()) {
                ?>
                        <div class="img-producto">
                            <div class="alinear-derecha">
                            <?php echo '<img src="data:image/png;base64,'.$cover.'" class="img-portada" width="400" height="400"/>';?>
                    </div>

                            <div class="contenido-producto">
                                    <a class="titulos-producto"><?php echo str_replace("`", "'", $nombre)?></a>
                                    <a class="titulos-producto artista">por <?php echo $artista ?></a>
                                    <h2 class="titulos-producto precio">
                                        <span class="strikethrough <?php echo $descStyle ?>">
                                            <?php echo "MX$". $precioV ?>
                                        </span>
                                        <?php echo '<h2 class="titulos-producto precio precioV ' . $descStyleD . '">MX$'. $precio .'</h2>' ?>
                                    </a>
                                    <br><br>
                                    <div class="rs espacio">
                                    <select name="tipo">
                                        <option value="value1">CD</option>
                                        <option value="value2" selected>LP</option>
                                        <option value="value3">Cassette</option>
                                        </select><input name="cantidad" type="number" min="1" max="999" value="1" placeholder="Cantidad" value="<?php echo $existencias; ?>"/>
                                    <br><br></div>
                                    <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>">
                                    <button class="registro anadir-carrito">Añadir al carrito</button></a>
                                    <button class="registro anadir-carrito">Wishlist</button>
                                    <!--button class="registro anadir-carrito">
                                    ♥️
                    </button-->
                    
                                    <a class="titulos-producto descripcion rs"><?php echo str_replace("`", "'", $descripcion) ?></a>
                                    <a class="titulos-producto descripcion listadoE"><b>Listado de canciones:</b></a>
                                    <a class="titulos-producto descripcion listado"><?php 
                                        $original = array("`","\n");
                                        $reemplazo = array("'","<br>");
                                        echo str_replace($original, $reemplazo, $tracklist) 
                                    ?></a>
                                    </div>
                            </div>
                                <!--div class="contenido-producto">
                                    <a class="titulos-producto"><?php echo $nombre ?></a>
                                    <a class="titulos-producto artista">por <?php echo $artista ?></a>
                                    <h2 class="titulos-producto precio">
                                        <span class="strikethrough <?php echo $descStyle ?>">
                                            <?php echo "MX$". $precioV ?>
                                        </span>
                                        <?php echo '<h2 class="titulos-producto precio precioV ' . $descStyleD . '">MX$'. $precio .'</h2>' ?>
                                    </a>
                                    <br><br>
                                    <select name="tipo">
                                        <option value="value1">CD</option>
                                        <option value="value2" selected>LP</option>
                                        <option value="value3">Cassette</option>
                                        </select><input name="cantidad" type="number" min="1" max="999" value="1" placeholder="Cantidad" value="<?php echo $existencias; ?>"/>
                                    <br><br>
                                    <a href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>">
                                    <button class="registro anadir-carrito">Añadir al carrito</button></a>
                                    <a class="titulos-producto descripcion"><?php echo $descripcion?></a>
                                    <a>Lista de canciones:</a>
                                    <a class="titulos-producto descripcion"><?php echo str_replace("\n", "<br>", $tracklist)?></a>
                                    </div-->
                            <!--div class="">
                                <p class="">
                                </p>
                                <div class="">
                                    <button href="cartAction.php?action=addToCart&id=<?php echo $row["id"]; ?>">Add to cart</button>
                                </div>
                            </div-->
                <?php } }else{ ?>
                <p>Producto no encontrado</p>
                <?php } ?>
    </main>
    
    <br>

    <footer class="footer">
        <p> © 2022 BandUp.com | Todos los derechos reservados | <a href="/aviso-de-privacidad">Aviso de Privacidad</a></p>
    </footer>

    <br>
</body>
</html>