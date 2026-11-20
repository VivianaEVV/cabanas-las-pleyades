<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$site    = $config['site'];
$contact = $config['contact'];
$address = $config['address'];
?>
    <footer class="site-footer">
        <div class="container site-footer__inner">
            <p class="site-footer__brand">Cabañas <?= e($site['name']) ?></p>
            <address>
                <?= e($address['street']) ?>, <?= e($address['city']) ?>, <?= e($address['region']) ?><br>
                <a href="<?= e(whatsapp_url($contact['whatsapp_number'])) ?>" target="_blank" rel="noopener noreferrer"><?= e($contact['whatsapp_display']) ?></a>
                ·
                <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a>
            </address>
            <p class="site-footer__copy">&copy; <?= e(date('Y')) ?> <?= e($site['name']) ?></p>
        </div>
    </footer>
</body>
</html>
