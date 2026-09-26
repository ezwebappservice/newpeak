<?php
helper('form_ui');
/** @var \Config\Workshop $workshop */
$mediumSelected = form_old_value('medium', $workshop->mediums[0] ?? 'English');
$heardSelected = form_old_value('heard_from', $workshop->sources[0] ?? 'LinkedIn');
?>
<main class="workshop-page">
  <div class="container workshop-wrap">
    <section class="workshop-poster">
      <img src="<?= peak_img('workshop/parenting-unplugged-banner.jpg') ?>" alt="Parenting Unplugged with Sapna KS. Emotional Strength, Healthier Boundaries and Better Conversations. 4th October 2026, 11:00 AM–12:00 PM IST, on Zoom, for parents of 13+ years." width="819" height="848">
      <h1 class="visually-hidden">Parenting Unplugged</h1>
    </section>

    <section class="workshop-body">
      <p class="workshop-lead">Please fill in your details below to reserve your seat.</p>
      <form class="workshop-form" id="workshop-form" method="post" action="<?= base_url('workshop-registration/checkout') ?>" novalidate>
        <?= csrf_field() ?>
        <div class="srl-form-antispam-hp" aria-hidden="true">
          <label for="company_website">Company website</label>
          <input type="text" name="company_website" id="company_website" value="" tabindex="-1" autocomplete="off">
        </div>

        <?= view('includes/form_flash_alerts', ['flash_key' => 'workshop_form_error']) ?>

        <h2 class="workshop-kicker">Your details</h2>
        <div class="workshop-grid">
          <label>
            First Name <span>*</span>
            <input type="text" name="first_name" value="<?= esc(form_old_value('first_name')) ?>" placeholder="e.g. Anita" required maxlength="80" autocomplete="given-name">
          </label>
          <label>
            Last Name <span>*</span>
            <input type="text" name="last_name" value="<?= esc(form_old_value('last_name')) ?>" placeholder="e.g. Sharma" required maxlength="80" autocomplete="family-name">
          </label>
          <label>
            WhatsApp Contact Number <span>*</span>
            <input type="tel" name="phone" value="<?= esc(form_old_value('phone')) ?>" placeholder="+91 98765 43210" required maxlength="20" autocomplete="tel" inputmode="tel">
          </label>
          <label>
            Email ID <span>*</span>
            <input type="email" name="email" value="<?= esc(form_old_value('email')) ?>" placeholder="anita.sharma@email.com" required maxlength="255" autocomplete="email">
          </label>
        </div>

        <h2 class="workshop-kicker">Workshop preferences</h2>
        <fieldset class="workshop-field">
          <legend>Preferred Medium of Instruction <span>*</span></legend>
          <div class="workshop-choice">
            <?php foreach ($workshop->mediums as $option): ?>
              <label>
                <input type="radio" name="medium" value="<?= esc($option, 'attr') ?>" <?= $mediumSelected === $option ? 'checked' : '' ?> required>
                <?= esc($option) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <label class="workshop-field">
          Is there a topic you’d like us to include in the workshop?
          <textarea name="topic" rows="3" maxlength="1000" placeholder="e.g. Handling exam stress conversations at home"><?= esc(form_old_value('topic')) ?></textarea>
        </label>

        <fieldset class="workshop-field">
          <legend>How did you hear about this workshop? <span>*</span></legend>
          <div class="workshop-choice">
            <?php foreach ($workshop->sources as $option): ?>
              <label>
                <input type="radio" name="heard_from" value="<?= esc($option, 'attr') ?>" <?= $heardSelected === $option ? 'checked' : '' ?> required>
                <?= esc($option) ?>
              </label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <p class="workshop-fee">Seat fee <?= esc($workshop->amountLabel()) ?> · paid securely with Razorpay</p>
        <button type="submit" class="workshop-submit" id="workshop-reserve">Reserve my seat →</button>
        <p class="workshop-signoff">Peak Potential Academy &nbsp;|&nbsp; Calmer Parents. Brighter Tomorrows.</p>
      </form>
    </section>
  </div>
</main>
<script>
document.getElementById('workshop-form').addEventListener('submit', function () {
  var button = document.getElementById('workshop-reserve');
  button.disabled = true;
  button.textContent = 'Please wait…';
});
</script>
