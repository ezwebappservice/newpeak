<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Rich HTML content for About Us section pages (matches shivalikrasayan.com).
 */
class ShivalikAboutPageContent extends BaseConfig
{
    /** @var array<string, string> */
    public array $pages = [];

    /** @var array<string, string> Banner paths relative to public/uploads/ */
    public array $banners = [
        'about-us'                        => 'about-pages/srl-company-bg.jpg',
        'our-core-values'                 => 'about-pages/our-values-hero.jpg',
        'our-history'                     => 'about-pages/card-history.jpg',
        'chairman-desk'                   => 'about-pages/chairman-desk.jpg',
        'corporate-social-responsibility' => 'about-pages/csr-2.jpg',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->pages = [
            'about-us'                        => $this->aboutUs(),
            'our-core-values'                 => $this->coreValues(),
            'our-history'                     => $this->history(),
            'chairman-desk'                   => $this->chairmanDesk(),
            'corporate-social-responsibility' => $this->csr(),
        ];
    }

    private function aboutUs(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Improving health through innovative products</span>
  <h2 class="srl-page-title">Shivalik Rasayan Limited</h2>
  <p class="srl-lead">Redefining innovation for healthcare — from world-class agrochemicals to advanced pharmaceutical APIs.</p>
  <p class="srl-sublead">We protect and enhance the interests of our customers, community, employees, partners and shareholders.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{about-page:srl-company-bg.jpg}" alt="Shivalik Rasayan Limited facility" class="img-fluid rounded-4 shadow-lg" width="1200" height="500">
</div>

<div class="srl-stat-grid">
  <div class="srl-stat-card reveal" data-reveal>
    <strong>#1</strong>
    <span>Largest producer of Dimethoate Technical in India</span>
  </div>
  <div class="srl-stat-card reveal" data-reveal data-reveal-delay="100">
    <strong>#2</strong>
    <span>Second largest producer of Malathion Technical in India</span>
  </div>
  <div class="srl-stat-card reveal" data-reveal data-reveal-delay="200">
    <strong>DSIR</strong>
    <span>R&amp;D Centre recognized by Govt. of India since April 2018</span>
  </div>
  <div class="srl-stat-card reveal" data-reveal data-reveal-delay="300">
    <strong>Global</strong>
    <span>Products established in India and international markets</span>
  </div>
</div>

<div class="row g-4 align-items-center srl-content-block">
  <div class="col-lg-6 reveal" data-reveal>
    <span class="section-label">Who We Are</span>
    <h3>Inspired by values, driven by vision</h3>
    <p>Shivalik Rasayan Ltd. (SRL) was established with a mission of producing effective and environment-friendly chemicals for protection of plants. SRL is the largest producer of international quality Dimethoate Technical and second largest producer of Malathion Technical in India. It also manufactures organophosphorus-based insecticides and chemicals.</p>
    <p>SRL products are well established in India and in global markets.</p>
  </div>
  <div class="col-lg-6 reveal" data-reveal data-reveal-delay="150">
    <div class="srl-image-wrap">
      <img src="{about-page:about-banner-home.jpg}" alt="Shivalik Rasayan – Redefining Innovation for Healthcare" class="img-fluid rounded-4 shadow">
    </div>
  </div>
</div>

<div class="srl-content-block reveal" data-reveal>
  <span class="section-label">Innovation &amp; Growth</span>
  <h3>Transforming healthcare through chemistry</h3>
  <div class="srl-highlight-box mb-4">
    <h4>Pharma &amp; Healthcare Expansion</h4>
    <p>With the acquisition of Medicamen Biotech Ltd, SRL has ventured into pharmaceuticals. With a state-of-the-art Research and Development Centre, SRL is dedicated to the development of Oncology and Non-Oncology active pharmaceutical ingredients and their finished dosage forms.</p>
    <p>Medicamen Biotech Limited (MBL) is well known in international markets across Africa, Latin/Central America, Far-East and CIS countries, and is in joint venture with Mission Pharma (through PharmaDanica), a key company of CFAO (Toyota) Group.</p>
  </div>
  <p>SRL is innovatively transforming healthcare spearheaded by its R&amp;D Centre at Bhiwadi. The facility is recognized by the Department of Scientific &amp; Industrial Research (DSIR), Government of India since April 2018.</p>
  <p>The state-of-the-art plant facility for Active Pharmaceutical Ingredient (API) &amp; Intermediate is under construction at Dahej, Gujarat (India).</p>
  <p>As a chemistry-diversified business group, SRL is also planning for development and commercial availability of advanced intermediates, specialty chemicals and high-grade impurities.</p>
</div>

<div class="srl-related-links">
  <h3>Explore More About SRL</h3>
  <div class="srl-link-grid srl-link-grid-images">
    <a href="our-core-values" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-core-values.jpg}" alt="Core Values"></span>
      <span class="srl-link-card-label">Core Values</span>
    </a>
    <a href="our-history" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-history.jpg}" alt="Our History"></span>
      <span class="srl-link-card-label">Our History</span>
    </a>
    <a href="leadership-at-srl" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-leadership.jpg}" alt="Leadership"></span>
      <span class="srl-link-card-label">Leadership</span>
    </a>
    <a href="corporate-social-responsibility" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-csr.jpg}" alt="CSR"></span>
      <span class="srl-link-card-label">CSR @ Shivalik</span>
    </a>
    <a href="chairman-desk" class="srl-link-card srl-link-card-img srl-link-card-icon">
      <span class="srl-link-card-media"><i class="bi bi-chat-square-quote" aria-hidden="true"></i></span>
      <span class="srl-link-card-label">Chairman's Desk</span>
    </a>
  </div>
