<div class="grid-imagens">
    <?php if (count($imagens) === 0): ?>
        <p>Nenhuma imagem encontrada.</p>
    <?php else: ?>
        <?php foreach ($imagens as $img): ?>
            <div class="imagem-box">
                <a href="<?php echo htmlspecialchars($img['caminho']); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo htmlspecialchars($img['caminho']); ?>" alt="Imagem do usuário">
                </a>
                <p><strong>Usuário:</strong> <?php echo htmlspecialchars($img['nome_usuario'] ?? 'Desconhecido'); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
