<?php 


function handleUpload(array $files, array $post, $usuarioModel, $imagemModel, $pdo) {
    if (!isset($files['foto'], $post['nome_usuario'])) return;

    // 1️⃣ Limpeza das imagens órfãs ANTES do upload
    limparImagensOrfas('./view/assets/img/', $imagemModel);

    $imagem = $files['foto'];
    $nomeUsuario = trim($post['nome_usuario']);

    $mimeTypesPermitidas = ['image/jpeg', 'image/png'];
    $maxSize = 16 * 1024 * 1024;

    if (!in_array($imagem['type'], $mimeTypesPermitidas)) {
        $_SESSION['mensagem'] = 'Tipo de arquivo inválido!';
        redirectIndex();
    } elseif ($imagem['size'] > $maxSize) {
        $_SESSION['mensagem'] = 'Arquivo muito grande!';
        redirectIndex();
    } elseif (empty($nomeUsuario)) {
        $_SESSION['mensagem'] = 'Nome é obrigatório!';
        redirectIndex();
    }

    $usuario = $usuarioModel->buscarPorNome($nomeUsuario);
    if (!$usuario || !is_array($usuario) || !isset($usuario['id'])) {
        $_SESSION['mensagem'] = 'Usuário não cadastrado. Faça o cadastro primeiro.';
        redirectIndex();
    }


    $dirUpload = './view/assets/img/';
    if (!is_dir($dirUpload)) {
        mkdir($dirUpload, 0777, true);
    }

    $nomeSanitizado = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $imagem['name']);
    $nomeUnico = uniqid() . '_' . $nomeSanitizado;
    $caminho = $dirUpload . $nomeUnico;

    if (!move_uploaded_file($imagem['tmp_name'], $caminho)) {
        $_SESSION['mensagem'] = 'Falha ao mover o arquivo!';
        redirectIndex();
    }

    if ($imagemModel->salvarImagem($nomeUnico, $imagem['name'], $caminho)) {
        $imagemId = $pdo->lastInsertId();
        $imagemModel->relacionarUsuarioImagem($imagemId, $usuario['id']);
        $_SESSION['mensagem'] = 'Upload realizado com sucesso!';
    } else {
        $_SESSION['mensagem'] = 'Erro ao salvar dados da imagem!';
    }

    redirectIndex();
}

function redirectIndex() {
    header('Location: index.php');
    exit;
}

function limparImagensOrfas($dirUpload, $imagemModel) {
    $imagensNoBanco = $imagemModel->listarTodasImagens();
    $nomesNoBanco = array_map(fn($img) => $img['nome'], $imagensNoBanco);

    $arquivosNoDisco = array_diff(scandir($dirUpload), ['..', '.']);

    foreach ($arquivosNoDisco as $arquivo) {
        if (!in_array($arquivo, $nomesNoBanco)) {
            unlink($dirUpload . $arquivo);
        }
    }

    foreach ($imagensNoBanco as $img) {
        if (!file_exists($dirUpload . $img['nome'])) {
            $imagemModel->excluirImagemPorNome($img['nome']);
        }
    }
}