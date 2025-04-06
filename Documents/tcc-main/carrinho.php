<?php
session_start();

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'add':
            adicionarAoCarrinho();
            break;
        case 'del':
            removerDoCarrinho();
            break;
        case 'delall':
            limparCarrinho();
            break;
        case 'update':
            atualizarCarrinho();
            break;
        case 'finalizar':
            finalizarCompra();
            break;
    }
}

function adicionarAoCarrinho() {
    $id = intval($_GET['id']);
    $_SESSION['carrinho'][$id] = isset($_SESSION['carrinho'][$id]) ? $_SESSION['carrinho'][$id] + 1 : 1;
    header("Location: carrinho.php");
}

function removerDoCarrinho() {
    $id = intval($_GET['id']);
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
        header("Location: carrinho.php");
    } else {
        echo "Produto não encontrado no carrinho.";
        exit();
    }
}

function limparCarrinho() {
    $_SESSION['carrinho'] = array();
    header("Location: carrinho.php");
}

function atualizarCarrinho() {
    if (isset($_POST['prod']) && is_array($_POST['prod'])) {
        foreach ($_POST['prod'] as $id => $qtd) {
            $id = intval($id);
            $qtd = intval($qtd);
            $_SESSION['carrinho'][$id] = $qtd;
        }
        header("Location: carrinho.php");
        exit();
    } else {
        echo "Dados inválidos para atualização do carrinho.";
        exit();
    }
}

function finalizarCompra() {
    $email_cliente = isset($_COOKIE["email"]) ? $_COOKIE["email"] : "";

    if (empty($email_cliente)) {
        echo "Erro: Cliente não está logado.";
        exit();
    }

    require("conexao.php");

    $cliente_id = obterClienteId($email_cliente, $conexao);

    if (!$cliente_id) {
        echo "Erro: Cliente não encontrado.";
        exit();
    }

    // Corrigir aqui: Incluir o email do cliente ao inserir o pedido
    $pedido_id = inserirPedido($cliente_id, $email_cliente, $conexao);

    if (!$pedido_id) {
        echo "Erro ao criar pedido.";
        exit();
    }

    if (!inserirItensPedido($pedido_id, $conexao)) {
        echo "Erro ao adicionar itens ao pedido.";
        exit();
    }

    if (!atualizarEstoque($conexao)) {
        echo "Erro ao atualizar estoque.";
        exit();
    }

    if (!atualizarTotalPedido($pedido_id, $conexao)) {
        echo "Erro ao atualizar total do pedido.";
        exit();
    }

    unset($_SESSION['carrinho']);

    // Adicionar o alerta e redirecionamento
    echo '<script>';
    echo 'alert("Pedido finalizado com sucesso!");';
    echo 'window.location.href = "meuspedidos.php";';
    echo '</script>';
    exit();
}




// Funções auxiliares
function obterClienteId($email, $conexao) {
    $sqlCliente = "SELECT id FROM cliente WHERE email = ?";
    $stmtCliente = mysqli_prepare($conexao, $sqlCliente);
    mysqli_stmt_bind_param($stmtCliente, "s", $email);
    mysqli_stmt_execute($stmtCliente);
    $resultCliente = mysqli_stmt_get_result($stmtCliente);

    $cliente = mysqli_fetch_assoc($resultCliente);

    return $cliente ? $cliente['id'] : null;
}

function inserirPedido($cliente_id, $cliente_email, $conexao) {
    $sqlPedido = "INSERT INTO pedido (cliente_id, cliente_email, total) VALUES (?, ?, 0)";
    $stmtPedido = mysqli_prepare($conexao, $sqlPedido);
    mysqli_stmt_bind_param($stmtPedido, "is", $cliente_id, $cliente_email);
    mysqli_stmt_execute($stmtPedido);

    return mysqli_insert_id($conexao);
}


function inserirItensPedido($pedido_id, $conexao) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $sqlItem = "INSERT INTO itens_pedido (pedido_id, perfume_id, quantidade, preco_unitario)
                    VALUES (?, ?, ?, (SELECT preco FROM perfume WHERE id=?))";
        $stmtItem = mysqli_prepare($conexao, $sqlItem);
        mysqli_stmt_bind_param($stmtItem, "iiii", $pedido_id, $id, $qtd, $id);

        if (!mysqli_stmt_execute($stmtItem)) {
            return false;
        }
    }

    return true;
}

