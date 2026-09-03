<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShivalikNewsSeeder extends Seeder
{
    public function run()
    {
        helper('news');

        $langId = 5;
        $langRow = $this->db->table('tbl_lang')->where('lang_default', 'Yes')->get()->getRowArray();
        if ($langRow) {
            $langId = (int) $langRow['lang_id'];
        }

        $categoryId = $this->ensureCategory('Latest Updates', $langId);

        $uploadDir = (defined('FCPATH') ? FCPATH : ROOTPATH . 'public/') . 'uploads/';
        $assetDir = (defined('FCPATH') ? FCPATH : ROOTPATH . 'public/') . 'assets/images/';

        $articles = [
            [
                'slug'    => 'agro-chemicals-plant-dahej-iii-gujarat',
                'title'   => 'Up-coming Agro-chemicals, synthetic Organic Chemicals & Intermediates plant at Dahej-III, Gujarat',
                'short'   => 'The Company is setting up an Agro-Chemical, synthetic Organic Chemicals & Intermediates plant at Dahej-III with an installed capacity of 20100MT.',
                'content' => '<p>The Company is setting up an Agro-Chemical, synthetic Organic Chemicals &amp; Intermediates plant at Dahej-III with an installed capacity of 20100MT. The Company has already received Environment Clearance (EC) for setting up the plant. The plant expected to be operational by April 2023. The construction activities are in full swing.</p>',
                'date'    => '2022-07-15',
                'photo'   => 'news-dahej.jpg',
            ],
            [
                'slug'    => 'srl-first-us-dmf-bortezomib-usfda',
                'title'   => 'SRL submits first US Drug Master File for Bortezomib to USFDA',
                'short'   => 'SRL has successfully submitted its first US Drug Master File (DMF) for BORTEZOMIB through ESG gateway to USFDA.',
                'content' => '<p>SRL has successfully submitted its first US Drug Master File (DMF) for BORTEZOMIB through ESG gateway to USFDA.</p>',
                'date'    => '2022-07-14',
                'photo'   => 'news-usfda.jpg',
            ],
            [
                'slug'    => 'cep-granted-busulfan-clonidine-pirfenidone-temozolomide',
                'title'   => 'SRL granted CEP for Busulfan, Clonidine HCl, Pirfenidone and Temozolomide',
                'short'   => 'SRL has successfully submitted CEP for PIRFENIDONE, TEMOZOLOMIDE, BUSULPHAN to EDQM, Europe.',
                'content' => '<p>SRL has been granted CEP for Busulfan, Clonidine HCl, Pirfenidone and Temozolomide. SRL has successfully submitted CEP for PIRFENIDONE, TEMOZOLOMIDE, BUSULPHAN to EDQM, Europe. It has also submitted CEP application for Ambroxol HCl and Pemetrexed Disodium Heptahydrate.</p>',
                'date'    => '2022-07-14',
                'photo'   => 'news-cep.jpg',
            ],
            [
                'slug'    => 'dr-vimal-kumar-shrawat-managing-director-srl',
                'title'   => 'Dr. Vimal Kumar Shrawat, Industry veteran, joins SRL as Managing Director',
                'short'   => 'Dr. Vimal Kumar Shrawat-COO of Shilpa Medicare Limited joins as Managing Director Peak Potential.',
                'content' => '<p>Dr. Vimal Kumar Shrawat-COO of Shilpa Medicare Limited joins as Managing Director Peak Potential. Dr. Shrawat as COO spearheaded Shilpa Medicare\'s growth into Oncology segment.</p>',
                'date'    => '2019-04-10',
                'photo'   => 'news-cep.jpg',
            ],
            [
                'slug'    => 'srl-corporate-update-august-2018',
                'title'   => 'Peak Potential – Corporate Update',
                'short'   => 'Latest corporate update from Peak Potential.',
                'content' => '<p>Peak Potential continues to strengthen its pharmaceutical and agrochemical operations with a focus on quality, innovation and sustainable growth.</p>',
                'date'    => '2018-08-29',
                'photo'   => 'news-dahej.jpg',
            ],
            [
                'slug'    => 'srl-files-process-patent-temozolomide',
                'title'   => 'SRL files process patent for Temozolomide',
                'short'   => 'Peak Potential has filed a process patent for Temozolomide, reinforcing its commitment to oncology API innovation.',
                'content' => '<p>Peak Potential has filed a process patent for Temozolomide as part of its ongoing investment in oncology active pharmaceutical ingredients and intellectual property development.</p>',
                'date'    => '2018-08-08',
                'photo'   => 'news-usfda.jpg',
            ],
        ];

        $this->db->table('tbl_news')->where('lang_id', $langId)->delete();

        $id = 1;
        foreach ($articles as $article) {
            $photoFile = 'news-' . $id . '.jpg';
            $bannerFile = 'news-banner-' . $id . '.jpg';
            $source = $assetDir . $article['photo'];

            if (is_file($source)) {
                copy($source, $uploadDir . $photoFile);
                copy($source, $uploadDir . $bannerFile);
            } else {
                $photoFile = 'news-' . $id . '.jpg';
                $bannerFile = 'news-banner-' . $id . '.jpg';
            }

            $this->db->table('tbl_news')->insert([
                'news_title'         => $article['title'],
                'news_slug'          => news_unique_slug($article['slug']),
                'news_content'       => $article['content'],
                'news_content_short' => $article['short'],
                'news_date'          => $article['date'],
                'photo'              => $photoFile,
                'banner'             => $bannerFile,
                'category_id'        => $categoryId,
                'comment'            => 'Off',
                'meta_title'         => $article['title'] . ' | Peak Potential',
                'meta_keyword'       => 'PeakRasayan, SRL, news',
                'meta_description'   => $article['short'],
                'lang_id'            => $langId,
            ]);

            $id++;
        }

        $this->db->table('tbl_page_news')
            ->where('lang_id', $langId)
            ->update([
                'news_heading' => 'News',
                'mt_news'      => 'News | Peak Potential',
                'md_news'      => 'Latest news and updates from Peak Potential.',
            ]);

        echo 'Seeded ' . count($articles) . ' news articles (lang_id=' . $langId . ').' . PHP_EOL;
    }

    private function ensureCategory(string $name, int $langId): int
    {
        $row = $this->db->table('tbl_category')
            ->where('category_name', $name)
            ->where('lang_id', $langId)
            ->get()
            ->getRowArray();

        if ($row) {
            return (int) $row['category_id'];
        }

        $this->db->table('tbl_category')->insert([
            'category_name'    => $name,
            'category_banner'  => 'category-banner-1.jpg',
            'meta_title'       => $name,
            'meta_keyword'     => '',
            'meta_description' => '',
            'lang_id'          => $langId,
        ]);

        return (int) $this->db->insertID();
    }
}
