<?php
namespace App\Models;



class Model_admin extends \App\Models\CI3Model
{
    function forget_password_update($email,$data) {
        $this->db->where('email',$email);
        $this->db->table('tbl_user')->update($data);
    }

    function reset_password_update($email,$data) {
        $this->db->where('email',$email);
        $this->db->table('tbl_user')->update($data);
    }

    function check_email($email) 
    {
        $sql = "SELECT * FROM tbl_user WHERE email=?";
        $query = $this->db->query($sql,array($email));
        return $query->getRowArray();
    }

    function check_password($email,$password)
    {
        $sql = "SELECT * FROM tbl_user WHERE email=? AND password=?";
        $query = $this->db->query($sql,array($email,md5($password)));
        return $query->getRowArray();
    }

    public function check_url($email,$token) {
        $sql = "SELECT * from tbl_user WHERE email=? AND token=?";
        $query = $this->db->query($sql,array($email,$token));
        return $query->getNumRows();
    }

    public function setting_update($data)
    {
        $this->db->where('id',1);
        $this->db->table('tbl_settings')->update($data);
    }

    function profile_update($data) {
        $this->db->where('id',1);
        $this->db->table('tbl_user')->update($data);
    }

    public function all_photos() {
        $sql = "SELECT * FROM tbl_photo ORDER BY photo_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function total_photos()
    {
        $sql = 'SELECT * from tbl_photo';
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }
    public function total_directories()
    {
        $sql = 'SELECT * from tbl_directory';
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }
    public function total_client()
    {
        $sql = 'SELECT * from tbl_client';
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }

    function photo_ai_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_photo'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function photo_add($data) {
        $this->db->table('tbl_photo')->insert($data);
        return $this->db->insert_id();
    }

    function photo_update($id,$data) {
        $this->db->where('photo_id',$id);
        $this->db->table('tbl_photo')->update($data);
    }
    function photo_delete($id)
    {
        $this->db->where('photo_id',$id);
        $this->db->table('tbl_photo')->delete();
    }
    function photo_get_data_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_photo WHERE photo_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    function photo_check($id)
    {
        $sql = 'SELECT * FROM tbl_photo WHERE photo_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    public function all_directories() {
        $sql = "SELECT * FROM tbl_directory ORDER BY directory_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function directory_ai_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_directory'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function directory_add($data) {
        $this->db->table('tbl_directory')->insert($data);
        return $this->db->insert_id();
    }

    function directory_update($id,$data) {
        $this->db->where('directory_id',$id);
        $this->db->table('tbl_directory')->update($data);
    }
    function directory_delete($id)
    {
        $this->db->where('directory_id',$id);
        $this->db->table('tbl_directory')->delete();
    }
    function directory_get_data_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_directory WHERE directory_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    function directory_check($id)
    {
        $sql = 'SELECT * FROM tbl_directory WHERE directory_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    public function all_testimonials() {
        $sql = "SELECT * FROM tbl_testimonial ORDER BY testimonial_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function testimonial_ai_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_testimonial'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function testimonial_add($data) {
        $this->db->table('tbl_testimonial')->insert($data);
        return $this->db->insert_id();
    }

    function testimonial_update($id,$data) {
        $this->db->where('testimonial_id',$id);
        $this->db->table('tbl_testimonial')->update($data);
    }
    function testimonial_delete($id)
    {
        $this->db->where('testimonial_id',$id);
        $this->db->table('tbl_testimonial')->delete();
    }
    function testimonial_get_data_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_testimonial WHERE testimonial_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    function testimonial_check($id)
    {
        $sql = 'SELECT * FROM tbl_testimonial WHERE testimonial_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }







    public function all_client() {
        $sql = "SELECT * FROM tbl_client ORDER BY client_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function client_ai_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_client'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function client_add($data) {
        $this->db->table('tbl_client')->insert($data);
        return $this->db->insert_id();
    }

    function client_update($id,$data) {
        $this->db->where('client_id',$id);
        $this->db->table('tbl_client')->update($data);
    }
    function client_delete($id)
    {
        $this->db->where('client_id',$id);
        $this->db->table('tbl_client')->delete();
    }
    function client_get_data_by_id($id)
    {
        $sql = 'SELECT * FROM tbl_client WHERE client_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    function client_check($id)
    {
        $sql = 'SELECT * FROM tbl_client WHERE client_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }
    // function client_background_delete($id) {
    //     $this->db->where('client_id',$id);
    //     $this->db->table('tbl_client')->delete();
    // }
}