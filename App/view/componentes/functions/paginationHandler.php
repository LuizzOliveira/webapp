<?php
function handlePagination(array $get, $usuarioModel, $imagemModel) {
    $imagensPerPage = 12;
    $page = isset($get['page']) && is_numeric($get['page']) && $get['page'] > 0 ? (int) $get['page'] : 1;
    $nomeBusca = trim($get['nome'] ?? '');
    $imagens = [];
    $totalImagens = 0;

    if ($nomeBusca !== '') {
        $usuario = $usuarioModel->buscarPorNome($nomeBusca);
        if ($usuario) {
            $totalImagens = $imagemModel->contarImagensPorUsuarioId($usuario['id']);
            $offset = ($page - 1) * $imagensPerPage;
            $imagens = $imagemModel->buscarImagensPorUsuarioIdComLimite($usuario['id'], $imagensPerPage, $offset);
        } else {
            $_SESSION['mensagem'] = "Nenhum usuário encontrado com esse nome.";
        }
    } else {
        $totalImagens = $imagemModel->contarTodasImagens();
        $offset = ($page - 1) * $imagensPerPage;
        $imagens = $imagemModel->buscarImagensComLimiteComUsuario($imagensPerPage, $offset);
    }

    $totalPages = (int) ceil($totalImagens / $imagensPerPage);

    if (count($imagens) === 0 && $page > 1) {
        header('Location: ?' . http_build_query(['nome' => $nomeBusca, 'page' => 1]));
        exit;
    }

    return [$imagens, $nomeBusca, $page, $totalPages];
}
