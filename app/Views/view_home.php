<?php
$page_home = is_array($page_home ?? null) ? $page_home : [];
$page_home_lang_independent = is_array($page_home_lang_independent ?? null) ? $page_home_lang_independent : [];
$hero = peak_home_hero($page_home, $page_home_lang_independent);
?>
<!-- ===== Hero Section ===== -->
<section class="hero">
<?php if ($hero['visible']): ?>
  <div class="container">
    <div class="row align-items-end pt-5 banner-mobile">

      <!-- Left column -->
      <div class="col-lg-6">
        <p class="hero-eyebrow"><?= cms_text($hero['eyebrow']) ?></p>
        <h1 class="hero-heading">
          <?= cms_text($hero['prefix']) ?><br>
          <span class="accent"><?= cms_text($hero['highlight']) ?></span><br>
          <?= cms_text($hero['suffix']) ?>
        </h1>

        <div class="hero-features">
          <?php foreach ($hero['features'] as $feature): ?>
          <div class="hero-feature">
            <span class="icon-circle">
              <img src="<?= peak_img($feature['icon']) ?>" alt="">
            </span>
            <span class="label"><?= cms_multiline($feature['label']) ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <p class="hero-text">
          <?= cms_text($hero['lead']) ?>
        </p>

        <div class="hero-ctas  pb-5">
          <a href="<?= cms_attr($hero['btn1_url']) ?>" class="btn-primary-maroon"><?= cms_text($hero['btn1_text']) ?> <span>&rarr;</span></a>
          <a href="<?= cms_attr($hero['btn2_url']) ?>" class="btn-outline-maroon"><?= cms_text($hero['btn2_text']) ?> <span>&rarr;</span></a>
        </div>
      </div>

      <!-- Right column -->
      <div class="col-lg-6">
        <div class="hero-visual">
          <div class="hero-dots"></div>
          <div class="hero-ring"></div>
          <div class="hero-circle">
              <img src="<?= cms_attr($hero['photo']) ?>" alt="<?= cms_attr($hero['photo_alt']) ?>">
            <div class="hero-info-card">
              <div class="name"><?= cms_text($hero['card_name']) ?></div>
              <div class="role"><?= cms_text($hero['card_role']) ?></div>
              <div class="org"><?= cms_text($hero['card_org']) ?></div>
              <div class="badge-line">
                <span class="badge-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#b08a4e" stroke-width="1.8"><path d="M8 21h8M12 17v4M17 5h3a1 1 0 011 1v1a4 4 0 01-4 4M7 5H4a1 1 0 00-1 1v1a4 4 0 004 4M7 5h10v4a5 5 0 01-10 0V5z"></path></svg>
                </span>
                <span class="badge-text"><?= cms_multiline($hero['card_badge']) ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
            <a href="<?= cms_attr($hero['btn1_url']) ?>" class="hero-book-tab">
              <span class="phone-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.12.9.35 1.78.68 2.61a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.47-1.27a2 2 0 012.11-.45c.83.33 1.71.56 2.61.68A2 2 0 0122 16.92z"/></svg>
              </span>
              <span class="tab-text"><?= cms_text($hero['tab_text']) ?></span>
            </a>
<?php endif; ?>
<?= view('partials/peak_stats_bar') ?>
</section>


