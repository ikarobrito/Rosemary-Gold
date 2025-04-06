<?php 
header("Content-type: text/html; charset=utf-8"); 
session_start(); 
include("conexao.php"); 
mysqli_set_charset($conexao, "utf8"); 
$id = $_GET['id']; 
$sql = "SELECT * FROM perfume WHERE id = '{$id}'"; 
$result = mysqli_query($conexao, $sql);
$nome = mysqli_fetch_assoc($result); 

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/avaliacao.css">
        <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="UTF-8"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $nome['nome']; ?></title>
        <script>
            function link(){
                window.location = "./index.php";
            }
        </script>

        
    </head>
    <body>
        <div class="fundo">
            <div class="fundo_top"> 
                <div class="logo"> 
                    <img src="./img/logo4.png" alt="logo" class="logo1" height="100" width="220">
                </div>
    
                <div class="topo"> 
                </div>
            </div> 
            <div class="menu">
                <ul class="menu-h">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="feminino.php">Feminino</a></li>
                    <li><a href="masculino.php">Masculino</a></li>
                    <li><a href="unissex.php">Unissex</a></li>
                    <li><a href="infantil.php">Infantil</a></li>
                    <li><a href="sobre.php">Sobre</a></li>
                    <li><a href="#contato-home">Contato</a></li>
                </ul>
            </div>  
            
            <form action="pesquisa.php" method="post" autocomplete="off">
                <input type="text" id="txtBusca" name="pesquisar" class="search-box" placeholder="O que procura?" method="post">
                <button class="search-btn search-txt" id="pesquisa" type="submit" ></button>
                <img src="img/lupa.png" alt="lupa" height="20" width="20">
        </form>
                
            <!-- <input type="text" id="txtBusca" name="pesquisar" class="search-txt" placeholder="O que procura?" method="post">
            <a href="pesquisa.php"  name="pesquisar" class="search-btn" method="post" autocomplete="off">
                <img src="img/lupa.png" alt="lupa" height="20" width="20">
            </a> -->

        <div class="icon">
          <a href="carrinho.php"> <img src="img/bolsa-de-compras (1).png" alt="icon" class="sacola" ></a> 
        </div>


		<script>
			setTimeout(function() {
				$('#msgbox').fadeOut("slow");
			}, 3000);
		</script>

    </div>


        <div class="container">
            <?php
            if (isset($_COOKIE["email"])) {
                $mostrar = "";
            } else {
                $mostrar = "
                <a class='login-button' id='log' href='fazerlogin.php' type='submit'>Login</a>";
            }
            echo $mostrar;
            ?>
            <?php
            if (isset($_COOKIE["email"])) {
                $mostrar2 = "<form method='POST' action='desloga.php' class='sair'><input class='logent' id='ent' href='' type='submit' name='desloga' value='SAIR'></form>";
            } else {
                $mostrar2 = "<a class='login-button' id='ent' href='cadastro.php' type='submit'>Criar Conta</a>";
            }
            echo $mostrar2;
            ?>
        </div>
        
            <?php
            if(isset($_COOKIE['email'])){
                echo '    <div class="container2">
                <div class="card">
                    <img src="'. $nome['imagem1'].'" alt="" class="card-imagem" >
                </div>
                <div class="conteudo">
                    <p class="titulo">'. $nome['nome'] .'</p>
                    <p class="titulo"> '. $nome['marca'] .'</p>
                    <p class="texto">R$ ' . $nome['preco'] . '</p>
                    <a href="carrinho.php?acao=add&id=' . $nome['id'] . '">Adicionar ao carrinho</a>
                    
                </div>
            </div>';
            } else {
                echo '<div class="error"><p class="erro">Você não tem permissão para acessar essa página. Faça a validação dos seus dados antes de continuar <a href="login.php" class="link">aqui</a>.</p></div>';
            }
            ?>
            

</body>

</html>
            <script>
                $(function() {
                    $("#headerDiv").load("header.php");
                });
            </script>
            <script>
                jQuery(document).ready(function($) {
                    $('#checkbox').change(function() {
                        setInterval(function() {
                            moveRight();
                        }, 3000);
                    });

                    var slideCount = $('#slider ul li').length;
                    var slideWidth = $('#slider ul li').width();
                    var slideHeight = $('#slider ul li').height();
                    var sliderUlWidth = slideCount * slideWidth;

                    $('#slider').css({
                        width: slideWidth,
                        height: slideHeight
                    });

                    $('#slider ul').css({
                        width: sliderUlWidth,
                        marginLeft: -slideWidth
                    });

                    $('#slider ul li:last-child').prependTo('#slider ul');

                    function moveLeft() {
                        $('#slider ul').animate({
                            left: +slideWidth
                        }, 200, function() {
                            $('#slider ul li:last-child').prependTo('#slider ul');
                            $('#slider ul').css('left', '');
                        });
                    };

                    function moveRight() {
                        $('#slider ul').animate({
                            left: -slideWidth
                        }, 200, function() {
                            $('#slider ul li:first-child').appendTo('#slider ul');
                            $('#slider ul').css('left', '');
                        });
                    };

                    $('a.control_prev').click(function() {
                        moveLeft();
                    });

                    $('a.control_next').click(function() {
                        moveRight();
                    });

                });
            </script>
        </div>
    </body>
</html>