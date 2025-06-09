<form action="cadastroUsuario.php" method="POST" onsubmit="return validarSenhas()">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" id="senha" name="senha" placeholder="Senha" required>
    <input type="password" id="confirmaSenha" name="confirmaSenha" placeholder="Confirmar Senha" required>
    <button type="submit">Cadastrar</button>
</form>

<a href="../../index.php">Voltar</a>