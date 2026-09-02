<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Shop_parent_category extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('shop');
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_shop_parent_category = new \App\Models\Admin\Model_shop_parent_category();
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['categories'] = $this->Model_shop_parent_category->show();

        echo view('admin/view_header', $data);
        echo view('admin/view_shop_parent_category', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['all_lang'] = $this->Model_common->all_lang();
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['category_image']['name'] ?? '';
            $path_tmp = $_FILES['category_image']['tmp_name'] ?? '';
            $ext = '';

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if ($this->Model_common->extension_check_photo($ext) == false) {
                    $valid = 0;
                    $error .= 'You must upload jpg, jpeg, gif or png file for category image<br>';
                }
            } else {
                $valid = 0;
                $error .= 'You must select a photo for category image<br>';
            }

            if ($valid == 1) {
                $lang_id = (int) $_POST['lang_id'];
                $slug = trim($_POST['category_slug'] ?? '');
                if ($slug == '') {
                    $slug = shop_generate_slug($_POST['category_name']);
                } else {
                    $slug = shop_generate_slug($slug);
                }
                $slug = shop_unique_slug($slug, function ($s) use ($lang_id) {
                    return $this->Model_shop_parent_category->slug_exists($s, $lang_id) > 0;
                });

                $next_id = $this->Model_shop_parent_category->get_auto_increment_id();
                $ai_id = 0;
                foreach ($next_id as $row) {
                    $ai_id = $row['Auto_increment'];
                }

                $final_name = 'shop-parent-cat-' . $ai_id . '.' . $ext;
                move_uploaded_to_uploads($path_tmp, $final_name);

                $form_data = [
                    'category_name'    => $_POST['category_name'],
                    'category_slug'    => $slug,
                    'category_image'   => $final_name,
                    'meta_title'       => $_POST['meta_title'],
                    'meta_keyword'     => $_POST['meta_keyword'],
                    'meta_description' => $_POST['meta_description'],
                    'sort_order'       => (int) ($_POST['sort_order'] ?? 0),
                    'status'           => (int) $_POST['status'],
                    'lang_id'          => $lang_id,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                ];
                $this->Model_shop_parent_category->add($form_data);

                $this->session->setFlashdata('success', 'Parent category is added successfully!');
                redirect(base_url() . 'admin/shop_parent_category');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/shop_parent_category/add');
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_shop_parent_category_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id)
    {
        $tot = $this->Model_shop_parent_category->check($id);
        if (!$tot) {
            redirect(base_url() . 'admin/shop_parent_category');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['all_lang'] = $this->Model_common->all_lang();
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['category_image']['name'] ?? '';
            $path_tmp = $_FILES['category_image']['tmp_name'] ?? '';
            $ext = '';

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if ($this->Model_common->extension_check_photo($ext) == false) {
                    $valid = 0;
                    $error .= 'You must upload jpg, jpeg, gif or png file for category image<br>';
                }
            }

            if ($valid == 1) {
                $data['category'] = $this->Model_shop_parent_category->getData($id);
                $lang_id = (int) $_POST['lang_id'];
                $slug = trim($_POST['category_slug'] ?? '');
                if ($slug == '') {
                    $slug = shop_generate_slug($_POST['category_name']);
                } else {
                    $slug = shop_generate_slug($slug);
                }
                $slug = shop_unique_slug($slug, function ($s) use ($lang_id, $id) {
                    return $this->Model_shop_parent_category->slug_exists($s, $lang_id, $id) > 0;
                });

                $form_data = [
                    'category_name'    => $_POST['category_name'],
                    'category_slug'    => $slug,
                    'meta_title'       => $_POST['meta_title'],
                    'meta_keyword'     => $_POST['meta_keyword'],
                    'meta_description' => $_POST['meta_description'],
                    'sort_order'       => (int) ($_POST['sort_order'] ?? 0),
                    'status'           => (int) $_POST['status'],
                    'lang_id'          => $lang_id,
                    'updated_at'       => date('Y-m-d H:i:s'),
                ];

                if ($path != '') {
                    if (! empty($data['category']['category_image'])) {
                        safe_unlink_upload($data['category']['category_image']);
                    }
                    $final_name = 'shop-parent-cat-' . $id . '.' . $ext;
                    move_uploaded_to_uploads($path_tmp, $final_name);
                    $form_data['category_image'] = $final_name;
                }

                $this->Model_shop_parent_category->update($id, $form_data);
                $this->session->setFlashdata('success', 'Parent category is updated successfully');
                redirect(base_url() . 'admin/shop_parent_category');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/shop_parent_category/edit/' . $id);
        }

        $data['category'] = $this->Model_shop_parent_category->getData($id);
        echo view('admin/view_header', $data);
        echo view('admin/view_shop_parent_category_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id)
    {
        $tot = $this->Model_shop_parent_category->check($id);
        if (!$tot) {
            redirect(base_url() . 'admin/shop_parent_category');
            exit;
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect($_SERVER['HTTP_REFERER']);
        }

        if ($this->Model_shop_parent_category->check_sub_categories($id)) {
            $this->session->setFlashdata('error', 'Parent category cannot be deleted because sub categories exist under it');
            redirect(base_url() . 'admin/shop_parent_category');
        }

        if ($this->Model_shop_parent_category->check_products($id)) {
            $this->session->setFlashdata('error', 'Parent category cannot be deleted because products are assigned to it');
            redirect(base_url() . 'admin/shop_parent_category');
        }

        $category = $this->Model_shop_parent_category->getData($id);
        if (! empty($category['category_image'])) {
            safe_unlink_upload($category['category_image']);
        }

        $this->Model_shop_parent_category->delete($id);
        $this->session->setFlashdata('success', 'Parent category is deleted successfully');
        redirect(base_url() . 'admin/shop_parent_category');
    }
}
