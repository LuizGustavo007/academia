<?php
include "./db/conexao.php"; // Inclui a conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_academia2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}

// Inicializa a variável para evitar erro de variável indefinida
$instrutor = [
    'instrutor_nome' => '',
    'instrutor_especialidade' => ''
];

// Verifica se um ID foi passado pela URL (GET) para carregar os dados do instrutor
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $instrutor_cod = intval($_GET['id']); // Garante que o ID é um número inteiro

    // Prepara e executa a consulta
    $stmt = $conn->prepare("SELECT instrutor_nome, instrutor_especialidade FROM instrutores WHERE instrutor_cod = ?");
    $stmt->bind_param("i", $instrutor_cod);
    $stmt->execute();
    $result = $stmt->get_result();
    $instrutor = $result->fetch_assoc();

    // Se nenhum instrutor for encontrado, redireciona e evita erro
    if (!$instrutor) {
        echo "<script>alert('Instrutor não encontrado!'); window.location='instrutore.php';</script>";
        exit();
    }
}

// Verifica se o formulário foi submetido para atualizar os dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar'])) {
    $nome = trim($_POST['nome']);
    $especialidade = trim($_POST['especialidade']);

    if (!empty($nome) && !empty($especialidade)) {
        // Prepara a query de atualização
        $stmt = $conn->prepare("UPDATE instrutores SET instrutor_nome = ?, instrutor_especialidade = ? WHERE instrutor_cod = ?");
        $stmt->bind_param("ssi", $nome, $especialidade, $instrutor_cod);

        if ($stmt->execute()) {
            echo "<script>alert('Dados atualizados com sucesso!'); window.location='instrutor.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar!');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Instrutor</title>
    <link rel="stylesheet" href="./css/edicao_instrutor.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Editar Instrutor</h2>
    <form method="post">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($instrutor['instrutor_nome'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label>Especialidade</label>
            <input type="text" name="especialidade" class="form-control" value="<?= htmlspecialchars($instrutor['instrutor_especialidade'] ?? ''); ?>" required>
        </div>
        <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
        <a href="instrutor.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
