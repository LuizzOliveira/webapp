<?php
require_once __DIR__ . '/BaseModel.php';

class ImagemModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function salvarImagem($nomeUnico, $nomeOriginal, $caminho) {
        $sql = "INSERT INTO imagens (nome, nome_original, caminho) VALUES (:nome_arquivo, :nome_original, :caminho)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome_arquivo' => $nomeUnico,
            ':nome_original' => $nomeOriginal,
            ':caminho' => $caminho
        ]);
    }

    public function relacionarUsuarioImagem($imagemId, $usuarioId) {
        $sql = "INSERT INTO usuario_imagem (imagem_id, usuario_id) VALUES (:imagem_id, :usuario_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':imagem_id' => $imagemId,
            ':usuario_id' => $usuarioId
        ]);
    }

    public function buscarImagensPorUsuarioId($usuarioId) {
        $stmt = $this->pdo->prepare("
            SELECT i.* FROM imagens i
            INNER JOIN usuario_imagem ui ON i.id = ui.imagem_id
            WHERE ui.usuario_id = :usuario_id
            ORDER BY i.id DESC
        ");
        $stmt->execute(['usuario_id' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarImagensPorUsuarioId(int $usuarioId): int {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM imagens i
            INNER JOIN usuario_imagem ui ON i.id = ui.imagem_id
            WHERE ui.usuario_id = ?
        ");
        $stmt->execute([$usuarioId]);
        return (int) $stmt->fetchColumn();
    }
    public function listarTodasImagens()
    {
        $stmt = $this->pdo->query("SELECT nome FROM imagens");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirImagemPorNome(string $nome): bool {
        $stmt = $this->pdo->prepare("DELETE FROM imagens WHERE nome = :nome");
        return $stmt->execute([':nome' => $nome]);
    }

    public function contarTodasImagens(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM imagens");
        return (int) $stmt->fetchColumn();
    }

    public function buscarImagensComLimite(int $limit, int $offset) {
        $stmt = $this->pdo->prepare("SELECT * FROM imagens ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Exemplo para buscar imagens com dados do usuário (supondo que a tabela imagem e usuário estão relacionadas)
    public function buscarImagensComLimiteComUsuario(int $limit, int $offset): array
    {
        $sql = "SELECT i.*, u.nome AS nome_usuario
                FROM imagens i
                INNER JOIN usuario_imagem ui ON ui.imagem_id = i.id
                INNER JOIN usuarios u ON u.id = ui.usuario_id
                ORDER BY i.id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarImagensPorUsuarioIdComLimite(int $usuarioId, int $limit, int $offset): array
    {
        $sql = "SELECT i.*, u.nome AS nome_usuario
                FROM imagens i
                INNER JOIN usuario_imagem ui ON ui.imagem_id = i.id
                INNER JOIN usuarios u ON u.id = ui.usuario_id
                WHERE u.id = :usuarioId
                ORDER BY i.id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}