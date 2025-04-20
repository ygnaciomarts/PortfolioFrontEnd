<?php
    // include database configuration file
    include 'config.php';

    // initializ shopping cart class
    include 'cart.php';
    $cart = new Cart;

    $style = $styleF = "";

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        // header("Location: login");
        $_SESSION['sessCustomerID'] = rand(10000, 1000000);
        //$_SESSION['sessCustomerID'] = $_SESSION["id"];
        $str_bienvenida = "Iniciar sesión";
        $str_link = "login";
        $style = "oculto";
        $styleF = "visible";

        $nombre_err = $apellido_err = $email_err = $direccion_err = $telefono_err = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $nombre = trim($_POST["nombre"]);
            $apellido = trim($_POST["apellido"]);
            $email = trim($_POST["email"]);
            $direccion = trim($_POST["direccion"]);
            $telefono = trim($_POST["telefono"]);

            if(empty(trim($_POST["nombre"]))){
                $nombre_err = "Por favor, inserta todos los datos indicados.";     
            } else{
                $nombre = trim($_POST["nombre"]);
            }

            if(empty($nombre_err) && empty($apellido_err) && empty($email_err) && empty($direccion_err) && empty($telefono_err)){
            
                // Prepare an insert statement
                $sql = "INSERT INTO usuarios (id, nombre, apellido, email, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?)";
         
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssss", $_SESSION['sessCustomerID'], $param_nombre, $param_apellido, $param_email, $param_direccion, $param_telefono);
                    
                    // Set parameters
                    $param_email = $email;
                    $param_nombre = $nombre;
                    $param_apellido = $apellido;
                    $param_direccion = $direccion;
                    $param_telefono = $telefono;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        header("location: cartAction.php?action=placeOrder");
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
        
    } else {
        $str_bienvenida = $_SESSION["nombre"];
        $str_link = "my-account";

        $styleF = "oculto";
        $_SESSION['sessCustomerID'] = $_SESSION["id"];

        $query = $link->query("SELECT * FROM usuarios WHERE id = ".$_SESSION['sessCustomerID']);
        $custRow = $query->fetch_assoc();
    }

    // redirect to home if cart is empty
    if($cart->total_items() <= 0){
        header("Location: index.php");
    }

    // set customer ID in session

    // get customer details by session customer ID

?>

<!--?php
    //session_start();

    // include database configuration file
    include 'config.php';

    // initializ shopping cart class
    include 'cart.php';
    $cart = new Cart;
    
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $str_bienvenida = "Iniciar sesión";
        $str_link = "login";
    } else {
        $str_bienvenida = $_SESSION["nombre"];
        $str_link = "my-account";
    }

        // redirect to home if cart is empty
        if($cart->total_items() <= 0){
            header("Location: index.php");
        }
    
        if($cart->total_items() <= 0){
            header("Location: index.php");
        }

?-->
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Checkout | BandUp</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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
            <a href="/bandupshop/">
                <img src="/bandupshop/img/BandUp.svg" width="160">
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
            <a href="checkout.php">
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

    <nav id="nav" class="nav">
        <ul class="menu">
            <li><a href="/bandupshop/">INICIO</a></li>
            <li><a href="/bandupshop/quienes-somos.html">QUIÉNES SOMOS</a></li>
            <li><a href="/bandupshop/#">CATÁLOGO</a></li>
            <li><a href="/bandupshop/contacto.html">CONTACTO</a></li>
        </ul>
    </nav>
    <nav id="navReg" class="nav-reg">
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
        <a href="/bandupshop/">
            <img src="/bandupshop/img/BandUp.svg" width="160">
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
            <a href="checkout.php">
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

    <nav id="menu" class="nav-inf">
        <ul class="menu">
            <li><a href="#">DEPARTAMENTOS</a></li>
            <li><a href="#">TOP SELLERS</a></li>
            <li><a href="#">NOVEDADES</a></li>
            <li><a href="#">PREVENTAS</a></li>
            <li><a href="#">OFERTAS</a></li>
        </ul>
    </nav>

    <br>

    <script>
    function updateCartItem(obj,id){
        $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Cart update failed, please try again.');
            }
        });
    }
    </script>

    <script
        src="https://www.paypal.com/sdk/js?client-id=ATZWOmFPUL3I3pjDji2ppfCDpx8yrechxhZ7EZe5kdJu8dJWuVquZ8i8qjSNHwr12sc-dYI5V3wP2MP6&currency=MXN"></script>
</head>

