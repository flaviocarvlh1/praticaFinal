<?php
session_start();
include_once 'config.php'; 


if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit;
}

$query_encomendas = "SELECT * FROM encomendas";
$resultado_encomendas = $conn->query($query_encomendas);

$query_produtos = "SELECT * FROM produtos";
$resultado_produtos = $conn->query($query_produtos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./CSS/admin.css">
    <title>Painel Administrativo</title>
</head>
<body>
    <div class="welcome">
        <h1>Bem-vindo, <?php echo $_SESSION['usuario_logado']; ?>!</h1>
        <a href="logout.php">Sair</a>
    </div>
    <div class="container">
        <h2>Lista de Encomendas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome Cliente</th>
                <th>Data Encomenda</th>
                <th>Total</th>
            </tr>
            <?php while ($encomenda = $resultado_encomendas->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $encomenda['id']; ?></td>
                    <td><?php echo $encomenda['nome_cliente']; ?></td>
                    <td><?php echo $encomenda['data_encomenda']; ?></td>
                    <td>R$ <?php echo number_format($encomenda['preco_total'], 2, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </table>

        <h2>Lista de Produtos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Atualizar</th>
            </tr>
            <?php while ($produto = $resultado_produtos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $produto['id']; ?></td>
                    <td><?php echo $produto['nome']; ?></td>
                    <td><?php echo $produto['quantidade']; ?></td>
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?php echo $produto['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Cadastrar Novo Produto</h2>
        <form action="adicionar_produto.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" required>

            <label for="preco">Preço:</label>
            <input type="text" name="preco" id="preco" required>

            <button type="submit">Adicionar Produto</button>
        </form>
    </div>
</body>
</html>
