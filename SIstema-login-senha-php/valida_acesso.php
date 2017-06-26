<?php
  
   include './conexao.php';
   
   session_start();
  
?>
<!DOCTYPE HTML>
<html lang="br" class="no-js">
     <head>
          <title>Sistema de Login e Senha Criptografados</title>
          <link href="css/style.css" rel="stylesheet" />
     </head>
     <body>
          <div id="conteudo">
               
               <h1>Sistema de login e senah criptrografados - Verificando informações</h1>  
               <div class="borda"></div>
               
               <?php 
                
            
                 $email = $_POST['email'];
                 $filtraEmail = filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS);
                 $filtraEmail = filter_var($filtraEmail, FILTER_SANITIZE_MAGIC_QUOTES);
                 
                 $senha = $_POST['senha'];
                 $filtraSenha = filter_var($senha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                 $filtraSenha = filter_var($filtraSenha, FILTER_SANITIZE_MAGIC_QUOTES);
                 
                 function cripSenha($senha){
                      
                      return md5($senha);
                      
                 }
                 
                 $cripSenha = cripSenha($filtraSenha);




                 $ConsultaInformacoes = mysqli_query($con, "SELECT * FROM usuario WHERE email_usuario = '$filtraEmail' AND senha_usuario =    '$cripSenha'") or die(mysqli_error($con));
                 
                 $VerificaInformacoes = mysqli_num_rows($ConsultaInformacoes); // número de linhas do banco
                 
                 if($VerificaInformacoes > 0):
                      
                      while ($resultado = mysqli_fetch_array($ConsultaInformacoes)):
                      
                      $_SESSION['login'] = true;
                      $_SESSION['nome_usuario'] = $resultado['nome_usuario'];
                      
                      header("Location: conteudo_exclusivo.php");
                      
                      endwhile;
                      
                    else:  
                      
                         echo "<p> Nome de usuário ou senha não conferem. Por favor, <a href='javascript:history.back();'>volte</a> e tente novamente!</p>";
                         die();
                 endif;
                 
                ?>
          </div>
     </body>
</html>