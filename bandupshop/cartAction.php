<?php
// initialize shopping cart class
include 'cart.php';
$cart = new Cart;

// include database configuration file
include 'config.php';
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        // get product details
        $query = $link->query("SELECT * FROM productos WHERE id = ".$productID);
        $row = $query->fetch_assoc();

        $descuento = "0.00";
        $precio = "";

        if($row['precioD'] === $descuento) {
            $precio = $row['precioV'];
        } else {
            $precio = $row['precioD'];
        }

        $itemData = array(
            'id' => $row['id'],
            'name' => $row['nombre'],
            'artist' => $row['artista'],
            'type' => $row['tipo'],
            'cover' => $row['img'],
            'price' => $precio,
            'qty' => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'checkout.php':'checkout.php';
        header("Location: ".$redirectLoc);
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: checkout.php");
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){
        // insert order details into database
        $insertOrder = $link->query("INSERT INTO ordenes (usuario_id, precio_total, creado, modificado) VALUES ('".$_SESSION['sessCustomerID']."', '".$cart->total()."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
        
        if($insertOrder){
            $orderID = $link->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
                $sql .= "INSERT INTO orden_items (orden_id, producto_id, cantidad) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');";
                $sql2 .= "UPDATE productos AS pa INNER JOIN productos AS pb ON pa.id=pb.id
                SET pa.existencias = pb.existencias - '".$item['qty']."' WHERE pa.id = '".$item['id']."'";
            }
            // insert order items into database
            $insertOrderItems = $link->multi_query($sql);
            
            if($insertOrderItems){
                $insertOrderItems = $link->multi_query($sql2);
                $userID = $_SESSION['sessCustomerID'];
                $cart->destroy();
                header("Location: orderSuccess.php?id=$orderID&userID=$userID");
            }else{
                header("Location: checkout.php");
            }
        }else{
            header("Location: checkout.php");
        }
    }else{
        header("Location: checkout.php");
    }
}else{
    header("Location: checkout.php");
}
?>