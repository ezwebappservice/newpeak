<?php
namespace App\Models\Admin;




class Model_lang extends \App\Models\CI3Model 
{
    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_lang'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function check_category_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_category WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_event_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_event WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_faq_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_faq WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_feature_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_feature WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_news_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_news WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }


    function check_portfolio_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_portfolio WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_portfolio_category_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_portfolio_category WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_pricing_table_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_pricing_table WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_service_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_service WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_slider_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_slider WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_team_member_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_team_member WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_testimonial_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_testimonial WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }

    function check_why_choose_for_lang_id($id) {
        $sql = "SELECT * FROM tbl_why_choose WHERE lang_id=?";
        $query = $this->db->query($sql,[$id]);
        return $query->getNumRows();
    }


    function delete_from_footer($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_footer')->delete();
    }

    function delete_from_page_about($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_about')->delete();
    }

    function delete_from_page_contact($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_contact')->delete();
    }

    function delete_from_page_event($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_event')->delete();
    }

    function delete_from_page_faq($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_faq')->delete();
    }

    function delete_from_page_home($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_home')->delete();
    }

    function delete_from_page_news($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_news')->delete();
    }

    function delete_from_page_photo_gallery($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_photo_gallery')->delete();
    }

    function delete_from_page_portfolio($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_portfolio')->delete();
    }

    function delete_from_page_pricing($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_pricing')->delete();
    }

    function delete_from_page_privacy($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_privacy')->delete();
    }

    function delete_from_page_search($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_search')->delete();
    }

    function delete_from_page_service($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_service')->delete();
    }

    function delete_from_page_team($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_team')->delete();
    }

    function delete_from_page_term($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_term')->delete();
    }

    function delete_from_page_testimonial($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_page_testimonial')->delete();
    }


    
    
    function show() {
        $sql = "SELECT * FROM tbl_lang ORDER BY lang_id ASC";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function make_all_empty($data)
    {
        $this->db->table('tbl_lang')->update($data);
    }

    function add($data) {
        $this->db->table('tbl_lang')->insert($data);
        return $this->db->insert_id();
    }

    function add_detail($data) {
        $this->db->table('tbl_lang_detail')->insert($data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_lang')->update($data);
    }

    function delete($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_lang')->delete();
    }
    function delete_detail($id)
    {
        $this->db->where('lang_id',$id);
        $this->db->table('tbl_lang_detail')->delete();
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_lang WHERE lang_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function lang_check($id)
    {
        $sql = 'SELECT * FROM tbl_lang WHERE lang_id=?';
        $query = $this->db->query($sql,array($id));
        return $query->getRowArray();
    }

    function detail($id) {
        $sql = "SELECT * FROM tbl_lang_detail WHERE lang_id=?";
        $query = $this->db->query($sql,array($id));
        return $query->getResultArray();
    }

    function update_detail($id,$data) {
        $this->db->where('lang_detail_id',$id);
        $this->db->table('tbl_lang_detail')->update($data);
    }

    function add_page_home($data) {
        $this->db->table('tbl_page_home')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_about($data) {
        $this->db->table('tbl_page_about')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_faq($data) {
        $this->db->table('tbl_page_faq')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_service($data) {
        $this->db->table('tbl_page_service')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_testimonial($data) {
        $this->db->table('tbl_page_testimonial')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_news($data) {
        $this->db->table('tbl_page_news')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_event($data) {
        $this->db->table('tbl_page_event')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_search($data) {
        $this->db->table('tbl_page_search')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_term($data) {
        $this->db->table('tbl_page_term')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_privacy($data) {
        $this->db->table('tbl_page_privacy')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_team($data) {
        $this->db->table('tbl_page_team')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_portfolio($data) {
        $this->db->table('tbl_page_portfolio')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_photo_gallery($data) {
        $this->db->table('tbl_page_photo_gallery')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_pricing($data) {
        $this->db->table('tbl_page_pricing')->insert($data);
        return $this->db->insert_id();
    }

    function add_page_contact($data) {
        $this->db->table('tbl_page_contact')->insert($data);
        return $this->db->insert_id();
    }

    function add_footer_setting($data) {
        $this->db->table('tbl_footer')->insert($data);
        return $this->db->insert_id();
    }

}