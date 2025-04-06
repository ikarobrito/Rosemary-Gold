
<?php

function isFavorito($perfume_id) {
    $favoritos = isset($_COOKIE['favoritos']) ? json_decode($_COOKIE['favoritos']) : [];
    return in_array($perfume_id, $favoritos);
}

session_start();
include('conexao.php');	
mysqli_set_charset($conexao, "utf8");



if(isset($_SESSION['msgv'])){
	session_destroy();
	if(isset($_COOKIE['emailv'])){
		setcookie("emailv", "", time() - 3600);
	}
}

$importadom= 'SELECT * FROM perfume WHERE tipo = "importadom"';
$oboticariom= 'SELECT * FROM perfume WHERE tipo = "oboticariom"';
$naturam= 'SELECT * FROM perfume WHERE tipo = "naturam"';
$eudoram= 'SELECT * FROM perfume WHERE tipo = "eudoram"';
$jequitim= 'SELECT * FROM perfume WHERE tipo = "jequitim"';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https: //fonts.googleapis.com/css2?family= Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/masculino.css">
        <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="UTF-8"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rosemary Gold | Masculino </title>
        <script>
            function link(){
                window.location = "./index.php"
            }
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
        // Adicionar o perfume aos favoritos
        favoritos.push(perfume_id.toString());
        saveFavoritosToCookies(favoritos); // Salvar favoritos nos cookies
        saveFavorito(perfume_id, true); // Adicionar favorito no banco de dados
        //alert('Perfume adicionado aos favoritos!');
    } else {
        // Remover o perfume dos favoritos
        favoritos.splice(index, 1);
        saveFavoritosToCookies(favoritos); // Salvar favoritos nos cookies
        saveFavorito(perfume_id, false); // Remover favorito no banco de dados
        //alert('Perfume removido dos favoritos!');
    }

    // Atualizar a imagem do coração após a ação
    updateHeartImage(perfume_id);
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

        // Nova função para remover favorito na página inicial
        function removerFavoritoNaPaginaInicial(perfume_id) {
            $.ajax({
                type: 'POST',
                url: 'index.php', // Substitua pelo caminho correto da sua página inicial
                data: { remover_favorito: perfume_id },
                success: function(response) {
                    console.log(response); // Exiba a resposta do servidor no console
                },
                error: function(error) {
                    console.error(error); // Exiba erros no console, se houver
                }
            });
        }

        // Função para salvar o favorito no banco de dados
        function saveFavorito(perfume_id, isFavorito) {
            $.ajax({
                type: 'POST',
                url: 'salvar_favorito.php', // Substitua pelo caminho correto do seu script PHP
                data: { perfume_id: perfume_id, isFavorito: isFavorito },
                success: function(response) {
                    console.log(response); // Exiba a resposta do servidor no console
                },
                error: function(error) {
                    console.error(error); // Exiba erros no console, se houver
                }
            });
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


<!--inicio cards-->
</div>

<?php
// Função para verificar se um usuário favoritou um perfume
function isUserFavorito($perfume_id, $userEmail, $conexao) {
    $query = "SELECT * FROM favoritos WHERE cliente_email = '$userEmail' AND perfume_id = $perfume_id";
    $result = mysqli_query($conexao, $query);
    return mysqli_num_rows($result) > 0;
}

// Importado
$result = mysqli_query($conexao, $importadom);
echo '<p class="titulo1"><b>Melhores Perfumes Importados</b></p>';
echo '<section class="container2">';
foreach ($result as $show) {
    $perfume_id = $show['id'];
    $isLoggedIn = isset($_COOKIE["email"]);
    $isUserFavorito = false;

    if ($isLoggedIn) {
        $userEmail = $_COOKIE["email"];
        $isUserFavorito = isUserFavorito($perfume_id, $userEmail, $conexao);
    }

    echo '
    <div class="card">
        <img src="img/' . ($isUserFavorito ? 'coracao-cheio.png' : 'coracao-vazio.png') . '" alt="icon" class="coracao" data-perfume-id="' . $perfume_id . '" onclick="handleFavorito(' . $perfume_id . ');">
        <img src="' . $show["imagem1"] . '" class="imagem">
        <h2 class="card-titulo1">' . $show['nome'] . '</h2>
        <p class="card-texto1">' . $show['marca'] . ' </p>
        <p class="card-texto2">R$' . $show['preco'] . '</p>
        <a href="avaliacao.php?id=' . $perfume_id . '">Saiba Mais</a>
    </div>';
}
echo '</section>';


// O boticario
$result = mysqli_query($conexao, $oboticariom);
echo '<p class="titulo1"><b>Melhores Perfumes O Boticário</b></p>';
echo '<section class="container2">';
foreach ($result as $show) {
    $perfume_id = $show['id'];
    $isLoggedIn = isset($_COOKIE["email"]);
    $isUserFavorito = false;

    if ($isLoggedIn) {
        $userEmail = $_COOKIE["email"];
        $isUserFavorito = isUserFavorito($perfume_id, $userEmail, $conexao);
    }

    echo '
    <div class="card">
        <img src="img/' . ($isUserFavorito ? 'coracao-cheio.png' : 'coracao-vazio.png') . '" alt="icon" class="coracao" data-perfume-id="' . $perfume_id . '" onclick="handleFavorito(' . $perfume_id . ');">
        <img src="' . $show["imagem1"] . '" class="imagem">
        <h2 class="card-titulo1">' . $show['nome'] . '</h2>
        <p class="card-texto1">' . $show['marca'] . ' </p>
        <p class="card-texto2">R$' . $show['preco'] . '</p>
        <a href="avaliacao.php?id=' . $perfume_id . '">Saiba Mais</a>
    </div>';
}
echo '</section>';

// Natura
$result = mysqli_query($conexao, $naturam);
echo '<p class="titulo1"><b>Melhores Perfumes Natura</b></p>';
echo '<section class="container2">';
foreach ($result as $show) {
    $perfume_id = $show['id'];
    $isLoggedIn = isset($_COOKIE["email"]);
    $isUserFavorito = false;

    if ($isLoggedIn) {
        $userEmail = $_COOKIE["email"];
        $isUserFavorito = isUserFavorito($perfume_id, $userEmail, $conexao);
    }

    echo '
    <div class="card">
        <img src="img/' . ($isUserFavorito ? 'coracao-cheio.png' : 'coracao-vazio.png') . '" alt="icon" class="coracao" data-perfume-id="' . $perfume_id . '" onclick="handleFavorito(' . $perfume_id . ');">
        <img src="' . $show["imagem1"] . '" class="imagem">
        <h2 class="card-titulo1">' . $show['nome'] . '</h2>
        <p class="card-texto1">' . $show['marca'] . ' </p>
        <p class="card-texto2">R$' . $show['preco'] . '</p>
        <a href="avaliacao.php?id=' . $perfume_id . '">Saiba Mais</a>
    </div>';
}
echo '</section>';

// Eudora
$result = mysqli_query($conexao, $eudoram);
echo '<p class="titulo1"><b>Melhores Perfumes Eudora</b></p>';
echo '<section class="container2">';
foreach ($result as $show) {
    $perfume_id = $show['id'];
    $isLoggedIn = isset($_COOKIE["email"]);
    $isUserFavorito = false;

    if ($isLoggedIn) {
        $userEmail = $_COOKIE["email"];
        $isUserFavorito = isUserFavorito($perfume_id, $userEmail, $conexao);
    }

    echo '
    <div class="card">
        <img src="img/' . ($isUserFavorito ? 'coracao-cheio.png' : 'coracao-vazio.png') . '" alt="icon" class="coracao" data-perfume-id="' . $perfume_id . '" onclick="handleFavorito(' . $perfume_id . ');">
        <img src="' . $show["imagem1"] . '" class="imagem">
        <h2 class="card-titulo1">' . $show['nome'] . '</h2>
        <p class="card-texto1">' . $show['marca'] . ' </p>
        <p class="card-texto2">R$' . $show['preco'] . '</p>
        <a href="avaliacao.php?id=' . $perfume_id . '">Saiba Mais</a>
    </div>';
}
echo '</section>';

// Jequiti
$result = mysqli_query($conexao, $jequitim);
echo '<p class="titulo1"><b>Melhores Perfumes Jequiti</b></p>';
echo '<section class="container2">';
foreach ($result as $show) {
    $perfume_id = $show['id'];
    $isLoggedIn = isset($_COOKIE["email"]);
    $isUserFavorito = false;

    if ($isLoggedIn) {
        $userEmail = $_COOKIE["email"];
        $isUserFavorito = isUserFavorito($perfume_id, $userEmail, $conexao);
    }

    echo '
    <div class="card">
        <img src="img/' . ($isUserFavorito ? 'coracao-cheio.png' : 'coracao-vazio.png') . '" alt="icon" class="coracao" data-perfume-id="' . $perfume_id . '" onclick="handleFavorito(' . $perfume_id . ');">
        <img src="' . $show["imagem1"] . '" class="imagem">
        <h2 class="card-titulo1">' . $show['nome'] . '</h2>
        <p class="card-texto1">' . $show['marca'] . ' </p>
        <p class="card-texto2">R$' . $show['preco'] . '</p>
        <a href="avaliacao.php?id=' . $perfume_id . '">Saiba Mais</a>
    </div>';
}
echo '</section>';
?>

<!--inicio footer-->
<footer>
    <div class="container-footer">
        <div class="row-footer">
            <!--footer-col inicio-->
            <div class="footer-col">
                <h4>Categorias</h4>
                <ul>
                    <li> <a href="feminino.php"> Feminino</a> </li>
                    <li> <a href="masculino.php"> Masculino</a> </li>
                    <li> <a href="unissex.php"> Unissex</a> </li>
                    <li> <a href="infantil.php"> Infantil</a> </li>
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
                    <li> <a href=""> Tendências</a> </li>
                    <li> <a href=""> Mais vendidos</a> </li>
                    <li> <a href=""> seilaseila </a> </li>
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

