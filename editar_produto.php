<?php
session_start();
include_once 'config.php'; 

if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $produto_id = $_GET['id'];

    $query_produto = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($query_produto);
    $stmt->bind_param("i", $produto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();
    } else {
        die("Produto não encontrado.");
    }

    $stmt->close();
}

if (isset($_POST['quantidade'], $_POST['preco'])) {
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    $query_update = "UPDATE produtos SET quantidade = ?, preco = ? WHERE id = ?";
    $stmt = $conn->prepare($query_update);
    $stmt->bind_param("idi", $quantidade, $preco, $produto_id);
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
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form action="editar_produto.php?id=<?php echo $produto['id']; ?>" method="POST">
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" value="<?php echo $produto['quantidade']; ?>" required><br><br>

        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="preco" value="<?php echo $produto['preco']; ?>" required><br><br>

        <button type="submit">Atualizar Produto</button>
    </form>
</body>
</html>
