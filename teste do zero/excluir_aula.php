<?php
include "db/conexao.php";

if (isset($_GET["id"])) {
    $aula_cod = $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM aula WHERE aula_cod = ?");
    $stmt->bind_param("i", $aula_cod);

    if ($stmt->execute()) {
        echo "<script>alert('Aula excluída com sucesso!'); window.location='agendamento.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir aula!');</script>";
    }
}
?>
