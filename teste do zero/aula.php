<?php
include "./db/conexao.php";

// Busca instrutores para exibir no select
$sql_instrutores = "SELECT instrutor_cod, instrutor_nome, instrutor_especialidade FROM instrutores";
$result_instrutores = $conn->query($sql_instrutores);

// Buscar alunos para exibir no select
$sql_alunos = "SELECT aluno_cod, aluno_nome FROM aluno";
$result_alunos = $conn->query($sql_alunos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aluno_cod = $_POST["aluno_cod"];
    $instrutor_cod = $_POST["instrutor_cod"];
    $aula_tipo = $_POST["especialidade"];
    $aula_data = $_POST["aula_data"];
    $aula_horario = $_POST["aula_horario"];

    $stmt = $conn->prepare("INSERT INTO aula (fk_aluno_cod, fk_instrutor_cod, aula_tipo, aula_data, aula_horario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $aluno_cod, $instrutor_cod, $aula_tipo, $aula_data, $aula_horario);
   
    if ($stmt->execute()) {
        echo "<script>alert('Aula agendada com sucesso!'); window.location='agendamento.php';</script>";
    } else {
        echo "<script>alert('Erro ao agendar a aula!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Aula</title>
</head>
<body>
    <h2>Agendar Aula</h2>
    <form method="post">
    <label>Aluno:</label>
        <select name="aluno_cod" required>
            <option value="">Selecione um aluno</option>
            <?php while ($aluno = $result_alunos->fetch_assoc()) { ?>
                <option value="<?= $aluno['aluno_cod']; ?>"><?= $aluno['aluno_nome']; ?></option>
            <?php } ?>
        </select><br>
       
        <label>Instrutor:</label>
        <select name="instrutor_cod" id="instrutorSelect" required>
            <option value="">Selecione um instrutor</option>
            <?php while ($instrutor = $result_instrutores->fetch_assoc()) { ?>
                <option value="<?= $instrutor['instrutor_cod']; ?>" data-especialidade="<?= $instrutor['instrutor_especialidade']; ?>">
                    <?= $instrutor['instrutor_nome']; ?>
                </option>
            <?php } ?>
        </select><br>
       
        <label>Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" required><br>
       
       
        <label>Data:</label>
        <input type="date" name="aula_data" required><br>
       
        <label>Horário:</label>
        <input type="time" name="aula_horario" required><br>
       
        <button type="submit">Agendar</button>
    </form>
   
    <script>
        document.getElementById("instrutorSelect").addEventListener("change", function() {
            var especialidade = this.options[this.selectedIndex].getAttribute("data-especialidade");
            document.getElementById("especialidade").value = especialidade;
        });
    </script>
</body>
</html>