<?php
$page_home = is_array($page_home ?? null) ? $page_home : [];
$page_home_lang_independent = is_array($page_home_lang_independent ?? null) ? $page_home_lang_independent : [];
$show_home_video = ($page_home_lang_independent['home_welcome_status'] ?? 'Show') !== 'Hide';
$video_eyebrow = trim((string) ($page_home['home_welcome_title'] ?? '')) ?: 'Discover More';
$video_title = trim((string) ($page_home['home_welcome_subtitle'] ?? '')) ?: 'A closer look at what we do';
$video_text = trim((string) ($page_home['home_welcome_text'] ?? ''));
$video_embed = peak_video_embed_src($page_home_lang_independent['home_welcome_video'] ?? '');
?>
<?php if ($show_home_video): ?>
<!-- ===== Video Section ===== -->
<section class="video-section" aria-labelledby="video-section-title">
  <div class="container">
    <div class="row align-items-center g-4 g-lg-5">
      <div class="col-lg-5">
        <p class="video-section__eyebrow"><?= cms_text($video_eyebrow) ?></p>
        <h2 id="video-section-title"><?= cms_text($video_title) ?></h2>
        <?php if ($video_text !== ''): ?>
        <div><?= cms_html($video_text) ?></div>
        <?php else: ?>
        <p>Discover how Peak Potential Academy helps students, parents, schools, and organisations move forward with greater clarity, confidence, and purpose.</p>
        <?php endif; ?>
      </div>
      <div class="col-lg-7">
        <div class="video-section__frame ratio ratio-16x9">
          <iframe src="<?= cms_attr($video_embed) ?>" title="<?= cms_attr($video_title) ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== Invisible Loops Section ===== -->
<section class="invisible-loops" aria-labelledby="loops-title">
  <div class="container">
    <div class="loops-layout">
       <div class="loops-intro">
            <p class="loops-kicker">THE INVISIBLE LOOP <sup>TM</sup> </p>
            <h2 id="loops-title mb-3">Most people don’t lack potential. They’re trapped in <span>invisible loops.</span></h2>
          </div>
     
          <div class="loops-diagram" aria-label="Digital, emotional and behaviour loops lead to human potential decline">
            <div class="loop-card loop-card1">
              <img src="<?= peak_img('mobile-phone.png') ?>" alt="">
              <h3>Digital Loop</h3>
              <p>Short attention span<br>Poor focus<br>Constant stimulation</p>
            </div>
            <span class="loop-arrow" aria-hidden="true">→</span>
            <div class="loop-card loop-card2">
              <img src="<?= peak_img('brain.png') ?>" alt="">
              <h3>Emotional Loop</h3>
              <p>Stress<br>Self-doubt<br>Fear of failure</p>
            </div>
            <span class="loop-arrow" aria-hidden="true">→</span>
            <div class="loop-card loop-card3">
              <img src="<?= peak_img('refresh.png') ?>" alt="">
              <h3>Behaviour Loop</h3>
              <p>Reactive decisions<br>Procrastination<br>Conflict</p>
            </div>
            <img src="<?= peak_img('curve-arrow.png') ?>" alt="" class="loop-curve-arrow arrow-two" aria-hidden="true">
            <span class="loop-arrow center-arrow-ico" aria-hidden="true">→</span>
            <div class="loop-outcome">Human Potential Declines</div>
              <img src="<?= peak_img('curve-arrow.png') ?>" alt="" class="loop-curve-arrow" aria-hidden="true">
          </div>
     
    </div>
  </div>
</section>



