<?php
session_start();
include('conexao.php');
mysqli_set_charset($conexao, "utf8");

// Verifica se o cliente está logado pelo email
if (!isset($_COOKIE["email"])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver logado
    exit;
}

$cliente_email = $_COOKIE["email"];

// Consulta SQL para obter as respostas do formulário do cliente
$sql_respostas = "SELECT estacao, sexo, intensidade, notas, ocasiao, durabilidade FROM respostas_formulario WHERE cliente_email = ?";
$stmt_respostas = mysqli_prepare($conexao, $sql_respostas);

if ($stmt_respostas) {
    mysqli_stmt_bind_param($stmt_respostas, "s", $cliente_email);
    mysqli_stmt_execute($stmt_respostas);
    $result_respostas = mysqli_stmt_get_result($stmt_respostas);

    // Inicializa um array para armazenar as características do cliente
    $caracteristicas_cliente = array();

    while ($row = mysqli_fetch_assoc($result_respostas)) {
        $caracteristicas_cliente[] = $row;
    }

    // Verifica se há respostas no formulário
    if (empty($caracteristicas_cliente)) {
        echo "Nenhuma resposta no formulário.";
        exit;
    }

    // Consulta SQL para obter os perfumes com no mínimo 5 características semelhantes
    $sql_perfumes = "SELECT * FROM perfume WHERE 
        estacao = ? OR
        sexo = ? OR
        intensidade = ? OR
        notas LIKE ? OR
        ocasiao = ? OR
        durabilidade = ?";
    $stmt_perfumes = mysqli_prepare($conexao, $sql_perfumes);

    if ($stmt_perfumes) {
        // Inicializa o contador de características correspondentes
        $caracteristicas_correspondentes = 0;
        ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family= Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/alterar.css">
        <link rel="stylesheet" href="css/favoritos.css">
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

<?php
                    foreach ($caracteristicas_cliente as $caracteristica) {
                        $notas_like = "%" . $caracteristica['notas'] . "%";
                        mysqli_stmt_bind_param($stmt_perfumes, "ssssss", $caracteristica['estacao'], $caracteristica['sexo'], $caracteristica['intensidade'], $notas_like, $caracteristica['ocasiao'], $caracteristica['durabilidade']);

                        mysqli_stmt_execute($stmt_perfumes);
                        $result_perfume = mysqli_stmt_get_result($stmt_perfumes);

                        // Verifica se pelo menos 5 características correspondem
                        while ($perfume = mysqli_fetch_assoc($result_perfume)) {
                            $correspondencia_atual = 0;

                            foreach ($caracteristica as $chave => $valor) {
                                if ($perfume[$chave] == $valor) {
                                    $correspondencia_atual++;
                                }
                            }

                            if ($correspondencia_atual >= 5) {
                                // Exibe os detalhes do perfume aqui, dentro do HTML
                                ?>
                                <div class="card">
                                    <img src="<?php echo $perfume['imagem1']; ?>" class="imagem">
                                    <h2 class="card-titulo1"><?php echo $perfume['nome']; ?></h2>
                                    <p class="card-texto1"><?php echo $perfume['marca']; ?> </p>
                                    <p class="card-texto2">R$<?php echo $perfume['preco']; ?></p>
                                    <a href="avaliacao.php?id=<?php echo $perfume['id']; ?>">Saiba Mais</a>
                                </div>
                                <?php
                            }
                        }
                    }
                    mysqli_stmt_close($stmt_perfumes);
                    ?>

                </div>
            </body>
        </html>

        <?php
    } else {
        echo "Erro na preparação da consulta de perfumes: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);
} else {
    echo "Erro na preparação da consulta de respostas: " . mysqli_error($conexao);
}
?>