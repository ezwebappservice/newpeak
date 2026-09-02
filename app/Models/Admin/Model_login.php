<?php
namespace App\Models\Admin;



class Model_login extends \App\Models\CI3Model 
{

    public function get_setting_data()
    {
        $query = $this->db->query("SELECT * from tbl_settings WHERE id=1");
        return $query->getRowArray();
    }

	function check_email($email) 
	{
        $where = array(
			'email' => $email
		);
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->getRowArray();
    }

    function update_password_hash(int $userId, string $hash): void
    {
        $this->db->where('id', $userId);
        $this->db->table('tbl_user')->update(['password' => $hash]);
    }

}