<!-- ===== Invisible Loops Section ===== -->
<section class="invisible-loops" aria-labelledby="transformation-title">
  <div class="container">
    <div class="loops-heading">
      <p class="loops-kicker">The Transformation</p>
      <h2 id="transformation-title">The Change Parents Can See </h2>
      <p class="loops-subtitle">Practical skills that strengthen children beyond academics. </p>
    </div>

    <div class="loops-transformation">
      <article class="transformation-card transformation-card--before">
        <h3><span class="status-icon status-icon--before" aria-hidden="true">&times;</span> Before</h3>
        <ul>
          <li><span class="status-icon status-icon--before" aria-hidden="true">&times;</span>Emotional   &amp; outbursts</li>
          <li><span class="status-icon status-icon--before" aria-hidden="true">&times;</span>Screen   &amp; dependence</li>
          <li><span class="status-icon status-icon--before" aria-hidden="true">&times;</span>Low focus and academic stress</li>
          <li><span class="status-icon status-icon--before" aria-hidden="true">&times;</span>Difficulty expressing themselves </li>
          <li><span class="status-icon status-icon--before" aria-hidden="true">&times;</span>Limited money awareness </li>
        </ul>
      </article>

      <div class="transformation-arrow" aria-label="From invisible loops to limitless potential">
        <span aria-hidden="true">&rarr;</span>
        <p>From Invisible Loops<br>to Limitless Potential</p>
      </div>

      <article class="transformation-card transformation-card--after">
        <h3><span class="status-icon status-icon--after" aria-hidden="true">&#10003;</span> After</h3>
        <ul>
          <li><span class="status-icon status-icon--after" aria-hidden="true">&#10003;</span>Calmer   &amp; responses</li>
          <li><span class="status-icon status-icon--after" aria-hidden="true">&#10003;</span>Healthier digital habits </li>
          <li><span class="status-icon status-icon--after" aria-hidden="true">&#10003;</span>Better focus and resilience </li>
          <li><span class="status-icon status-icon--after" aria-hidden="true">&#10003;</span>Confident communication </li>
          <li class="transformation-highlight"><span class="status-icon status-icon--after" aria-hidden="true">&#10003;</span>Smarter financial choices </li>
        </ul>
      </article>
    </div>

  
  </div>
</section>



<!-- ===== Peak Transformation Framework ===== -->
<section class="transformation-framework" aria-labelledby="framework-title">
  <div class="container">
    <div class="framework-title-wrap">
      <span></span>
      <p id="framework-title">The Peak Transformation Framework<sup>™</sup></p>
      <span></span>
    </div>
    <ol class="framework-steps">
      <li class="framework-step">
        <span class="frameworkIconBox">
          <img src="<?= peak_img('search.png') ?>" alt="">
        </span>
        <h3>1. Identify</h3>
        <p>Become aware of<br>your patterns<br>and triggers</p>
      </li>
      <li class="framework-arrow" aria-hidden="true">→</li>
      <li class="framework-step">
        <span class="frameworkIconBox">
          <img src="<?= peak_img('link.png') ?>" alt="">
        </span>
        
        <h3>2. Break</h3>
        <p>Interrupt the loop<br>and create space<br>to choose</p>
      </li>
      <li class="framework-arrow" aria-hidden="true">→</li>
      <li class="framework-step">
        <span class="frameworkIconBox">
          <img src="<?= peak_img('refresh-single.png') ?>" alt="">
        </span>
        
        <h3>3. Replace</h3>
        <p>Build new habits<br>and healthier<br>responses</p>
      </li>
      <li class="framework-arrow" aria-hidden="true">→</li>
      <li class="framework-step">
        <span class="frameworkIconBox">
          <img src="<?= peak_img('bar-chart.png') ?>" alt="">
        </span>
        
        <h3>4. Strengthen</h3>
        <p>Strengthen core<br>human skills<br>every day</p>
      </li>
      <li class="framework-arrow" aria-hidden="true">→</li>
      <li class="framework-step framework-thrive">
        <span class="frameworkIconBox">
          <img src="<?= peak_img('user-avatar.png') ?>" alt="">
        </span>
        
        <h3>5. Thrive</h3>
        <p>Unlock your<br>potential and<br>live with purpose</p>
      </li>
    </ol>
  </div>
</section>

<!-- ===== Peak Human Skills Framework ===== -->
<section class="human-skills" aria-labelledby="skills-title">
  <div class="container">
    <p id="skills-title" class="skills-title">The Peak Human Skills Framework<sup>™</sup></p>
    <div class="skills-grid">
      <article class="skill-item">
        <span class="skill-icon" aria-hidden="true">
          <img src="<?= peak_img('emotional-intelligence.png') ?>" alt="">
        </span>
        <div>
          <h3>Emotional<br>Strength</h3>
          
        </div>
      </article>
      <article class="skill-item">
        <span class="skill-icon" aria-hidden="true">
          <img src="<?= peak_img('paralyzed.png') ?>" alt="">
        </span>
        <div>
          <h3>Mental<br>Agility</h3>
          
        </div>
      </article>
      <article class="skill-item">
        <span class="skill-icon skill-chat" aria-hidden="true">
          <img src="<?= peak_img('chat.png') ?>" alt="">
        </span>
        <div>
          <h3>Clear<br>Communication</h3>
          
        </div>
      </article>
      <article class="skill-item">
        <span class="skill-icon skill-rupee" aria-hidden="true">
          <img src="<?= peak_img('rupee-indian.png') ?>" alt="">
        </span>
        <div>
          <h3>Financial<br>Intelligence</h3>
          
        </div>
      </article>
    </div>
  </div>
