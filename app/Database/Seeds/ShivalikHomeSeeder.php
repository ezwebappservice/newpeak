<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShivalikHomeSeeder extends Seeder
{
    public function run()
    {
        $langId = 5;
        $langRow = $this->db->table('tbl_lang')->where('lang_default', 'Yes')->get()->getRowArray();
        if ($langRow) {
            $langId = (int) $langRow['lang_id'];
        }

        $welcomeText = '<p>Shivalik Rasayan Ltd. (SRL) is a chemistry-driven Indian manufacturer built to serve <strong>healthcare</strong> and <strong>crop protection</strong>.</p>'
            . '<p>We are India\'s largest producer of Dimethoate Technical and the second-largest producer of Malathion Technical. With Medicamen Biotech Ltd, we also develop oncology and non-oncology APIs from our Dahej facility.</p>'
            . '<p>In simple terms: <strong>we make the chemistry that helps protect crops and improve human health</strong> — with quality systems aligned to global regulators.</p>';

        $this->db->table('tbl_page_home')->where('lang_id', $langId)->update([
            'hero_badge'              => 'Shivalik Rasayan Limited',
            'hero_title_prefix'       => 'We Manufacture',
            'hero_title_highlight'    => 'APIs, Agrochemicals & Specialty Chemicals',
            'hero_lead'               => 'We are an Indian chemistry company serving healthcare and crop protection — with USFDA/EDQM-aligned facilities, DSIR-recognized R&D, and products trusted in India and global markets.',
            'hero_btn1_text'          => 'Who We Are',
            'hero_btn1_url'           => '#about',
            'hero_btn2_text'          => 'What We Do',
            'hero_btn2_url'           => '#products',
            'home_welcome_title'      => 'Who We Are',
            'home_welcome_subtitle'   => 'Shivalik Rasayan Limited',
            'home_welcome_text'       => $welcomeText,
            'home_welcome_pbar1_text' => 'DSIR Recognized',
            'home_welcome_pbar2_text' => 'R&D Centre, Bhiwadi',
            'home_vision_title'       => 'Our Vision',
            'home_vision_text'        => 'To be a globally respected chemistry-driven healthcare and crop protection company.',
            'home_mission_title'      => 'Our Mission',
            'home_mission_text'       => 'Deliver innovative, affordable and regulatory-compliant products that improve lives worldwide.',
            'home_service_title'      => 'What We Do',
            'home_service_subtitle'   => 'Our Services & Capabilities',
            'home_service_intro'      => 'Four clear capabilities for customers and partners — manufacturing, product supply and R&D support across pharmaceuticals and agrochemicals.',
            'home_feature_title'      => 'Who We Serve',
            'home_feature_subtitle'   => 'Industries & Markets',
            'home_feature_intro'      => 'We work with pharmaceutical, agriculture and chemical partners in India and export markets.',
            'home_why_choose_title'   => 'Why Choose Us',
            'home_why_choose_subtitle'=> 'Strength Built on Science & Scale',
            'home_why_choose_intro'   => 'From Dehradun to Dahej, SRL combines decades of manufacturing excellence with cutting-edge R&D and global regulatory compliance.',
            'home_cert_title'         => 'Quality & Compliance',
            'home_cert_subtitle'      => 'Certifications & Standards',
            'home_cert_intro'         => 'Committed to the highest global quality, safety and environmental standards.',
            'home_partners_tagline'   => 'Trusted by partners across India and global markets',
            'home_feature_mini1_title'=> 'Strategic Locations',
            'home_feature_mini1_text' => 'Dehradun, Bhiwadi (R&D) and Dahej I/II/III, Gujarat',
            'home_feature_mini1_icon' => 'bi bi-geo-alt',
            'home_feature_mini2_title'=> 'Growth Trajectory',
            'home_feature_mini2_text' => '59% revenue growth with expanding global footprint',
            'home_feature_mini2_icon' => 'bi bi-graph-up-arrow',
            'home_testimonial_title'  => 'Testimonials',
            'home_testimonial_subtitle'=> 'What Our Partners Say',
            'home_blog_title'         => 'Latest Updates',
            'home_blog_subtitle'      => 'Shivalik Rasayan in News',
            'counter_1_title'         => 'Employees',
            'counter_1_value'         => '250',
            'counter_1_suffix'        => '+',
            'counter_2_title'         => 'API Capacity (MT)',
            'counter_2_value'         => '1500',
            'counter_2_suffix'        => '',
            'counter_3_title'         => 'GL & SS Reactors',
            'counter_3_value'         => '32',
            'counter_3_suffix'        => '',
            'counter_4_title'         => 'R&D Scientists',
            'counter_4_value'         => '60',
            'counter_4_suffix'        => '+',
        ]);

        $this->db->table('tbl_page_home_lang_independent')->where('id', 1)->update([
            'home_hero_status'           => 'Show',
            'home_welcome_status'        => 'Show',
            'home_service_status'        => 'Show',
            'home_feature_status'        => 'Show',
            'home_why_choose_status'     => 'Show',
            'home_certification_status'  => 'Show',
            'home_partners_status'       => 'Show',
            'counter_status'             => 'Show',
            'home_testimonial_status'    => 'Show',
            'home_blog_status'           => 'Show',
            'home_blog_item'             => 3,
        ]);

        $this->seedTable('tbl_service', $langId, [
            ['name' => 'APIs', 'short_description' => 'Manufacture oncology & general APIs (Busulfan, Temozolomide, Pirfenidone and more) from USFDA/EDQM-aligned facilities.', 'icon' => 'bi bi-capsule', 'link_text' => 'Explore APIs', 'link_url' => 'oncology-products'],
            ['name' => 'Agrochemicals', 'short_description' => 'Crop-protection chemistry including organophosphorus insecticides — India\'s #1 Dimethoate Technical producer.', 'icon' => 'bi bi-flower1', 'link_text' => 'Explore Agrochem', 'link_url' => 'agrochemical-bu'],
            ['name' => 'Specialty Chemicals', 'short_description' => 'Advanced intermediates, specialty chemicals and high-grade impurities for global pharma and chemical partners.', 'icon' => 'bi bi-bezier2', 'link_text' => 'Explore Specialty', 'link_url' => 'specialty-chemicals'],
            ['name' => 'R&D', 'short_description' => 'DSIR-recognized R&D with 60+ scientists — process development, new molecules and finished dosage forms.', 'icon' => 'bi bi-lightbulb', 'link_text' => 'Explore R&D', 'link_url' => 'research-and-development-bu'],
        ], function ($row) use ($langId) {
            return [
                'name'              => $row['name'],
                'short_description' => $row['short_description'],
                'description'       => $row['short_description'],
                'photo'             => '',
                'meta_title'        => $row['name'],
                'meta_keyword'      => '',
                'meta_description'  => $row['short_description'],
                'icon'              => $row['icon'],
                'link_url'          => $row['link_url'],
                'link_text'         => $row['link_text'],
                'lang_id'           => $langId,
            ];
        });

        $this->seedTable('tbl_feature', $langId, [
            ['name' => 'Pharmaceuticals', 'icon' => 'bi bi-heart-pulse'],
            ['name' => 'Agriculture', 'icon' => 'bi bi-tree'],
            ['name' => 'Export Markets', 'icon' => 'bi bi-globe2'],
            ['name' => 'Contract Mfg.', 'icon' => 'bi bi-building'],
            ['name' => 'Fine Chemicals', 'icon' => 'bi bi-droplet'],
            ['name' => 'Regulatory', 'icon' => 'bi bi-shield-check'],
        ], function ($row) use ($langId) {
            return [
                'name'    => $row['name'],
                'content' => $row['name'],
                'icon'    => $row['icon'],
                'lang_id' => $langId,
            ];
        });

        $this->seedTable('tbl_why_choose', $langId, [
            ['name' => 'USFDA-approved API facility at Dahej'],
            ['name' => 'CEP certifications from EDQM for key APIs'],
            ['name' => 'Zero effluent discharge commitment'],
            ['name' => 'Exports to UAE, Poland, China & beyond'],
        ], function ($row) use ($langId) {
            return [
                'name'    => $row['name'],
                'content' => $row['name'],
                'icon'    => 'bi bi-check-circle-fill',
                'photo'   => '',
                'lang_id' => $langId,
            ];
        });

        $this->seedTable('tbl_certification', $langId, [
            ['name' => 'USFDA', 'description' => 'API facility approved with Establishment Inspection Report (EIR) released.', 'icon' => 'bi bi-patch-check', 'sort_order' => 1],
            ['name' => 'EDQM / CEP', 'description' => 'CEP granted for Busulfan, Clonidine HCl, Pirfenidone, Temozolomide & more.', 'icon' => 'bi bi-award', 'sort_order' => 2],
            ['name' => 'Zero Effluent', 'description' => 'Sustainable manufacturing with zero liquid discharge facilities.', 'icon' => 'bi bi-recycle', 'sort_order' => 3],
            ['name' => 'DSIR', 'description' => 'R&D Centre recognized by Department of Scientific & Industrial Research, Govt. of India.', 'icon' => 'bi bi-mortarboard', 'sort_order' => 4],
        ], function ($row) use ($langId) {
            return [
                'name'        => $row['name'],
                'description' => $row['description'],
                'icon'        => $row['icon'],
                'sort_order'  => $row['sort_order'],
                'lang_id'     => $langId,
            ];
        });

        $this->seedTable('tbl_client', null, [
            ['name' => 'Medicamen Biotech'],
            ['name' => 'PharmaDanica'],
            ['name' => 'Mission Pharma'],
            ['name' => 'CFAO Group'],
            ['name' => 'Global Pharma'],
            ['name' => 'Agro Partners'],
            ['name' => 'Export Alliance'],
            ['name' => 'Research Collab'],
        ], function ($row) {
            return ['name' => $row['name'], 'url' => '', 'photo' => ''];
        });

        $this->seedTable('tbl_testimonial', $langId, [
            ['name' => 'Rajesh Kumar', 'designation' => 'Procurement Head, Global Pharma', 'comment' => "SRL's commitment to regulatory compliance and consistent API quality has made them a reliable partner for our oncology portfolio."],
            ['name' => 'Anita Mehta', 'designation' => 'Director, Agro Solutions Ltd.', 'comment' => 'Their Dimethoate technical quality and timely delivery have strengthened our agrochemical supply chain across multiple seasons.'],
            ['name' => 'Dr. David Lee', 'designation' => 'Chief Scientific Officer, MedTech Innovations', 'comment' => 'The R&D team at Bhiwadi demonstrates exceptional scientific rigor — a true partner in developing niche pharmaceutical intermediates.'],
        ], function ($row) use ($langId) {
            return [
                'name'        => $row['name'],
                'designation' => $row['designation'],
                'comment'     => $row['comment'],
                'photo'       => '',
                'lang_id'     => $langId,
            ];
        });

        if ($this->db->tableExists('tbl_slider')) {
            $sliderRows = [
                ['photo' => 'hero-bg.jpg'],
                ['photo' => 'hero-slide-2.jpg'],
            ];

            $this->db->table('tbl_slider')->where('lang_id', $langId)->delete();

            foreach ($sliderRows as $slide) {
                $this->db->table('tbl_slider')->insert([
                    'photo'        => $slide['photo'],
                    'heading'      => '',
                    'content'      => '',
                    'button1_text' => '',
                    'button1_url'  => '',
                    'button2_text' => '',
                    'button2_url'  => '',
                    'position'     => 'Left',
                    'lang_id'      => $langId,
                ]);
            }
        }

        echo 'Home page content seeded (lang_id=' . $langId . ').' . PHP_EOL;
    }

    private function seedTable(string $table, ?int $langId, array $rows, callable $mapper): void
    {
        if (! $this->db->tableExists($table)) {
            return;
        }

        if ($langId !== null) {
            $this->db->table($table)->where('lang_id', $langId)->delete();
        } else {
            $this->db->table($table)->truncate();
        }

        foreach ($rows as $row) {
            $this->db->table($table)->insert($mapper($row));
        }
    }
}
