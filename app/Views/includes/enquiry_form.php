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
    <label>First Name <span class="text-danger">*</span><input type="text" name="first_name" value="<?= esc(form_old_value('first_name')) ?>" required></label>
    <label>Last Name <span class="text-danger">*</span><input type="text" name="last_name" value="<?= esc(form_old_value('last_name')) ?>" required></label>
    <label>Email ID <span class="text-danger">*</span><input type="email" name="email" value="<?= esc(form_old_value('email')) ?>" required></label>
    <label>WhatsApp Contact Number <span class="text-danger">*</span><input type="tel" name="phone" inputmode="tel" value="<?= esc(form_old_value('phone')) ?>" required></label>
    <label>Country <span class="text-danger">*</span>
     <select name="country" required>
    <option value="" disabled<?= form_old_value('country') === '' ? ' selected' : '' ?>>Select country</option>
    <?php
    $countries = [
        'Afghanistan',
        'Albania',
        'Algeria',
        'Andorra',
        'Angola',
        'Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Australia',
        'Austria',
        'Azerbaijan',
        'Bahamas',
        'Bahrain',
        'Bangladesh',
        'Barbados',
        'Belarus',
        'Belgium',
        'Belize',
        'Benin',
        'Bhutan',
        'Bolivia',
        'Bosnia and Herzegovina',
        'Botswana',
        'Brazil',
        'Brunei',
        'Bulgaria',
        'Burkina Faso',
        'Burundi',
        'Cambodia',
        'Cameroon',
        'Canada',
        'Cape Verde',
        'Central African Republic',
        'Chad',
        'Chile',
        'China',
        'Colombia',
        'Comoros',
        'Congo',
        'Costa Rica',
        'Croatia',
        'Cuba',
        'Cyprus',
        'Czech Republic',
        'Denmark',
        'Djibouti',
        'Dominica',
        'Dominican Republic',
        'Ecuador',
        'Egypt',
        'El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
        'Eswatini',
        'Ethiopia',
        'Fiji',
        'Finland',
        'France',
        'Gabon',
        'Gambia',
        'Georgia',
        'Germany',
        'Ghana',
        'Greece',
        'Grenada',
        'Guatemala',
        'Guinea',
        'Guinea-Bissau',
        'Guyana',
        'Haiti',
        'Honduras',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Kuwait',
        'Kyrgyzstan',
        'Laos',
        'Latvia',
        'Lebanon',
        'Lesotho',
        'Liberia',
        'Libya',
        'Liechtenstein',
        'Lithuania',
        'Luxembourg',
        'Madagascar',
        'Malawi',
        'Malaysia',
        'Maldives',
        'Mali',
        'Malta',
        'Marshall Islands',
        'Mauritania',
        'Mauritius',
        'Mexico',
        'Micronesia',
        'Moldova',
        'Monaco',
        'Mongolia',
        'Montenegro',
        'Morocco',
        'Mozambique',
        'Myanmar',
        'Namibia',
        'Nauru',
        'Nepal',
        'Netherlands',
        'New Zealand',
        'Nicaragua',
        'Niger',
        'Nigeria',
        'North Korea',
        'North Macedonia',
        'Norway',
        'Oman',
        'Pakistan',
        'Palau',
        'Palestine',
        'Panama',
        'Papua New Guinea',
        'Paraguay',
        'Peru',
        'Philippines',
        'Poland',
        'Portugal',
        'Qatar',
        'Romania',
        'Russia',
        'Rwanda',
        'Saint Kitts and Nevis',
        'Saint Lucia',
        'Saint Vincent and the Grenadines',
        'Samoa',
        'San Marino',
        'Sao Tome and Principe',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Seychelles',
        'Sierra Leone',
        'Singapore',
        'Slovakia',
        'Slovenia',
        'Solomon Islands',
        'Somalia',
        'South Africa',
        'South Korea',
        'South Sudan',
        'Spain',
        'Sri Lanka',
        'Sudan',
        'Suriname',
        'Sweden',
        'Switzerland',
        'Syria',
        'Taiwan',
        'Tajikistan',
        'Tanzania',
        'Thailand',
        'Timor-Leste',
        'Togo',
        'Tonga',
        'Trinidad and Tobago',
        'Tunisia',
        'Turkey',
        'Turkmenistan',
        'Tuvalu',
        'Uganda',
        'Ukraine',
        'United Arab Emirates',
        'United Kingdom',
        'United States',
        'Uruguay',
        'Uzbekistan',
        'Vanuatu',
        'Vatican City',
        'Venezuela',
        'Vietnam',
        'Yemen',
        'Zambia',
        'Zimbabwe'
    ];


foreach ($countries as $country):
?>
    <option value="<?= esc($country) ?>"<?= form_old_value('country') === $country ? ' selected' : '' ?>>
        <?= esc($country) ?>
    </option>
<?php endforeach; ?>


</select>

    </label>
    <label>City <span class="text-danger">*</span>
      <input type="text" name="city" value="<?= esc(form_old_value('city')) ?>" placeholder="Enter city" required>

     
    </label>
    <label>Are you applying as? <span class="text-danger">*</span>
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
    <label>Which program are you interested in? <span class="text-danger">*</span>
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
      <label>When should we meet? <span class="text-danger">*</span><input type="date" name="meeting_date" value="<?= esc(form_old_value('meeting_date')) ?>" required></label>
      <label>Select time of day <span class="text-danger">*</span>
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
