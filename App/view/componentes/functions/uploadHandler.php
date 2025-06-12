<?php
function handleUpload(array $files, array $post, $usuarioModel, $imagemModel, $pdo) {
    // Verifica se o formulário foi enviado corretamente
    if (!isset($files['foto'], $post['nome_usuario'])) return;

    // Define o diretório onde as imagens serão salvas
    $dirUpload = './view/assets/img/';

    // Cria o diretório se ele não existir
    if (!is_dir($dirUpload)) {
        mkdir($dirUpload, 0777, true);
    }

    // Remove imagens órfãs do disco ou do banco
    limparImagensOrfas($dirUpload, $imagemModel);

    // Recupera o arquivo e o nome do usuário do formulário
    $imagem = $files['foto'];
    $nomeUsuario = trim($post['nome_usuario']);

    // Define tipos de imagem permitidos e o tamanho máximo (16 MB)
    $mimeTypesPermitidas = ['image/jpeg', 'image/png'];
    $maxSize = 16 * 1024 * 1024;

    // Valida tipo de arquivo, tamanho e nome do usuário
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

    // Busca o usuário no banco
    $usuario = $usuarioModel->buscarPorNome($nomeUsuario);
    if (!$usuario || !is_array($usuario) || !isset($usuario['id'])) {
        $_SESSION['mensagem'] = 'Usuário não cadastrado. Faça o cadastro primeiro.';
        redirectIndex();
    }

    // Se o usuário já tem imagem associada, exclui imagem antiga do disco e do banco
    $imagensAntigas = $imagemModel->buscarImagensPorUsuarioId($usuario['id']);
    foreach ($imagensAntigas as $img) {
        $caminhoAntigo = $dirUpload . $img['nome'];
        if (file_exists($caminhoAntigo)) {
            unlink($caminhoAntigo); // remove arquivo físico
        }
    }
    $imagemModel->excluirImagemPorUsuarioId($usuario['id']); // remove do banco

    // Gera nome único para a nova imagem
    $nomeSanitizado = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $imagem['name']);
    $nomeUnico = uniqid() . '_' . $nomeSanitizado;
    $caminho = $dirUpload . $nomeUnico;

    // Move a imagem para o diretório final
    if (!move_uploaded_file($imagem['tmp_name'], $caminho)) {
        $_SESSION['mensagem'] = 'Falha ao mover o arquivo!';
        redirectIndex();
    }

    // Salva os dados da nova imagem no banco e associa ao usuário
    if ($imagemModel->salvarImagem($nomeUnico, $imagem['name'], $caminho)) {
        $imagemId = $pdo->lastInsertId(); // recupera ID gerado
        $imagemModel->relacionarUsuarioImagem($imagemId, $usuario['id']); // cria vínculo no banco
        $_SESSION['mensagem'] = 'Upload realizado com sucesso!';
    } else {
        $_SESSION['mensagem'] = 'Erro ao salvar dados da imagem!';
    }

    redirectIndex(); // Redireciona de volta para a página principal
}

// Redireciona para o index.php e encerra execução
function redirectIndex() {
    header('Location: index.php');
    exit;
}

// Remove arquivos órfãos do disco e registros inválidos do banco
function limparImagensOrfas($dirUpload, $imagemModel) {
    if (!is_dir($dirUpload)) return;

    $arquivosNoDisco = scandir($dirUpload);
    if (!is_array($arquivosNoDisco)) return;

    $arquivosNoDisco = array_diff($arquivosNoDisco, ['..', '.']);

    $imagensNoBanco = $imagemModel->listarTodasImagens();
    $nomesNoBanco = array_map(fn($img) => $img['nome'], $imagensNoBanco);

    // Apaga arquivos no disco que não estão no banco
    foreach ($arquivosNoDisco as $arquivo) {
        if (!in_array($arquivo, $nomesNoBanco)) {
            unlink($dirUpload . $arquivo);
        }
    }

    // Apaga registros no banco cujos arquivos não existem mais
    foreach ($imagensNoBanco as $img) {
        if (!file_exists($dirUpload . $img['nome'])) {
            $imagemModel->excluirImagemPorNome($img['nome']);
        }
    }
}
