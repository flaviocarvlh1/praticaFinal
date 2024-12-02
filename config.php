<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "mercearia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT id, nome, quantidade FROM produtos";
$result = $conn->query($sql);

$produtos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $produtos[$row['id']] = $row['quantidade'];
    }
} else {
    echo "0 resultados";
}

?>
