<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Rich HTML content for Business Unit pages (matches shivalikrasayan.com).
 */
class ShivalikBusinessUnitPageContent extends BaseConfig
{
    /** @var array<string, string> */
    public array $pages = [];

    /** @var array<string, string> Banner paths relative to public/uploads/ */
    public array $banners = [
        'api-focus-area'              => 'business-units/api-focus-hero.jpg',
        'research-and-development-bu' => 'business-units/rnd-hero.png',
        'agrochemical-bu'             => 'business-units/agro-hero.jpg',
        'specialty-chemicals'         => 'business-units/specialty-chemicals.jpg',
        'intellectual-property-bu'    => 'business-units/ip-banner.jpg',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->pages = [
            'api-focus-area'              => $this->apiFocusArea(),
            'research-and-development-bu' => $this->researchDevelopment(),
            'agrochemical-bu'             => $this->agrochemical(),
            'specialty-chemicals'         => $this->specialtyChemicals(),
            'intellectual-property-bu'    => $this->intellectualProperty(),
        ];
    }

    private function apiFocusArea(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Business Unit</span>
  <h2 class="srl-page-title">API – Active Pharmaceutical Ingredients</h2>
  <p class="srl-lead">To help patients get access to affordable and innovative medicines, we focus on creating high quality and cost-effective Active Pharmaceutical Ingredients (APIs).</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:api-focus-hero.jpg}" alt="API Active Pharmaceutical Ingredients" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-content-block reveal" data-reveal>
  <p>Shivalik Rasayan Ltd has a diverse product range and product mix in order to serve consumer requirements. Presently, the APIs being developed and manufactured are in the niche area of oncology, ARVs, cardiovascular, metabolic disorders and immunology.</p>
</div>

<div class="srl-stat-grid">
  <div class="srl-stat-card reveal" data-reveal>
    <strong>1500</strong>
    <span>Installed capacity (tons)</span>
  </div>
  <div class="srl-stat-card reveal" data-reveal data-reveal-delay="100">
    <strong>32</strong>
    <span>GL &amp; SS Reactors with chilling up to -20°C</span>
  </div>
  <div class="srl-stat-card reveal" data-reveal data-reveal-delay="200">
    <strong>Zero</strong>
    <span>Effluent discharge facility</span>
  </div>
</div>

<div class="srl-highlight-box reveal" data-reveal>
  <h4>Reaction Capabilities</h4>
  <p>Catalytic hydrogenation, Organoborane chemistry, Chiral synthesis &amp; resolution, Grignard reaction, Acylation &amp; Alkylation, Carbon homologation, Coupling reaction (Amide metal/catalysed), Amination (Reductive/Chiral), Nitration, Diazotisation, Reduction, Halogenation, Cyanation, and more.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:api-facility.png}" alt="SRL API manufacturing facility" class="img-fluid rounded-4 shadow">
</div>
HTML;
    }

    private function researchDevelopment(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Business Unit</span>
  <h2 class="srl-page-title">Research &amp; Development</h2>
  <p class="srl-lead">DSIR-approved R&amp;D Centre driving innovation in APIs, intermediates, formulations and process improvement for complex molecules.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:rnd-hero.png}" alt="Shivalik Rasayan R&D Centre" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-content-block reveal" data-reveal>
  <span class="section-label">R&amp;D Centre Highlights</span>
  <ul class="srl-check-list">
    <li>R&amp;D Centre approved by DSIR (Dept. of Scientific &amp; Industrial Research, Govt. of India)</li>
    <li>World-class set up for development of APIs, Intermediates &amp; Process Improvement of complex molecules</li>
    <li>Chemical R&amp;D, Formulation R&amp;D, Analytical R&amp;D (Oncology &amp; Non-Oncology products)</li>
    <li>Gas Chromatography, FTIR, HPLC, LCMS, UV, Combiflash, Particle Size Analyser, Rota evaporator</li>
    <li>Dedicated Stability Chambers for accelerated stability studies, Photostability and various Zones</li>
    <li>Latest formulation R&amp;D scale equipment: RMG, FBD, Roller Compactor, Coater in Isolator, Lyophiliser, Liquid injection filling machine, Walk-in Fuming Hoods</li>
  </ul>
</div>

<div class="srl-section-block reveal" data-reveal>
  <h3>R&amp;D Centre: API Capabilities</h3>
  <p>SRL has experienced and dedicated teams of scientists committed towards innovation in new process development with focus on:</p>
  <ul>
    <li>Development of non-infringing processes for generic APIs</li>
    <li>Cost optimization</li>
  </ul>
  <p><strong>Our team is capable of:</strong></p>
  <ul>
    <li>High potent APIs handling in OEB 3 &amp; 4 levels in Dynamic / Static Isolators</li>
    <li>AR&amp;D facility with glove box static isolators for sample analysis</li>
    <li>Development of Environment Friendly processes</li>
    <li>Development of Chiral APIs and economically viable processes</li>
  </ul>
  <div class="row g-4 mt-2">
    <div class="col-md-6"><img src="{business-unit:rnd-api-capabilities.png}" alt="API Capabilities" class="img-fluid rounded-4 shadow"></div>
    <div class="col-md-6"><img src="{business-unit:rnd-chemistry.png}" alt="R&D Chemistry Capabilities" class="img-fluid rounded-4 shadow"></div>
  </div>
  <p class="mt-3"><strong>R&amp;D Chemistry Capabilities:</strong> Catalytic Hydrogenations, Organoborane Chemistry, Chiral Synthesis and Resolutions, Grignard reactions, Acylations and alkylation, Organometallic (LDA/ Alkyl Lithium), Carbon Homologation.</p>
