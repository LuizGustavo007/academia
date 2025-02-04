<?php
include "./db/conexao.php"; // Verifique o caminho do seu arquivo 'conexao.php'

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_academia2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
// Verifica se um ID foi passado pela URL (GET) para carregar os dados do aluno
if (isset($_GET['id'])) {
    $aluno_cod = $_GET['id'];

    // Busca os dados do aluno com base no ID
    $stmt = $conn->prepare("SELECT aluno_nome, aluno_endereco, aluno_cpf FROM aluno WHERE aluno_cod = ?");
    $stmt->bind_param("i", $aluno_cod);
    $stmt->execute();
    $result = $stmt->get_result();
    $aluno = $result->fetch_assoc(); // Armazena os dados do aluno encontrado
}

// Verifica se o formulário foi submetido para atualizar os dados
if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome']; // Obtém o novo nome do formulário
    $endereco = $_POST['endereco']; // Obtém o novo endereço do formulário
    $cpf = $_POST['cpf']; // Obtém o novo CPF do formulário

    // Prepara a query de atualização para os dados do aluno
    $stmt_aluno = $conn->prepare("UPDATE aluno SET aluno_nome = ?, aluno_endereco = ?, aluno_cpf = ? WHERE aluno_cod = ?");
    $stmt_aluno->bind_param("sssi", $nome, $endereco, $cpf, $aluno_cod);

    // Executa a atualização do aluno
    if ($stmt_aluno->execute()) {
        echo "<script>alert('Dados atualizados com sucesso!'); window.location='aluno.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar aluno!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/edicao_aluno.css">
    <title>Editar Aluno</title>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Editar Aluno</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($aluno['aluno_nome']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Endereço</label>
            <input type="text" name="endereco" class="form-control" value="<?= htmlspecialchars($aluno['aluno_endereco']); ?>">
        </div>
        <div class="mb-3">
            <label>CPF</label>
            <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($aluno['aluno_cpf']); ?>">
        </div>
        <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
        <a href="aluno.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
