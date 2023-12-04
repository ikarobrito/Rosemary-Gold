<?php header("Content-type: text/html; charset=utf-8");
session_start();
include('conexao.php');
mysqli_set_charset($conexao, "utf8");
$pesquisa = $_POST['pesquisar'];

$consulta = "SELECT * FROM perfume 
WHERE nome LIKE '%$pesquisa%'  
OR marca LIKE '%$pesquisa%'
OR sexo LIKE '%$pesquisa%'
OR preco LIKE '%$pesquisa%'
OR durabilidade LIKE '%$pesquisa%'
OR notas LIKE '%$pesquisa%'
OR intensidade LIKE '%$pesquisa%'
OR ocasiao LIKE '%$pesquisa%'
OR estacao LIKE '%$pesquisa%'
OR descricao LIKE '%$pesquisa%'";
$result = mysqli_query($conexao, $consulta);
mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Produto</title>
    <link rel="stylesheet" href="css/feminino.css">
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

        

    </div>

 

    <p class="titulo1"><b>Mostrando resultados para '<?php echo $pesquisa; ?>'</b></p>

        
        <div class="container2">
            <?php
            foreach ($result as $show) {
                $nome = $show['nome'];
                echo '
                
            
            <div class="card">
            <img src="img/coracao-vazio.png" class="coracao">
            <img src="' . $show['imagem1'] . '" class="imagem" alt="" />
            <h2 class="card-titulo1"> ' . $show['nome'] . ' </h2>
            <p class="card-texto1">' . $show['marca'] . '</p>
            <p class="card-texto2">R$' . $show['preco'] . '</p>
            <a href="avaliacao.php?id=' . $show['id'] . '">Saiba Mais</a>
        </div>
        ';
            }
            ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</body>

</html>