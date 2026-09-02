<?php

namespace App\Models\Admin;

class Model_dashboard extends \App\Models\CI3Model
{
    protected function countTable(string $table): int
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists($table)) {
            return 0;
        }

        return (int) $db->table($table)->countAllResults();
    }

    public function show_total_category(): int
    {
        return $this->countTable('tbl_category');
    }

    public function show_total_news(): int
    {
        return $this->countTable('tbl_news');
    }

    public function show_total_team_member(): int
    {
        return $this->countTable('tbl_team_member');
    }

    public function show_total_career(): int
    {
        return $this->countTable('tbl_career');
    }

    public function show_total_dynamic_page(): int
    {
        return $this->countTable('tbl_page_dynamic');
    }

    public function show_total_api_product(): int
    {
        return $this->countTable('tbl_api_product');
    }

    public function show_total_investor_document(): int
    {
        return $this->countTable('tbl_investor_document');
    }

    public function show_total_site_inquiry(): int
    {
        return $this->countTable('tbl_site_inquiry');
    }

    public function show_new_site_inquiry(): int
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('tbl_site_inquiry')) {
            return 0;
        }

        return (int) $db->table('tbl_site_inquiry')->where('status', 'New')->countAllResults();
    }

    public function show_total_subscriber(): int
    {
        return $this->countTable('tbl_subscriber');
    }
}
