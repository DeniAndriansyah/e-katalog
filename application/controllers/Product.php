<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            redirect('auth');
        }
        $this->load->model('Base_m');
    }

    public function index()
    {
        $product = $this->Base_m->all_product();
        $data = [
            'title' => 'Product',
            'products' => $product,
        ];

        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/product/index', $data);
        $this->load->view('component/admin/footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Product Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == false) {
            $category = $this->Base_m->all("category");

            $data = [
                'title' => 'Add Product',
                'categories' => $category,
            ];

            // var_dump($data['categories']); die();

            $this->load->view('component/admin/header', $data);
            $this->load->view('component/admin/sidebar');
            $this->load->view('pages/admin/product/add', $data);
            $this->load->view('component/admin/footer');

        } else {
            // tambahkan data produk
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $price = str_replace(['Rp', '.', ','], '', $price); // Menghapus format currency
            $price = (int) $price; // Konversi ke integer
            $status = $this->input->post('status');
            $category = $this->input->post('category');
            $desc = $this->input->post('desc');
            $image = $_FILES['image']['name'];

            if ($image) {
                $config['upload_path'] = './assets/uploads/product/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = '5000';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $image = $this->upload->data('file_name');
                } else {
                    $image = "default.jpg";
                }
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'name' => $name,
                'price' => $price,
                'status' => $status,
                'category_id' => $category,
                'desc' => $desc,
                'image' => $image,
            );
            if (!$this->Base_m->create('product', $data)) {
                $this->session->set_flashdata('error', 'Failed to add product');
                redirect('product/add');
            }

            $this->session->set_flashdata('success', 'Product added successfully');
            redirect('product');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name', 'Product Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == false) {
            $category = $this->Base_m->all("category");
            $product = $this->Base_m->find("product", $id);

            $data = [
                'title' => 'Edit Product',
                'categories' => $category,
                'product' => $product,
            ];

            // var_dump($data['categories']); die();

            $this->load->view('component/admin/header', $data);
            $this->load->view('component/admin/sidebar');
            $this->load->view('pages/admin/product/edit', $data);
            $this->load->view('component/admin/footer');

        } else {
            // EDIT DATA PRODUK
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $price = str_replace(['Rp', '.', ','], '', $price); // Menghapus format currency
            $price = (int) $price; // Konversi ke integer
            $status = $this->input->post('status');
            $category = $this->input->post('category');
            $desc = $this->input->post('desc', true);
            $image = $_FILES['image']['name'];
            $image_old = $this->input->post('image_old');

            // Tetap gunakan gambar lama jika tidak ada gambar baru diunggah
            if (empty($image)) {
                $image = $image_old;
            } else {
                $config['upload_path'] = './assets/uploads/product/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 5000;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    // Dapatkan nama file baru yang diunggah
                    $image = $this->upload->data('file_name');

                    // Hapus gambar lama jika ada
                    if ($image_old && file_exists('./assets/uploads/product/' . $image_old)) {
                        unlink('./assets/uploads/product/' . $image_old);
                    }
                } else {
                    // Jika gagal upload, tetap gunakan gambar lama
                    $image = $image_old;
                }
            }

            $data = array(
                'name' => $name,
                'price' => $price,
                'status' => $status,
                'category_id' => $category,
                'desc' => $desc,
                'image' => $image,
            );

            if (!$this->Base_m->update('product', $data, $id)) {
                $this->session->set_flashdata('error', 'Failed to update product');
                redirect('product/edit/' . $id);
            }

            $this->session->set_flashdata('success', 'Product updated successfully');
            redirect('product');
        }
    }

    public function delete($id)
    {
        $data = $this->Base_m->find('product', $id);
        unlink('./assets/uploads/product/' . $data->image);
        if (!$this->Base_m->delete('product', $id)) {
            $this->session->set_flashdata('error', 'Failed to delete product');
            redirect('product');
        }
        $this->session->set_flashdata('success', 'Product deleted successfully');
        redirect('product');
    }
}
