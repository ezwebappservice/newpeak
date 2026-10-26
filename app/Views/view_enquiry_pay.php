<?php
/** @var array<string, mixed> $enquiry */
$name = trim(($enquiry['first_name'] ?? '') . ' ' . ($enquiry['last_name'] ?? ''));
$digits = preg_replace('/\D+/', '', (string) ($enquiry['phone'] ?? '')) ?? '';
if (strlen($digits) === 10) {
    $digits = '91' . $digits;
}
$amountLabel = (string) ($enquiry['amount_label'] ?? '');
$paymentLabel = (string) ($enquiry['payment_label'] ?? '');
?>
<main>
  <section class="enquiry-hero">
    <div class="container">
      <p class="enquiry-eyebrow">Secure payment</p>
      <h1>Complete your <em>payment</em></h1>
      <p>Pay <?= esc($amountLabel) ?> for <?= esc($paymentLabel) ?> with Razorpay. Your enquiry is confirmed once payment succeeds.</p>
    </div>
  </section>

  <section class="enquiry-section">
    <div class="container">
      <article class="enquiry-thanks enquiry-pay">
        <p class="enquiry-eyebrow">Almost there</p>
        <h2>Pay <?= esc($amountLabel) ?></h2>
        <p>Hello <?= esc($enquiry['first_name'] ?? '') ?>. Review the details below, then continue to Razorpay.</p>
        <ul class="enquiry-pay__rows">
          <li><span>Name</span><?= esc($name) ?></li>
          <li><span>Email</span><?= esc($enquiry['email'] ?? '') ?></li>
          <li><span>Program</span><?= esc($enquiry['program'] ?? '') ?></li>
          <li><span>Payment for</span><?= esc($paymentLabel) ?></li>
          <li><span>Amount</span><?= esc($amountLabel) ?></li>
        </ul>
        <button type="button" class="discovery-form__submit" id="enquiry-pay-btn">Pay <?= esc($amountLabel) ?> with Razorpay</button>
        <p class="enquiry-pay__note" id="enquiry-pay-note" hidden>Payment was closed before it finished. You can open Razorpay again, or <a href="<?= esc(peak_enquiry_url(), 'attr') ?>">go back to the form</a>.</p>
      </article>

      <form id="enquiry-verify-form" method="post" action="<?= base_url('enquiry/verify') ?>" hidden>
        <?= csrf_field() ?>
        <input type="hidden" name="public_token" value="<?= esc($enquiry['public_token'] ?? '', 'attr') ?>">
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
    amount: <?= (int) ($enquiry['amount_paise'] ?? 0) ?>,
    currency: 'INR',
    name: 'Peak Potential Academy',
    description: <?= json_encode($paymentLabel . ' ' . $amountLabel) ?>,
    order_id: <?= json_encode($razorpay_order) ?>,
    prefill: {
      name: <?= json_encode($name) ?>,
      email: <?= json_encode((string) ($enquiry['email'] ?? '')) ?>,
      contact: <?= json_encode($digits) ?>
    },
    theme: { color: '#6B1D2A' },
    handler: function (response) {
      document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id || '';
      document.getElementById('razorpay_order_id').value = response.razorpay_order_id || '';
      document.getElementById('razorpay_signature').value = response.razorpay_signature || '';
      document.getElementById('enquiry-verify-form').submit();
    },
    modal: {
      ondismiss: function () {
        document.getElementById('enquiry-pay-note').hidden = false;
      }
    }
  };

  var checkout = new Razorpay(options);
  document.getElementById('enquiry-pay-btn').addEventListener('click', function () {
    checkout.open();
  });
  checkout.open();
})();
</script>
