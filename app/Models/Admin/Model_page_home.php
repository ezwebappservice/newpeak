<?php
namespace App\Models\Admin;



class Model_page_home extends \App\Models\CI3Model 
{
    function show()
    {
        $sql = "SELECT * 
                FROM tbl_page_home t1
                JOIN tbl_lang t2
                ON t1.lang_id = t2.lang_id
                ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function show_lang_independent()
    {
        $sql = "SELECT * FROM tbl_page_home_lang_independent WHERE id=?";
        $query = $this->db->query($sql,[1]);
        return $query->getRowArray();
    }

    function update($id,$data) 
    {
        $this->ensurePageHomeColumns();
        $data = $this->existingTableData('tbl_page_home', $data);
        if ($data === []) {
            return;
        }

        $this->db->where('id',$id);
        $this->db->table('tbl_page_home')->update($data);
    }

    function get_page_home($id)
    {
        $this->ensurePageHomeColumns();

        $query = $this->db->query("SELECT * 
                FROM tbl_page_home t1 
                JOIN tbl_lang t2 
                ON t1.lang_id = t2.lang_id 
                WHERE t1.id=?",
                [$id]
            );
        return $query->getRowArray();
    }

    function page_home_check($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_page_home');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->getRowArray();
    }

    public function update_home($data)
    {
        $data = $this->existingTableData('tbl_page_home_lang_independent', $data);
        if ($data === []) {
            return;
        }

        $this->db->where('id',1);
        $this->db->table('tbl_page_home_lang_independent')->update($data);
    }

    /**
     * Add homepage columns that newer admin saves expect, so FTP-deployed
     * databases that missed spark migrate do not fail with "unknown column".
     */
    public function ensurePageHomeColumns(): void
    {
        static $ensured = false;
        if ($ensured) {
            return;
        }
        $ensured = true;

        $db = \Config\Database::connect();
        if (! $db->tableExists('tbl_page_home')) {
            return;
        }

        $forge = \Config\Database::forge();
        $columns = [
            'counter_5_title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'counter_5_value'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'counter_5_suffix'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'counter_5_icon'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'hero_title_suffix'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_feature_1_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_feature_2_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_feature_3_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_name'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_role'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_org'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_card_badge'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_tab_text'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ];

        $schemaChanged = false;
        foreach ($columns as $name => $def) {
            if (! $db->fieldExists($name, 'tbl_page_home')) {
                $forge->addColumn('tbl_page_home', [$name => $def]);
                $schemaChanged = true;
            }
        }

        foreach ($db->getFieldData('tbl_page_home') as $field) {
            if (! preg_match('/^counter_[1-4]_value$/', $field->name)) {
                continue;
            }
            if (stripos((string) $field->type, 'int') === false) {
                continue;
            }
            $forge->modifyColumn('tbl_page_home', [
                $field->name => [
                    'name'       => $field->name,
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => false,
                ],
            ]);
            $schemaChanged = true;
        }

        if ($schemaChanged) {
            unset($db->dataCache['field_names']['tbl_page_home']);
        }
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function existingTableData(string $table, array $data): array
    {
        $db = \Config\Database::connect();
        if (! $db->tableExists($table)) {
            return [];
        }

        return array_intersect_key($data, array_flip($db->getFieldNames($table)));
    }
}