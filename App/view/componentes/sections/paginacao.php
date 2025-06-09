<div class="paginacao">
    <?php if ($totalPages > 1 && count($imagens) > 0): ?>
        <?php if ($page > 1): ?>
            <a href="?<?php echo http_build_query(['nome' => $nomeBusca, 'page' => $page - 1]); ?>" class="btn-pag">← Anterior</a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php
            $classe = 'btn-pag';
            if ($p === $page) {
                $classe .= $emptyPage ? '' : ' ativo';
            }
            ?>
            <?php if ($p === $page): ?>
                <span class="<?php echo $classe; ?>"><?php echo $p; ?></span>
            <?php else: ?>
                <a href="?<?php echo http_build_query(['nome' => $nomeBusca, 'page' => $p]); ?>" class="<?php echo $classe; ?>"><?php echo $p; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?<?php echo http_build_query(['nome' => $nomeBusca, 'page' => $page + 1]); ?>" class="btn-pag">Próximo →</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
