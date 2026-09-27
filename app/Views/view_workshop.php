<?php
helper('form_ui');
/** @var \Config\Workshop $workshop */
$mediumSelected = form_old_value('medium', $workshop->mediums[0] ?? 'English');
$heardSelected = form_old_value('heard_from', $workshop->sources[0] ?? 'LinkedIn');
$fieldErrors = session()->getFlashdata('workshop_field_errors');
$fieldErrors = is_array($fieldErrors) ? $fieldErrors : [];
$fieldError = static function (string $field) use ($fieldErrors): string {
    return trim((string) ($fieldErrors[$field] ?? ''));
};
?>
<main class="workshop-page">
  <div class="container workshop-wrap">
    <section class="pu-poster" aria-labelledby="pu-title">
      <h1 id="pu-title" class="pu-poster-title">Parenting Unplugged</h1>
      <img src="<?= peak_img('workshop/parenting-unplugged.jpg') ?>" alt="Parenting Unplugged, a live online workshop for parents on 4th October 2026, 11:00 AM to 12:00 PM IST, on Zoom. For parents of 13 to 20 years. Seat fee ₹299, 70% off ₹999." width="1024" height="501">
    </section>

    <section class="workshop-body">
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
            <input type="text" name="first_name" id="first_name" value="<?= esc(form_old_value('first_name')) ?>" placeholder="e.g. Anita" required maxlength="80" autocomplete="given-name" aria-describedby="first_name-error"<?= $fieldError('first_name') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="first_name-error"<?= $fieldError('first_name') === '' ? ' hidden' : '' ?>><?= esc($fieldError('first_name')) ?></small>
          </label>
          <label>
            Last Name <span>*</span>
            <input type="text" name="last_name" id="last_name" value="<?= esc(form_old_value('last_name')) ?>" placeholder="e.g. Sharma" required maxlength="80" autocomplete="family-name" aria-describedby="last_name-error"<?= $fieldError('last_name') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="last_name-error"<?= $fieldError('last_name') === '' ? ' hidden' : '' ?>><?= esc($fieldError('last_name')) ?></small>
          </label>
          <label>
            WhatsApp Contact Number <span>*</span>
            <input type="tel" name="phone" id="phone" value="<?= esc(form_old_value('phone')) ?>" placeholder="+91 98765 43210" required maxlength="20" autocomplete="tel" inputmode="tel" aria-describedby="phone-error"<?= $fieldError('phone') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="phone-error"<?= $fieldError('phone') === '' ? ' hidden' : '' ?>><?= esc($fieldError('phone')) ?></small>
          </label>
          <label>
            Email ID <span>*</span>
            <input type="email" name="email" id="email" value="<?= esc(form_old_value('email')) ?>" placeholder="anita.sharma@email.com" required maxlength="255" autocomplete="email" aria-describedby="email-error"<?= $fieldError('email') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="email-error"<?= $fieldError('email') === '' ? ' hidden' : '' ?>><?= esc($fieldError('email')) ?></small>
          </label>
        </div>

        <h2 class="workshop-kicker">Workshop preferences</h2>
        <fieldset class="workshop-field">
          <legend>Preferred Medium of Instruction <span>*</span></legend>
          <div class="workshop-choice<?= $fieldError('medium') !== '' ? ' is-invalid' : '' ?>">
            <?php foreach ($workshop->mediums as $option): ?>
              <label>
                <input type="radio" name="medium" value="<?= esc($option, 'attr') ?>" <?= $mediumSelected === $option ? 'checked' : '' ?> required>
                <?= esc($option) ?>
              </label>
            <?php endforeach; ?>
          </div>
          <small class="workshop-error" id="medium-error"<?= $fieldError('medium') === '' ? ' hidden' : '' ?>><?= esc($fieldError('medium')) ?></small>
        </fieldset>

        <label class="workshop-field">
          Is there a topic you’d like us to include in the workshop?
          <textarea name="topic" id="topic" rows="3" maxlength="1000" placeholder="e.g. Handling exam stress conversations at home" aria-describedby="topic-error"<?= $fieldError('topic') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>><?= esc(form_old_value('topic')) ?></textarea>
          <small class="workshop-error" id="topic-error"<?= $fieldError('topic') === '' ? ' hidden' : '' ?>><?= esc($fieldError('topic')) ?></small>
        </label>

        <fieldset class="workshop-field">
          <legend>How did you hear about this workshop? <span>*</span></legend>
          <div class="workshop-choice<?= $fieldError('heard_from') !== '' ? ' is-invalid' : '' ?>">
            <?php foreach ($workshop->sources as $option): ?>
              <label>
                <input type="radio" name="heard_from" value="<?= esc($option, 'attr') ?>" <?= $heardSelected === $option ? 'checked' : '' ?> required>
                <?= esc($option) ?>
              </label>
            <?php endforeach; ?>
          </div>
          <small class="workshop-error" id="heard_from-error"<?= $fieldError('heard_from') === '' ? ' hidden' : '' ?>><?= esc($fieldError('heard_from')) ?></small>
        </fieldset>

        <p class="workshop-fee">Seat fee <?= esc($workshop->amountLabel()) ?> · paid securely with Razorpay</p>
        <button type="submit" class="workshop-submit" id="workshop-reserve">Grab your seat · <?= esc($workshop->amountLabel()) ?></button>
        <p class="workshop-signoff">Peak Potential Academy &nbsp;|&nbsp; Calmer Parents. Brighter Tomorrows.</p>
      </form>
    </section>
  </div>
