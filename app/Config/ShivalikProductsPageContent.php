<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Rich HTML content for Focus Area / Products pages (matches shivalikrasayan.com).
 */
class ShivalikProductsPageContent extends BaseConfig
{
    /** @var array<string, string> */
    public array $pages = [];

    /** @var array<string, string> Banner paths relative to public/uploads/ */
    public array $banners = [
        'customer-synthesis'           => 'products/custom-manufacturing.jpg',
        'api-bu'                       => 'products/api-bu-facility3.jpg',
        'oncology-products'            => 'products/oncology-products.jpg',
        'non-oncology-products'        => 'products/non-oncology-products.jpg',
        'agro-chemical-products'       => 'products/agro-products.jpg',
        'intellectual-property-rights' => 'business-units/ip-banner.jpg',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->pages = [
            'customer-synthesis'           => $this->customerSynthesis(),
            'api-bu'                       => $this->apiBu(),
            'oncology-products'            => $this->oncologyProducts(),
            'non-oncology-products'        => $this->nonOncologyProducts(),
            'agro-chemical-products'       => $this->agroChemicalProducts(),
            'intellectual-property-rights' => $this->intellectualPropertyRights(),
        ];
    }

    private function customerSynthesis(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Focus Area</span>
  <h2 class="srl-page-title">Custom Manufacturing</h2>
  <p class="srl-lead">SRL offers world-class capabilities for large scale custom manufacturing of chemicals with complex chemistry.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{products:custom-manufacturing.jpg}" alt="Custom Manufacturing at SRL" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-content-block reveal" data-reveal>
  <p>We have a truly unique technology and chemistry portfolio, combined with decades of experience in this field. We operate production sites at Bhiwadi and Haridwar in accordance with strict internal and external quality standards. As a result, wherever you are and whatever your requirements, you can be sure of high-quality products and first-class support at every stage of your project.</p>
</div>

<div class="srl-highlight-box reveal" data-reveal>
  <h4>Services — Custom Manufacturing Technologies</h4>
  <ul>
    <li>Custom Synthesis and Contract Manufacturing</li>
    <li>Product R&amp;D and process development</li>
    <li>Technical support and technology transfer</li>
    <li>Product stability studies as per ICH guideline and customer specification</li>
    <li>Analytical Method development and validation of method</li>
    <li>Site transfer and commercial production</li>
  </ul>
</div>
HTML;
    }

    private function apiBu(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Business Unit</span>
  <h2 class="srl-page-title">API Manufacturing</h2>
  <p class="srl-lead">Highlights of the process adopted to meet our goal of world-class API production with zero cross-contamination.</p>
</div>

<div class="row g-4 srl-content-block reveal" data-reveal>
  <div class="col-lg-6">
    <img src="{products:api-bu-process1.png}" alt="API manufacturing process" class="img-fluid rounded-4 shadow">
  </div>
  <div class="col-lg-6">
    <img src="{products:api-bu-process2.png}" alt="API manufacturing process overview" class="img-fluid rounded-4 shadow">
  </div>
</div>

<div class="srl-content-block reveal" data-reveal>
  <h3>API Facility</h3>
  <p>Our API manufacturing facility is designed and operated to support both oncology and non-oncology production with dedicated infrastructure, equipment and quality systems.</p>
</div>

<div class="row g-4 srl-content-block reveal" data-reveal>
  <div class="col-md-6"><img src="{products:api-bu-img12.jpg}" alt="API facility" class="img-fluid rounded-4 shadow"></div>
  <div class="col-md-6"><img src="{products:api-bu-img13.jpg}" alt="API facility equipment" class="img-fluid rounded-4 shadow"></div>
  <div class="col-md-6"><img src="{products:api-bu-facility3.jpg}" alt="API manufacturing facility" class="img-fluid rounded-4 shadow"></div>
  <div class="col-md-6"><img src="{products:api-bu-facility4.png}" alt="API facility layout" class="img-fluid rounded-4 shadow"></div>
</div>

<div class="srl-page-intro text-center srl-content-block reveal" data-reveal>
  <h3 class="srl-page-title">Ensuring Total Absence of Cross Contamination</h3>
</div>

<div class="row g-4 srl-content-block reveal" data-reveal>
  <div class="col-lg-6">
    <div class="srl-highlight-box h-100">
      <h4>Manpower</h4>
      <ul>
        <li>Cleanroom HVAC</li>
        <li>Dedicated manpower for oncology &amp; non-oncology API production</li>
        <li>Entry controls in production blocks — only authorized personnel</li>
        <li>Adequate training by QA to personnel of Production, QC, Engineering and other Departments to prevent cross-contamination</li>
      </ul>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="srl-highlight-box h-100">
      <h4>Facility</h4>
      <ul>
        <li>Air showers for entry &amp; exit of personnel in oncology production facility</li>
        <li>Different gowning procedure for oncology &amp; non-oncology production facilities</li>
        <li>Material isolation inside isolators for oncology products manufacturing</li>
        <li>Uni-directional movement of men &amp; materials to avoid cross contamination</li>
        <li>Dedicated production blocks for oncology &amp; non-oncology products</li>
        <li>Dedicated QC labs for analysis of oncology &amp; non-oncology products</li>
        <li>Detoxification of tools &amp; samplers/waste in oncology production facility</li>
        <li>Dedicated vacuum systems for oncology &amp; non-oncology production facilities</li>
        <li>Dedicated storage facility for oncology &amp; non-oncology APIs in warehouse</li>
        <li>Environmental monitoring for oncology &amp; non-oncology production facilities</li>
      </ul>
    </div>
  </div>
</div>

<div class="row g-4 srl-content-block reveal" data-reveal>
  <div class="col-md-6"><img src="{products:api-bu-absence1.png}" alt="Cross contamination prevention" class="img-fluid rounded-4 shadow"></div>
  <div class="col-md-6"><img src="{products:api-bu-absence2.png}" alt="Cross contamination prevention measures" class="img-fluid rounded-4 shadow"></div>
</div>
HTML;
    }

