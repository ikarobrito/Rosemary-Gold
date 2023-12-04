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
        var coracaoImg = document.querySelector('.coracao[data-perfume-id="' + perfumeId + '"]');
        if (coracaoImg) {
            console.log('Encontrou a imagem:', coracaoImg);
            coracaoImg.src = 'img/coracao-vazio.png';
        } else {
            console.error('CoracaoImg ou coracaoImg.src é null:', coracaoImg);
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


    /// Função para salvar o favorito no banco de dados
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