</main>
<script>
(function () {
  var form = document.getElementById('workshop-form');
  var button = document.getElementById('workshop-reserve');
  var buttonLabel = button.textContent;

  function digits(value) {
    return String(value || '').replace(/\D/g, '');
  }

  function validName(value) {
    var name = String(value || '').trim();
    if (name.length < 2 || name.length > 80) return false;
    if (/https?:|www\.|<|>|@|\d/i.test(name)) return false;
    return /^[\p{L}\p{M}\s'.-]+$/u.test(name);
  }

  function validPhone(value) {
    var number = digits(value);
    if (number.indexOf('91') === 0 && number.length === 12) number = number.slice(2);
    else if (number.charAt(0) === '0' && number.length === 11) number = number.slice(1);
    return /^[6-9]\d{9}$/.test(number);
  }

  function validEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(String(value || '').trim());
  }

  function setError(name, message) {
    var fields = form.querySelectorAll('[name="' + name + '"]');
    var error = document.getElementById(name + '-error');
    var box = fields[0] ? fields[0].closest('.workshop-choice') : null;
    fields.forEach(function (field) {
      if (field.type === 'radio' || field.type === 'checkbox') return;
      field.classList.toggle('is-invalid', !!message);
      field.setAttribute('aria-invalid', message ? 'true' : 'false');
    });
    if (box) box.classList.toggle('is-invalid', !!message);
    if (error) {
      error.textContent = message || '';
      error.hidden = !message;
    }
  }

  function validate() {
    var data = new FormData(form);
    var firstInvalid = null;
    var checks = [
      ['first_name', (function () {
        var value = String(data.get('first_name') || '');
        if (value.trim() === '') return 'Please enter your first name.';
        if (!validName(value)) return 'Please enter a valid first name.';
        return '';
      })()],
      ['last_name', (function () {
        var value = String(data.get('last_name') || '');
        if (value.trim() === '') return 'Please enter your last name.';
        if (!validName(value)) return 'Please enter a valid last name.';
        return '';
      })()],
      ['phone', (function () {
        var value = String(data.get('phone') || '');
        if (value.trim() === '') return 'Please enter your WhatsApp number.';
        if (!validPhone(value)) return 'Please enter a valid 10-digit WhatsApp number.';
        return '';
      })()],
      ['email', (function () {
        var value = String(data.get('email') || '');
        if (value.trim() === '') return 'Please enter your email address.';
        if (!validEmail(value)) return 'Please enter a valid email address.';
        return '';
      })()],
      ['medium', data.get('medium') ? '' : 'Please choose a preferred medium of instruction.'],
      ['topic', String(data.get('topic') || '').length > 1000 ? 'The topic is too long.' : ''],
      ['heard_from', data.get('heard_from') ? '' : 'Please tell us how you heard about this workshop.']
    ];

    checks.forEach(function (check) {
      setError(check[0], check[1]);
      if (check[1] && !firstInvalid) firstInvalid = form.querySelector('[name="' + check[0] + '"]');
    });

    if (firstInvalid) {
      firstInvalid.focus();
      var message = document.getElementById(firstInvalid.name + '-error');
      if (message) message.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }

    return !firstInvalid;
  }

  form.addEventListener('submit', function (event) {
    if (!validate()) {
      event.preventDefault();
      button.disabled = false;
      button.textContent = buttonLabel;
      return;
    }
    button.disabled = true;
    button.textContent = 'Please wait…';
  });

  form.addEventListener('input', function (event) {
    if (event.target && event.target.name) setError(event.target.name, '');
  });

  var existing = form.querySelector('.is-invalid');
  if (existing) existing.focus();
})();
</script>
