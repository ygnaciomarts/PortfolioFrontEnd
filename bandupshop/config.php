<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'bandup_user');
    define('DB_PASSWORD', '12345');
    define('DB_NAME', 'bandup_shop');
    
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($link === false) {
        die("Error en la conexión: " . mysqli_connect_error());
    }
?>