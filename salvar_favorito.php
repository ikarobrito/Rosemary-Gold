<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

error_log("Script salvar_favorito.php foi chamado.");

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perfume_id = mysqli_real_escape_string($conexao, $_POST['perfume_id']);
    $cliente_email = $_COOKIE['email'];

    // Verifique se já existe uma entrada na tabela 'favoritos' para o cliente e o perfume em questão
    $checkQuery = "SELECT * FROM favoritos WHERE cliente_email = '$cliente_email' AND perfume_id = '$perfume_id'";
    $checkResult = mysqli_query($conexao, $checkQuery);

    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            // Se existe uma entrada, atualize o registro
            $row = mysqli_fetch_assoc($checkResult);
            $favorito_id = $row['id'];
            $updateQuery = "UPDATE favoritos SET cliente_email = '$cliente_email', perfume_id = '$perfume_id' WHERE id = '$favorito_id'";
            mysqli_query($conexao, $updateQuery);
            echo "Operação realizada com sucesso";
        } else {
            // Se não existe uma entrada, insira uma nova
            $insertQuery = "INSERT INTO favoritos (cliente_email, perfume_id) VALUES ('$cliente_email', '$perfume_id')";
            mysqli_query($conexao, $insertQuery);
            echo "Operação realizada com sucesso";
        }
    } else {
        echo "Erro na verificação no banco de dados: " . mysqli_error($conexao);
    }
}
?>
