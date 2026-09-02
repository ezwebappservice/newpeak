<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Shivalik Rasayan live-site pages (slug => page definition).
 * Content is stored in tbl_page_dynamic and editable via Admin → Dynamic Pages.
 */
class ShivalikPages extends BaseConfig
{
    /**
     * Pages served by dedicated modules (not tbl_page_dynamic) but still shown in navigation.
     *
     * @var list<string>
     */
    public array $moduleSlugs = [
        'connect',
        'latest-news',
        'leadership-at-srl',
        'investor-relations',
        'careers',
    ];

    /** When true, Investors menu children are replaced with CMS investor categories. */
    public bool $mergeInvestorCategoriesInNav = true;

    /** @var list<string> All routable slugs (matches shivalikrasayan.com URLs) */
    public array $slugs = [
        'modules',
        'details',
        'careers',
        'our-company',
        'documentation',
        'agrochemical-bu',
        'formulation-bu',
        'research-and-development-bu',
        'intellectual-property-bu',
        'about-us',
        'our-core-values',
        'corporate-social-responsibility',
        'our-history',
        'chairman-desk',
        'advantage-srl',
        'oncology-products',
        'non-oncology-products',
        'impurities-products',
        'api-bu',
        'api-focus-area',
        'srl-policies',
        'footprints-and-approvals',
        'annual-reports',
        'share-holding-pattern',
        'notice',
        'quarter-results',
        'agro-chemical-products',
        'investor-contact',
        'customer-synthesis',
        'board-of-directors',
        'specialty-chemicals',
        'drug-master-file',
        'intellectual-property-rights',
        'lab-samples',
        'international-partners-associates',
        'corporate-governance',
        'unclaimed-dividends',
        'compliance-reports',
        'announcements',
        'statement-of-deviation',
        'group-companies-financials',
        'newspaper-advertisements',
        'share-reconciliation-report',
        'composition-of-committees',
        'news-advertisement',
    ];

