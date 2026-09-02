<?php
helper(['form', 'form_ui']);
$oldChallenges = old('challenges') ?? [];
if (! is_array($oldChallenges)) {
    $oldChallenges = $oldChallenges !== '' && $oldChallenges !== null ? [$oldChallenges] : [];
}
$programs = [
    'Discovery Call',
    'One-to-One Session',
    'Student Workshop — 60 Minutes',
    'Student Bootcamp — Five-Day Program',
    'Parent Workshop — 60 Minutes',
    'Parent Bootcamp — Five-Day Program',
    'School Partnerships',
    'Corporate Partnerships',
];
$challenges = [
    'Parenting',
    'Exam Pressure',
    'Screen Dependency',
    'Behavioural Challenges',
    'Communication',
    'Corporate Leadership',
    'Others',
];
?>
<?= form_open(base_url('enquiry/send'), ['class' => 'discovery-form enquiry-card', 'id' => 'enquiry-form']) ?>
  <input type="hidden" name="return_url" value="<?= esc(peak_enquiry_url()) ?>">
  <div class="enquiry-card__heading">
    <p class="enquiry-eyebrow">Personal details</p>
    <h2>Customer Enquiry Form</h2>
    <p>Please complete the required fields and we will be in touch soon.</p>
  </div>
  <?= view('includes/form_flash_alerts', ['flash_key' => 'discovery_form_error', 'success_key' => 'discovery_form_success']) ?>
  <div class="discovery-form__grid">
    <label>First Name<input type="text" name="first_name" value="<?= esc(form_old_value('first_name')) ?>" required></label>
    <label>Last Name<input type="text" name="last_name" value="<?= esc(form_old_value('last_name')) ?>" required></label>
    <label>Email ID<input type="email" name="email" value="<?= esc(form_old_value('email')) ?>" required></label>
    <label>WhatsApp Contact Number<input type="tel" name="phone" inputmode="tel" value="<?= esc(form_old_value('phone')) ?>" required></label>
    <label>Country
      <select name="country" required>
        <option value="" disabled<?= form_old_value('country') === '' ? ' selected' : '' ?>>Select country</option>
        <?php foreach (['India', 'United States', 'United Kingdom', 'Other'] as $country): ?>
        <option value="<?= esc($country) ?>"<?= form_old_value('country') === $country ? ' selected' : '' ?>><?= esc($country) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>City
      <select name="city" required>
        <option value="" disabled<?= form_old_value('city') === '' ? ' selected' : '' ?>>Select city</option>
        <?php foreach (['New Delhi', 'Mumbai', 'Bengaluru', 'Other'] as $city): ?>
        <option value="<?= esc($city) ?>"<?= form_old_value('city') === $city ? ' selected' : '' ?>><?= esc($city) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>Are you applying as?
      <select name="applicant" required>
        <option value="" disabled<?= form_old_value('applicant') === '' ? ' selected' : '' ?>>Select one</option>
        <?php foreach (['Student', 'Parent', 'Working Professional'] as $applicant): ?>
        <option value="<?= esc($applicant) ?>"<?= form_old_value('applicant') === $applicant ? ' selected' : '' ?>><?= esc($applicant) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>Student/Attendee Age<input type="number" name="age" min="1" max="120" value="<?= esc(form_old_value('age')) ?>"></label>
  </div>
  <fieldset>
    <legend>Program Selection</legend>
    <label>Which program are you interested in?
      <select name="program" required>
        <option value="" disabled<?= form_old_value('program') === '' ? ' selected' : '' ?>>Select a program</option>
        <?php foreach ($programs as $program): ?>
        <option value="<?= esc($program) ?>"<?= form_old_value('program') === $program ? ' selected' : '' ?>><?= esc($program) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </fieldset>
  <fieldset>
    <legend>Challenges</legend>
    <label>What challenges do you want us to address?
      <select name="challenge_focus">
        <option value="" disabled<?= form_old_value('challenge_focus') === '' ? ' selected' : '' ?>>Select a focus area</option>
        <?php foreach (['Academic performance', 'Behaviour and emotions', 'Screen dependency', 'Parenting support'] as $focus): ?>
        <option value="<?= esc($focus) ?>"<?= form_old_value('challenge_focus') === $focus ? ' selected' : '' ?>><?= esc($focus) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <span class="discovery-form__label mt-2">Select your top challenges</span>
    <div class="discovery-form__checks">
      <?php foreach ($challenges as $challenge): ?>
      <label><input type="checkbox" name="challenges[]" value="<?= esc($challenge) ?>"<?= in_array($challenge, $oldChallenges, true) ? ' checked' : '' ?>> <?= esc($challenge) ?></label>
      <?php endforeach; ?>
    </div>
    <label>If “Others”, please specify<input type="text" name="other_challenge" value="<?= esc(form_old_value('other_challenge')) ?>"></label>
  </fieldset>
  <fieldset>
    <legend>Scheduling</legend>
    <div class="discovery-form__grid">
      <label>When should we meet?<input type="date" name="meeting_date" value="<?= esc(form_old_value('meeting_date')) ?>" required></label>
      <label>Select time of day
        <select name="meeting_time" required>
          <option value="" disabled<?= form_old_value('meeting_time') === '' ? ' selected' : '' ?>>Select a time</option>
          <?php foreach (['Morning (9 AM – 12 PM)', 'Afternoon (12 PM – 4 PM)', 'Evening (4 PM – 7 PM)'] as $time): ?>
          <option value="<?= esc($time) ?>"<?= form_old_value('meeting_time') === $time ? ' selected' : '' ?>><?= esc($time) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
  </fieldset>
  <?= view('includes/form_antispam_fields', ['form_key' => 'discovery_inquiry', 'compact' => true]) ?>
  <button type="submit" class="discovery-form__submit" name="form_discovery" value="1">Send enquiry</button>
<?= form_close() ?>
