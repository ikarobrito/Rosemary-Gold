<?php
include('conexao.php');

session_start();

$mensagem = ''; // Variável para armazenar a mensagem de sucesso

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o cliente está logado
    if (isset($_COOKIE["email"])) {
        $email = $_COOKIE["email"];

        // Atualiza os campos no banco de dados
        foreach ($_POST as $campo => $valor) {
            // Evita a atualização do campo de senha se estiver vazio
            if ($campo != 'nova_senha' && $campo != 'id' && ($campo != 'senha_atual' || !empty($valor))) {
                $sql_update = "UPDATE cliente SET $campo='$valor' WHERE email='$email'";
                $conexao->query($sql_update);
            }
        }

        // Atualiza a senha se a nova senha estiver definida
        if (isset($_POST['nova_senha'])) {
            $nova_senha = $_POST['nova_senha'];
            $sql_atualiza_senha = "UPDATE cliente SET senha='$nova_senha' WHERE email='$email'";
            $conexao->query($sql_atualiza_senha);
        }

        $mensagem = "Dados atualizados com sucesso.";
    } else {
        $mensagem = "Cliente não está logado.";
    }
}

// Remova a linha abaixo para evitar o fechamento prematuro da conexão
// $conexao->close();
?>



<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https: //fonts.googleapis.com/css2?family= Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/alterar.css">
        <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="UTF-8"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rosemary Gold | Perfil </title>
        <script>
            function link(){
                window.location = "./index.php"
            }
        </script>
        <script>
            // Função para exibir o alerta
            function exibirAlerta(mensagem) {
                alert(mensagem);
            }
        </script>
    </head>
    <body>

    <div class="fundo">
        <div class="fundo_top">
            <div class="logo">
                <img src="./img/logo4.png" alt="logo" class="logo1" height="100" width="220">
            </div>
            <div class="topo"></div>
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
            <button class="search-btn search-txt" id="pesquisa" type="submit"></button>
            <img src="img/lupa.png" alt="lupa" height="20" width="20">
        </form>
        

        <div class="icon">
            <a href="carrinho.php"> <img src="img/bolsa-de-compras (1).png" alt="icon" class="sacola"> </a>
        </div>

        <script>
            setTimeout(function () {
                $('#msgbox').fadeOut("slow");
            }, 3000);
        </script>

<script>
        function confirmLogout(event) {
            event.preventDefault(); // Evita o comportamento padrão do link

            const confirmLogout = window.confirm('Tem certeza de que deseja sair da conta?');

            if (confirmLogout) {
                // Adicione aqui a lógica para deslogar o usuário
                window.location.href = 'desloga.php'; // Substitua 'logout.php' pelo caminho do seu arquivo de logout
            } else {
                // Operação de logout cancelada
            }
        }
    </script>

    </div>


    <div class="container">
        
        <?php
        if (isset($_COOKIE["email"])) {
            $mostrar = "";
        } else {
            $mostrar = "<a class='login-button'  href='fazerlogin.php' type='submit'><p>Login</p></a>";
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

        } else {
            $mostrar2 = "<a class='login-button' href='cadastro.php' type='submit'>Criar Conta</a>";
        }
        echo $mostrar2;
        ?>
    </div>
<!-- fim menu -->

<!-- menu lateral -->
        <div class="content">

        <div class="navigation">
            <ul>
                <li class="list active">
                    <a  href="alterar.php">
                        <span class="icone"><ion-icon name="person"></ion-icon></span>
                        <span class="titulo">Alterar dados</span>
                    </a>
                </li>
                <li class="list">
                    <a  href="alterar_respostas.php">
                        <span class="icone"><ion-icon name="document"></ion-icon></span>
                        <span class="titulo">Alterar Formulário</span>
                    </a>
                </li>
                <li class="list">
                    <a  href="perfumes_relacionados.php">
                        <span class="icone"><ion-icon name="fas fa-perfume"></ion-icon></span>
                        <span class="titulo">Perfumes Relacionados</span>
                    </a>
                </li>
                <li class="list">
                    <a  href="favoritos.php">
                        <span class="icone"><ion-icon name="heart-empty"></ion-icon></span>
                        <span class="titulo">Seus Favoritos</span>
                    </a>
                </li>
                <li class="list">
                    <a  href="meuspedidos.php">
                        <span class="icone"><ion-icon name="basket"></ion-icon></span>
                        <span class="titulo">Meus Pedidos</span>
                    </a>
                </li>
                <li class="list">
                    <a href="" onclick="confirmLogout(event);">
                        <span class="icone"><ion-icon name="log-in"></ion-icon></span>
                        <span class="titulo">Sair da conta</span>
                    </a>
                </li>   
            </ul>


            <script src = "https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js" > </script>

            <script>
                const list = document.querySelectorAll('.list');
                function activelink(){
                    list.forEach((item)=>
                    item.classList.remove('active'));
                    this.classList.add('active');
                }
                    list.forEach((item)=>
                    item.addEventListener('click', activelink));
            </script>
            
        </div>

        <div class="altear">
            <div class="form_box">
        
                <h2 class="title">Alterar Dados</h2>

                <?php
                // Exibir alerta se a mensagem estiver definida
                if (!empty($mensagem)) {
                    echo "<script>exibirAlerta('$mensagem');</script>";
                }
                ?>
        
                <form action="" method="post">
                    <?php
                    // Exibe os campos existentes no banco de dados
                    if (isset($_COOKIE["email"])) {
                        $email = $_COOKIE["email"];

                        $sql = "SELECT * FROM cliente WHERE email = '$email'";
                        $result = $conexao->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            foreach ($row as $campo => $valor) {
                                // Ignora a exibição do campo de senha e ID
                                if ($campo != 'senha' && $campo != 'id') {
                                    echo "<input type='text' name='$campo' value='$valor' placeholder='Digite seu $campo'>";
                                }
                            }

                            echo "<input type='password' name='nova_senha' placeholder='Digite sua nova senha'>";
                            echo "<button type='submit'>Alterar</button>";
                        } else {
                            echo "Cliente não encontrado.";
                        }
                    } else {
                        echo "Cliente não está logado.";
                    }
                    ?>
                </form>
            </div>
        </div>


    </body>
</html>