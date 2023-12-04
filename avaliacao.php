<?php
function isFavorito($perfume_id) {
    $favoritos = isset($_COOKIE['favoritos']) ? json_decode($_COOKIE['favoritos']) : [];
    return in_array($perfume_id, $favoritos);
}

session_start();
header("Content-type: text/html; charset=utf-8");
include("conexao.php");
mysqli_set_charset($conexao, "utf8");
$id = $_GET['id'];
$sqlperfume = "SELECT * FROM perfume WHERE id = '{$id}'";
$result = mysqli_query($conexao, $sqlperfume);
$nome = mysqli_fetch_assoc($result);

$nomeCliente = isset($_COOKIE['nome']) ? $_COOKIE['nome'] : '';

// Se o formulário de comentário for enviado e o cliente estiver logado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_COOKIE['email'])) {
    $nomeUsuario = isset($_POST['nome']) ? $_POST['nome'] : $nomeCliente;
    $emailUsuario = isset($_POST['email']) ? $_POST['email'] : $_COOKIE['email'];
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
    $idPerfume = isset($nome['id']) ? $nome['id'] : '';

    // Verifica se o cliente está logado antes de inserir o comentário
    if (isset($_COOKIE['email'])) {
        // Inserir o comentário no banco de dados
        $sqlComentario = "INSERT INTO comentarios (nome, email, comentario, id_perfume) VALUES ('$nomeUsuario', '$emailUsuario', '$comentario', '$idPerfume')";
        mysqli_query($conexao, $sqlComentario);

        // Redirecionar para evitar o reenvio do formulário
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}

// Obtém os comentários existentes
$sqlComentarios = "SELECT * FROM comentarios WHERE id_perfume = '{$id}'";
$resultComentarios = mysqli_query($conexao, $sqlComentarios);
$comentarios = [];

while ($comentario = mysqli_fetch_assoc($resultComentarios)) {
    $comentarios[] = $comentario;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/avaliacao.css">
    <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $nome['nome']; ?></title>

    <script>
        function link() {
            window.location.href = "./index.php";
        }
    </script>

    <script>
        setTimeout(function () {
            $('.msgbox').fadeOut("slow");
        }, 3000);
    </script>

<script>
    // Função para obter favoritos dos cookies
    function getFavoritosFromCookies() {
        var favoritosCookie = getCookie('favoritos');
        return favoritosCookie ? JSON.parse(favoritosCookie) : [];
    }

    // Função para salvar favoritos nos cookies
    function saveFavoritosToCookies(favoritos) {
        setCookie('favoritos', JSON.stringify(favoritos), 365);
    }

    // Função para configurar um cookie
    function setCookie(name, value, days) {
        var expires = '';
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }

    // Função para obter um cookie pelo nome
    function getCookie(name) {
        var nameEQ = name + '=';
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) == ' ') cookie = cookie.substring(1, cookie.length);
            if (cookie.indexOf(nameEQ) == 0) return cookie.substring(nameEQ.length, cookie.length);
        }
        return null;
    }

    
        // Função para verificar se um usuário favoritou um perfume
        function isUserFavorito(perfume_id) {
        var userEmail = "<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>";
        if (userEmail) {
            // Aqui você pode fazer uma chamada AJAX para verificar no lado do servidor se o usuário favoritou o perfume
            // Exemplo:
            // $.ajax({
            //     type: 'POST',
            //     url: 'verificar_favorito.php',
            //     data: { perfume_id: perfume_id, userEmail: userEmail },
            //     success: function(response) {
            //         console.log(response);
            //     },
            //     error: function(error) {
            //         console.error(error);
            //     }
            // });

            // Por enquanto, vamos apenas simular que o usuário favoritou, você precisará implementar a lógica real no servidor
            return true;
        }
        return false;
    }

    // Função para verificar se um perfume está nos favoritos
    function isFavorito(perfume_id) {
        var favoritos = getFavoritosFromCookies();
        return favoritos.includes(perfume_id.toString());
    }

    // Função para lidar com a ação de favoritar/desfavoritar
    function handleFavorito(perfume_id) {
    var isLoggedIn = <?php echo isset($_COOKIE["email"]) ? 'true' : 'false'; ?>;
    if (!isLoggedIn) {
        alert('Faça login para favoritar perfumes.');
        return;
    }

        var favoritos = getFavoritosFromCookies();
        var index = favoritos.indexOf(perfume_id.toString());

        if (index === -1) {
            favoritos.push(perfume_id.toString());
            saveFavoritosToCookies(favoritos);
            saveFavorito(perfume_id, true);
            alert('Perfume adicionado aos favoritos!');
        } else {
            favoritos.splice(index, 1);
            saveFavoritosToCookies(favoritos);
            removerFavoritoNaPaginaInicial(perfume_id);
            alert('Perfume removido dos favoritos!');
        }

        updateHeartImage(perfume_id);
    }
    
    function removerFavoritoNaPaginaInicial(perfumeId) {
    console.log('Removendo favorito para perfume_id:', perfumeId);
    $.ajax({
        type: 'POST',
        url: 'remover_favorito.php',
        data: { perfume_id: perfumeId },
        success: function(response) {
            console.log(response);
            // Verifique se a função está sendo chamada
            console.log('Chamando atualizarImagemPaginaInicial');
            atualizarImagemPaginaInicial(perfumeId);


        },
        error: function(error) {
            console.error(error);
        }
    });
}

