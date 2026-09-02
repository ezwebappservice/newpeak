<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Shop_product extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('shop');
        $this->Model_common = new \App\Models\Admin\Model_common();
        $this->Model_shop_product = new \App\Models\Admin\Model_shop_product();
        $this->Model_shop_parent_category = new \App\Models\Admin\Model_shop_parent_category();
        $this->Model_shop_sub_category = new \App\Models\Admin\Model_shop_sub_category();
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['products'] = $this->Model_shop_product->show();

        echo view('admin/view_header', $data);
        echo view('admin/view_shop_product', $data);
        echo view('admin/view_footer');
    }

    public function add()
    {
        $data['setting'] = $this->Model_common->get_setting_data();
        $data['all_lang'] = $this->Model_common->all_lang();
        $data['parent_categories'] = $this->Model_shop_parent_category->show();
        $data['sub_categories'] = $this->Model_shop_sub_category->show();
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('short_description', 'Short Description', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['featured_image']['name'] ?? '';
            $path_tmp = $_FILES['featured_image']['tmp_name'] ?? '';
            $ext = '';

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if ($this->Model_common->extension_check_photo($ext) == false) {
                    $valid = 0;
                    $error .= 'You must upload jpg, jpeg, gif or png file for featured image<br>';
                }
            } else {
                $valid = 0;
                $error .= 'You must select a featured image<br>';
            }

            if ($valid == 1) {
                $lang_id = (int) $_POST['lang_id'];
                $slug = trim($_POST['product_slug'] ?? '');
                if ($slug == '') {
                    $slug = shop_generate_slug($_POST['product_name']);
                } else {
                    $slug = shop_generate_slug($slug);
                }
                $slug = shop_unique_slug($slug, function ($s) use ($lang_id) {
                    return $this->Model_shop_product->slug_exists($s, $lang_id) > 0;
                });

                $next_id = $this->Model_shop_product->get_auto_increment_id();
                $ai_id = 0;
                foreach ($next_id as $row) {
                    $ai_id = $row['Auto_increment'];
                }

                $final_name = 'shop-product-' . $ai_id . '.' . $ext;
                move_uploaded_to_uploads($path_tmp, $final_name);

                upload_dir('shop_product_photos');

                $form_data = [
                    'product_name'       => $_POST['product_name'],
                    'product_slug'       => $slug,
                    'short_description'  => $_POST['short_description'],
                    'full_description'   => $_POST['full_description'],
                    'price'              => (float) $_POST['price'],
                    'featured_image'     => $final_name,
                    'stock_quantity'     => (int) ($_POST['stock_quantity'] ?? 0),
                    'meta_title'         => $_POST['meta_title'],
                    'meta_keyword'       => $_POST['meta_keyword'],
                    'meta_description'   => $_POST['meta_description'],
                    'status'             => (int) $_POST['status'],
                    'sort_order'         => (int) ($_POST['sort_order'] ?? 0),
                    'lang_id'            => $lang_id,
                    'created_at'         => date('Y-m-d H:i:s'),
                    'updated_at'         => date('Y-m-d H:i:s'),
                ];
                $product_id = $this->Model_shop_product->add($form_data);

                $this->Model_shop_product->save_category_mapping(
                    $product_id,
                    (int) ($_POST['parent_category_id'] ?? 0),
                    (int) ($_POST['sub_category_id'] ?? 0)
                );

                $this->upload_gallery_images($product_id);

                $this->session->setFlashdata('success', 'Product is added successfully!');
                redirect(base_url() . 'admin/shop_product');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/shop_product/add');
        }

        echo view('admin/view_header', $data);
        echo view('admin/view_shop_product_add', $data);
        echo view('admin/view_footer');
    }

    public function edit($id)
    {
        $tot = $this->Model_shop_product->check($id);
        if (!$tot) {
            redirect(base_url() . 'admin/shop_product');
            exit;
        }

        $data['setting'] = $this->Model_common->get_setting_data();
        $data['all_lang'] = $this->Model_common->all_lang();
        $data['parent_categories'] = $this->Model_shop_parent_category->show();
        $data['sub_categories'] = $this->Model_shop_sub_category->show();
        $error = '';

        if (isset($_POST['form1'])) {
            if (PROJECT_MODE == 0) {
                $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $valid = 1;
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('short_description', 'Short Description', 'trim|required');

            if ($this->form_validation->run() == false) {
                $valid = 0;
                $error .= validation_errors();
            }

            $path = $_FILES['featured_image']['name'] ?? '';
            $path_tmp = $_FILES['featured_image']['tmp_name'] ?? '';
            $ext = '';

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if ($this->Model_common->extension_check_photo($ext) == false) {
                    $valid = 0;
                    $error .= 'You must upload jpg, jpeg, gif or png file for featured image<br>';
                }
            }

            if ($valid == 1) {
                $data['product'] = $this->Model_shop_product->getData($id);
                $lang_id = (int) $_POST['lang_id'];
                $slug = trim($_POST['product_slug'] ?? '');
                if ($slug == '') {
                    $slug = shop_generate_slug($_POST['product_name']);
                } else {
                    $slug = shop_generate_slug($slug);
                }
                $slug = shop_unique_slug($slug, function ($s) use ($lang_id, $id) {
                    return $this->Model_shop_product->slug_exists($s, $lang_id, $id) > 0;
                });

                $form_data = [
                    'product_name'       => $_POST['product_name'],
                    'product_slug'       => $slug,
                    'short_description'  => $_POST['short_description'],
                    'full_description'   => $_POST['full_description'],
                    'price'              => (float) $_POST['price'],
                    'stock_quantity'     => (int) ($_POST['stock_quantity'] ?? 0),
                    'meta_title'         => $_POST['meta_title'],
                    'meta_keyword'       => $_POST['meta_keyword'],
                    'meta_description'   => $_POST['meta_description'],
                    'status'             => (int) $_POST['status'],
                    'sort_order'         => (int) ($_POST['sort_order'] ?? 0),
                    'lang_id'            => $lang_id,
                    'updated_at'         => date('Y-m-d H:i:s'),
                ];

                if ($path != '') {
                    if (! empty($data['product']['featured_image'])) {
                        safe_unlink_upload($data['product']['featured_image']);
                    }
                    $final_name = 'shop-product-' . $id . '.' . $ext;
                    move_uploaded_to_uploads($path_tmp, $final_name);
                    $form_data['featured_image'] = $final_name;
                }

                $this->Model_shop_product->update($id, $form_data);
                $this->Model_shop_product->save_category_mapping(
                    $id,
                    (int) ($_POST['parent_category_id'] ?? 0),
                    (int) ($_POST['sub_category_id'] ?? 0)
                );

                $this->upload_gallery_images($id);

                $this->session->setFlashdata('success', 'Product is updated successfully');
                redirect(base_url() . 'admin/shop_product');
            }

            $this->session->setFlashdata('error', $error);
            redirect(base_url() . 'admin/shop_product/edit/' . $id);
        }

        $data['product'] = $this->Model_shop_product->getData($id);
        $data['product_images'] = $this->Model_shop_product->get_images($id);
        $data['category_mapping'] = $this->Model_shop_product->get_category_mapping($id);
        echo view('admin/view_header', $data);
        echo view('admin/view_shop_product_edit', $data);
        echo view('admin/view_footer');
    }

    public function delete($id)
    {
        $tot = $this->Model_shop_product->check($id);
        if (!$tot) {
            redirect(base_url() . 'admin/shop_product');
            exit;
        }

        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $product = $this->Model_shop_product->getData($id);
        if (! empty($product['featured_image'])) {
            safe_unlink_upload($product['featured_image']);
        }

        $images = $this->Model_shop_product->get_images($id);
        foreach ($images as $img) {
            safe_unlink_upload($img['image_name'], 'shop_product_photos');
        }
        $this->Model_shop_product->delete_images_by_product($id);
        $this->Model_shop_product->delete($id);

        $this->session->setFlashdata('success', 'Product is deleted successfully');
        redirect(base_url() . 'admin/shop_product');
    }

    public function delete_image($image_id)
    {
        if (PROJECT_MODE == 0) {
            $this->session->setFlashdata('error', PROJECT_NOTIFICATION);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $image = $this->Model_shop_product->get_image($image_id);
        if ($image) {
            safe_unlink_upload($image['image_name'], 'shop_product_photos');
            $this->Model_shop_product->delete_image($image_id);
            $this->session->setFlashdata('success', 'Gallery image deleted successfully');
            redirect(base_url() . 'admin/shop_product/edit/' . $image['product_id']);
        }

        redirect(base_url() . 'admin/shop_product');
    }

    protected function upload_gallery_images($product_id)
    {
        if (! isset($_FILES['photos']['name']) || ! is_array($_FILES['photos']['name'])) {
            return;
        }

        upload_dir('shop_product_photos');

        $photos = array_values(array_filter($_FILES['photos']['name']));
        $photos_temp = array_values(array_filter($_FILES['photos']['tmp_name']));

        $next_id = $this->Model_shop_product->get_auto_increment_id_image();
        $z = 0;
        foreach ($next_id as $row) {
            $z = $row['Auto_increment'];
        }

        for ($i = 0; $i < count($photos); $i++) {
            $ext = pathinfo($photos[$i], PATHINFO_EXTENSION);
            if ($this->Model_common->extension_check_photo($ext) == false) {
                continue;
            }
            $final_name = 'shop-gallery-' . $z . '.' . $ext;
            move_uploaded_to_uploads($photos_temp[$i], $final_name, 'shop_product_photos');
            $this->Model_shop_product->add_image([
                'product_id' => $product_id,
                'image_name' => $final_name,
                'sort_order' => $i,
            ]);
            $z++;
        }
    }
}