</div>

<div class="srl-section-block reveal" data-reveal>
  <h3>Chemical &amp; Analytical Research Capabilities</h3>
  <p>Team is supported by state-of-the-art Chemical &amp; Analytical Research capabilities to develop:</p>
  <ul>
    <li>Method Validation</li>
    <li>Impurity profiling and assessment</li>
    <li>Synthesis, Isolation and Characterization of Impurities</li>
    <li>Expertise in Organometallic reactions sustainable for commercial manufacturing</li>
    <li>Handling sensitive pyrophoric reagents &amp; cryogenic reactions</li>
    <li>Ability to comply with ICH guidelines</li>
    <li>Coupling Reactions, Aminations, Nitration, Diazotisation, Reductions, Halogenations, Cyanation</li>
  </ul>
  <div class="row g-4 mt-2">
    <div class="col-md-6"><img src="{business-unit:rnd-chemical-analytical1.png}" alt="Chemical Analytical Research" class="img-fluid rounded-4 shadow"></div>
    <div class="col-md-6"><img src="{business-unit:rnd-chemical-analytical2.png}" alt="Analytical Research Capabilities" class="img-fluid rounded-4 shadow"></div>
  </div>
</div>

<div class="srl-section-block reveal" data-reveal>
  <h3>Formulation Capabilities</h3>
  <ul>
    <li>State-of-the-art formulation &amp; analytical development supported by Regulatory Services, IP Management, QA &amp; Project Management</li>
    <li>Full support from Concept to commercialisation</li>
    <li>CDMO model offering end-to-end services till commercialization</li>
    <li>Formulation strategy based on IP Landscape, Scientific literature, CQA and QTPP study</li>
  </ul>
  <div class="row g-4 mt-2">
    <div class="col-md-6"><img src="{business-unit:rnd-formulation.png}" alt="Formulation Capabilities" class="img-fluid rounded-4 shadow"></div>
    <div class="col-md-6"><img src="{business-unit:rnd-formulation2.png}" alt="Formulation Development" class="img-fluid rounded-4 shadow"></div>
  </div>
</div>

<div class="srl-section-block reveal" data-reveal>
  <h3>Formulation Development – Dosage Forms</h3>
  <div class="row g-4">
    <div class="col-md-6">
      <h4>Capsules</h4>
      <ul>
        <li>Powder/granules, Pellets (IR, ER and SR)</li>
        <li>Modified release – beads or mini tablets in capsules</li>
        <li>MUPS (Multiple Unit Particle Systems)</li>
      </ul>
      <h4>Semi Solids</h4>
      <ul><li>Gels, Creams, Ointments</li></ul>
      <h4>Liquid</h4>
      <ul><li>Syrup, Elixir</li></ul>
    </div>
    <div class="col-md-6">
      <h4>Injectable</h4>
      <ul><li>Solutions, Suspensions, Emulsions</li></ul>
      <h4>Novel Drug Delivery</h4>
      <ul><li>Liposome, Niosome, Microsphere, Nano-emulsion, Nano-liposomes</li></ul>
      <h4>Buccal Delivery</h4>
      <ul><li>ODF/ODS/OF</li></ul>
    </div>
  </div>
  <div class="row g-4 mt-2">
    <div class="col-md-6"><img src="{business-unit:rnd-center-offer1.png}" alt="R&D Centre Dosage Forms" class="img-fluid rounded-4 shadow"></div>
    <div class="col-md-6"><img src="{business-unit:rnd-center-offer2.png}" alt="Formulation Development Services" class="img-fluid rounded-4 shadow"></div>
  </div>
</div>
HTML;
    }

    private function agrochemical(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Business Unit</span>
  <h2 class="srl-page-title">Agrochemical</h2>
  <p class="srl-lead">For Sustainable Farming — protecting crops with effective, environment-friendly plant protection chemicals.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:agro-hero.jpg}" alt="Agrochemical Business Unit" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="row g-4 align-items-center srl-content-block reveal" data-reveal>
  <div class="col-lg-6">
    <span class="section-label">Foundation of SRL</span>
    <h3>For Sustainable Farming</h3>
    <p>The foundation of Shivalik Rasayan Limited (SRL) is the agrochemical sector, which is one of India's significant sectors influencing the Indian economy — ensuring food security for a population of 1.3 billion citizens.</p>
    <p>Shivalik Rasayan Limited was established to produce effective and environment-friendly chemicals for protection of plants.</p>
    <p>SRL is the producer of international quality <strong>Malathion Technical</strong> and <strong>Dimethoate Technical</strong>. It also manufactures organophosphorus-based insecticides and chemicals.</p>
  </div>
  <div class="col-lg-6">
    <img src="{business-unit:agro-1.jpg}" alt="Agrochemical manufacturing" class="img-fluid rounded-4 shadow">
  </div>
