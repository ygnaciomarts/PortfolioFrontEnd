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

    $nombreCambiado = "empty";

    $nombre = $artista = $descStyle = $descStyleD = "";

    //if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
        //if($_REQUEST['action'] == 'ver' && !empty($_REQUEST['id'])){
            //$id = $_REQUEST['id'];

            $query = $link->query("SELECT * FROM productos");
            $row = $query->fetch_assoc();

            //$id = $row['id'];
            //$nombre = $row['nombre'];
            //$artista = $row['artista'];
            //$tracklist = $row['tracklist'];

            //if($row === null) {
                //header("Location: 404.html");
            //}
        //} else {
            //header("Location: 404.html");
        //}
    //} else {
        //header("Location: 404.html");
    //}
?>

<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Editar producto | BandUp</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Montserrat:wght@700&display=swap"
        rel="stylesheet">
    <link href="../css/normalize.css" rel="stylesheet">
    <link href="../css/styles.css" as="style" rel="preload">
    <link href="../css/styles.css" rel="stylesheet">

</head>

<body>

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
                    <li><a href="/bandupshop/">INICIO</a></li>
                    <li><a href="/bandupshop/admin/product-insert.php">INSERTAR PRODUCTOS</a></li>
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
        </div>
    </div>

    <body>
        <div class="logo-alt" style="position: relative;">
            <a href="/bandupshop/">
                <img src="/bandupshop/img/BandUp.svg" width="100">
            </a>
            <nav class="nav-alt">
                <ul class="menu-alt" style="padding-left: 20px;">
                    <li><a href="/bandupshop/">INICIO</a></li>
                    <li><a href="/bandupshop/admin/product-insert.php">INSERTAR PRODUCTOS</a></li>
                </ul>
            </nav>
        </div>

        <script language="javascript">
            function activa_boton(campo,boton){
                if (campo.value != "0"){
                    boton.disabled=false;
                } else {
                    boton.disabled=true;
                }
            }
        </script> 

<br>
<main class="contenedor-producto">
<div class="contenedor-insertar editar texto-suelto">
<a class="titulos-body alt">Editar producto</a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="producto" id="producto">
        <select name="producto" onChange="activa_boton(this,this.form.boton)">
        <option value="0" selected>Seleccione...</option>
        
        <?php
        $style = "rebaja";
                $query = $link->query("SELECT * FROM productos");
                while($row = $query->fetch_assoc()) {
                        echo '<option value="'.$row["id"].'">'.$row["id"]." - ".$row["nombre"]." de ".$row["artista"].'</option>';
                }
                ?>
                </select>
                <input type="submit" name="boton" id="boton" value="Enviar" disabled=true>
                </form>


    <?php
    $id = $_POST['producto'];


    if(!empty($id)){
                $query = $link->query("SELECT * FROM productos where id = ".$id);
                //$id = $_REQUEST['producto'];
                        /*echo "<table border = 1 cellspacing = 0 cellpadding = 10>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Artista</th>
			<th>Tipo</th>
            <th>Precio de venta</th>
            <th>Precio con descuento</th>
            <th>Existencias</th>
            <th>Imagen</th>
            <th>Descripción</th>
            <th>Tracklist</th>
            <th>Estado</th>
		</tr>";*/

        while($row = $query->fetch_assoc()) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $artista = $row['artista'];
            $tipo = $row['tipo'];
            $precioV = $row["precioV"];
            $precioD = $row["precioD"];
            $existencias = $row["existencias"];
            $descripcion = $row["descripcion"];
            $tracklist = $row['tracklist'];
            $estado = $row["estado"];
            $cover = base64_encode($row['img']);

            /*echo " <tr> <td><div contenteditable>".$row["id"]."</div></td> <td name='nombre' id='nombre'><div contenteditable name='nombre'>".$row["nombre"]."</div></td><td><div contenteditable>".$row["artista"]."</div></td>
            <td><div contenteditable>".$row["tipo"]."</div></td> <td><div contenteditable>".$row["precioV"]."</div></td>
            <td><div contenteditable>".$row["precioD"]."</div></td> <td><div contenteditable>".$row["existencias"]."</div></td>
            <td><div contenteditable> a </div></td> <td><div contenteditable>".$row["descripcion"]."</div></td>
            <td><div contenteditable>".$row["tracklist"]."</div></td> <td><div contenteditable>".$row["estado"]."</div></td> </tr>";*/
        }
        $style = "";
    }
                    
                ?>


<script>
    $(document).ready(function(){
        $(".boton").click(function(){
 
            var valores="";
 
            // Obtenemos todos los valores contenidos en los <td> de la fila
            // seleccionada
            $(this).parents("tr").find("#nombre").each(function(){
                valores+=$(this).html()+"\n";
            });
            console.log(valores);
            alert(valores);
        });
    });

    </script>


<form action="editAction.php" method="post" class="<?php echo $style;?>">
<br><br>
    <input type="text" name="id" readonly value="<?php echo $id;?>"><br>
	<input type="text" name="nombre" value="<?php echo $nombre;?>"><br>
    <input type="text" name="artista" value="<?php echo $artista;?>"><br>
    <input type="text" name="tipo" value="<?php echo $tipo;?>"><br>
    <input type="text" name="precioV" value="<?php echo $precioV;?>"><br>
    <input type="text" name="precioD" value="<?php echo $precioD;?>"><br>
    <input type="text" name="existencias" value="<?php echo $existencias;?>"><br><br>
    <?php echo '<img name="cover" src="data:image/png;base64,'.$cover.'" class="img-portada" width="400" height="400"/>';?><br><br><input type="file" name="cover">
                <input type="submit" value="Subir"><br><br>
    <textarea name="descripcion" rows="7" cols="60"><?php echo $descripcion;?></textarea><br><br>
    <textarea name="tracklist" rows="10" cols="60"><?php echo $tracklist;?></textarea><br><br>
    <input type="text" name="estado" value="<?php echo $estado;?>"><br>

	<br>

    <!--div class="input-contenedorReg">
                    <input name="nombre" value="<?php echo $nombre; ?>" type="text" placeholder="Nombre">
                    <input name="artista" value="<?php echo $artista; ?>" type="text" placeholder="Artista"/>
                </div>
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
                    <input name="descripcion" value="<?php echo $descripcion; ?>" type="text" placeholder="Descripción"/>
                    <input name="tracklist" value="<?php echo $tracklist; ?>" type="text" placeholder="Tracklist"/>
                    <input name="existencias" type="number" placeholder="Existencias" value="<?php echo $existencias; ?>"/>
        </div>
                <br>
                
                    <div class="ins-center">
                    <button type="submit" class="registro" name="subir">Insertar</button>
                </div-->
	<input type="submit" value="Guardar">
</form>
</div>

</main>

<br><br>

    </body>
</html>