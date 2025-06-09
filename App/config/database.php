<?php
class Database {
    public static function conectar() {
        try {
            $pdo = new PDO('mysql:host=localhost;port=3308;dbname=webapp;charset=utf8', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }
}
