<?php
   require 'app.php';

   function includeTemplate(string $name){
      include TEMPLATES_URL."/${name}.php";
   }
?>
