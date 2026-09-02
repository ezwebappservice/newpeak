<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShivalikLeadershipTeamSeeder extends Seeder
{
    public function run()
    {
        $langId = 5;
        $langRow = $this->db->table('tbl_lang')->where('lang_default', 'Yes')->get()->getRowArray();
        if ($langRow) {
            $langId = (int) $langRow['lang_id'];
        }

        $uploadDir = (defined('FCPATH') ? FCPATH : ROOTPATH . 'public/') . 'uploads/';
        $aboutDir = $uploadDir . 'about-pages/';

        $this->db->table('tbl_page_team')->where('lang_id', $langId)->update([
            'team_heading'   => 'Leadership Team',
            'team_subtitle'  => 'Leadership @ SRL',
            'team_intro'     => 'The Executive Management at SRL has an extensive global experience and is deeply passionate about delivering efficient healthcare solutions to its clients.',
            'mt_team'        => 'Leadership Team | Shivalik Rasayan Limited',
            'mk_team'        => 'Shivalik Rasayan leadership, SRL executive team',
            'md_team'        => 'Executive leadership team at Shivalik Rasayan Limited.',
        ]);

        $this->db->table('tbl_page_dynamic')
            ->where('slug', 'leadership-at-srl')
            ->where('lang_id', $langId)
            ->update(['status' => 'Inactive']);

        $members = [
            [
                'name'        => 'Rahul Bishnoi',
                'designation' => 'Chairman',
                'photo_src'   => 'leader-rahul-bishnoi.jpg',
                'detail'      => '<p>Rahul Bishnoi is having 25 years of rich experience in managing agrochemical, APIs and Finished Dosage Form plants. Currently he is the Chairman of Shivalik Rasayan Limited &amp; Medicamen Biotech Ltd. His core competence includes strategic business planning, financial analysis, and developing new business model with strong processes.</p><p>He spearheaded the initiatives regarding acquisition of the then sick Shivalik Rasayan Limited in the year 2002 &amp; debt ridden Medicamen Biotech Limited in 2016 and subsequently transformed these into profit making companies.</p><p>Mr. Bishnoi is a first-generation entrepreneur. He has earned his Commerce degree from Punjab University, Chandigarh in 1983 and completed Chartered Accountant programme in the year 1986.</p>',
            ],
            [
                'name'        => 'Dr. Vimal Kumar Shrawat',
                'designation' => 'Managing Director',
                'photo_src'   => 'leader-vimal-shrawat.jpg',
                'detail'      => '<p>Dr. Shrawat holds a Doctorate Degree in Organic Chemistry from Centre of Advanced Studies, Department of Chemistry, University of Delhi, India. He previously held position of Chief Operating Officer (COO) in Shilpa Medicare Limited. Apart from this, he has over 30 years of vast experience of having worked in renowned Pharma companies like Fresenius Kabi Oncology Limited (Formerly Dabur Pharma Ltd), Ranbaxy Laboratories Ltd, and VAM Organics Ltd., spanning across activities of R&amp;D, Pilot &amp; Plant Productions, QA/QC, Administration, CRAMS, Project Management etc. His keen interest in and consistent efforts for R&amp;D has led him to become one of key contributors in a large number of Patents/applications. He is a very well-known name in the pharma scientific fraternity.</p><p>He is overall in charge of activities in Shivalik Rasayan Limited. Under his dynamic leadership, SRL is developing its niche Oncology and Non-Oncology APIs. He is the guiding force for Organic Synthesis/ Intermediates APIs and Formulation Development. His vision of team work and time bound approach always guides &amp; motivates the teams at all our operational sites.</p>',
            ],
            [
                'name'        => 'Suresh Kumar Singh',
                'designation' => 'Vice Chairman',
                'photo_src'   => 'leader-suresh-kumar.jpg',
                'detail'      => '<p>Mr. S. K. Singh is a Chemical Engineer with over 30 years rich experience of running chemical units. He has served as a Production Controller at M/s Synthetics and Chemicals Limited for approximately 12 years. He is responsible for running agrochemical unit of Shivalik Rasayan at Dehradun.</p>',
            ],
            [
                'name'        => 'Ashwani Sharma',
                'designation' => 'Director',
                'photo_src'   => 'leader-ashwani-sharma.jpg',
                'detail'      => '<p>Mr. Ashwani Sharma is a Graduate, possessing rich experience in running administrative affairs of Shivalik Rasayan Limited. Mr. Sharma was appointed as Director of Shivalik Rasayan Limited on 18.07.2003. He has over 30 years of experience in managing Supply chain activities of Shivalik Rasayan Limited.</p>',
            ],
            [
                'name'        => 'Harish Pande',
                'designation' => 'Director',
                'photo_src'   => 'leader-harish-pande.jpg',
                'detail'      => '<p>Mr. Harish Pande is a Graduate with a vast experience of 30 years in the field of Marketing of AgroChemicals, Technical Formulations and Industrial Chemicals. He has worked in served M/s Ficom Organics Limited for almost 20 years and is currently one of the Directors at Shivalik Rasayan Limited.</p>',
            ],
            [
                'name'        => 'Anand Kumar',
                'designation' => 'VP – Sales & Business Development',
                'photo_src'   => 'leader-anand-kumar.jpg',
                'detail'      => '<p>Mr. Anand Kumar brings with him over 30 years of valuable experience of handling global oncology sales in major companies like Dabur Pharma Ltd., Fresenius Kabi Oncology Ltd., etc. He is responsible for global API sales.</p>',
            ],
        ];

        $this->db->table('tbl_team_member')->where('lang_id', $langId)->delete();

        $id = 1;
        foreach ($members as $member) {
            $photoFile = 'team-member-' . $id . '.jpg';
            $source = $aboutDir . $member['photo_src'];

            if (is_file($source)) {
                copy($source, $uploadDir . $photoFile);
            }

            $this->db->table('tbl_team_member')->insert([
                'name'             => $member['name'],
                'designation'      => $member['designation'],
                'photo'            => $photoFile,
                'detail'           => $member['detail'],
                'facebook'         => '',
                'twitter'          => '',
                'linkedin'         => '',
                'youtube'          => '',
                'google_plus'      => '',
                'instagram'        => '',
                'flickr'           => '',
                'phone'            => '',
                'email'            => '',
                'website'          => '',
                'meta_title'       => $member['name'] . ' | Shivalik Rasayan Limited',
                'meta_keyword'     => 'Shivalik Rasayan leadership',
                'meta_description' => $member['name'] . ' – ' . $member['designation'] . ' at Shivalik Rasayan Limited.',
                'lang_id'          => $langId,
            ]);

            $id++;
        }

        echo 'Leadership team: seeded ' . count($members) . ' members (lang_id=' . $langId . ').' . PHP_EOL;
    }
}