<body>
    <main id="main" class="contenedor sombra">
        <a class="titulos-body alt3">Checkout</a>
        <div class="checkout">
        <?php if($cart->total_items() == 1){ ?>
            <a class="titulos-body alt2">Resumen del producto</a>
        <?php } else {?>
            <a class="titulos-body alt2">Resumen de los productos</a>
        <?php } ?>
        <table class="table">
            <a class="titulos-body alt2 resp">Resumen del pedido</a>
            <hr noshade color="#dc454d"><hr class="resp" noshade color="#dc454d">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>
                <tr>
                    <td>
                        <a href="/product.php?action=ver&id=<?php echo $item["id"]; ?>">
                            <div class="carritoOut">
                                <?php echo '<img src="data:image/png;base64,'.base64_encode($item["cover"]).'" width="70px" height="70px" />'; ?>
                                <div class="check-nombre"><?php echo str_replace("`", "'", $item["name"])?><br>
                                <div class="check-por">por</div> <div class="check-artista"><?php echo $item["artist"] ?></div><br>
                                <div class="check-por">Cantidad: </div> <div class="check-artista"><?php echo $item["qty"]; ?></div></div>
                            </div>
                         </a>
                    </td>
                    <!--td>
                        <=?php echo $item["name"]; ?>
                    </td-->
                    <td>
                        <div class="center-carrito carrText">
                            <?php echo 'MX$'.$item["price"]; ?>
                        </div>
                    </td>
                    <td>
                        <div class="center-carrito carrText">
                            
                            <input class="inputItems" type="number" value="<?php echo $item['qty']; ?>" onchange="updateCartItem(this, '<?php echo $item['rowid']; ?>')">
                        </div>
                    </td>
                    <td>
                        <div class="center-carrito carrText">
                            <?php echo 'MX$'.$item["subtotal"]; ?>
                        </div>
                    </td>
                    <td>
                        <div class="center-carrito">
                            <a href="cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" onclick="return confirm('¿Estás seguro de querer eliminar este producto de tu carrito?')">
                                <svg class="delete" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 23 23" fill="none" stroke="#dc454d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } }else{ ?>
                <tr>
                    <td colspan="4">
                        <p>Tu carrito está vacío.</p>
                    </td>
                    <?php } ?>
            </tbody>
            <!--tfoot>
                <tr>
                    <td colspan="3"></td>
                    <?php if($cart->total_items() > 0){ ?>
                    <td class="text-center"><strong>Total:
                            <?php echo 'MX$'.$cart->total() ?>
                        </strong></td>
                    <?php } ?>
                </tr>
            </tfoot-->
        </table>

        <?php
            if($cart->total() < 799) {
                $costoEnvio = $cart->total()*0.07;
            } else {
                $costoEnvio = 0;
            }
        ?>

        <div class="sub resp">
            <a class="subtotal">Subtotal</a><a class="subtotal precioSub"><?php echo 'MX$'.$cart->total() ?></a><br>
            <a class="subtotal">Envío</a><a class="subtotal precioSub">
                <?php 
                    if($costoEnvio == 0) {
                        echo 'Gratis';
                    } else {
                        echo 'MX$'.$costoEnvio;
                    }
                ?>
            </a><br>
            <br><br>
            <a>Total</a><a class="subtotal precioSub">
                <?php echo 'MX$'.$cart->total() + $costoEnvio ?>
            </a>

            <div class="paypal" id="paypal-button-container-50">
                <script>
                    paypal.Buttons({
                        style: {
                            color: 'silver',
                            shape: 'rect',
                            label: 'pay'
                        },
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: <?php echo $cart->total() + $costoEnvio ?>
                                }
                            }]
                        })
                    },

                    onApprove: function(data, actions) {
                        actions.order.capture().then(function (detaller) {
                            window.location.href = "shipping.php"
                        });
                    },

                    onCancel: function(data) {
                        alert("Pago cancelado. Por favor, inténtelo de nuevo.");
                        console.log(data);
                    }
                }).render('#paypal-button-container-50');
                </script>
            </div>
            <!--a href="shipping.php">
                <button class="checkoutBtn resp">Checkout</button>
            </a-->
        </div>

        <a href="index.php">
            <button class="checkoutBtn">Añadir más artículos</button>
        </a>

        <br><br>

        <a class="titulos-body alt2 resp2">Resumen del pedido</a>

        <hr class="resp2" noshade color="#dc454d">

        <div class="sub resp2">
            <a class="subtotal">Subtotal</a><a class="subtotal precioSub"><?php echo 'MX$'.$cart->total() ?></a><br>
            <a class="subtotal">Envío</a><a class="subtotal precioSub">
                <?php 
                    if($costoEnvio == 0) {
                        echo 'Gratis';
                    } else {
                        echo 'MX$'.$costoEnvio;
                    }
                ?>
            </a><br>
            <br><br>
            <a>Total</a><a class="subtotal precioSub">
                <?php echo 'MX$'.$cart->total() + $costoEnvio ?>
            </a>

            <div class="paypal" id="paypal-button-container">
                <script>
                    paypal.Buttons({
                        style: {
                            color: 'silver',
                            shape: 'rect',
                            label: 'pay'
                        },
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: <?php echo $cart->total() ?>
                                }
                            }]
                        })
                    },

                    onApprove: function(data, actions) {
                        actions.order.capture().then(function (detaller) {
                            window.location.href = "shipping.php"
                        });
                    },

                    onCancel: function(data) {
                        alert("Pago cancelado. Por favor, inténtelo de nuevo.");
                        console.log(data);
                    }
                }).render('#paypal-button-container');
                </script>
            </div>

            <!--a href="shipping.php">
                <button class="checkoutBtn resp2">Checkout</button>
            </a-->
        </div>

        <!--a-->

        <!--div class="shipAddr <?php echo $style ?>">
            <p>
                <?php echo $custRow['nombre']; ?>
            </p>
            <p>
                <?php echo $custRow['email']; ?>
            </p>
            <p>
                <?php echo $custRow['telefono']; ?>
            </p>
            <p>
                <?php echo $custRow['direccion']; ?>
            </p>
        </div-->

        <!--div class="shipAddr <?php echo $styleF ?>">
            <a class="titulos-body alt">Datos para el envío</a>
            <form class="formulario" id="form1" name="signup-form" method="post" action="">
                <div class="varios">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M14 20H4V17C4 14.3 9.3 13 12 13C13.5 13 15.9 13.4 17.7 14.3C16.9 14.6 16.3 15 15.7 15.5C14.6 15.1 13.3 14.9 12 14.9C9 14.9 5.9 16.4 5.9 17V18.1H14.2C14.1 18.5 14 19 14 19.5V20M23 19.5C23 21.4 21.4 23 19.5 23S16 21.4 16 19.5 17.6 16 19.5 16 23 17.6 23 19.5M12 6C13.1 6 14 6.9 14 8S13.1 10 12 10 10 9.1 10 8 10.9 6 12 6M12 4C9.8 4 8 5.8 8 8S9.8 12 12 12 16 10.2 16 8 14.2 4 12 4Z" />
                    </svg>
                    <input name="nombre" type="text" placeholder="Nombre">
                    <input name="apellido" type="text" placeholder="Apellido" />
                </div>
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C12.1,13 13.66,13.23 15.11,13.69C14.5,14.07 14,14.6 13.61,15.23C12.79,15.03 11.89,14.9 11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H13.04C13.13,18.8 13.38,19.44 13.76,20H3V17C3,14.34 8.33,13 11,13M18.5,10H20L22,10V12H20V17.5A2.5,2.5 0 0,1 17.5,20A2.5,2.5 0 0,1 15,17.5A2.5,2.5 0 0,1 17.5,15C17.86,15 18.19,15.07 18.5,15.21V10Z" />
                    </svg>
                    <input name="direccion" type="text" placeholder="Direccion" title="" />
                </div>
                <div class="input-contenedorReg">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M22 6C22 4.9 21.1 4 20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6M20 6L12 11L4 6H20M20 18H4V8L12 13L20 8V18Z" />
                    </svg>
                    <input name="email" type="email" placeholder="Correo electronico" />
                </div>
                <div class="varios">
                    <svg class="iconReg" style="width:22px; height:22px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                    </svg>
                    <input name="telefono" type="text" placeholder="Teléfono / Móvil" />
                </div>
                <br>
                <div class="center">
                    <input type="checkbox" class="padding" value="1" name="terminos" checked /><label for="terminos">He
                        leído y acepto los <a class="link" href="terminos-y-condiciones">términos y condiciones</a> y el
                        <a class="link" href="aviso-de-privacidad">aviso de privacidad</a>.</label>
                </div>
                <div class="center">
                    <button href="cartAction.php?action=placeOrder" type="submit" class="registro" name="enviar">Ir para
                        la entrega</button>
                </div>
                <br>
                <p>¿Ya tienes una cuenta en BandUp? <a class="link" href="login.php">Inicia sesión</a>.</p>
            </form>
        </div-->
    <!--div id="paypal-button-container">

        <script>
            paypal.Buttons({
                style: {
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: <?php echo $cart->total() ?>
                        }
                    }]
                })
            },

            onApprove: function(data, actions) {
                actions.order.capture().then(function (detaller) {
                    window.location.href = "orderSuccess.php"
                });
            },

            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
        </script>
    </div-->
    </div>
    </main>
    </div>
</body>

<br>

    <footer class="footer">
        <p> © 2022 BandUp.com | Todos los derechos reservados | <a href="/aviso-de-privacidad">Aviso de Privacidad</a></p>
        <br>
    </footer>

    <script lenguage="javascript">    
    var nav = document.getElementById('nav');
    var navReg = document.getElementById('navReg');
    var menu = document.getElementById('menu');
    var main = document.getElementById('main');
    load();

    function load () {
        const darkmode = localStorage.getItem('dark');

        if(!darkmode){
            store('false');
        } else if(darkmode == 'true'){
            document.body.classList.toggle('dark');
            nav.classList.toggle('dark');
            navReg.classList.toggle('dark');
            menu.classList.toggle('dark');
            main.classList.toggle('dark');
        }
    }

    function store(value) {
        localStorage.setItem('dark', value);    
    }
    </script>

</html>