function atualizarEstoque($conexao) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $sqlUpdate = "UPDATE perfume SET quant = quant - ? WHERE id = ?";
        $stmtUpdate = mysqli_prepare($conexao, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ii", $qtd, $id);

        if (!mysqli_stmt_execute($stmtUpdate)) {
            return false;
        }
    }

    return true;
}

function atualizarTotalPedido($pedido_id, $conexao) {
    $sqlUpdateTotal = "UPDATE pedido SET total = (SELECT SUM(quantidade * preco_unitario) FROM itens_pedido WHERE pedido_id = ?) WHERE id = ?";
    $stmtUpdateTotal = mysqli_prepare($conexao, $sqlUpdateTotal);
    mysqli_stmt_bind_param($stmtUpdateTotal, "ii", $pedido_id, $pedido_id);

    return mysqli_stmt_execute($stmtUpdateTotal);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/feminino.css">
</head>
<body style="text-align: center;">




<body>

    <div class="fundo">
        <div class="fundo_top">
            <div class="logo">
                <img src="./img/logo4.png" alt="logo" class="logo1" height="100" width="220">
            </div>
            <div class="topo"></div>
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
            <button class="search-btn search-txt" id="pesquisa" type="submit"></button>
            <img src="img/lupa.png" alt="lupa" height="20" width="20">
        </form>
        

        <div class="icon">
            <a href="carrinho.php"> <img src="img/bolsa-de-compras (1).png" alt="icon" class="sacola"> </a>
        </div>

        <script>
            setTimeout(function () {
                $('#msgbox').fadeOut("slow");
            }, 3000);
        </script>

        

    </div>
    <table style="width: 100%;">
        <caption class="titulo1">Carrinho de compras</caption>
        <thead>
            <tr>
                <th width="80" class="card-texto3">Produto</th>
                <th width="80">Quantidade</th>
                <th width="80">Preço</th>
                <th width="80">SubTotal</th>
                <th width="80">Remover</th>
            </tr>
        </thead>
        <form action="?acao=update" method="POST">
            <tbody>
                <?php
                $total = 0;
                if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
                    require("conexao.php");
                    foreach ($_SESSION['carrinho'] as $id => $qtd) {
                        $sql = "SELECT * FROM perfume WHERE id='$id'";
                        $result = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
                        $nome = mysqli_fetch_assoc($result);
                        $nome1 = $nome['nome'];
                        $preco = number_format(floatval($nome['preco']), 2, ',', '.'); // preco
                        $sub = number_format(floatval($nome['preco']) * $qtd, 2, ',', '.'); // preco x qtd
                        $total += floatval($nome['preco']) * $qtd;
                ?>
                        <tr>
                            <td><?php echo $nome1 ?></td>
                            <td><input type="text" size="3" name="prod[<?php echo $id ?>]" value="<?php echo $qtd ?>"></td>
                            <td><?php echo $preco ?></td>
                            <td><?php echo $sub ?></td>
                            <td><a href="?acao=del&id=<?php echo $id ?>">Remover</a></td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="5">Carrinho vazio</td></tr>';
                }
                ?>
                <tr style="background-color: #dfdfdf;">
                    <td colspan="3">Total</td>
                    <td>R$ <?php echo $total; ?></td>
                    <td><input type="submit" value="Atualizar carrinho"></td>
                </tr>
            </tbody>
        </form>
        <tfoot>
            <tr>
                <td colspan="5"><a href="index.php">Continuar comprando</a></td>
            </tr>
            <tr>
                <td colspan="5">
                    <form action="?acao=finalizar" method="POST">
                        <input type="hidden" name="finalizar_compra" value="1">
                        <input type="submit" value="Finalizar Compra">
                    </form>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <div id="msgbox" style="margin-top: 10px;">
                        <?php
                        if (isset($_SESSION['mensagem'])) {
                            echo '<p style="color: green; font-weight: bold;">' . $_SESSION['mensagem'] . '</p>';
                            unset($_SESSION['mensagem']);
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>