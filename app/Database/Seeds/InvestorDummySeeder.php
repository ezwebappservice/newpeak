<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InvestorDummySeeder extends Seeder
{
    public function run()
    {
        if (! $this->db->tableExists('investor_documents') || ! $this->db->tableExists('investor_categories')) {
            echo "Investor tables not found. Run migrations first.\n";

            return;
        }

        $this->call('InvestorCategoriesSeeder');

        $existing = $this->db->table('investor_documents')
            ->like('file_title', '[TEST]', 'after')
            ->countAllResults();

        if ($existing > 0) {
            echo "Investor dummy data already exists ({$existing} test documents).\n";

            return;
        }

        helper('investor');

        $categories = $this->db->table('investor_categories')
            ->where('status', 'Active')
            ->get()
            ->getResultArray();

        $categoryMap = [];

        foreach ($categories as $category) {
            $categoryMap[$category['category_name']] = (int) $category['id'];
        }

        $definitions = [
            [
                'category'      => 'Annual Reports',
                'year'          => '2023-24',
                'file_title'    => '[TEST] Integrated Annual Report FY 2023-24',
                'title_type'    => 'Annual Report',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Integrated Annual Report FY 2023-24'),
            ],
            [
                'category'      => 'Annual Reports',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Integrated Annual Report FY 2024-25',
                'title_type'    => 'Annual Report',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Integrated Annual Report FY 2024-25'),
            ],
            [
                'category'      => 'Financial Results',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Unaudited Financial Results Q1 FY 2024-25',
                'title_type'    => 'Quarterly Results',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Unaudited Financial Results Q1 FY 2024-25'),
            ],
            [
                'category'      => 'Financial Results',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Unaudited Financial Results Q2 FY 2024-25',
                'title_type'    => 'Quarterly Results',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Unaudited Financial Results Q2 FY 2024-25'),
            ],
            [
                'category'      => 'Financial Results',
                'year'          => '2024',
                'file_title'    => '[TEST] Standalone Financial Summary Calendar 2024',
                'title_type'    => 'Financial Summary',
                'document_type' => 'CSV',
                'ext'           => 'csv',
                'body'          => "Metric,Value (INR Cr)\nRevenue,842.50\nEBITDA,126.30\nPAT,78.15\nEPS,12.45\n",
            ],
            [
                'category'      => 'Shareholding Pattern',
                'year'          => '2025-26',
                'file_title'    => '[TEST] Shareholding Pattern as on 31 March 2025',
                'title_type'    => 'Shareholding Pattern',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Shareholding Pattern as on 31 March 2025'),
            ],
            [
                'category'      => 'Shareholding Pattern',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Shareholding Pattern as on 30 September 2024',
                'title_type'    => 'Shareholding Pattern',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Shareholding Pattern as on 30 September 2024'),
            ],
            [
                'category'      => 'Corporate Governance',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Corporate Governance Report FY 2024-25',
                'title_type'    => 'Governance Report',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Corporate Governance Report FY 2024-25'),
            ],
            [
                'category'      => 'Corporate Governance',
                'year'          => '2025',
                'file_title'    => '[TEST] Composition of Board Committees',
                'title_type'    => 'Committee Composition',
                'document_type' => 'TXT',
                'ext'           => 'txt',
                'body'          => "Peak Potential - Board Committees (Dummy Test Data)\n\nAudit Committee\n- Mr. A. Sharma (Chairperson)\n- Ms. R. Mehta\n- Mr. P. Verma\n\nNomination & Remuneration Committee\n- Ms. R. Mehta (Chairperson)\n- Mr. A. Sharma\n",
            ],
            [
                'category'      => 'Notices & Announcements',
                'year'          => '2025-26',
                'file_title'    => '[TEST] Notice of 38th Annual General Meeting',
                'title_type'    => 'AGM Notice',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Notice of 38th Annual General Meeting'),
            ],
            [
                'category'      => 'Notices & Announcements',
                'year'          => '2025',
                'file_title'    => '[TEST] Outcome of Board Meeting held on 15 January 2025',
                'title_type'    => 'Board Outcome',
                'document_type' => 'TXT',
                'ext'           => 'txt',
                'body'          => "Outcome of Board Meeting - Dummy Test Data\n\nThe Board approved unaudited financial results for Q3 FY 2024-25.\nDividend recommendation: INR 2.50 per equity share.\n",
            ],
            [
                'category'      => 'Notices & Announcements',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Intimation under Regulation 30 of SEBI LODR',
                'title_type'    => 'Regulatory Disclosure',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Intimation under Regulation 30 of SEBI LODR'),
            ],
            [
                'category'      => 'Policies',
                'year'          => '2025-26',
                'file_title'    => '[TEST] Dividend Distribution Policy',
                'title_type'    => 'Policy',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Dividend Distribution Policy'),
            ],
            [
                'category'      => 'Policies',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Code of Conduct for Board and Senior Management',
                'title_type'    => 'Policy',
                'document_type' => 'TXT',
                'ext'           => 'txt',
                'body'          => "Code of Conduct - Dummy Test Policy\n\nAll directors and senior management personnel shall act with integrity and transparency.\nThis is sample content for investor module testing only.\n",
            ],
            [
                'category'      => 'Policies',
                'year'          => '2024',
                'file_title'    => '[TEST] Related Party Transaction Policy Summary',
                'title_type'    => 'Policy Summary',
                'document_type' => 'CSV',
                'ext'           => 'csv',
                'body'          => "Policy Area,Status,Last Review\nRelated Party Transactions,Active,2024-08-12\nWhistle Blower,Active,2024-06-01\n",
            ],
            [
                'category'      => 'Investor Presentations',
                'year'          => '2024-25',
                'file_title'    => '[TEST] Investor Presentation Q2 FY 2024-25',
                'title_type'    => 'Investor Presentation',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Investor Presentation Q2 FY 2024-25'),
            ],
            [
                'category'      => 'Investor Presentations',
                'year'          => '2025',
                'file_title'    => '[TEST] Company Overview for Institutional Investors',
                'title_type'    => 'Company Overview',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('Company Overview for Institutional Investors'),
            ],
            [
                'category'      => 'Investor Presentations',
                'year'          => '2023-24',
                'file_title'    => '[TEST] ESG Highlights Presentation FY 2023-24',
                'title_type'    => 'ESG Presentation',
                'document_type' => 'PDF',
                'ext'           => 'pdf',
                'body'          => $this->minimalPdf('ESG Highlights Presentation FY 2023-24'),
            ],
        ];

        $now  = date('Y-m-d H:i:s');
        $rows = [];

        foreach ($definitions as $definition) {
            $categoryId = $categoryMap[$definition['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            $ext      = $definition['ext'];
            $fileName = investor_unique_filename($ext);
            $path     = investor_storage_path($fileName);

            if (file_put_contents($path, $definition['body']) === false) {
                continue;
            }

            $rows[] = [
                'category_id'        => $categoryId,
                'year'               => $definition['year'],
                'file_title'         => $definition['file_title'],
                'title_type'         => $definition['title_type'],
                'document_type'      => $definition['document_type'],
                'file_name'          => $fileName,
                'original_file_name' => $this->originalFileName($definition['file_title'], $ext),
                'file_size'          => (int) filesize($path),
                'status'             => 'Active',
                'created_at'         => $now,
                'updated_at'         => $now,
            ];
        }

        if ($rows !== []) {
            $this->db->table('investor_documents')->insertBatch($rows);
        }

        echo count($rows) . " dummy investor documents seeded for testing.\n";
    }

    private function originalFileName(string $title, string $ext): string
    {
        $name = preg_replace('/^\[TEST\]\s*/', '', $title) ?? $title;
        $name = preg_replace('/[^a-zA-Z0-9._-]+/', '-', $name) ?? $name;
        $name = trim($name, '-');

        return strtolower($name) . '.' . $ext;
    }

    private function minimalPdf(string $title): string
    {
        $safeTitle = preg_replace('/[^\x20-\x7E]/', '', $title) ?? 'Investor Document';
        $text      = substr($safeTitle, 0, 120);
        $stream    = "BT /F1 14 Tf 50 750 Td (" . str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text) . ") Tj ET";
        $length    = strlen($stream);

        return "%PDF-1.4\n"
            . "1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj\n"
            . "2 0 obj<< /Type /Pages /Kids [3 0 R] /Count 1 >>endobj\n"
            . "3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>endobj\n"
            . "4 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj\n"
            . "5 0 obj<< /Length {$length} >>stream\n{$stream}\nendstream endobj\n"
            . "xref\n0 6\n0000000000 65535 f \n"
            . "trailer<< /Size 6 /Root 1 0 R >>\nstartxref\n0\n%%EOF";
    }
}
