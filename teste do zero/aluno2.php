<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="./css/aluno.css">
</head>
<body>
<nav class="navbar">
    <a href="index.php"><img src="./img/logo_academia_nav.png" alt=""></a>
    <a href="index.php">Início</a>
    <a href="aluno.php">Aluno</a>
    <a href="instrutor.php">Instrutor</a>
</nav>
<div class="container mt-4">
    <h2 class="text-center">Lista de Alunos</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop que percorre cada aluno no banco e exibe na tabela -->
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['aluno_nome']); ?></td>
                    <td><?= htmlspecialchars($row['aluno_cpf']); ?></td>
                    <td><?= htmlspecialchars($row['aluno_endereco']); ?></td>
                    <td>
                        <!-- Botão para editar (redireciona para editar_aluno.php com ID do aluno) -->
                        <a href="edicao_aluno.php?id=<?= $row['aluno_cod']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        
                        <!-- Formulário para excluir o aluno com método POST -->
                        <form method="POST" action="aluno.php" style="display:inline;">
                            <input type="hidden" name="excluir" value="<?= $row['aluno_cod']; ?>">
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Academia Saúde Total. Todos os direitos reservados.</p>
</footer>
</body>
</html>