    private function oncologyProducts(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">API Products</span>
  <h2 class="srl-page-title">API Product List – Oncology</h2>
</div>

<div class="srl-disclaimer-box reveal" data-reveal>
  <p><strong>**</strong> This API is not official in EP. Hence, CEP cannot be filed. If an MA Holder in Europe requires, then ASMF support can be provided within a month's notice.</p>
  <p><strong>***</strong> Open Part of DMF (for Domestic &amp; Emerging Markets) can be provided within one month of receiving request.</p>
  <h4>Patent Disclaimers</h4>
  <ol>
    <li>No information in this list — including any reference to any product or service — constitutes an offer for sale or commercialization. Products will be commercialized after expiry of all valid patents.</li>
    <li>Products protected by valid patents (of innovators / third parties) are not offered for commercialization / sale in countries where the sale of such products constitutes a patent infringement.</li>
    <li>Products currently covered by valid US Patents are offered only for R&amp;D use in accordance with 35 USC 271 + A13(1).</li>
    <li>Our valued partners / buyers are requested to ensure required patent evaluations at their end before purchasing any product from us. Any patent infringement liability is solely to the account of the buyer.</li>
  </ol>
</div>
HTML;
    }

    private function nonOncologyProducts(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">API Products</span>
  <h2 class="srl-page-title">API Product List – Non Oncology</h2>
</div>

<div class="srl-disclaimer-box reveal" data-reveal>
  <p><strong>**</strong> This API is not official in EP presently. Hence, CEP cannot be filed. However, if a Marketing Authorisation Holder in Europe requires, then ASMF support can be provided nearabout the timeframe mentioned for USDMF.</p>
  <p><strong>***</strong> Can be provided at a month's notice for Emerging Markets.</p>
  <h4>Patent Disclaimers</h4>
  <ol>
    <li>No information in this list — including any reference to any product or service — constitutes an offer for sale or commercialization. Products will be commercialized after expiry of all valid patents.</li>
    <li>Products protected by valid patents (of innovators / third parties) are not offered for commercialization / sale in countries where the sale of such products constitutes a patent infringement.</li>
    <li>Products currently covered by valid US Patents are offered only for R&amp;D use in accordance with 35 USC 271 + A13(1).</li>
    <li>Our valued partners / buyers are requested to ensure required patent evaluations at their end before purchasing any product from us. Any patent infringement liability is solely to the account of the buyer.</li>
  </ol>
</div>
HTML;
    }