    /**
     * Default page definitions for seeding (slug => [name, meta_title, meta_description]).
     *
     * @var array<string, array{name: string, meta_title: string, meta_description: string}>
     */
    public array $definitions = [
        'modules' => [
            'name' => 'Modules',
            'meta_title' => 'Modules | Shivalik Rasayan Limited',
            'meta_description' => 'Shivalik Rasayan Limited modules and capabilities.',
        ],
        'details' => [
            'name' => 'Details',
            'meta_title' => 'Details | Shivalik Rasayan Limited',
            'meta_description' => 'Company details – Shivalik Rasayan Limited.',
        ],
        'our-company' => [
            'name' => 'Our Company',
            'meta_title' => 'Our Company | Shivalik Rasayan Limited',
            'meta_description' => 'Learn about Shivalik Rasayan Limited – our company profile and operations.',
        ],
        'documentation' => [
            'name' => 'Documentation',
            'meta_title' => 'Documentation | Shivalik Rasayan Limited',
            'meta_description' => 'Technical and regulatory documentation from Shivalik Rasayan Limited.',
        ],
        'agrochemical-bu' => [
            'name' => 'Agrochemical Business Unit',
            'meta_title' => 'Agrochemical BU | Shivalik Rasayan Limited',
            'meta_description' => 'Agrochemical business unit – crop protection and organophosphorus insecticides.',
        ],
        'formulation-bu' => [
            'name' => 'Formulation Business Unit',
            'meta_title' => 'Formulation BU | Shivalik Rasayan Limited',
            'meta_description' => 'Formulation business unit – Shivalik Rasayan Limited.',
        ],
        'research-and-development-bu' => [
            'name' => 'Research & Development',
            'meta_title' => 'Research & Development | Shivalik Rasayan Limited',
            'meta_description' => 'DSIR-recognized R&D centre driving innovation in APIs and finished dosage forms.',
        ],
        'intellectual-property-bu' => [
            'name' => 'Intellectual Property',
            'meta_title' => 'Intellectual Property | Shivalik Rasayan Limited',
            'meta_description' => 'Intellectual property and innovation at Shivalik Rasayan Limited.',
        ],
        'about-us' => [
            'name' => 'About Us',
            'meta_title' => 'About Us | Shivalik Rasayan Limited',
            'meta_description' => 'Shivalik Rasayan Ltd – leading manufacturer of APIs, agrochemicals and specialty chemicals in India.',
        ],
        'connect' => [
            'name' => 'Connect With Us',
            'meta_title' => 'Connect | Shivalik Rasayan Limited',
            'meta_description' => 'Contact Shivalik Rasayan Limited for product inquiries, partnerships and investor relations.',
        ],
        'our-core-values' => [
            'name' => 'Our Core Values',
            'meta_title' => 'Core Values | Shivalik Rasayan Limited',
            'meta_description' => 'Core values that define Shivalik Rasayan Limited at individual and organizational levels.',
        ],
        'corporate-social-responsibility' => [
            'name' => 'CSR @ Shivalik',
            'meta_title' => 'Corporate Social Responsibility | Shivalik Rasayan Limited',
            'meta_description' => 'Corporate social responsibility and sustainable development at Shivalik Rasayan Limited.',
        ],
        'our-history' => [
            'name' => 'Our History',
            'meta_title' => 'Our History | Shivalik Rasayan Limited',
            'meta_description' => 'History of Shivalik Rasayan Ltd – organophosphorus insecticides and chemicals manufacturing.',
        ],
        'chairman-desk' => [
            'name' => "Chairman's Desk",
            'meta_title' => "Chairman's Desk | Shivalik Rasayan Limited",
            'meta_description' => "Message from the Chairman of Shivalik Rasayan Limited.",
        ],
        'advantage-srl' => [
            'name' => 'Advantage SRL',
            'meta_title' => 'Advantage SRL | Shivalik Rasayan Limited',
            'meta_description' => 'Competitive advantages and strengths of Shivalik Rasayan Limited.',
        ],
        'oncology-products' => [
            'name' => 'Oncology APIs',
            'meta_title' => 'Oncology Products | Shivalik Rasayan Limited',
            'meta_description' => 'Oncology active pharmaceutical ingredients manufactured by Shivalik Rasayan Limited.',
        ],
        'non-oncology-products' => [
            'name' => 'General APIs',
            'meta_title' => 'Non-Oncology Products | Shivalik Rasayan Limited',
            'meta_description' => 'Non-oncology active pharmaceutical ingredients from Shivalik Rasayan Limited.',
        ],
        'impurities-products' => [
            'name' => 'Impurities',
            'meta_title' => 'Impurities Products | Shivalik Rasayan Limited',
            'meta_description' => 'High-grade impurities and reference standards from Shivalik Rasayan Limited.',
        ],
        'api-bu' => [
            'name' => 'API Business Unit',
            'meta_title' => 'API BU | Shivalik Rasayan Limited',
            'meta_description' => 'Active Pharmaceutical Ingredients business unit at Shivalik Rasayan Limited.',
        ],
        'api-focus-area' => [
            'name' => 'API Focus Areas',
            'meta_title' => 'API Focus Area | Shivalik Rasayan Limited',
            'meta_description' => 'API focus areas and therapeutic segments at Shivalik Rasayan Limited.',
        ],
        'srl-policies' => [
            'name' => 'SRL Policies',
            'meta_title' => 'Policies | Shivalik Rasayan Limited',
            'meta_description' => 'Corporate policies and disclosures under Regulation 46 – Shivalik Rasayan Limited.',
        ],
        'footprints-and-approvals' => [
            'name' => 'Footprints & Approvals',
            'meta_title' => 'Footprints and Approvals | Shivalik Rasayan Limited',
            'meta_description' => 'Global footprints, regulatory approvals and certifications of Shivalik Rasayan Limited.',
        ],
        'leadership-at-srl' => [
            'name' => 'Leadership',
            'meta_title' => 'Leadership at SRL | Shivalik Rasayan Limited',
            'meta_description' => 'Executive leadership team at Shivalik Rasayan Limited.',
        ],
        'annual-reports' => [
            'name' => 'Annual Reports',
            'meta_title' => 'Annual Reports | Shivalik Rasayan Limited',
            'meta_description' => 'Annual reports and financial statements of Shivalik Rasayan Limited.',
        ],
        'share-holding-pattern' => [
            'name' => 'Shareholding Pattern',
            'meta_title' => 'Shareholding Pattern | Shivalik Rasayan Limited',
            'meta_description' => 'Shareholding pattern disclosures for Shivalik Rasayan Limited.',
        ],
        'notice' => [
            'name' => 'Notices',
            'meta_title' => 'Notice | Shivalik Rasayan Limited',
            'meta_description' => 'Statutory notices and communications to shareholders.',
        ],
        'quarter-results' => [
            'name' => 'Quarterly Results',
            'meta_title' => 'Quarter Results | Shivalik Rasayan Limited',
            'meta_description' => 'Quarterly financial results and transcripts of Shivalik Rasayan Limited.',
        ],
        'agro-chemical-products' => [
            'name' => 'Agrochemical Products',
            'meta_title' => 'Agro Chemical Products | Shivalik Rasayan Limited',
            'meta_description' => 'Agrochemical products including Dimethoate and Malathion technical.',
        ],
        'investor-contact' => [
            'name' => 'Investor Contact',
            'meta_title' => 'Investor Contact | Shivalik Rasayan Limited',
            'meta_description' => 'Investor relations contact information for Shivalik Rasayan Limited.',
        ],
        'customer-synthesis' => [
            'name' => 'Customer Synthesis',
            'meta_title' => 'Customer Synthesis | Shivalik Rasayan Limited',
            'meta_description' => 'Custom synthesis and contract manufacturing services at Shivalik Rasayan Limited.',
        ],
        'board-of-directors' => [
            'name' => 'Board of Directors',
            'meta_title' => 'Board of Directors | Shivalik Rasayan Limited',
            'meta_description' => 'Board of Directors of Shivalik Rasayan Limited.',
        ],
        'specialty-chemicals' => [
            'name' => 'Specialty Chemicals',
            'meta_title' => 'Specialty Chemicals | Shivalik Rasayan Limited',
            'meta_description' => 'Specialty chemicals, intermediates and advanced organic chemicals.',
        ],
        'drug-master-file' => [
            'name' => 'Drug Master File',
            'meta_title' => 'Drug Master File | Shivalik Rasayan Limited',
            'meta_description' => 'Drug Master File (DMF) information for Shivalik Rasayan API products.',
        ],
        'intellectual-property-rights' => [
            'name' => 'Intellectual Property Rights',
            'meta_title' => 'Intellectual Property Rights | Shivalik Rasayan Limited',
            'meta_description' => 'Intellectual property rights and patents at Shivalik Rasayan Limited.',
        ],
        'lab-samples' => [
            'name' => 'Lab Samples',
            'meta_title' => 'Lab Samples | Shivalik Rasayan Limited',
            'meta_description' => 'Laboratory samples and analytical services at Shivalik Rasayan Limited.',
        ],
        'latest-news' => [
            'name' => 'Latest News',
            'meta_title' => 'Latest News | Shivalik Rasayan Limited',
            'meta_description' => 'Latest news and updates from Shivalik Rasayan Limited.',
        ],
        'international-partners-associates' => [
            'name' => 'International Partners',
            'meta_title' => 'International Partners & Associates | Shivalik Rasayan Limited',
            'meta_description' => 'International partners and associates of Shivalik Rasayan Limited.',
        ],
        'corporate-governance' => [
            'name' => 'Corporate Governance',
            'meta_title' => 'Corporate Governance | Shivalik Rasayan Limited',
            'meta_description' => 'Corporate governance framework and practices at Shivalik Rasayan Limited.',
        ],
        'unclaimed-dividends' => [
            'name' => 'Unclaimed Dividends',
            'meta_title' => 'Unclaimed Dividends | Shivalik Rasayan Limited',
            'meta_description' => 'Information on unclaimed dividends – Shivalik Rasayan Limited.',
        ],
        'compliance-reports' => [
            'name' => 'Compliance Reports',
            'meta_title' => 'Compliance Reports | Shivalik Rasayan Limited',
            'meta_description' => 'Regulatory compliance reports of Shivalik Rasayan Limited.',
        ],
        'announcements' => [
            'name' => 'Announcements',
            'meta_title' => 'Announcements | Shivalik Rasayan Limited',
            'meta_description' => 'Corporate announcements and exchange filings.',
        ],
        'statement-of-deviation' => [
            'name' => 'Statement of Deviation',
            'meta_title' => 'Statement of Deviation | Shivalik Rasayan Limited',
            'meta_description' => 'Statement of deviation in use of funds – Shivalik Rasayan Limited.',
        ],
        'group-companies-financials' => [
            'name' => 'Group Companies Financials',
            'meta_title' => 'Group Companies Financials | Shivalik Rasayan Limited',
            'meta_description' => 'Financial information of group companies and subsidiaries.',
        ],
        'newspaper-advertisements' => [
            'name' => 'Newspaper Advertisements',
            'meta_title' => 'Newspaper Advertisements | Shivalik Rasayan Limited',
            'meta_description' => 'Newspaper advertisements and public notices.',
        ],
        'share-reconciliation-report' => [
            'name' => 'Share Reconciliation Report',
            'meta_title' => 'Share Reconciliation Report | Shivalik Rasayan Limited',
            'meta_description' => 'Share reconciliation reports for Shivalik Rasayan Limited.',
        ],
        'composition-of-committees' => [
            'name' => 'Composition of Committees',
            'meta_title' => 'Composition of Committees | Shivalik Rasayan Limited',
            'meta_description' => 'Board committees composition – Shivalik Rasayan Limited.',
        ],
        'news-advertisement' => [
            'name' => 'News Advertisement',
            'meta_title' => 'News Advertisement | Shivalik Rasayan Limited',
            'meta_description' => 'News advertisements and regulatory publications.',
        ],
        'careers' => [
            'name' => 'Careers',
            'meta_title' => 'Careers | Shivalik Rasayan Limited',
            'meta_description' => 'Explore career opportunities at Shivalik Rasayan Limited.',
        ],
    ];