</div>

<div class="srl-highlight-box reveal" data-reveal>
  <h4>Quality &amp; Global Reputation</h4>
  <p>SRL's products are well-established not only in Indian markets but foreign markets as well. SRL has a long-established global reputation as a reliable supplier of quality products in the agrochemical sector — a mainstay of SRL's commitment towards quality.</p>
  <p>SRL focuses significantly on quality of raw materials and finished products, with well equipped quality monitoring at every stage of the chemical reaction. Our dedicated R&amp;D team consistently works toward leveraging technological innovations for existing and new products.</p>
  <p>SRL has registered more than 20 products for in-house development and viable commercialised capacity including five export registrations. Many agrochemical products are under development for technology and process optimisation.</p>
</div>

<div class="row g-4 srl-csr-gallery reveal" data-reveal>
  <div class="col-md-6"><img src="{business-unit:agro-2.jpg}" alt="Agrochemical products" class="img-fluid rounded-4 shadow"></div>
  <div class="col-md-6"><img src="{business-unit:agro-hero.jpg}" alt="Sustainable farming solutions" class="img-fluid rounded-4 shadow"></div>
</div>
HTML;
    }

    private function specialtyChemicals(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Business Unit</span>
  <h2 class="srl-page-title">Speciality Chemicals</h2>
  <p class="srl-lead">SRL is planning to foray into the high growth area of Speciality Chemicals — an emerging sector in the global chemical industry.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:specialty-chemicals.jpg}" alt="Speciality Chemicals" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="row g-4 align-items-start srl-content-block reveal" data-reveal>
  <div class="col-lg-6">
    <p>Speciality chemicals are those that have been developed in recent times and are regarded as an emerging sector in the global chemical industry.</p>
    <p>Recent market research statistics suggest that the speciality chemicals market is growing further with major shift of growth towards China, India and Japan.</p>
    <p>They include high performance anti-corrosion coatings, speciality films, cosmetic chemicals, petrochemical process catalysts, water management chemicals, adhesives and sealants, packaging chemicals, textile chemicals, industrial chemicals, surfactants, flavours and fragrances, food additives and water-soluble polymers.</p>
  </div>
  <div class="col-lg-6">
    <div class="srl-highlight-box">
      <h4>Market Outlook</h4>
      <ul>
        <li><strong>Japan</strong> holds 30% market share with 2% growth — expected value $100 billion</li>
        <li><strong>China</strong> accounts for 25% of Asia-Pacific market, growing at 11% annually</li>
        <li><strong>India</strong> holds ~10% market share with ~10% growth — expected to reach $200 billion</li>
      </ul>
      <p>Among sub-segments, commodity chemicals dominates the Indian market. Major players include BASF, Dow, Tata Speciality Chemicals, and RCF. Many chemical companies have started speciality chemicals divisions.</p>
    </div>
  </div>
</div>
HTML;
    }

    private function intellectualProperty(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Business Unit</span>
  <h2 class="srl-page-title">Intellectual Property</h2>
  <p class="srl-lead">Intellectual Property Protection is important to the pharmaceutical industry — managing innovation better than competitors is key to thriving in today's economy.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:ip-banner.jpg}" alt="Intellectual Property at SRL" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-content-block reveal" data-reveal>
  <p>Research and Development in Shivalik Rasayan Limited ensures full compliance with globally harmonized Intellectual Property laws.</p>
  <p>Shivalik Rasayan Limited has a corporate IP and Legal Affairs team dedicated to creating, cultivating, leveraging and securing an ever-growing portfolio of high-value patents, product and research pipeline with patent portfolio management.</p>
  <p>We strive to achieve every opportunity to generate IP portfolio and earlier launch options in generic competition with PARA IV filing. As a fast-growing organization we are building IP as company assets and securing innovations by patents.</p>
</div>

<div class="srl-highlight-box reveal" data-reveal>
  <h4>Our IP Philosophy</h4>
  <p>SRL believes in fair market behaviour and gives full recognition to authentic and valid IP rights of our competitors. However, we also challenge what we believe is invalid or unenforceable as per Patent Law.</p>
  <p>SRL is a company that does not violate the rights of patentees (U/S 48, Patents Act) by making, using, offering for sale, selling or importing any patented product within the respective jurisdiction.</p>
  <p>For further queries contact: <a href="mailto:ipr@shivalikrasayan.com">ipr@shivalikrasayan.com</a></p>
</div>
HTML;
    }
}
