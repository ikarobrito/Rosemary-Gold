

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/6e68b6b4aa.js" crossorigin="anonymous"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script src="js/login.js"></script>
    <title>Rosemary Gold | Login </title>
        <script>
            function link(){
                window.location = "./index.php"
            }
        </script>
</head>

<body>

    <div id="msgbox">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            $_SESSION['msg'] == "";
            session_destroy();
        }
        ?>

        <script>
            setTimeout(function() {
                $('#msgbox').fadeOut("slow");
            }, 5000);
        </script>
    </div>

    <div class="container">
        <div class="form-image">
            <img src="img/rosemary_footer.png" alt="">
        </div>
        <div class="form">
            <form action="login.php" method="POST" autocomplete="off">
                
                <div class="form-header">
                    <div class="title">
                        <h1>Login</h1>
                    </div>
                    <div class="login-button">
                        <button><a href="cadastro.php">Cadastre-se</a></button>
                    </div>
                </div>

                <div class="input-group">
                    
                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" required>
                        <span class="focus-border"></span>
                    </div>

                    <div class="input-box">
                        <label for="password">Senha</label>
                        <div class="password-input">
                            <input type="password" placeholder="Digite uma senha válida" name="senha" id="senha" minlength="8" required>
                            <span class="fa-regular fa-eye" id="olho"></span>
                        </div>
                        <span class="focus-border"></span>
                    </div>


                </div>

                <div class="continue-button">
                <button type="submit" name="entrar" value="Entrar"><a href="">Entrar</button>
                </div>
                <br>
                
            </form>
            <a href="esqsenha.php" class="buttonsenha">Esqueceu a senha?</a>
        </div>
    </div>
    <?php
    if (isset($_SESSION['altersenha'])) {
        echo $_SESSION['altersenha'];
        $_SESSION['altersenha'] == "";
        session_destroy();
    }
    ?>
    <script>
        setTimeout(function() {
            $('#msgsenha').fadeOut("slow");
        }, 5000);
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
</body>


</html>