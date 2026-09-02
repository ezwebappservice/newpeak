<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CareerSeeder extends Seeder
{
    public function run()
    {
        if (! $this->db->tableExists('tbl_career')) {
            return;
        }

        if ($this->db->table('tbl_career')->countAllResults() > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');

        $this->db->table('tbl_career')->insertBatch([
            [
                'job_title'         => 'Production Chemist',
                'department'        => 'Manufacturing',
                'location'          => 'Nalagarh, Himachal Pradesh',
                'job_type'          => 'Full Time',
                'experience'        => '2-4 years',
                'short_description' => 'Responsible for batch manufacturing, documentation, and cGMP compliance in API production.',
                'job_description'   => "Execute production batches as per approved batch manufacturing records.\nMaintain cGMP documentation and ensure safety compliance.\nCoordinate with QA and engineering for smooth plant operations.",
                'requirements'      => "B.Sc/M.Sc in Chemistry or related field.\nExperience in API or pharmaceutical manufacturing.\nGood knowledge of cGMP and plant SOPs.",
                'apply_email'       => null,
                'sort_order'        => 1,
                'status'            => 'Active',
                'lang_id'           => 5,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'job_title'         => 'Quality Assurance Executive',
                'department'        => 'Quality Assurance',
                'location'          => 'Nalagarh, Himachal Pradesh',
                'job_type'          => 'Full Time',
                'experience'        => '3-6 years',
                'short_description' => 'Support QA systems, audits, batch record review, and regulatory compliance activities.',
                'job_description'   => "Review batch manufacturing and analytical records.\nSupport internal and external audits.\nAssist in CAPA, change control, and deviation management.",
                'requirements'      => "B.Pharm/M.Sc with QA experience in pharma/API industry.\nKnowledge of USFDA/EU GMP requirements.\nStrong documentation and communication skills.",
                'apply_email'       => null,
                'sort_order'        => 2,
                'status'            => 'Active',
                'lang_id'           => 5,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ]);
    }
}
