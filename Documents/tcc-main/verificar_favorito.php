<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['cliente_id'])) {
        $cliente_id = $_SESSION['cliente_id'];
        $perfume_id = $_POST['perfume_id'];

        // Verifica se o perfume já está nos favoritos
        $checkFavoritoQuery = "SELECT * FROM favoritos WHERE cliente_id = $cliente_id AND perfume_id = $perfume_id";
        $checkFavoritoResult = $conexao->query($checkFavoritoQuery);

        if ($checkFavoritoResult) {
            if ($checkFavoritoResult->num_rows > 0) {
                // Se o perfume já estiver nos favoritos, remove
                $removeFavoritoQuery = "DELETE FROM favoritos WHERE cliente_id = $cliente_id AND perfume_id = $perfume_id";
                $removeResult = $conexao->query($removeFavoritoQuery);

                if ($removeResult) {
                    echo 'success';
                } else {
                    echo 'error_remove';
                }
            } else {
                // Se o perfume não estiver nos favoritos, adiciona
                $addFavoritoQuery = "INSERT INTO favoritos (cliente_id, perfume_id) VALUES ($cliente_id, $perfume_id)";
                $addResult = $conexao->query($addFavoritoQuery);

                if ($addResult) {
                    echo 'success';
                } else {
                    echo 'error_add';
                }
            }
        } else {
            echo 'error_check';
        }
    } else {
        // Se o usuário não estiver logado, retorna erro
        echo 'error_session';
    }
} else {
    // Se a requisição não for do tipo POST, retorna erro
    echo 'error_request';
}
?>
