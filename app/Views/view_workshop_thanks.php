<?php
/** @var \Config\Workshop $workshop */
/** @var array<string, string>|null $receipt */
?>
<main class="workshop-page">
  <section class="workshop-hero">
    <div class="container workshop-wrap">
      <p class="workshop-badge">Seat reserved</p>
      <h1>Thank you.</h1>
      <p>Your place is confirmed for <?= esc($workshop->title) ?>.</p>
    </div>
  </section>

  <section class="workshop-body">
    <div class="container workshop-wrap">
      <article class="workshop-thanks">
        <h2><?= esc($workshop->when) ?></h2>
        <p><?= esc($workshop->where) ?> · <?= esc($workshop->audience) ?></p>
        <?php if (is_array($receipt)): ?>
          <ul>
            <?php if (($receipt['name'] ?? '') !== ''): ?><li><span>Name</span><?= esc($receipt['name']) ?></li><?php endif; ?>
            <?php if (($receipt['email'] ?? '') !== ''): ?><li><span>Email</span><?= esc($receipt['email']) ?></li><?php endif; ?>
            <?php if (($receipt['medium'] ?? '') !== ''): ?><li><span>Medium</span><?= esc($receipt['medium']) ?></li><?php endif; ?>
            <?php if (($receipt['amount'] ?? '') !== ''): ?><li><span>Amount paid</span><?= esc($receipt['amount']) ?></li><?php endif; ?>
            <?php if (($receipt['payment_id'] ?? '') !== ''): ?><li><span>Payment reference</span><?= esc($receipt['payment_id']) ?></li><?php endif; ?>
          </ul>
        <?php endif; ?>
        <p>A confirmation email is on its way. Your Zoom joining link will be shared in a separate email 24 hours before the workshop.</p>
        <a class="workshop-submit workshop-submit--link" href="<?= base_url() ?>">Back to home</a>
        <p class="workshop-signoff">Peak Potential Academy &nbsp;|&nbsp; Calmer Parents. Brighter Tomorrows.</p>
      </article>
    </div>
  </section>
</main>
