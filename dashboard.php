<?php
session_start();

require_once('classes/Eagle.php');
require_once('conexao/conexao.php');

$database = new Conexao();
$db = $database->getConnection();
$eagle = new eagle($db);

if (!isset($_SESSION['nome'])) {
    header("Location: index.php");
    exit();
}

$nome = $_SESSION['nome'];

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'read':
            $rows = $eagle->read();
            break;
        case 'update':
            if (isset($_POST['id'])) {
                $eagle->update($_POST);
            }
            $rows = $eagle->read();
            break;

        default:
            $rows = $eagle->read();
            break;
    }
} else {
    $rows = $eagle->read();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
            max-width: 500px;
            margin: 0 auto;
        }

        h1 {
            position: relative;
            font-size: 35px;
            font-family: 'Lucida Sans';
            color: #ffabab;
            text-align: center;
        }

        p {
            position: relative;
            font-size: 35px;
            font-family: 'Lucida Sans';
            color: #ffabab;
            text-align: center;
        }

        label {
            display: flex;
            margin-top: 10px;
            color: #ffabab;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            color: #ffabab;
        }

        input[type=email] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            color: #ffabab;
        }

        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            color: #ffabab;
        }

        input[type=submit] {
            background-color: #ffabab;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            padding: 8px 12px;
            background-color: #ffabab;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            position: relative;
            top: -5px;
            left: 510px;
        }

        a:hover {
            background-color: #0069d9;
        }

        a.delete {
            background-color: #dc3545;
        }

        a.delete:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $eagle->readOne($id);

        if (!$result) {
            echo "Registro não encontrado.";
            exit();
        }
        $nome = $result['nome'];
        $email = $result['email'];
        $senha = $result['senha'];
    }
    ?>

    <form action="?action=update" method="POST">

        <h1>Painel de controle</h1>
        <p>Seja bem vindo <?php echo $nome; ?> </p>

        <input type="hidden" name="id" value="<?php echo $id ?>">

        <label for="">Nome de Usuario</label>
        <input type="text" name="nome" value="<?php echo $nome ?>">

        <label for="">Email</label>
        <input type="email" name="email" value="<?php echo $email ?>">

        <label for="">Senha</label>
        <input type="password" name="senha" value="<?php echo $senha ?>">
        <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
        <?php


        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
                echo "<a href='?action=update&id=" . $row['id'] . "'>Editar</a>";
            }
        ?>
    </form>

    <a href="logout.php">Sair</a>

</body>

</html>