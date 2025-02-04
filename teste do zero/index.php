<?php
require './db/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_nome = $_POST['nome'];
    $usuario_senha = $_POST['senha'];

    // Verificar se o usuário existe
    $query = "SELECT * FROM usuarios WHERE usuario_nome = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usuario_nome);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        // Verificar a senha
        if (password_verify($usuario_senha, $usuario['usuario_senha'])) {
            $_SESSION['usuario_nome'] = $usuario['usuario_nome'];
            $_SESSION['usuario_tipo'] = $usuario['usuario_tipo'];

            // Redirecionar dependendo do tipo de usuário
            if ($usuario['usuario_tipo'] == 'aluno') {
                header("Location: aluno2.php");
            } else {
                header("Location: instrutor.php");
            }
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="submit" value="Login">
        <a href="cadastro.php">Cadastrar-se</a>
    </form>
</div>
</body>
</html>