</section>



<!-- ===== Transformation Outcomes ===== -->
<section class="transformation-outcomes hidden" aria-labelledby="outcomes-title">
  <div class="container">
    <div class="outcomes-layout">
      <h2 id="outcomes-title">What Changes After<br>Working With Us?</h2>
      <div class="before-after-card">
        <div class="outcome-column outcome-before">
          <h3>Before</h3>
          <ul>
            <li>Reactive</li>
            <li>Distracted</li>
            <li>Overwhelmed</li>
            <li>Anxious</li>
          </ul>
        </div>
        <span class="outcome-arrow" aria-hidden="true">›</span>
        <div class="outcome-column outcome-after">
          <h3>After</h3>
          <ul>
            <li>Focused</li>
            <li>Resilient</li>
            <li>Confident</li>
            <li>Purposeful</li>
          </ul>
        </div>
      </div>
      <div class="outcomes-message">
        <span class="lotus-mark" aria-hidden="true">♧</span>
        <h3>From Invisible Loops<br>to <span>Limitless Potential.</span></h3>
        <p>We don’t just teach skills.<br>We transform the way you think,<br>feel and show up in the world.</p>
      </div>
    </div>
  </div>
</section>


<!-- ===== Discovery Session Journey ===== -->
<section class="discovery-journey" aria-labelledby="discovery-journey-title">
  <div class="container">
    <div class="discovery-journey__main">
      <div class="discovery-journey__steps">
        <h2 id="discovery-journey-title">What happens in your <span>₹599</span> discovery session?</h2>
        <ol class="journey-steps">
          <li class="journey-step">
            <span class="journey-icon"><img src="<?= peak_img('briefcase.png') ?>" alt=""></span>
            <div><strong>1. Assess</strong><p>Science-backed Human Potential Assessment</p></div>
          </li>
          <li class="journey-step">
            <span class="journey-icon"><img src="<?= peak_img('find.png') ?>" alt=""></span>
            <div><strong>2. Identify</strong><p>Uncover your invisible loops</p></div>
          </li>
          <li class="journey-step">
            <span class="journey-icon"><img src="<?= peak_img('bar-chart-color.png') ?>" alt=""></span>
            <div><strong>3. Score</strong><p>Get your Peak Potential Score</p></div>
          </li>
          <li class="journey-step">
            <span class="journey-icon"><img src="<?= peak_img('blueprint.png') ?>" alt=""></span>
            <div><strong>4. Blueprint</strong><p>Receive your personal growth roadmap</p></div>
          </li>
          <li class="journey-step">
            <span class="journey-icon"><img src="<?= peak_img('target.png') ?>" alt=""></span>
            <div><strong>5. Transform</strong><p>Choose the right path to break the loop</p></div>
          </li>
        </ol>
      </div>
      <aside class="discovery-offer" aria-label="Discovery session offer">
        <p>Start your transformation today with our</p>
        <h3>Break the Loop<sup>™</sup><br>Discovery Session</h3>
        <strong class="discovery-price">₹599</strong>
        <span class="discovery-details">60 Minutes <i></i> 1:1 <i></i> Personalised</span>
        <a href="<?= peak_enquiry_url() ?>" class="discovery-button">Book now <span aria-hidden="true">→</span></a>
      </aside>
    </div>
  </div>
</section>
