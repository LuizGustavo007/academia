<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_academia2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Excluir instrutor se solicitado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir'])) {
    $instrutor_cod = intval($_POST['excluir']); // Sanitiza entrada

    $stmt = $conn->prepare("DELETE FROM instrutores WHERE instrutor_cod = ?");
    $stmt->bind_param("i", $instrutor_cod);

    if ($stmt->execute()) {
        echo "<script>alert('Instrutor excluído com sucesso!'); window.location='instrutor.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir instrutor!');</script>";
    }
}

// Consulta para buscar todos os instrutores
$sql = "SELECT instrutor_cod, instrutor_nome, instrutor_especialidade FROM instrutores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrutores Cadastrados</title>
    <link rel="stylesheet" href="./css/instrutor.css">
</head>
<body>

<!-- Barra de Navegação -->
<nav class="navbar">
    <a href="index.php"><img src="./img/logo_academia_nav.png" alt=""></a>
    <a href="index.php">Início</a>
    <a href="aluno.php">Aluno</a>
    <a href="instrutor.php">Instrutor</a>
</nav>

<h2 class="text-center">Lista de Instrutores</h2>

<div class="container mt-4">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Especialidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['instrutor_nome']); ?></td>
                    <td><?= htmlspecialchars($row['instrutor_especialidade']); ?></td>
                    <td>
                        <!-- Botão para editar -->
                        <a href="edicao_instrutor.php?id=<?= $row['instrutor_cod']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        
                        <!-- Formulário para excluir -->
                        <form method="POST" action="instrutor.php" style="display:inline;">
                            <input type="hidden" name="excluir" value="<?= $row['instrutor_cod']; ?>">
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>
<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Academia Saúde Total. Todos os direitos reservados.</p>
</footer>
</body>
</html>
