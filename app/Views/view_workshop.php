<?php
helper(['form_ui', 'theme']);
/** @var \Config\Workshop $workshop */
$mediumSelected = form_old_value('medium');
$heardSelected = form_old_value('heard_from');
$fieldErrors = session()->getFlashdata('workshop_field_errors');
$fieldErrors = is_array($fieldErrors) ? $fieldErrors : [];
$fieldError = static function (string $field) use ($fieldErrors): string {
    return trim((string) ($fieldErrors[$field] ?? ''));
};
$amount = $workshop->amountLabel();
$facilitator = peak_home_hero($page_home ?? [], $page_home_lang_independent ?? []);
$facilitatorPhoto = $facilitator['photo'] ?? peak_img('14 hero section image.webp');
?>
<main class="pu-page">
  <section class="pu-hero">
    <div class="pu-wrap">
      <div class="pu-eyebrow">Parenting Unplugged · Peak Potential Academy</div>
      <h1>Understand<br><span class="pu-accent">Your Teen</span><br>Before the Next<br>Fight Starts.</h1>
      <p class="pu-lead">A live, interactive workshop for parents of teenagers — on why the silence, the screen fights, and the “nothing” answers happen, and what actually helps.</p>
      <div class="pu-pills">
        <span class="pu-pill">4th October 2026</span>
        <span class="pu-pill">11:00 AM – 12:00 PM</span>
        <span class="pu-pill">Live on Zoom</span>
        <span class="pu-pill">Limited Seats</span>
      </div>
      <a href="#register" class="pu-cta">Grab your seat · <?= esc($amount) ?></a>
      <div class="pu-micro">Seat fee <?= esc($amount) ?> · Paid securely with Razorpay</div>
    </div>
  </section>

  <section class="pu-tabs-section">
    <div class="pu-wrap">
      <h2 class="pu-section-title">Your parenting mind has<br><span class="pu-accent">too many tabs open.</span></h2>
      <p class="pu-section-sub">When every concern is running in the background, even a small conversation can turn into conflict.</p>
      <div class="pu-browser">
        <div class="pu-browserbar" aria-hidden="true"><span class="pu-dot"></span><span class="pu-dot"></span><span class="pu-dot"></span></div>
        <div class="pu-tabs">
          <span class="pu-tab">Screen Time ×</span>
          <span class="pu-tab">Backchat ×</span>
          <span class="pu-tab">Silent Treatment ×</span>
          <span class="pu-tab">Comparison ×</span>
          <span class="pu-tab">Exam Pressure ×</span>
          <span class="pu-tab">“Nothing, Mom.” ×</span>
          <span class="pu-tab">Trust Issues ×</span>
          <span class="pu-tab">Overthinking ×</span>
          <span class="pu-tab pu-tab-you">YOU ×</span>
        </div>
        <div class="pu-address">your-home › tonight › dinner-table</div>
      </div>
      <div class="pu-questions">
        <div class="pu-question">“Am I being too strict?”</div>
        <div class="pu-question">“Am I giving too much freedom?”</div>
        <div class="pu-question">“Should I step in?”</div>
        <div class="pu-question">“Or should I let them figure it out?”</div>
      </div>
    </div>
  </section>

  <section class="pu-section">
    <div class="pu-wrap">
      <h2 class="pu-section-title">What you'll walk away with</h2>
      <p class="pu-section-sub">Sixty minutes. No jargon. Just practical tools.</p>
      <div class="pu-cards">
        <article class="pu-card">
          <h3>Understand the shutdown</h3>
          <p>What may be happening behind silence, anger, defensiveness and “nothing.”</p>
        </article>
        <article class="pu-card">
          <h3>Reconnect without interrogating</h3>
          <p>Listen → Understand → Ask → Respond. Start a conversation without immediately fixing it.</p>
        </article>
        <article class="pu-card">
          <h3>Set boundaries without battles</h3>
          <p>Create limits while protecting trust and accountability. Freedom = Trust + Responsibility.</p>
        </article>
        <article class="pu-card">
          <h3>Build emotional strength</h3>
          <p>Support difficult emotions without dismissing, fixing or rescuing. Supporting ≠ Rescuing.</p>
        </article>
      </div>
      <div class="pu-eventbar">
        <div><small>Date</small><b>4 Oct 2026</b></div>
        <div><small>Time</small><b>11 AM – 12 PM</b></div>
        <div><small>Format</small><b>Live on Zoom</b></div>
        <div><small>Seat fee</small><b><?= esc($amount) ?></b></div>
      </div>
    </div>
  </section>

  <section class="pu-facilitator">
    <div class="pu-wrap">
      <h2 class="pu-section-title">Meet your facilitator</h2>
      <div class="pu-bio">
        <img src="<?= esc($facilitatorPhoto) ?>" alt="Sapna KS, founder of Peak Potential Academy" width="420" height="420">
        <div>
          <h3>Sapna KS</h3>
          <div class="pu-role">Founder, Peak Potential Academy · 20+ Years of Experience</div>
          <ul>
            <li>M.Sc. &amp; M.Phil. in Mathematics, MBA, Strategic Leadership Programme at IIM</li>
            <li>15+ years in education leadership; former leader at Unacademy and Physics Wallah</li>
            <li>Top 100 Global Expert in Education Impact</li>
            <li>Awardee, 35th World Education Summit, Dubai</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="pu-section">
    <div class="pu-wrap">
      <h2 class="pu-section-title">Good to know</h2>
      <div class="pu-faq">
        <div class="pu-faqitem">
          <b>Who is this for?</b>
          <p>Parents and caregivers of 13–20 year olds, whether things are calm at home right now or feeling difficult.</p>
        </div>
        <div class="pu-faqitem">
          <b>How do I join?</b>
          <p>Complete the registration form and payment. The Zoom joining link will be shared separately 24 hours before the workshop.</p>
        </div>
        <div class="pu-faqitem">
          <b>Is this interactive?</b>
          <p>Yes. Bring a notebook, pen and one real parenting situation you would like to think through differently.</p>
        </div>
        <div class="pu-faqitem">
          <b>What is the refund policy?</b>
          <p>Seats are non-refundable once booked, given the limited group size.</p>
        </div>
      </div>
      <div class="pu-final">
        <h2>Seats are limited.</h2>
        <p>Reserve yours before this workshop fills up.</p>
        <a href="#register" class="pu-cta">Grab your seat · <?= esc($amount) ?></a>
      </div>
    </div>
  </section>

  <section class="pu-register" id="register">
    <div class="pu-wrap">
      <h2 class="pu-section-title">Reserve your seat</h2>
      <p class="pu-section-sub">Complete your details below, then continue to secure payment.</p>
      <form class="pu-formbox workshop-form" id="workshop-form" method="post" action="<?= base_url('workshop-registration/checkout') ?>" novalidate>
        <?= csrf_field() ?>
        <div class="srl-form-antispam-hp" aria-hidden="true">
          <label for="company_website">Company website</label>
          <input type="text" name="company_website" id="company_website" value="" tabindex="-1" autocomplete="off">
        </div>

        <?= view('includes/form_flash_alerts', ['flash_key' => 'workshop_form_error']) ?>

        <div class="pu-label">Your details</div>
        <div class="pu-grid workshop-grid">
          <div>
            <label for="first_name">First Name *</label>
            <input type="text" name="first_name" id="first_name" value="<?= esc(form_old_value('first_name')) ?>" required maxlength="80" autocomplete="given-name" aria-describedby="first_name-error"<?= $fieldError('first_name') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="first_name-error"<?= $fieldError('first_name') === '' ? ' hidden' : '' ?>><?= esc($fieldError('first_name')) ?></small>
          </div>
          <div>
            <label for="last_name">Last Name *</label>
            <input type="text" name="last_name" id="last_name" value="<?= esc(form_old_value('last_name')) ?>" required maxlength="80" autocomplete="family-name" aria-describedby="last_name-error"<?= $fieldError('last_name') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="last_name-error"<?= $fieldError('last_name') === '' ? ' hidden' : '' ?>><?= esc($fieldError('last_name')) ?></small>
          </div>
          <div>
            <label for="phone">WhatsApp Contact Number *</label>
            <input type="tel" name="phone" id="phone" value="<?= esc(form_old_value('phone')) ?>" required maxlength="20" autocomplete="tel" inputmode="tel" aria-describedby="phone-error"<?= $fieldError('phone') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="phone-error"<?= $fieldError('phone') === '' ? ' hidden' : '' ?>><?= esc($fieldError('phone')) ?></small>
          </div>
          <div>
            <label for="email">Email ID *</label>
            <input type="email" name="email" id="email" value="<?= esc(form_old_value('email')) ?>" required maxlength="255" autocomplete="email" aria-describedby="email-error"<?= $fieldError('email') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="workshop-error" id="email-error"<?= $fieldError('email') === '' ? ' hidden' : '' ?>><?= esc($fieldError('email')) ?></small>
          </div>
        </div>

        <div class="pu-label">Workshop preferences</div>
        <fieldset class="workshop-field">
          <legend>Preferred Medium of Instruction *</legend>
          <div class="pu-radios workshop-choice<?= $fieldError('medium') !== '' ? ' is-invalid' : '' ?>">
            <?php foreach ($workshop->mediums as $option): ?>
              <label>
                <input type="radio" name="medium" value="<?= esc($option, 'attr') ?>" <?= $mediumSelected === $option ? 'checked' : '' ?> required>
                <?= esc($option) ?>
              </label>
            <?php endforeach; ?>
          </div>
          <small class="workshop-error" id="medium-error"<?= $fieldError('medium') === '' ? ' hidden' : '' ?>><?= esc($fieldError('medium')) ?></small>
        </fieldset>

        <div class="pu-topic">
          <label for="topic">Is there a topic you'd like us to include in the workshop?</label>
          <textarea name="topic" id="topic" rows="3" maxlength="1000" placeholder="e.g. Handling exam stress conversations at home" aria-describedby="topic-error"<?= $fieldError('topic') !== '' ? ' class="is-invalid" aria-invalid="true"' : '' ?>><?= esc(form_old_value('topic')) ?></textarea>
          <small class="workshop-error" id="topic-error"<?= $fieldError('topic') === '' ? ' hidden' : '' ?>><?= esc($fieldError('topic')) ?></small>
        </div>

        <fieldset class="workshop-field pu-topic">
          <legend>How did you hear about this workshop? *</legend>
          <div class="pu-radios workshop-choice<?= $fieldError('heard_from') !== '' ? ' is-invalid' : '' ?>">
            <?php foreach ($workshop->sources as $option): ?>
              <label>
                <input type="radio" name="heard_from" value="<?= esc($option, 'attr') ?>" <?= $heardSelected === $option ? 'checked' : '' ?> required>
                <?= esc($option) ?>
              </label>
            <?php endforeach; ?>
          </div>
          <small class="workshop-error" id="heard_from-error"<?= $fieldError('heard_from') === '' ? ' hidden' : '' ?>><?= esc($fieldError('heard_from')) ?></small>
        </fieldset>

        <p class="pu-paynote workshop-fee">Seat fee <?= esc($amount) ?> · Paid securely with Razorpay</p>
        <button class="pu-submit workshop-submit" id="workshop-reserve" type="submit">Grab your seat · <?= esc($amount) ?></button>
      </form>
    </div>
  </section>

  <div class="pu-close">
    <div class="pu-tag">Calmer Parents. Brighter Tomorrows.</div>
    <div>Peak Potential Academy · Parenting Unplugged</div>
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
