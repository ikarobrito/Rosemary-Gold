<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

error_log("Script foi chamado (favoritos)");

include('conexao.php');

// Função para atualizar a imagem na página inicial
function atualizarImagemPaginaInicial($perfumeId) {
    // Aguarde até que o documento esteja completamente carregado
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var coracaoImg = window.opener.document.querySelector('.coracao[data-perfume-id=\"$perfumeId\"]');
            if (coracaoImg && coracaoImg.src) {
                coracaoImg.src = 'img/coracao-vazio.png';
            } else {
                console.error('CoracaoImg ou coracaoImg.src é null:', coracaoImg);
            }
        });
    </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Recebido POST (favoritos)");

    $perfume_id = mysqli_real_escape_string($conexao, $_POST['perfume_id']);
    $cliente_email = $_COOKIE['email'];

    error_log("Perfume ID (favoritos): $perfume_id");
    error_log("Cliente Email (favoritos): $cliente_email");

    // Verifique se já existe uma entrada na tabela 'favoritos' para o cliente e o perfume em questão
    $checkQuery = "SELECT * FROM favoritos WHERE cliente_email = '$cliente_email' AND perfume_id = '$perfume_id'";
    $checkResult = mysqli_query($conexao, $checkQuery);

    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            // Se existe uma entrada, remova o favorito
            $deleteQuery = "DELETE FROM favoritos WHERE cliente_email = '$cliente_email' AND perfume_id = '$perfume_id'";
            $deleteResult = mysqli_query($conexao, $deleteQuery);

            if ($deleteResult) {
                echo "Operação realizada com sucesso";
                atualizarImagemPaginaInicial($perfume_id); // Atualiza a imagem na página inicial
            } else {
                echo "Erro ao remover favorito do banco de dados: " . mysqli_error($conexao);
            }
        } else {
            echo "Não há favorito para remover";
        }
    } else {
        echo "Erro na verificação no banco de dados: " . mysqli_error($conexao);
    }
}
?>
