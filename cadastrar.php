<?php
require_once('classes/Eagle.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$eagle = new eagle($db);

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];

    if ($eagle->cadastrar($nome, $email, $senha, $confSenha)) {
        echo '<div class="alerts">', "Cadastro realizado com sucesso", '</div>';
    } else {
        echo '<div class="alertss">', "Erro ao cadastrar", '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="cadast">
    <form method="POST">
        <div class="laput">

            <h1>Cadastro</h1>

            <label for="">Nome de usuario</label>
            <input type="text" name="nome" placeholder="Coloque seu nome de Usuario" required>

            <label for="">Email</label>
            <input type="email" name="email" placeholder="Coloque seu email" required>

            <label for="">Senha</label>
            <input type="password" name="senha" minlength="8" placeholder="Coloque sua senha" required>

            <label for="">Confirmar senha</label>
            <input type="password" name="confSenha" placeholder="Confirme Sua senha" required>

            <button type="submit" name="cadastrar">Cadastrar</button>
            
            <a href="index.php">Voltar</a>

        </div>

    </form>

</body>

</html>