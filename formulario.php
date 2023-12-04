<?php
session_start();
include('conexao.php');
mysqli_set_charset($conexao, "utf8");

// Verifica se o cliente está logado pelo email
if (!isset($_COOKIE["email"])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver logado
    exit;
}

$cliente_email = $_COOKIE["email"];

// Verifica se o cliente já respondeu ao formulário
$sql_verifica_respostas = "SELECT COUNT(*) as total FROM respostas_formulario WHERE cliente_email = ?";
$stmt_verifica_respostas = mysqli_prepare($conexao, $sql_verifica_respostas);

if ($stmt_verifica_respostas) {
    mysqli_stmt_bind_param($stmt_verifica_respostas, "s", $cliente_email);
    mysqli_stmt_execute($stmt_verifica_respostas);
    $result_verifica_respostas = mysqli_stmt_get_result($stmt_verifica_respostas);
    $total_respostas = mysqli_fetch_assoc($result_verifica_respostas)['total'];

    mysqli_stmt_close($stmt_verifica_respostas);

    // Se o cliente já respondeu ao formulário, exibe um alerta e redireciona para a página principal
    if ($total_respostas > 0) {
        echo '<script>';
        echo 'alert("Você já respondeu o formulário.");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formulario.css">
    <link href="https: //fonts.googleapis.com/css2?family= Cinzel:wght@400;500 ; 600 & display=swap" rel="stylesheet">
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
            <form id="formulario" method="post" action="salvar_respostas.php" enctype="multipart/form-data">
                <div class="form-header">
                    <div class="title" id="pergunta1">
                        <h1>Qual é a sua estação do ano favorita?</h1><br><br>
                        <input type="radio" name="estacao" value="Inverno"> Inverno<br>
                        <input type="radio" name="estacao" value="Verão"> Verão<br>
                        <input type="radio" name="estacao" value="Outono"> Outono<br>
                        <input type="radio" name="estacao" value="Primavera"> Primavera
                    </div>

                    <div class="title hidden" id="pergunta2">
                        <h1>Você tem alguma preferência por perfumes masculino, feminino ou unissex?</h1><br><br>
                        <input type="radio" name="sexo" value="Masculino"> Masculino<br>
                        <input type="radio" name="sexo" value="Feminino"> Feminino<br>
                        <input type="radio" name="sexo" value="Unissex"> Unissex
                    </div>

                    <div class="title hidden" id="pergunta3">
                        <h1>Você prefere perfumes mais suaves e discretos ou fragrâncias mais intensas e marcantes?</h1><br><br>
                        <input type="radio" name="intensidade" value="Suave"> Suave<br>
                        <input type="radio" name="intensidade" value="Intenso"> Intenso
                    </div>

                    <div class="title hidden" id="pergunta4">
                        <h1>Gosta de notas de frutas em seus perfumes? Se sim, quais frutas você mais gosta?</h1><br><br>
                        <input type="checkbox" name="notas[]" value="Notas Cítricas"> Cítricas<br>
                        <input type="checkbox" name="notas[]" value="Frutas Vermelhas"> Frutas Vermelhas<br>
                        <input type="checkbox" name="notas[]" value="Notas Tropicais"> Tropicais<br>
                        <input type="checkbox" name="notas[]" value="Notas Silvestres"> Silvestres
                    </div>

                    <div class="title hidden" id="pergunta5">
                        <h1>Você gostaria que seu perfume fosse mais apropriado para uso diurno ou noturno?</h1><br><br>
                        <input type="radio" name="ocasiao" value="Diurno"> Diurno<br>
                        <input type="radio" name="ocasiao" value="Noturno"> Noturno<br>
                        <input type="radio" name="ocasiao" value="Ambos"> Ambos
                    </div>

                    <div class="title hidden" id="pergunta6">
                        <h1>Você prefere fragrâncias que durem o dia todo ou está mais interessado em opções mais leves e discretas?</h1><br><br>
                        <input type="radio" name="durabilidade" value="Duradouro"> Duradouro<br>
                        <input type="radio" name="durabilidade" value="Leves e discretas"> Leves e discretas
                    </div>
                </div>

                  <!-- Adicione um campo escondido para marcar o envio automático -->
                  <input type="hidden" name="envio_automatico" id="envio_automatico" value="0">

                    <div class="continue-button">
                        <button type="button" onclick="proximaPergunta()"><a href="">Continuar</button>
                    </div>
                    <div class="continue-button1">
                        <button type="button" onclick="anteriorPergunta()"><a href="">Voltar</button>                    
                    </div>
                </div>
            </form>

<script>
let perguntaAtual = 1;

function proximaPergunta() {
const perguntaAtualElement = document.getElementById(`pergunta${perguntaAtual}`);
if (perguntaAtualElement) {
    perguntaAtualElement.classList.add('hidden');
    perguntaAtual++;

    const proximaPerguntaElement = document.getElementById(`pergunta${perguntaAtual}`);
    if (proximaPerguntaElement) {
        proximaPerguntaElement.classList.remove('hidden');
    } else {
        // Última pergunta, exibe a mensagem final
        document.getElementById('envio_automatico').value = '1';
        document.getElementById('formulario').submit();
    }
}
}

function anteriorPergunta() {
if (perguntaAtual > 1) {
    const perguntaAtualElement = document.getElementById(`pergunta${perguntaAtual}`);
    if (perguntaAtualElement) {
        perguntaAtualElement.classList.add('hidden');
        perguntaAtual--;

        const perguntaAnteriorElement = document.getElementById(`pergunta${perguntaAtual}`);
        if (perguntaAnteriorElement) {
            perguntaAnteriorElement.classList.remove('hidden');
        }
    }
}
}
</script>
</div>
</div>
</body>
</html>