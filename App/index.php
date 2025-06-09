<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/model/UsuarioModel.php';
require_once __DIR__ . '/model/ImagemModel.php';

require_once __DIR__ . '/view/componentes/functions/uploadHandler.php';
require_once __DIR__ . '/view/componentes/functions/paginationHandler.php';

$pdo = Database::conectar();
$usuarioModel = new UsuarioModel($pdo);
$imagemModel = new ImagemModel($pdo);

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

// Processa upload se for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleUpload($_FILES, $_POST, $usuarioModel, $imagemModel, $pdo);
}

// Obtém dados para paginação e busca
list($imagens, $nomeBusca, $page, $totalPages) = handlePagination($_GET, $usuarioModel, $imagemModel);

$emptyPage = (count($imagens) === 0);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Upload e Visualização de Imagens</title>
    <link id="light-theme-css" rel="stylesheet" href="view/assets/css/lightTheme.css">
    <link id="dark-theme-css" rel="stylesheet" href="view/assets/css/darkTheme.css" disabled>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <span id="theme-toggle" class="theme-toggle">🌙</span>

    <div class="layout-colunas">

        <div class="coluna-esquerda">
            <h1>Upload de Imagem</h1>

            <?php include __DIR__ . '/view/componentes/sections/mensagem.php'; ?>
            <?php include __DIR__ . '/view/componentes/sections/formularioUpload.php'; ?>
            <br>
            <a href="view/pages/cadastroUsuario.php">Cadastrar Usuário</a>
            <hr>
            <h2>Buscar imagens</h2>
            <?php include __DIR__ . '/view/componentes/sections/formularioBusca.php'; ?>
        </div>

        <div class="coluna-direita">
            <?php if ($nomeBusca): ?>
                <h2>Imagens de: <?php echo htmlspecialchars($nomeBusca); ?></h2>
            <?php else: ?>
                <h2>Imagens salvas</h2>
            <?php endif; ?>

            <?php include __DIR__ . '/view/componentes/sections/gridImagens.php'; ?>
            <?php include __DIR__ . '/view/componentes/sections/paginacao.php'; ?>
        </div>
    </div>
    
    <script src="view/assets/js/main.js"></script>

</body>
</html>