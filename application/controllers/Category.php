<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
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
        $category = $this->Base_m->all("category");

        $data = [
            'title' => 'Category',
            'categories' => $category,
        ];

        // var_dump($data['categories']); die();

        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/category/index', $data);
        $this->load->view('component/admin/footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Category Name', 'required');

        if ($this->form_validation->run() == false) {
            $data = [
                'title' => 'Add Category',
            ];

            // var_dump($data['categories']); die();

            $this->load->view('component/admin/header', $data);
            $this->load->view('component/admin/sidebar');
            $this->load->view('pages/admin/category/add', $data);
            $this->load->view('component/admin/footer');
        } else {
            $i = $this->input;

            $data = [
                'name' => htmlspecialchars($i->post('name')),
            ];
            $this->Base_m->create('category', $data);
            $this->session->set_flashdata('success', 'Saved Is Successfully');
            redirect('category');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('name', 'Category Name', 'required');

        if ($this->form_validation->run() == false) {

            $category = $this->Base_m->find("category", $id);

            $data = [
                'title' => 'Add Category',
                'category' => $category,

            ];

            // var_dump($data['categories']); die();

            $this->load->view('component/admin/header', $data);
            $this->load->view('component/admin/sidebar');
            $this->load->view('pages/admin/category/edit', $data);
            $this->load->view('component/admin/footer');
        } else {
            $i = $this->input;

            $data = [
                'name' => htmlspecialchars($i->post('name')),
            ];
            $this->Base_m->update('category', $data, $id);
            $this->session->set_flashdata('success', 'Updated Is Successfully');
            redirect('category');
        }
    }

    public function delete($id)
    {
        $this->Base_m->delete("category", $id);
        $this->session->set_flashdata('success', 'Deleted Is Successfully');
        redirect('category');
    }
}
