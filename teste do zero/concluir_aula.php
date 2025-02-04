<?php
include "db/conexao.php";

if (isset($_GET["id"])) {
    $aula_cod = $_GET["id"];

    $stmt = $conn->prepare("UPDATE aula SET aula_status = 'concluida' WHERE aula_cod = ?");
    $stmt->bind_param("i", $aula_cod);

    if ($stmt->execute()) {
        echo "<script>alert('Aula concluída com sucesso!'); window.location='agendamento.php';</script>";
    } else {
        echo "<script>alert('Erro ao concluir aula!');</script>";
    }
}
?>
