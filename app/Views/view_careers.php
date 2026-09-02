<?php
$page = $page_dynamic_detail ?? [];
$banner = page_dynamic_banner($page['banner'] ?? '');
$jobs = $careers ?? [];
$defaultApplyEmail = trim($setting['top_bar_email'] ?? $setting['receive_email_to'] ?? '');
?>
<section class="inner-page-hero banner-slider" style="background-image: url(<?= cms_attr($banner) ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <h1><?= esc($page['name'] ?? 'Careers') ?></h1>
    </div>
  </div>
</section>

<section class="section section-inner-content srl-careers-section">
  <div class="container">
    <?php if (! empty($page['content'])): ?>
    <div class="row mb-5">
      <div class="col-lg-12">
        <div class="dynamic-page-content cms-content reveal" data-reveal>
          <?= cms_page_content($page['content'] ?? '') ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-12">
        <h2 class="srl-section-heading mb-4 reveal" data-reveal>Current Openings</h2>

        <?php if (empty($jobs)): ?>
        <div class="srl-career-empty reveal" data-reveal>
          <p class="text-muted mb-0">There are no open positions at the moment. Please check back later or send your resume to <?= $defaultApplyEmail !== '' ? '<a href="mailto:' . esc($defaultApplyEmail, 'attr') . '">' . esc($defaultApplyEmail) . '</a>' : 'our HR team' ?>.</p>
        </div>
        <?php else: ?>
        <div class="accordion srl-careers-accordion reveal" data-reveal id="careersAccordion">
          <?php foreach ($jobs as $index => $job): ?>
          <?php
            $applyEmail = trim($job['apply_email'] ?? '') ?: $defaultApplyEmail;
            $collapseId = 'careerJob' . (int) $job['id'];
          ?>
          <div class="accordion-item srl-career-item">
            <h3 class="accordion-header" id="heading<?= (int) $job['id'] ?>">
              <button class="accordion-button<?= $index > 0 ? ' collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($collapseId, 'attr') ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="<?= esc($collapseId, 'attr') ?>">
                <span class="srl-career-title"><?= esc($job['job_title']) ?></span>
                <span class="srl-career-meta">
                  <?php if (! empty($job['department'])): ?><span><i class="bi bi-building"></i> <?= esc($job['department']) ?></span><?php endif; ?>
                  <?php if (! empty($job['location'])): ?><span><i class="bi bi-geo-alt"></i> <?= esc($job['location']) ?></span><?php endif; ?>
                  <?php if (! empty($job['job_type'])): ?><span><i class="bi bi-briefcase"></i> <?= esc($job['job_type']) ?></span><?php endif; ?>
                  <?php if (! empty($job['experience'])): ?><span><i class="bi bi-bar-chart"></i> <?= esc($job['experience']) ?></span><?php endif; ?>
                </span>
              </button>
            </h3>
            <div id="<?= esc($collapseId, 'attr') ?>" class="accordion-collapse collapse<?= $index === 0 ? ' show' : '' ?>" aria-labelledby="heading<?= (int) $job['id'] ?>" data-bs-parent="#careersAccordion">
              <div class="accordion-body">
                <?php if (! empty($job['short_description'])): ?>
                <p class="srl-career-lead"><?= cms_multiline($job['short_description']) ?></p>
                <?php endif; ?>

                <?php if (! empty($job['job_description'])): ?>
                <h4>Job Description</h4>
                <div class="srl-career-block"><?= cms_multiline($job['job_description']) ?></div>
                <?php endif; ?>

                <?php if (! empty($job['requirements'])): ?>
                <h4>Requirements</h4>
                <div class="srl-career-block"><?= cms_multiline($job['requirements']) ?></div>
                <?php endif; ?>

                <?php if ($applyEmail !== ''): ?>
                <a href="mailto:<?= esc($applyEmail, 'attr') ?>?subject=<?= esc(rawurlencode('Application: ' . ($job['job_title'] ?? '')), 'attr') ?>" class="btn btn-primary mt-3">
                  <i class="bi bi-envelope me-1"></i> Apply Now
                </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