    /**
     * Header navigation tree (matches live site structure).
     * Each item: label, slug (optional), children (optional).
     *
     * @var list<array<string, mixed>>
     */
    public array $navigation = [
        [
            'label' => 'About Us',
            'children' => [
                [
                    'label'    => 'Overview',
                    'slug'     => 'about-us',
                    'children' => [
                        ['label' => 'Mission and Values', 'slug' => 'our-core-values'],
                    ],
                ],
                ['label' => 'Our History', 'slug' => 'our-history'],
                ['label' => "Chairman's Message", 'slug' => 'chairman-desk'],
                ['label' => 'Leadership Team', 'slug' => 'leadership-at-srl'],
                ['label' => 'The Board at SRL', 'slug' => 'board-of-directors'],
                ['label' => 'CSR', 'slug' => 'corporate-social-responsibility'],
            ],
        ],
        [
            'label' => 'Business Units',
            'children' => [
                [
                    'label'    => 'Pharmaceuticals',
                    'slug'     => 'api-bu',
                    'children' => [
                        ['label' => 'Active Pharmaceutical Ingredients', 'slug' => 'api-bu'],
                    ],
                ],
                ['label' => 'R&D Centre', 'slug' => 'research-and-development-bu'],
                ['label' => 'Agrochemical', 'slug' => 'agrochemical-bu'],
                ['label' => 'Speciality Chemicals', 'slug' => 'specialty-chemicals'],
                ['label' => 'Intellectual Property', 'slug' => 'intellectual-property-bu'],
            ],
        ],
        [
            'label' => 'Focus Areas',
            'children' => [
                ['label' => 'API Manufacturing', 'slug' => 'api-focus-area'],
                ['label' => 'Custom Manufacturing', 'slug' => 'customer-synthesis'],
                ['label' => 'Specialty Chemicals', 'slug' => 'specialty-chemicals'],
                ['label' => 'Custom R&D', 'slug' => 'research-and-development-bu'],
            ],
        ],
        [
            'label' => 'Products',
            'children' => [
                [
                    'label'    => 'Pharmaceuticals',
                    'children' => [
                        ['label' => 'API PRODUCT LIST – ONCOLOGY', 'slug' => 'oncology-products'],
                        ['label' => 'API PRODUCT LIST – NON ONCOLOGY', 'slug' => 'non-oncology-products'],
                    ],
                ],
                ['label' => 'Agrochemical', 'slug' => 'agro-chemical-products'],
                ['label' => 'IPR', 'slug' => 'intellectual-property-rights'],
            ],
        ],
        [
            'label' => 'Investors',
            // Children loaded dynamically from Admin → Investor Categories (sort_order).
        ],
        ['label' => 'News', 'slug' => 'latest-news'],
        ['label' => 'Careers', 'slug' => 'careers'],
        ['label' => 'Contact', 'slug' => 'connect'],
    ];
}
