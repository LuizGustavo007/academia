<?php
require './db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_nome = $_POST['nome'];
    $usuario_senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $usuario_tipo = $_POST['tipo']; // 'aluno' ou 'instrutor'

    // Verificar se o tipo de usuário é válido
    if (!in_array($usuario_tipo, ['aluno', 'instrutor'])) {
        echo "Tipo de usuário inválido.";
        exit;
    }

    // Iniciar a transação para garantir consistência
    $conn->begin_transaction();

    try {
        // Inserir o usuário na tabela 'usuarios'
        $query = "INSERT INTO usuarios (usuario_nome, usuario_senha, usuario_tipo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $usuario_nome, $usuario_senha, $usuario_tipo);
        $stmt->execute();

        // Obter o ID do usuário recém-cadastrado
        $usuario_cod = $conn->insert_id;

        if ($usuario_tipo == 'instrutor') {
            // Cadastro do instrutor na tabela 'instrutores'
            $especialidade = $_POST['especialidade'];
            $query_instrutor = "INSERT INTO instrutores (instrutor_cod, instrutor_nome, instrutor_especialidade) 
                                VALUES (?, ?, ?)";
            $stmt_instrutor = $conn->prepare($query_instrutor);
            $stmt_instrutor->bind_param("iss", $usuario_cod, $usuario_nome, $especialidade);
            $stmt_instrutor->execute();
        } elseif ($usuario_tipo == 'aluno') {
            // Cadastro do aluno na tabela 'aluno'
            $cpf = $_POST['cpf'];
            $endereco = $_POST['endereco'];
            $query_aluno = "INSERT INTO aluno (aluno_cod, aluno_nome, aluno_cpf, aluno_endereco) 
                            VALUES (?, ?, ?, ?)";
            $stmt_aluno = $conn->prepare($query_aluno);
            $stmt_aluno->bind_param("isss", $usuario_cod, $usuario_nome, $cpf, $endereco);
            $stmt_aluno->execute();
        }

        // Confirmar a transação
        $conn->commit();

        echo "Cadastro realizado com sucesso!";

    } catch (Exception $e) {
        // Se houver erro, desfazer as inserções
        $conn->rollback();
        echo "Erro no cadastro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/cadastro.css">
        <title>Document</title>
    </head>
    <body>
        <a href="login.php" class="voltar-btn">← Voltar</a>

        <div class="cadastro-container">
            <h2>Cadastro</h2>
            <form method="POST" action="cadastro.php">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="password" name="senha" placeholder="Senha" required>
                
                <select name="tipo" id="tipo" required>
                    <option value="aluno">Aluno</option>
                    <option value="instrutor">Instrutor</option>
                </select>

                <!-- Campos específicos para instrutor -->
                <div id="instrutor_fields" style="display: none;">
                    <input type="text" name="especialidade" placeholder="Especialidade (Ex: Zumba, Pilates)">
                </div>

                <!-- Campos específicos para aluno -->
                <div id="aluno_fields">
                    <input type="text" name="cpf" placeholder="CPF">
                    <input type="text" name="endereco" placeholder="Endereço">
                </div>

                <input type="submit" value="Cadastrar">
            </form>
        </div>
        <script>
            // Mostrar/esconder campos com base na seleção do usuário
            document.querySelector('#tipo').addEventListener('change', function() {
                var tipo = this.value;
                document.getElementById('instrutor_fields').style.display = (tipo === 'instrutor') ? 'block' : 'none';
                document.getElementById('aluno_fields').style.display = (tipo === 'aluno') ? 'block' : 'none';
            });
        </script>
    </body>
</html>