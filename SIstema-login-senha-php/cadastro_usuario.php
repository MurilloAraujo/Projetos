<?php
  include "conexao.php";
?>
<!DOCTYPE HTML>
<html>
     <head>
          <meta charset="utf-8">
          <title>Sistema de Login e Senha Criptografados</title>
          <link href="css/style.css" rel="stylesheet" />
     </head>
     <body>
          <div id="conteudo">

               <h1>Sistema de login e senha criptografados</h1>

               <div class="borda"></div>
               <?php
                 
                 $recebeNome = $_POST['nome'];
                 $filtraNome = filter_var($recebeNome, FILTER_SANITIZE_SPECIAL_CHARS);
                 $filtraNome = filter_var($filtraNome, FILTER_SANITIZE_MAGIC_QUOTES);
                 
                 
                 $recebeEmail = $_POST['email'];
                 $filtraEmail = filter_var($recebeEmail, FILTER_SANITIZE_SPECIAL_CHARS);
                 $filtraEmail = filter_var($filtraEmail, FILTER_SANITIZE_MAGIC_QUOTES);

                 $recebeSenha = $_POST['senha'];
                 $filtraSenha = filter_var($recebeSenha, FILTER_SANITIZE_SPECIAL_CHARS);
                 $filtraSenha = filter_var($filtraSenha, FILTER_SANITIZE_MAGIC_QUOTES);

                 function criptoSenha($criptoSenha) {

                      return md5($criptoSenha);
                 }

                 function TamanhoSenha($senha) {

                      if (filter_var($senha) && strlen($senha) >= 4):

                           return TRUE;

                      else:

                           echo "<b style='color: red;'>Senha muito curta. Sua senha deve ter no mínimo 6 digitos</b>";

                           echo "<p><a href='javascript:history.back();'>Volte</a> para a página anterior e informe uma senha válida !</p>";
                           die();

                      endif;
                      
                 }
                 
                 
                 $criptoSenha = criptoSenha($filtraSenha);
                 $consultaBanco = mysqli_query($con, "SELECT * FROM usuario WHERE email_usuario = '$recebeEmail'");
                 $verificaBanco = mysqli_num_rows($consultaBanco);

                 if ($verificaBanco > 0):

                      echo "<p>Prezado(a) <strong>$recebeNome</strong>, o endereço de e-mail informado (<strong><em>$recebeEmail</em></strong>) já consta em nossa base de dados!</p>";
                      echo "<p><a href='javascript:history.back();'>Volte</a> para a página anterior e informe um novo endereço! Obrigado!</p>";

                      return false;

                 elseif(TamanhoSenha($filtraSenha)):

                      $insereDados = mysqli_query($con, "INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario) VALUES ('$filtraNome', '$filtraEmail', '$criptoSenha')") or die(mysql_error($con));
                      echo "<p>Seu cadastro foi efetuado com sucesso!</p>";
                       echo "<p><a href='index.php'>Volte</a> e acesse o sistema !</p>";
                   
                      
                 endif;
               ?>
          </div>
     </body>
</html>