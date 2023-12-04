

<?php header("Content-type: text/html; charset=utf-8");
session_start();

include_once("conexao.php");
mysqli_set_charset($conexao, "utf8");

$tabela = "cliente";

$campos = "nome, telefone, cpf, email, senha, data_nasc";


if (isset($_POST['cadastrar'])) {

  $nomeF = ucwords($_POST['nome']);
  $telefoneF = $_POST['telefone'];
  $cpfF = $_POST['cpf'];
  $emailF = strtolower($_POST['email']);
  $senhaF = $_POST['senha'];
  $data = $_POST['data_nasc'];

  $sql = "INSERT INTO $tabela ($campos) 
			VALUES ('$nomeF', '$telefoneF', '$cpfF', '$emailF', '$senhaF', '$data')";

  $instrucao = mysqli_query($conexao, $sql);

  if (!$instrucao) {
    die('Algo deu errado: ' . mysqli_error($conexao));
  } else {
    mysqli_close($conexao);
    $_SESSION['email'] = $emailF;
    $_SESSION['senha'] = $senhaF;
    header('Location: index.php');
    $_SESSION['msg'] = '<p id="mensagem">Bem Vindo, ' . $nomeF . '!</p>';
    setcookie("email", $emailF);
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rosemary Gold | Cadastro</title>
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="css/cadastro.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/6e68b6b4aa.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
  <script>
            function link(){
                window.location = "./index.php"
            }
        </script>
</head>

<body>
<div class="container">
        <div class="form-image">
            <img src="img/rosemary_footer.png" alt="">
        </div>
        <div class="form">
            <form action="" method="post" autocomplete="off">
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastre-se</h1>
                    </div>
                    <div class="login-button">
                        <button><a href="fazerlogin.php">Login</a></button>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="Nome">Nome</label>
                        <input id="Nome" type="text" placeholder="Digite seu nome" name="nome" required>
                    </div>

                    <div class="input-box">
                        <label for="CPFInput">CPF</label>
                        <input id="CPFInput" type="text" placeholder="XXX.XXX.XXX-XX" name="cpf" oninput="valcpf(this)" onblur="validarCPF(this)" required>
                    </div>

                    <div class="input-box">
                        <label for="number">Data Nascimento</label>
                        <input type="text" oninput="data(this)" onblur="validadata(this)" name="data_nasc" placeholder="XX/XX/XXXX" required>
                    </div>

                    <div class="input-box">
                        <label for="number">Celular</label>
                        <input type="text" placeholder="XX XXXXX-XXXX" name="telefone" id="CelularInput" oninput="tel(this)" required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="text" placeholder="Digite um email válido" name="email" onblur="validacaoEmail(this)" required>
                    </div>

                    <div class="input-box">
                        <label for="password">Senha</label>
                        <div class="password-input">
                            <input type="password" placeholder="Digite uma senha válida" name="senha" id="senha" required>
                            <span class="fa-regular fa-eye" id="olho"></span>
                        </div>
                        <span class="focus-border"></span>
                    </div>




                </div>
                <div class="continue-button">
                <button type="submit" name="cadastrar"><a href="">Cadastrar</button><br>
            </div>
            </form>
        </div>
    </div>
</body>
<script>
  function mascara(i) {

    var v = i.value;

    if (isNaN(v[v.length - 1])) {
      i.value = v.substring(0, v.length - 1);
      return;
    }

    i.setAttribute("maxlength", "9");
    if (v.length == 5) i.value += "-";
  }
</script>
<script>
  function data(i) {

    var v = i.value;

    if (isNaN(v[v.length - 1])) {
      i.value = v.substring(0, v.length - 1);
      return;
    }

    i.setAttribute("maxlength", "10");
    if (v.length == 2) i.value += "/";
    if (v.length == 5) i.value += "/";
    if (v.length == 6) i.value += "/";
  }
</script>
<script>
  function valcpf(j) {

    var v = j.value;

    if (isNaN(v[v.length - 1])) {
      j.value = v.substring(0, v.length - 1);
      return;
    }

    j.setAttribute("maxlength", "14");
    if (v.length == 3) j.value += ".";
    if (v.length == 7) j.value += ".";
    if (v.length == 11) j.value += "-";
  }
</script>

<script>
  function tel(j) {

    var v = j.value;

    if (isNaN(v[v.length - 1])) {
      j.value = v.substring(0, v.length - 1);
      return;
    }

    j.setAttribute("maxlength", "13");
    if (v.length == 2) j.value += " ";
    if (v.length == 8) j.value += "-";
  }
</script>

<script type="text/javascript">
  $("#CEPInput").focusout(function() {
    $.ajax({
      url: "https://viacep.com.br/ws/" + $(this).val() + "/json/",
      dataType: "json",
      success: function(resposta) {
        $("#rua").val(resposta.logradouro);
        $("#complementocasa").val(resposta.complemento);
        $("#bairro").val(resposta.bairro);
        $("#cidade").val(resposta.localidade);
        $("#uf").val(resposta.uf);
      },
    });
  });
</script>
<script>
  var senha = $('#senha');
  var olho = $("#olho");

  olho.mousedown(function() {
    senha.attr("type", "text");
  });

  olho.mouseup(function() {
    senha.attr("type", "password");
  });
  $("#olho").mouseout(function() {
    $("#senha").attr("type", "password");
  });
</script>
<script>
  function _cpf(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '') return false;
    if (cpf.length != 11 ||
      cpf == "00000000000" ||
      cpf == "11111111111" ||
      cpf == "22222222222" ||
      cpf == "33333333333" ||
      cpf == "44444444444" ||
      cpf == "55555555555" ||
      cpf == "66666666666" ||
      cpf == "77777777777" ||
      cpf == "88888888888" ||
      cpf == "99999999999")
      return false;
    add = 0;
    for (i = 0; i < 9; i++)
      add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
      rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
      return false;
    add = 0;
    for (i = 0; i < 10; i++)
      add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
      rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
      return false;
    return true;
  }

  function validarCPF(el) {
    if (!_cpf(el.value)) {

      alert("CPF inválido!");

      el.value = "";
    }
  }
</script>

<script>
  function validadata(a) {
    var data = a.value;
    var data_array = data.split("/");

    var date = new Date();
    var newano = date.getFullYear();
    var newmes = date.getMonth() + 1;
    var newdia = date.getDate();
    var newall = (newano * 365) + (newmes * 30) + newdia;

    var dia = parseInt(data_array[0]);
    var mes = parseInt(data_array[1]);
    var ano = parseInt(data_array[2]);
    var all = dia + (mes * 30) + (ano * 365);

    if (newall - all < 6570) {
      var alerta = "Apenas maiores de idade podem se cadastrar!";
      var i = false;
    }

    if (dia < 1 || dia > 31 || mes < 1 || mes > 12 || ano < 1940) {
      var i = false;
      var alerta = "Data inválida";
    }
    if (i == false) {
      alert(alerta);
      a.value = "";
    }
  }
</script>

<script>
  function validacaoEmail(field) {
    usuario = field.value.substring(0, field.value.indexOf("@"));
    dominio = field.value.substring(field.value.indexOf("@") + 1, field.value.length);

    if ((usuario.length >= 1) &&
      (dominio.length >= 3) &&
      (usuario.search("@") == -1) &&
      (dominio.search("@") == -1) &&
      (usuario.search(" ") == -1) &&
      (dominio.search(" ") == -1) &&
      (dominio.search(".") != -1) &&
      (dominio.indexOf(".") >= 1) &&
      (dominio.lastIndexOf(".") < dominio.length - 1)) {} else {
      alert("E-mail invalido");
      field.value = "";
    }
  }
</script>

</html>