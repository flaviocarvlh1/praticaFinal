<?php
session_start();
include_once 'config.php'; 

if (isset($_POST['quantidades']) && !empty($_POST['quantidades'])) {
    $produtos_selecionados = $_POST['quantidades'];

    $quantidade_total = 0;
    $preco_total = 0;
    $produtos_resumo = [];

    foreach ($produtos_selecionados as $produto_id => $quantidade) {
        if ($quantidade > 0) {
            $query_produto = "SELECT nome, preco, quantidade FROM produtos WHERE id = ?";
            $stmt = $conn->prepare($query_produto);
            $stmt->bind_param("i", $produto_id);
            $stmt->execute();
            $stmt->bind_result($produto_nome, $preco_unitario, $estoque_disponivel);
            $stmt->fetch();
            $stmt->close();

            if ($quantidade > $estoque_disponivel) {
                die("Erro: Quantidade solicitada de '$produto_nome' excede o estoque disponível.");
            }

            $produtos_resumo[] = "$produto_nome (x$quantidade)";
            $quantidade_total += $quantidade;
            $preco_total += $preco_unitario * $quantidade;

            $query_atualizar_estoque = "UPDATE produtos SET quantidade = quantidade - ? WHERE id = ?";
            $stmt = $conn->prepare($query_atualizar_estoque);
            $stmt->bind_param("ii", $quantidade, $produto_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    $_SESSION['produtos_resumo'] = $produtos_resumo;
    $_SESSION['quantidade_total'] = $quantidade_total;
    $_SESSION['preco_total'] = $preco_total;
} else {
    die("Erro: Nenhum produto selecionado ou quantidade inválida.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./CSS/finalizar_compra.css">
    <title>Finalizar Compra</title>
</head>
<body>
<h1>Dados de Envio!</h1>
<div class="form-container">
    <form action="compra_concluida.php" method="POST" onsubmit="return validarIdade()">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" required>

        <label for="morada">Morada:</label>
        <input type="text" name="morada" id="morada" required>

        <button type="submit">Concluir Compra</button>
    </form>
</div>

<script>
    function validarIdade() {
        const dataNascimento = document.getElementById('data_nascimento').value;

        if (!dataNascimento) {
            alert('Por favor, insira sua data de nascimento.');
            return false;
        }

        const hoje = new Date();
        const nascimento = new Date(dataNascimento);

       
        let idade = hoje.getFullYear() - nascimento.getFullYear();
        const mes = hoje.getMonth() - nascimento.getMonth();

        if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
            idade--;
        }

        if (idade < 18) {
            alert('Você precisa ter pelo menos 18 anos para concluir a compra.');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
