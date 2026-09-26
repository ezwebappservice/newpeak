<?php
helper('form_ui');
/** @var \Config\Workshop $workshop */
$mediumSelected = form_old_value('medium', $workshop->mediums[0] ?? 'English');
$heardSelected = form_old_value('heard_from', $workshop->sources[0] ?? 'LinkedIn');
?>
<main class="workshop-page">
  <div class="container workshop-wrap">
    <section class="pu" aria-labelledby="pu-title">
      <div class="pu-top">
        <p class="pu-pill">Live online workshop for parents</p>
        <img class="pu-logo" src="<?= peak_img('workshop/ppa-logo.png') ?>" alt="Peak Potential Academy" width="270" height="102">
      </div>

      <div class="pu-intro">
        <div class="pu-copy">
          <h1 id="pu-title">
            <span class="pu-title">Parenting</span>
            <span class="pu-script">Unplugged</span>
          </h1>
          <p class="pu-tagline">A calmer, more confident way to parent in a noisy digital world</p>
        </div>
        <div class="pu-photo">
          <img src="<?= peak_img('workshop/family.png') ?>" alt="A mother sitting with her teenage son and daughter" width="419" height="345">
        </div>
      </div>

      <div class="pu-host">
        <span class="pu-sk" aria-hidden="true">SK</span>
        <div>
          <strong>With Sapna KS</strong>
          <p>Top 100 Global Expert in Education · Emotional Strength Expert · 20 Years of Experience</p>
        </div>
      </div>

      <div class="pu-pillars">
        <article>
          <span class="pu-icon" aria-hidden="true">
            <svg viewBox="0 0 48 48" fill="none"><path d="M24 40c0-8 6-12 6-18 0-4-2.5-7-6-8-3.5 1-6 4-6 8 0 6 6 10 6 18Z" stroke="currentColor" stroke-width="1.8"/><path d="M24 22c-4-6-2-12 0-16 2 4 4 10 0 16Z" stroke="currentColor" stroke-width="1.8"/><path d="M18 24c-6-2-10 2-12 6 4 0 8-1 12-6Z" stroke="currentColor" stroke-width="1.8"/><path d="M30 24c6-2 10 2 12 6-4 0-8-1-12-6Z" stroke="currentColor" stroke-width="1.8"/></svg>
          </span>
          <h2>Emotional Strength</h2>
          <p>Give your teen a toolkit to manage big emotions on their own.</p>
        </article>
        <article>
          <span class="pu-icon" aria-hidden="true">
            <svg viewBox="0 0 48 48" fill="none"><path d="M24 6 38 12v12c0 9-6.2 14.6-14 18-7.8-3.4-14-9-14-18V12L24 6Z" stroke="currentColor" stroke-width="1.8"/><path d="m17 24 5 5 10-11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <h2>Healthier Boundaries</h2>
          <p>Set limits your teen respects, without the power struggle.</p>
        </article>
        <article>
          <span class="pu-icon" aria-hidden="true">
            <svg viewBox="0 0 48 48" fill="none"><path d="M10 14h20a6 6 0 0 1 6 6v6a6 6 0 0 1-6 6H20l-7 6v-6h-3a6 6 0 0 1-6-6v-6a6 6 0 0 1 6-6Z" stroke="currentColor" stroke-width="1.8"/><circle cx="18" cy="23" r="1.4" fill="currentColor"/><circle cx="24" cy="23" r="1.4" fill="currentColor"/><circle cx="30" cy="23" r="1.4" fill="currentColor"/></svg>
          </span>
          <h2>Better Conversations</h2>
          <p>Turn a shutdown into a real conversation, without it becoming a fight.</p>
        </article>
      </div>

      <div class="pu-facts">
        <div>
          <span class="pu-icon" aria-hidden="true">
            <svg viewBox="0 0 48 48" fill="none"><rect x="8" y="12" width="32" height="28" rx="4" stroke="currentColor" stroke-width="1.8"/><path d="M8 20h32M16 8v8M32 8v8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
          </span>
          <p>4th October<br>2026</p>
        </div>
        <div>
          <span class="pu-icon" aria-hidden="true">
            <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="14" stroke="currentColor" stroke-width="1.8"/><path d="M24 16v9l6 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
          <p>11:00 AM – 12:00 PM<br>(IST) · On Zoom</p>
        </div>
        <div>
          <span class="pu-icon" aria-hidden="true">
            <svg viewBox="0 0 48 48" fill="none"><circle cx="16" cy="16" r="5" stroke="currentColor" stroke-width="1.8"/><circle cx="32" cy="16" r="5" stroke="currentColor" stroke-width="1.8"/><path d="M6 36c1.2-6 5-9 10-9s8.8 3 10 9M22 36c1-4.2 3.8-7 8-7 4.6 0 8 3 9.4 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
          </span>
          <p>For Parents of<br>13+ Years</p>
        </div>
      </div>
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
