<?php
include "db/conexao.php";

if (isset($_GET["id"])) {
    $aula_cod = $_GET["id"];

    // Obtém os dados atuais da aula
    $stmt = $conn->prepare("SELECT * FROM aula WHERE aula_cod = ?");
    $stmt->bind_param("i", $aula_cod);
    $stmt->execute();
    $result = $stmt->get_result();
    $aula = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $aula_tipo = $_POST["aula_tipo"];
        $aula_data = $_POST["aula_data"];
        $aula_horario = $_POST["aula_horario"];

        // Atualiza os dados da aula
        $stmt = $conn->prepare("UPDATE aula SET aula_tipo = ?, aula_data = ?, aula_horario = ? WHERE aula_cod = ?");
        $stmt->bind_param("sssi", $aula_tipo, $aula_data, $aula_horario, $aula_cod);

        if ($stmt->execute()) {
            echo "<script>alert('Aula atualizada com sucesso!'); window.location='agendamento.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar aula!');</script>";
        }
    }
} else {
    echo "<script>alert('ID de aula inválido!'); window.location='agendamento.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Aula</title>
</head>
<body>
    <h2>Editar Aula</h2>
    <form method="post">
        <label>Tipo da Aula:</label>
        <input type="text" name="aula_tipo" value="<?= $aula['aula_tipo']; ?>" required>

        <label>Data:</label>
        <input type="date" name="aula_data" value="<?= $aula['aula_data']; ?>" required>

        <label>Horário:</label>
        <input type="time" name="aula_horario" value="<?= $aula['aula_horario']; ?>" required>

        <button type="submit">Salvar</button>
        <a href="agendamento.php">Cancelar</a>
    </form>
</body>
</html>