    private function agroChemicalProducts(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Products</span>
  <h2 class="srl-page-title">Agrochemical @ SRL</h2>
  <p class="srl-lead">We believe that a well-nurtured, healthy soil enables environment-friendly, healthy agriculture, sustainable across future centuries — ensuring the safety and good health of human generations that live off it.</p>
</div>

<div class="srl-content-block reveal" data-reveal>
  <p>SRL deals in high quality pesticides including insecticides, herbicides and fungicides.</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{products:agro-products.jpg}" alt="Agrochemical products at SRL" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-content-block reveal" data-reveal>
  <h3>Dimethoate Technical</h3>
  <p>Dimethoate technical is used in preparation of formulations used in the control of a broad range of insect and mites. Dimethoate is primarily an organophosphorous based systemic insecticide but also possesses properties of a contact insecticide and an acaricide. It is an insecticide of moderate mammalian toxicity which is widely used against piercing and sucking insects, spider mites, chewing, mining and boring insects on cereals, cotton, chilies, tobacco, vegetables, fruit crops, tea and coffee etc.</p>
  <p class="text-muted"><em>Note: Some items may not display properly in the table above due to typography limitations. Please refer to the PDF document for complete specifications.</em></p>
  <p><a href="https://shivalikrasayan.com/wp-content/uploads/2019/04/DIMETHOATE-TECHNICAL.pdf" class="btn btn-primary" target="_blank" rel="noopener">Download Dimethoate Technical PDF</a></p>
</div>

<div class="srl-content-block reveal" data-reveal>
  <h3>Malathion Technical</h3>
  <p>Malathion is a non-systemic, wide spectrum organophosphorous (OP) based contact insecticide. It is used in the agricultural production of a wide variety of food/feed crops. It controls insects such as aphids, leafhoppers, Japanese beetles, spider mites, scale insects, housefly &amp; mosquitos as well as large number of other sucking and chewing insects attacking fruits, vegetables, ornamentals &amp; stored products, mosquito control in Public Health Programs.</p>
  <p>Malathion is formulated as a technical (91–95% ai), a dust (1–10% ai), and emulsifiable concentrate (3–82% ai), a ready-to-use (1.5–95% ai), a pressurized liquid (0.5–3% ai), and a wettable powder (6–50% ai). Several of the 95% liquids are intended for ultra-low-volume (ULV) applications. Malathion can be applied using ground or aerial equipment, thermal and non-thermal fogger, ground boom, airblast sprayer, chemigation, and a variety of hand-held equipment such as backpack sprayers, low-pressure handwands, hose-end sprayers and power dusters. Multiple foliar applications may be made, as needed depending on pest presence.</p>
  <p>Malathion is an OP insecticide, and like all members of this class, the mode of toxic action is the inhibition of cholinesterase (ChE). The selective toxicity of Malathion has been well documented. Malathion is metabolically converted to its structurally similar metabolite, malaoxon (oxidation of the P=S moiety to P=O), in insects and mammals. Mammalian systems show greater carboxyesterase activity, as compared with insects, so that the toxic agent malaoxon builds up more in insects than in mammals. This accounts for the selective toxicity of Malathion towards insects.</p>
  <p class="text-muted"><em>Note: Some items may not display properly in the table above due to typography limitations. Please refer to the PDF document for complete specifications.</em></p>
  <p><a href="https://shivalikrasayan.com/wp-content/uploads/2019/04/MALATHION-TECHNICAL.pdf" class="btn btn-primary" target="_blank" rel="noopener">Download Malathion Technical PDF</a></p>
</div>
HTML;
    }

    private function intellectualPropertyRights(): string
    {
        return <<<'HTML'
<div class="srl-page-intro text-center">
  <span class="srl-kicker">Focus Area</span>
  <h2 class="srl-page-title">Intellectual Property Rights</h2>
  <p class="srl-lead">Patents Filed during 2018–2019</p>
</div>

<div class="srl-page-hero-image reveal" data-reveal>
  <img src="{business-unit:ip-banner.jpg}" alt="Intellectual Property Rights at SRL" class="img-fluid rounded-4 shadow-lg">
</div>

<div class="srl-content-block reveal" data-reveal>
  <p>Research and Development in Shivalik Rasayan Limited ensures full compliance with globally harmonized Intellectual Property laws. Shivalik Rasayan Limited has a corporate IP and Legal Affairs team dedicated to creating, cultivating, leveraging and securing an ever-growing portfolio of high-value patents, product and research pipeline with patent portfolio management.</p>
  <p>We strive to achieve every opportunity to generate IP portfolio and earlier launch options in generic competition with PARA IV filing. As a fast-growing organization we are building IP as company assets and securing innovations by patents.</p>
</div>

<div class="srl-highlight-box reveal" data-reveal>
  <h4>Our IP Philosophy</h4>
  <p>SRL believes in fair market behaviour and gives full recognition to authentic and valid IP rights of our competitors. However, we also challenge what we believe is invalid or unenforceable as per Patent Law.</p>
  <p>SRL is a company that does not violate the rights of patentees (U/S 48, Patents Act) by making, using, offering for sale, selling or importing any patented product within the respective jurisdiction.</p>
  <p>For further queries contact: <a href="mailto:ipr@shivalikrasayan.com">ipr@shivalikrasayan.com</a></p>
</div>

<p class="text-center reveal" data-reveal><a href="intellectual-property-bu" class="btn btn-outline-primary">Learn more about our IP Business Unit</a></p>
HTML;
    }
}
