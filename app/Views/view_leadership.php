<section class="inner-page-hero banner-slider srl-leadership-hero" style="background-image: url(<?= theme_upload($setting['banner_team'] ?? '', theme_asset('images/hero-bg.jpg')) ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <h1><?= esc($page_team['team_heading'] ?? 'Leadership Team') ?></h1>
    </div>
  </div>
</section>

<section class="section section-inner-content srl-leadership-section">
  <div class="container">
    <div class="srl-page-intro text-center reveal" data-reveal>
      <?php if (! empty($page_team['team_subtitle'])): ?>
      <span class="srl-kicker"><?= esc($page_team['team_subtitle']) ?></span>
      <?php endif; ?>
      <h2 class="srl-page-title"><?= esc($page_team['team_heading'] ?? 'Leadership Team') ?></h2>
      <?php if (! empty($page_team['team_intro'])): ?>
      <p class="srl-lead"><?= esc($page_team['team_intro']) ?></p>
      <?php endif; ?>
    </div>

    <?php if (empty($team_members)): ?>
    <div class="srl-highlight-box text-center reveal" data-reveal>
      <p class="mb-0">Leadership profiles will appear here. Add team members via <strong>Admin → Team Member</strong>.</p>
    </div>
    <?php else: ?>
    <div class="srl-leadership-profiles">
      <?php $i = 0; foreach ($team_members as $member): $i++; ?>
      <article class="srl-leader-profile reveal<?= $i % 2 === 0 ? ' srl-leader-profile-alt' : '' ?>" data-reveal<?= $i > 1 ? ' data-reveal-delay="' . min(($i - 1) * 60, 240) . '"' : '' ?>>
        <div class="row g-4 g-lg-5 align-items-start">
          <div class="col-md-4 col-lg-3">
            <div class="srl-leader-profile-photo">
              <img src="<?= theme_upload($member['photo'] ?? '') ?>"
                   alt="<?= esc($member['name']) ?>" width="320" height="400" loading="lazy">
            </div>
          </div>
          <div class="col-md-8 col-lg-9">
            <div class="srl-leader-profile-body">
              <h3><?= esc($member['name']) ?></h3>
              <p class="srl-leader-role"><?= esc($member['designation']) ?></p>
              <div class="srl-leader-bio cms-content dynamic-page-content">
                <?= cms_html($member['detail'] ?? '') ?>
              </div>
            </div>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="srl-related-links reveal" data-reveal>
      <h3>Related Pages</h3>
      <div class="srl-link-grid">
        <a href="<?= dynamic_page_url('chairman-desk') ?>" class="srl-link-card"><i class="bi bi-chat-quote"></i><span>Chairman's Desk</span></a>
        <a href="<?= dynamic_page_url('about-us') ?>" class="srl-link-card"><i class="bi bi-building"></i><span>About Us</span></a>
        <a href="<?= dynamic_page_url('board-of-directors') ?>" class="srl-link-card"><i class="bi bi-diagram-3"></i><span>Board of Directors</span></a>
      </div>
    </div>
  </div>
</section>
