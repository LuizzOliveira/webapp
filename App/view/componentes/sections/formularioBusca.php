<form method="GET" action="index.php" style="margin-bottom: 10px;">
    <input type="text" name="nome" placeholder="Nome do usuário" value="<?php echo htmlspecialchars($nomeBusca); ?>" required>
    <button type="submit">Buscar</button>
</form>

<?php if ($nomeBusca): ?>
    <form method="GET" action="index.php">
        <button type="submit">Ver todas</button>
    </form>
<?php endif; ?>
