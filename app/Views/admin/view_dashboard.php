<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>
<section class="content-header">
  <h1>Dashboard</h1>
  <p class="text-muted srl-dashboard-intro">Overview of content managed on the Peak Potentialwebsite.</p>
</section>

<section class="content">
  <div class="row">
    <?php foreach (($stats ?? []) as $stat): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
      <a href="<?= base_url($stat['url']) ?>" class="srl-dashboard-stat-link">
        <div class="info-box srl-dashboard-stat">
          <span class="info-box-icon <?= esc($stat['color']) ?>"><i class="fa <?= esc($stat['icon']) ?>"></i></span>
          <div class="info-box-content">
            <span class="info-box-text"><?= esc($stat['label']) ?></span>
            <span class="info-box-number"><?= (int) ($stat['value'] ?? 0) ?></span>
            <?php if (! empty($stat['note'])): ?>
            <span class="info-box-note"><?= esc($stat['note']) ?></span>
            <?php endif; ?>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</section>
