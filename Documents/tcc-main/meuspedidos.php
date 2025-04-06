<?php
session_start();
require("conexao.php");

if (!isset($_COOKIE["email"])) {
    header("Location: login.php");
    exit();
}

$email_cliente = $_COOKIE["email"];

$sql = "SELECT pedido.id as pedido_id, total, data_pedido, perfume.nome as nome_perfume, perfume.imagem1 as imagem1, quantidade, preco_unitario
        FROM pedido
        JOIN itens_pedido ON pedido.id = itens_pedido.pedido_id
        JOIN perfume ON itens_pedido.perfume_id = perfume.id
        WHERE cliente_email = '$email_cliente'
        ORDER BY data_pedido DESC";

$result = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/pedidos.css">
    <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosemary Gold | Meus Pedidos </title>
    <script>
        function link(){
            window.location = "./index.php"
        }
    </script>

<script>
        setTimeout(function() {
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
            $mostrar2 = "<form method='POST' action='desloga.php' class='sair'><input class='login-button' href='' type='submit' name='desloga' value='SAIR'></form>";
        } else {
            $mostrar2 = "<a class='login-button' href='cadastro.php' type='submit'>Criar Conta</a>";
        }
        echo $mostrar2;
        ?>
    </div>


</div>

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

<div class="container2">
    <p class="titulo1"><b>Meus Pedidos</b></p>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="card">

                    <img src="<?php echo $row['imagem1']; ?>" alt="Imagem do Perfume" class="imagem">
                <div class="card-texto1">
                    <p>Data do Pedido: <?php echo $row['data_pedido']; ?></p>
                    <p>Produto: <?php echo $row['nome_perfume']; ?></p>
                    <p>Quantidade: <?php echo $row['quantidade']; ?></p>
                    <p>Preço Unitário: R$ <?php echo number_format($row['preco_unitario'], 2, ',', '.'); ?></p>
                    <p>Total do Item: R$ <?php echo number_format($row['quantidade'] * $row['preco_unitario'], 2, ',', '.'); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <h1 class="titulo1">Você ainda não tem produtos finalizados.</h1>
    <?php endif; ?>

    <a href="index.php">Voltar para a Página Inicial</a>
</div>


</body>
</html>
