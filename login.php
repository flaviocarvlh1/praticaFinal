<?php
session_start();
include_once 'config.php'; 

if (isset($_POST['usuario'], $_POST['senha'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM utilizadores WHERE nome_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario_bd = $resultado->fetch_assoc();

        if ($usuario_bd['senha'] === $senha) { 
            $_SESSION['usuario_logado'] = $usuario_bd['nome_usuario'];
            header("Location: admin.php");
            exit;
        } else {
            $erro = "Senha incorreta";
        }
    } else {
        $erro = "Usuário não encontrado";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./CSS/login.css">
    <title>Login Administrativo</title>
</head>
<body>
    <h1>Login Administrativo</h1>
    <form method="POST" action="">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>
        <button type="submit">Entrar</button>
        <a class="back" href="./index.php">Voltar</a>
    </form>
    <?php if (isset($erro)): ?>
        <p><?php echo $erro; ?></p>
    <?php endif; ?>
</body>
</html>
