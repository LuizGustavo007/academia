<?php
include "db/conexao.php";

// Consulta os agendamentos com os detalhes do aluno e do instrutor
$sql = "SELECT 
            aula.aula_cod, 
            aluno.aluno_nome, 
            instrutores.instrutor_nome, 
            instrutores.instrutor_especialidade, 
            aula.aula_tipo, 
            aula.aula_data, 
            aula.aula_horario, 
            aula.aula_status
        FROM aula
        INNER JOIN aluno ON aula.fk_aluno_cod = aluno.aluno_cod
        INNER JOIN instrutores ON aula.fk_instrutor_cod = instrutores.instrutor_cod
        ORDER BY aula.aula_data ASC, aula.aula_horario ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h2>Lista de Agendamentos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Instrutor</th>
                <th>Especialidade</th>
                <th>Tipo da Aula</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["aluno_nome"]); ?></td>
                    <td><?= htmlspecialchars($row["instrutor_nome"]); ?></td>
                    <td><?= htmlspecialchars($row["instrutor_especialidade"]); ?></td>
                    <td><?= htmlspecialchars($row["aula_tipo"]); ?></td>
                    <td><?= htmlspecialchars($row["aula_data"]); ?></td>
                    <td><?= htmlspecialchars($row["aula_horario"]); ?></td>
                    <td><?= htmlspecialchars($row["aula_status"]); ?></td>
                    <td>
                        <a href="editar_aula.php?id=<?= $row['aula_cod']; ?>">✏️ Editar</a>
                        <a href="excluir_aula.php?id=<?= $row['aula_cod']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">❌ Excluir</a>
                        <?php if ($row["aula_status"] == "pendente") { ?>
                            <a href="concluir_aula.php?id=<?= $row['aula_cod']; ?>">✅ Concluir</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
