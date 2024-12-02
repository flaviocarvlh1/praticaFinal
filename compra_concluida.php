<?php
session_start();
include_once 'config.php'; 

if (isset($_POST['nome'], $_POST['data_nascimento'], $_POST['morada'])) {
    $nome_cliente = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $morada = $_POST['morada'];

    $produtos_resumo = $_SESSION['produtos_resumo'] ?? [];
    $quantidade_total = $_SESSION['quantidade_total'] ?? 0;
    $preco_total = $_SESSION['preco_total'] ?? 0;

    if (empty($produtos_resumo) || $quantidade_total == 0 || $preco_total == 0) {
        die("Erro: Nenhum produto válido encontrado.");
    }

    $data_encomenda = date('Y-m-d H:i:s');
    $query_encomenda = "INSERT INTO encomendas (nome_cliente, data_nascimento, morada, data_encomenda, quantidade_total, preco_total, produtos) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query_encomenda);
$produtos_serializados = json_encode($produtos_resumo); 
$stmt->bind_param("ssssdis", $nome_cliente, $data_nascimento, $morada, $data_encomenda, $quantidade_total, $preco_total, $produtos_serializados);
    $stmt->execute();
    $encomenda_id = $stmt->insert_id; 
    $stmt->close();

    $query_detalhes = "INSERT INTO detalhes_encomenda (encomenda_id, produto_nome, quantidade, preco_unitario) 
                       VALUES (?, ?, ?, ?)";
    $stmt_detalhes = $conn->prepare($query_detalhes);

    foreach ($produtos_resumo as $produto_detalhe) {
        
        preg_match('/^(.*?) \(x(\d+)\)$/', $produto_detalhe, $matches);
        $produto_nome = $matches[1];
        $quantidade = (int) $matches[2];
        
        $query_preco = "SELECT preco FROM produtos WHERE nome = ?";
        $stmt_preco = $conn->prepare($query_preco);
        $stmt_preco->bind_param("s", $produto_nome);
        $stmt_preco->execute();
        $stmt_preco->bind_result($preco_unitario);
        $stmt_preco->fetch();
        $stmt_preco->close();

        $stmt_detalhes->bind_param("isid", $encomenda_id, $produto_nome, $quantidade, $preco_unitario);
        $stmt_detalhes->execute();
    }

    $stmt_detalhes->close();


    if (isset($nome_cliente) && isset($produtos_resumo) && isset($quantidade_total) && isset($preco_total) && isset($morada)) {
        echo "
        <div style='
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: Arial, sans-serif;
            '>
            <h1 style='
                font-size: 2.5rem;
                color: #333;
                margin-bottom: 20px;
            '>Compra realizada com sucesso!</h1>
            <p style='
                font-size: 1rem;
                color: #555;
                margin-bottom: 15px;
                line-height: 1.5;
            '>Obrigado por sua compra, <strong style='color: #6c63ff;'>$nome_cliente</strong>.</p>
            <p style='
                font-size: 1rem;
                color: #555;
                margin-bottom: 15px;
            '>Resumo da encomenda:</p>
            <ul style='
                list-style: none;
                padding: 0;
                margin: 20px 0;
            '>";
            
            foreach ($produtos_resumo as $produto_detalhe) {
                echo "<li style='
                    font-size: 1rem;
                    color: #444;
                    background: #f3f3f3;
                    margin: 5px 0;
                    padding: 10px;
                    border-radius: 5px;
                '>$produto_detalhe</li>";
            }

        echo "
            </ul>
            <p style='
                font-weight: bold;
                color: #333;
                margin-top: 20px;
            '><strong>Total de itens:</strong> $quantidade_total</p>
            <p style='
                font-weight: bold;
                color: #333;
                margin-top: 10px;
            '><strong>Preço total:</strong> R$ " . number_format($preco_total, 2, ',', '.') . "</p>
            <p style='
                font-size: 1rem;
                color: #555;
                margin-top: 15px;
            '>Data de entrega será enviada para: <strong style='color: #6c63ff;'>$morada</strong>.</p>
            <a href='index.php' style='
                display: inline-block;
                margin-top: 30px;
                background: #6c63ff;
                color: #fff;
                padding: 12px 20px;
                font-size: 1rem;
                border-radius: 5px;
                text-decoration: none;
                transition: background 0.3s ease-in-out, transform 0.2s;
            ' onmouseover='this.style.background=\"#584ce6\"; this.style.transform=\"scale(1.05)\";' onmouseout='this.style.background=\"#6c63ff\"; this.style.transform=\"scale(1)\";'>Voltar à Página Inicial</a>
        </div>
        ";
    } else {
        die("Erro: Dados do cliente não enviados.");
    }

    }


?>
