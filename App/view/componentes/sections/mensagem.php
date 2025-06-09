<?php if ($mensagem): ?>
    <p class="<?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
        <?php echo htmlspecialchars($mensagem); ?>
    </p>
<?php endif; ?>
