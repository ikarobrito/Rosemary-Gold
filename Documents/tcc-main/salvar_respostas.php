<?php
session_start();
include('conexao.php');
mysqli_set_charset($conexao, "utf8");

$cliente_email = $_COOKIE['email'];

// Verifica se o cookie de resposta já está definido
if (isset($_COOKIE['respondeu_formulario']) && $_COOKIE['respondeu_formulario'] == '1') {
    $response = array("success" => false, "error" => "Você já respondeu o formulário.");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$perfume_id = null; // Insira o ID do perfume, se aplicável

// Captura das respostas do formulário
$estacao = isset($_POST['estacao']) ? $_POST['estacao'] : null;
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;
$intensidade = isset($_POST['intensidade']) ? $_POST['intensidade'] : null;
$notas = isset($_POST['notas']) ? implode(", ", $_POST['notas']) : null;
$ocasiao = isset($_POST['ocasiao']) ? $_POST['ocasiao'] : null;
$durabilidade = isset($_POST['durabilidade']) ? $_POST['durabilidade'] : null;

// Adiciona logs para depuração
error_log("Dados do formulário recebidos:");
error_log("cliente_email: $cliente_email");
error_log("perfume_id: $perfume_id");
error_log("estacao: $estacao");
error_log("sexo: $sexo");
error_log("intensidade: $intensidade");
error_log("notas: $notas");
error_log("ocasiao: $ocasiao");
error_log("durabilidade: $durabilidade");

// Prepara a declaração SQL
$sql = "INSERT INTO respostas_formulario (cliente_email, perfume_id, estacao, sexo, intensidade, notas, ocasiao, durabilidade)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    // Binda os parâmetros
    mysqli_stmt_bind_param($stmt, "ssssssss", $cliente_email, $perfume_id, $estacao, $sexo, $intensidade, $notas, $ocasiao, $durabilidade);

    // Executa a declaração
    if (mysqli_stmt_execute($stmt)) {
        // Definindo o cookie para que o formulário não seja mais exibido para este usuário
        setcookie('respondeu_formulario', '1', time() + (86400 * 30), "/"); // Expira em 30 dias
        
        // Sucesso - prepara resposta e redireciona
        $response = array("success" => true, "message" => "Respostas salvas com sucesso.");
        error_log("Respostas salvas com sucesso.");
        header("Location: formulario_concluido.php"); // Redireciona para página de agradecimento
        exit;
    } else {
        $response = array("success" => false, "error" => "Erro ao executar a declaração SQL: " . mysqli_error($conexao));
        error_log("Erro ao executar a declaração SQL: " . mysqli_error($conexao));
        http_response_code(500); // Adiciona código de status HTTP 500 para erro interno do servidor
    }

    // Fecha a declaração
    mysqli_stmt_close($stmt);
} else {
    $response = array("success" => false, "error" => "Erro ao preparar a declaração SQL: " . mysqli_error($conexao));
    error_log("Erro ao preparar a declaração SQL: " . mysqli_error($conexao));
    http_response_code(500); // Adiciona código de status HTTP 500 para erro interno do servidor
}

// Adiciona logs para depuração
error_log("Resposta final:");
error_log(print_r($response, true));

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formulario.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Formulário</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="logo"> 
        <img src="img/logo4.png" alt="logo" class="logo1">
    </div>
    <div class="container">
        <div class="form">
            <div class="form-header">
                <!-- Adicione um bloco para a mensagem final -->
                <div id="mensagem-final" class="title">
                    <h1>Formulário concluído! Obrigado!</h1>
                    <p>Clique nos links abaixo:</p>
                    <p><a href="perfumes_relacionados.php">Ver Perfumes Recomendados</a></p>
                    <p><a href="index.php">Voltar para o Início</a></p>
                </div>
            </div>
        </div>
    </div>
</html>