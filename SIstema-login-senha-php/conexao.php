<?php

  $servidor = "localhost";
  $usuario = "root";
  $senha = "65112647";
  $db = 'teste';


  $con = new mysqli($servidor, $usuario, $senha, $db);

  if ($con->connect_error):

       die("Falha ao conectar") . $con->connect_error;   
  
  
 endif;
 
