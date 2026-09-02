<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShivalikContactSeeder extends Seeder
{
    public function run()
    {
        $langId = 5;
        $langRow = $this->db->table('tbl_lang')->where('lang_default', 'Yes')->get()->getRowArray();
        if ($langRow) {
            $langId = (int) $langRow['lang_id'];
        }

        $this->db->table('tbl_page_contact')->where('lang_id', $langId)->update([
            'contact_heading'  => 'Contact Us',
            'contact_subtitle' => 'Stay in touch with us',
            'contact_intro'    => 'We work from Monday till Saturday from 10:00 a.m. to 6:00 p.m.',
            'contact_address'  => "1506, Chiranjiv Tower,\n43, Nehru Place,\nNew Delhi - 110019, India",
            'contact_phone'    => '+91-11-47589500',
            'contact_email'    => 'info@shivalikrasayan.com',
            'contact_website'  => 'www.shivalikrasayan.com',
            'contact_hours'    => "For any queries, please connect on mail or phone\n\nPhone: +91-11-47589500\nMonday - Friday: 10:00 - 18:00\nSecond Saturday is Off: 10:00 - 16:00",
            'contact_map'      => '',
            'mt_contact'       => 'Contact Us | Shivalik Rasayan Limited',
            'mk_contact'       => 'Shivalik Rasayan contact, SRL connect',
            'md_contact'       => 'Contact Shivalik Rasayan Limited for product inquiries, partnerships and investor relations.',
        ]);

        $this->db->table('tbl_page_dynamic')
            ->where('slug', 'connect')
            ->where('lang_id', $langId)
            ->update(['status' => 'Inactive']);

        $locations = [
            [
                'title'      => 'Our Dahej Facility',
                'address'    => "D-2/CH/41/A, GIDC Industrial Estates, Dahej-II\nPinCode - 392140, District Bharuch (Gujarat), India",
                'sort_order' => 1,
            ],
            [
                'title'      => 'Dehradun Facility',
                'address'    => "Kolhupani, P.O. Chandanwari, Via Prem Nagar\nDehradun, PinCode - 248007, Uttrakhand, India",
                'sort_order' => 2,
            ],
            [
                'title'      => 'R&D Centre',
                'address'    => "SP-1192 A&B Phase-IV, Industrial Area, Bhiwadi-301019\nDistrict Alwar, Rajasthan, India",
                'sort_order' => 3,
            ],
        ];

        $this->db->table('tbl_contact_locations')->where('lang_id', $langId)->delete();

        foreach ($locations as $loc) {
            $this->db->table('tbl_contact_locations')->insert([
                'title'      => $loc['title'],
                'address'    => $loc['address'],
                'sort_order' => $loc['sort_order'],
                'status'     => 'Active',
                'lang_id'    => $langId,
            ]);
        }

        echo 'Contact page and ' . count($locations) . ' locations seeded (lang_id=' . $langId . ').' . PHP_EOL;
    }
}
