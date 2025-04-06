<?php
session_start();
include('conexao.php');
mysqli_set_charset($conexao, "utf8");

// Verifica se o cliente está logado
if (!isset($_COOKIE['email'])) {
    // Se o cliente não estiver logado, redireciona para a página de login
    header('Location: login.php');
    exit;
}

$cliente_email = $_COOKIE['email'];

// Recupera as respostas atuais do banco de dados
$sql = "SELECT * FROM respostas_formulario WHERE cliente_email = ?";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $cliente_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $cliente_email, $perfume_id, $estacao, $sexo, $intensidade, $frutas, $ocasiao, $durabilidade);

    // Se o cliente não tiver respostas no banco de dados, redireciona para o formulário inicial
    if (!mysqli_stmt_fetch($stmt)) {
        header('Location: formulario.php');
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    // Trate erros ao preparar a declaração SQL
    echo "Erro ao preparar a declaração SQL: " . mysqli_error($conexao);
    exit;
}

// Processa as alterações enviadas pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_estacao = isset($_POST['estacao']) ? $_POST['estacao'] : $estacao;
    // Adicione processamento para outros campos do formulário

    // Atualiza os dados no banco de dados
    $sql_update = "UPDATE respostas_formulario SET estacao = ?, sexo = ?, intensidade = ?, notas = ?, ocasiao = ?, durabilidade = ? WHERE cliente_email = ?";
    $stmt_update = mysqli_prepare($conexao, $sql_update);

    if ($stmt_update) {
        mysqli_stmt_bind_param($stmt_update, "sssssss", $nova_estacao, $sexo, $intensidade, $frutas, $ocasiao, $durabilidade, $cliente_email);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);

        // Exibir mensagem de confirmação
        $confirmacao_mensagem = "Alterações salvas com sucesso!";
    } else {
        // Trate erros ao preparar a declaração SQL de atualização
        echo "Erro ao preparar a declaração SQL de atualização: " . mysqli_error($conexao);
        exit;
    }
}

mysqli_close($conexao);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formulario.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Alterar Respostas</title>
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
                <?php if (isset($confirmacao_mensagem)): ?>
                    <!-- Exibir mensagem de confirmação -->
                    <div id="confirmacao" class="title">
                        <h1><?php echo $confirmacao_mensagem; ?></h1>
                        <p>Clique nos links abaixo:</p>
                        <p><a href="ver_perfumes_recomendados.php">Ver Perfumes Recomendados</a></p>
                        <p><a href="index.php">Voltar para o Início</a></p>
                    </div>
                <?php else: ?>
                    <!-- Formulário de Alteração -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="title">
                            <h1>Qual é a sua estação do ano favorita?</h1>
                            <input type="radio" name="estacao" value="Inverno" <?php echo ($estacao === "Inverno") ? "checked" : ""; ?>> Inverno
                            <input type="radio" name="estacao" value="Verão" <?php echo ($estacao === "Verão") ? "checked" : ""; ?>> Verão
                            <input type="radio" name="estacao" value="Outono" <?php echo ($estacao === "Outono") ? "checked" : ""; ?>> Outono
                            <input type="radio" name="estacao" value="Primavera" <?php echo ($estacao === "Primavera") ? "checked" : ""; ?>> Primavera
                        </div>
                        <!-- Adicione outros campos do formulário conforme necessário -->
                        <div>
                            <input type="submit" value="Salvar Alterações">
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