</div>
HTML;
    }

    private function coreValues(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Our Mission</span>
  <h2 class="srl-page-title">We aspire to be the best, yet strive to be humble</h2>
  <p class="srl-lead">To be a fast-growing and leading Generic APIs and advanced key pharma intermediates company enabling affordable healthcare worldwide by redefining our healthcare products innovatively with leadership in quality and costs.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{about-page:our-values-hero.jpg}" alt="Our Core Values at Shivalik Rasayan" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-values-intro text-center reveal" data-reveal>
  <p>At SRL, our core values of <strong>Knowledge</strong>, <strong>Care</strong> and <strong>Impact</strong> have been an integral part of our guiding philosophy.</p>
</div>

<div class="row g-4 srl-value-cards">
  <div class="col-md-4 reveal" data-reveal>
    <div class="srl-value-card">
      <div class="srl-value-icon srl-value-icon-img"><img src="{about-page:icon-impact.png}" alt="Impact"></div>
      <h3>Impact</h3>
      <p>Our core values reside in our commitment to customers in meeting timelines, quality and cost.</p>
    </div>
  </div>
  <div class="col-md-4 reveal" data-reveal data-reveal-delay="100">
    <div class="srl-value-card">
      <div class="srl-value-icon srl-value-icon-img"><img src="{about-page:icon-knowledge.png}" alt="Knowledge"></div>
      <h3>Knowledge</h3>
      <p>Our values exist owing to our talented pool of scientists and associated teams for their consistent and rigorous efforts for innovation and achieving affordability for our products.</p>
    </div>
  </div>
  <div class="col-md-4 reveal" data-reveal data-reveal-delay="200">
    <div class="srl-value-card">
      <div class="srl-value-icon srl-value-icon-img"><img src="{about-page:icon-care.png}" alt="Care"></div>
      <h3>Care</h3>
      <p>We value our team, teamwork, high level of integrity, mutual trust and respect among each other.</p>
    </div>
  </div>
</div>

<div class="srl-related-links">
  <h3>Learn More</h3>
  <div class="srl-link-grid srl-link-grid-images">
    <a href="chairman-desk" class="srl-link-card srl-link-card-img srl-link-card-icon">
      <span class="srl-link-card-media"><i class="bi bi-chat-square-quote" aria-hidden="true"></i></span>
      <span class="srl-link-card-label">Chairman's Desk</span>
    </a>
    <a href="our-history" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-history.jpg}" alt="Our History"></span>
      <span class="srl-link-card-label">Our History</span>
    </a>
    <a href="leadership-at-srl" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-leadership.jpg}" alt="Leadership"></span>
      <span class="srl-link-card-label">Leadership</span>
    </a>
    <a href="corporate-social-responsibility" class="srl-link-card srl-link-card-img">
      <span class="srl-link-card-media"><img src="{about-page:card-csr.jpg}" alt="CSR"></span>
      <span class="srl-link-card-label">CSR @ Shivalik</span>
    </a>
  </div>
