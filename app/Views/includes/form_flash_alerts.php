<?php
helper('form_ui');
$flashKey = $flash_key ?? 'form_error';
$successKey = $success_key ?? str_replace('_error', '_success', $flashKey);
$successMessages = form_flash_messages($successKey);
$errorMessages = form_flash_messages($flashKey);
$compact = ! empty($compact);

if ($successMessages === [] && $errorMessages === []) {
    return;
}
?>
<div class="srl-form-messages<?= $compact ? ' srl-form-messages-compact' : '' ?>"<?= $errorMessages !== [] ? ' data-has-errors="1"' : '' ?>>
  <?php foreach ($successMessages as $message): ?>
    <div class="alert alert-success srl-form-alert" role="alert">
      <i class="bi bi-check-circle-fill srl-form-alert-icon" aria-hidden="true"></i>
      <div><?= esc($message) ?></div>
    </div>
  <?php endforeach; ?>

  <?php if ($errorMessages !== []): ?>
    <div class="alert alert-danger srl-form-alert" role="alert">
      <i class="bi bi-exclamation-triangle-fill srl-form-alert-icon" aria-hidden="true"></i>
      <div>
        <?php if (count($errorMessages) > 1): ?>
          <strong class="srl-form-alert-title">Please correct the following:</strong>
          <ul class="srl-form-alert-list mb-0">
            <?php foreach ($errorMessages as $message): ?>
              <li><?= esc($message) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <strong class="srl-form-alert-title"><?= esc($errorMessages[0]) ?></strong>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
