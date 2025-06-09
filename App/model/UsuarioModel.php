<?php
require_once __DIR__ . '/BaseModel.php';

class UsuarioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criarUsuario($nome, $email, $senhaHash) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senhaHash
        ])) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorNome(string $nome): ?array {
        $sql = "SELECT * FROM usuarios WHERE LOWER(nome) = LOWER(:nome) LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nome' => $nome]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    public function buscarTodosUsuarios()
{
    $stmt = $this->pdo->query("SELECT id, nome, email FROM usuarios");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
