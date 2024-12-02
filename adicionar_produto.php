<?php
session_start();
include_once 'config.php'; 

if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['nome'], $_POST['quantidade'], $_POST['preco'])) {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    $query_insert = "INSERT INTO produtos (nome, quantidade, preco) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query_insert);
    $stmt->bind_param("sid", $nome, $quantidade, $preco);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h1>Cadastrar Novo Produto</h1>
    <form action="adicionar_produto.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" required><br><br>

        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="preco" required><br><br>

        <button type="submit">Adicionar Produto</button>
    </form>
</body>
</html>
