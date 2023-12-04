
<?php
session_start();
include('conexao.php');	
mysqli_set_charset($conexao, "utf8");



if(isset($_SESSION['msgv'])){
	session_destroy();
	if(isset($_COOKIE['emailv'])){
		setcookie("emailv", "", time() - 3600);
	}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https: //fonts.googleapis.com/css2?family= Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/sobre.css">
        <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="UTF-8"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rosemary Gold | Sobre</title>
        <script>
            function link(){
                window.location = "./index.php"
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
                <li><a href="feminino.php"> Feminino</a></li>
                <li><a href="masculino.php"> Masculino</a></li>
                <li><a href="unissex.php"> Unissex</a></li>
                <li><a href="infantil.php"> Infantil</a></li>
                <li><a href="sobre.php"> Sobre</a></li>
                <li><a href="perfil.php"> Perfil</a></li>
                <li><a href="https://linktr.ee/rosemarygold"> Contato</a></li>
            </ul>
        </div> 
        <form action="pesquisa.php" method="post" autocomplete="off">
                <input type="text" id="txtBusca" name="pesquisar" class="search-box" placeholder="O que procura?" method="post">
                <button class="search-btn search-txt" id="pesquisa" type="submit" ></button>
                <img src="img/lupa.png" alt="lupa" height="20" width="20">
        </form>

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
            $mostrar = "<button class='login'><a  href='fazerlogin.php' type='submit'><p>Login</p></a></button>";
        }
        echo $mostrar;
        ?>
        <?php
        if (isset($_COOKIE["email"])) {
            $email = $_COOKIE["email"];
        
        // Consulta SQL para obter o nome do cliente
        $sql = "SELECT nome FROM cliente WHERE email = '$email'";
        $result = $conexao->query($sql);
        
        if ($result->num_rows > 0) {
            // Se houver resultados, obtém o nome
            $row = $result->fetch_assoc();
            $nomeCliente = $row["nome"];
            $mostrar2 = "<a href=perfil.php>Bem vindo, $nomeCliente</a>";
            
        }
        echo $mostrar2;
    }

        // } else {
        //     $mostrar2 = "<a class='login-button' href='cadastro.php' type='submit'>Criar Conta</a>";
        // }

        // ?>
    </div>


<!--inicio sobre-->

<p class="titulo1"> Conheça a Rosemary Gold </p>

<p class="texto">A empresa Rosemary Gold tem seu foco nas revendas de perfumes de altos e baixos 
    preços com objetivo de alcançar públicos de diferentes rendas. 
    <br>
    Para facilitar o processo de escolha do cliente tem a opção de responder um formulário com perguntas, 
    fundadas em pesquisas feitas pela nossa equipe, onde o usuário responde com base no seu gosto e 
    através das respostas é indicado propostas de perfumes de acordo com a pesquisa. <br><br>Rosemary Gold o perfume de um bom momento!</p>

    <p class="titulo1"> Missão da empresa </p>
    <p class="texto">Facilitar os clientes a encontraremseu perfume ideal para contribuir na limpeza e saúde geral, além do bem-estar e auxiliando na melhora da concentração e temperamento.</p>

    <p class="titulo1"> Visão da empresa </p>
    <p class="texto">Uma empresa que no futuro se vê no ramo mundial.</p>

    <p class="titulo1"> Valores da empresa </p>
    <section class="container2">
        <div class="card2">
            <h2 class="card2-titulo1">Verdade</h2>
        </div>
        <div class="card2">
            <h2 class="card2-titulo1">Diversidade</h2>
        </div>
        <div class="card2">
            <h2 class="card2-titulo1">Compromisso</h2>


        </div>
    </section>
    <section class="container2">
        <div class="card2">
            <h2 class="card2-titulo1">Criatividade</h2>
        </div>
        <div class="card2">
            <h2 class="card2-titulo1">Cliente no Controle</h2>
        </div>
        <div class="card2">
            <h2 class="card2-titulo1">Qualidade</h2>

        </div>
    </section>




    <p class="titulo1">Nossa Equipe</p>
    <section class="container2">
        <div class="card">
            <img src="img/ikaro.jpeg" class="imagem">
            <h2 class="card-titulo1">Ikaro Ramoni</h2>
            <p class="card-texto2">Back-End</p>
        </div>
        <div class="card">
            <img src="img/kety.jpeg" class="imagem"> 
            <h2 class="card-titulo1">Ketyllen Pacheco</h2>
            <p class="card-texto2">Front-End</p>
        </div>
        <div class="card">
            <img src="img/madu.jpeg" class="imagem">
            <h2 class="card-titulo1">Maria Eduarda</h2>
            <p class="card-texto2">Front-End</p>

        </div>
    </section>
        


<!--inicio footer-->
<footer>
    <div class="container-footer">
        <div class="row-footer">
            <!--footer-col inicio-->
            <div class="footer-col">
                <h4>Categorias</h4>
                <ul>
                    <li> <a href=""> Feminino</a> </li>
                    <li> <a href=""> Masculino</a> </li>
                    <li> <a href=""> Unissex</a> </li>
                    <li> <a href=""> Infantil</a> </li>
                </ul>
            </div>
            <!--end footer-col-->
            <!--footer-col inicio-->
            <div class="footer-col">
                <h4> Ajuda</h4>
                <ul>
                    <li> <a href=""> Sobre nós </a> </li>
                    <li> <a href=""> Contato</a> </li>
                    <li> <a href=""> politica de privacidade</a> </li>
                </ul>
            </div>
            <!--end footer-col-->
            <!--footer-col inicio-->
            <div class="footer-col">
                <h4>Sugestões </h4>
                <ul>
                    <li> <a href=""> Formulário de preferência</a> </li>
                    <li> <a href=""> Clássicos</a> </li>
                    <li> <a href=""> Mais vendidos</a> </li>
                    <li> <a href=""> Marcas </a> </li>
                </ul>
            </div>
    
            <div class="footer-col">
                <h4>Redes Sociais </h4>
                <div class="medias-socias ">
                    <ul>
                    <a href="https://www.instagram.com/rosemary_goldd/"> <i class="fa fa-instagram"></i> </a>
                    <a href="https://www.facebook.com/profile.php?id=61552037515417"> <i class="fa fa-facebook"></i> </a>
                    <a href="https://api.whatsapp.com/send?phone=5511914152486&text=Fale%20com%20a%20Rosemary%20Gold!"> <i class="fa fa-whatsapp"></i> </a>
                    
                    </ul>
                </div>
            </div>
            <!--end footer-col-->
        </div>
    </div>
</footer>
<!-- fim footer -->
</body>
</html>


