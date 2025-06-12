<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../model/UsuarioModel.php';
require_once __DIR__ . '/../componentes/functions/userRegistrationHandler.php';



$pdo = Database::conectar();
$usuarioModel = new UsuarioModel($pdo);

$message = handleUserRegistration($_POST, $usuarioModel);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro de Usuário</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../view/assets/css/cadastroUsuario.css">
</head>
<body>
    
    <div class="container">
        <h1>Cadastrar Usuário</h1>

        <?php
            $mensagem = $message;
            include __DIR__ . '/../../view/componentes/sections/mensagem.php';
        ?>

        <?php
            include __DIR__ . '/../../view/componentes/sections/formularioCadastroUsuario.php';
        ?>
    </div>
    <script src="../../view/assets/js/main.js"></script>
</body>
</html>
