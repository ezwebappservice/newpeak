<?php
/** @var \Config\Workshop $workshop */
/** @var array<string, mixed> $registration */
$name = trim(($registration['first_name'] ?? '') . ' ' . ($registration['last_name'] ?? ''));
$digits = preg_replace('/\D+/', '', (string) ($registration['phone'] ?? '')) ?? '';
if (strlen($digits) === 10) {
    $digits = '91' . $digits;
}
$amountLabel = '₹' . number_format(((int) ($registration['amount_paise'] ?? 0)) / 100);
?>
<main class="workshop-page">
  <section class="workshop-hero">
    <div class="container workshop-wrap">
      <p class="workshop-badge">Secure payment</p>
      <h1>Reserve your seat</h1>
      <p><?= esc($workshop->title) ?> — <?= esc($workshop->when) ?></p>
    </div>
  </section>

  <section class="workshop-body">
    <div class="container workshop-wrap">
      <div class="workshop-pay">
        <h2>Almost there, <?= esc($registration['first_name'] ?? '') ?>.</h2>
        <p>Pay <?= esc($amountLabel) ?> with Razorpay to confirm your seat. Your Zoom joining link will be emailed to <?= esc($registration['email'] ?? '') ?> 24 hours before the workshop.</p>
        <ul>
          <li><span>Name</span><?= esc($name) ?></li>
          <li><span>Medium</span><?= esc($registration['medium'] ?? '') ?></li>
          <li><span>Seat fee</span><?= esc($amountLabel) ?></li>
        </ul>
        <button type="button" class="workshop-submit" id="workshop-pay-btn">Pay <?= esc($amountLabel) ?> with Razorpay</button>
        <p class="workshop-pay-note" id="workshop-pay-note" hidden>Payment was closed before it finished. You can open Razorpay again, or <a href="<?= base_url('workshop-registration') ?>">go back to the form</a>.</p>
        <p class="workshop-signoff">Peak Potential Academy &nbsp;|&nbsp; Calmer Parents. Brighter Tomorrows.</p>
      </div>

      <form id="workshop-verify-form" method="post" action="<?= base_url('workshop-registration/verify') ?>" hidden>
        <?= csrf_field() ?>
        <input type="hidden" name="public_token" value="<?= esc($registration['public_token'] ?? '', 'attr') ?>">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature" value="">
      </form>
    </div>
  </section>
</main>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(function () {
  var options = {
    key: <?= json_encode($razorpay_key) ?>,
    amount: <?= (int) ($registration['amount_paise'] ?? 0) ?>,
    currency: 'INR',
    name: 'Peak Potential Academy',
    description: <?= json_encode($workshop->title . ' — ' . $workshop->when) ?>,
    order_id: <?= json_encode($razorpay_order) ?>,
    prefill: {
      name: <?= json_encode($name) ?>,
      email: <?= json_encode((string) ($registration['email'] ?? '')) ?>,
      contact: <?= json_encode($digits) ?>
    },
    theme: { color: '#6B1D2A' },
    handler: function (response) {
      document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id || '';
      document.getElementById('razorpay_order_id').value = response.razorpay_order_id || '';
      document.getElementById('razorpay_signature').value = response.razorpay_signature || '';
      document.getElementById('workshop-verify-form').submit();
    },
    modal: {
      ondismiss: function () {
        document.getElementById('workshop-pay-note').hidden = false;
      }
    }
  };

  var checkout = new Razorpay(options);
  document.getElementById('workshop-pay-btn').addEventListener('click', function () {
    checkout.open();
  });
  checkout.open();
})();
</script>
