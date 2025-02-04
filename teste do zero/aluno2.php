

<!DOCTYPE html>
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
    <a href="aula.php">Agendar aula</a>
</nav>
<div class="container mt-4">
    <h2 class="text-center"></h2>
    <table class="table table-bordered table-striped">
       
        <tbody>
            <!-- Loop que percorre cada aluno no banco e exibe na tabela -->
            
        </tbody>
    </table>
</div>
<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Academia Saúde Total. Todos os direitos reservados.</p>
</footer>
</body>
</html>