</div>
HTML;
    }

    private function history(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Our Journey</span>
  <h2 class="srl-page-title">SRL History</h2>
  <p class="srl-lead">Shivalik Rasayan Ltd. (SRL) originated as one of India's leading manufacturers of organophosphorus based insecticides and chemicals. In due course, it entered the highly regulated pharmaceutical industry by acquisition of Medicamen Biotech Limited.</p>
</div>

<div class="srl-milestones-image reveal" data-reveal>
  <img src="{about-page:history-milestones.png}" alt="SRL History Milestones" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-timeline reveal" data-reveal>
  <div class="srl-timeline-item">
    <div class="srl-timeline-year">2002</div>
    <div class="srl-timeline-body">
      <h4>Turnaround &amp; Acquisition</h4>
      <p>Mr. Rahul Bishnoi spearheaded the acquisition of the then sick Shivalik Rasayan Limited and subsequently transformed it into a profit-making company.</p>
    </div>
  </div>
  <div class="srl-timeline-item">
    <div class="srl-timeline-year">2003</div>
    <div class="srl-timeline-body">
      <h4>Strengthening Governance</h4>
      <p>Mr. Ashwani Sharma was appointed as Director of Shivalik Rasayan Limited, bringing decades of administrative and supply chain expertise.</p>
    </div>
  </div>
  <div class="srl-timeline-item">
    <div class="srl-timeline-year">2009</div>
    <div class="srl-timeline-body">
      <h4>CSR Commitment Begins</h4>
      <p>SRL actively engaged in Corporate Social Responsibility, supporting primary education in nearby villages of Dehradun District under the "Sab Padhe Sab Badhe" initiative.</p>
    </div>
  </div>
  <div class="srl-timeline-item">
    <div class="srl-timeline-year">2016</div>
    <div class="srl-timeline-body">
      <h4>Pharma Expansion</h4>
      <p>Acquisition of debt-ridden Medicamen Biotech Limited — marking SRL's entry into the pharmaceutical industry and global API markets.</p>
    </div>
  </div>
  <div class="srl-timeline-item">
    <div class="srl-timeline-year">2018</div>
    <div class="srl-timeline-body">
      <h4>DSIR Recognition</h4>
      <p>R&amp;D Centre at Bhiwadi recognized by the Department of Scientific &amp; Industrial Research (DSIR), Government of India.</p>
    </div>
  </div>
  <div class="srl-timeline-item">
    <div class="srl-timeline-year">Today</div>
    <div class="srl-timeline-body">
      <h4>Innovating for Tomorrow</h4>
      <p>SRL is developing Oncology and Non-Oncology APIs with a new API &amp; Intermediate plant under construction at Dahej, Gujarat — advancing specialty chemicals and high-grade impurities.</p>
    </div>
  </div>
</div>

<div class="srl-related-links">
  <h3>Explore More</h3>
  <div class="srl-link-grid">
    <a href="about-us" class="srl-link-card"><i class="bi bi-building"></i><span>About Us</span></a>
    <a href="leadership-at-srl" class="srl-link-card"><i class="bi bi-people"></i><span>Leadership</span></a>
    <a href="our-core-values" class="srl-link-card"><i class="bi bi-heart"></i><span>Core Values</span></a>
  </div>
</div>
HTML;
    }

    private function chairmanDesk(): string
    {
        return <<<'HTML'
<div class="srl-chairman-block reveal" data-reveal>
  <div class="row g-4 align-items-start">
    <div class="col-lg-4 text-center text-lg-start">
      <div class="srl-chairman-profile">
        <img src="{about-page:leader-rahul-bishnoi.jpg}" alt="Mr. Rahul Bishnoi" class="srl-chairman-photo img-fluid rounded-4 shadow">
        <h3>Mr. Rahul Bishnoi</h3>
        <p class="srl-chairman-role">Chairman, Shivalik Rasayan Limited</p>
      </div>
    </div>
    <div class="col-lg-8">
      <blockquote class="srl-quote">
        "We are committed to the pursuit of excellence in business and in society."
      </blockquote>
      <p>Rahul Bishnoi is the Chairman of Shivalik Rasayan Limited and its pharma associate Medicamen Biotech Limited. He believes that today's pharma business is highly dynamic, owing to stringent IP-driven needs of the global market.</p>
      <p>We emphasize achieving growth with a well-articulated value proposition. As a fast-growing bulk chemicals company, our business is driven by this simple philosophy.</p>
      <p>We constantly explore new growth opportunities to respond to the constantly changing industry needs. We focus on quality and innovation to flourish in the complex chemistry sphere and create our own niche. At the same time, we adhere to safe and environment-friendly operations for a sustainable future.</p>
      <p>We are building innovative chemistry and are passionately striving towards creating value for our customers, shareholders, employees and society.</p>
      <p>Our constant endeavours towards making SRL a responsible corporate are reflected in the bedrock of our business strategies. We are fully committed to making a difference in the areas of Active Pharma Ingredients (API) and Advance Pharma Intermediates by delivering optimal solutions. Our constant engagement with our stakeholders allows us to improve social, environmental and economic performance of our operations.</p>
      <p>We have on-board a team of highly experienced scientists with a proven track record who are relentlessly working on selected molecules. Besides, our associate company, Medicamen Biotech Limited will further provide us with the benefit of forward integration for our pharmaceutical value chain.</p>
      <p>As we look forward, we are focused on making the critical, strategic choices that are needed to drive a lean, disciplined operation with a view to further strengthening our foundation while leveraging our strategy to navigate our organization in the fast-moving market dynamics.</p>
      <p class="srl-signoff"><em>I remain excited, passionate and confident about this great company and its very bright future.</em></p>
    </div>
  </div>
</div>
HTML;
    }

    private function csr(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Corporate Social Responsibility</span>
  <h2 class="srl-page-title">Caring that goes beyond pharma</h2>
  <p class="srl-lead">Shivalik Rasayan Limited as a responsible corporate works with passion on Sustainable Development Goals (SDGs) adopted by all United Nations Member States in 2015 — a universal call to action to end poverty, protect the planet and ensure peace and prosperity by 2030.</p>
</div>

<div class="srl-content-block reveal" data-reveal>
  <p>Our existing policy for CSR is a testimony to the fact that corporate philosophy embeds CSR initiative and activities as a matter of great importance and value addition to the lives of people in society.</p>
  <p>Shivalik Rasayan Limited has been actively involved in CSR activities since 2009. We believe in business growth with a value-centric approach where our business interests work in harmony with society's overall interests.</p>
</div>

<div class="row g-4 srl-csr-gallery reveal" data-reveal>
  <div class="col-md-6">
    <img src="{about-page:csr-1.jpg}" alt="CSR activity at Shivalik Rasayan" class="img-fluid rounded-4 shadow">
  </div>
  <div class="col-md-6">
    <img src="{about-page:csr-2.jpg}" alt="Community outreach by Shivalik Rasayan" class="img-fluid rounded-4 shadow">
  </div>
</div>

<div class="row g-4 srl-csr-pillars">
  <div class="col-lg-6 reveal" data-reveal>
    <div class="srl-csr-card">
      <div class="srl-csr-icon"><i class="bi bi-book"></i></div>
      <h3>Education</h3>
      <p>Education is the backbone of every society. SRL focuses on strengthening educational infrastructure by supporting Government Primary Schools through teacher sponsorship since 2009–10:</p>
      <ul>
        <li>Rajkiya Prathmik Vidyalaya Aamwala</li>
        <li>Rajkiya Prathmik Vidyalaya Kolhupani Lower</li>
        <li>Rajkiya Prathmik Vidyalaya Kotra Santore</li>
        <li>Rajkiya Purva Madhyamik Vidyalaya Kolhupani Lower</li>
      </ul>
      <p>Employees actively volunteer time to inspect progress and monitor initiatives on a routine basis under the <strong>"Sab Padhe Sab Badhe"</strong> initiative.</p>
    </div>
  </div>
  <div class="col-lg-6 reveal" data-reveal data-reveal-delay="100">
    <div class="srl-csr-card">
      <div class="srl-csr-icon"><i class="bi bi-heart-pulse"></i></div>
      <h3>Health</h3>
      <p>The Company is dedicated towards providing basic healthcare facilities to communities around its manufacturing locations:</p>
      <ul>
        <li>Constructed a shed at Rajkiya Purva Madhyamik Vidyalaya Kolhupani Lower so children could take mid-day meals safely</li>
        <li>General medical check-up camps organized for neighbouring villagers once or twice a year</li>
        <li>Eye check-up camp organized during 2018–19</li>
      </ul>
    </div>
  </div>
  <div class="col-lg-6 reveal" data-reveal data-reveal-delay="150">
    <div class="srl-csr-card">
      <div class="srl-csr-icon"><i class="bi bi-people"></i></div>
      <h3>Social Welfare &amp; Support</h3>
      <p>SRL customizes CSR activities as per the needs of society and calls from nearby communities:</p>
      <ul>
        <li>Shed in Kolhupani village for assembly on religious occasions (2017–18)</li>
        <li>Community hall construction in neighbouring village of Kolhupani (2014–15)</li>
        <li>Sponsorship of "Kolhupani Kota Santore Jan Kalyan Samiti, Dehradun"</li>
        <li>Community help to neighbouring villages on advice of Gram Pradhans</li>
      </ul>
    </div>
  </div>
  <div class="col-lg-6 reveal" data-reveal data-reveal-delay="200">
    <div class="srl-csr-card">
      <div class="srl-csr-icon"><i class="bi bi-droplet"></i></div>
      <h3>Sanitization &amp; Hygiene</h3>
      <p>With the ideology of "Business has responsibility to give back to community", SRL provides RO drinking water and proper storage facilities at primary schools:</p>
      <ul>
        <li>RO machine installed in Kolhupani primary school (2014–15)</li>
        <li>Water storage facility provided in Kolhupani primary school (2014–15)</li>
        <li>Shed constructed for safe, hygienic mid-day meal environment (2014–15)</li>
      </ul>
    </div>
  </div>
  <div class="col-lg-12 reveal" data-reveal data-reveal-delay="250">
    <div class="srl-csr-card srl-csr-card-wide">
      <div class="srl-csr-icon"><i class="bi bi-music-note-beamed"></i></div>
      <h3>Cultural Activity</h3>
      <p>To nurture the rich tradition of cultural patronage, SRL sponsors annual sports and cultural functions in nearby communities to promote talent alongside education — including sponsorship of the annual sports function at Kotra Santore village high school (2016–17).</p>
    </div>
  </div>
</div>

<div class="srl-related-links">
  <h3>About SRL</h3>
  <div class="srl-link-grid">
    <a href="about-us" class="srl-link-card"><i class="bi bi-building"></i><span>About Us</span></a>
    <a href="our-core-values" class="srl-link-card"><i class="bi bi-heart"></i><span>Core Values</span></a>
    <a href="our-history" class="srl-link-card"><i class="bi bi-clock-history"></i><span>Our History</span></a>
  </div>
</div>
HTML;
    }
}
