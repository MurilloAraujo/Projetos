<?php 
     include "conexao.php"; 
     
     $recebeEmail = $_POST['email'];
     
     $filtraEmail = filter_var($recebeEmail,FILTER_SANITIZE_SPECIAL_CHARS);
     $filtraEmail = filter_var($filtraEmail, FILTER_SANITIZE_MAGIC_QUOTES);
     $sql_pesq = mysqli_query($con, "SELECT * FROM usuario WHERE email_usuario = '$recebeEmail'") or die (mysql_error($con));
     $verifica = mysqli_num_rows($sql_pesq);
     
?>
<!DOCTYPE HTML>
<html lang="br" class="no-js">
     <head>
          <meta charset="utf-8">
          <title>Sistema de Login e Senha Criptografados</title>
          <link href="css/style.css" rel="stylesheet" />
     </head>
     <body>
          <div id="conteudo">
               
               <?php if ($verifica == 0) { ?>
               
                    <H2>E-mail inválido!</H2> 
                    <p>Desculpe, mas o e-mail solicitado não &eacute; cadastrado.</p>
                    <p>Entre em contato com o administrador do sistema.<br>
                    Se quiser tentar novamente, <a href="../">clique aqui</a>.<p>
                    <p>Obrigado.</p>
                    
               <?php }
               
               else {
                    
                    $result = mysqli_fetch_array($sql_pesq);
                    $id_usuario = $result['id_usuario'];
                    $nome = $verifica['nome_usuario '];
                    $email = $verifica['email'];
                    
                    function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
                         
                         $lmin = 'abcdefghijklmnopqrstuvwxyz';
                         $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                         $num = '1234567890';
                         $simb = '!@#$%*-';
                         $retorno = '';
                         $caracteres = '';
                         $caracteres .= $lmin;
                         
                         if ($maiusculas) $caracteres .= $lmai;
                         if ($numeros) $caracteres .= $num;
                         if ($simbolos) $caracteres .= $simb;
                         
                         $len = strlen($caracteres);
                         
                         for ($n = 1; $n <= $tamanho; $n++):
                              
                              $rand = mt_rand(1, $len);
                              $retorno .= $caracteres[$rand-1];
                              
                         endfor;
                         
                         return $retorno;
                         
                    }
                    
                   
                    
                    $novasenha = geraSenha(9, true, false);
                    $senhamd5 = md5($novasenha);
 
                    $query = "UPDATE usuario SET senha_usuario = '$senhamd5' where id_usuario = ".$id_usuario;
                    $rs = mysqli_query($con, $query);
                    $formato = "\nContent-type: text/html\n";
                    $msg = "Olá, $nome. Recebemos uma solicitação para renovar sua senha\n.<br><br>";
                    $msg .= "Seu usuario: <strong>$usuario</strong><br>";
                    $msg .= "Sua <strong>nova</strong> senha: <strong>$novasenha</strong>\n<br><br>";
                    $msg .= "Caso não tenha solicitado esta ação. Acesse a sua conta e altere sua senha novamente\n.<br>";
                    $msg .= "<br>\n";	
                    $msg .= "Obrigado.<br>\n";
                    mail("$email","Nova Senha","$msg", "From: Sistema <murylllo2233@gmail.com>".$formato);
               ?>
                    
               <H2>Senha enviada!</H2> 
               <p>Parabéns. Sua senha foi enviada para o e-mail solicitado.</p>
               <p>Após verificar seu e-mail, retorne à página de login.</p>
               <p>Se preferir, <a href="index.php">clique aqui</a>.</p>
               <p>Obrigado!</p>
               
          <?php } ?>
     </body>
</html>