function atualizarImagemPaginaInicial(perfumeId) {
    console.log('Chamando atualizarImagemPaginaInicial para perfumeId:', perfumeId);
    // Aguarde até que o documento esteja completamente carregado
    document.addEventListener('DOMContentLoaded', function() {
    var isLoggedIn = <?php echo isset($_COOKIE["email"]) ? 'true' : 'false'; ?>;
    if (!isLoggedIn) {
        // Define todas as imagens de coração como vazias se o usuário não estiver logado
        var coracoes = document.querySelectorAll('.coracao');
        coracoes.forEach(function(coracaoImg) {
            coracaoImg.src = 'img/coracao-vazio.png';
        });
    }
});
}

function removerFavorito(perfume_id) {
    $.ajax({
    type: 'POST',
    url: 'remover_favorito.php',
    data: { perfume_id: perfumeId },
    success: function(response) {
        console.log(response);
        atualizarImagemPaginaInicial(perfumeId);
    },
    error: function(error) {
        console.error(error);
    }
});
}

// Função para salvar o favorito no banco de dados
function saveFavorito(perfume_id, isFavorito) {
    $.ajax({
        type: 'POST',
        url: 'salvar_favorito.php', // Altere para o caminho correto do seu script de salvar favorito
        data: { perfume_id: perfume_id, isFavorito: isFavorito },
        success: function(response) {
            console.log(response); // Exiba a resposta do servidor no console
        },
        error: function(error) {
            console.error(error); // Exiba erros no console, se houver
        }
    });
}

    // Função para atualizar a imagem do coração
    function updateHeartImage(perfume_id) {
        var coracaoImg = document.querySelector('.coracao[data-perfume-id="' + perfume_id + '"]');
        if (coracaoImg) {
            var isFav = isFavorito(perfume_id);
            coracaoImg.src = 'img/' + (isFav ? 'coracao-cheio.png' : 'coracao-vazio.png');
            coracaoImg.setAttribute('data-favorito', isFav ? 'true' : 'false');
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
            <button class="search-btn search-txt" name="pesquisar" type="submit">
                <img src="img/lupa.png" alt="lupa" height="20" width="20">
            </button>
        </form>

        <div class="icon">
            <a href="carrinho.php"> <img src="img/bolsa-de-compras (1).png" alt="icon" class="sacola"></a>
        </div>
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
            $sqlcliente = "SELECT nome FROM cliente WHERE email = '$email'";
            $resultcliente = $conexao->query($sqlcliente);

            if ($resultcliente->num_rows > 0) {
                // Se houver resultados, obtém o nome
                $row = $resultcliente->fetch_assoc();
                $nomeCliente = $row["nome"];
                $mostrar2 = "<a href=perfil.php>Bem vindo, $nomeCliente</a>";
            }
        } else {
            $mostrar2 = "<a class='login-button' href='cadastro.php' type='submit'>Criar Conta</a>";
        }
        echo $mostrar2;
        ?>
    </div>

    <div class="container2">
    <section class="container2">

    <?php
    // Função para verificar se um usuário favoritou um perfume
function isUserFavorito($perfume_id, $userEmail, $conexao) {
    $query = "SELECT * FROM favoritos WHERE cliente_email = '$userEmail' AND perfume_id = $perfume_id";
    $result = mysqli_query($conexao, $query);
    return mysqli_num_rows($result) > 0;
}

    foreach ($result as $show) {
        $perfume_id = $show['id'];
        $isLoggedIn = isset($_COOKIE["email"]);
        $isUserFavorito = false;
        
        if ($isLoggedIn) {
            $userEmail = $_COOKIE["email"];
            $isUserFavorito = isUserFavorito($perfume_id, $userEmail, $conexao);
        }        
    ?>

    <div class="card">
        <img src="<?php echo $show['imagem1']; ?>" alt="" class="imagem">
    </div>
    <div class="card2">
        <img src="img/<?php echo ($isUserFavorito ? 'coracao-cheio.png' : 'coracao-vazio.png'); ?>" alt="icon" class="coracao" data-perfume-id="<?php echo $perfume_id; ?>" onclick="handleFavorito(<?php echo $perfume_id; ?>);">
        <h2><?php echo $show['nome'] . ' - ' . $show['marca']; ?></h2>
        <p class="card2-texto">R$ <?php echo $show['preco']; ?></p>

        <?php
        // Se o cliente estiver logado, exibe o botão de adicionar ao carrinho
        if (isset($_COOKIE['email'])) {
            echo '<a href="carrinho.php?acao=add&id=' . $show['id'] . '">Adicionar ao carrinho</a>
                <p class="card2-texto2">Frete grátis para todo Brasil!</p>';
        } else {
            echo '<p class="card2-texto2">Faça login para adicionar ao carrinho</p>
                <p class="card2-texto2">Frete grátis para todo Brasil!</p>';
        }
        ?>
    </div>

    <?php
    }
    echo '</section>

    <div class="titulo">Descrição do perfume</div>
    <div class="descricao"><p> ' . $nome['descricao'] . '</p></div>';
    ?>
</div>


<?php
// Exibe o formulário de comentários para todos os usuários
echo '<div class="comentario">
        <div class="form_box">
            <h2 class="title">Deixe sua avaliação</h2>
            <form action="" method="post">';

// Se o cliente estiver logado, preenche automaticamente o nome e email
if (isset($_COOKIE['email'])) {
    echo '<input type="text" name="nome" placeholder="Digite seu nome" value="' . $nomeCliente . '">
          <input type="email" name="email" placeholder="Digite seu e-mail" value="' . $_COOKIE['email'] . '" readonly>';
} else {
    echo '<input type="text" name="nome" placeholder="Digite seu nome">
          <input type="email" name="email" placeholder="Digite seu e-mail">';
}

echo '<textarea name="comentario" placeholder="Digite seu comentário"></textarea>
        <button type="submit">Enviar comentário</button>
    </form>
</div>
</div>';

// Exibe os comentários existentes
if (!empty($comentarios)) {
    echo '<div class="comentarios-existentes">
            <h2>Comentários existentes:</h2>';

    foreach ($comentarios as $comentario) {
        echo '<div class="comentario-item">
                <p><strong>' . $comentario['nome'] . '</strong> - ' . $comentario['comentario'] . '</p>
            </div>';
    }

    echo '</div>';
}

        ?>
    </div>
</body>

</html>