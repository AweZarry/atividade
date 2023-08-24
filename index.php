<?php
session_start();

require_once('classes/Eagle.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$eagle = new eagle($db);

if (isset($_POST['logar'])) {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if ($eagle->logar($nome, $senha)) {
        $_SESSION['nome'] = $nome;

        header("Location: dashboard.php");
        exit();
    } else {
        print "<script>alert('Credenciais invalidas')</script>";
    }
}

?>



<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="index">
    <form action="" method="POST">
        <div class="inbel">
            <h1>Tela de Login</h1>

            <label for="Email">Usuario</label>
            <input type="text" name="nome" placeholder="Coloque seu Usuario" required>
           
            <label for="Senha">Senha</label>
            <input type="password" name="senha" minlength="8" placeholder="Coloque sua senha" required>

            <button type="submit" name="logar">Logar</button>

            <a href="cadastrar.php">Clique aqui para criar uma conta</a>

        </div>

    </form>
</body>

</html>