<?php

function handleUserRegistration($post, $usuarioModel)
{
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($post['nome'] ?? '');
        $name = mb_strtolower(trim($name));
        $email = trim($post['email'] ?? '');
        $password = $post['senha'] ?? '';
        $confirmPassword = $post['confirmaSenha'] ?? '';

        if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
            $message = "Por favor preencha todos os campos.";
        } elseif ($password !== $confirmPassword) {
            $message = "As senhas não coincidem.";
        } elseif ($usuarioModel->buscarPorEmail($email)) {
            $message = "Email já cadastrado.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $usuarioModel->criarUsuario($name, $email, $passwordHash);
            $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
            header('Location: ../../index.php');
            exit;
        }
    }

    return $message;
}